<?php

namespace App\Util;

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\Integracoes\HandlerIntegracao;
use Cake\Log\Log;
use Util\Core\ResponseUtil;

class RequestUtil {

    const REQUEST_TYPE_GET = 0;
    const REQUEST_TYPE_POST = 1;

    private $sUrl = '';
    private $uData = [];
    private $sType = 'GET';
    private $oCurl = null;
    private $iStatus = 0;
    private $aHeaders = [
        'Content-Type:application/json'
    ];
    private $aResponseData = null;
    private $aResponseHeader = null;
    private $aResponseError = null;


    public function getCurl(){
        return $this->oCurl;
    }

    public function setCurl($oCurl){
        $this->oCurl = $oCurl;
        return $this;
    }

    public function __construct($iTimeOut = 60)
    {
        $this->oCurl = curl_init();
        curl_setopt($this->oCurl, CURLOPT_TIMEOUT, $iTimeOut);
        return $this;
    }

    public function setUrl($sUrl){
        $this->sUrl = $sUrl;
        return $this;
    }

    public function getUrl(){
        return $this->sUrl;
    }

    public function setSll($sKey, $sCert, $sCa, $sPass, $bVerifypeer = false, $iVerifyHost = 0){        
        curl_setopt($this->oCurl, CURLOPT_SSL_VERIFYPEER,  $bVerifypeer);
        curl_setopt($this->oCurl, CURLOPT_SSL_VERIFYHOST,  $iVerifyHost);
        curl_setopt($this->oCurl, CURLOPT_SSLKEY, $sKey);
        curl_setopt($this->oCurl, CURLOPT_SSLCERT, $sCert);
        curl_setopt($this->oCurl, CURLOPT_CAINFO,  $sCa);
        curl_setopt($this->oCurl, CURLOPT_SSLCERTPASSWD, $sPass);
    }

    public function setType($sType = 'GET'){
        $this->sType = $sType;
        return $this;
    }

    private function sGetMethod(){
       return $this->sType;  
    }

    public function setJsonData($aData = []){
        $this->uData = json_encode($aData);
        return $this;
    }

    public function setData($uData = []){
        $this->uData = $uData;
        return $this;
    }

    public function getData(){
        return $this->uData;
    }

    public function setHeaders($aHeaders = ['Content-Type:application/json']){
        $aNewHeaders = [];
        foreach ($aHeaders as $key => $value) {
            if(is_string($key)) $aHeaders[$key] = $key .':'.$value;
            array_push($aNewHeaders, $aHeaders[$key]);
        }
        $this->aHeaders = $aNewHeaders;
        return $this;
    }

    public function getHeaders(){
        return $this->aHeaders;
    }

    public function getResponseDatas(){
        return $this->aResponseData;
    }

    public function getResponseData($sString){
        return isset($this->aResponseData[$sString]) ? $this->aResponseData[$sString] : null;
    }

    public function getResponseHeaders(){
        return $this->aResponseHeader;
    }

    public function getResposeError(){
        return $this->aResponseError;
    }

    public function getResposeHeader($sHeader){

        if(empty($this->aResponseHeader)){
            return false;
        }
        
        $aWords = explode('-', $sHeader);

        foreach ($aWords as  $sWords) {
            ucfirst($sWords);
        }

        $sHeader = implode('-', $aWords);

        foreach ($this->aResponseHeader as $value) {
            if (strpos($value, $sHeader) !== false) {
                $aParts = explode(':', $value);
                return isset($aParts[1]) ? trim($aParts[1]) : $aParts[0];
            }
        }

        return false;

    }

    public function getResposeHeaders(){
        return $this->aResponseHeader;
    }

    public function getResponseAsResponseUtil(){

        $oResponseUtil = new ResponseUtil();
       
        if($this->validResponseUtil()){
            $oResponseUtil->setStatus(@$this->aResponseData['status']);
            if(@$this->aResponseData['type']){
                $oResponseUtil->setType(@$this->aResponseData['type']);
            }
            $oResponseUtil->setTitle(@$this->aResponseData['title']);
            $oResponseUtil->setError(@$this->aResponseData['error']);
            $oResponseUtil->setMessage(@$this->aResponseData['message']);
            $oResponseUtil->setDataExtra(@$this->aResponseData['dataExtra']);
            return $oResponseUtil;
        }

        $oResponseUtil->setStatus($this->iStatus);
        $oResponseUtil->setDataExtra(@$this->aResponseData);
        $oResponseUtil->setError(@$this->aResponseError);
        return $oResponseUtil;
    }
   
    public function send($isCallback = false){
        $uData = $this->uData;

        if(is_array($this->uData) && $this->isJsonRequest()){
            $uData = json_encode($this->uData);
        }
        
        if (!$isCallback)
            $this->aHeaders = array_merge($this->aHeaders, self::consisteValidaToken($this->aHeaders));
        
        curl_setopt($this->oCurl, CURLOPT_HTTPHEADER, $this->aHeaders);
        curl_setopt($this->oCurl, CURLOPT_CUSTOMREQUEST, $this->sType);
        curl_setopt($this->oCurl, CURLOPT_POSTFIELDS, $uData);
        curl_setopt($this->oCurl, CURLOPT_VERBOSE, true);
        curl_setopt($this->oCurl, CURLOPT_RETURNTRANSFER,  true);
        curl_setopt($this->oCurl, CURLOPT_AUTOREFERER,  true);
        curl_setopt($this->oCurl, CURLOPT_HEADER, true);
        curl_setopt($this->oCurl, CURLOPT_REFERER , $this->sUrl);
        curl_setopt($this->oCurl, CURLOPT_URL , $this->sUrl);
        curl_setopt($this->oCurl, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($this->oCurl, CURLOPT_COOKIESESSION , false);
        curl_setopt($this->oCurl, CURLOPT_SSL_VERIFYPEER,  false);
        curl_setopt($this->oCurl, CURLOPT_SSL_VERIFYHOST,  0);
        // // curl_setopt($this->oCurl, CURLOPT_COOKIEFILE , ROOT . '/cookie.txt');
        // // curl_setopt($this->oCurl, CURLOPT_COOKIEJAR , ROOT . '/cookie.txt');
        
        // Log::write('info',  '------------------------------------------------------');
        // Log::write('info',  '-------------------- SEND RESQUEST -------------------');
        // Log::write('info',  'METODO: ' . $this->sGetMethod());
        // Log::write('info',  'URL: ' . $this->sUrl);
        // Log::write('info',  'DATA: ' . json_encode($this->uData, true));
        
        $response = curl_exec($this->oCurl);
        $code = curl_getinfo($this->oCurl, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($this->oCurl, CURLINFO_HEADER_SIZE);

        // Log::write('info', '---- RESPONSE STATUS ----');
        // Log::write('info', $code);

        if($response == false){
            $error = curl_error($this->oCurl); 
            $errno = curl_errno($this->oCurl);
            // Log::write('info',  '---- RESPONSE ERROR ----');
            // Log::write('info', ['code' => $errno, 'erro' => $error]);
            $this->aResponseError = ['error' => $error, 'code' => $errno];
            $this->aResponseHeader = [];
            $this->aResponseData = [];
            $this->iStatus = 553;
            return $this;
        }

        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        
        // Log::write('info',  '---- RESPONSE HEADER ----');
        // Log::write('info',  $header);
        // Log::write('info',  '---- RESPONSE BODY ----');
        // Log::write('info',  $body);

        $this->iStatus = $code;
        curl_close ($this->oCurl);

        // Log::write('info',  '-------------------- END RESQUEST --------------------');
        // Log::write('info',  '------------------------------------------------------');

        if(isset($header)){
            $this->aResponseHeader = explode("\r\n", $header);
        }

        if(empty($body)){
            return $this;
        }

        if($aJson = $this->json($body)){
            // Log::write('info',  '---- RESPONSE DATA IS JSON ----');
            $this->aResponseData = $aJson;
            return $this;
        }

        $this->aResponseData = [$body];

        return $this;
    }

    private function validResponseUtil(){
        return is_array($this->aResponseData) 
            && array_key_exists('status', $this->aResponseData) 
            && is_numeric($this->aResponseData['status']);
    }

    public function getStatus(){
        return $this->iStatus;
    }

    private function json($sResponse){
        try {
            return  @json_decode($sResponse, true);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function put($sUrl, $aData, $aHeaders){
        return (new RequestUtil())
            ->setType('PUT')
            ->setUrl($sUrl)
            ->setData($aData)
            ->setHeaders($aHeaders)
            ->send();
            
    }

    public static function post($sUrl, $aData, $aHeaders){
        return (new RequestUtil())
            ->setType('POST')
            ->setUrl($sUrl)
            ->setData($aData)
            ->setHeaders($aHeaders)
            ->send();
    }

    public static function get($sUrl, $aData, $aHeaders){
        return (new RequestUtil())
            ->setType('GET')
            ->setUrl($sUrl)
            ->setData($aData)
            ->setHeaders($aHeaders)
            ->send();
    }

    private function isJsonRequest(){
        return in_array('content-type:application/json', 
            array_map('strtolower', $this->aHeaders)
        );
    }

    private static function consisteValidaToken($aHeaders)
    {
        $oParamIntegracaoValidaToken = ParametroGeral::getParameterByUniqueName('PARAM_VALIDACAO_TOKEN_REQUEST');

        $aHeader = [];
        if ($oParamIntegracaoValidaToken)
            $aHeader = HandlerIntegracao::do(@$oParamIntegracaoValidaToken->id, $aHeaders);

        return is_array($aHeader) ? $aHeader : [];
    }
}
