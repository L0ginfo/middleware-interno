<?php 
namespace Util\Core;

class SaveBackUtil
{
    public static function doLink($that, $aData, $params = []) 
    {
        $sHtml = [];
        $sHtml[] = '<span class="input-group-btn">';
        $sHtml[] = $that->Html->link(
            '<i class="fa fa-plus" aria-hidden="true"></i>',
            [
                'controller' => $aData['controller'],
                'action' => $aData['action'],
                '?' => (['historyback' => 1] + $params)
            ],
            ['escape' => false, 'class' => 'btn btn-primary']);
        $sHtml[] = '</span>';

        return implode($sHtml);
    }

    public static function doLinkWithQuery($that, $aData)
    {
        return '<span class="input-group-btn">' . SaveBackUtil::generateLink($that, $aData) . '</span>';
    }

    public static function doLinkComplete($that, $aData, $aParameters)
    {
        return '<span class="input-group-btn">' . SaveBackUtil::linkWithParameters($that, $aData, $aParameters) . '</span>';
    }

    public static function doBackReturn($that, $exec = true, $back = 1, $selected = null)
    {
        if($selected) {
            if(isset($_COOKIE['VALUE_SELECT'])) {
                setcookie("VALUE_SELECT", "", time() - 15);
            }
            
            setcookie('VALUE_SELECT', serialize($selected), time() + 15, "/");
        }

        if($exec) {
            echo "<script>window.history.go(-".($that->request->getQuery('historyback') + $back).")</script>";
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
            'label'     => '',
            'id'        => '',
            'class'     => 'btn btn-primary',
            'icon'      => true,
            'iconClass' =>'fa fa-plus'
        ], $parameters);

        $label = $parameters['icon'] ? SaveBackUtil::createIcon(
            $parameters['iconClass']) . $parameters['label'] : $parameters['label'];

        $link = '<a href="'.$that->Url->build($aData).'" class="'
            . $parameters['class'] . '" ' . ($parameters['id'] ? 'id="' . $parameters['id'] . '"' : '') . '>'
            . $label . '</a>';
        
        return $link;
    }
    
    private static function createIcon($class = ''){
        return '<i class="' . $class . '" aria-hidden="true"></i>';
    }

    private static function generateLink($that, $aData){
        $aData = array_merge($aData, ['?' => array_merge(['historyback' => 1], $aData['?'])]);
        return $that->Html->link(SaveBackUtil::createIcon('fa fa-plus'), $aData, ['escape' => false, 'class' => 'btn btn-primary btn-save-back']);
    }
}
