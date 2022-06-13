<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoSaidaChat Entity.
 *
 * @property int $id
 * @property string $conversation
 * @property \Cake\I18n\Time $date_time
 * @property int $id_documento_saida
 * @property \App\Model\Entity\DocumentoSaida $documento_saida
 * @property int $id_usuario
 * @property \App\Model\Entity\Usuario $usuario
 */
class DocumentoSaidaChat extends Entity {

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