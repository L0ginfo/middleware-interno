<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Containers Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Empresas
 * @property &\Cake\ORM\Association\BelongsTo $TipoIsos
 * @property &\Cake\ORM\Association\HasMany $ContainerEntradas
 * @property &\Cake\ORM\Association\HasMany $ItemContainers
 * @property &\Cake\ORM\Association\HasMany $Lacres
 *
 * @method \App\Model\Entity\Container get($primaryKey, $options = [])
 * @method \App\Model\Entity\Container newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Container[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Container|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Container saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Container patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Container[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Container findOrCreate($search, callable $callback = null, $options = [])
 */
class ContainersTable extends Table
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
        

        $this->setTable('containers');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'armador_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Armadores', [
            'foreignKey' => 'armador_id',
            'className' => 'Empresas',
            'propertyName' => 'armador',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('TipoIsos', [
            'foreignKey' => 'tipo_iso_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('TipoIsosLeft', [
            'foreignKey' => 'tipo_iso_id',
            'className' => 'TipoIsos',
            'propertyName' => 'tipo_iso',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('ContainerEntradas', [
            'foreignKey' => 'container_id',
        ]);
        $this->hasMany('ItemContainers', [
            'foreignKey' => 'container_id',
        ]);
        $this->hasMany('Lacres', [
            'foreignKey' => 'container_id',
        ]);
        $this->hasOne('EstoqueContainerVazio', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT',
            'className' => 'EstoqueEnderecos', 
            'propertyName' => 'estoque_endereco_container_vazio'
        ]);
        $this->hasMany('EstoqueEnderecos', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('EntradaSaidaContainers', [
            'className'=>'EntradaSaidaContainers',
            'foreignKey' => 'id',
            'bindingKey' => 'container_id',
            'joinType' => 'LEFT'
        ])
        ->setConditions([
            'EntradaSaidaContainers.resv_entrada_id IS NOT NULL',
            'EntradaSaidaContainers.resv_saida_id IS NULL'
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
            ->scalar('numero')
            ->maxLength('numero', 45)
            ->allowEmptyString('numero');

        $validator
            ->scalar('capacidade_m3')
            ->maxLength('capacidade_m3', 45)
            ->allowEmptyString('capacidade_m3');

        $validator
            ->scalar('mes_ano_fabricacao')
            ->maxLength('mes_ano_fabricacao', 45)
            ->allowEmptyString('mes_ano_fabricacao');

        $validator
            ->decimal('tara')
            ->allowEmptyString('tara');

        $validator
            ->decimal('payload')
            ->allowEmptyString('payload');

        $validator
            ->decimal('temp_minima')
            ->allowEmptyString('temp_minima');

        $validator
            ->decimal('temp_maxima')
            ->allowEmptyString('temp_maxima');

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
        $rules->add($rules->existsIn(['armador_id'], 'Empresas'));
        $rules->add($rules->existsIn(['tipo_iso_id'], 'TipoIsos'));

        return $rules;
    }
}
