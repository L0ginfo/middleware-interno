<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use ReflectionClass;
use ReflectionMethod;
use PDO;
use PDOException;

class ClonarComponent extends Component 
{
	public $conn;

	/*  
	 * Metodo utilizado para se conectar a base "portal" do SQLServer
	 *
	 * como usar:
	 * use App\Controller\Component\ClonarComponent;
	 * $conexao = new ClonarComponent(new \Cake\Controller\ComponentRegistry());
     * $conn = $conexao->conecta_db_sql_server_clonar();
     * $sql = "select * from $tabela";
	 * $res = $conn->query($sql);
	 */
    public function conecta_db_sql_server_clonar() 
    {
        try {
            if (!isset($this->conn)) {
                $this->conn = new PDO(SQLSERVER_DSN_clone, SQLSERVER_USER_SA, SQLSERVER_PASS_SA);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            }
            return $this->conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}