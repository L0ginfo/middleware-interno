<?php

/**
 * Autor: Lucas Chegatti
 */

namespace App\Util;

use Cake\View\View;

class ElementUtil {

    public static function getHtmlElement($sViewElement, $aArrayParams, $iValue = null)
    {
        $oViewBuilder = new View();

        // create a builder
        $oBuilder = $oViewBuilder->viewBuilder();

        // configure as needed
        $oBuilder->setLayout(false);
        $oBuilder->setTemplate($sViewElement); // Here you can use elements also
        $oBuilder->setHelpers(['Html']);

        if ($iValue) {
            $aArrayParams['value']    = $iValue;
            $aArrayParams['selected'] = $iValue;
        }
        
        // create a view instance
        $oView = $oBuilder->build([
            'dataForView'  => @$aArrayParams,
            'url'          => @$aArrayParams['url'],
            'data'         => @$aArrayParams['data'],
            'options_ajax' => @$aArrayParams['options_ajax'],
            'name'         => @$aArrayParams['name'],
            'class'        => @$aArrayParams['class'],
            'label'        => @$aArrayParams['label'],
            'null'         => @$aArrayParams['null'],
            'search'       => @$aArrayParams['search'],
            'value'        => @$aArrayParams['value'],
            'selected'     => @$aArrayParams['selected'],
        ]); // Pass the variables to the view

        // render to a variable
        return $oView->render();
    }

}