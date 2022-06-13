<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Phinx\Db\Adapter\MysqlAdapter;

class MigrationUtil
{
    private static $PATTERN_DECIMAL = ['precision' => 18, 'scale' => 6];

    public static function getDecimalPattern($aAdditional = [])
    {
        return self::$PATTERN_DECIMAL + $aAdditional;
    }

    public static function getNullPattern($aAdditional = [])
    {
        return ['null' => true] + $aAdditional;
    }

    public static function getArrayLongTextByDb()
    {
        if (env('DB_ADAPTER', 'mysql') == 'mysql')
            return ['null' => true, 'limit' => MysqlAdapter::TEXT_LONG];

        return ['null' => true];   
    }

    public static function getJsonByDb()
    {
        return env('DB_ADAPTER', 'mysql') == 'mysql' ? 'json' : 'text';
    }

    public static function addTimestamps($oThatMigration, $sTable)
    {
        $oThatMigration->table($sTable)
            ->addColumn('created_at', 'datetime', MigrationUtil::getNullPattern(['default' => 'CURRENT_TIMESTAMP']))
            ->addColumn('modified_at', 'datetime', MigrationUtil::getNullPattern(['update' => 'CURRENT_TIMESTAMP']))
            ->save();
    }
}
