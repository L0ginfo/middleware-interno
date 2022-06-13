<?php

class dbsara {

    public static $debug = false;

    public static $db = null;

    public static function get()
    {
        if (self::$db) return self::$db;

        //production
        $hostname = "BARRA-SQL01\TST";
        $username = "sa";
        $pw = "Barradorio2015";
        $dbname = "Sara_db";

        //teste
        // $hostname = "BARRA-SQL01\TST";
        // $username = "sa";
        // $pw = "Barradorio2015";
        // $dbname = "Sara_db";

        if (self::$debug) error_log('Conect string: '."sqlsrv:server=$hostname;Database=$dbname => $username");
        self::$db = new PDO("sqlsrv:server=$hostname;Database=$dbname", $username, $pw);
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
        return self::$db;
    }

    public static function beginTransaction()
    {
        $db = self::get();
        if (self::$debug) error_log('begin transaction');
        $stmt = $db->beginTransaction();
    }

    public static function rollBack()
    {
        $db = self::get();
        if (self::$debug) error_log('rollback');
        $stmt = $db->rollBack();
    }

    public static function commit()
    {
        $db = self::get();
        if (self::$debug) error_log('commit');
        $stmt = $db->commit();
    }


    public static function fetch($sql, $params = [])
    {
        $db = self::get();
        if (self::$debug) error_log(vsprintf(str_replace('?', "'%s'", $sql), $params));
        $stmt = $db->prepare($sql);
        if ($stmt->execute($params) && $stmt->columnCount())
            return $stmt->fetch(PDO::FETCH_ASSOC);
        else
            return [];
    }

    public static function fetchOne($sql, $params = [])
    {
        $db = self::get();
        if (self::$debug) error_log(vsprintf(str_replace('?', "'%s'", $sql), $params));
        $stmt = $db->prepare($sql);
        if ($stmt->execute($params) && $stmt->columnCount()) {
            $row = $stmt->fetch(PDO::FETCH_NUM);
            return $row[0];
        } else {
            return null;
        }
    }

    public static function fetchAll($sql, $params = [])
    {
        $db = self::get();
        if (self::$debug) error_log(vsprintf(str_replace('?', "'%s'", $sql), $params));

        $stmt =  $db->prepare($sql);
        if ($stmt->execute($params) && $stmt->columnCount())
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        else
            return [];
    }

    public static function fetchCol($sql, $params = [])
    {
        $db = self::get();
        if (self::$debug) error_log(vsprintf(str_replace('?', "'%s'", $sql), $params));

        $stmt =  $db->prepare($sql);
        if ($stmt->execute($params) && $stmt->columnCount())
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        else
            return [];
    }

    public static function fetchPairs($sql, $params = [])
    {
        // lembre-se de ter dois campos no retorno name e value
        $db = self::get();
        if (self::$debug) error_log(vsprintf(str_replace('?', "'%s'", $sql), $params));

        $stmt =  $db->prepare($sql);
        if ($stmt->execute($params) && $stmt->columnCount())
            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        else
            return [];
    }

    public static function exec($sql, $params = [])
    {
        $db = self::get();
        if (self::$debug) error_log(vsprintf(str_replace('?', "'%s'", $sql), $params));

        try {
            $stmt =  $db->prepare($sql);
            $ok = $stmt->execute($params);
            if ($ok) {

                do {
					// if (self::$debug) error_log('RS fetch');
                    if ($stmt->columnCount()) {
                        $rowset = $stmt->fetchAll();
                        if ($rowset) {
                            if (self::$debug) error_log(print_r($rowset, true));
                        }
                    }
                } while ($stmt->nextRowset());

                return [true, []];

            } else {
                throw new Exception('stmt->execute returned false');
            }

        } catch (Exception $e) {
            if (self::$debug) error_log($e->getMessage());
            return [false, $e->getMessage()];
        }
    }
}
