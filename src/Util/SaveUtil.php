<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Cake\Http\Client\Response;

class SaveUtil
{
    /**
     * multiple function
     *
     * @param integer $id
     * @param array $aData = [
     *  'table' => 'string', 
     *  'input'=> 'string',
     *  'id' => 'string',
     *  'value' => 'string'
     * ]
     * @param array $aDataPost
     * @return void
     */
    public static function multiple($id, $aData, $aDataPost){
        $sTable = @$aData['table'];
        $sInput = @$aData['input'];
        $sId = @$aData['id'];
        $sValue = @$aData['value'];

        if(empty($sTable)||empty($sInput)||empty($sId)||empty($sValue)){
            return (new ResponseUtil())->setMessage('Falta Parameters aData');
        }

        if(empty($aDataPost[$sInput.'_add'])||empty($aDataPost[$sInput.'_del'])){
            return (new ResponseUtil())->setMessage('Add ou del input não localizado.');
        }

        try {
            $inclusao = json_decode($aDataPost[$sInput.'_add']);
            $delecao = json_decode($aDataPost[$sInput.'_del']);
        } catch (\Throwable $th) {
            return (new ResponseUtil())->setMessage('Falha ao converter inputs do json');
        }

        try {
            if(is_array($inclusao) && !empty($inclusao)){
                $aInsert = array_map(function($value) use($id, $sId, $sValue){ 
                    return [
                        "$sId" => $id,
                        "$sValue" => $value
                    ];
                }, $inclusao);
                $aEntity = LgDbUtil::get($sTable)->newEntities($aInsert);
                LgDbUtil::get($sTable)->saveMany($aEntity);
            }

            if(is_array($delecao) && !empty($delecao)){
                LgDbUtil::get($sTable)->deleteAll([
                    "$sId" => $id,
                    "$sValue IN" => $delecao
                ]);
            }

            return (new ResponseUtil())->setStatus(200);

        } catch (\Throwable $th) {
            return (new ResponseUtil())
                ->setMessage('Falha ao salvar')
                ->setError($th->getMessage());
        }
    }
}