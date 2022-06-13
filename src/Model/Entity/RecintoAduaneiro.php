<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RecintoAduaneiro Entity
 *
 * @property int $id
 * @property string|null $codigo
 * @property string $nome
 * @property string|null $sigla
 * @property string $cnpj
 * @property string|null $urf
 * @property int|null $tipo_operacao
 * @property int|null $zona_secundaria
 *
 * @property \App\Model\Entity\LiberacoesDocumental[] $liberacoes_documentais
 */
class RecintoAduaneiro extends Entity
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
        
        'codigo' => true,
        'nome' => true,
        'sigla' => true,
        'cnpj' => true,
        'urf' => true,
        'tipo_operacao' => true,
        'zona_secundaria' => true,
        'liberacoes_documentais' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
