<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoAnexos Model
 *
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\BelongsTo $Programacoes
 * @property \App\Model\Table\AnexosTable&\Cake\ORM\Association\BelongsTo $Anexos
 *
 * @method \App\Model\Entity\ProgramacaoAnexo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoAnexo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoAnexo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoAnexo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoAnexo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoAnexo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoAnexo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoAnexo findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoAnexosTable extends Table
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
        

        $this->setTable('programacao_anexos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Anexos', [
            'foreignKey' => 'anexo_id',
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
        $rules->add($rules->existsIn(['programacao_id'], 'Programacoes'));
        $rules->add($rules->existsIn(['anexo_id'], 'Anexos'));

        return $rules;
    }
}
