<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ObjetivoImportacoes Model
 *
 * @property \App\Model\Table\TabelaPrecoObjetivoImportacoesTable&\Cake\ORM\Association\HasMany $TabelaPrecoObjetivoImportacoes
 *
 * @method \App\Model\Entity\ObjetivoImportacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\ObjetivoImportacao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ObjetivoImportacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ObjetivoImportacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ObjetivoImportacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ObjetivoImportacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ObjetivoImportacao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ObjetivoImportacao findOrCreate($search, callable $callback = null, $options = [])
 */
class ObjetivoImportacoesTable extends Table
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
        

        $this->setTable('objetivo_importacoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('TabelaPrecoObjetivoImportacoes', [
            'foreignKey' => 'objetivo_importacao_id',
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
