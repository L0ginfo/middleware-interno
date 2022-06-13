<?php 

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

class TooltipUtil
{
    public static function doSimpleTooltip($sButtonText, $sContent, $sCustomClass = '', $sClasses = 'btn btn-primary')
    {
        return '<div class="shake-tooltip">
            <div class="tooltip-custom '.$sClasses . ' ' . $sCustomClass .'">
                <i class="fas fa-search"></i> '.$sButtonText.'
            </div>
            <span class="tooltip-content">
                '.$sContent.'
            </span>
        </div>';

    }
}