<?php 

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

class SaveBackUtil
{

    public static function doLink ($that, $aData, $aParams = []) 
    {
        $sHtml = array();

        $sHtml[] = '<span class="input-group-btn">';
        $sHtml[] = $that->Html->link(
        '<i class="fa fa-plus" aria-hidden="true"></i>',
        ['?' => ['historyback' => 1] + $aParams] + $aData,
        ['escape' => false, 'class' => 'btn btn-primary btn-save-back' . (@$aParams['class'] ? ' ' . $aParams['class'] : '')]
        );
        $sHtml[] = '</span>';

        return implode($sHtml);
    }

    public static function doLinkWithQuery($that, $aData) 
    {
        return '<span class="input-group-btn">'.SaveBackUtil::generateLink(
            $that, $aData).'</span>';
    }

    public static function doLinkComplete($that, $aData, $aParameters) 
    {
        return '<span class="input-group-btn">'.SaveBackUtil::linkWithParameters(
            $that, $aData, $aParameters).'</span>';
    }

    public static function doBackReturn ($that, $exec = true, $back = 1, $selected = null, $iTimeToCache = 15) 
    {

        if($that->request->getData('ajax_save_back')){
            $iId = @$that->request->getQuery('historybackid');
            $aWhere = [];

            if(isset($iId) && is_numeric($iId)){
                $aWhere = ['id' => $iId];
            }

            $oEntity = LgDbUtil::getFirst($that->name, $aWhere, ['id' => 'DESC']);

            echo json_encode((new ResponseUtil())
                ->setDataExtra(['entity' => $oEntity])
                ->setStatus(200)); 
            die;
        }

        $label = $that->request->getQuery('input');
        $sCookieName = ('VALUE_SELECT_' . str_replace(['[', ']'], ['_','_'], $label));

        if($selected) {
            if(isset($_COOKIE[$sCookieName])) {
                setcookie($sCookieName, "", time() - $iTimeToCache);
            }
            
            $uReturn = setcookie($sCookieName, serialize($selected), time() + $iTimeToCache, "/");
        }
        
        echo "<script>localStorage.setItem('manageSaveBack', 'executed')</script>";

        if($exec) {
            echo "<script>
            
                window.history.go(-".($that->request->getQuery('historyback') + $back).")
            
            </script>";
            exit;
        }
        else {
            return "event.preventDefault(); window.history.go(-".($that->request->getQuery('historyback')).");";
        }
    }

    public static function linkWithParameters($that, $aData = [], $parameters = []) 
    {   
        
        $aData = array_merge($aData, 
            isset($aData['?']) ? 
            ['?' => array_merge(['historyback' => 1], $aData['?'])] : 
            ['?' =>['historyback' => 1]]);

        $parameters = array_merge([
            'label' => '', 
            'class' => 'btn btn-primary', 
            'icon'=> true, 
            'iconClass' =>'fa fa-plus', 
            'id'=>''], $parameters);

        $label = $parameters['icon'] ? SaveBackUtil::createIcon(
            $parameters['iconClass']).$parameters['label'] : $parameters['label'];

        $link = '<a href="'.$that->Url->build($aData).'" class="'
            .$parameters['class']. '" '.($parameters['id']?'id="'.$parameters['id'].'"':''). '>'
            .$label.'</a>';
        
        return $link;
    }

    private static function createIcon($class = ''){
        return '<i class="'.$class.'" aria-hidden="true"></i>';
    }

    private static function generateLink($that, $aData){
        $aData = array_merge($aData, [
            '?' => array_merge(['historyback' => 1], $aData['?'])]);
        return $that->Html->link(SaveBackUtil::createIcon('fa fa-plus'), $aData,[ 'escape' => false, 'class' => 'btn btn-primary btn-save-back']);
    }
}
?>

