<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\EntityUtil;
use App\Util\DoubleUtil;
use App\Util\UniversalCodigoUtil;
use Cake\I18n\Number;
use Cake\ORM\TableRegistry;

/**
 * DocumentosMercadoriasItem Entity
 *
 * @property int $id
 * @property int $sequencia_item
 * @property string $descricao
 * @property float|null $quantidade
 * @property float|null $peso_liquido
 * @property float|null $peso_bruto
 * @property float|null $valor_unitario
 * @property float|null $valor_total
 * @property float|null $valor_frete_total
 * @property float|null $valor_seguro_total
 * @property float|null $temperatura
 * @property int $produto_id
 * @property int $documentos_mercadoria_id
 * @property int $unidade_medida_id
 *
 * @property \App\Model\Entity\Produto $produto
 * @property \App\Model\Entity\DocumentosMercadoria $documentos_mercadoria
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 */
class DocumentosMercadoriasItem extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function saveOrIncrementItem( $that, $aData )
    {
        $bIncrementaDocMercItem = ($x = ParametroGeral::getParametro($that, 'DESCARGA_INCREMENTA_DOC_MERC_ITEM')) ? (int) $x->valor : 0;
        $bExibeCampoProduto = ($x = ParametroGeral::getParametro($that, 'DESCARGA_EXIBE_CAMPO_PRODUTO')) ? (int) $x->valor : 0;
        $aQueryExtra = [];

        if (!$bIncrementaDocMercItem)
            return $this->getDocMercItem($that, $aData);

        if ($bExibeCampoProduto)
            $aQueryExtra = [
                'produto_id' => $aData['produto_id'],
                // 'lote'       => $aData['lote'],
                // 'serie'      => $aData['serie'],
                // 'validade'   => $aData['validade'],
            ];

        $oDocumentosMercadoriasItem = $that->DocumentosMercadoriasItens->find()
            ->where([
                'unidade_medida_id' => $aData['unidade_medida_id'],
                'documentos_mercadoria_id' => $aData['documentos_mercadoria_id']
            ] + $aQueryExtra)
            ->first();

        $aData['quantidade']  = DoubleUtil::toDBUnformat($aData['quantidade']);
        $aData['peso_bruto']  = DoubleUtil::toDBUnformat($aData['peso_bruto']);
        $aData['temperatura'] = DoubleUtil::toDBUnformat($aData['temperatura']);

        if (!$oDocumentosMercadoriasItem)
            return $this->saveMercadoriaItem( $that, $aData );

        return $this->incrementMercadoriaItem( $that, $aData, $oDocumentosMercadoriasItem );
    }

    public function getDocMercItem($that, $aData)
    {
        $oDocumentosMercadoriasItem = $that->DocumentosMercadoriasItens->find()
            ->where([
                'unidade_medida_id' => $aData['unidade_medida_id'],
                'documentos_mercadoria_id' => $aData['documentos_mercadoria_id'],
                'produto_id' => $aData['produto_id']
            ])
            ->first();

        if (!$aData['unidade_medida_id'])
            return [
                'message' => 'Não foi possível capturar a unidade de medida! ' . EntityUtil::dumpErrors($oDocumentosMercadoriasItem),
                'status' => 406
            ];

        if (!$oDocumentosMercadoriasItem)
            return [
                'message' => 'Não foi possível capturar o Item do documento de mercadoria! ' . EntityUtil::dumpErrors($oDocumentosMercadoriasItem),
                'status' => 406
            ];

        $oDocumentosMercadoriasItem->temperatura = DoubleUtil::toDBUnformat($aData['temperatura']);

        $that->DocumentosMercadoriasItens->save($oDocumentosMercadoriasItem);

        if (!$oDocumentosMercadoriasItem)
            return [
                'message' => 'Houve algum problema ao buscar Mercadoria Item! ' . EntityUtil::dumpErrors($oDocumentosMercadoriasItem),
                'status' => 406
            ];

        return [
            'message'   => 'OK',
            'status'    => 200,
            'dataExtra' => [
                'id'                      => $oDocumentosMercadoriasItem->id,
                'documento_mercadoria_id' => $oDocumentosMercadoriasItem->documentos_mercadoria_id,
                'sequencia_item'          => $oDocumentosMercadoriasItem->sequencia_item
            ]
        ];
    }

    public function incrementMercadoriaItem( $that, $aData, $oDocumentosMercadoriasItem )
    {
        if ($aData['descricao'] != '') {
            $oDocumentosMercadoriasItem->descricao = $oDocumentosMercadoriasItem->descricao . ' <br> ' . $aData['descricao'];
        }

        if (isset($aData['etiqueta_produto_id'])) {
            $oEtiquetaProduto = $that->EtiquetaProdutos->get($aData['etiqueta_produto_id']);

            //valida se adicionou ou removeu quantidade, se sim, debita ou incrementa
            if ($oEtiquetaProduto->qtde > $aData['quantidade'])
                $oDocumentosMercadoriasItem->quantidade -= $oEtiquetaProduto->qtde - $aData['quantidade'];
            elseif ($oEtiquetaProduto->qtde < $aData['quantidade'])
                $oDocumentosMercadoriasItem->quantidade += $aData['quantidade'] - $oEtiquetaProduto->qtde;
            elseif (!$oDocumentosMercadoriasItem->quantidade)
                $oDocumentosMercadoriasItem->quantidade = $aData['quantidade'];

            //valida se adicionou ou removeu peso_bruto, se sim, debita ou incrementa
            if ($oEtiquetaProduto->peso > $aData['peso_bruto'])
                $oDocumentosMercadoriasItem->peso_bruto -= $oEtiquetaProduto->peso - $aData['peso_bruto'];
            elseif ($oEtiquetaProduto->peso < $aData['peso_bruto'])
                $oDocumentosMercadoriasItem->peso_bruto += $aData['peso_bruto'] - $oEtiquetaProduto->peso;
            elseif (!$oDocumentosMercadoriasItem->peso_bruto)
                $oDocumentosMercadoriasItem->peso_bruto = $aData['peso_bruto'];

        }else {
            $oDocumentosMercadoriasItem->quantidade += $aData['quantidade'];
            $oDocumentosMercadoriasItem->peso_bruto += $aData['peso_bruto'];
        }

        if ($result = $that->DocumentosMercadoriasItens->save($oDocumentosMercadoriasItem))
            return [
                'message' => 'OK',
                'status' => 200,
                'dataExtra' => [
                    'id'                      => $result->id,
                    'documento_mercadoria_id' => $result->documentos_mercadoria_id,
                    'sequencia_item'          => $result->sequencia_item
                ]
            ];

        return [
            'message' => 'Houve algum problema ao incrementar Mercadoria Item! ' . EntityUtil::dumpErrors($oDocumentosMercadoriasItem),
            'status' => 406
        ];
    }

    private function saveMercadoriaItem( $that, $aData )
    {
        $oDocumentosMercadoriasItens = $that->DocumentosMercadoriasItens->newEntity();

        $oLastSecMercItem = $that->DocumentosMercadoriasItens->find()
            ->where([
                'documentos_mercadoria_id' => $aData['documentos_mercadoria_id']
            ])
            ->order('id', 'DESC')
            ->first();

        $iLastSecMercItem = isset($oLastSecMercItem->sequencia_item) ? $oLastSecMercItem->sequencia_item + 1 : 1;
        $aData['sequencia_item'] = $iLastSecMercItem;

        $oDocumentosMercadoriasItens = $that->DocumentosMercadoriasItens->patchEntity($oDocumentosMercadoriasItens, $aData);

        if ($result = $that->DocumentosMercadoriasItens->save($oDocumentosMercadoriasItens))
            return [
                'message'   => 'OK',
                'status'    => 200,
                'dataExtra' => [
                    'id'                      => $result->id,
                    'documento_mercadoria_id' => $result->documentos_mercadoria_id,
                    'sequencia_item'          => $result->sequencia_item
                ]
            ];

        return [
            'message' => 'Houve algum problema ao salvar Mercadoria Item! ' . EntityUtil::dumpErrors($oDocumentosMercadoriasItens),
            'status' => 406
        ];
    }

    public static function getItensDescarga($aItensDescarregados, $iTransporteID)
    {
        $aDocMercItensDescarregados = [];

        foreach ($aItensDescarregados as $aDocumentosMercadoriasAgroup) {
            foreach ($aDocumentosMercadoriasAgroup as $oEtiquetaProduto) {
                $iItemID = $oEtiquetaProduto->documento_mercadoria_item_id;
                $iDocMercID = $oEtiquetaProduto->documentos_mercadorias_item->documentos_mercadoria_id;
                $key = '_' . $iDocMercID . '__' . $iItemID . '_';
                if (!array_key_exists($key, $aDocMercItensDescarregados) && $iItemID)
                    $aDocMercItensDescarregados[$key] = $key;
            }
        }

        $aDocumentosMercadoriasItens = TableRegistry::get('DocumentosMercadoriasItens')->find()
            ->contain(['DocumentosMercadorias', 'Produtos'])
            ->where([
                'DocumentosMercadorias.documento_transporte_id' => $iTransporteID
            ])
            ->toArray();

        foreach ($aDocumentosMercadoriasItens as $iDocItemID => $oDocumentosMercadoriasItem) {
            $iDocMercID = $oDocumentosMercadoriasItem->documentos_mercadoria_id;
            $keyDocMerc = '_' . $iDocMercID . '__';
            $keyItem = $oDocumentosMercadoriasItem->id . '_';

            if (array_key_exists($keyDocMerc . $keyItem, $aDocMercItensDescarregados))
                continue;

            $aData = json_decode(json_encode([
                'id' => null,
                'unidade_medida_id' => $oDocumentosMercadoriasItem->unidade_medida_id,
                'house_desconsolidacao' => '',
                'qtde' => 0,
                'peso' => 0,
                'documentos_mercadorias_item' => [
                    'temperatura' => 0,
                    'descricao'=> '',
                    'produto' => $oDocumentosMercadoriasItem->produto,
                ],
                'endereco' => [
                    'id' => 0,
                    'area' => [
                        'local' => [
                            'id' => 0
                        ]
                    ]
                ],
                'termo_avarias' => []
            ]));

            if (array_key_exists($iDocMercID, $aItensDescarregados)) {
                $iCountKey = count($aItensDescarregados[$iDocMercID]);
                $aItensDescarregados[$iDocMercID][$iCountKey] = $aData;
            }else {
                $aItensDescarregados[$iDocMercID][] = $aData;
            }
        }

        return $aItensDescarregados;
    }

    public static function getQuantidadeFromId ($iDocumentosMercadoriaItemID)
    {
        $entityDocumentosMercadoriaItem = TableRegistry::getTableLocator()->get('DocumentosMercadoriasItens');
        $oDocumentoMercadoriaItem = $entityDocumentosMercadoriaItem->find()->select(['quantidade'])->where(['id' => $iDocumentosMercadoriaItemID])->first();
        return $oDocumentoMercadoriaItem->quantidade;
    }

}
