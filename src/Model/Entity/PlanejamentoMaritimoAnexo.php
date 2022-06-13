<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanejamentoMaritimoAnexo Entity
 *
 * @property int $id
 * @property int|null $planejamento_maritimo_id
 * @property int|null $anexo_id
 * @property string|null $caminho_arquivo
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 * @property \App\Model\Entity\Axeno $axeno
 */
class PlanejamentoMaritimoAnexo extends Entity
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
        
        'planejamento_maritimo_id' => true,
        'anexo_id' => true,
        'caminho_arquivo' => true,
        'created_at' => true,
        'updated_at' => true,
        'planejamento_maritimo' => true,
        'axeno' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
