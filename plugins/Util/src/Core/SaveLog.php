<?php 
namespace Util\Core;


class SaveLog {

    public static function Error($that)
    {
        $oResponse = new ResponseUtil();
        $aData = $that->request->getData();
        $sData = json_encode($aData);

        $sResult = ($sData);
        $aResult = json_decode($sResult, true);
        $aResult['timestamp'] = strtotime(date('Y-m-d H:i:s'));

        $that->log($aResult, 'debug');

        return $oResponse->setStatus(200)
            ->setMessage('OK')
            ->setDataExtra(['timestamp' => $aResult['timestamp']])
            ->setJsonResponse($that, $aResult['timestamp']);
    }

}