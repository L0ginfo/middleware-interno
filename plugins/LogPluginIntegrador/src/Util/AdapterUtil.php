<?php

namespace LogPluginIntegrador\Util;

use Util\Core\ArrayUtil;
use Util\Core\ObjectUtil;
use Util\Core\ResponseUtil;
use Util\Core\StringUtil;

class AdapterUtil {

    public $data = [
        'tree' => [
            'object' => null,
            'nested' => null,
            'data_to_render' => null,
        ],
    ];

    public function render($oData) {
        $this->setData($oData);
        $oResponseValidate = $this->validate();

        if ($oResponseValidate->getStatus() !== 200)
            return $oResponseValidate;

        return $this->replaceNested();
    }

    public function setData($oData) {
        $this->data['tree']['object']         = $oData['object'];
        $this->data['tree']['nested']         = $oData['nested_tree'];
        $this->data['tree']['data_to_render'] = $oData['data_to_render'];
    }

    public function validate() {
        $oResponse = new ResponseUtil();

        if ( !ArrayUtil::getDepth($this, ['data', 'tree','nested']) )
            return $oResponse->setMessage('Não foi possível obter a Árvore associativa para renderizar!');
        else if ( !ArrayUtil::getDepth($this, ['data','tree','object']) )
            return $oResponse->setMessage('Não foi possível obter o Objeto associativo para renderizar!');
        else if ( !ArrayUtil::getDepth($this, ['data','tree','data_to_render']) )
            return $oResponse->setMessage('Não foi possível obter a chave para renderizar os dados!');

        return $oResponse->setStatus(200);
    }

    public function replaceNested() {
        $aNested       = ObjectUtil::getAsArray(ArrayUtil::getDepth($this, ['data','tree','nested']));
        $oObject       = ObjectUtil::getAsArray(ArrayUtil::getDepth($this, ['data','tree','object']));
        $sDataToRender = ArrayUtil::getDepth($this, ['data','tree','data_to_render']);
        $uData         = null;
        $oInfoReplace  = null;
        $aResultReplace = [];

        if(isset($aNested[$sDataToRender])){
            foreach ($aNested[$sDataToRender] as $key => $oInfoReplace) {
                $uData = $this->getValue($oInfoReplace, $oObject);

                if (empty( $uData ))
                    $uData = null;

                $uData = $this->manageCaseWhenValues($uData, $oInfoReplace, $oObject);
                $aResultReplace[$key] = $uData;
            };
        }
        else {
            dump('O template de tradução: ' . $sDataToRender . ' não existe! ');
            die;
        }

        return $aResultReplace;
    }

    public function manageCaseWhenValues($uData, $oInfoReplace, $oObject) {

        if (!isset($oInfoReplace['when']))
            return $uData;

        foreach ($oInfoReplace['when'] as $oCase) {
            $uValueReferer = $this->getValue($oCase['value_referer'], $oObject);
            $uValueReplace = $this->getValue($oCase['value_replace'], $oObject);

            if ($uValueReferer === $uData){
                $uData = $uValueReplace;
                return $uData;
            }
        }

        return $uData;
    }

    public function getValue($oInfoReplace, $oObject) {
        if ($oInfoReplace['type'] === 'static'){
            if(is_string($oInfoReplace['referer']))
                return addslashes($oInfoReplace['referer']);

            return $oInfoReplace['referer'];
        }
        else if ($oInfoReplace['type'] === 'depth') {
            return ArrayUtil::getDepth($oObject, explode('.', $oInfoReplace['referer']));
        }
        else if ($oInfoReplace['type'] === 'search') {
            return @$oObject[$oInfoReplace['referer']];
        }
        else if ($oInfoReplace['type'] === 'closure') {
            $values = StringUtil::replaceValues('/(\{{\w{0,}.*?\}})/', $oInfoReplace['referer'], $oObject);
            return eval("return " . str_replace($values[0], $values[1], $oInfoReplace['referer']) . ";");
        }

        return null;
    }

}
