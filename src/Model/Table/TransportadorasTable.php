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
 * Transportadoras Model
 *
 * @method \App\Model\Entity\Transportadora get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transportadora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transportadora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transportadora|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transportadora saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transportadora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transportadora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transportadora findOrCreate($search, callable $callback = null, $options = [])
 */
class TransportadorasTable extends Table
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

        $this->setTable('transportadoras');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Paises', [
             'foreignKey' => 'pais_id',
        ]);


        // $this->belongsToMany('Transportadoras', [
        //     'foreignKey' => 'transportadora_id',
        //     'joinType' => 'INNER',
        // ]);

        $this->belongsToMany('Usuarios', [
            'className'=> 'Usuarios',
            'foreignKey' => 'transportadora_id',
            'targetForeignKey' => 'usuario_id',
            'through' => 'UsuarioTransportadoras'
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
            ->scalar('razao_social')
            ->maxLength('razao_social', 300)
            ->allowEmptyString('razao_social');

        $validator
            ->integer('ativo')
            ->allowEmptyString('ativo');

        return $validator;
    }

    public function beforeSave($model, $e)
    {
        $e->cnpj = str_replace(['.', '-'], ['', ''], $e->cnpj);
        
        return $e;
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
