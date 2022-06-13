<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipesTrabalhos Model
 *
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsToMany $Usuarios
 * @property \App\Model\Table\TabelasPrecosTable&\Cake\ORM\Association\BelongsToMany $TabelasPrecos
 *
 * @method \App\Model\Entity\EquipesTrabalho get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipesTrabalho newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalho[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalho|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipesTrabalho saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipesTrabalho patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalho[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipesTrabalho findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipesTrabalhosTable extends Table
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

        $this->setTable('equipes_trabalhos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Usuarios', [
            'foreignKey' => 'equipes_trabalho_id',
            'targetForeignKey' => 'usuario_id',
            'joinTable' => 'equipes_trabalhos_usuarios'
        ]);

        $this->belongsToMany('TabelasPrecos', [
            'foreignKey' => 'equipes_trabalho_id',
            'targetForeignKey' => 'tabelas_preco_id',
            'joinTable' => 'tabelas_precos_equipes_trabalhos'
        ]);

        $this->hasMany('EquipesTrabalhosUsuarios', [
            'foreignKey' => 'equipes_trabalho_id'
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
            ->scalar('descricao')
            ->maxLength('descricao', 70)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->integer('recebimento')
            ->requirePresence('recebimento', 'create')
            ->notEmptyString('recebimento');

        $validator
            ->integer('expedicao')
            ->requirePresence('expedicao', 'create')
            ->notEmptyString('expedicao');

        $validator
            ->integer('separacao')
            ->requirePresence('separacao', 'create')
            ->notEmptyString('separacao');

        return $validator;
    }
}
