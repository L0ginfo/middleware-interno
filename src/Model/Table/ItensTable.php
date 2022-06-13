<?php

namespace App\Model\Table;

use App\Model\Entity\Item;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Itens Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Embalagens
 * @property \Cake\ORM\Association\BelongsTo $CodigoOnus
 * @property \Cake\ORM\Association\BelongsTo $Containers
 * @property \Cake\ORM\Association\BelongsTo $Lotes
 * @property \Cake\ORM\Association\HasMany $ItemAgendamentos
 * @property \Cake\ORM\Association\HasMany $LotesEntradas
 */
class ItensTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('itens');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Embalagens', [
            'foreignKey' => 'embalagem_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CodigoOnus', [
            'foreignKey' => 'codigo_onu_id',
            'joinType' => 'left'
        ]);
        $this->belongsTo('Containers', [
            'foreignKey' => 'container_id',
            'joinType' => 'left'
        ]);
        $this->belongsTo('Lotes', [
            'foreignKey' => 'lote_id',
            'joinType' => 'left'
        ]);
        $this->hasMany('ItemAgendamentos', [
            'foreignKey' => 'item_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('ncm', 'create')
                ->notEmpty('ncm');

        $validator
                ->requirePresence('embalagem_id', 'create')
                ->notEmpty('embalagem_id');

        $validator
                ->allowEmpty('ncm_descricao');

        $validator
                ->allowEmpty('descricao');
        $validator
                ->allowEmpty('codigo');

        $validator
                ->allowEmpty('codigo_referencia');

        $validator
                ->allowEmpty('descricao_produto');

        $validator
                ->requirePresence('peso_liquido', 'create')
                ->notEmpty('peso_liquido');

        $validator
                ->requirePresence('peso_bruto', 'create')
                ->notEmpty('peso_bruto');

        $validator
                ->requirePresence('quantidade', 'create')
                ->notEmpty('quantidade');


        $validator->add('peso_bruto', [
            'validaMaior' => [
                'rule' => 'validaMaior',
                'provider' => 'table',
                'message' => 'Valor menor que peso liquido'
            ]
        ]);

        // $validator->add('codigo_onu_id', [
        //     'validaIMO' => [
        //         'rule' => 'validaIMO',
        //         'provider' => 'table',
        //         'message' => 'Terminal não possui esta habilidação. Entre em contato com o COMEX'
        //     ]
        // ]);

        $validator->add('controlado', [
            'validacontrolado' => [
                'rule' => 'validaControlado',
                'provider' => 'table',
                'message' => 'Não possui liberado para recebimento desse tipo de mercadoria. Favor enviar solicitação para comex@barradorio.com.br'
            ]
        ]);


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['embalagem_id'], 'Embalagens'));
        return $rules;
    }

    public function validaMaior($check, $context) {

        $bruto = str_replace('.', '', $context['data']['peso_bruto']);
        $bruto = str_replace(',', '.', $bruto);

        $liquido = str_replace('.', '', $context['data']['peso_liquido']);
        $liquido = str_replace(',', '.', $liquido);

        if ($bruto >= $liquido)
            return true;
        else
            return false;
    }

    public function validaIMO($check, $context) {

        if (!$context['data']['codigo_onu_id'] || $context['data']['codigo_onu_id'] == 10)
            return true;
        else
            return false;
    }

    public function validaControlado($check, $context) {

        if ($context['data']['controlado'] == 'Sim')
            return false;
        else
            return true;
    }

    public function beforeSave($event, $entity, $options) {


        $bruto = str_replace('.', '', $entity->peso_bruto);
        $bruto = str_replace(',', '.', $bruto);

        $liquido = str_replace('.', '', $entity->peso_liquido);
        $liquido = str_replace(',', '.', $liquido);

        $quantidade = str_replace('.', '', $entity->quantidade);
        $quantidade = str_replace(',', '.', $quantidade);


        if ($entity->dirty('quantidade')) {
            $entity->quantidade = $quantidade;
        }
        if ($entity->dirty('peso_bruto')) {
            $entity->peso_bruto = $bruto;
        }
        if ($entity->dirty('peso_liquido')) {
            $entity->peso_liquido = $liquido;
        }
    }

}
