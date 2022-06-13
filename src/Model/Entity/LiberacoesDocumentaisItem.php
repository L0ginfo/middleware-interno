<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ObjectUtil;
use App\Util\ResponseUtil;

/**
 * LiberacoesDocumentaisItem Entity
 *
 * @property int $id
 * @property int $adicao_numero
 * @property float $quantidade_liberada
 * @property int $liberacao_documental_id
 * @property int $regime_aduaneiro_id
 * @property int $estoque_id
 * @property int|null $tabela_preco_id
 *
 * @property \App\Model\Entity\LiberacoesDocumental $liberacoes_documental
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\Estoque $estoque
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 */
class LiberacoesDocumentaisItem extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     *  'adicao_numero' => true,
     *  'quantidade_liberada' => true,
     *  'liberacao_documental_id' => true,
     *  'regime_aduaneiro_id' => true,
     *  'estoque_id' => true,
     *  'tabela_preco_id' => true,
     *  'liberacoes_documental' => true,
     *  'regimes_aduaneiro' => true,
     *  'estoque' => true,
     *  'tabelas_preco' => true
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function saveItens ( $that, $aPost, $iLiberacaoDocID ) 
    {

        $aCanNotDelete = [];
        $oItensTable = LgDbUtil::get('LiberacoesDocumentaisItens');
        foreach ($aPost['lote_liberado']['item'] as $key => $aItem) {
            $aItem['id'] = @$aItem['id']?$aItem['id']:NULL;
            $aItem['tabela_preco_id'] = @$aItem['tabela_preco_id']?:NULL;

            $sLoteItem      = $aItem['lote_item'];
            $oEstoque       = LgDbUtil::get('Estoques')->get($aItem['estoque_id']);
            $fQtdeLiberada  = DoubleUtil::toDBUnformat($aItem['lote_quantidade_liberar']);

            if(empty($oEstoque)){
                return (new ResponseUtil())
                    ->setStatus(400)
                    ->setMessage("Não foi possível salvar todos os itens, criação parou no item: $sLoteItem. Estoque não localizado.");
            }

            if(empty($aItem['id'])) {

                $oResponse = self::create($fQtdeLiberada, $oEstoque, [
                    'adicao_numero'             => @$aPost['quantidade_adicoes'],
                    'regime_aduaneiro_id'       => @$aItem['regime_id'],
                    'tabela_preco_id'           => @$aItem['tabela_preco_id'],
                    'liberacao_documental_id'   => $iLiberacaoDocID,
                ]);

                if($oResponse->getStatus() != 200){
                    return $oResponse;
                }

                continue;
            }
        
            $oItem = $oItensTable->find()->where([
                'id' => $aItem['id']
            ])->first();

            if(empty($oItem)) {
                continue;
            }

            if (!$fQtdeLiberada){

                $oResponse = self::delete($oItem);

                if($oResponse->getStatus() != 200){
                    $aCanNotDelete[] = $oResponse->getMessage();
                }

                continue;
            }

            $oResponse = self::update($fQtdeLiberada, $oItem, $oEstoque, [
                'adicao_numero'             => @$aPost['quantidade_adicoes'],
                'regime_aduaneiro_id'       => @$aItem['regime_id'],
                'tabela_preco_id'           => @$aItem['tabela_preco_id'],
                'liberacao_documental_id'   => $iLiberacaoDocID,
            ]);

            if($oResponse->getStatus() != 200){
                return $oResponse;
            } 
        }

        if(empty($aCanNotDelete)){
            return (new ResponseUtil())
                ->setMessage('Todos os itens foram salvos com sucesso!')
                ->setStatus(200);
        }
        
        return (new ResponseUtil())
            ->setTitle('Ops..')
            ->setStatus(400)
            ->setMessage('Houve problemas ao salvar os itens, pois existem itens vinculados a uma resv, remova o vinculo primeiro: ')
            ->setDataExtra($aCanNotDelete);
    }


    public static function create($fQtdeLiberada, $oEstoque, $aItem){
        $sLoteItem = $oEstoque->lote_codigo;

        if(empty($fQtdeLiberada)) 
            return (new ResponseUtil())->setStatus(200);

        if($oEstoque->qtde_saldo < $fQtdeLiberada) {

            $fLiberado = DoubleUtil::fromDBUnformat($fQtdeLiberada);
            $fEstoque = DoubleUtil::fromDBUnformat($oEstoque->qtde_saldo);

            return (new ResponseUtil())
                ->setStatus(406)
                ->setMessage("Não foi possível salvar todos os itens, criação parou no item: $sLoteItem. Saldo insuficiente, disponível em Estoque ($fEstoque), Liberado ($fLiberado)");
        }

        $aData = ObjectUtil::getAsArray($oEstoque, true);

        $aData += [
            'estoque_id'                => $oEstoque->id,
            'adicao_numero'             => $aItem['adicao_numero'] ?:0,
            'regime_aduaneiro_id'       => $aItem['regime_aduaneiro_id'],
            'tabela_preco_id'           => $aItem['tabela_preco_id'],
            'liberacao_documental_id'   => $aItem['liberacao_documental_id'],
            'quantidade_liberada'       => $fQtdeLiberada,
            'liberacao_por_produto'     => 0
        ];

        unset($aData['id']);
        unset($aData['created_at']);
        unset($aData['updated_at']);

        $oItensTable = LgDbUtil::get('LiberacoesDocumentaisItens');
        $oItem = $oItensTable->newEntity($aData);

        if (!$oItensTable->save($oItem)) {

            return (new ResponseUtil())
                ->setStatus(406)
                ->setMessage("Não foi possível salvar todos os itens, criação parou no item: $sLoteItem." . EntityUtil::dumpErrors($oItem));

        }

        return (new ResponseUtil())->setStatus(200);
    }


    public static function update($fQtdeLiberada, $oItem, $oEstoque, $aItem){
        $sLoteItem = $oEstoque->lote_codigo;

        if(empty($fQtdeLiberada)) 
            return (new ResponseUtil())->setStatus(202);

        $oItensTable = LgDbUtil::get('LiberacoesDocumentaisItens');

        if($fQtdeLiberada == $oItem->quantidade_liberada){

            $oItem = $oItensTable->patchEntity($oItem, [
                'regime_aduaneiro_id'       => @$aItem['regime_aduaneiro_id'],
                'tabela_preco_id'           => @$aItem['tabela_preco_id'],
                'liberacao_por_produto'     => 0
            ]);

            if (!$oItensTable->save($oItem)) {
                return (new ResponseUtil())
                    ->setStatus(406)
                    ->setMessage("Não foi possível salvar todos os itens, criação parou no item: $sLoteItem. ". EntityUtil::dumpErrors($oItem));
                
            }

            return (new ResponseUtil())->setStatus(200);
        }
            
        if($oEstoque->qtde_saldo < $fQtdeLiberada){
            $fLiberado = DoubleUtil::fromDBUnformat($fQtdeLiberada);
            $fEstoque = DoubleUtil::fromDBUnformat($oEstoque->qtde_saldo);

            return (new ResponseUtil())
                ->setStatus(406)
                ->setMessage("Não foi possível salvar todos os itens, criação parou no item: $sLoteItem. Saldo insuficiente, disponível em Estoque ($fEstoque), Liberado ($fLiberado)");
        }

        $aData = ObjectUtil::getAsArray($oEstoque, true);

        unset($aData['id']);
        unset($aData['created_at']);
        unset($aData['updated_at']);

        $aData += [
            'estoque_id'                => $oEstoque->id,
            'regime_aduaneiro_id'       => @$aItem['regime_aduaneiro_id'],
            'tabela_preco_id'           => @$aItem['tabela_preco_id'],
            'quantidade_liberada'       => $fQtdeLiberada,
            'liberacao_por_produto'     => 0
        ];

        $oItem = $oItensTable->patchEntity($oItem, $aData);
        
        if (!$oItensTable->save($oItem)) {
            return (new ResponseUtil())
            ->setStatus(406)
            ->setMessage("Não foi possível salvar todos os itens, criação parou no item: $sLoteItem." . EntityUtil::dumpErrors($oItem));
        }

        return (new ResponseUtil())->setStatus(200);
    }

    public static function delete($oItem){

        $sLote = $oItem->lote_codigo .' - ' . $oItem->lote_item;
        $sLote = $sLote ? " / Lote $sLote" : '';

        $oExiste = LgDbUtil::getFirst('ResvLiberacaoDocumentalItens', [
            'liberacao_documental_item_id' => $oItem->id
        ]);

        if($oExiste){
            return (new ResponseUtil())->setMessage('Id '. $oItem->id . $sLote);
        }

        try {

            if(LgDbUtil::get('LiberacoesDocumentaisItens')->delete($oItem)){
                return (new ResponseUtil())->setStatus(200);
            }

            return (new ResponseUtil())
                ->setMessage('Id '. $oItem->id . $sLote);

        } catch (\Throwable $th) {
            return (new ResponseUtil())
                ->setStatus(500)
                ->setMessage('Id '. $oItem->id . $sLote);
        }
    }
}
