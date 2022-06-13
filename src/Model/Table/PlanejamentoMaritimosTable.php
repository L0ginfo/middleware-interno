<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PlanejamentoMaritimos Model
 *
 * @property \App\Model\Table\SituacaoProgramacaoMaritimasTable&\Cake\ORM\Association\BelongsTo $SituacaoProgramacaoMaritimas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\BercosTable&\Cake\ORM\Association\BelongsTo $Bercos
 * @property \App\Model\Table\VeiculosTable&\Cake\ORM\Association\BelongsTo $Veiculos
 * @property \App\Model\Table\NcmsTable&\Cake\ORM\Association\BelongsTo $Ncms
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\TiposCargasTable&\Cake\ORM\Association\BelongsTo $TiposCargas
 * @property \App\Model\Table\TiposViagensTable&\Cake\ORM\Association\BelongsTo $TiposViagens
 * @property \App\Model\Table\SentidosTable&\Cake\ORM\Association\BelongsTo $Sentidos
 * @property \App\Model\Table\ProcedenciasTable&\Cake\ORM\Association\BelongsTo $Procedencias
 * @property \App\Model\Table\ProcedenciasTable&\Cake\ORM\Association\BelongsTo $Procedencias
 * @property \App\Model\Table\EventosTable&\Cake\ORM\Association\BelongsToMany $Eventos
 *
 * @method \App\Model\Entity\PlanejamentoMaritimo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimo|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimo saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PlanejamentoMaritimo findOrCreate($search, callable $callback = null, $options = [])
 */
class PlanejamentoMaritimosTable extends Table
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

        $this->setTable('planejamento_maritimos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('SituacaoProgramacaoMaritimas', [
            'foreignKey' => 'situacao_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Empresas', [
            'foreignKey' => 'faturar_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Bercos', [
            'foreignKey' => 'berco_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Veiculos', [
            'foreignKey' => 'navio_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Ncms', [
            'foreignKey' => 'ncm_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Afreteadores', [
            'className'=>'Empresas',
            'foreignKey' => 'afreteador_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clientes', [
            'className'=>'Empresas',
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Armadores', [
            'className'=>'Empresas',
            'foreignKey' => 'armador_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('AgenteArmadores', [
            'className'=>'Empresas',
            'foreignKey' => 'agente_armador_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('OperacaoPortuarias', [
            'className'=>'Empresas',
            'foreignKey' => 'oper_portuaria_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TiposCargas', [
            'foreignKey' => 'carga_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TiposViagens', [
            'foreignKey' => 'tipo_viagem_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sentidos', [
            'foreignKey' => 'sentido_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PortoOrigens', [
            'className'=>'Procedencias',
            'foreignKey' => 'porto_origem_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PortoDestinos', [
            'className'=>'Procedencias',
            'foreignKey' => 'porto_destino_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('PortoOrigensLeft', [
            'className'=>'Procedencias',
            'propertyName' => 'porto_origem',
            'foreignKey' => 'porto_origem_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('PortoDestinosLeft', [
            'className'=>'Procedencias',
            'propertyName' => 'porto_destino',
            'foreignKey' => 'porto_destino_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('PlanejamentoMaritimosEventos',[
            'foreignKey' => 'planejamento_maritimos_id',
            'joinType' => 'LEFT'
        ]);

        $this->hasMany('ResvPlanejamentoMaritimos',[
            'className' =>'ResvPlanejamentoMaritimos',
            'foreignKey' => 'planejamento_maritimo_id',
        ]);

        $this->hasMany('PlanoCargas',[
            'foreignKey' => 'planejamento_maritimo_id',
        ]);

        $this->hasMany('PlanejamentoMaritimoTernos',[
            'foreignKey' => 'planejamento_maritimo_id',
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
            ->scalar('numero')
            ->maxLength('numero', 45)
            ->requirePresence('numero', 'create')
            ->notEmptyString('numero');

        $validator
            ->scalar('viagem_numero')
            ->maxLength('viagem_numero', 45)
            ->requirePresence('viagem_numero', 'create')
            ->notEmptyString('viagem_numero');

        $validator
            ->integer('versao')
            ->requirePresence('versao', 'create')
            ->allowEmptyString('versao', null, 'create');

        $validator
            ->scalar('carpeta')
            ->maxLength('carpeta', 45)
            ->requirePresence('carpeta', 'create')
            ->notEmptyString('carpeta');

        $validator
            ->scalar('escala')
            ->maxLength('escala', 250)
            ->requirePresence('escala', 'create')
            ->notEmptyString('escala');

        $validator
            ->decimal('loa')
            ->requirePresence('loa', 'create')
            ->notEmptyString('loa');

        $validator
            ->boolean('fundeado')
            ->requirePresence('fundeado', 'create')
            ->notEmptyString('fundeado');

        $validator
            ->dateTime('data_fundeio')
            ->allowEmptyDateTime('data_fundeio');

        $validator
            ->date('data_registro')
            ->requirePresence('data_registro', 'create')
            ->notEmptyDate('data_registro');

        $validator
            ->scalar('observacao')
            ->allowEmptyString('observacao');

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
        $rules->add($rules->existsIn(['situacao_id'], 'SituacaoProgramacaoMaritimas'));
        $rules->add($rules->existsIn(['faturar_id'], 'Empresas'));
        $rules->add($rules->existsIn(['berco_id'], 'Bercos'));
        $rules->add($rules->existsIn(['navio_id'], 'Veiculos'));
        $rules->add($rules->existsIn(['ncm_id'], 'Ncms'));
        $rules->add($rules->existsIn(['afreteador_id'], 'Afreteadores'));
        $rules->add($rules->existsIn(['agente_armador_id'], 'Armadores'));
        $rules->add($rules->existsIn(['oper_portuaria_id'], 'OperacaoPortuarias'));
        $rules->add($rules->existsIn(['carga_id'], 'TiposCargas'));
        $rules->add($rules->existsIn(['tipo_viagem_id'], 'TiposViagens'));
        $rules->add($rules->existsIn(['sentido_id'], 'Sentidos'));
        $rules->add($rules->existsIn(['porto_origem_id'], 'PortoOrigens'));
        $rules->add($rules->existsIn(['porto_destino_id'], 'PortoDestinos'));
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));
        return $rules;
    }
}
