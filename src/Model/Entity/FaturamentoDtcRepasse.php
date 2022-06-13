<?php

namespace App\Model\Entity;

use App\Controller\AppController;
use Cake\ORM\Entity;

/**
 * FaturamentoDtcRepasse Entity.
 *
 * @property int $id
 * @property int $id_entrada
 * @property string $valor_area_primaria
 * @property string $valor_final
 * @property string $situacao
 * @property int $parceiro_id
 * @property \App\Model\Entity\Parceiro $parceiro
 * @property float $taxa_administrativa
 * @property string $numero_demostrativo
 */
class FaturamentoDtcRepasse extends Entity {

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

    protected function _getDemostrativo() {
        //   debug($this->_properties['nfm_id'] );         die();
        
        return AppController:: geraUrls('layout=pdf001&params[NFM_ID]=' . $this->_properties['nfm_id'] );;
    }

}
