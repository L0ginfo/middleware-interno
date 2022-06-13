<?php
namespace Util\Core;

class ArrayUtil {

    public static function get($aArray, $sKey)
    {
        if (array_key_exists($sKey, $aArray))
            return $aArray[$sKey];

        return '';
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
}