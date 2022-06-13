<?php
namespace App\Model\Table;

use App\Model\Entity\MapaTransacaoHistorico;
use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\SessionUtil;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mapas Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\DocumentosTransportesTable&\Cake\ORM\Association\BelongsTo $DocumentosTransportes
 * @property \App\Model\Table\TipoMapasTable&\Cake\ORM\Association\BelongsTo $TipoMapas
 * @property \App\Model\Table\MapaAnexosTable&\Cake\ORM\Association\HasMany $MapaAnexos
 *
 * @method \App\Model\Entity\Mapa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mapa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mapa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mapa|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mapa saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mapa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mapa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mapa findOrCreate($search, callable $callback = null, $options = [])
 */
class MapasTable extends Table
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
        

        $this->setTable('mapas');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('DocumentosTransportes', [
            'foreignKey' => 'documento_transporte_id',
            'joinType' => 'INNER',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsTo('DocumentosMercadorias', [
            'foreignKey' => 'documento_mercadoria_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('LiberadoPor', [
            'foreignKey' => 'liberado_por',
            'className' => 'Usuarios',
            'propertyName' => 'liberado_por',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('TipoMapas', [
            'foreignKey' => 'tipo_mapa_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'LEFT',
        ]);
        $this->hasMany('ItemContainers', [
            'foreignKey' => [
                'documento_transporte_id',
                // 'container_id'
            ],
            'bindingKey' => [
                'documento_transporte_id',
                // 'container_id'
            ],
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('VistoriaItens', [
            'foreignKey' => [
                'documento_transporte_id'
            ],
            'bindingKey' => [
                'documento_transporte_id'
            ],
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('MapaAnexos', [
            'foreignKey' => 'mapa_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('MapaAnexosInner', [
            'className' => 'MapaAnexos',
            'foreignKey' => 'mapa_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
            'propertyName' => 'mapa_anexos',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('MapaTransacaoHistoricos', [
            'foreignKey' => 'mapa_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->belongsTo('MapaProcessos', [
            'foreignKey' => 'mapa_processo_id',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'created_by',
            'joinType' => 'LEFT',
        ]);
        $this->belongsTo('Representantes', [
            'foreignKey' => 'representante_id',
            'className' => 'Usuarios',
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

        $validator
            ->scalar('madeira')
            ->maxLength('madeira', 255)
            ->allowEmptyString('madeira');

        $validator
            ->scalar('necessita_vistoria')
            ->maxLength('necessita_vistoria', 255)
            ->allowEmptyString('necessita_vistoria');

        $validator
            ->integer('vistoriado_por')
            ->allowEmptyString('vistoriado_por');

        $validator
            ->dateTime('vistoriado_em')
            ->allowEmptyDateTime('vistoriado_em');

        $validator
            ->integer('liberado_por')
            ->allowEmptyString('liberado_por');

        $validator
            ->dateTime('liberado_em')
            ->allowEmptyDateTime('liberado_em');

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
        $rules->add($rules->existsIn(['documento_transporte_id'], 'DocumentosTransportes'));
        $rules->add($rules->existsIn(['tipo_mapa_id'], 'TipoMapas'));

        return $rules;
    }

    public function afterSave($event, $entity, $options)
    {
        MapaTransacaoHistorico::consistencyStatusMapa(EntityUtil::getArrayColumnsModified($entity), $entity->id);
    }

    public function beforeSave($event, $entity, $options)
    {
        $aDataOriginal = $entity->extractOriginal($entity->getDirty());

        if (!array_key_exists('necessita_vistoria', $aDataOriginal))
            return;

        if ($entity->necessita_vistoria === $aDataOriginal['necessita_vistoria'])
           return;

        if ($entity->necessita_vistoria != 1) {
            $entity->liberado_por = SessionUtil::getUsuarioConectado();
            $entity->liberado_em = DateUtil::dateTimeToDB(date('Y-m-d H:i:s'));
        } elseif ($entity->necessita_vistoria == 1) {
            $entity->liberado_por = null;
            $entity->liberado_em = null;
        }
    }
}
