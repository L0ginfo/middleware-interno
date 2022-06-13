<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MapaComentario Entity
 *
 * @property int $id
 * @property string $comentario
 * @property int $mapa_comentario_tipo_id
 * @property int $mapa_comentario_acao_id
 *
 * @property \App\Model\Entity\MapaComentarioTipo $mapa_comentario_tipo
 * @property \App\Model\Entity\MapaComentarioAcao $mapa_comentario_acao
 */
class MapaComentario extends Entity
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
     /* Default fields
        
        'comentario' => true,
        'mapa_comentario_tipo_id' => true,
        'mapa_comentario_acao_id' => true,
        'mapa_comentario_tipo' => true,
        'mapa_comentario_acao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
