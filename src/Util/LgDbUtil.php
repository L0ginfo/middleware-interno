<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Cake\ORM\TableRegistry;

class LgDbUtil 
{
    public static function get($sTable)
    {
        return TableRegistry::getTableLocator()->get($sTable);
    }

    public static function getFind($sTable)
    {
        return TableRegistry::getTableLocator()->get($sTable)->find();
    }

    public static function getOrSaveNew($sTable, $aData)
    {
        $oEntity = LgDbUtil::getFirst($sTable, $aData);

        if ($oEntity)
            return $oEntity;

        return LgDbUtil::saveNew($sTable, $aData, true);
    }

    public static function saveNew($sTable, $aData, $bReturnEntity = false)
    {
        $oEntity = LgDbUtil::get($sTable)->newEntity($aData);

        $uResult = LgDbUtil::get($sTable)->save($oEntity);

        if ($bReturnEntity)
            return $oEntity;

        return $uResult;
    }

    public static function getFirst($sTable, $aData, $aOrder = [])
    {
        return LgDbUtil::getFind($sTable)->where($aData)->order($aOrder)->first();
    }

    public static function getLast($sTable, $aData, $aOrder = [])
    {
        return LgDbUtil::getFind($sTable)->where($aData)->order($aOrder)->last();
    }

    public static function getByID($sTable, $iID, $aOrder = [])
    {
        return LgDbUtil::getFind($sTable)->where(['id' => $iID])->order($aOrder)->first();
    }

    public static function save($sTable, $oEntity, $bReturnEntity = false)
    {
    
        $uResult = LgDbUtil::get($sTable)->save($oEntity);

        if ($bReturnEntity)
            return $oEntity;

        return $uResult;
    }

   
    public static function getAll($sTable, $aData, $aOrder = [], $aList = [], $aSelect = [])
    {
        if ($aList && $aSelect) {
            return LgDbUtil::get($sTable)
                ->find('list', $aList)
                ->select($aSelect)
                ->where($aData)
                ->order($aOrder)
                ->toArray();
        }


        return LgDbUtil::getFind($sTable)->where($aData)->order($aOrder)->toArray();
    }


    public static function duplicateEntity($sTable, $aWhere, $aUpdate = []){

        if(empty($sTable) || empty($aWhere)){
            return null;
        }

        $oEntity = LgDbUtil::getFind($sTable)
            ->where($aWhere)
            ->first();

        if(empty($oEntity)){
            return null;
        }

        try {
            if(!empty($aUpdate)) $oEntity = LgDbUtil::get($sTable)->patchEntity($oEntity, $aUpdate);
            $oNewEntity = LgDbUtil::get($sTable)->newEntity($oEntity->toArray());
            return LgDbUtil::get($sTable)->save($oNewEntity);
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * duplicateRalation function
     *
     * @param [int] $iIdOld old_father_id
     * @param [int] $iIdNew new_father_id
     * @param array $aOptions = [
     *      'table' => string,
     *      'id' => 'string'
     *      'children' = [
     *           [        
     *               'table' => string,
     *               'id' => 'string'
     *           ]
     *      ]
     * ]
     * @return array;
     */
    public static function duplicateRelationship($iIdOld, $iIdNew, $aOptions = []){

        $sTable = @$aOptions['table']?:''; 
        $sColumn  = @$aOptions['id']?:'';
        $aArray = [];

        if(empty($sTable) || empty($sColumn) || empty($iIdOld) || empty($iIdNew)){
            return $aArray;
        }

        $aEntities = LgDbUtil::getFind($sTable)->where([$sColumn => $iIdOld])->toArray();

        if(empty($aEntities)){
            return $aArray;
        }

        foreach ($aEntities as $oValue) {

            try {
                
                $aData = $oValue->toArray();
                $aData[$sColumn] = $iIdNew;
                $oEntity = LgDbUtil::get($sTable)->newEntity($aData);     
                $oSave = LgDbUtil::get($sTable)->save($oEntity);
                $aResultData['newEntity'] = $oSave;
                $aResultData['oldEntity'] = $oValue;
                $aResultData['children'] = [];
                if($oSave && isset($aOptions['children'])){
                    foreach ($aOptions['children'] as $aChild) {
                        $sChildTable = @$aChild['table'];
                        $aResultData['children'][$sChildTable] = LgDbUtil::duplicateRelationship($oValue->id, $oEntity->id, $aChild);
                    }
                }

                array_push($aArray, $aResultData);

            } catch (\Throwable $th) {
                //throw $th;
            }
            
        }

        return  $aArray;
    }

    public static function setConcatGroupByDb($sParam)
    {
        if (env('DB_ADAPTER', 'mysql') == 'mysql')
            return 'GROUP_CONCAT('.$sParam.')';

        return "STRING_AGG(CAST(".$sParam." AS NVARCHAR(MAX)), ',')";
    }

    /**
     * Esta função faz a atualização de registros no banco de dados da mesma forma que 
     * o updateAll nativo do CakePHP, com a diferença que este método salva 
     * no log_tabelas a alteração.
     */
    public static function updateAll($sTable, $aWhereFind, $aFieldsToUpdate)
    {
        $aRegisters = LgDbUtil::getAll($sTable, $aWhereFind);

        foreach ($aRegisters as $oRegister) {
            foreach ($aFieldsToUpdate as $sField => $sValue) {
                $oRegister->{$sField} = $sValue;
            }
        }

        return LgDbUtil::get($sTable)->saveMany($aRegisters);
    }

    /**
     * 
     */
    public static function deleteByID($sTable, $iID)
    {
        $aRegister = LgDbUtil::getByID($sTable, $iID);

        return LgDbUtil::get($sTable)->delete($aRegister);
    }

    public static function setDataFormatWhere($sCampo, $sOperador)
    {
        $aWhere = [];
        if (env('DB_ADAPTER', 'mysql') != 'mysql') {
            $aWhere = [
                "FORMAT(".$sCampo.", concat('yyyy-', upper('mm'), '-dd')) ".$sOperador."" => date('Y-m-d')
            ];
        } else {
            $aWhere = [
                $sCampo.' '. $sOperador => date('Y-m-d')
            ];
        }

        return $aWhere;
    }

    /**
     * Esta função faz a atualização de registros no banco de dados da mesma forma que 
     * o updateAll nativo do CakePHP, com a diferença que este método salva 
     * no log_tabelas a alteração.
     */
    public static function deleteAll($sTable, $aWhereFind)
    {
        $aRegisters = LgDbUtil::getAll($sTable, $aWhereFind);

        foreach ($aRegisters as $oRegister) {
            LgDbUtil::get($sTable)->delete($oRegister);
        }
    }

    public static function setOrderFormat($sCampo, $sOperador)
    {
        $aOrder = [];
        if (env('DB_ADAPTER', 'mysql') != 'mysql') {
            $aOrder = [
                $sCampo => $sOperador
            ];
        } else {
            $aOrder = [
                'CAST('.$sCampo.' as unsigned)' => $sOperador
            ];
        }

        return $aOrder;
    }
}