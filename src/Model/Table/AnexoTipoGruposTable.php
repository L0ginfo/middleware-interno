<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AnexoTipoGrupos Model
 *
 * @property \App\Model\Table\AnexoSituacoesTable&\Cake\ORM\Association\HasMany $AnexoSituacoes
 * @property \App\Model\Table\AnexoTiposTable&\Cake\ORM\Association\HasMany $AnexoTipos
 *
 * @method \App\Model\Entity\AnexoTipoGrupo get($primaryKey, $options = [])
 * @method \App\Model\Entity\AnexoTipoGrupo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AnexoTipoGrupo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AnexoTipoGrupo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnexoTipoGrupo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnexoTipoGrupo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AnexoTipoGrupo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AnexoTipoGrupo findOrCreate($search, callable $callback = null, $options = [])
 */
class AnexoTipoGruposTable extends Table
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
        

        $this->setTable('anexo_tipo_grupos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('AnexoSituacoes', [
            'foreignKey' => 'anexo_tipo_grupo_id',
        ]);
        $this->hasMany('AnexoTipos', [
            'foreignKey' => 'anexo_tipo_grupo_id',
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
