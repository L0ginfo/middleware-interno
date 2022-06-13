<?php

class dbportal {

	public static $debug = false;

    public static $db = null;

    public static function get()
    {
        if (self::$db) return self::$db;

        self::$db = new PDO("mysql:host=10.1.1.229;dbname=agendamento_dev;charset=utf8", 'loginfo', '%Tkl153x.');
        self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_UPPER);
        return self::$db;
    }

    public static function sendMail($params)
    {
        $fields = [
            'PROFILE' => $params['PROFILE'],
            'TO_EMAIL' => $params['TO_EMAIL'],
            'SUBJECT' => $params['SUBJECT'],
            'MESSAGE' => $params['MESSAGE'],
            'DATE_PUBLISHED' => date('Y-m-d H:i:s'),
        ];

        if (isset($params['ATTACHS'])) $fields['ATTACHS'] = json_encode($params['ATTACHS']);
        if (isset($params['HTML'])) $fields['HTML'] = 1;

        self::insert('queue_email', $fields);
    }

    public static function insert($table, $fields)
    {
        $db = self::get();
        $keys = implode(', ', array_keys($fields));
        $values = str_repeat('?, ', count($fields)-1) . '?';
        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $params = array_values($fields);

        if (self::$debug) error_log(vsprintf(str_replace('?', "'%s'", $sql), $params));
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
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
