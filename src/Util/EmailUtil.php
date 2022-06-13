<?php

namespace App\Util;

use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

class EmailUtil {


    public static function newEmail($sCodigo, $aData){
        $oEmail = LgDbUtil::getFirst('Emails',['codigo' => $sCodigo]);
        if(empty($oEmail)) return false;
        return self::createQueueEmail($oEmail->id, $aData, $oEmail);
    }

    public static function newEmailByEntity($iEmail, $oEmailEntity){
        if(empty($oEmailEntity)) return false;
        return self::createQueueEmail($iEmail, [
            'para' => $oEmailEntity->para,
            'assunto' => $oEmailEntity->assunto
        ], $oEmailEntity);
    }

    public static function createQueueEmail($iEmail, $dataExtra = [], $oEntityEmail = null){

        $oEmail = self::getEntityEmail($iEmail, $oEntityEmail);
        $aAnexos = self::getAnexos($oEntityEmail);
        $sPara = isset($oEntityEmail->id) ? $oEmail->para . ';' . @$dataExtra['para'] : @$dataExtra['para'];
        $sFromName = isset($dataExtra['from_name']) ? $dataExtra['from_name']: 'Loginfo WMS';

        if(isset($dataExtra['anexos']) && is_array($dataExtra['anexos'])){
            $aAnexos = $aAnexos + $dataExtra['anexos'];
        }

        $aData = [
            'email_id' => $oEmail->id,
            'from_name' => $sFromName,
            'from_email' => $oEmail->de,
            'to_email' => $sPara,
            'subject' => @$dataExtra['assunto'] ?: $oEmail->assunto,
            'date_published' => DateUtil::getNowTime(),
            'user_id' => SessionUtil::getUsuarioConectado(),
            'mensagem_id' => @$dataExtra['mensagem_id'],
            'html' => 1,
            'template' => self::getContentEmail($oEntityEmail),
            'max_attempts' => 3
        ];

        $oEmailQueueEmail = self::newQueueEmail($aData);
        self::newQueueEmailAnexos($oEmailQueueEmail, $aAnexos);
    }

    public static function newQueueEmail($aData){
        return LgDbUtil::saveNew('QueueEmails', $aData, true);
    }

    public static function sendAll(){
        $aEmails = EmailUtil::getAllValid();
        foreach ($aEmails as  $oEmail) EmailUtil::send($oEmail);
    }

    public static function sendOne($aWhere){
        $oEmail = EmailUtil::getFirst($aWhere);
        if(empty($oEmail)) return false;
        return EmailUtil::send($oEmail);
    }

    public static function newQueueEmailAnexos($oQueueEmail, $aAnexos){

        $aAnexosToSave = [];
        foreach ($aAnexos as $value) {
            if(isset($value['anexo_id'])) array_push($aAnexosToSave, [
                'anexo_id' => $value['anexo_id'],
                'queue_email_id' => $oQueueEmail->id
            ]);
        }
        $aAnexosToSave = LgDbUtil::get('QueueEmailAnexos')->newEntities($aAnexosToSave);
        LgDbUtil::get('QueueEmailAnexos')->saveMany($aAnexosToSave);
    }

    private static function getEntityEmail($iEmail, $oEntityEmail = null){
        if(empty($oEntityEmail) || !isset($oEntityEmail->id)) 
           return LgDbUtil::getFirst('Emails', ['id' => $iEmail]);
        return $oEntityEmail;
    }

    private static function getSmtp($oEntityEmail){
        if(empty($oEntityEmail->smtp)) 
            return LgDbUtil::getFirst('Smtps', ['id' => $oEntityEmail->smtp_id]);
        return $oEntityEmail->smtp;
    }

    private static function getAnexos($oEntityEmail){
        if(empty($oEntityEmail->email_anexos))
            return LgDbUtil::getAll('EmailAnexos', ['email_id' => $oEntityEmail->id]);
        return $oEntityEmail->email_anexos;
    }

    private static function getMensagem($iMensagemId, $oMensagem = null){
        if($oMensagem) return $oMensagem;
        if(empty($iMensagemId)) return false;
        return LgDbUtil::getFirst('Mensagens', ['id' => $iMensagemId], true);
    }

    private static function getAllValid(){
        return LgDbUtil::getFind('QueueEmails')
            ->contain(['Emails', 'Mensagens', 'QueueEmailAnexos' => 'Anexos'])
            ->where(['attempts < max_attempts', 'success' => 0])
            ->toArray();
    }

    private static function getFirst($aWhere){
        return LgDbUtil::getFind('QueueEmails')
            ->contain(['Emails', 'QueueEmailAnexos' => 'Anexos'])
            ->where($aWhere)
            ->first();
    }

    private static function getAnexosToSend($oQueueEmail){

        $aAnexos = @$oQueueEmail->queue_email_anexos;

        if(empty($aAnexos)){
            $aAnexos = LgDbUtil::getFind('QueueEmailAnexos')
                ->contain(['Anexos'])
                ->where(['queue_email_id' => $oQueueEmail->id])
                ->toArray();
        }

        $aAnexosToSend = [];
        foreach ($aAnexos as $value) {
            if(isset($value->anexo)) {
                $sName = Inflector::underscore(Inflector::variable($value->anexo->nome));
                $aAnexosToSend[$sName] = [
                    'file' => ROOT . DS .$value->anexo->arquivo,
                    'mimetype' => $value->anexo->mime,
                    'contentId' => 'anexo-'.$value->anexo_id,
                ];
            }
        }

       return $aAnexosToSend;
    }

    private static function sendEmail($oQueueEmail){

        if(empty($oQueueEmail)) return false;
        $oEmail = self::getEntityEmail($oQueueEmail->email_id, $oQueueEmail->email);
        $oMensagem = self::getMensagem($oQueueEmail->mensagem_id, $oQueueEmail->mensagem);
        $oSmtp = self::getSmtp($oEmail);
        $aAnexos = self::getAnexosToSend($oQueueEmail);
        $sFrom = self::getFrom($oQueueEmail, $oEmail);
        $sTo = self::getTo($oQueueEmail, $oEmail, $oMensagem);
        $sContent = self::getContent($oQueueEmail, $oEmail, $oMensagem);
        $sSubject = self::getSubject($oQueueEmail, $oEmail, $oMensagem);
        $aConfig = [
            'host' => $oSmtp->host,
            'port' =>  $oSmtp->port,
            'username' => $oSmtp->user,
            'password' => $oSmtp->pass,
            'className' => $oSmtp->auth ? 'Smtp' : 'Mail',
            'tls' => ($oSmtp->smtp_secure == 'tls')
        ];

        $aData = [
            'transport' => 'email',
            'from' => $sFrom,
            'to' => $sTo,
            'subject' => $sSubject,
            'emailFormat' => 'html',
            'attachments' => $aAnexos
        ];

        if(!empty(TransportFactory::getConfig('email')))
            TransportFactory::drop('email');

        TransportFactory::setConfig('email', $aConfig);
        return (new Email($aData))->send($sContent);
    }

    private static function send($oQueueEmail){

        try {
            $oEmail = EmailUtil::sendEmail($oQueueEmail);
            if(empty($oEmail)) return EmailUtil::saveAttempt($oQueueEmail, false);
            return EmailUtil::saveAttempt($oQueueEmail, true);
        } catch (\Throwable $th) {
            return EmailUtil::saveAttempt($oQueueEmail, false);
        }
    }

    private static function saveAttempt($oQueueEmail, $bSuccess = false){
        $oQueueEmail->attempts = $oQueueEmail->attempts + 1;
        $oQueueEmail->success =  $bSuccess ? 1 : 0; 
        $oQueueEmail->date_sent = new \DateTime('now');            
        return LgDbUtil::save('QueueEmails', $oQueueEmail, true);
    }

    private static function getFrom($oQueueEmail, $oEmail){
        return $oQueueEmail->from ?: $oEmail->de;
    }

    private static function getSubject($oQueueEmail, $oEmail, $oMessage = null){
        $sAssunto = $oQueueEmail->subject ?: $oEmail->para;
        if($oMessage) $sAssunto = $oMessage->assunto?:$sAssunto;
        return $sAssunto;
    }

    private static function getTo($oQueueEmail, $oEmail, $oMessage = null){
        $sTo = $oQueueEmail->to_email ?: $oEmail->para;
        $sTo = str_replace(',', ';', $sTo);
        $aTo = explode(';', $sTo);
        if($oMessage){
            $oMessage->emails = str_replace(',', ';', $oMessage->emails);
            $aTo += explode(';', $oMessage->emails);
        }

        $aTo = array_filter($aTo, function($value){
            return !empty($value);
        });

        return $aTo;
    }
    private static function getContent($oQueueEmail, $oEmail, $oMessage = null){
        $sBody = $oQueueEmail->template?:'';
        if($oMessage) $sBody = $oMessage->texto;
        return "<!DOCTYPE html><html><body>$sBody</body></html>";
    }
    private static function getContentEmail($oEmail, $oMessage = null){
        $sHeader = $oEmail->header ?:'';
        $sBody = $oEmail->body ?:'';
        $sFooter = $oEmail->footer?:'';
        if($oMessage) $sBody = $oMessage->texto;
        return "$sHeader $sBody $sFooter";
    }
}