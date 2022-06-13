<?php 

namespace App\Util;

class DoubleUtil
{
    public static function toDB( $dDouble )
    {
        return number_format($dDouble, 3, ',', '.');
    }

    public static function toDBUnformat( $dDouble )
    {
        $num = $dDouble;

        if (strpos($num, ',') === false)
            $num = (double) $num;
        else 
            $num = (double) str_replace(['.', ','], ['', '.'], $num);
        
        return $num;
    }

    public static function fromDBUnformat( $dDouble, $iPrecision = 2 )
    {
        $dDouble = !$dDouble ? 0 : $dDouble;
        
        return number_format(str_replace(',', '.', $dDouble), $iPrecision, ',', '.');
    }

    public static function format($uNum, $iDecimals = 2, $sDecPoint = '.', $sThousands = ',')
    {
        $uNum = $uNum ?: 0;

        return number_format($uNum, $iDecimals, $sDecPoint, $sThousands);
    }
}