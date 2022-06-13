<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Retencoes Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsToMany $Empresas
 *
 * @method \App\Model\Entity\Retencao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Retencao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Retencao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Retencao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Retencao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Retencao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Retencao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Retencao findOrCreate($search, callable $callback = null, $options = [])
 */
class RetencoesTable extends Table
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
        

        $this->setTable('retencoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Empresas', [
            'foreignKey' => 'retencao_id',
            'targetForeignKey' => 'empresa_id',
            'joinTable' => 'empresas_retencoes',
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
