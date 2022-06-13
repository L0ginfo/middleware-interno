<?php

namespace LogPluginIntegrador;

use Util\Core\ResponseUtil;
use Cake\Datasource\ConnectionManager;
use LogPluginIntegrador\Util\AdapterUtil;
use Util\Core\ObjectUtil;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use DateTime;

class Integracoes {
    protected $oConn;
    protected $aData;
    protected $oIntegracao;
    protected $aParameters;
    protected $aErrors = [];

    function __construct($oIntegracao, $aParameters = null) {
        if($oIntegracao->tipo == 'Database'){
            try {
                ConnectionManager::drop('integracao');
                ConnectionManager::config('integracao', [
                    'className' => 'Cake\Database\Connection',
                    'driver' => 'Cake\Database\Driver\Sqlserver',
                    'persistent' => false,
                    'host' => $oIntegracao->db_host,
                    'port' => $oIntegracao->db_porta,
                    'database' => $oIntegracao->db_database,
                    'username' => $oIntegracao->db_user,
                    'password' => $oIntegracao->db_pass,
                    'timezone' => 'UTC',
                ]);
                $this->oConn = ConnectionManager::get('integracao');
            } catch (\Throwable $th) {
                $this->oConn = null;
            }
        }

        $this->aParameters = $aParameters;
        $this->oIntegracao = $oIntegracao;
    }

    public function requestDataAPI($aParameters) {
        $aHeader = ObjectUtil::getAsArray(json_decode($this->oIntegracao->json_header));
        $oHttp = new Client(['headers' => $aHeader]);
        $oResponse = $oHttp->post($this->oIntegracao->url_endpoint, json_encode($aParameters), ['type'=>'json']);
        $this->saveLogIntegracao($this->oIntegracao, json_encode($aParameters), $oResponse->body, $oResponse->code);
        return ObjectUtil::getAsArray(json_decode($oResponse->body));
    }

    public function request($sUrl, $aData = null, $aHeader = false, $bCompleteUrl = false){
        $requestUrl = $bCompleteUrl ?: $this->oIntegracao->url_endpoint.$sUrl;
        $aHeader = $aHeader ?: ObjectUtil::getAsArray(json_decode($this->oIntegracao->json_header));
        $oHttp = new Client(['headers' => $aHeader]);
        $oResponse = $oHttp->post($requestUrl, json_encode($aData), ['type'=>'json']);
        $this->saveLogIntegracao($this->oIntegracao, json_encode($aData), $oResponse->body, $oResponse->code);
        return $oResponse;
    }

    public function getParameters() {
        return $this->aParameters;
    }

    /**
     * getConn function
     *
     * @return Cake\Database\Connection
     */
    public function getConn(){
        return $this->oConn;
    }

    public function setParameters($aParameters) {
        $this->aParameters = $aParameters;
        return $this;
    }

    public function setData($aRequest) {
        $this->aData = $aRequest;
        return $this;
    }

    public function getData() {
        return $this->aData;
    }

    public function setError($aError) {
        $this->aErrors[] = $aError;
        return $this;
    }

    public function getErrors() {
        return $this->aErrors;
    }

    public function adapterDataFromTemplate($sTemplate, $aData = null, $bReturnData = false) {
        $aResult = [];
        $aObjects = isset($aData) ? $aData : $this->aData;
        $aErrors = [];
        
        foreach ($aObjects as $aObject) {
            $NestedTree = ObjectUtil::getAsArray(json_decode($this->oIntegracao->integracao_traducoes[0]->nested_json_translate));
            $oConversion = new AdapterUtil();
            $oResponse = $oConversion->render([
                'object'         => $aObject,
                'nested_tree'    => $NestedTree,
                'data_to_render' => $sTemplate,
            ]);

            $aResult[] = $oResponse;
        }
        if(isset($aData)) {
            return $aResult;
        }

        $this->aData = $aResult;
        
        if ($bReturnData)
            return $this->aData;

        return $this;
    }

    public function arrayMerge($aArray1, $aArray2) {
        $aArrayReturn = $aArray1;

        foreach ($aArray2 as $iArrayKey => $aArray) {
            foreach ($aArray as $iRowKey => $row) {
                if(!isset($aArray1[$iArrayKey][$iRowKey])){
                    $aArrayReturn[$iArrayKey][$iRowKey] = $aArray2[$iArrayKey][$iRowKey];
                }
            }
        }

        return $aArrayReturn;
    }

    public static function getIntegracoesTable(){
        return TableRegistry::getTableLocator()->get(
            'LogPluginIntegrador.Integracoes');
    }

    /**
     * oCreateLogIntegracaoTabela function
     *
     * @param [string] $sTabela
     * @param [int] $iColuna  = NULL
     * @param [string] $soOperacao
     * @param [int] $iStatus
     * @param [array] $aData = NULL
     * @param [array] $aError = NULL
     * @return false/IntegracaoTabelaLog
     */
    public function oCreateLogIntegracaoTabela($sTabela, $iColuna, $soOperacao, $iStatus, $aData = null, $aError = null, $sTabelaDestino = null, $iColunaDestino = null){

        $sData = json_encode($aData, JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);
        $sError = json_encode($aError, JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);

        $oTable = TableRegistry::getTableLocator()->get('LogPluginIntegrador.IntegracaoTabelaLogs');
        $oEntity =  $oTable->newEntity([
                'integracao_id' => $this->oIntegracao->id,
                'tabela' => $sTabela,
                'coluna' => $iColuna ,
                'operacao' => $soOperacao,
                'data' => $sData,
                'error' => $sError,
                'status' =>  $iStatus,
                'create_at' => new DateTime('now'),
                'tabela_destino' => $sTabelaDestino,
                'coluna_destino' => $iColunaDestino
        ]);
        return $oTable->save($oEntity);
    }

    /**
     * saveLogIntegracao function
     *
     * @param [Object] $oIntegracaoData
     * @param [string] $jsonEnvio
     * @param [string] $jsonRetorno
     * @param [int] $status
     * @return false/IntegracaoLogs
     */
    public function saveLogIntegracao($oIntegracaoData, $jsonEnvio, $jsonRetorno, $status, $tabela = null, $id = null) 
    {
        $oIntegracaoLogsTable = TableRegistry::getTableLocator()->get(
            'LogPluginIntegrador.IntegracaoLogs');

        $aDataLog = [
            'integracao_id' => $oIntegracaoData->id,
            'url_requisitada' => $oIntegracaoData->url_endpoint ?: 'sem request',
            // 'json_enviado' => is_string($jsonEnvio) ? $jsonEnvio : json_encode($jsonEnvio),
            'json_enviado' => $jsonEnvio,
            // 'json_recebido' => is_string($jsonRetorno) ? $jsonRetorno : json_encode($jsonRetorno),
            'json_recebido' => $jsonRetorno,
            'status' => $status
        ];

        if ($tabela)
            $aDataLog['tabela'] = $tabela;

        if ($id)
            $aDataLog['id'] = $id;

        $oIntegracaoLog = $oIntegracaoLogsTable->newEntity($aDataLog);
        $oIntegracaoLogsTable->save($oIntegracaoLog);
        
        return $oIntegracaoLog;
        
    }

    public static function testDB($oIntegracoesData, $aData){
        $oRespose = new ResponseUtil();
        $oIntegracoes = new Integracoes($oIntegracoesData, $aData);
        try {
            $oConection = $oIntegracoes->getConn();
            $oConection->connect();
            return  $oRespose->setStatus(200)->setMessage('Sucesso.');
        } catch (\Exception $connectionError) {
            return $oRespose
                ->setMessage($connectionError->getMessage());
        }
    }

}
