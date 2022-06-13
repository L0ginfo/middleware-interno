<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tributos Model
 *
 * @property \App\Model\Table\DocumentoRegimeEspecialTributosTable&\Cake\ORM\Association\HasMany $DocumentoRegimeEspecialTributos
 *
 * @method \App\Model\Entity\Tributo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tributo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tributo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tributo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tributo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tributo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tributo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tributo findOrCreate($search, callable $callback = null, $options = [])
 */
class TributosTable extends Table
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
        

        $this->setTable('tributos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('DocumentoRegimeEspecialTributos', [
            'foreignKey' => 'tributo_id',
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

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }
}
