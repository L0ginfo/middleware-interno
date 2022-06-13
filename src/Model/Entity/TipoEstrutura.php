<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TipoEstrutura Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $composicao1
 * @property string $composicao2
 * @property string|null $composicao3
 * @property string|null $composicao4
 * @property int $ativo
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Area[] $areas
 */
class TipoEstrutura extends Entity
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
        'composicao1' => true,
        'composicao2' => true,
        'composicao3' => true,
        'composicao4' => true,
        'ativo' => true,
        'empresa_id' => true,
        'empresa' => true,
        'areas' => true
    ];

    public static function getComposicao($oTipoEstrutura, $oArea = null)
    {
        $aTipoEstruturas = [];
        $sPrefixo = $oArea ? $oArea->descricao . ' ~ ' : '';

        for ($i=1; $i <= 4; $i++) {
            $property = 'composicao' . $i;
            if (isset($oTipoEstrutura->{$property}) && $oTipoEstrutura->{$property} != '') {
                $aTipoEstruturas[] = $oTipoEstrutura->{$property};
            }
        }

        return $sPrefixo . implode(' > ', $aTipoEstruturas);
    }
}
