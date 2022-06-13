<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipesTrabalhosUsuarios Model
 *
 * @property \App\Model\Table\EquipesTrabalhosTable&\Cake\ORM\Association\BelongsTo $EquipesTrabalhos
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 *
 * @method \App\Model\Entity\EquipesTrabalhosUsuario get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipesTrabalhosUsuario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalhosUsuario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalhosUsuario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipesTrabalhosUsuario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipesTrabalhosUsuario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalhosUsuario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalhosUsuario findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipesTrabalhosUsuariosTable extends Table
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

        $this->setTable('equipes_trabalhos_usuarios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('EquipesTrabalhos', [
            'foreignKey' => 'equipes_trabalho_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
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
            ->scalar('recurso')
            ->maxLength('recurso', 45)
            ->requirePresence('recurso', 'create')
            ->notEmptyString('recurso');

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
        $rules->add($rules->existsIn(['equipes_trabalho_id'], 'EquipesTrabalhos'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));

        return $rules;
    }
}
