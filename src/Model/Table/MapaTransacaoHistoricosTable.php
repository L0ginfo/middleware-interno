<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MapaTransacaoHistoricos Model
 *
 * @property \App\Model\Table\MapaTransacaoTiposTable&\Cake\ORM\Association\BelongsTo $MapaTransacaoTipos
 * @property \App\Model\Table\MapasTable&\Cake\ORM\Association\BelongsTo $Mapas
 *
 * @method \App\Model\Entity\MapaTransacaoHistorico get($primaryKey, $options = [])
 * @method \App\Model\Entity\MapaTransacaoHistorico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoHistorico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoHistorico|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaTransacaoHistorico saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MapaTransacaoHistorico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoHistorico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MapaTransacaoHistorico findOrCreate($search, callable $callback = null, $options = [])
 */
class MapaTransacaoHistoricosTable extends Table
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
        

        $this->setTable('mapa_transacao_historicos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('MapaTransacaoTipos', [
            'foreignKey' => 'mapa_transacao_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Mapas', [
            'foreignKey' => 'mapa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'created_by',
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
        $rules->add($rules->existsIn(['mapa_transacao_tipo_id'], 'MapaTransacaoTipos'));
        $rules->add($rules->existsIn(['mapa_id'], 'Mapas'));

        return $rules;
    }
}
