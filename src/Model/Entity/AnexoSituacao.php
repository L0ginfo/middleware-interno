<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AnexoSituacao Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int|null $anexo_tipo_grupo_id
 *
 * @property \App\Model\Entity\AnexoTipoGrupo $anexo_tipo_grupo
 * @property \App\Model\Entity\AnexoTabela[] $anexo_tabelas
 */
class AnexoSituacao extends Entity
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
        
        'descricao' => true,
        'anexo_tipo_grupo_id' => true,
        'anexo_tipo_grupo' => true,
        'anexo_tabelas' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
