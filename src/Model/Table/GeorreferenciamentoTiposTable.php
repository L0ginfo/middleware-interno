<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GeorreferenciamentoTipos Model
 *
 * @property \App\Model\Table\GeorreferenciamentosTable&\Cake\ORM\Association\HasMany $Georreferenciamentos
 *
 * @method \App\Model\Entity\GeorreferenciamentoTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\GeorreferenciamentoTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GeorreferenciamentoTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GeorreferenciamentoTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GeorreferenciamentoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GeorreferenciamentoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GeorreferenciamentoTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GeorreferenciamentoTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class GeorreferenciamentoTiposTable extends Table
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
        

        $this->setTable('georreferenciamento_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Georreferenciamentos', [
            'foreignKey' => 'georreferenciamento_tipo_id',
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
            ->allowEmptyString('descricao');

        $validator
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        return $validator;
    }
}
