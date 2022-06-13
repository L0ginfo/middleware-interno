<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CredenciamentoPerfilAreas Model
 *
 * @property \App\Model\Table\CredenciamentoPerfisTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPerfis
 * @property \App\Model\Table\ControleAcessoAreasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoAreas
 *
 * @method \App\Model\Entity\CredenciamentoPerfilArea get($primaryKey, $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfilArea newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfilArea[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfilArea|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfilArea saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfilArea patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfilArea[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CredenciamentoPerfilArea findOrCreate($search, callable $callback = null, $options = [])
 */
class CredenciamentoPerfilAreasTable extends Table
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
        

        $this->setTable('credenciamento_perfil_areas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('CredenciamentoPerfis', [
            'foreignKey' => 'credenciamento_perfil_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ControleAcessoAreas', [
            'foreignKey' => 'controle_acesso_area_id',
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
        $rules->add($rules->existsIn(['credenciamento_perfil_id'], 'CredenciamentoPerfis'));
        $rules->add($rules->existsIn(['controle_acesso_area_id'], 'ControleAcessoAreas'));

        return $rules;
    }
}
