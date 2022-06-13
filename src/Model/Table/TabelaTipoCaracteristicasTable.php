<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TabelaTipoCaracteristicas Model
 *
 * @property \App\Model\Table\TipoCaracteristicasTable&\Cake\ORM\Association\BelongsTo $TipoCaracteristicas
 *
 * @method \App\Model\Entity\TabelaTipoCaracteristica get($primaryKey, $options = [])
 * @method \App\Model\Entity\TabelaTipoCaracteristica newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TabelaTipoCaracteristica[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TabelaTipoCaracteristica|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaTipoCaracteristica saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TabelaTipoCaracteristica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaTipoCaracteristica[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TabelaTipoCaracteristica findOrCreate($search, callable $callback = null, $options = [])
 */
class TabelaTipoCaracteristicasTable extends Table
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
        

        $this->setTable('tabela_tipo_caracteristicas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('TipoCaracteristicas', [
            'foreignKey' => 'tipo_caracteristica_id',
            'joinType' => 'INNER',
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
            ->scalar('tabela')
            ->maxLength('tabela', 255)
            ->allowEmptyString('tabela');

        $validator
            ->scalar('coluna')
            ->maxLength('coluna', 255)
            ->allowEmptyString('coluna');

        $validator
            ->scalar('valor')
            ->maxLength('valor', 255)
            ->allowEmptyString('valor');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tipo_caracteristica_id'], 'TipoCaracteristicas'));

        return $rules;
    }
}
