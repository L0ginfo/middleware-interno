<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Canais Model
 *
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\HasMany $LiberacoesDocumentais
 *
 * @method \App\Model\Entity\Canal get($primaryKey, $options = [])
 * @method \App\Model\Entity\Canal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Canal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Canal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Canal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Canal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Canal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Canal findOrCreate($search, callable $callback = null, $options = [])
 */
class CanaisTable extends Table
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

        $this->setTable('canais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('LiberacoesDocumentais', [
            'foreignKey' => 'canal_id'
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
            ->maxLength('descricao', 45)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
