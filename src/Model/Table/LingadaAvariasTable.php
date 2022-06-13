<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LingadaAvarias Model
 *
 * @property \App\Model\Table\AvariasTable&\Cake\ORM\Association\BelongsTo $Avarias
 * @property \App\Model\Table\OrdemServicoItemLingadasTable&\Cake\ORM\Association\BelongsTo $OrdemServicoItemLingadas
 * @property \App\Model\Table\LingadaAvariaFotosTable&\Cake\ORM\Association\HasMany $LingadaAvariaFotos
 *
 * @method \App\Model\Entity\LingadaAvaria get($primaryKey, $options = [])
 * @method \App\Model\Entity\LingadaAvaria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LingadaAvaria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LingadaAvaria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaAvaria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LingadaAvaria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaAvaria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LingadaAvaria findOrCreate($search, callable $callback = null, $options = [])
 */
class LingadaAvariasTable extends Table
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
        

        $this->setTable('lingada_avarias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Avarias', [
            'foreignKey' => 'avaria_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('OrdemServicoItemLingadas', [
            'foreignKey' => 'ordem_servico_item_lingada_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('LingadaAvariaFotos', [
            'foreignKey' => 'lingada_avaria_id',
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
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        $rules->add($rules->existsIn(['avaria_id'], 'Avarias'));
        $rules->add($rules->existsIn(['ordem_servico_item_lingada_id'], 'OrdemServicoItemLingadas'));

        return $rules;
    }
}
