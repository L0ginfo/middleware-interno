<?php

/**
 * Autor: Matheus Henrique Alves
 */

namespace App\Util;

use App\Model\Entity\ParametroGeral;

class TokenValidateUtil {

    public static function getToken($sCodigo)
    {
        $sObjParam = ParametroGeral::getParametroWithValue('TOKENS_DE_VALIDACAO');
        $oResponse = new ResponseUtil();

        if (!$sObjParam)
            return $oResponse->setMessage('Parâmetro não encontrado ou sem valor!');

        $aTokens = json_decode($sObjParam, true);

        if (!$aTokens[$sCodigo])
            return $oResponse->setMessage('Código de token não encontrado ou sem valor!');

        return $oResponse->setStatus(200)->setDataExtra($aTokens);

    }

    public static function generateToken()
    {
        $bytes = openssl_random_pseudo_bytes(3, $cstrong);
        $token = bin2hex($bytes);

        return strtoupper($token);
    }

    public static function validateToken($sCodigo, $sToken)
    {
        $oGetToken = self::getToken($sCodigo);

        if ($oGetToken->getStatus() == 400)
            return $oGetToken;

        $aTokens = $oGetToken->getDataExtra();

        if ($aTokens[$sCodigo] == $sToken) {

            $aTokens[$sCodigo] = self::generateToken();
            ParametroGeral::saveValueParametro('TOKENS_DE_VALIDACAO', json_encode($aTokens));

            return $oGetToken->setMessage('Token validado!')->setDataExtra('');
        }

        return $oGetToken->setStatus(400)->setMessage('Token inválido!')->setDataExtra('');
    }

    public static function createLog($sToken, $iResvId, $isValid)
    {
        $bSaved = LgDbUtil::saveNew('TokenUtilizados', [
            'token' => $sToken,
            'usuario_id' => $_SESSION['Auth']['User']['id'],
            'resv_id' => $iResvId,
            'valido' => $isValid ? 1 : 0

        ], false);

        return $bSaved;
    }

}
