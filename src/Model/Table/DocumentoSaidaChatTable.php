<?php

namespace App\Model\Table;

use App\Model\Entity\DocumentoSaidaChat;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use App\Controller\Component\ClonarComponent;
// use App\Controller\Component\AppComponent;

/**
 * DocumentoSaidaChat Model
 */
class DocumentoSaidaChatTable extends Table
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

		$this->table('documento_saida_chat');
		$this->displayField('id');
        $this->primaryKey('id');
        
        $this->addBehavior('LogsTabelas');

		$this->belongsTo('DocumentoSaida', [
			'foreignKey' => 'id_documento_saida',
			'joinType' => 'INNER'
		]);

		$this->belongsTo('Usuarios', [
			'foreignKey' => 'id_usuario',
			'joinType' => 'INNER'
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
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create');

		$validator
			->requirePresence('id_documento_saida', 'create')
			->notEmpty('id_documento_saida');

		$validator
			->requirePresence('id_usuario', 'create')
			->notEmpty('id_usuario');

		$validator
			->requirePresence('conversation', 'create')
			->notEmpty('conversation');

		$validator
			->requirePresence('date_time', 'create')
			->notEmpty('date_time');

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
        $rules->add($rules->existsIn(['id_usuario'], 'Usuarios'));
        $rules->add($rules->existsIn(['id_documento_saida'], 'DocumentoSaida'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
    	$entity->date_time = date('Y-m-d H:i:s');
    }

    public function afterSave($created) 
    {
        $this->clonar($created->data['entity']);
    }

    /*
     * Metodo clonar()
     * @param $dados 
     *
     * Verifica os campos e salva na $tabela da base de dados Portal do SQLServer
     */
    private function clonar($dados) 
    {
        $tabela = 'documento_saida_chat';
        $campos_data = ['date_time'];
        $campos = ['id',
            'id_documento_saida',
            'id_usuario',
            'nome_usuario',
            'conversation',
        ];

        $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
        $conn = $conexao->conecta_db_sql_server_clonar();
        $sql = "select count(*) as count from $tabela where id = " . $dados['id'];
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
        }
    }

    /*
     * Metodo formataData()
     * @param $data
     *
     * Formata os $campos_data que vem do metodo clonar() para ficar no padrao do SQLServer
     */
    private function formataData($data) 
    {
        if (!$data) {
            return null;
        }
        $m = explode("/", $data);
        if (count($m) > 1) {
            return implode("-", array_reverse(explode("/", $data)));
        }
        return date("Y-m-d H:i:s", strtotime($data));
    }
}