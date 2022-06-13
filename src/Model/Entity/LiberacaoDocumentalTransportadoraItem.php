<?php
namespace App\Model\Entity;

use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use PhpParser\Node\Expr\Cast\Double;

/**
 * LiberacaoDocumentalTransportadoraItem Entity
 *
 * @property int $id
 * @property float|null $quantidade_liberada
 * @property int $liberacao_documental_transportadora_id
 * @property int $liberacao_documental_item_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\LiberacaoDocumentalTransportadora $liberacao_documental_transportadora
 * @property \App\Model\Entity\LiberacaoDocumentalItem $liberacao_documental_item
 * @property \App\Model\Entity\Motorista $motorista
 * @property \App\Model\Entity\Veiculo $veiculo
 */
class LiberacaoDocumentalTransportadoraItem extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
     /* Default fields
        
        'quantidade_liberada' => true,
        'liberacao_documental_transportadora_id' => true,
        'liberacao_documental_item_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'liberacao_documental_transportadora' => true,
        'liberacao_documental_item' => true,
        'motorista' => true,
        'veiculo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function changeQtde($oThat)
    {
        $oResponse = new ResponseUtil;
        $aButtonClicked = $oThat->request->getData('alterar_quantidade_item');
        $aTransportadoraItens = $oThat->request->getData('item');

        if (!$aButtonClicked)
            return $oResponse->setStatus(200);
        
        $iTransportadoraItemID = array_keys($aButtonClicked)[0];
        $dQtdeAlterada = DoubleUtil::toDBUnformat($aTransportadoraItens[$iTransportadoraItemID]);
        
        if (!$dQtdeAlterada)
            return $oResponse->setStatus(200);

        $oTransportadoraItem = LgDbUtil::getByID('LiberacaoDocumentalTransportadoraItens', $iTransportadoraItemID);

        $oResponseCanChange = self::canChange($oTransportadoraItem, $dQtdeAlterada);

        if ($oResponseCanChange->getStatus() != 200) 
            return $oResponseCanChange;

        $oTransportadoraItem->quantidade_liberada = $dQtdeAlterada;

        LgDbUtil::save('LiberacaoDocumentalTransportadoraItens', $oTransportadoraItem);

        return $oResponse->setStatus(200);
    }

    private static function canChange($oTransportadoraItem, $dQtdeAlterada)
    {
        $oResponse = new ResponseUtil;

        $oLiberacaoTransportadoraReferente = LgDbUtil::getByID('LiberacaoDocumentalTransportadoras', $oTransportadoraItem->liberacao_documental_transportadora_id);
        $oLiberacaoDocumentalItem = LgDbUtil::getByID('LiberacoesDocumentaisItens', $oTransportadoraItem->liberacao_documental_item_id);
        $aLiberacaoTransportadoras = LgDbUtil::getFind('LiberacaoDocumentalTransportadoras')->contain([
            'LiberacaoDocumentalTransportadoraItens'
        ])->where([
            'liberacao_documental_id' => $oLiberacaoTransportadoraReferente->liberacao_documental_id,
            'id <>' => $oLiberacaoTransportadoraReferente->id
        ])->toArray();

        $dQtdeLiberadaTransporadoras = 0.00;
        $dQtdeDocumentalLiberada = $oLiberacaoDocumentalItem->quantidade_liberada;
        
        foreach ($aLiberacaoTransportadoras as $oLiberacaoTransportadora) {
            foreach ($oLiberacaoTransportadora->liberacao_documental_transportadora_itens as $oTransportadoraItem) {

                $aResvs = LiberacaoDocumentalTransportadora::getCarregamentoPorVeiculos($oLiberacaoTransportadora->id);

                $dTotalUtilizado = array_reduce($aResvs, function($dCarry, $oResv) {

                    if ($oResv->peso_carga)
                        $dCarry += $oResv->peso_carga / 1000;
                    elseif ($oResv->peso_liquido)
                        $dCarry += $oResv->peso_liquido;
                    else 
                        $dCarry += $oResv->peso_estimado_carga;

                    return $dCarry;
                }, 0.0);

                if (date('YmdHis') <= $oLiberacaoTransportadora->data_fim_retirada->format('YmdHis')) {

                    if ($dTotalUtilizado >= $oTransportadoraItem->quantidade_liberada)
                        $dQtdeLiberadaTransporadoras += $dTotalUtilizado;
                    else
                        $dQtdeLiberadaTransporadoras += $oTransportadoraItem->quantidade_liberada;
                } elseif ($dTotalUtilizado) {

                    $dQtdeLiberadaTransporadoras += $dTotalUtilizado;
                }
            }
        }

        // dd($dQtdeLiberadaTransporadoras);

        if ($dQtdeLiberadaTransporadoras + $dQtdeAlterada > $dQtdeDocumentalLiberada)
            return $oResponse->setMessage('Não é possível liberar <b>'
                . DoubleUtil::fromDBUnformat($dQtdeAlterada).'</b>, pois somando com as liberações por transportadora (<b>'. DoubleUtil::fromDBUnformat($dQtdeLiberadaTransporadoras) 
                .'</b>) é maior do que a quantidade documental liberada: <b>'
                . DoubleUtil::fromDBUnformat($dQtdeDocumentalLiberada) . '</b>');

        return $oResponse->setStatus(200);
    }

    public static function getAndSaveAll($iLiberacaoID, $iLiberacaoTransportadoraID)
    {
        if (!$iLiberacaoID)
            return;

        $aLiberacaoItens = LgDbUtil::getAll('LiberacoesDocumentaisItens', [
            'liberacao_documental_id' => $iLiberacaoID
        ]);

        foreach ($aLiberacaoItens as $oLiberacaoItem) {
            if (LgDbUtil::getFirst('LiberacaoDocumentalTransportadoraItens', [
                'liberacao_documental_transportadora_id' => $iLiberacaoTransportadoraID,
                'liberacao_documental_item_id'           => $oLiberacaoItem->id
            ]))
                continue;

            LgDbUtil::saveNew('LiberacaoDocumentalTransportadoraItens', [
                'liberacao_documental_transportadora_id' => $iLiberacaoTransportadoraID,
                'liberacao_documental_item_id'           => $oLiberacaoItem->id,
                'quantidade_liberada'                    => 0
            ]);
        }
    }
}
