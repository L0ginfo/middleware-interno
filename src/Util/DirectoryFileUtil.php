<?php 

namespace App\Util;

class DirectoryFileUtil {

    public static function fileForceContents($sDir, $sContents){
        $aParts = explode(DS, $sDir);
        $sFile = array_pop($aParts);
        $sDir = '';

        foreach($aParts as $sPart) {
            if (!$sDir && strpos($sPart, ':') === 1)
                $sDir .= $sPart;
            else 
                $sDir .= DS . $sPart;

            if(!is_dir($sDir)) {
                mkdir($sDir); 
            }
        }

        file_put_contents($sDir . DS . $sFile, $sContents);
    }
}