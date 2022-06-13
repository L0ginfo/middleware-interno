<?php

namespace App\Model\Table;

use App\Model\Entity\Perfil;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * Perfis Model
 *
 * @property \Cake\ORM\Association\HasMany $EmpresasUsuarios
 * @property \Cake\ORM\Association\HasMany $Usuarios
 */
class PerfisTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        //$this->addBehavior('Acl.Acl', ['type' => 'requester']);

        $this->table('perfis');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        //$this->addBehavior('Muffin/Footprint.Footprint'); // modified_by and created_by

        $this->belongsToMany('EmpresasUsuarios', [
            //'foreignKey' => 'perfil_id'
            'through' => 'EmpresasUsuarios',
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
                ->requirePresence('nome', 'create')
                ->notEmpty('nome');

        $validator
                ->allowEmpty('descricao');

        return $validator;
    }

    function beforeFind(Event $event, Query $query, $options, $primary) {
        return;
        //   debug($_SESSION);

        if (isset($_SESSION) && isset($_SESSION['Auth']) && isset($_SESSION['Auth']['User'])) {
            if (!$_SESSION['Auth'] || $_SESSION['Auth']['User']['perfil_id'] == PERFIL_ADMIN || $_SESSION['Auth']['User']['perfil_id'] == 14 
            // || $_SESSION['Auth']['User']['perfil_id'] == PERFIL_COMEX
            ) {
                //administrador
                return;
            }
/*
            if ($_SESSION['Auth']['User']['perfil_id'] != PERFIL_ADMIN) {
                $conditions = $query->where('Perfis.id  in (' . PERFIL_CLIENTEVINCULADO . ',' . PERFIL_REPRESENTANTE_TRANSPORTADOR . ',' . $_SESSION['Auth']['User']['perfil_id'] . ') ');
            }*/
        }


        //  debug($conditions);        die();
    }

}
