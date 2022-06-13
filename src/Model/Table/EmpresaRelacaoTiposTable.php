<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmpresaRelacaoTipos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\TiposEmpresasTable&\Cake\ORM\Association\BelongsTo $TiposEmpresas
 *
 * @method \App\Model\Entity\EmpresaRelacaoTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmpresaRelacaoTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmpresaRelacaoTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmpresaRelacaoTipo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpresaRelacaoTipo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpresaRelacaoTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmpresaRelacaoTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmpresaRelacaoTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class EmpresaRelacaoTiposTable extends Table
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
        

        $this->setTable('empresa_relacao_tipos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
        ]);
        $this->belongsTo('TiposEmpresas', [
            'foreignKey' => 'tipos_empresa_id',
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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['tipos_empresa_id'], 'TiposEmpresas'));

        return $rules;
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $oParamIntegracaoDadosEntidade = ParametroGeral::getParameterByUniqueName('PARAM_ENVIA_DADOS_ENTIDADE');

        if ($oParamIntegracaoDadosEntidade)
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoDadosEntidade->id, [
                'oEntity' => $entity
            ]);
    }

    public function beforeDelete(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $oParamIntegracaoDadosEntidade = ParametroGeral::getParameterByUniqueName('PARAM_ENVIA_DADOS_ENTIDADE');

        if ($oParamIntegracaoDadosEntidade)
            $oResponse = HandlerIntegracao::do(@$oParamIntegracaoDadosEntidade->id, [
                'oEntity' => $entity
            ]);
    }
}
