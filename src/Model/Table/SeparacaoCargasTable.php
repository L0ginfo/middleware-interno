<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * SeparacaoCargas Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\SeparacaoSituacoesTable&\Cake\ORM\Association\BelongsTo $SeparacaoSituacoes
 * @property \App\Model\Table\SeparacaoCargaItensTable&\Cake\ORM\Association\HasMany $SeparacaoCargaItens
 * @property &\Cake\ORM\Association\HasMany $SeparacaoCargaOperadores
 *
 * @method \App\Model\Entity\SeparacaoCarga get($primaryKey, $options = [])
 * @method \App\Model\Entity\SeparacaoCarga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SeparacaoCarga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCarga|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoCarga saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SeparacaoCarga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCarga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SeparacaoCarga findOrCreate($search, callable $callback = null, $options = [])
 */
class SeparacaoCargasTable extends Table
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


        $this->setTable('separacao_cargas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ClientesLeft', [
            'className' => 'Empresas',
            'foreignKey' => 'cliente_id',
            'joinType' => 'LEFT',
            'propertyName' => 'cliente'
        ]);
        $this->belongsTo('SeparacaoSituacoes', [
            'foreignKey' => 'separacao_situacao_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('SeparacaoCargaItens', [
            'foreignKey' => 'separacao_carga_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->hasMany('SeparacaoCargaOperadores', [
            'foreignKey' => 'separacao_carga_id',
            'dependent' => true,
            'cascadeCallbacks' => true
        ]);
        $this->belongsToMany('OrdemServicos', [
            'foreignKey' => 'separacao_carga_id',
            'targetForeignKey' => 'ordem_servico_id',
            'joinTable' => 'ordem_servico_separacao_cargas',
        ]);

        $this->belongsTo('OrdemServicoSeparacaoCargas', [
            'foreignKey' => 'id',
            'bindingKey' => 'separacao_carga_id',
            'targetForeignKey' => 'id',
            'joinType' => 'INNER',
        ]);

        $this->belongsToMany('FormacaoCargas', [
            'foreignKey' => 'separacao_carga_id',
            'targetForeignKey' => 'formacao_carga_id',
            'joinTable' => 'formacao_carga_nf_pedidos',
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
            ->scalar('codigo_pedido')
            ->maxLength('codigo_pedido', 255)
            ->allowEmptyString('codigo_pedido');

        $validator
            ->scalar('numero_pedido')
            ->maxLength('numero_pedido', 255)
            ->allowEmptyString('numero_pedido');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->dateTime('data_recepcao')
            ->allowEmptyDateTime('data_recepcao');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['separacao_situacao_id'], 'SeparacaoSituacoes'));

        return $rules;
    }

    public function afterSaveCommit(Event $event, EntityInterface $oSeparacaoCarga, ArrayObject $options)
    {
        if (!$oSeparacaoCarga->id)
            return $oSeparacaoCarga;

        $oHistoricoSeparacaoCarga = null;
        $oTableHistorico = TableRegistry::getTableLocator()->get('HistoricoSeparacaoCargas');
        $sSeparacaoSituacao = '';

        if ($oSeparacaoCarga->separacao_situacao_id) {
            $oSeparacaoSituacao = TableRegistry::getTableLocator()->get('SeparacaoSituacoes')->find()
                ->where(['id' => $oSeparacaoCarga->separacao_situacao_id])
                ->first();

            $sSeparacaoSituacao = $oSeparacaoSituacao ? $oSeparacaoSituacao->descricao : 'NA';
        }

        if (!$oSeparacaoCarga->isNew())
            $oHistoricoSeparacaoCarga = $oTableHistorico->find()
                ->where([
                    'separacao_carga_id' => $oSeparacaoCarga->id,
                    'date_created' => new Time(date('Y-m-d'))
                ])
                ->first();

        $aData = [
            'codigo_pedido' => $oSeparacaoCarga->codigo_pedido,
            'numero_pedido' => $oSeparacaoCarga->numero_pedido,
            'separacao_carga_id' => $oSeparacaoCarga->id,
            'cliente_id' => $oSeparacaoCarga->cliente_id,
            'data_recepcao' => $oSeparacaoCarga->data_recepcao,
            'separacao_situacao' => $sSeparacaoSituacao,
            'created_at_original' => $oSeparacaoCarga->created_at,
            'updated_at_original' => $oSeparacaoCarga->updated_at,
            'date_created' => new Time(date('Y-m-d'))
        ];

        if (!$oHistoricoSeparacaoCarga) {
            $oHistoricoSeparacaoCarga = $oTableHistorico->newEntity();
        }else {
            $oHistoricoSeparacaoCarga->updated_at = (new Time(date('Y-m-d H:i:s')))->modify('+3 hours');
        }

        $oHistoricoSeparacaoCarga = $oTableHistorico->patchEntity($oHistoricoSeparacaoCarga, $aData);

        $oTableHistorico->save($oHistoricoSeparacaoCarga);
    }
}
