<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use App\Util\LgDbUtil;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vistorias Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\PessoasTable&\Cake\ORM\Association\BelongsTo $Pessoas
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\VistoriaTipoCargasTable&\Cake\ORM\Association\BelongsTo $VistoriaTipoCargas
 * @property \App\Model\Table\VistoriaAvariasTable&\Cake\ORM\Association\HasMany $VistoriaAvarias
 * @property \App\Model\Table\VistoriaFotosTable&\Cake\ORM\Association\HasMany $VistoriaFotos
 * @property \App\Model\Table\VistoriaItensTable&\Cake\ORM\Association\HasMany $VistoriaItens
 *
 * @method \App\Model\Entity\Vistoria get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vistoria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vistoria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vistoria|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vistoria saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vistoria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vistoria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vistoria findOrCreate($search, callable $callback = null, $options = [])
 */
class VistoriasTable extends Table
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
        

        $this->setTable('vistorias');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
        ]);
        $this->belongsTo('Pessoas', [
            'foreignKey' => 'pessoa_id',
        ]);
        $this->belongsTo('Veiculos', [
            'foreignKey' => 'veiculo_id',
        ]);
        $this->hasOne('VistoriaItensOne', [
            'className'  => 'VistoriaItens',
            'foreignKey' => 'vistoria_id',
            'propertyName' => 'vistoria_itens',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('VistoriaTipoCargas', [
            'foreignKey' => 'vistoria_tipo_carga_id',
        ]);
        $this->hasMany('VistoriaAvarias', [
            'foreignKey' => 'vistoria_id',
        ]);
        $this->hasMany('VistoriaFotos', [
            'foreignKey' => 'vistoria_id',
        ]);
        $this->hasMany('VistoriaItens', [
            'foreignKey' => 'vistoria_id',
        ]);
        $this->hasMany('VistoriaLacres', [
            'foreignKey' => 'vistoria_id',
        ]);
        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'ordem_servico_id',
        ]);
        $this->belongsTo('VistoriaTipos', [
            'foreignKey' => 'vistoria_tipo_id',
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
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->scalar('cpf_motorista')
            ->maxLength('cpf_motorista', 11)
            ->allowEmptyString('cpf_motorista');

        $validator
            ->scalar('placa')
            ->maxLength('placa', 15)
            ->allowEmptyString('placa');

        $validator
            ->dateTime('data_hora_vistoria')
            ->allowEmptyDateTime('data_hora_vistoria');

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
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['pessoa_id'], 'Pessoas'));
        $rules->add($rules->existsIn(['veiculo_id'], 'Veiculos'));
        $rules->add($rules->existsIn(['vistoria_tipo_carga_id'], 'VistoriaTipoCargas'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options) {

        $oParamIntegracaoVistoria = ParametroGeral::getParameterByUniqueName('PARAM_INTEGRACAO_FINAL_VISTORIA');

        if ($oParamIntegracaoVistoria) {
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoVistoria->id, [
                'oEntity' => $entity,
                'iStatus' => 2,
                'function' => 3
            ]);
    
            if ($oResponse->getStatus() != 200) {
                $entity->setErrors(['data_hora_fim' => [$oResponse->getMessage()]]);
                return false;
            }
        }
    }
}
