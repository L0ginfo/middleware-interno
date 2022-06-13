<?php
namespace App\Model\Table;

use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoDocumentoTransportes Model
 *
 * @property \App\Model\Table\ProgramacoesTable&\Cake\ORM\Association\BelongsTo $Programacoes
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 *
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoDocumentoTransporte findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoDocumentoTransportesTable extends Table
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
        

        $this->setTable('programacao_documento_transportes');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'joinType' => 'INNER',
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
        $rules->add($rules->existsIn(['programacao_id'], 'Programacoes'));
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));

        return $rules;
    }

    public function afterSave($event, $entity, $options)
    {
        RfbManager::doAction('rfb', 'acesso-veiculos', 'init', $entity, ['nome_model' => 'Integracoes', 'tipo' => 'ProgramacaoDocumentoTransportes']);
    }
}
