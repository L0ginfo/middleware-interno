<?php

namespace App\Model\Table;

use App\Model\Entity\Lote;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use App\Controller\Component\ClonarComponent;

/**
 * Lotes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TipoConhecimentos
 * @property \Cake\ORM\Association\BelongsTo $Moedas
 * @property \Cake\ORM\Association\BelongsTo $Paises
 * @property \Cake\ORM\Association\HasMany $Anexos
 * @property \Cake\ORM\Association\HasMany $CargaGerais
 * @property \Cake\ORM\Association\HasMany $Containers
 * @property \Cake\ORM\Association\HasMany $ItemAgendamentos
 * @property \Cake\ORM\Association\HasMany $Itens
 * @property \Cake\ORM\Association\BelongsToMany $Entradas
 */
class LotesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('lotes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');

        /*$this->belongsTo('Empresas', [
            'foreignKey' => 'cnpj_cliente',
            'bindingKey' => 'cnpj',
            'joinType' => 'INNER'
        ]);*/

        $this->belongsTo('Procedencias', [
            'foreignKey' => 'procedencia_id',
            'joinType' => 'INNER'
        ]);
/*
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

        $this->belongsTo('agenteMaster', [
            'className' => 'Empresas',
            'foreignKey' => 'cnpj_agente_master',
            'bindingKey' => 'cnpj',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('empresaParceiracnpj', [
            'className' => 'Empresas',
            'foreignKey' => 'cnpj_parceiro',
            'bindingKey' => 'cnpj',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('empresaParceira', [
            'className' => 'Empresas',
            'foreignKey' => 'empresa_parceira_comercial_id',
            'bindingKey' => 'id',
            'joinType' => 'LEFT',
        ]);*/

        $this->belongsTo('TipoConhecimentos', [
            'foreignKey' => 'tipo_conhecimento_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TipoNaturezas', [
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Moedas', [
            'foreignKey' => 'moeda_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Paises', [
            'foreignKey' => 'pais_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Recintos', [
            'foreignKey' => 'recinto_id',
            'joinType' => 'left'
        ]);
        $this->hasMany('Anexos', [
            'foreignKey' => 'lote_id'
        ]);
        $this->hasMany('CargaGerais', [
            'foreignKey' => 'lote_id'
        ]);

        $this->hasMany('Pendencias', [
            'foreignKey' => 'id_modelo',
            'joinType' => 'LEFT',
            'conditions' => ['modelo' => 'Lotes'],
            'order' => 'PendenciaTipos.peso ASC',
        ]);

        $this->hasMany('Containers', [
            'joinType' => 'left'
        ]);

        $this->hasMany('ItemAgendamentos', [
            'foreignKey' => 'lote_id'
        ]);
        $this->hasMany('Itens', [
            'foreignKey' => 'lote_id'
        ]);
        $this->belongsToMany('Entradas', [
            'foreignKey' => 'lote_id',
            'targetForeignKey' => 'entrada_id',
            'joinTable' => 'entradas_lotes'
        ]);
              $this->belongsTo('faturamento_usuario', [
            'className' => 'Usuarios',
            'foreignKey' => 'faturamento_usuario_id',
            'joinType' => 'LEFT'
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
                ->requirePresence('conhecimento', 'create')
                ->notEmpty('conhecimento');

        $validator
                ->add('data_conhecimento', 'valid', ['rule' => ['date', 'dmy']])
                ->notEmpty('data_conhecimento');

        $validator
                ->requirePresence('ce_mercante', 'create')
                ->allowEmpty('ce_mercante');

        $validator
                ->requirePresence('codigo_viagem_sara', 'create')
                ->notEmpty('codigo_viagem_sara');

        $validator
                ->allowEmpty('referencia_cliente');

        $validator
                ->requirePresence('pais_id', 'create')
                ->notEmpty('pais_id');

        $validator
                ->requirePresence('valor_fob', 'create')
                ->notEmpty('valor_fob');

        $validator
                ->requirePresence('valor_frete', 'create')
                ->notEmpty('valor_frete');

        $validator
                ->requirePresence('valor_seguro', 'create')
                ->notEmpty('valor_seguro');



        $validator
                ->requirePresence('quantidade', 'create')
                ->notEmpty('quantidade');

        $validator
                ->requirePresence('peso_bruto', 'create')
                ->notEmpty('peso_bruto');

        $validator
                ->requirePresence('peso_liquido', 'create')
                ->notEmpty('peso_liquido');


        $validator
                ->requirePresence('cemaster', 'create')
                ->allowEmpty('cemaster');


        $validator
                ->allowEmpty('familia_codigo');

        $validator
                ->requirePresence('recinto_id', 'create')
                ->notEmpty('recinto_id');

        $validator->add('peso_bruto', [
            'validaMaior' => [
                'rule' => 'validaMaior',
                'provider' => 'table',
                'message' => 'Valor menor que peso liquido'
            ]
        ]);

        $validator->add('peso_bruto', [
            'validaMaiorZero' => [
                'rule' => 'validaMaiorZero',
                'provider' => 'table',
                'message' => 'Valor inválido'
            ]
        ]);

        $validator->add('peso_liquido', [
            'validaMaiorZero' => [
                'rule' => 'validaMaiorZero',
                'provider' => 'table',
                'message' => 'Valor inválido'
            ]
        ]);

        $validator->add('quantidade', [
            'validaMaiorZero' => [
                'rule' => 'validaMaiorZero',
                'provider' => 'table',
                'message' => 'Valor inválido'
            ]
        ]);

        $validator->add('ce_mercante', [
            'validaCE' => [
                'rule' => 'validaCE',
                'provider' => 'table',
                'message' => 'Deverá conter 15 caracteres'
            ]
        ]);

        $validator->add('cemaster', [
            'validaCE' => [
                'rule' => 'validaCE',
                'provider' => 'table',
                'message' => 'Deverá conter 15 caracteres'
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
        $rules->add($rules->existsIn(['tipo_conhecimento_id'], 'TipoConhecimentos'));
        $rules->add($rules->existsIn(['moeda_id'], 'Moedas'));
       // $rules->add($rules->existsIn(['pais_id'], 'Paises'));

        $rules->add($rules->existsIn(['tipo_natureza_id'], 'TipoNaturezas'));
        /*$rules->add($rules->existsIn(['empresa_id'], 'Empresas'));
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
        );*/
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

    public function validaMaiorZero($check, $context) {

        $valor = str_replace('.', '', $check);
        $valor = str_replace(',', '.', $valor);

        if ($valor > 0)
            return true;
        else
            return false;
    }

    public function beforeSave($event, $entity, $options) {
        $bruto = str_replace(',', '.', $entity->peso_bruto);

        $liquido = str_replace(',', '.', $entity->peso_liquido);

        $quantidade = str_replace(',', '.', $entity->quantidade);

        if (!$entity->valor_cif) {
            $entity->valor_cif = $entity->valor_seguro + $entity->valor_frete + $entity->valor_fob;
        }

        $entity->quantidade = $quantidade;
        $entity->peso_bruto = $bruto;
        $entity->peso_liquido = $liquido;

        $entity->ce_mercante = trim($entity->ce_mercante);
        $entity->cemaster = trim($entity->cemaster);
        $entity->modified = date('Y-m-d H:i:s');
    }

    public function afterSave($created) {

        $this->clonar($created->data['entity']);
    }

    function beforeFind(Event $event, Query $query, $options, $primary) {

        $empresasUsuariosTable = TableRegistry::get('EmpresasUsuarios');
        $empresasUsuarios = $empresasUsuariosTable->find('all')->contain(['Empresas'])->where(['usuario_id' => $_SESSION['Auth']['User']['id']])->toArray();

        // debug($_SESSION['Auth']['User'] );die();
        $perfilSemFiltro = [PERFIL_ADMIN, PERFIL_COMERCIAL, 14, 24, PERFIL_ARMAZEM, PERFIL_CPO, PERFIL_COMEX];
        if (in_array($_SESSION['Auth']['User']['perfil_id'], $perfilSemFiltro)) {        
            //administrador
            return;
        }

        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_CLIENTE) {
            //cliente
            $list = '0';
            foreach ($empresasUsuarios as $e) {
                $list .= ",'" . $e['empresa']['cnpj'] . "'";
            }
            $conditions = $query->where('cnpj_cliente  in (' . $list . ')');
            return;
        }

        //   debug($empresasUsuarios);        die();
        if (!in_array($_SESSION['Auth']['User']['perfil_id'], [PERFIL_CLIENTE, PERFIL_PARCEIRO_COMERCIAL, PERFIL_AGENTE])) {
            $list_despachantes = '0';
            $list_cliente = '0';
            foreach ($empresasUsuarios as $e) {
                if ($e['perfil_id'] == PERFIL_CLIENTE) {
                    $list_cliente .= ",'" . $e['empresa']['cnpj'] . "'";
                }
                if ($e['perfil_id'] == PERFIL_DESPACHANTE) {
                    $list_despachantes .= ",'" . $e['empresa']['cnpj'] . "'";
                }
            }
            // debug($list_despachantes);   debug($list_cliente);        die();
            ///  $conditions = $query->where('cnpj_cliente  in (' . $list . ')');
            $conditions = $query->where('cnpj_cliente  in (' . $list_cliente . ') and cnpj_despachante  in (' . $list_despachantes . ')');
        }
        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_PARCEIRO_COMERCIAL) { //parceiro comercial
            $list = '-1';
            foreach ($empresasUsuarios as $e) {
                $list .= ",'" . $e['empresa']['cnpj'] . "'";
            }

            $list_despachante = '0';
            foreach ($empresasUsuarios as $e) {
                $list_despachante .= ",'" . $e['empresa']['cnpj'] . "'";
            }



            $list_parceiro = '-1';
            foreach ($empresasUsuarios as $e) {
                //  debug($e);die();
                if ($e['perfil_id'] == PERFIL_PARCEIRO_COMERCIAL)
                    $list_parceiro .= ",'" . $e['empresa']['id'] . "'";
            }
            // $conditions = $query->where(' ( empresa_parceira_comercial_id  in (' . $list_parceiro . ') or cnpj_parceiro  in (' . $list . ') or ( cnpj_cliente  in (' . $list . ') and cnpj_despachante  in (' . $list_despachante . ')))');
            //  $conditions = $query->where(' ( empresa_parceira_comercial_id  in (' . $list_parceiro . ') or cnpj_parceiro  in (' . $list . ') or ( cnpj_cliente  in (' . $list . ') and cnpj_despachante  in (' . $list_despachante . ')))');
            $conditions = $query->where(' ( empresa_parceira_comercial_id  in (' . $list_parceiro . ') or cnpj_parceiro  in (' . ( $list ? $list : '-2') . ') )');
        }

        if ($_SESSION['Auth']['User']['perfil_id'] == PERFIL_AGENTE) { //parceiro comercial
            $list = '0';
            foreach ($empresasUsuarios as $e) {
                $list .= ",'" . $e['empresa']['cnpj'] . "'";
            }


            $conditions = $query->where('( (lcl= 1 and cnpj_agente_master  in (' . $list . ') ) or (lcl = 0 and cnpj_representante   in (' . $list . ') ) )');
        }
        //    debug($conditions);       die();
    }

    public function validaCE($check, $context) {

        if (!$check || strlen(trim($check)) == '15')
            return true;
        else
            return false;
    }

    private function clonar($dados) {

        $tabela = 'lotes';
        $campos_data = ['data_conhecimento'];
        $campos = ['id',
            'tipo_natureza_id',
            'tipo_conhecimento_id',
            'conhecimento',
            'ce_mercante',
            'referencia_cliente',
            'moeda_id',
            'valor_cif',
            'valor_fob',
            'valor_frete',
            'valor_seguro',
            'peso_liquido',
            'peso_bruto',
            'quantidade',
            'familia_codigo',
            'pais_id',
            'cnpj_representante',
            'cnpj_despachante',
            'cnpj_destinatario',
            'codigo_viagem_sara',
            'nome_viagem_sara',
            'procedencia_id',
            'cnpj_cliente',
            'cfop',
            'serie',
            'mbl',
            'cemaster',
            'recinto_id',
            'lcl',
            'gerado_lote',
            'sincronizado_em',
            'cnpj_agente_master',
            'cnpj_agente_faturamento',
            'enviado_email_concluido',
            'anexo_valido',
            'comentario_anexo',
            'cnpj_parceiro',
            'oculto',
            'cnpjadquirente',
            'nome_adquirente',
            'fatura_adquirente',
            'empresa_parceira_comercial_id',
            'ref_cliente',
            'cadastrado',
            'entrada',
        ];

        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();

        $sql = "select count(*) as count from $tabela   where id = " . $dados['id'];

        $existe = false;
        $res = $conn->query($sql);
        if (!$res) {
            return;
        }

        foreach (@$res as $i => $v) {
            if ($v['count'] > 0) {
                $existe = true;
            }
        }


        if (!@$dados['cnpjadquirente']) {
            @$dados['cnpjadquirente'] = 'NA';
        }

        if ($existe) {
            $sql_campos = '';
            foreach ($campos as $i) {
                $sql_campos .= (@$sql_campos ? ' , ' : '' );
                $sql_campos .= " $i = '" . $dados[$i] . "' ";
            }

            foreach ($campos_data as $i) {
                if ($dados->dirty($i)) {
                    $sql_campos .= (@$sql_campos ? ' , ' : '' );
                    $sql_campos .= "$i = '" . $this->formataData($dados[$i]) . "' ";
                }
            }
            $sql = "update $tabela set " . $sql_campos . ' where id = ' . $dados['id'];
            $conn->query($sql);


            //debug($sql);die();
        } else {
            $sql_campos = '';
            $sql_valor = '';
            foreach ($campos as $i) {
                @$sql_valor .= (@$sql_valor ? ' , ' : '' );
                $sql_valor .= "'" . $dados[$i] . "' ";
                $sql_campos .= (@$sql_campos ? ' , ' : '' );
                $sql_campos .= $i;
            }

            foreach ($campos_data as $i) {
                if ($dados->dirty($i)) {

                    @$sql_valor .= (@$sql_valor ? ' , ' : '' );
                    @$sql_valor .= "'" . $this->formataData($dados[$i]) . "' ";
                    @$sql_campos .= (@$sql_campos ? ' , ' : '' );
                    $sql_campos .= $i;
                }
            }
            $sql = "insert into $tabela  (" . $sql_campos . ' ) VALUES ( ' . $sql_valor . ")";
            $conn->query($sql);
        };
    }

    private function formataData($data) {
        if (!$data) {
            return null;
        }
        $m = explode("/", $data);
        if (count($m) > 1) {
            return implode("-", array_reverse(explode("/", $data)));
        }
        return date("Y-m-d H:i:s", strtotime($data));
    }

    /*
     * Metodo afterDelete
     * @param $deletado
     *
     * Apos deletar do MySQL ele deleta do SQLServer tambem
     */
    public function afterDelete($deletado)
    {
        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();

        if (@$deletado->data['entity']->id) {
            $sql = "DELETE lotes 
                    WHERE id = " . $deletado->data['entity']->id;
        }

        $conn->query($sql);
    }

}
