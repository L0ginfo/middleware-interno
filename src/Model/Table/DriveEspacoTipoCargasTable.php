<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DriveEspacoTipoCargas Model
 *
 * @property \App\Model\Table\DriveEspacosTable&\Cake\ORM\Association\HasMany $DriveEspacos
 *
 * @method \App\Model\Entity\DriveEspacoTipoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\DriveEspacoTipoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DriveEspacoTipoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DriveEspacoTipoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DriveEspacoTipoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DriveEspacoTipoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DriveEspacoTipoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DriveEspacoTipoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class DriveEspacoTipoCargasTable extends Table
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
        

        $this->setTable('drive_espaco_tipo_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('DriveEspacos', [
            'foreignKey' => 'drive_espaco_tipo_carga_id',
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
