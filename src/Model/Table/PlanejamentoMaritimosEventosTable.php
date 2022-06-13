<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMaritimosEventos Model
 *
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 * @property \App\Model\Table\SituacaoProgramacaoMaritimasTable&\Cake\ORM\Association\BelongsTo $SituacaoProgramacaoMaritimas
 * @property \App\Model\Table\EventosTable&\Cake\ORM\Association\BelongsTo $Eventos
 *
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimosEvento findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMaritimosEventosTable extends Table
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

        $this->setTable('planejamento_maritimos_eventos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimos_id'
        ]);
        $this->belongsTo('SituacaoProgramacaoMaritimas', [
            'foreignKey' => 'situacao_id'
        ]);
        $this->belongsTo('Eventos', [
            'foreignKey' => 'evento_id'
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
            ->scalar('versao')
            ->maxLength('versao', 45)
            ->allowEmptyString('versao');

        $validator
            ->dateTime('data_hora_evento')
            ->allowEmptyDateTime('data_hora_evento');

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
        $rules->add($rules->existsIn(['planejamento_maritimos_id'], 'PlanejamentoMaritimos'));
        $rules->add($rules->existsIn(['situacao_id'], 'SituacaoProgramacaoMaritimas'));
        $rules->add($rules->existsIn(['evento_id'], 'Eventos'));

        return $rules;
    }
}
