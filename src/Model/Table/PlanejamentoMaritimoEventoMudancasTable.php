<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMaritimoEventoMudancas Model
 *
 * @property \App\Model\Table\EventosTable&\Cake\ORM\Association\BelongsTo $Eventos
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 * @property \App\Model\Table\PlanejamentoMaritimoMudancasTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimoMudancas
 *
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoEventoMudanca findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMaritimoEventoMudancasTable extends Table
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
        

        $this->setTable('planejamento_maritimo_evento_mudancas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Eventos', [
            'foreignKey' => 'evento_id',
        ]);
        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimo_id',
        ]);
        $this->belongsTo('PlanejamentoMaritimoMudancas', [
            'foreignKey' => 'planejamento_maritimo_mudanca_id',
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
            ->dateTime('data_hora')
            ->requirePresence('data_hora', 'create')
            ->notEmptyDateTime('data_hora');

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
        $rules->add($rules->existsIn(['evento_id'], 'Eventos'));
        $rules->add($rules->existsIn(['planejamento_maritimo_id'], 'PlanejamentoMaritimos'));
        $rules->add($rules->existsIn(['planejamento_maritimo_mudanca_id'], 'PlanejamentoMaritimoMudancas'));

        return $rules;
    }
}
