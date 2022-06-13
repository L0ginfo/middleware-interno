<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Procedencia Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $sigla
 * @property int $is_internacional
 * @property int $pais_id
 * @property int $modal_id
 */
class Procedencia extends Entity
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

    public function getProcViaMantra( $that, $sProc, $iPosicao )
    {
        $sProc = explode('/', $sProc)[$iPosicao];

        $oProcedencia = $that->Procedencias->find()
            ->where([
                'sigla' => $sProc
            ])
            ->first();

        if (!$oProcedencia) {
            $aData = [
                'nome' => $sProc,
                'sigla' => $sProc,
                'is_internacional' => 0,
                'pais_id' => 1,
                'modal_id' => 1
            ];
            $oProcedencia = $that->Procedencias->newEntity($aData);
            $oProcedencia = $that->Procedencias->save($oProcedencia);
        }

        return $oProcedencia->id;
    }
}
