<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Area Entity
 *
 * @property int $id
 * @property string $descricao
 * @property float $comprimento
 * @property float $altura
 * @property float $largura
 * @property float $m2
 * @property float $m3
 * @property int $ativo
 * @property int $empresa_id
 * @property int $local_id
 * @property int $funcionalidade_id
 * @property int $tipo_estrutura_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Local $local
 * @property \App\Model\Entity\Funcionalidade $funcionalidade
 * @property \App\Model\Entity\TipoEstrutura $tipo_estrutura
 * @property \App\Model\Entity\Endereco[] $enderecos
 */
class Area extends Entity
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
        'comprimento' => true,
        'altura' => true,
        'largura' => true,
        'm2' => true,
        'm3' => true,
        'ativo' => true,
        'empresa_id' => true,
        'local_id' => true,
        'funcionalidade_id' => true,
        'tipo_estrutura_id' => true,
        'empresa' => true,
        'local' => true,
        'funcionalidade' => true,
        'tipo_estrutura' => true,
        'enderecos' => true
    ];

    public static function getAreas($iAreaID = null)
    {
        $aConditions = [];

        if ($iAreaID) {
            $aConditions['area_id'] = $iAreaID;
        }

        return TableRegistry::get('Areas')->find()
            ->where([
                'ativo' => 1
            ] + $aConditions)
            ->toArray();
    }

    public static function getList($iAreaID = null)
    {
        $aAreas = self::getAreas($iAreaID);
        $aList = [];

        foreach ($aAreas as $oArea) {
            $aList[ $oArea->id ] = $oArea->descricao;
        }

        return $aList;
    }
}
