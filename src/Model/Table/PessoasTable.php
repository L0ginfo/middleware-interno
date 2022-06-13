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
 * Pessoas Model
 *
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\HasMany $Resvs
 *
 * @method \App\Model\Entity\Pessoa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pessoa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pessoa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pessoa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pessoa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pessoa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pessoa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pessoa findOrCreate($search, callable $callback = null, $options = [])
 */
class PessoasTable extends Table
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

        $this->setTable('pessoas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_id'
        ]);

        $this->hasMany('Resvs', [
            'foreignKey' => 'pessoa_id'
        ]);

        $this->hasMany('CredenciamentoPessoas', [
            'foreignKey' => 'pessoa_id'
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
            ->maxLength('descricao', 45)
            ->allowEmptyString('descricao');

        $validator
            ->scalar('nome_fantasia')
            ->maxLength('nome_fantasia', 45)
            ->allowEmptyString('nome_fantasia');

        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->allowEmptyString('cpf');

        $validator
            ->scalar('rg')
            ->maxLength('rg', 20)
            ->allowEmptyString('rg');

        $validator
            ->scalar('cnh')
            ->maxLength('cnh', 20)
            ->allowEmptyString('cnh');

        $validator
            ->date('cnh_validade')
            ->allowEmptyDate('cnh_validade');

        $validator
            ->integer('bloqueado')
            ->allowEmptyString('bloqueado');

        return $validator;
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
