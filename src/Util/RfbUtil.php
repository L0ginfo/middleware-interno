<?php

namespace App\Util;

use App\Model\Entity\Empresa;
use App\Model\Entity\ParametroGeral;
use App\Util\LgDbUtil;
use App\Util\RequestUtil;
use App\Util\ResponseUtil;
use Cake\Http\Client;
use Cake\Utility\Xml;

class RfbUtil
{

    private $sToken = '';
    private $sChecktoken = '';
    private $sChecktTokenExpiration ='';
    private $sBaseUrl;
    private $sPerfil;
    private $iEmpresaId;
    private $uCertificado;
    private $aCertificado;


    public function __construct($sBaseUrl, $iEmpresaId)
    {
        $this->iEmpresaId = $iEmpresaId;
        $this->sBaseUrl = $sBaseUrl;
        $this->sPerfil = self::getPerfil($this->iEmpresaId);

        $this->uCertificado = [
            'key' => self::base64_to_temp(
                self::getCertificado($this->iEmpresaId, 'KEY_PEM')
            ),
            'cert' => self::base64_to_temp(
                self::getCertificado($this->iEmpresaId, 'CERT_PEM')
            ),
            'ca' => self::base64_to_temp(
                self::getCertificado($this->iEmpresaId, 'CA_PEM')
            ),
            'pass' => self::getPassword(
                self::getCertificado($this->iEmpresaId, 'PASS_PEM')
            )
        ];

        $this->aCertificado = [
            'key' =>  self::getPathTemp($this->uCertificado['key']),
            'cert' => self::getPathTemp($this->uCertificado['cert']),
            'ca' => self::getPathTemp($this->uCertificado['ca']),
            'pass' => $this->uCertificado['pass']
        ];
    }

    public function login(){

        // $this->uCertificado = [
        //     'key' => ROOT.DS.'cert'.DS.'key.pem',
        //     'cert' => ROOT.DS.'cert'.DS.'client.pem',
        //     'ca' => ROOT.DS.'cert'.DS.'ca.pem',
        //     'pass' => 'tesc12'
        // ];

        if(
            !$this->sPerfil || 
            !$this->aCertificado['key'] || 
            !$this->aCertificado['cert'] ||
            !$this->aCertificado['ca'] || 
            !$this->aCertificado['pass']
        ){
            return false;
        }
        
        $oResquest = $this->post('/portal/api/autenticar', [] , [
            'Role-Type: '.$this->sPerfil,
        ], false,  $this->aCertificado, 30);

        if($oResquest->getStatus() == 200){
            $this->sToken = 
                $oResquest->getResposeHeader('Set-Token');
            $this->sChecktoken = 
                $oResquest->getResposeHeader('X-CSRF-Token');
            $this->sChecktTokenExpiration = 
                $oResquest->getResposeHeader('X-CSRF-Expiration');
        }

        return $oResquest;
    }

    public function submitRfb($Url, $aBody, $aHeader = ['Content-Type: application/json'], $bCompleteUrl = false){

        if(!$this->sPerfil){
            return (new ResponseUtil())
                ->setStatus(511)
                ->setMessage('Falha na Autentificação:'. 'Sem Pefil do RFB');
        }

        if(!$this->uCertificado){
            return (new ResponseUtil())
                ->setStatus(511)
                ->setMessage('Falha na Autentificação:'. 'Sem Certificado.');
        }

        $oRespose = $this->doLogin();

        if($oRespose->getStatus() != 200){
            return $oRespose;
        }

        if(empty($aHeader)){
            $aHeader = ['Content-Type: application/json'];
        }

        $aDefaultHeader = [
            'Authorization: '.@$this->sToken,
            'X-CSRF-Token: '.@$this->sChecktoken
        ];

        
        $oResquest = $this->post($Url, $aBody, $aDefaultHeader + $aHeader , $bCompleteUrl, $this->aCertificado);

        return (new ResponseUtil())
            ->setStatus($oResquest->getStatus())
            ->setDataExtra([
                'body' => $oResquest->getResponseDatas(),
                'header' => $oResquest->getResponseHeaders()
            ]);
    }

    public function submit($Url, $sBody, $aHeader = [], $bCompleteUrl = false){        
        $oResquest = $this->post($Url, $sBody, $aHeader, $bCompleteUrl);
        $oRespose = $oResquest->getResponseAsResponseUtil();
        return (new ResponseUtil())
            ->setStatus($oRespose->getStatus())
            ->setDataExtra([
                'body' => $oResquest->getResponseDatas(),
                'header' => $oResquest->getResponseHeaders()
            ]);
        
    }

    public function doLogin(){
        if(empty($this->sChecktTokenExpiration)){
            $oRequest = $this->tryLogin();
            return $oRequest->getResponseAsResponseUtil();
        }

        if($this->sChecktTokenExpiration < time()){
            $oRequest = $this->tryLogin();
            return $oRequest->getResponseAsResponseUtil();
        }
        return (new ResponseUtil())->setStatus(200);
    }


    private function tryLogin($limit = 10){

        for ($i=0; $i < $limit; $i++) { 
            
            $oRequest = $this->login();

            if(!in_array($oRequest->getStatus(),[0 , 401])){
                return $oRequest;
            }

            sleep(1);
        }

        return $oRequest;
    }


    private static function getCertificado($iEmpresaId, $sTipo){

        $oCertificado = LgDbUtil::getFirst('CertificadoEmpresas', [
            'empresa_id' => $iEmpresaId,
            'tipo' => $sTipo
        ]);

        if(empty($oCertificado)){
            return false;
        }

        return stream_get_contents($oCertificado->certificado);
    }

    private static function getFile($sBase64){
        $temp = tmpfile();
        $data = explode(',', $sBase64);
        fwrite($temp, base64_decode($data[1]));
        return $temp; 
    }

    private static function getPerfil($iEmpresaId){
        $oRfbPerfilEmpresa = LgDbUtil::getFind('RfbPerfilEmpresas')
            ->contain(['RfbPerfis'])
            ->where(['RfbPerfilEmpresas.empresa_id' => $iEmpresaId])
            ->first();

        if(isset($oRfbPerfilEmpresa->rfb_perfil)){
            return $oRfbPerfilEmpresa->rfb_perfil->codigo;
        } 

        if(isset($oRfbPerfilEmpresa->rfb_perfi)){
            return $oRfbPerfilEmpresa->rfb_perfi->codigo;
        } 
        
        return false;
    }


    private function post($Url, $uData, $aHeaders = [], $bCompleteUrl = false, $aCertificado = null, $iTimeout = 60){
        
        $sUrlComplete = $bCompleteUrl ? $Url : $this->sBaseUrl . $Url;
        $oRequestUtil = new RequestUtil($iTimeout);
        $oRequestUtil->setHeaders($aHeaders);
        $oRequestUtil->setData($uData);
        $oRequestUtil->setUrl($sUrlComplete);
        $oRequestUtil->setType('POST');

        if($aCertificado){
            $oRequestUtil->setSll(@$aCertificado['key'], @$aCertificado['cert'], @$aCertificado['ca'], @$aCertificado['pass']);
        }
        
        $aResponse = $oRequestUtil->send();

        return  $aResponse;
    }


    public static function doIntegracaoRfb($oIntegracaoRfb){

        try {
        
            $oRfbUtil = new RfbUtil($oIntegracaoRfb->rfb_base_url, $oIntegracaoRfb->cliente_id);
            $oIntegracaoRfb->data_ultima_tentativa = DateUtil::getNowTime();
            $oIntegracaoRfb->updated_at = DateUtil::getNowTime();
            $oIntegracaoRfb->numero_tentativas++;
            $iStatus = 100;

            
            if($oRfbUtil->bPodeIntegrarRfb($oIntegracaoRfb)){
                self::getDataRfb($oIntegracaoRfb, $sBody, $aHeaders);
                $oResponse = $oRfbUtil->submitRfb(
                    $oIntegracaoRfb->rfb_endpoint_envio, $sBody, $aHeaders, true);
                $oIntegracaoRfb->rfb_body_retorno = @$oResponse->getDataExtra()['body'];
                $oIntegracaoRfb->rfb_headers_retorno = @$oResponse->getDataExtra()['header'];
                $iStatus = $oIntegracaoRfb->rfb_status_retorno = $oResponse->getStatus();
            }

            if($oRfbUtil->bPodeIntegrarCliente($oIntegracaoRfb)){

                try {

                    $oRespose = (new ResponseUtil())
                        ->setStatus($oIntegracaoRfb->rfb_status_retorno)
                        ->setDataExtra([
                            'return' => [
                                'header'=> $oIntegracaoRfb->rfb_body_retorno,
                                'body'=> $oIntegracaoRfb->rfb_headers_retorno,
                                'status' => $oIntegracaoRfb->rfb_status_retorno
                            ],
                            'receive' => [
                                'header'=> $oIntegracaoRfb->cliente_body_envio,
                                'body'=> $oIntegracaoRfb->cliente_headers_envio,
                            ]
                        ]);

                    $aHeader = [
                        'private-key:'.RfbUtil::getHeader(
                            $oIntegracaoRfb->cliente_headers_envio, 'private-key'),
                        'empresa-cnpj:'.RfbUtil::getHeader(
                            $oIntegracaoRfb->cliente_headers_envio, 'empresa-cnpj'),
                        'empresa-token:'. RfbUtil::getHeader(
                            $oIntegracaoRfb->cliente_headers_envio, 'empresa-token'),
                        'content-type:'.'application/json' 
                    ];

                    $oResponse = $oRfbUtil->submit(
                        $oIntegracaoRfb->sUrlRetorno, json_encode($oRespose), $aHeader, true);

                    $oIntegracaoRfb->status_recebimento = $oResponse->getStatus();

                }catch (\Throwable $th) {
                    $iStatus = $oIntegracaoRfb->status_recebimento = 
                        self::getErroStatusFromCliente($iStatus);
                }

            }

            $oIntegracaoRfb->status_integracao = $iStatus;
            LgDbUtil::save('fila_rfb_integracoes', $oIntegracaoRfb);

        } catch (\Throwable $th) {
            $oIntegracaoRfb->status_integracao = 522;
            $oIntegracaoRfb->stack_error = json_encode($th->getTrace());
            LgDbUtil::save('fila_rfb_integracoes', $oIntegracaoRfb);
        }
    }


    public static function doIntegracaoApi($oIntegracaoRfb){

        try {
        
            $oRfbUtil = new RfbUtil($oIntegracaoRfb->rfb_base_url, $oIntegracaoRfb->cliente_id);
            $oIntegracaoRfb->data_ultima_tentativa = DateUtil::getNowTime();
            $oIntegracaoRfb->updated_at = DateUtil::getNowTime();
            $oIntegracaoRfb->numero_tentativas++;
            $iStatus = 0;
            
            if($oRfbUtil->bPodeIntegrarRfb($oIntegracaoRfb)){

                $oResponse = $oRfbUtil->submit(
                    $oIntegracaoRfb->rfb_endpoint_envio, 
                    json_encode($oIntegracaoRfb->cliente_body_envio),
                    $oIntegracaoRfb->cliente_headers_envio,
                    true
                );
                $oIntegracaoRfb->rfb_body_retorno = $oResponse->getDataExtra()['body'];
                $oIntegracaoRfb->rfb_headers_retorno = @$oResponse->getDataExtra()['header'];
                $iStatus = $oResponse->getStatus();
            }

            $oIntegracaoRfb->status_integracao = $iStatus;
            LgDbUtil::save('fila_rfb_integracoes', $oIntegracaoRfb);

        } catch (\Throwable $th) {
            $oIntegracaoRfb->status_integracao = 522;
            $oIntegracaoRfb->stack_error = json_encode($th->getTrace());
            LgDbUtil::save('fila_rfb_integracoes', $oIntegracaoRfb);
        }
    }

    public function bPodeIntegrarRfb($oRfb){
        return 
            in_array($oRfb->status_integracao, [0, 1, 100]) 
            && !empty($oRfb->cliente_body_envio) 
            && !empty($oRfb->cliente_headers_envio);
    }

    public function bPodeIntegrarCliente($oRfb){
        return empty($oRfb->status_recebimento) && !empty($oRfb->cliente_endpoint_envio);
    }

    public static function getErroStatusFromCliente($iStatus){
       return in_array($iStatus, [200, 201, 204]) ? 520 : 521;
    }

    public static function base64_to_temp($oBase64) {

        if(!$oBase64){
            return false;
        }

        $sData = base64_decode($oBase64);
        $tempPemFile = tmpfile();
        fwrite($tempPemFile, $sData);
        return $tempPemFile;
    }

    public static function getPassword($oBase64){

        if(!$oBase64){
            return false;
        }

        return base64_decode($oBase64);      
    }

    public static function getPathTemp($oTemp){

        if(!$oTemp){
            return false;
        }

        $tempPemPath = stream_get_meta_data($oTemp);
        return $tempPemPath = $tempPemPath['uri'];
    }


    public static function getHeader($aHeader, $name){
        $parts = explode('-', $name);
        $parts = array_map('ucfirst', $parts);
        return @$aHeader[implode('-', $parts)][0];
    }

    public static function getDataRfb($oRfb, &$uBody, &$aHeaders){

        $aRotas = json_decode(ParametroGeral::getParametroWithValue('PARAM_ROTAS_RFB'), true);
        $sType = $aRotas[$oRfb->nome_endpoint];

        try {
        
            switch (@$sType) {
                case 'xml':
                    $uBody = Xml::fromArray($oRfb->cliente_body_envio, ['format' => 'tags'])->asXML();
                    $aHeaders = ['Content-Type: application/xml'];
                break;
                
                default:
                    $uBody = json_encode($oRfb->cliente_body_envio);
                    $aHeaders = ['Content-Type: application/json'];
                break;
            }

            return true;

        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function formatDatetime($dDateTime){
        return DateUtil::dateTimeFromDB($dDateTime, 'Y-m-d\TH:i:s.vO');
    }

    public static function initProtocolo($sClass, $aData){
        $sIdEvento  = @$aData['idEvento'];
        $sAction    = @$aData['tipoOperacao'];

        if($sIdEvento && in_array($sAction, ['R','E'])){

            $oProtocolo = LgDbUtil::getFirst('rfb_protocolos',[
                'endpoint_rfb'      => $sClass::$_sNomeEndPoint,
                'codigo_trigger'    => $sClass::$_sCodigoTrigger,
                'id_coluna'         => $sIdEvento
            ]);

            $aData["protocoloEventoRetificadoOuExcluido"] = @$oProtocolo->protocolo_gerado?:'';
        }

        return $aData;
    }

    private static function getTipoOperacao($oEntity, $aParameters)
    {
        if (isset($aParameters['operacao']) && $aParameters['operacao'] == 'delete')
            return "E";

        if ($oEntity->isNew())
            return "I";

        return "R";
    }
}