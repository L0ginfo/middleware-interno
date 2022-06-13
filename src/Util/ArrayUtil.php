<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

class ArrayUtil {

    public static function get($aArray, $sKey, $uDefault = '')
    {
        if (array_key_exists($sKey, $aArray))
            return $aArray[$sKey];

        return $uDefault;
    }

    public static function getDepth($uVar, $aPosition, $uDefault = false, $dd = 0)
    {
        if (!$uVar && $uDefault !== false)
            return $uDefault;
        else if (!$uVar)
            return '';

        $aVar = json_decode(json_encode($uVar), true);
        $aVar = self::findColumnArray($aVar, $aPosition);

        if (is_object($uVar))
            return json_decode(json_encode($aVar));

        if (!$aVar && $uDefault !== false)
            return $uDefault;

        return $aVar;
    }

    public static function findColumnArray($aVar, $position, $index = 0)
    {
        if (!$aVar)
            return [];
            
        foreach ($aVar as $key => $column) {

            $percent = 0;
            if ($position[$index]) {

                similar_text($position[$index], $key, $percent);
                $key = preg_replace('/\d+/', '', $key);

                if ($key == $position[$index]) {

                    unset($position[$index]);

                    if (count($position)) {
                        return self::findColumnArray($column, $position, $index + 1);
                    } else {
                        return $column;
                    }
                }
            }
        }
        return [];
    }

    public static function countDimension($aArray)
    {
        if (!is_array($aArray))
            return 0;

        return self::countDimensionAction($aArray);
    }
    
    private static function countDimensionAction($aArray)
    {
        if (is_array(reset($aArray))){
            $return = self::countDimensionAction(reset($aArray)) + 1;
        }else {
            $return = 1;
        }
    
        return $return;
    }

    public static function toCsv($aArray) 
    {
        $sSeparator = ';';
        
        if (!$aArray)
            return '';

        $aFields = array_keys($aArray[0]);
        $aReturn[] = implode($sSeparator, $aFields);

        foreach ($aArray as $aData) {
            $aReturn[] = implode($sSeparator, $aData);
        }

        return implode("\n\r", $aReturn);
    }
}
