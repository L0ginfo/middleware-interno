<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Cake\Datasource\ConnectionManager;

class LgConnDbUtil 
{

    private $oConn;
    private $oQuery;
    private $aSelect;

    public function __construct($oConn)
    {
        $this->oConn = $oConn;
    }

    public function find($sTable){

        $this->aSelect = ['*'];

        $this->oQuery = $this
            ->oConn
            ->newQuery()
            ->from($sTable);

        return $this;
    }

    public function select($aSelect = ['*']){
        $this->aSelect = $aSelect;
        return $this;
    }

    public function where($aWhere = []){
        $this->oQuery->where($aWhere);
        return $this;
    }

    public function limit($value = 1){
        $this->oQuery->limit($value);
        return $this;
    }

    public function order($aOrder = []){
        $this->oQuery->order($aOrder);
        return $this;
    }

    public function toArray(){

        return $this->oQuery
            ->select($this->aSelect)
            ->execute()
            ->fetchAll('assoc');
    }

    public function first(){
        $aResult = $this->oQuery
            ->select($this->aSelect)
            ->limit(1)
            ->execute()
            ->fetchAll('assoc');

        if(empty($aResult)){
            return null;
        }

        return $aResult[0];
    }

    public function findAll($sTable, $aWhere = [], $aOrder = []){
        return $this->oConn
            ->newQuery()
            ->select('*')
            ->from($sTable)
            ->where($aWhere)
            ->order($aOrder)
            ->execute()
            ->fetchAll('assoc');
    }

    public function findFirst($sTable, $aWhere = [], $aOrder = []){
        $aResponse = $this->oConn
            ->newQuery()
            ->select('*')
            ->from($sTable)
            ->where($aWhere)
            ->order($aOrder)
            ->limit(1)
            ->execute()
            ->fetchAll('assoc');

        if(empty($aResponse)){
            return null;
        }

        return $aResponse[0];
    }

    public function save($sTable, $aData , $bIsNew = true){
        
        if($bIsNew){
            return $this->oConn->insert($sTable, $aData);
        }

        if(empty($aData['id'])){
            return false;
        }

        $aWhere = ['id' => $aData['id']];
        unset($aData['id']);

        return $this->oConn->update($sTable, $aData, $aWhere);
    }

    public function saveMany($sTable, $aDataMany, $isNew = true){

        if(empty($aDataMany)){
            return false;
        }

        $this->oConn->begin();

        foreach ($aDataMany as $aData) {
            if($isNew){
                $this->oConn->insert($sTable, $aData);
            }else{
                $aWhere = ['id' => $aData['id']];
                unset($aData['id']);
                $this->oConn->update($sTable, $aData, $aWhere);
            }
        }
        $this->oConn->commit();

    }

    public function update($sTable, $aData, $aWhere){

        if(empty($aWhere)){
            return false;
        }

        return $this->oConn->update($sTable, $aData, $aWhere);
    }

    public function delete($sTable, $aWhere){

        if(empty($aWhere)){
            return false;
        }

        return $this->oConn->delete($sTable, $aWhere);
    }


    public function insertRaw($sTable, $aData){

        if(empty($aData)){
            return false;
        }
        
        $sTable = $this->camel2dashed($sTable);
        $sKeys = implode(',', array_keys($aData));
        $sOptions = array_map(function($value){return '?';}, array_keys($aData));
        $sSql ="INSERT INTO $sTable ($sKeys) value ($sOptions)";
        return $this->oConn->execute($sSql, array_values($aData));
    }


    function camel2dashed($className) {
        return strtolower(preg_replace('/([A-Z])/', '-$1', $className));
    }


    public static function getConn(){
        return ConnectionManager::get('default');
    }
        
    
}