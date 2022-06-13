<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DriveEspacos Model
 *
 * @property \App\Model\Table\EmpresasTable&\Cake\ORM\Association\BelongsTo $Empresas
 * @property \App\Model\Table\ContainerTamanhosTable&\Cake\ORM\Association\BelongsTo $ContainerTamanhos
 * @property \App\Model\Table\TipoIsosTable&\Cake\ORM\Association\BelongsTo $TipoIsos
 * @property \App\Model\Table\OperacoesTable&\Cake\ORM\Association\BelongsTo $Operacoes
 * @property \App\Model\Table\DriveEspacoClassificacoesTable&\Cake\ORM\Association\BelongsTo $DriveEspacoClassificacoes
 * @property \App\Model\Table\DriveEspacoTiposTable&\Cake\ORM\Association\BelongsTo $DriveEspacoTipos
 * @property \App\Model\Table\UnidadeMedidasTable&\Cake\ORM\Association\BelongsTo $UnidadeMedidas
 * @property \App\Model\Table\ResvsContainersTable&\Cake\ORM\Association\HasMany $ResvsContainers
 *
 * @method \App\Model\Entity\DriveEspaco get($primaryKey, $options = [])
 * @method \App\Model\Entity\DriveEspaco newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DriveEspaco[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DriveEspaco|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DriveEspaco saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DriveEspaco patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DriveEspaco[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DriveEspaco findOrCreate($search, callable $callback = null, $options = [])
 */
class DriveEspacosTable extends Table
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
        

        $this->setTable('drive_espacos');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'armador_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('ContainerTamanhos', [
            'foreignKey' => 'conteiner_tamanho_id',
        ]);
        $this->belongsTo('TipoIsos', [
            'foreignKey' => 'tipo_iso_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Operacoes', [
            'foreignKey' => 'operacao_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('DriveEspacoClassificacoes', [
            'foreignKey' => 'drive_espaco_classificacao_id',
        ]);
        $this->belongsTo('DriveEspacoTipos', [
            'foreignKey' => 'drive_espaco_tipo_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UnidadeMedidas', [
            'foreignKey' => 'unidade_medida_id',
        ]);
        $this->hasMany('ResvsContainers', [
            'foreignKey' => 'drive_espaco_id',
        ]);
        $this->hasMany('DriveEspacoContainers', [
            'foreignKey' => 'drive_espaco_id',
        ]);
        $this->belongsTo('Clientes', [
            'className'=>'Empresas',
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('DriveEspacoTipoCargas', [
            'foreignKey' => 'drive_espaco_tipo_carga_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('ContainerFormaUsos', [
            'foreignKey' => 'container_forma_uso_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Beneficiarios', [
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
            ->scalar('descricao')
            ->maxLength('descricao', 255)
            ->requirePresence('descricao', 'create')
            ->notEmptyString('descricao');

        $validator
            ->integer('qtde_cnt_possivel')
            ->allowEmptyString('qtde_cnt_possivel');

        $validator
            ->decimal('qtde_carga_geral_possivel')
            ->allowEmptyString('qtde_carga_geral_possivel');

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
        $rules->add($rules->existsIn(['armador_id'], 'Empresas'));
        $rules->add($rules->existsIn(['conteiner_tamanho_id'], 'ContainerTamanhos'));
        $rules->add($rules->existsIn(['tipo_iso_id'], 'TipoIsos'));
        $rules->add($rules->existsIn(['operacao_id'], 'Operacoes'));
        $rules->add($rules->existsIn(['drive_espaco_classificacao_id'], 'DriveEspacoClassificacoes'));
        $rules->add($rules->existsIn(['drive_espaco_tipo_id'], 'DriveEspacoTipos'));
        $rules->add($rules->existsIn(['unidade_medida_id'], 'UnidadeMedidas'));

        return $rules;
    }
}
