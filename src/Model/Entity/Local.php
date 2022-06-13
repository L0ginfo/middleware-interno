<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Local Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $ativo
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Area[] $areas
 */
class Local extends Entity
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
        'ativo' => true,
        'empresa_id' => true,
        'empresa' => true,
        'areas' => true
    ];

    public static function getLocais()
    {
        return LgDbUtil::getAll('Locais', [
            'ativo' => 1
        ]);
    }

    public static function getList()
    {
        $aLocais = self::getLocais();
        $aList = [];

        foreach ($aLocais as $oLocal) {
            $aList[ $oLocal->id ] = $oLocal->descricao;
        }

        return $aList;
    }
}
