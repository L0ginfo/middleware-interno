<?php
namespace LogPluginColetores\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usuarios Model
 *
 * @property \LogPluginColetores\Model\Table\PerfisTable&\Cake\ORM\Association\BelongsTo $Perfis
 * @property \LogPluginColetores\Model\Table\DashboardsTable&\Cake\ORM\Association\HasMany $Dashboards
 * @property \LogPluginColetores\Model\Table\InventarioItensTable&\Cake\ORM\Association\HasMany $InventarioItens
 * @property \LogPluginColetores\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsToMany $Empresas
 * @property \LogPluginColetores\Model\Table\EquipesTrabalhosTable&\Cake\ORM\Association\BelongsToMany $EquipesTrabalhos
 *
 * @method \LogPluginColetores\Model\Entity\Usuario get($primaryKey, $options = [])
 * @method \LogPluginColetores\Model\Entity\Usuario newEntity($data = null, array $options = [])
 * @method \LogPluginColetores\Model\Entity\Usuario[] newEntities(array $data, array $options = [])
 * @method \LogPluginColetores\Model\Entity\Usuario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginColetores\Model\Entity\Usuario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \LogPluginColetores\Model\Entity\Usuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \LogPluginColetores\Model\Entity\Usuario[] patchEntities($entities, array $data, array $options = [])
 * @method \LogPluginColetores\Model\Entity\Usuario findOrCreate($search, callable $callback = null, $options = [])
 */
class UsuariosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->addBehavior('LogsTabelas');
        

        $this->setTable('usuarios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Perfis', [
            'foreignKey' => 'perfil_id',
            'joinType' => 'INNER',
            'className' => 'LogPluginColetores.Perfis',
        ]);
        $this->hasMany('Dashboards', [
            'foreignKey' => 'usuario_id',
            'className' => 'LogPluginColetores.Dashboards',
        ]);
        $this->hasMany('InventarioItens', [
            'foreignKey' => 'usuario_id',
            'className' => 'LogPluginColetores.InventarioItens',
        ]);
        $this->belongsToMany('Empresas', [
            'foreignKey' => 'usuario_id',
            'targetForeignKey' => 'empresa_id',
            'joinTable' => 'empresas_usuarios',
            'className' => 'LogPluginColetores.Empresas',
        ]);
        $this->belongsToMany('EquipesTrabalhos', [
            'foreignKey' => 'usuario_id',
            'targetForeignKey' => 'equipes_trabalho_id',
            'joinTable' => 'equipes_trabalhos_usuarios',
            'className' => 'LogPluginColetores.EquipesTrabalhos',
        ]);

        $this->hasMany('EmpresasUsuarios', [
            'foreignKey' => 'usuario_id',
            'joinTable' => 'empresas_usuarios',
            'conditions' => ['validade >=' => date('Y-m-d')]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('senha')
            ->maxLength('senha', 60)
            ->requirePresence('senha', 'create')
            ->notEmptyString('senha');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 11)
            ->requirePresence('cpf', 'create')
            ->notEmptyString('cpf');

        $validator
            ->integer('ativo')
            ->requirePresence('ativo', 'create')
            ->notEmptyString('ativo');

        $validator
            ->dateTime('sincronizado')
            ->allowEmptyDateTime('sincronizado');

        $validator
            ->scalar('token')
            ->maxLength('token', 255)
            ->allowEmptyString('token');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->integer('updated_by')
            ->allowEmptyString('updated_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['perfil_id'], 'Perfis'));

        return $rules;
    }
}
