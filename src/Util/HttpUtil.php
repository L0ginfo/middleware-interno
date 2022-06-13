<?php

namespace App\Util;

/**
 * Classe centralizadora de requisições externas/internas
 * 
 * Poderá ser utilizado POST, GET e enviar headers.
 */
class HttpUtil 
{
    public static function getFileContents($sUrl, $sType = 'GET', $aHeaders = [], $aData = null, $iTimeout = 0)
    {
        $uData = $aData ? http_build_query($aData) : '';

        $aHeaders += ['Content-Type' => 'application/json'];
        $sHeadersFormated = '';
        
        foreach ($aHeaders as $sKey => $sVal) {
            $sHeadersFormated .= $sKey . ': ' . $sVal . "\r\n";
        }
        
        $aOpts = [
            'http' => [
                'method'  => $sType,
                'header'  => $sHeadersFormated,
                'content' => $uData
            ],
            "ssl"=> [
                "verify_peer"       => false,
                "verify_peer_name"  => false
            ]
        ];

        if ($iTimeout) {
            $aOpts['http']['timeout'] = $iTimeout;
        }
        
        $oContext  = stream_context_create($aOpts);
        
        $sResponse = file_get_contents($sUrl, false, $oContext);

        if ($sResponse)
            return $sResponse;

        return (new ResponseUtil)->setStatus(400)->setMessage('Não foi possível obter o resultado da requisição.')->setTitle('Ops...');
    }
}