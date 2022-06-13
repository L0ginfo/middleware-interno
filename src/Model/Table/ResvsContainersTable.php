<?php
namespace App\Model\Table;

use App\Model\Entity\EntradaSaidaContainer;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResvsContainers Model
 *
 * @property \App\Model\Table\ContainersTable&\Cake\ORM\Association\BelongsTo $Containers
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 * @property \App\Model\Table\ResvsTable&\Cake\ORM\Association\BelongsTo $Resvs
 * @property \App\Model\Table\OperacoesTable&\Cake\ORM\Association\BelongsTo $Operacoes
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\LiberacoesDocumentaisTable&\Cake\ORM\Association\BelongsTo $LiberacoesDocumentais
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\BelongsTo $Bookings
 * @property \App\Model\Table\DocumentoGenericosTable&\Cake\ORM\Association\BelongsTo $DocumentoGenericos
 *
 * @method \App\Model\Entity\ResvsContainer get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResvsContainer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResvsContainer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResvsContainer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsContainer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResvsContainer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsContainer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResvsContainer findOrCreate($search, callable $callback = null, $options = [])
 */
class ResvsContainersTable extends Table
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
        

        $this->setTable('resvs_containers');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Resvs', [
            'foreignKey' => 'resv_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'cliente_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('LiberacoesDocumentais', [
            'foreignKey' => 'liberacao_documental_id',
        ]);
        $this->belongsTo('DriveEspacos', [
            'foreignKey' => 'drive_espaco_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('DocumentoGenericos', [
            'foreignKey' => 'documento_genericos_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ResvContainerLacres', [
            'foreignKey' => 'resv_container_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('OrdemServicos', [
            'foreignKey' => 'resv_id',
            'targetForeignKey' => 'resv_id',
            'bindingKey' => 'resv_id',
        ]);
        $this->belongsTo('ContainerFormaUsos', [
            'foreignKey' => 'container_forma_uso_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Beneficiarios', [
            'joinType' => 'LEFT',
            'className'=>'Empresas',
            'foreignKey' => 'beneficiario_id'
        ]);

        $this->hasOne('EntradaSaidaContainers', [
            'joinType' => 'LEFT',
            'foreignKey' => 'container_id',
            'bindingKey' => 'container_id',
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
        // $rules->add($rules->existsIn(['container_id'], 'Containers'));
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));
        $rules->add($rules->existsIn(['resv_id'], 'Resvs'));
        $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        $rules->add($rules->existsIn(['cliente_id'], 'Empresas'));
        $rules->add($rules->existsIn(['liberacao_documental_id'], 'LiberacoesDocumentais'));
        //$rules->add($rules->existsIn(['drive_espaco_id'], 'DriveEspacos'));
        $rules->add($rules->existsIn(['documento_genericos_id'], 'DocumentoGenericos'));

        return $rules;
    }

    public function afterSave(Event $event, EntityInterface $oResvsContainers, ArrayObject $options)
    {
        // $aDataOriginal = $oResvsContainers->extractOriginal($oResvsContainers->getDirty());
        // EntradaSaidaContainer::saveEntradaSaidaContainerFromResvsContainers($oResvsContainers, $aDataOriginal);
    }

    public function afterDelete(Event $event, EntityInterface $oResvsContainers, ArrayObject $options)
    {
        // EntradaSaidaContainer::deleteEntradaSaidaContainerFromResvsContainers($oResvsContainers);
    }
}
