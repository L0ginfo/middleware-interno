<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Consolidado Entity.
 *
 * @property int $codigo_viagem_sara
 * @property int $id
 * @property string $container
 * @property float $peso_tara
 * @property int $free_time_dias
 * @property string $lacre
 * @property int $lote_id
 * @property \App\Model\Entity\Lote $lote
 * @property int $iso_code_id
 * @property \App\Model\Entity\IsoCode $iso_code
 */
class Consolidado extends Entity
{

}
