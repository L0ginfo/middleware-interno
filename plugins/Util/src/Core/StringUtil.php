<?php
namespace Util\Core;

class StringUtil {

    public static function replaceFirst($sFrom, $sTo, $sContent)
    {
        $sFrom = '/' . preg_quote($sFrom, '/') . '/';

        return preg_replace($sFrom, $sTo, $sContent, 1);
    }

    public static function replaceValues($sPreg, $sSearch, $aObject)
    {
        preg_match_all($sPreg, $sSearch, $aValues);
        foreach ($aValues[1] as $key => $sValue) {
            $aDepth = explode('.', trim(str_replace(['{{', '}}'], ['', ''], $sValue)));
            $aValues[1][$key] = self::getDepthValue($aObject, $aDepth);

            if(is_string($aValues[1][$key])) {
                $aValues[1][$key] = addslashes($aValues[1][$key]);
            }
        }

        return $aValues;
    }


    private static function getDepthValue($aArray, $aDepth, $iDepth = 0){
        if(count($aDepth)-1 == $iDepth){
            return @$aArray[$aDepth[$iDepth]];
        }

        return self::getDepthValue($aArray[$aDepth[$iDepth]], $aDepth, ++$iDepth);
    }

}
