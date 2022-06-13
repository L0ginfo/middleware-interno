<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TipoIsos Model
 *
 * @property \App\Model\Table\ContainerModelosTable&\Cake\ORM\Association\BelongsTo $ContainerModelos
 * @property \App\Model\Table\ContainerTamanhosTable&\Cake\ORM\Association\BelongsTo $ContainerTamanhos
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\HasMany $Containers
 *
 * @method \App\Model\Entity\TipoIso get($primaryKey, $options = [])
 * @method \App\Model\Entity\TipoIso newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TipoIso[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TipoIso|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoIso saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TipoIso patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TipoIso[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TipoIso findOrCreate($search, callable $callback = null, $options = [])
 */
class TipoIsosTable extends Table
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
        

        $this->setTable('tipo_isos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ContainerModelos', [
            'foreignKey' => 'container_modelo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ContainerTamanhos', [
            'foreignKey' => 'container_tamanho_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Containers', [
            'foreignKey' => 'tipo_iso_id',
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
            ->allowEmptyString('descricao');

        $validator
            ->scalar('m3')
            ->maxLength('m3', 45)
            ->allowEmptyString('m3');

        $validator
            ->scalar('m2')
            ->maxLength('m2', 45)
            ->allowEmptyString('m2');

        $validator
            ->decimal('comprimento')
            ->allowEmptyString('comprimento');

        $validator
            ->decimal('largura')
            ->allowEmptyString('largura');

        $validator
            ->decimal('altura')
            ->allowEmptyString('altura');

        $validator
            ->scalar('sigla')
            ->maxLength('sigla', 45)
            ->allowEmptyString('sigla');

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
        $rules->add($rules->existsIn(['container_modelo_id'], 'ContainerModelos'));
        $rules->add($rules->existsIn(['container_tamanho_id'], 'ContainerTamanhos'));

        return $rules;
    }
}
