<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoDsics Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadorias
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadorias
 * @property \App\Model\Table\OrdemServicoDsicApropricoesTable&\Cake\ORM\Association\HasMany $OrdemServicoDsicApropricoes
 *
 * @method \App\Model\Entity\OrdemServicoDsic get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoDsic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDsic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDsic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsic findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoDsicsTable extends Table
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
        

        $this->setTable('ordem_servico_dsics');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('DocumentosMercadoriasDsics', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documento_mercadoria_dsic_id',
        ]);
        $this->belongsTo('DocumentosMercadoriasHawbs', [
            'className' => 'DocumentosMercadorias',
            'foreignKey' => 'documento_mercadoria_hawb_id',
        ]);
        $this->hasMany('OrdemServicoDsicApropricoes', [
            'foreignKey' => 'ordem_servico_dsic_id',
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
            ->integer('associar')
            ->notEmptyString('associar');

        $validator
            ->integer('apropriar')
            ->notEmptyString('apropriar');

        $validator
            ->decimal('quantidade')
            ->requirePresence('quantidade', 'create')
            ->notEmptyString('quantidade');

        $validator
            ->decimal('peso')
            ->requirePresence('peso', 'create')
            ->notEmptyString('peso');

        $validator
            ->decimal('volume')
            ->requirePresence('volume', 'create')
            ->notEmptyString('volume');

        $validator
            ->date('data_recebimento')
            ->allowEmptyDate('data_recebimento');

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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['documento_mercadoria_dsic_id'], 'DocumentosMercadoriasDsics'));
        $rules->add($rules->existsIn(['documento_mercadoria_hawb_id'], 'DocumentosMercadoriasHawbs'));

        return $rules;
    }
}
