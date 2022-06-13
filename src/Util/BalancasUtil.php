<?php

namespace App\Util;

use App\Model\Entity\ParametroGeral;

/**
 * Formato do vetor JSON armazenado no parametro: LOGINFO_BALANCAS_CONFIG
 * Poderao ser "N" balancas em "N" hosts diferentes, por isso em array
 * 
 * [
 *   {
 *       "conexao_balanca": {
 *           "host": "http://host.com",
 *           "headers": {
 *               "x-token-key": "token"
 *           },
 *           "endpoints": {
 *               "getBalancasDisponiveis": {
 *                   "controller": "balancas",
 *                   "action": "get-balancas-disponiveis"
 *               },
 *               "getBalancaPeso": {
 *                   "controller": "balancas",
 *                   "action": "get-balanca-peso"
 *               },
 *               "reiniciarServicoBalanca": {
 *                   "controller": "balancas",
 *                   "action": "recognize-service-external"
 *               }
 *           }
 *       }
 *   }
 * ]
 */

class BalancasUtil 
{
    /**
     * Balancas disponiveis sao aquelas que estao com o campo "ativo" = 1
     * 
     * @return -> O retorno esperado do endpoint "getBalancasDisponiveis" 
     * sera sempre em formato de ResponseUtil, com um vetor associativo
     * no dataExtra, onde sua key é o codigo unico identificador da balanca, 
     * e o valor é a breve descricao da balanca. 
     * 
     */
    public static function getBalancasDisponiveis($bWithFullData = false)
    {
        $aBalancasDisponiveis = [];
        $sBalancaParam = ParametroGeral::getParametroWithValue('LOGINFO_BALANCAS_CONFIG');
        
        if (!$sBalancaParam)
            return [];

        $aBalancasData = ObjectUtil::getJsonAsArray($sBalancaParam, true);
        
        if (!$aBalancasData)
            return [];

        $aUrls = self::getBalancasUrls($aBalancasData);

        $oUsuario = LgDbUtil::getByID('Usuarios', SessionUtil::getUsuarioConectado());

        foreach ($aUrls as $aUrl) {

            if (@$oUsuario->login_externo_token)
                $aUrl['headers'] += [
                    'Authorization' => $oUsuario->login_externo_token,
                ];

            $oRequestUtil = new RequestUtil(30);
            $oRequestUtil->setHeaders($aUrl['headers']);
            $oRequestUtil->setUrl($aUrl['links']['getBalancasDisponiveis']['link']);
            $oRequestUtil->setType('GET');
            curl_setopt($oRequestUtil->getCurl(), CURLOPT_SSL_VERIFYPEER,  false);
            curl_setopt($oRequestUtil->getCurl(), CURLOPT_SSL_VERIFYHOST,  0);
            $oRequestUtil->send();
            $oResponse = $oRequestUtil->getResponseAsResponseUtil();

            //dd($oRequest);
                
            //$sResponse = @HttpUtil::getFileContents($aUrl['links']['getBalancasDisponiveis']['link'], 'GET', $aUrl['headers'], null, 5);
            //$oResponse = ObjectUtil::getJsonAsArray($sResponse);

            //dd(ObjectUtil::get($oResponse, 'status') );
            
            if (ObjectUtil::get($oResponse, 'status') == 200 && ObjectUtil::get($oResponse, 'dataExtra')) {
                $aDataExtra = @ObjectUtil::getAsArray($oResponse->dataExtra, true);

                if ($bWithFullData)
                    $aBalancasDisponiveis += self::setFullData($aUrl, $oResponse);
                else 
                    $aBalancasDisponiveis += $aDataExtra;
            }
        }
        
        $aUsuarioRestricoes = LgDbUtil::getFind('UsuarioBalancas')
            ->where([
                'usuario_id IS' => @$_SESSION['Auth']['User']['id']
            ])
            ->extract('balanca_codigo')->toArray();
        
        if ($aUsuarioRestricoes) {
            $aBalancasDisponiveisRestritas = [];

            foreach($aBalancasDisponiveis as $sBalancaCodigo => $sBalancaDescricao) {
                if (in_array($sBalancaCodigo, $aUsuarioRestricoes)) {
                    $aBalancasDisponiveisRestritas[$sBalancaCodigo] = $sBalancaDescricao;
                }
            }

            $aBalancasDisponiveis = $aBalancasDisponiveisRestritas;
        }

        return $aBalancasDisponiveis;
    }

    private static function setFullData($aUrl, $aResponse)
    {
        $aBalancas = ObjectUtil::getAsArray($aResponse->dataExtra, true);
        $aFullDataBalancas = [];

        foreach ($aBalancas as $sBalancaCodigo => $sBalancaDescricao) {
            $aFullDataBalancas[$sBalancaCodigo] = [
                'conexao'   => $aUrl,
                'descricao' => $sBalancaDescricao,
                'codigo'    => $sBalancaCodigo
            ];
        }

        return $aFullDataBalancas;
    }

    private static function getBalancasUrls($aBalancasData)
    {
        $aUrls = [];
        
        foreach ($aBalancasData as $key => $aBalancaData) {

            $aLinks = [];

            foreach ($aBalancaData['conexao_balanca']['endpoints'] as $sEndpointName => $aEndpointData) {
                $aLinks[$sEndpointName] = [
                    'endpoint_name' => $sEndpointName,
                    'link' => $aBalancaData['conexao_balanca']['host']
                            . $aEndpointData['controller'] . '/'
                            . $aEndpointData['action']
                ];
            }
            
            $aUrls[] = [
                'links'   => $aLinks,
                'headers' => $aBalancaData['conexao_balanca']['headers']
            ];
        }

        return $aUrls;
    }
 
    /**
     * getBalancaPeso
     * 
     * @param $aBalancaFullData = [
     *    'conexao'   => [
     *         'links' => [
     *             "endpoint_name" => ""
     *             "link" => ""
     *         ],
     *         'headers' => ['' => '']
     *    ],
     *    'descricao' => '',
     *    'codigo'    => ''
     * ]
     */
    public static function getBalancaPeso($aBalancaFullData)
    {
        $aConexao = $aBalancaFullData['conexao'];
        $sData    = http_build_query(['balanca_codigo' => $aBalancaFullData['codigo']]);
        $sLink    = $aConexao['links']['getBalancaPeso']['link'] . '?' . $sData;

        //$sResponse = HttpUtil::getFileContents($sLink, 'GET', $aConexao['headers']);
        $oUsuario = LgDbUtil::getByID('Usuarios', SessionUtil::getUsuarioConectado());

        if (@$oUsuario->login_externo_token)
            $aConexao['headers'] += [
                'Authorization' => $oUsuario->login_externo_token,
            ];

        $oRequestUtil = new RequestUtil(30);
        $oRequestUtil->setHeaders($aConexao['headers']);
        $oRequestUtil->setUrl($sLink);
        $oRequestUtil->setType('GET');
        curl_setopt($oRequestUtil->getCurl(), CURLOPT_SSL_VERIFYPEER,  false);
        curl_setopt($oRequestUtil->getCurl(), CURLOPT_SSL_VERIFYHOST,  0);
        $oRequestUtil->send();
        $oResponse = $oRequestUtil->getResponseAsResponseUtil();
        
        if (ObjectUtil::get($oResponse, 'status') == 200 && ObjectUtil::get($oResponse, 'dataExtra')) 
            return new ResponseUtil($oResponse);

        return new ResponseUtil($oResponse);
    }

    public static function reiniciarServicoBalanca($sBalancaCodigo, $aBalancaFullData)
    {
        $oResponse = new ResponseUtil;
        $aConexao = $aBalancaFullData['conexao'];
        $sData    = http_build_query(['balanca_codigo' => $aBalancaFullData['codigo']]);
        $sLink    = $aConexao['links']['reiniciarServicoBalanca']['link'] . '?' . $sData;
        
        if (!$sBalancaCodigo)
            return $oResponse->setMessage('Não foi passado nenhum código de balança via parâmetro!');

        $sResponse = HttpUtil::getFileContents($sLink, 'GET', $aConexao['headers']);
        
        $oResponse = @ObjectUtil::getJsonAsArray($sResponse);
        
        if (ObjectUtil::get($oResponse, 'status') == 200 && ObjectUtil::get($oResponse, 'dataExtra')) 
            return new ResponseUtil($oResponse);

        return new ResponseUtil($oResponse);
    }
}