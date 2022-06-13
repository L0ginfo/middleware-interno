<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoUnitizacoesFoto Entity
 *
 * @property int $id
 * @property string|null $caminho_arquivo
 * @property int|null $usuario_id
 * @property int|null $anexo_id
 * @property string|null $fita
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Anexo $anexo
 */
class OrdemServicoUnitizacoesFoto extends Entity
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
        
        'caminho_arquivo' => true,
        'usuario_id' => true,
        'anexo_id' => true,
        'fita' => true,
        'created_at' => true,
        'updated_at' => true,
        'usuario' => true,
        'anexo' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
