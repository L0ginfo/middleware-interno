<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMaritimoMudancas Model
 *
 * @property \App\Model\Table\BercosTable&\Cake\ORM\Association\BelongsTo $Bercos
 * @property \App\Model\Table\PlanejamentoMaritimosTable&\Cake\ORM\Association\BelongsTo $PlanejamentoMaritimos
 *
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimoMudanca findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMaritimoMudancasTable extends Table
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
        

        $this->setTable('planejamento_maritimo_mudancas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Bercos', [
            'foreignKey' => 'berco_id',
        ]);
        $this->belongsTo('PlanejamentoMaritimos', [
            'foreignKey' => 'planejamento_maritimo_id',
        ]);

        $this->hasMany('PlanejamentoMaritimoEventoMudancas',[
            'foreignkey' => 'planejamento_maritimo_mudancas_id'
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
            ->decimal('fwd')
            ->allowEmptyString('fwd');

        $validator
            ->decimal('ifo')
            ->allowEmptyString('ifo');

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
        $rules->add($rules->existsIn(['berco_id'], 'Bercos'));
        $rules->add($rules->existsIn(['planejamento_maritimo_id'], 'PlanejamentoMaritimos'));

        return $rules;
    }
}
