<?php

/**
 * Author: Silvio Regis da Silva Junior
 */

namespace App\Util;

use App\Model\Entity\Perfil;
use Cake\ORM\TableRegistry;
use App\Util\ObjectUtil;

class PermissionUtil {

    public static function checkDefault($oThat, $oUser)
    {
        $aListaPermissoesJson = Perfil::listaPermissoes($oUser);

        if (!$oThat->plugin) {
            return $oThat->Acl->check($oThat->request->controller, $oThat->request->action, $aListaPermissoesJson);
        }else {
            $aListaPermissoes = ObjectUtil::getJsonAsArray($aListaPermissoesJson);
            
            if (!array_key_exists($oThat->plugin . '__' . $oThat->request->controller, $aListaPermissoes))
                return false;

            return $oThat->Acl->check($oThat->plugin . '__' . $oThat->request->controller, $oThat->request->action, $aListaPermissoesJson);
        }
    }

    public static function check($sController, $sAction = 'index')
    {
        $sAction = str_replace(['-','_'], ['',''], $sAction);
        $sController = strtolower(str_replace(['-', '_'],['',''], $sController));

        $aPermissions = self::getPermissions();

        if (isset($aPermissions[$sController]) && in_array($sAction, $aPermissions[$sController]) ) 
            return true;

        return false;
    }

    public static function getPermissions()
    {
        if (!isset($_SESSION['Auth']['User'])) 
            return false;

        $iPerfilID = $_SESSION['Auth']['User']['perfil_id'];
        $oPerfil = TableRegistry::get('Perfis')->find()
            ->where(['id' => $iPerfilID])
            ->first();

        if (!$oPerfil)
            return false;

        $aPermissions = json_decode($oPerfil->acl, true);
         
        $aPermissions = array_change_key_case($aPermissions, CASE_LOWER);

        foreach ($aPermissions as $keyController => $aControlerActions) {
            foreach ($aControlerActions as $keyAction => $sAction) {
                $aPermissions[$keyController][$keyAction] = strtolower(str_replace(['-','_'], ['',''], $sAction));
            }
        }
        return $aPermissions;
    }
}