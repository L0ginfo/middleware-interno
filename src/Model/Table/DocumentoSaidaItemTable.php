<?php

namespace App\Model\Table;

use App\Model\Entity\DocumentoSaidaItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PDO;
use PDOException;
use App\Controller\Component\ClonarComponent;

/**
 * DocumentoSaidaItem Model
 */
class DocumentoSaidaItemTable extends Table
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

		$this->table('documento_saida_item');
		$this->displayField('id');
        $this->primaryKey('id');
        
        $this->addBehavior('LogsTabelas');

		$this->belongsTo('DocumentoSaida', [
			'foreignKey' => 'documento_saida_id',
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
			->requirePresence('documento_saida_id', 'create')
			->notEmpty('documento_saida_id');

		$validator
			->requirePresence('latu_lote', 'create')
			->notEmpty('latu_lote');

		$validator
			->requirePresence('latu_item', 'create')
			->notEmpty('latu_item');

		$validator
			->requirePresence('diitem_qt_lib', 'create')
			->notEmpty('diitem_qt_lib');

		$validator
			->requirePresence('diitem_qt_averb', 'create')
			->notEmpty('diitem_qt_averb');

		$validator
			->requirePresence('diitem_dent_id', 'create')
			->notEmpty('diitem_dent_id');

		$validator
			->requirePresence('cnt_id', 'create')
			->notEmpty('cnt_id');

		return $validator;
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
        $tabela = 'documento_saida_item';
        $campos_data = ['liberado_em'];
        $campos = ['id',
            'documento_saida_id',
            'latu_lote',
            'lote_conhec',
            'latu_item',
            'diitem_qt_lib',
            'diitem_qt_averb',
            'diitem_dent_id',
            'cnt_id',
            'diitem_descricao',
            'liberado_por_nome',
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
            $sql = "DELETE documento_saida_item 
                    WHERE id = " . $deletado->data['entity']->id;
        }

        $conn->query($sql);
    }
    
}