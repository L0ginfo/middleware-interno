<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrdemServicoConferentes Model
 *
 * @property \App\Model\Table\OrdemServicosTable&\Cake\ORM\Association\BelongsTo $OrdemServicos
 * @property \App\Model\Table\UsuariosTable&\Cake\ORM\Association\BelongsTo $Usuarios
 *
 * @method \App\Model\Entity\OrdemServicoConferente get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrdemServicoConferente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrdemServicoConferente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoConferente|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoConferente saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrdemServicoConferente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoConferente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrdemServicoConferente findOrCreate($search, callable $callback = null, $options = [])
 */
class OrdemServicoConferentesTable extends Table
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
        

        $this->setTable('ordem_servico_conferentes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'conferente_id',
        ]);
        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
        ]);
        $this->belongsTo('Funcoes', [
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
            ->integer('create_by')
            ->requirePresence('create_by', 'create')
            ->notEmptyString('create_by');

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
        $rules->add($rules->existsIn(['ordem_servico_id'], 'OrdemServicos'));
        $rules->add($rules->existsIn(['conferente_id'], 'Usuarios'));

        return $rules;
    }
}
