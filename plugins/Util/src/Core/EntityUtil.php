<?php

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
    public static function dumpErrors($oEntity)
    {
        if (!$oEntity)
            return '<br><div class="swal-html-custom">' . __('Verifique novamente os parâmetros enviados!') . '</div>';

        $aErrors = array();

        if (!$oEntity->getErrors())
            return false;

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

        return implode($aErrors);
    }

    public static function getLastId($sTable)
    {
        $sSql = 'SELECT (auto_increment-1) as lastId
                   FROM information_schema.tables
                  WHERE table_name = "'.Inflector::underscore($sTable).'"
                    AND table_schema = "'.env('DB_NAME', '').'"';

        $oConn = ConnectionManager::get('default');
        $aArr = $oConn->query($sSql)->fetch();

        return $aArr ? $aArr[0] : 0;
    }

    public static function getIdByParams ($sTable, $sColumn, $uValue)
    {
        $oRegistry = TableRegistry::get($sTable)->find()
            ->where([$sColumn => $uValue])
            ->first();
        
        if ($oRegistry) {
            return $oRegistry->id;
        } 
        return null;
    } 
}