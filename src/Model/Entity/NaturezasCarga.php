<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NaturezasCarga Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 */
class NaturezasCarga extends Entity
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
        'id' => false,
        '*' => true
    ];

    public function getNaturezaViaMantra( $that, $sNatureza ) 
    {
        if ($sNatureza == 'ATT') 
            $sNatureza = 'NOR';

        $oNatureza = $that->NaturezasCargas->find()
            ->where([
                'codigo' => $sNatureza
            ])
            ->first();

        if (!$oNatureza && $sNatureza) { 
            $aData = [
                'descricao' => $sNatureza,
                'codigo' => $sNatureza
            ];
            $oNatureza = $that->NaturezasCargas->newEntity($aData);
            $oNatureza = $that->NaturezasCargas->save($oNatureza);
        }else {
            $oNatureza = $that->NaturezasCargas->find()
                ->where([
                    'codigo' => 'NOR'
                ])
                ->first();
        }
        
        return $oNatureza->id;
    }
}
