<?php

namespace LogPluginIntegrador\Util;

use Util\Core\ObjectUtil;

/**
 * Classe de Responses
 *
 * IMPORTANTE: Quando feita qualquer alteração nessa classe
 * favor alterar também na ResponseUtil.js
 */

/**
 * Respostas de informação (100-199),
 * Respostas de sucesso (200-299),
 * Redirecionamentos (300-399)
 * Erros do cliente (400-499)
 * Erros do servidor (500-599).
 */

class ResponseApiUtil
{
    public $message;
    public $status;
    public $dataExtra;

    public function __construct()
    {
        $this->message = $this->translate('Error');
        $this->status = 400;
    }

    private function translate($sString)
    {
        try {
            return __($sString);
        } catch (\Throwable $th) {
            return $sString;
        }
    }

    public function setStatus($iStatus)
    {
        if ($iStatus >= 200 && $iStatus <= 299){
            $this->setMessage('Success');
        }
        else{
            $this->setMessage('Error');
        }

        $this->status = $iStatus;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setMessage($sMessage)
    {
        $this->message = $this->translate($sMessage);
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setDataExtra($aDataExtra)
    {
        $this->dataExtra = $aDataExtra;
        return $this;
    }

    public function getDataExtra()
    {
        return $this->dataExtra;
    }

    /**
     * setJsonResponse method
     *
     * @param $that == $this ~> Controller (instance)
     * @param $aResponse == array a retornar
     */
    public function setJsonResponse($that, $aResponse = null)
    {
        if (!$aResponse){
            $aResponse = ObjectUtil::getAsArray($this);
        }

        $that->loadComponent('RequestHandler');
        $that->RequestHandler->renderAs($that, 'json');
        $that->response->type('application/json');
        $that->set(['aResponse' => $aResponse, '_serialize' => 'aResponse']);
    }

    public function getArray()
    {
        return json_decode(json_encode($this), true);
    }
}
