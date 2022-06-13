<?php
namespace App\Model\Table;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProgramacaoContainers Model
 *
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 * @property &\Cake\ORM\Association\BelongsTo $Programacoes
 * @property \App\Model\Table\OperacoesTable&\Cake\ORM\Association\BelongsTo $Operacoes
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 * @property \App\Model\Table\DocumentoGenericosTable&\Cake\ORM\Association\BelongsTo $DocumentoGenericos
 * @property \App\Model\Table\DriveEspacosTable&\Cake\ORM\Association\BelongsTo $DriveEspacos
 * @property \App\Model\Table\ProgramacaoContainerLacresTable&\Cake\ORM\Association\HasMany $ProgramacaoContainerLacres
 *
 * @method \App\Model\Entity\ProgramacaoContainer get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProgramacaoContainer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoContainer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProgramacaoContainer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProgramacaoContainer findOrCreate($search, callable $callback = null, $options = [])
 */
class ProgramacaoContainersTable extends Table
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
        

        $this->setTable('programacao_containers');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
        ]);
        $this->belongsTo('Programacoes', [
            'foreignKey' => 'programacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id',
        ]);
        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
        ]);
        $this->belongsTo('DocumentoGenericos', [
            'foreignKey' => 'documento_genericos_id',
        ]);
        $this->belongsTo('DriveEspacos', [
            'foreignKey' => 'drive_espaco_id',
        ]);
        $this->hasMany('ProgramacaoContainerLacres', [
            'dependent' => true,
            'foreignKey' => 'programacao_container_id',
        ]);
        $this->belongsTo('ContainerDestinos', [
            'foreignKey' => 'container_destino_id',
        ]);
        $this->belongsTo('Beneficiarios', [
            'joinType' => 'LEFT',
            'className'=>'Empresas',
            'foreignKey' => 'beneficiario_id'
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
            ->scalar('tipo')
            ->requirePresence('tipo', 'create')
            ->notEmptyString('tipo');

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
        $rules->add($rules->existsIn(['container_id'], 'Containers'));
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));
        $rules->add($rules->existsIn(['programacao_id'], 'Programacoes'));
        $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));
        $rules->add($rules->existsIn(['documento_genericos_id'], 'DocumentoGenericos'));
        //$rules->add($rules->existsIn(['drive_espaco_id'], 'DriveEspacos'));

        return $rules;
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew() && $entity->tipo == 'VAZIO' && $entity->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga')
            && ParametroGeral::getParametroWithValue('AGEN_VAZIO_APROVACAO')) {
            $oProgramacao = LgDbUtil::getByID('Programacoes', $entity->programacao_id);
            $oProgramacao->programacao_situacao_id = EntityUtil::getIdByParams('ProgramacaoSituacoes', 'descricao', 'Aguardando aprovação');
            LgDbUtil::save('Programacoes', $oProgramacao);
        }
    }

    public function beforeDelete(Event $event, EntityInterface $oProgramacaoContainer, ArrayObject $options)
    {
        if (ParametroGeral::getParametroWithValue('AGEN_VAZIO_APROVACAO')) {
            $aProgramacaoContainers = LgDbUtil::getFind('ProgramacaoContainers')
                ->where([
                    'programacao_id' => $oProgramacaoContainer->programacao_id,
                    'tipo' => 'VAZIO',
                    'id <>' => $oProgramacaoContainer->id
                ])
                ->toArray();

            if (!$aProgramacaoContainers) {
                $oProgramacao = LgDbUtil::getByID('Programacoes', $oProgramacaoContainer->programacao_id);
                $oProgramacao->programacao_situacao_id = null;
                LgDbUtil::save('Programacoes', $oProgramacao);
            }
        }
            
    }
}
