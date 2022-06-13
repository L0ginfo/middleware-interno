<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoAreas Model
 *
 * @property \App\Model\Table\ControleAcessoNiveisTable&\Cake\ORM\Association\BelongsTo $ControleAcessoNiveis
 * @property \App\Model\Table\ControleAcessoTipoAreasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoTipoAreas
 * @property \App\Model\Table\CredenciamentoPessoaAreasTable&\Cake\ORM\Association\HasMany $CredenciamentoPessoaAreas
 *
 * @method \App\Model\Entity\ControleAcessoArea get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoArea newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoArea[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoArea|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoArea saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoArea patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoArea[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoArea findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoAreasTable extends Table
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
        

        $this->setTable('controle_acesso_areas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleAcessoNiveis', [
            'foreignKey' => 'nivel_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ControleAcessoTipoAreas', [
            'foreignKey' => 'tipo_area_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CredenciamentoPessoaAreas', [
            'foreignKey' => 'controle_acesso_area_id',
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

        $validator
            ->integer('situacao')
            ->notEmptyString('situacao');

        $validator
            ->scalar('motivo_situacao')
            ->maxLength('motivo_situacao', 255)
            ->allowEmptyString('motivo_situacao');

        $validator
            ->integer('is_alfandegado')
            ->notEmptyString('is_alfandegado');

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
        $rules->add($rules->existsIn(['nivel_id'], 'ControleAcessoNiveis'));
        $rules->add($rules->existsIn(['tipo_area_id'], 'ControleAcessoTipoAreas'));

        return $rules;
    }
}
