<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pendencia Entity.
 *
 * @property int $id
 * @property int $lote_id
 * @property \App\Model\Entity\Lote $lote
 * @property int $entrada_id
 * @property \App\Model\Entity\Entrada $entrada
 * @property int $id_modelo
 * @property string $modelo
 * @property int $tipo_pendencia_id
 * @property \App\Model\Entity\PendenciaTipo $pendencia_tipo
 * @property string $frase
 */
class Pendencia extends Entity
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
        'id' => false,
    ];
}
