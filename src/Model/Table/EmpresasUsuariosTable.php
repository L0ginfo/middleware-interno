<?php

namespace App\Model\Table;

use App\Model\Entity\EmpresasUsuario;
use App\RegraNegocio\Rfb\RfbManager;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

/**
 * EmpresasUsuarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Empresas
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 * @property \Cake\ORM\Association\BelongsTo $Perfis
 */
class EmpresasUsuariosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('empresas_usuarios');
        $this->displayField('empresa_id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        $this->belongsTo('Empresas', [
            'foreignKey' => 'empresa_id',
            'joinType' => 'right'
        ]);
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Perfis', [
            'foreignKey' => 'perfil_id',
            'joinType' => 'INNER'
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
                ->allowEmptyString('validade');

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
        $rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['perfil_id'], 'Perfis'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options) {
        $entity->nome = trim($entity->nome);
        RfbManager::doAction('rfb', 'representantes', 'init', $entity, [
            'nome_model' => 'Integracoes', 'tipo' => 'EmpresaUsuarios'
        ]);
    }

    public function beforeDelete($event, $entity, $options) {
        RfbManager::doAction('rfb', 'representantes', 'init', $entity, [
            'nome_model' => 'Integracoes', 'tipo' => 'EmpresaUsuarios', 'operacao' => 'delete'
        ]);
    }

}
