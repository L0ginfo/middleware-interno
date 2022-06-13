<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoDsicApropricoes Model
 *
 * @property \App\Model\Table\OrdemServicoDsicsTable&\Cake\ORM\Association\BelongsTo $OrdemServicoDsics
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\BelongsTo $DocumentosMercadorias
 *
 * @method \App\Model\Entity\OrdemServicoDsicApropricao get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoDsicApropricao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsicApropricao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsicApropricao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDsicApropricao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoDsicApropricao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsicApropricao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoDsicApropricao findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoDsicApropricoesTable extends Table
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
        

        $this->setTable('ordem_servico_dsic_apropricoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicoDsics', [
            'foreignKey' => 'ordem_servico_dsic_id',
        ]);
        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documento_mercadoria_hawb_id',
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
        $rules->add($rules->existsIn(['ordem_servico_dsic_id'], 'OrdemServicoDsics'));
        $rules->add($rules->existsIn(['documento_mercadoria_hawb_id'], 'DocumentosMercadorias'));

        return $rules;
    }
}
