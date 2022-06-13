<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EntradaSaidaFluxos Model
 *
 * @property \App\Model\Table\PassagensTable&\Cake\ORM\Association\BelongsTo $Passagens
 * @property &\Cake\ORM\Association\BelongsTo $Cancelas
 * @property &\Cake\ORM\Association\BelongsTo $Cancelas
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\BelongsTo $Programacoes
 * @property \App\Model\Table\BalancasTable&\Cake\ORM\Association\BelongsTo $Balancas
 * @property \App\Model\Table\BalancasTable&\Cake\ORM\Association\BelongsTo $Balancas
 * @property \App\Model\Table\EntradaSaidaFluxoFotosTable&\Cake\ORM\Association\HasMany $EntradaSaidaFluxoFotos
 *
 * @method \App\Model\Entity\EntradaSaidaFluxo get($primaryKey, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EntradaSaidaFluxo findOrCreate($search, callable $callback = null, $options = [])
 */
class EntradaSaidaFluxosTable extends Table
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
        

        $this->setTable('entrada_saida_fluxos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cancelas', [
            'foreignKey' => 'cancela_entrada_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Cancelas', [
            'foreignKey' => 'cancela_saida_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
        ]);
        $this->belongsTo('Balancas', [
            'foreignKey' => 'balanca_entrada_id',
        ]);
        $this->belongsTo('Balancas', [
            'foreignKey' => 'balanca_saida_id',
        ]);
        $this->hasMany('EntradaSaidaFluxoFotos', [
            'foreignKey' => 'entrada_saida_fluxo_id',
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
            ->dateTime('data_hora_entrada')
            ->allowEmptyDateTime('data_hora_entrada');

        $validator
            ->dateTime('data_hora_saida')
            ->allowEmptyDateTime('data_hora_saida');

        $validator
            ->integer('updated_by')
            ->allowEmptyString('updated_by');

        $validator
            ->scalar('tipo_fluxo_entrada')
            ->maxLength('tipo_fluxo_entrada', 255)
            ->allowEmptyString('tipo_fluxo_entrada');

        $validator
            ->scalar('tipo_fluxo_saida')
            ->maxLength('tipo_fluxo_saida', 255)
            ->allowEmptyString('tipo_fluxo_saida');

        $validator
            ->scalar('tipo_entrada')
            ->maxLength('tipo_entrada', 255)
            ->allowEmptyString('tipo_entrada');

        $validator
            ->scalar('tipo_saida')
            ->maxLength('tipo_saida', 255)
            ->allowEmptyString('tipo_saida');

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
        $rules->add($rules->existsIn(['cancela_entrada_id'], 'Cancelas'));
        $rules->add($rules->existsIn(['cancela_saida_id'], 'Cancelas'));
        $rules->add($rules->existsIn(['programacao_id'], 'Programacoes'));
        $rules->add($rules->existsIn(['balanca_entrada_id'], 'Balancas'));
        $rules->add($rules->existsIn(['balanca_saida_id'], 'Balancas'));

        return $rules;
    }
}
