<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeparacaoCargaOperadores Model
 *
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 * @property \App\Model\Table\SeparacaoCargasTable&\Cake\ORM\Association\BelongsTo $SeparacaoCargas
 *
 * @method \App\Model\Entity\SeparacaoCargaOperador get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeparacaoCargaOperador newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaOperador[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaOperador|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoCargaOperador saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoCargaOperador patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaOperador[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCargaOperador findOrCreate($search, callable $callback = null, $options = [])
 */
class SeparacaoCargaOperadoresTable extends Table
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
        

        $this->setTable('separacao_carga_operadores');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_operador_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('SeparacaoCargas', [
            'foreignKey' => 'separacao_carga_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['usuario_operador_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['separacao_carga_id'], 'SeparacaoCargas'));

        return $rules;
    }
}
