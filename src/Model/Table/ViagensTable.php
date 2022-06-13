<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Viagens Model
 *
 * @property \App\Model\Table\TransportadorasTable&\Cake\ORM\Association\BelongsTo $Transportadoras
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 * @property \App\Model\Table\OperadoresTable&\Cake\ORM\Association\BelongsTo $Operadores
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\HasMany $Programacoes
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\HasMany $Resvs
 *
 * @method \App\Model\Entity\Viagem get($primaryKey, $options = [])
 * @method \App\Model\Entity\Viagem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Viagem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Viagem|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Viagem saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Viagem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Viagem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Viagem findOrCreate($search, callable $callback = null, $options = [])
 */
class ViagensTable extends Table
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
        

        $this->setTable('viagens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Transportadoras', [
            'foreignKey' => 'transportadora_id',
        ]);
        $this->belongsTo('TerminalOrigem', [
            'foreignKey' => 'terminal_origem_id',
            'joinType' => 'LEFT',
            'className' => 'Empresas', 
            'propertyName' => 'terminal_origem'
        ]);
        $this->belongsTo('TerminalDestino', [
            'foreignKey' => 'terminal_destino_id',
            'joinType' => 'LEFT',
            'className' => 'Empresas', 
            'propertyName' => 'terminal_destino'
        ]);
        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id',
        ]);
        $this->belongsTo('Operadores', [
            'foreignKey' => 'operador_id',
            'className'  => 'Usuarios'
        ]);
        $this->hasMany('Programacoes', [
            'foreignKey' => 'viagem_id',
        ]);
        $this->hasMany('Resvs', [
            'foreignKey' => 'viagem_id',
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
            ->scalar('codigo')
            ->maxLength('codigo', 255)
            ->allowEmptyString('codigo');

        $validator
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->allowEmptyString('descricao');

        $validator
            ->dateTime('previsao_chegada')
            ->allowEmptyDateTime('previsao_chegada');

        $validator
            ->integer('vagoes_cheios')
            ->allowEmptyString('vagoes_cheios');

        $validator
            ->integer('vagoes_vazios')
            ->allowEmptyString('vagoes_vazios');

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
        $rules->add($rules->existsIn(['transportadora_id'], 'Transportadoras'));
        $rules->add($rules->existsIn(['terminal_origem_id'], 'TerminalOrigem'));
        $rules->add($rules->existsIn(['terminal_destino_id'], 'TerminalDestino'));
        $rules->add($rules->existsIn(['modal_id'], 'Modais'));
        $rules->add($rules->existsIn(['operador_id'], 'Operadores'));

        return $rules;
    }
}
