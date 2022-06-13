<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VistoriaFoto Entity
 *
 * @property int $id
 * @property int|null $vistoria_id
 * @property string|null $caminho_arquivo
 * @property int|null $usuario_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Vistoria $vistoria
 * @property \App\Model\Entity\Usuario $usuario
 */
class VistoriaFoto extends Entity
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
        
        'vistoria_id' => true,
        'caminho_arquivo' => true,
        'usuario_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'vistoria' => true,
        'usuario' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
