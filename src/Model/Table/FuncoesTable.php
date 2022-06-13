<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Funcoes Model
 *
 * @property \App\Model\Table\OrdemServicoConferentesTable&\Cake\ORM\Association\HasMany $OrdemServicoConferentes
 * @property \App\Model\Table\PlanejamentoMaritimoTernoUsuariosTable&\Cake\ORM\Association\HasMany $PlanejamentoMaritimoTernoUsuarios
 *
 * @method \App\Model\Entity\Funcao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Funcao newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Funcao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Funcao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Funcao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Funcao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Funcao[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Funcao findOrCreate($search, callable $callback = null, $options = [])
 */
class FuncoesTable extends Table
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
        

        $this->setTable('funcoes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->hasMany('OrdemServicoConferentes', [
            'foreignKey' => 'funcao_id',
        ]);
        $this->hasMany('PlanejamentoMaritimoTernoUsuarios', [
            'foreignKey' => 'funcao_id',
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
