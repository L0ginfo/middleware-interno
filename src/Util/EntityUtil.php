<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

class EntityUtil
{
    /*
    * usage:

        use App\Util\EntityUtil;
        .
        .
        .
        $this->Flash->error( __('Não foi possível salvar, valide novamente os campos!'),
                [
                    'params' => [
                        'html'  => EntityUtil::dumpErrors($oEntity),
                        'timer' => 9000
                    ]
                ]
        );
    */
    public static function dumpErrors($oEntity, $bToFlash = false)
    {
        if (!$oEntity)
            return '<br><div class="swal-html-custom">' . __('Verifique novamente os parâmetros enviados!') . '</div>';

        $aErrors = array();

        if (!$oEntity->getErrors() && !$bToFlash)
            return false;
        elseif ($bToFlash && $oEntity->getErrors())
            return ['params' => ['html' => 'EntityUtil sem erors']];

        foreach ($oEntity->getErrors() as $sField => $aErrorList) {
            foreach ($aErrorList as $sCausedBy => $sDescription) {
                $aErrors[] = __( 'Campo: ' ) . '[' . __($sField) . '] ~> ' . __( $sDescription ) . ' [' . __( $sCausedBy ) . ']<br>';
            }
        }

        (count($aErrors) > 1)
            ? array_unshift($aErrors, __('<br>Causas:<br> ') )
            : array_unshift($aErrors, __('<br>Causa:<br> ') );

        array_unshift($aErrors, '<div class="swal-html-custom">' );

        if (@$_SESSION['Auth']['User']['perfil_id'] === 1) {
            $aErrors[] = '&nbsp;Detalhamento técnico&nbsp;';
            $aErrors[] = '<a class="lf-copy-to-clipboard lf-cursor-pointer">';
            $aErrors[] = '<div class="lf-copy-to-clipboard-content">';
            $aErrors[] = json_encode($oEntity);
            $aErrors[] = '</div>';
            $aErrors[] = 'aqui.';
            $aErrors[] = '</a>';
            $aErrors[] = '</div>';
        }

        if ($bToFlash)
            return ['params' => ['html' => implode($aErrors)]];

        return implode($aErrors);
    }

    public static function getLastId($sTable)
    {
        if (env('DB_ADAPTER', 'mysql') == 'mysql') {
            $sSql = 'SELECT (auto_increment-1) as lastId
                       FROM information_schema.tables
                      WHERE table_name = "'.Inflector::underscore($sTable).'"
                        AND table_schema = "'.env('DB_NAME', '').'"';
        } else {
            $sSql = "SELECT IDENT_CURRENT('" . Inflector::underscore($sTable) . "')";
        }

        $oConn = ConnectionManager::get('default');
        $aArr = $oConn->query($sSql)->fetch();

        return $aArr ? $aArr[0] : 0;
    }

    public static function getIdByParams ($sTable, $sColumn, $uValue, $bReturnFirst = true, $aOrder = ['id' => 'ASC'])
    {
        $sTypeSearch = '';

        if (is_array($uValue)) {
            $sTypeSearch = ' IN';
        }

        //dd([$sColumn . $sTypeSearch => (!is_array($uValue) ? "'%". $uValue . "%'" : $uValue)]);

        if (env('DB_ADAPTER', 'mysql') != 'mysql' && !$sTypeSearch) {
            $sTypeSearch = ' LIKE ';
            $uValue = $uValue . '%';
        }

        $oRegistry = TableRegistry::get($sTable)->find()
            ->where([$sColumn . $sTypeSearch => $uValue])
            ->order($aOrder);

        if ($bReturnFirst)
            $oRegistry = $oRegistry->first();
        else 
            return $oRegistry->toArray();
        
        if ($oRegistry) {
            return $oRegistry->id;
        } 
        return null;
    } 

    public static function getOrSave($aData, $sTable, $aFieldsToSearch = [], $sOperador = '')
    {
        //sanitize
        foreach ($aData as $iKey => $uValue) {
            $aData[$iKey] = is_string($uValue) ? trim($uValue) : $uValue;
        }

        $aSearch = [];

        if ($aFieldsToSearch){
            foreach ($aFieldsToSearch as $iKey => $sFieldName) {
                if (isset($aData[$sFieldName]))
                    $aSearch[$sOperador ? $sFieldName . ' ' . $sOperador : $sFieldName] = ($sOperador == 'LIKE') ? '%'.$aData[$sFieldName].'%' : $aData[$sFieldName];
            }
        }
        
        $oPessoa = LgDbUtil::get($sTable)->find()
            ->where($aSearch ?: $aData)
            ->first();

        if ($oPessoa)
            return $oPessoa;

        $oPessoa = LgDbUtil::get($sTable)->newEntity($aData);

        LgDbUtil::get($sTable)->save($oPessoa);

        return $oPessoa;

    }

    public static function filterQuerySelectpicker($oThat)
    {
        $oResponse = new ResponseUtil;
        $aData = $oThat->request->getData();

        // LgDbUtil::get($aData['table'])
        //     ->find('list', [
        //         'keyField' => 'id', 
        //         'valueField' => function ($row) {
        //         $nome = isset($row->navio->nome)? $row->navio->nome.' /' :'';
        //         return "$row->numero ($nome $row->vei_id)";}
        //     ])
        //     ->contain('Navios')
        //     ->where(['numero LIKE' => "%{$sSearch}%"])
        //     ->limit($iLimit)
        //     ->toArray();

        return $oResponse
            ->setStatus(200)
            ->setJsonResponse($oThat);
    }

    public static function setEntity($entityName, $aPostData = null, $options=[])
    {
        $Object = null;
        $id = self::checkEditID($aPostData);

        if ($entityName)
            if ($id)
                $Object = LgDbUtil::get($entityName)->get($id, $options);
            else
                $Object = LgDbUtil::get($entityName)->newEntity();

        return $Object;
    }

    private static function checkEditID($aPostData)
    {
        if (isset($aPostData['id']) && $aPostData['id'] != '') {
            return $aPostData['id'];
        }

        return null;
    }

    public static function getArrayColumnsModified($oEntity)
    {
        $aColumns = [];

        foreach ($oEntity->getDirty() as $sColumn) {
            $aColumns[$sColumn] = $oEntity->{$sColumn};
        }

        return $aColumns;
    }
}