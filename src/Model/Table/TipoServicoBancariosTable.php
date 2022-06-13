<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoServicoBancarios Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\HasMany $Empresas
 *
 * @method \App\Model\Entity\TipoServicoBancario get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoServicoBancario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoServicoBancario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoServicoBancario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoServicoBancario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoServicoBancario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoServicoBancario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoServicoBancario findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoServicoBancariosTable extends Table
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

        $this->setTable('tipo_servico_bancarios');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');


        $this->hasMany('Empresas', [
            'foreignKey' => 'tipo_servico_bancario_id'
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
            ->scalar('codigo')
            ->maxLength('codigo', 11)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        return $validator;
    }
}
