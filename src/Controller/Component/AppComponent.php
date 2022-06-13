<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use ReflectionClass;
use ReflectionMethod;

class AppComponent extends Component 
{
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
