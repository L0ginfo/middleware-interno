<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * ProdutoClassificacao Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\Produto[] $produtos
 */
class ProdutoClassificacao extends Entity
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
        'produtos' => true,
        'granel' => true,
        'codigo' => true,
    ];

    public static function getByDescricao($sDescricao)
    {
        $oTable = TableRegistry::get('ProdutoClassificacoes');
        $oData = $oTable->find()->where(['descricao' => $sDescricao])->first();

        if ($oData)
            return $oData->id;

        $oData = $oTable->newEntity(['descricao'  => $sDescricao]);
        $oTable->save($oData);
        $oData->codigo = $oData->id;
        $oTable->save($oData);

        return $oData->id;
    }
}
