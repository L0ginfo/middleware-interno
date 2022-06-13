<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Incoterms Model
 *
 * @property \App\Model\Table\DocumentoRegimeEspecialAdicoesTable&\Cake\ORM\Association\HasMany $DocumentoRegimeEspecialAdicoes
 *
 * @method \App\Model\Entity\Incoterm get($primaryKey, $options = [])
 * @method \App\Model\Entity\Incoterm newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Incoterm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Incoterm|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Incoterm saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Incoterm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Incoterm[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Incoterm findOrCreate($search, callable $callback = null, $options = [])
 */
class IncotermsTable extends Table
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
        

        $this->setTable('incoterms');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('DocumentoRegimeEspecialAdicoes', [
            'foreignKey' => 'incoterm_id',
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

        $validator
            ->scalar('codigo_externo')
            ->maxLength('codigo_externo', 255)
            ->allowEmptyString('codigo_externo');

        return $validator;
    }
}
