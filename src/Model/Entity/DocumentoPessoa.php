<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentoPessoa Entity
 *
 * @property int $id
 * @property int|null $tipo_documento_id
 * @property string|null $numero_documento
 * @property \Cake\I18n\Time|null $data_documento
 * @property string|null $orgao_emissor
 * @property int|null $pessoa_id
 *
 * @property \App\Model\Entity\TipoDocumento $tipo_documento
 * @property \App\Model\Entity\Pessoa $pessoa
 */
class DocumentoPessoa extends Entity
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
        
        'tipo_documento_id' => true,
        'numero_documento' => true,
        'data_documento' => true,
        'orgao_emissor' => true,
        'pessoa_id' => true,
        'tipo_documento' => true,
        'pessoa' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
