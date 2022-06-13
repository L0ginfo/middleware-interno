<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControleAcessoLogs Model
 *
 * @property \App\Model\Table\ControleAcessoControladorasTable&\Cake\ORM\Association\BelongsTo $ControleAcessoControladoras
 * @property \App\Model\Table\AreaDesTable&\Cake\ORM\Association\BelongsTo $AreaDes
 * @property \App\Model\Table\AreaParasTable&\Cake\ORM\Association\BelongsTo $AreaParas
 * @property \App\Model\Table\DirecaoControladorasTable&\Cake\ORM\Association\BelongsTo $DirecaoControladoras
 * @property \App\Model\Table\TipoAcessosTable&\Cake\ORM\Association\BelongsTo $TipoAcessos
 * @property \App\Model\Table\CredenciamentoPessoasTable&\Cake\ORM\Association\BelongsTo $CredenciamentoPessoas
 * @property \App\Model\Table\ControleAcessoEventosTable&\Cake\ORM\Association\BelongsTo $ControleAcessoEventos
 * @property &\Cake\ORM\Association\BelongsTo $ControleAcessoEquipamentos
 *
 * @method \App\Model\Entity\ControleAcessoLog get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControleAcessoLog newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControleAcessoLog[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControleAcessoLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoLog[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControleAcessoLog findOrCreate($search, callable $callback = null, $options = [])
 */
class ControleAcessoLogsTable extends Table
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
        

        $this->setTable('controle_acesso_logs');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('ControleAcessoControladoras', [
            'foreignKey' => 'controle_acesso_controladora_id',
        ]);
        $this->belongsTo('DeAreas', [
            'className'  => 'ControleAcessoAreas',
            'foreignKey' => 'area_de_id',
        ]);
        $this->belongsTo('ParaAreas', [
            'className'  => 'ControleAcessoAreas',
            'foreignKey' => 'area_para_id',
        ]);
        $this->belongsTo('DirecaoControladoras', [
            'foreignKey' => 'direcao_controladora_id',
        ]);
        $this->belongsTo('TipoAcessos', [
            'foreignKey' => 'tipo_acesso_id',
        ]);
        $this->belongsTo('CredenciamentoPessoas', [
            'foreignKey' => 'credenciamento_pessoa_id',
        ]);
        $this->belongsTo('ControleAcessoEventos', [
            'foreignKey' => 'controle_acesso_evento_id',
        ]);
        $this->belongsTo('ControleAcessoEquipamentos', [
            'foreignKey' => 'controle_acesso_equipamento_id',
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
            ->scalar('ip')
            ->maxLength('ip', 255)
            ->allowEmptyString('ip');

        $validator
            ->scalar('liberado')
            ->maxLength('liberado', 1)
            ->allowEmptyString('liberado');

        $validator
            ->scalar('cracha')
            ->maxLength('cracha', 255)
            ->allowEmptyString('cracha');

        $validator
            ->scalar('mensagem')
            ->maxLength('mensagem', 255)
            ->allowEmptyString('mensagem');

        $validator
            ->dateTime('data_hora')
            ->allowEmptyDateTime('data_hora');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['controle_acesso_controladora_id'], 'ControleAcessoControladoras'));
        $rules->add($rules->existsIn(['area_de_id'], 'DeAreas'));
        $rules->add($rules->existsIn(['area_para_id'], 'ParaAreas'));
        $rules->add($rules->existsIn(['direcao_controladora_id'], 'DirecaoControladoras'));
        $rules->add($rules->existsIn(['tipo_acesso_id'], 'TipoAcessos'));
        $rules->add($rules->existsIn(['credenciamento_pessoa_id'], 'CredenciamentoPessoas'));
        $rules->add($rules->existsIn(['controle_acesso_evento_id'], 'ControleAcessoEventos'));
        $rules->add($rules->existsIn(['controle_acesso_equipamento_id'], 'ControleAcessoEquipamentos'));

        return $rules;
    }
}
