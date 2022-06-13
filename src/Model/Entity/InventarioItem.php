<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventarioItem Entity
 *
 * @property int $id
 * @property int $inventario_id
 * @property int $endereco_id
 * @property int $etiqueta_produto_id
 * @property float $quantidade_lida
 * @property int $operador_id
 *
 * @property \App\Model\Entity\Inventario $inventario
 * @property \App\Model\Entity\Endereco $endereco
 * @property \App\Model\Entity\EtiquetaProduto $etiqueta_produto
 * @property \App\Model\Entity\Operadore $operadore
 */
class InventarioItem extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    public static function saveInventarioItens($that, $dataPost, $iInventarioId)
    {
        $aEnderecos = self::getEnderecos($that, $dataPost);

        if ($aEnderecos) {
            foreach ($aEnderecos as $key => $value) {

                $bGetEnderecoExistente = self::getEnderecoExistente($that, $iInventarioId, $key);
                if (!$bGetEnderecoExistente) {
                    $oItem = $that->InventarioItens->newEntity();
                    $oItem->inventario_id       = $iInventarioId;
                    $oItem->endereco_id         = $key;
                    $oItem->usuario_id          = (int)$dataPost['usuario_id'];
                    $that->InventarioItens->save($oItem);
                }
            }

            return true;
        }

        return false;        
    }

    private static function getEnderecos ($that, $dataPost)
    {
        $aEnderecos = $that->Enderecos->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->where([
                isset($dataPost['composicao1']['de'])  ? 'cod_composicao1 >= ' . (int)$dataPost['composicao1']['de']  : '',
                isset($dataPost['composicao1']['ate']) ? 'cod_composicao1 <= ' . (int)$dataPost['composicao1']['ate'] : '',
                isset($dataPost['composicao2']['de'])  ? 'cod_composicao2 >= ' . (int)$dataPost['composicao2']['de']  : '',
                isset($dataPost['composicao2']['ate']) ? 'cod_composicao2 <= ' . (int)$dataPost['composicao2']['ate'] : '',
                isset($dataPost['composicao3']['de'])  ? 'cod_composicao3 >= ' . (int)$dataPost['composicao3']['de']  : '',
                isset($dataPost['composicao3']['ate']) ? 'cod_composicao3 <= ' . (int)$dataPost['composicao3']['ate'] : '',
                isset($dataPost['composicao4']['de'])  ? 'cod_composicao4 >= ' . (int)$dataPost['composicao4']['de']  : '',
                isset($dataPost['composicao4']['ate']) ? 'cod_composicao4 <= ' . (int)$dataPost['composicao4']['ate'] : '',
                'area_id' => $dataPost['area_id']
            ])->toArray();

        return $aEnderecos;
    }

    private static function getEnderecoExistente ($that, $iInventarioId, $iEnderecoId)
    {
        $oItem = $that->InventarioItens->find('all')->where(['inventario_id' => $iInventarioId, 'endereco_id' => $iEnderecoId])->first();

        if ($oItem) {
            return true;
        }
        return false;
    }

    public static function getIdsEnderecosInventario ($aInventarioItens)
    {
        $aIdsInventarioItens = [];
        foreach ($aInventarioItens as $item) {
            $aIdsInventarioItens[] = $item->endereco_id;
        }

        return $aIdsInventarioItens;
    }
}
