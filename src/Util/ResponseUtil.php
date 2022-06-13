<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

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

class ResponseUtil
{
    public $message;
    public $status;
    public $dataExtra;

    public function __construct($uData = [])
    {
        $uData = ObjectUtil::getAsObject($uData, true);

        $aData = array_merge($uData, [
            'message'   => ArrayUtil::get($uData, 'message') ?: $this->translate('NOK'),
            'title'     => ArrayUtil::get($uData, 'title') ?: $this->translate('Ops!'),
            'type'      => ArrayUtil::get($uData, 'type') ?: 'warning',
            'status'    => ArrayUtil::get($uData, 'status') ?: 400,
            'error'     => ArrayUtil::get($uData, 'error') ?: null,
            'dataExtra' => ArrayUtil::get($uData, 'dataExtra') ?: []
        ]);

        $this->message = $aData['message'];
        $this->title = $aData['title'];
        $this->type = $aData['type'];
        $this->status = $aData['status'];
        $this->error = $aData['error'];
        $this->dataExtra = $aData['dataExtra'];
    }

    public function setError($uError)
    {
        $this->error = $uError;
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setType($sType)
    {
        $this->type = $sType;
        return $this;
    }

    public function getType()
    {
        return $this->type;
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
        if ($iStatus === 200){
            $this->setType('success');

            if ($this->getMessage() === 'NOK')
                $this->setMessage('OK');

            if ($this->getTitle() === 'Ops!')
                $this->setTitle(' ');
        }else{
            $this->setType('warning');

            if ($this->getMessage() === 'OK')
                $this->setMessage('NOK');

            if ($this->getTitle() === ' ')
                $this->setTitle('Ops!');
        }

        $this->status = $iStatus;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setTitle($sTitle)
    {
        $this->title = $sTitle;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
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
