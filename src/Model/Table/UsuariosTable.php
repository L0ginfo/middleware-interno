<?php

namespace App\Model\Table;

use App\Model\Entity\Usuario;
use App\Util\LgDbUtil;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use ArrayObject;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;

/**
 * Usuarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Empresas
 * @property \Cake\ORM\Association\BelongsTo $Perfil
 * @property \Cake\ORM\Association\BelongsToMany $Empresas
 */
class UsuariosTable extends Table {

    public function conecta_db_sql_server()
    {
        try {
            $this->conn = new PDO(SQLSERVER_DSN, $_SESSION['SQLSERVER_USER'], $_SESSION['SQLSERVER_PASS']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('usuarios');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        // $this->addBehavior('Acl', ['type' => 'requester']);


        $this->belongsTo('Perfis', [
            'foreignKey' => 'perfil_id',
            'joinType' => 'INNER'
        ]);

        $aWhere = LgDbUtil::setDataFormatWhere('validade', '>=');
        $this->hasMany('EmpresasUsuarios', [
            //'through' => 'EmpresasUsuarios',
            'foreignKey' => 'usuario_id',
            //'targetForeignKey' => 'empresa_id',
            'joinTable' => 'empresas_usuarios',
            'conditions' => $aWhere
        ]);

        $this->hasMany('UsuarioTransportadoras', [
            'foreignKey' => 'usuario_id',
            'joinTable' => 'usuario_transportadoras',
        ]);

        $this->hasMany('UsuarioPessoas', [
            'foreignKey' => 'usuario_id',
            'joinTable' => 'usuario_pessoas',
        ]);

        $this->hasMany('UsuarioVeiculos', [
            'foreignKey' => 'usuario_id',
            'joinTable' => 'usuario_veiculos',
        ]);

        $this->hasMany('PlanejamentoMaritimoTernoUsuarios', [
            'foreignKey' => 'usuario_id',
        ]);


        $this->belongsToMany('PlanejamentoMaritimoTernos', [
            'className'=> 'PlanejamentoMaritimoTernos',
            'foreignKey' => 'empresa_id',
            'targetForeignKey' => 'planejamento_maritimo_terno_id',
            'through' => 'PlanejamentoMaritimoTernoUsuarios'
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
                ->requirePresence('email', 'create')
                ->notEmpty('email')
        ;

        $validator
                ->add('ativo', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('ativo');

        $validator
                ->requirePresence('cpf', 'create')
                ->notEmpty('cpf')
                ->add('cpf', 'unique', ['rule' => 'validateUnique', 'provider' => 'table',
                    'message' => 'CPF já utilizado.'])
        ;

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
        $rules->add($rules->existsIn(['perfil_id'], 'Perfis'));

        return $rules;
    }

    public function beforeSave($event, $entity, $options) {
        $entity->nome = trim($entity->nome);
    }

    public function afterSave($created)
    {

    }

    function beforeFind(Event $event, Query $query, $options, $primary) {
        return;
        if (strpos($query->sql(), 'existing') > 1) {
            return true;
            //validateUnique
        }


        if (@$_SESSION['Auth']['User']['perfil_id']) {

            if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_ADMIN ||
		$_SESSION['Auth']['User']['perfil_id'] == 14 ||
                    $_SESSION['Auth']['User']['perfil_id'] == PERFIL_TRIAGEM
                    // || $_SESSION['Auth']['User']['perfil_id'] == PERFIL_COMEX
            ) {
                //administrador
                return;
            }

            if ($_SESSION['Auth']['User']['perfil_id'] != PERFIL_ADMIN) {
                $list = '0';
                $lista = [];

                $_SESSION['empresasDoUsuarios'] = TableRegistry::getTableLocator()->get('EmpresasUsuarios')->find('all')
                    ->where([
                        'usuario_id' => $_SESSION['Auth']['User']['id']
                    ])
                    ->toArray();

                foreach ($_SESSION['empresasDoUsuarios'] as $e) {
                    if (!in_array($e['empresa']['id'], $lista)) {
                        $lista[] = $e['empresa']['id'];
                        $list .= ",'" . $e['empresa']['id'] . "'";
                    }
                }


                $empresasusuarios_master = TableRegistry::get('EmpresasUsuarios');
                if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_CLIENTE) {
                    $empresasusuarios_master_list = $empresasusuarios_master->find('all')
                            ->where([
                        " perfil_id in (" . PERFIL_CLIENTEVINCULADO . ',' . PERFIL_REPRESENTANTE_TRANSPORTADOR . ")",
                        ' empresa_id in (' . $list . ')'
                    ]);
                } else {
                    $empresasusuarios_master_list = $empresasusuarios_master->find('all')
                            ->where([
                        "( perfil_id  in (" . PERFIL_CLIENTEVINCULADO . ',' . PERFIL_REPRESENTANTE_TRANSPORTADOR . ')' . " and master = 0 )",
                        ' empresa_id in (' . $list . ')'
                    ]);
                }


                $usuarios_acesso = '0';
                $lista = [];
                //  debug($empresasusuarios_master_list);die();
                foreach ($empresasusuarios_master_list as $row) {
                    if (!in_array($row->usuario_id, $lista)) {
                        $lista[] = $row->usuario_id;
                        $usuarios_acesso .= "," . $row->usuario_id;
                    }
                }

                //debug($usuarios_acesso);                die();
                $conditions = $query->where(' ( Usuarios.id  in (' . $usuarios_acesso
                        . ',' . $_SESSION['Auth']['User']['id'] . ') or Usuarios.created_by = ' . $_SESSION['Auth']['User']['id'] . ')');
                //debug($conditions);                die();
            }
        }
    }

}
