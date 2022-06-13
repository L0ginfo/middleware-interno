<?php

namespace App\Model\Table;

use App\Model\Entity\LiberacoesCesv;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;
use Cake\Datasource\ConnectionManager;
use PDO;
use PDOException;
use App\Controller\Component\LogComponent;


/**
 * LiberacoesCesv Model
 */
class LiberacoesCesvTable extends Table
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

		$this->table('liberacoes_cesv');
		$this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('LogsTabelas');
        
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
    }    
    
    public function afterSave($created) 
    {
        $this->logLiberacoesCesv($created->data['entity']);
    }

    private function logLiberacoesCesv ($dados = null, $action = null) {

        $conexao = new LogComponent(new \Cake\Controller\ComponentRegistry());
        $db = $conexao->conecta_db_my_sql();
        if ($action == "D") {
            $acao = "D";
        } else {
            $sql = "select count(*) as count from l_liberacoes_cesv where l_id = " . $dados['id'];
            if (!$sql) {
                return;
            }
            $existe = false;
            $res = $db->query($sql);
            foreach ($res as $r) {
                if ($r['COUNT'] > 0) {
                    $existe = true;
                }
            }
            if ($existe) {
                $acao = "U";
            } else {
                $acao = "I";
            }
        }

        if ($dados['data_hora']) {
            if (getType($dados['data_hora']) != 'string') {
                $dados['data_hora'] = $dados['data_hora']->format("Y-m-d H:i:s");
            }
        }

        $usuario_id = $_SESSION['Auth']['User']['id'];
        $sql = "insert into l_liberacoes_cesv ("
                . 'acao,' .
                'data_hora,' .
                'usuario_id,' .
                'l_id,' .  
                'l_cesv,' .
                'l_observacao,' . 
                'l_data_hora,' . 
                'l_usuario_id) values (' .
                "'" . $acao . "', " .
                "now(), " .
                "" . $usuario_id . ", " .
                "" . $dados['id'] . ", " .
                "'" . $dados['cesv'] . "', " .
                "'" . $dados['observacao'] . "', " .
                "'" . $dados['data_hora'] . "', " .
                "" . $dados['usuario_id'] . ")";

        $db->query($sql);
    }

    public function afterDelete($deletado)
    {
        $this->logLiberacoesCesv($deletado->data['entity'], "D");
    }
}