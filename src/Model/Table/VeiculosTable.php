<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Veiculos Model
 *
 * @property \App\Model\Table\ModaisTable&\Cake\ORM\Association\BelongsTo $Modais
 * @property &\Cake\ORM\Association\BelongsTo $Empresas
 * @property &\Cake\ORM\Association\BelongsTo $TipoVeiculos
 * @property &\Cake\ORM\Association\HasMany $FormacaoCargaVeiculos
 * @property &\Cake\ORM\Association\HasMany $FormacaoCargas
 * @property &\Cake\ORM\Association\HasMany $PesagemVeiculos
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\HasMany $Resvs
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsToMany $Resvs
 *
 * @method \App\Model\Entity\Veiculo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Veiculo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Veiculo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Veiculo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Veiculo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Veiculo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Veiculo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Veiculo findOrCreate($search, callable $callback = null, $options = [])
 */
class VeiculosTable extends Table
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

        $this->setTable('veiculos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Modais', [
            'foreignKey' => 'modal_id'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'armador_id',
        ]);
        $this->belongsTo('TipoVeiculos', [
            'foreignKey' => 'tipo_veiculo_id',
        ]);
        $this->hasMany('FormacaoCargaVeiculos', [
            'foreignKey' => 'veiculo_id',
        ]);
        $this->hasMany('FormacaoCargas', [
            'foreignKey' => 'veiculo_id',
        ]);
        $this->hasMany('PesagemVeiculos', [
            'foreignKey' => 'veiculo_id',
        ]);
        $this->hasMany('Resvs', [
            'foreignKey' => 'veiculo_id'
        ]);
        $this->belongsToMany('Resvs', [
            'foreignKey' => 'veiculo_id',
            'targetForeignKey' => 'resv_id',
            'joinTable' => 'resvs_veiculos'
        ]);
        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_id'
        ]);
        $this->hasMany('CredenciamentoVeiculos', [
            'foreignKey' => 'veiculo_id',
            'type' => 'LEFT'
        ]);
        $this->belongsTo('MarcaVeiculos', [
            'foreignKey' => 'marca_veiculo_id',
            'type' => 'LEFT'
        ]);
        $this->belongsTo('ModeloVeiculos', [
            'foreignKey' => 'modelo_veiculo_id',
            'type' => 'LEFT'
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
            ->allowEmptyString('descricao');

        $validator
            ->scalar('veiculo_identificacao')
            ->maxLength('veiculo_identificacao', 255)
            ->allowEmptyString('veiculo_identificacao');

        $validator
            ->scalar('imo')
            ->maxLength('imo', 15)
            ->allowEmptyString('imo');

        $validator
            ->decimal('loa')
            ->allowEmptyString('loa');

        $validator
            ->decimal('boca')
            ->allowEmptyString('boca');

        $validator
            ->scalar('bandeira')
            ->maxLength('bandeira', 255)
            ->allowEmptyString('bandeira');

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
        $rules->add($rules->existsIn(['modal_id'], 'Modais'));
        $rules->add($rules->existsIn(['armador_id'], 'Empresas'));
        $rules->add($rules->existsIn(['tipo_veiculo_id'], 'TipoVeiculos'));

        return $rules;
    }

    public function afterSave($event, $entity, $options) {

        $oParamIntegracaoCadatroVeiculo = ParametroGeral::getParameterByUniqueName('PARAM_ENVIA_DADOS_VEICULO');

        if ($oParamIntegracaoCadatroVeiculo)
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoCadatroVeiculo->id, [
                'oEntity' => $entity
            ]);
    }

    public function beforeDelete($event, $entity, $options) {

        $oParamIntegracaoCadatroVeiculo = ParametroGeral::getParameterByUniqueName('PARAM_ENVIA_DADOS_VEICULO');

        if ($oParamIntegracaoCadatroVeiculo)
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoCadatroVeiculo->id, [
                'oEntity' => $entity
            ]);
    }
}
