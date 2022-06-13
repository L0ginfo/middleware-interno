<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EnderecoMedicoes Model
 *
 * @property \App\Model\Table\EnderecoMedicaoDadosTable&\Cake\ORM\Association\HasMany $EnderecoMedicaoDados
 *
 * @method \App\Model\Entity\EnderecoMedicao get($primaryKey, $options = [])
 * @method \App\Model\Entity\EnderecoMedicao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EnderecoMedicao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EnderecoMedicao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EnderecoMedicao findOrCreate($search, callable $callback = null, $options = [])
 */
class EnderecoMedicoesTable extends Table
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
        

        $this->setTable('endereco_medicoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('EnderecoMedicaoDados', [
            'foreignKey' => 'endereco_medicao_id',
        ]);

        $this->belongsTo('Usuarios', [
            'foreignKey' => 'created_by',
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
            ->date('data_medicao')
            ->requirePresence('data_medicao', 'create')
            ->notEmptyDate('data_medicao');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->integer('created_by')
            ->allowEmptyString('created_by');

        return $validator;
    }
}
