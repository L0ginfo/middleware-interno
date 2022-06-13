<?php
namespace App\Model\Entity;

use App\Util\ArrayUtil;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * FormacaoCargaNfPedido Entity
 *
 * @property int $id
 * @property int|null $formacao_carga_id
 * @property string|null $numero_nf
 * @property int $separacao_carga_id
 *
 * @property \App\Model\Entity\FormacaoCarga $formacao_carga
 */
class FormacaoCargaNfPedido extends Entity
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
        
        'formacao_carga_id' => true,
        'numero_nf' => true,
        'separacao_carga_id' => true,
        'formacao_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function setPedidoByVolumeItem($oFormacaoCargaVolumeItem)
    {
        $iFormacaoCargaID = TableRegistry::getTableLocator()->get('FormacaoCargaVolumes')
            ->get($oFormacaoCargaVolumeItem->formacao_carga_volume_id)
            ->formacao_carga_id;

        $iSeparacaoCargaID = TableRegistry::getTableLocator()->get('OrdemServicoItemSeparacoes')
            ->get($oFormacaoCargaVolumeItem->ordem_servico_item_separacao_id, [
                'contain' => ['SeparacaoCargaItens']
            ])
            ->separacao_carga_item
            ->separacao_carga_id;

        $oSeparacaoCarga = LgDbUtil::getByID('SeparacaoCargas', $iSeparacaoCargaID);

        $aNotaFiscal = $oSeparacaoCarga->retorno_nota_integracao
            ? @json_decode($oSeparacaoCarga->retorno_nota_integracao, true)
            : [];

        $oFormacaoCargaNfPedido = LgDbUtil::getFind('FormacaoCargaNfPedidos')
            ->where([
                'formacao_carga_id' => $iFormacaoCargaID,
                'separacao_carga_id' => $iSeparacaoCargaID,
            ])
            ->first();

        $sNotaFiscal = $oSeparacaoCarga->nota_fiscal ?: ArrayUtil::get($aNotaFiscal, 'numero');

        if ($oFormacaoCargaNfPedido) {
            $oFormacaoCargaNfPedido->numero_nf = $sNotaFiscal;
            !$oFormacaoCargaNfPedido->numero_nf ?: LgDbUtil::save('FormacaoCargaNfPedidos', $oFormacaoCargaNfPedido);

            return;
        }

        $oFormacaoCargaNfPedido = TableRegistry::getTableLocator()->get('FormacaoCargaNfPedidos')
            ->newEntity([
                'formacao_carga_id'  => $iFormacaoCargaID,
                'separacao_carga_id' => $iSeparacaoCargaID,
                'numero_nf'          => $sNotaFiscal
            ]);

        TableRegistry::getTableLocator()->get('FormacaoCargaNfPedidos')->save($oFormacaoCargaNfPedido);
    }

    public static function removePedidoByVolumeItem($oFormacaoCargaVolumeItem)
    {
        $iFormacaoCargaID = TableRegistry::getTableLocator()->get('FormacaoCargaVolumes')
            ->get($oFormacaoCargaVolumeItem->formacao_carga_volume_id)
            ->formacao_carga_id;

        $iSeparacaoCargaID = TableRegistry::getTableLocator()->get('OrdemServicoItemSeparacoes')
            ->get($oFormacaoCargaVolumeItem->ordem_servico_item_separacao_id, [
                'contain' => ['SeparacaoCargaItens']
            ])
            ->separacao_carga_item
            ->separacao_carga_id;

        $oFormacaoCargaNfPedido = TableRegistry::getTableLocator()->get('FormacaoCargaNfPedidos')->find()
            ->where([
                'formacao_carga_id' => $iFormacaoCargaID,
                'separacao_carga_id' => $iSeparacaoCargaID,
            ])
            ->first();
        
        $aFormacaoCargaVolumeItens = TableRegistry::getTableLocator()->get('FormacaoCargaVolumeItens')->find()
            ->contain(['OrdemServicoItemSeparacoes' => ['SeparacaoCargaItens']])
            ->where(['SeparacaoCargaItens.separacao_carga_id' => $iSeparacaoCargaID])
            ->toArray();

        if (!$oFormacaoCargaNfPedido || $aFormacaoCargaVolumeItens)
            return;

        TableRegistry::getTableLocator()->get('FormacaoCargaNfPedidos')->delete($oFormacaoCargaNfPedido);
    }
}
