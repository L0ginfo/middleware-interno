<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControleAcessoEquipamento Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $codigo
 * @property int $modelo_equipamento_id
 *
 * @property \App\Model\Entity\ModeloEquipamento $modelo_equipamento
 * @property \App\Model\Entity\ControleAcessoSolicitacaoLeitura[] $controle_acesso_solicitacao_leituras
 */
class ControleAcessoEquipamento extends Entity
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
        'codigo' => true,
        'modelo_equipamento_id' => true,
        'modelo_equipamento' => true,
        'controle_acesso_solicitacao_leituras' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
