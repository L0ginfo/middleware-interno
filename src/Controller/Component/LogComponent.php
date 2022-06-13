<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use ReflectionClass;
use ReflectionMethod;
use PDO;
use PDOException;

class LogComponent extends Component 
{
    public static $db = null;

	/*  
	 * Metodo utilizado para se conectar a base de dados do MYSql
	 *
	 * como usar:
	 * use App\Controller\Component\LogComponent;
	 * $conexao = new LogComponent(new \Cake\Controller\ComponentRegistry());
     * $conn = $conexao->conecta_db_my_sql();
     * $sql = "select * from $tabela";
	 * $res = $conn->query($sql);
	 */
    public function conecta_db_my_sql()
    {
        $host = '10.1.1.229';
        $base_dados = 'agendamento_dev';
        $root = 'loginfo';
        $password = '%Tkl153x.';

        if (self::$db) return self::$db;

        self::$db = new PDO("mysql:host=$host;dbname=$base_dados;charset=utf8",$root,$password);
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
        return self::$db;

    }
}