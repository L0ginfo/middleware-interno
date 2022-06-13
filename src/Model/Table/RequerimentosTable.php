<?php

namespace App\Model\Table;

use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Requerimentos Model
 *
 * @property BelongsTo $Empresas
 * @property BelongsTo $Documentos
 * @property BelongsTo $NavioViagens
 * @property HasMany $Anexos
 * @property HasMany $CargaGerais
 * @property HasMany $Containers
 */
class RequerimentosTable extends Table {

    /**
     * Status
     * @var type 
     */
    public $status = [
        0 => 'Rascunho',
        1 => 'Finalizado pelo requerente',
        2 => 'Confirmado',
        3 => 'Integrado',
        4 => 'Entrada'
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('requerimentos');
        $this->displayField('numero_documento');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Documentos', [
            'foreignKey' => 'documento_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Procedencias', [
            'foreignKey' => 'procedencia_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('NavioViagens', [
            'foreignKey' => 'navio_viagem_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('TipoNaturezas', [
            'foreignKey' => 'tipo_natureza_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Lotes', [
            'foreignKey' => 'requerimento_id'
        ]);

        $this->hasMany('Agendamentos', [
            'foreignKey' => 'requerimento_id'
        ]);

        $this->belongsTo('cliente', [
            'className' => 'Empresas',
            'foreignKey' => 'cnpj_cliente',
            'bindingKey' => 'cnpj',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('despachante', [
            'className' => 'Empresas',
            'foreignKey' => 'cnpj_despachante',
            'bindingKey' => 'cnpj',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('representante', [
            'className' => 'Empresas',
            'foreignKey' => 'cnpj_representante',
            'bindingKey' => 'cnpj',
            'joinType' => 'LEFT',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');



        $validator
                ->notEmpty('nome_cnpj_cliente');

        $validator
                ->notEmpty('nome_cnpj_representante');

        $validator
                ->notEmpty('nome_cnpj_despachante');

        $validator
                ->allowEmpty('numero_documento');

        $validator
                ->allowEmpty('navio_viagem_id');

        $validator
                ->allowEmpty('data_emissao');


        $validator
                ->add('valor_cif', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('valor_cif');

        $validator
                ->allowEmpty('referencia_cliente');

        $validator
                ->allowEmpty('observacoes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['navio_viagem_id'], 'NavioViagens'));
        $rules->add(
                function ($entity, $options) {
            $empresas = TableRegistry::get('Empresas');
            return $empresas->exists(['cnpj' => $entity->cnpj_cliente]);
        }, ['errorField' => 'cnpj_cliente', 'message' => 'CNPJ não encontrado']
        );
        $rules->add(
                function ($entity, $options) {
            $empresas = TableRegistry::get('Empresas');
            return $empresas->exists(['cnpj' => $entity->cnpj_despachante]);
        }, ['errorField' => 'cnpj_despachante', 'message' => 'CNPJ não encontrado']
        );
        $rules->add(
                function ($entity, $options) {
            $empresas = TableRegistry::get('Empresas');
            return $empresas->exists(['cnpj' => $entity->cnpj_representante]);
        }, ['errorField' => 'cnpj_representante', 'message' => 'CNPJ não encontrado']
        );
        return $rules;
    }

}
