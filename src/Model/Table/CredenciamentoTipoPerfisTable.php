<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CredenciamentoTipoPerfis Model
 *
 * @property \App\Model\Table\CredenciamentoPerfisTable&\Cake\ORM\Association\HasMany $CredenciamentoPerfis
 *
 * @method \App\Model\Entity\CredenciamentoTipoPerfi get($primaryKey, $options = [])
 * @method \App\Model\Entity\CredenciamentoTipoPerfi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CredenciamentoTipoPerfi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoTipoPerfi|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoTipoPerfi saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoTipoPerfi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoTipoPerfi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoTipoPerfi findOrCreate($search, callable $callback = null, $options = [])
 */
class CredenciamentoTipoPerfisTable extends Table
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
        

        $this->setTable('credenciamento_tipo_perfis');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('CredenciamentoPerfis', [
            'foreignKey' => 'credenciamento_tipo_perfil_id',
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

        return $validator;
    }
}
