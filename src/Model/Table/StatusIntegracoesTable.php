<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StatusIntegracoes Model
 *
 * @property \App\Model\Table\FaturamentoBaixasTable&\Cake\ORM\Association\HasMany $FaturamentoBaixas
 * @property \App\Model\Table\FilaIntegracaoFaturamentoBaixasTable&\Cake\ORM\Association\HasMany $FilaIntegracaoFaturamentoBaixas
 *
 * @method \App\Model\Entity\StatusIntegracao get($primaryKey, $options = [])
 * @method \App\Model\Entity\StatusIntegracao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StatusIntegracao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StatusIntegracao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatusIntegracao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatusIntegracao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StatusIntegracao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StatusIntegracao findOrCreate($search, callable $callback = null, $options = [])
 */
class StatusIntegracoesTable extends Table
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
        

        $this->setTable('status_integracoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('FaturamentoBaixas', [
            'foreignKey' => 'status_integracao_id',
        ]);
        $this->hasMany('FilaIntegracaoFaturamentoBaixas', [
            'foreignKey' => 'status_integracao_id',
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
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        return $validator;
    }
}
