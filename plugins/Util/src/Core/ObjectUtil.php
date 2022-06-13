<?php
namespace Util\Core;

class ObjectUtil {
    public static function get($oObj, $sProperty, $uDefault = '')
    {
        if (isset($oObj->{$sProperty}))
            return $oObj->{$sProperty};
        if ($uDefault)
            return $uDefault;
        return '';
    }
    public static function getAsObject($uVar)
    {
        return json_decode(json_encode($uVar));
    }
    public static function getAsArray($uVar, $bPreseveFields = false)
    {
        $aFieldPreserves = [];
        if ($bPreseveFields && strpos(getTypeName($uVar), 'App\\Model\\Entity\\') !== false) {
            $aFieldPreserves = self::preserveFields($uVar);
        }
        $aVar = json_decode(json_encode($uVar), true);
        if ($bPreseveFields) {
            $aVar = self::setPreserved($aVar, $aFieldPreserves);
        }
        return $aVar;
    }
    public static function setPreserved($aVar, $aFieldPreserves)
    {
        foreach ($aVar as $sFieldName => $uFieldValue) {
            if (isset($aFieldPreserves[$sFieldName])) {
                $aVar[$sFieldName] = $aFieldPreserves[$sFieldName];
            }
        }
        return $aVar;
    }
    /**
     * Mantem campos de certas Classes
     */
    public static function preserveFields($uVar) {
        $aFieldPreserves = [];
        $aVar = json_decode(json_encode($uVar), true);
        foreach ($aVar as $sFieldName => $uFieldValue) {
            $uFieldCompare = is_object($uVar) 
                ? $uVar->{$sFieldName} 
                : (is_array($uVar) 
                    ? $uVar[$sFieldName]
                    : $uFieldValue);
            if (strpos(getTypeName($uFieldCompare), 'Cake\\I18n\\') !== false) {
                $aFieldPreserves[$sFieldName] = $uFieldCompare;
            }
        }
        return $aFieldPreserves;
    }
}