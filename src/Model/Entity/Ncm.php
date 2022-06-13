<?php
namespace App\Model\Entity;

use Cake\Http\Session;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Ncm Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Produto[] $produtos
 */
class Ncm extends Entity
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
        'produtos' => true,
    ];

    public static function getNcmByCodigo($sCodigo)
    {
        $oNcm = TableRegistry::get('Ncms')->find()
            ->where([
                'codigo' => $sCodigo
            ])->first();

        if ($oNcm)
            return $oNcm->id;

        $oNcm = TableRegistry::get('Ncms')->newEntity([
            'descricao'  => $sCodigo,
            'codigo'     => $sCodigo,
            'empresa_id' => Empresa::getEmpresaPadrao()
        ]);

        return TableRegistry::get('Ncms')->save($oNcm)->id;
    }

    public static function getByDescricao($sDescricao)
    {
        $oTable = TableRegistry::get('Ncms');
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
