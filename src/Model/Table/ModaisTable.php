<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modais Model
 *
 * @property \App\Model\Table\DocumentosMercadoriasTable&\Cake\ORM\Association\HasMany $DocumentosMercadorias
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\HasMany $DocumentosTransportes
 * @property \App\Model\Table\PortariasTable&\Cake\ORM\Association\HasMany $Portarias
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\HasMany $Resvs
 *
 * @method \App\Model\Entity\Modal get($primaryKey, $options = [])
 * @method \App\Model\Entity\Modal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Modal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Modal|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Modal saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Modal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Modal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Modal findOrCreate($search, callable $callback = null, $options = [])
 */
class ModaisTable extends Table
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

        $this->setTable('modais');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->hasMany('DocumentosMercadorias', [
            'foreignKey' => 'modal_id'
        ]);
        $this->hasMany('DocumentosTransportes', [
            'foreignKey' => 'modal_id'
        ]);
        $this->hasMany('Portarias', [
            'foreignKey' => 'modal_id'
        ]);
        $this->hasMany('Resvs', [
            'foreignKey' => 'modal_id'
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
