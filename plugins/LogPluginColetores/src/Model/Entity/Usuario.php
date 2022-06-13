<?php
namespace LogPluginColetores\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $senha
 * @property string $cpf
 * @property int $ativo
 * @property \Cake\I18n\Time|null $sincronizado
 * @property string|null $token
 * @property \Cake\I18n\Time|null $created_at
 * @property int|null $created_by
 * @property \Cake\I18n\Time|null $updated_at
 * @property int|null $updated_by
 * @property int $perfil_id
 *
 * @property \LogPluginColetores\Model\Entity\Perfil $perfil
 * @property \LogPluginColetores\Model\Entity\Dashboard[] $dashboards
 * @property \LogPluginColetores\Model\Entity\InventarioItem[] $inventario_itens
 * @property \LogPluginColetores\Model\Entity\Empresa[] $empresas
 * @property \LogPluginColetores\Model\Entity\EquipesTrabalho[] $equipes_trabalhos
 */
class Usuario extends Entity
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
        
        'nome' => true,
        'email' => true,
        'senha' => true,
        'cpf' => true,
        'ativo' => true,
        'sincronizado' => true,
        'token' => true,
        'created_at' => true,
        'created_by' => true,
        'updated_at' => true,
        'updated_by' => true,
        'perfil_id' => true,
        'perfil' => true,
        'dashboards' => true,
        'inventario_itens' => true,
        'empresas' => true,
        'equipes_trabalhos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token',
    ];
}
