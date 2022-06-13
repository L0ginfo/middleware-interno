<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PesagemVeiculoRegistros Model
 *
 * @property \App\Model\Table\BalancasTable&\Cake\ORM\Association\BelongsTo $Balancas
 * @property \App\Model\Table\PesagemVeiculosTable&\Cake\ORM\Association\BelongsTo $PesagemVeiculos
 * @property \App\Model\Table\PesagemTiposTable&\Cake\ORM\Association\BelongsTo $PesagemTipos
 * @property \App\Model\Table\PesagensTable&\Cake\ORM\Association\BelongsTo $Pesagens
 *
 * @method \App\Model\Entity\PesagemVeiculoRegistro get($primaryKey, $options = [])
 * @method \App\Model\Entity\PesagemVeiculoRegistro newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculoRegistro[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculoRegistro|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PesagemVeiculoRegistro saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PesagemVeiculoRegistro patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculoRegistro[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PesagemVeiculoRegistro findOrCreate($search, callable $callback = null, $options = [])
 */
class PesagemVeiculoRegistrosTable extends Table
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
        

        $this->setTable('pesagem_veiculo_registros');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Balancas', [
            'foreignKey' => 'balanca_id',
        ]);
        $this->belongsTo('PesagemVeiculos', [
            'foreignKey' => 'pesagem_veiculo_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsTo('PesagemTipos', [
            'foreignKey' => 'pesagem_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Pesagens', [
            'foreignKey' => 'pesagem_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT',
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
            ->decimal('peso')
            ->allowEmptyString('peso');

        $validator
            ->integer('manual')
            ->allowEmptyString('manual');

        $validator
            ->scalar('balanca_codigo')
            ->maxLength('balanca_codigo', 255)
            ->allowEmptyString('balanca_codigo');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

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
        // $rules->add($rules->existsIn(['balanca_id'], 'Balancas'));
        $rules->add($rules->existsIn(['pesagem_veiculo_id'], 'PesagemVeiculos'));
        $rules->add($rules->existsIn(['pesagem_tipo_id'], 'PesagemTipos'));
        $rules->add($rules->existsIn(['pesagem_id'], 'Pesagens'));

        return $rules;
    }

    public function afterSave($event, $entity, $options) 
    {
        RfbManager::doAction('rfb', 'pesagem-veiculos-cargas', 'init', $entity, ['nome_model' => 'Integracoes']);  
    }

    public function beforeDelete($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'pesagem-veiculos-cargas', 'init', $entity, ['nome_model' => 'Integracoes', 'operacao' => 'delete']);
    }
    
}
