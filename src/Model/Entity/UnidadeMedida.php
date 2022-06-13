<?php
namespace App\Model\Entity;

use Cake\Http\Session;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * UnidadeMedida Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\EstoqueEndereco[] $estoque_enderecos
 * @property \App\Model\Entity\Estoque[] $estoques
 * @property \App\Model\Entity\EtiquetaProduto[] $etiqueta_produtos
 * @property \App\Model\Entity\Produto[] $produtos
 */
class UnidadeMedida extends Entity
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
        'descricao' => true,
        'codigo' => true,
        'empresa_id' => true,
        'empresa' => true,
        'estoque_enderecos' => true,
        'estoques' => true,
        'etiqueta_produtos' => true,
        'produtos' => true
    ];

    public static function getUnidadeMedidaByCodigo($sCodigo)
    {
        $oUnidadeMedida = TableRegistry::get('UnidadeMedidas')->find()
            ->where([
                'codigo' => $sCodigo
            ])->first();

        if ($oUnidadeMedida)
            return $oUnidadeMedida->id;

        $oUnidadeMedida = TableRegistry::get('UnidadeMedidas')->newEntity([
            'descricao'  => $sCodigo,
            'codigo'     => $sCodigo,
            'empresa_id' => Empresa::getEmpresaPadrao()
        ]);

        return TableRegistry::get('UnidadeMedidas')->save($oUnidadeMedida)->id;
    }

    public static function getByDescricao($sDescricao)
    {
        $oTable = TableRegistry::get('UnidadeMedidas');
        $oData = $oTable->find()->where(['descricao' => $sDescricao])->first();

        if ($oData)
            return $oData->id;

        $oData = $oTable->newEntity([
            'descricao'  => $sDescricao,
            'codigo'     => $sDescricao,
            'empresa_id' => Empresa::getEmpresaPadrao()
        ]);
        $oTable->save($oData);

        return $oData->id;
    }
}
