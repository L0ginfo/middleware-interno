<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use ReflectionClass;
use ReflectionMethod;
use PDO;
use PDOException;

class PostgreComponent extends Component 
{
	public static $conn;

    public static function getInstance() 
    {
        try {
            if (!isset(self::$conn)) {
                self::$conn = new PDO(POSTGRE_DSN, POSTGRE_USER, POSTGRE_PASS);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
            }
            return self::$conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function query ($sql)
    {
        $db = self::getInstance();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getLastEvent ($operacao)
    {
        $sql =  "SELECT Max(t_event.id) AS event_id, t_event.gate_id AS gate, Max(t_event.data_inicio) AS inicio 
                 FROM t_event 
                 WHERE t_event.gate_id IN (" . $operacao .") AND t_event.data_inicio <= '" . date("Y-m-d H:i:s") . "'
                 GROUP BY t_event.gate_id";

        $retorno = self::query($sql);
        return $retorno['EVENT_ID'];
    }
}
