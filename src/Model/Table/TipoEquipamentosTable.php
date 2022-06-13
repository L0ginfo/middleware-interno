<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoEquipamentos Model
 *
 * @property \App\Model\Table\ControleAcessoControladorasTable&\Cake\ORM\Association\HasMany $ControleAcessoControladoras
 *
 * @method \App\Model\Entity\TipoEquipamento get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoEquipamento newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoEquipamento[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoEquipamento|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoEquipamento saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoEquipamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoEquipamento[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoEquipamento findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoEquipamentosTable extends Table
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
        

        $this->setTable('tipo_equipamentos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('ControleAcessoControladoras', [
            'foreignKey' => 'tipo_equipamento_id',
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
