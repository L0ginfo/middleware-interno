<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Enderecos Model
 *
 * @property \App\Model\Table\AreasTable&\Cake\ORM\Association\BelongsTo $Areas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EstoqueEnderecosTable&\Cake\ORM\Association\HasMany $EstoqueEnderecos
 * @property \App\Model\Table\EtiquetaProdutosTable&\Cake\ORM\Association\HasMany $EtiquetaProdutos
 *
 * @method \App\Model\Entity\Endereco get($primaryKey, $options = [])
 * @method \App\Model\Entity\Endereco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Endereco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Endereco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Endereco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Endereco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Endereco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Endereco findOrCreate($search, callable $callback = null, $options = [])
 */
class EnderecosTable extends Table
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

        $this->setTable('enderecos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Areas', [
            'foreignKey' => 'area_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('EstoqueEnderecos', [
            'foreignKey' => 'endereco_id'
        ]);
        $this->hasMany('EtiquetaProdutos', [
            'foreignKey' => 'endereco_id'
        ]);

        $this->hasMany('EtiquetaProdutosFilter', [
            'className'=> 'etiqueta_produtos',
            'foreignKey' => 'endereco_id',
        ])->setJoinType('INNER');;

        $this->belongsTo('LeftAreas', [
            'className' => 'Areas',
            'foreignKey' => 'area_id',
            'joinType' => 'Left'
        ]);

        $this->belongsTo('AreasLeft', [
            'className' => 'Areas',
            'propertyName' => 'area',
            'foreignKey' => 'area_id',
            'joinType' => 'Left'
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

        $validator
            ->decimal('comprimento')
            ->allowEmptyString('comprimento');

        $validator
            ->decimal('altura')
            ->requirePresence('altura', 'create')
            ->notEmptyString('altura');

        $validator
            ->decimal('largura')
            ->requirePresence('largura', 'create')
            ->notEmptyString('largura');

        $validator
            ->decimal('m2')
            ->requirePresence('m2', 'create')
            ->notEmptyString('m2');

        $validator
            ->decimal('m3')
            ->requirePresence('m3', 'create')
            ->notEmptyString('m3');

        $validator
            ->integer('ativo')
            ->requirePresence('ativo', 'create')
            ->notEmptyString('ativo');

        $validator
            ->integer('cod_composicao1')
            ->requirePresence('cod_composicao1', 'create')
            ->notEmptyString('cod_composicao1');

        $validator
            ->integer('cod_composicao2')
            ->requirePresence('cod_composicao2', 'create')
            ->notEmptyString('cod_composicao2');

        $validator
            ->integer('cod_composicao3')
            ->allowEmptyString('cod_composicao3');

        $validator
            ->integer('cod_composicao4')
            ->allowEmptyString('cod_composicao4');

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
        $rules->add($rules->existsIn(['area_id'], 'Areas'));
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));

        return $rules;
    }
}
