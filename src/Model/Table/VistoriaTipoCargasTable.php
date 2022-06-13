<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VistoriaTipoCargas Model
 *
 * @property \App\Model\Table\AvariasTable&\Cake\ORM\Association\HasMany $Avarias
 * @property \App\Model\Table\VistoriasTable&\Cake\ORM\Association\HasMany $Vistorias
 *
 * @method \App\Model\Entity\VistoriaTipoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\VistoriaTipoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VistoriaTipoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaTipoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaTipoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VistoriaTipoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaTipoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VistoriaTipoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class VistoriaTipoCargasTable extends Table
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
        

        $this->setTable('vistoria_tipo_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('Avarias', [
            'foreignKey' => 'vistoria_tipo_carga_id',
        ]);
        $this->hasMany('Vistorias', [
            'foreignKey' => 'vistoria_tipo_carga_id',
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

        return $validator;
    }
}
