<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EntradaSaidaFluxoFotos Model
 *
 * @property \App\Model\Table\EntradaSaidaFluxosTable&\Cake\ORM\Association\BelongsTo $EntradaSaidaFluxos
 *
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto get($primaryKey, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxoFoto findOrCreate($search, callable $callback = null, $options = [])
 */
class EntradaSaidaFluxoFotosTable extends Table
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
        

        $this->setTable('entrada_saida_fluxo_fotos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('EntradaSaidaFluxos', [
            'foreignKey' => 'entrada_saida_fluxo_id',
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

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 255)
            ->allowEmptyString('tipo');

        $validator
            ->scalar('placa')
            ->maxLength('placa', 255)
            ->allowEmptyString('placa');

        $validator
            ->scalar('foto')
            ->maxLength('foto', 255)
            ->requirePresence('foto', 'create')
            ->notEmptyString('foto');

        $validator
            ->dateTime('data_registro')
            ->allowEmptyDateTime('data_registro');

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
        $rules->add($rules->existsIn(['entrada_saida_fluxo_id'], 'EntradaSaidaFluxos'));

        return $rules;
    }
}
