<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Cake\Utility\Inflector;
use Migrations\Command\Dump;

class SeederUtil
{
    private static $sSql = '';
    private static $aParams = [];

    //Traduzindo nomes de tabelas
    private static $aTranslates = [
        'local' => 'locais',
        'produto_classificacao' => 'produto_classificacoes',
        'operador' => 'operadores',
        'integracao' => 'integracoes',
        'modal' => 'modais'
    ];

    /**
     * Recebe o nome da Seed a ser executada
     * @param $sSeederName
     * @deprecated
     */
    public static function execute($sSeederName)
    {
        //@deprecated
        return false;

        $dir_app = explode('src' . DS . 'Util', dirname(__FILE__))[0];
        $exec =  'cd ' . $dir_app . ' && .' . DS . 'vendor' . DS . 'bin' . DS . 'phinx seed:run -s ' . $sSeederName  . ' --configuration phinx.php 2>&1';

        //echo $dir_app . ' ' . $exec;

        try {
            $retorno = shell_exec($exec);
            echo '  == Início de execução de Seed ==
            
            ' . 
            $retorno .
            '  
            == Fim de execução de Seed ==
            
            ';

        } catch (\Throwable $th) {
            echo '"Não pode ser executada a Seed ------'.$sSeederName.'------ pelo motivo: "';
            var_dump($th);
        }
    }

    public static function canExecuteInsert($oThat, $aInsert, $aParams = [])
    {
        $oReturn = self::checkForeignKeys($oThat, $aInsert);
        $sLinha = '-----------------------------------------------------------------------------------------';
        $sMessage = 'Continuando Migrations, caso necessário, faça um rollback dessa migration!';

        if ($oReturn->getStatus() != 200){
            dump($oReturn, $sMessage);
            dump($sLinha);
            sleep(7);
            return false;
        }

        $oReturn = self::idExistsOnTable($oThat, $aInsert, 'insert'); 

        if ($oReturn->getStatus() != 200){
            dump($oReturn, $sMessage);
            dump($sLinha);
            sleep(7);
            return false;
        }

        return true;
    }

    public static function canExecuteUpdate($oThat, $aUpdate)
    {
        $oReturn = self::checkForeignKeys($oThat, $aUpdate); 
        $sLinha = '-----------------------------------------------------------------------------------------';
        $sMessage = 'Continuando Migrations, caso necessário, faça um rollback dessa migration!';

        if ($oReturn->getStatus() != 200){
            dump($oReturn, $sMessage);
            dump($sLinha);
            sleep(4);
            return false;
        }

        $oReturn = self::idExistsOnTable($oThat, $aUpdate, 'update'); 
        
        if ($oReturn->getStatus() != 200){
            dump($oReturn, $sMessage);
            dump($sLinha);
            sleep(4);
            return false;
        }
        
        if (isset($aUpdate['wheres']['id'])){
            $iID = $aUpdate['wheres']['id'];
            $aRows = self::checkIdOnTable($oThat, $aUpdate['table'], $iID);
            if (!$aRows){
                dump('O ID {'.$iID.'} usado para fazer o {UPDATE} não existe na tabela {'.$aUpdate['table'].'}!');
                dump($sLinha);
                dump($sMessage);
                sleep(4);
                return false;
            }
        }

        return true;
    }

    public static function idExistsOnTable($oThat, $aQuery, $sType)
    {
        $oResponse = new ResponseUtil;
        $sTable = $aQuery['table'];

        foreach ($aQuery['values'] as $key => $aValues) {
            if (isset($aValues['id'])){
                $aRows = self::checkIdOnTable($oThat, $sTable, $aValues['id']);

                if ($sType === 'insert'){
                    if ($aRows) 
                        return $oResponse->setMessage('A tabela {'. $sTable . '} já tem o ID {'.$aValues['id'].'}');
                }
                elseif ($sType === 'update'){
                    if (!$aRows) 
                        return $oResponse->setMessage('A tabela {'. $sTable . '} não tem o ID {'.$aValues['id'].'}');
                }
            }
        }
        
        return $oResponse->setMessage('OK')->setStatus(200);
    }

    private static function checkIdOnTable($oThat, $sTable, $uID)
    {

        if (is_array($uID) && $uID) {
            $uCondition = ' IN (' . implode(', ', $uID) . ')';
        }else {
            $uCondition = ' = '. $uID;
        }

        $sSql = 'SELECT 1 FROM ' . $sTable . ' WHERE id ' . $uCondition;
        $oStmt = $oThat->query($sSql);
        return $oStmt->fetchAll();
    }

    public static function checkForeignKeys($oThat, $aQuery)
    {
        $oResponse = new ResponseUtil;
        $aColumnDependencies = [];

        foreach ($aQuery['columns'] as $key => $sColumn) {
            $iPos = strpos($sColumn, '_id');
            
            if ($iPos !== false && $iPos === (strlen($sColumn) - 3) )
                $aColumnDependencies[] = $sColumn;
        }

        foreach ($aColumnDependencies as $sColumn) {

            $sColumn = str_replace('_id', '', $sColumn);

            if ((isset(self::$aParams['useInflectorPluralize']) && self::$aParams['useInflectorPluralize']) || !isset(self::$aParams['useInflectorPluralize'])) {
                
                $sTable = array_key_exists($sColumn, self::$aTranslates) 
                    ? self::$aTranslates[$sColumn] 
                    : Inflector::pluralize($sColumn);

                // $sTable = ucwords($sTable);
            } else {
                $sTable = $sColumn;
            }

            $aIDsInserir = [];

            foreach ($aQuery['values'] as $aQueryData) {
                $iForeignKeyID = $aQueryData[$sColumn.'_id'];
                
                $iID = isset($aQueryData['id']) ? $aQueryData['id'] : null;
                
                if ($iID)
                    $aIDsInserir[$iID] = true;

                if(!$iForeignKeyID)
                    continue;

                $oStmt = $oThat->query('SELECT 1 FROM ' . $sTable . ' WHERE id = ' . $iForeignKeyID);
                $aRows = $oStmt->fetchAll();
                
                if (!$aRows && (!isset($aIDsInserir[$iForeignKeyID]) && $sTable !== $aQuery['table'])) 
                    return $oResponse->setMessage('A tabela {'. $sTable . '} não tem o ID {'.$iForeignKeyID.'}');
            }
        }

        return $oResponse->setMessage('OK')->setStatus(200);
    }

    /**
     * insertOnMigrate
     * Modo de uso:
     * 
     * $data = [
     *      'table' => 'table',
     *      'columns' => ['column1', 'column2', 'column3'],
     *      'values' => [
     *          [
     *              'column1' => 1,
     *              'column2' => 'value2',
     *              'column3' => 'value3',
     *          ]
     *      ]
     *   ];
     **/
    public static function insertOnMigrate($oThat, $aInsert, $aParams = [])
    {
        self::$aParams = $aParams;
        $iCanExecute = self::canExecuteInsert($oThat, $aInsert);
        self::$sSql = '';
        
        if (!$iCanExecute)
            return false;

        // if (!in_array('id', $aInsert['columns']))
        self::beforeExecute($oThat, $aInsert['table'], 'OFF', $aInsert['columns']);
        
        try {
            foreach ($aInsert['values'] as $key => $value) {
                $oSql = $oThat->getQueryBuilder()
                    ->insert($aInsert['columns'])
                    ->into($aInsert['table'])
                    ->values($value);
                
                $aBindings = $oSql->__debugInfo()['params'];
                
                self::setSql($oSql->sql() . '; ', $aBindings);
            }
            // if (!in_array('id', $aInsert['columns']))
            self::afterExecute($oThat, $aInsert['table'], 'ON', $aInsert['columns']);

            return true;

        } catch (\Throwable $th) {
            self::afterExecute($oThat, $aInsert['table']);
            dd($th);
        }
    }


    /**
     * updateOnMigrate
     * Modo de uso:
     * 
     * $data = [
     *      'table' => 'table',
     *      'columns' => ['column1', 'column2', column3],
     *      'values' => [
     *          [
     *              'column1' => 1,
     *              'column2' => 'value2',
     *              'column3' => 'value3',
     *          ]
     *      ],
     *      'wheres' => [
     *          'column1' => 1,
     *          'column2' => 'value2',
     *          'column3' => 'value3',
     *      ]
     *   ];
     **/
    public static function updateOnMigrate($oThat, $aUpdate, $aParams = [])
    {
        self::$aParams = $aParams;
        $iCanExecute = self::canExecuteUpdate($oThat, $aUpdate);

        if (!$iCanExecute)
            return;

        self::beforeExecute($oThat, '', 'ON');

        try {
            $oBuilder = $oThat->getQueryBuilder();
            $oBuilder = $oBuilder->update($aUpdate['table']);

            foreach ($aUpdate['values'] as $key => $aSetProps) 
                foreach ($aSetProps as $sSetColumn => $uSetValue)
                    $oBuilder = $oBuilder->set($sSetColumn, $uSetValue);
            
            foreach ($aUpdate['wheres'] as $sWhereColumn => $uWhereValue) {
                $uCondition = self::getCondition($sWhereColumn, $uWhereValue);
                $oBuilder = $oBuilder->where($uCondition);
            }

            $oBuilder->execute();

            self::afterExecute($oThat, '', 'OFF');

            return true;

        } catch (\Throwable $th) {
            self::afterExecute($oThat, '', 'OFF');
            dd($th);
        }
    }

    private static function getCondition($sWhereColumn, $uWhereValue)
    {
        $uCondition = [$sWhereColumn => $uWhereValue];

        if (is_array($uWhereValue) && $uWhereValue) {
            $uCondition = $sWhereColumn . ' IN ("' . implode('", "', $uWhereValue) . '")';
        }

        return $uCondition;
    }

    public static function beforeExecute($oThat, $sTable = '', $sTypeIdentity = 'OFF', $aColumns = [])
    {
        $sAdapter = env('DB_ADAPTER', 'mysql');
        
        switch ($sAdapter) {
            case 'mysql':
                self::setSql('SET FOREIGN_KEY_CHECKS=0;');
            break;
            
            default:
            break;
        }
    }

    public static function afterExecute($oThat, $sTable = '', $sTypeIdentity = 'ON', $aColumns = [])
    {
        $sAdapter = env('DB_ADAPTER', 'mysql');
        
        switch ($sAdapter) {
            case 'mysql':
                self::setSql('SET FOREIGN_KEY_CHECKS=1;');
            break;
            
            default:
            break;
        }

        dump(self::getSql());
        sleep(0.5);
        $oThat->execute(self::getSql());
        self::$sSql = '';
    }

    private static function setSql($sSql, $aBindings = false)
    {
        if ($aBindings)
            $sSql = self::setBindings($sSql, $aBindings);


        self::$sSql .= ' ' . $sSql. ' ';
    }

    private static function setBindings($sSql, $aBindings)
    {
        foreach ($aBindings as $sBinding => $aBinding) {
            
            //if (((int) $aBinding['value']) == $aBinding['value']) {
                $sReplaceValue = $aBinding['value'];
            //}

            $sReplaceValue = addslashes($sReplaceValue);

            if($aBinding['value'] === NULL) {
                $sReplaceValue = 'NULL';
            }
            else{
                $sReplaceValue = "'" . $sReplaceValue . "'";
            }

            $sSql = str_replace([$sBinding.',', $sBinding.')'], [$sReplaceValue.',', $sReplaceValue.')'], $sSql);
        }

        return $sSql;
    }

    private static function getSql()
    {
        return self::$sSql;
    }
}