<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Areas Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\LocaisTable&\Cake\ORM\Association\BelongsTo $Locais
 * @property \App\Model\Table\FuncionalidadesTable&\Cake\ORM\Association\BelongsTo $Funcionalidades
 * @property \App\Model\Table\TipoEstruturasTable&\Cake\ORM\Association\BelongsTo $TipoEstruturas
 * @property \App\Model\Table\EnderecosTable&\Cake\ORM\Association\HasMany $Enderecos
 *
 * @method \App\Model\Entity\Area get($primaryKey, $options = [])
 * @method \App\Model\Entity\Area newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Area[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Area|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Area saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Area patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Area[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Area findOrCreate($search, callable $callback = null, $options = [])
 */
class AreasTable extends Table
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

        $this->setTable('areas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');
        

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locais', [
            'foreignKey' => 'local_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Funcionalidades', [
            'foreignKey' => 'funcionalidade_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoEstruturas', [
            'foreignKey' => 'tipo_estrutura_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Enderecos', [
            'foreignKey' => 'area_id'
        ]);

        $this->belongsTo('LeftLocais', [
            'className' => 'Locais',
            'foreignKey' => 'local_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('LocaisLeft', [
            'className' => 'Locais',
            'propertyName' => 'local',
            'foreignKey' => 'local_id',
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
            ->requirePresence('comprimento', 'create')
            ->notEmptyString('comprimento');

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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['local_id'], 'Locais'));
        $rules->add($rules->existsIn(['funcionalidade_id'], 'Funcionalidades'));
        $rules->add($rules->existsIn(['tipo_estrutura_id'], 'TipoEstruturas'));

        return $rules;
    }
}
