<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Plugin;
use ReflectionClass;
use ReflectionMethod;

class AclComponent extends Component {

    public function getControllers($sDir = '..' . DS . 'src' . DS . 'Controller' . DS . '') {
        
        if (strpos($sDir, 'Controller' . DS) != strlen($sDir) - 11)
            return [];

        if (!is_dir($sDir))
            return [];

        $files = scandir($sDir);
        $results = [];
        $ignoreList = [
            '.',
            '..',
            'Component',
            'AppController.php',
        ];
        foreach ($files as $file) {
            if (!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }
        }
        return $results;
    }

    public function getActions($controllerName, $sNamespace = 'App') {
        $className = $sNamespace . '\\Controller\\' . $controllerName . 'Controller';
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [$controllerName => []];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
        foreach ($actions as $action) {
            if ($action->class == $className && !in_array($action->name, $ignoreList)) {
                array_push($results[$controllerName], $action->name);
            }
        }
        return $results;
    }

    public function getResources($sDir = '..' . DS . 'src' . DS . 'Controller' . DS . '', $sNamespace = 'App') {
        $controllers = $this->getControllers($sDir);
        $resources = [];
        foreach ($controllers as $controller) {
            $actions = $this->getActions($controller, $sNamespace);
            array_push($resources, $actions);
        }
        return $resources;
    }

    public function getResourcesPlugins() {
        
        $aPlugins = Plugin::loaded();
        $aPluginResources = [];

        foreach ($aPlugins as $sPlugin) {
            
            //Se não for um plugin da Loginfo
            if (strpos($sPlugin, 'LogPlugin') === false)
                continue;

            $sControllerPlugin = ROOT . DS . 'plugins' . DS . $sPlugin . DS . 'src' . DS . 'Controller' . DS;
            $aPluginResources[$sPlugin] = $this->getResources($sControllerPlugin, $sPlugin);
        }

        $aResources = [];

        foreach ($aPluginResources as $sPluginName => $aPlugins) {
            foreach ($aPlugins as $aPluginControllers) {
                foreach ($aPluginControllers as $sControllerName => $aPluginActions) {
                    $aResources[$sPluginName . '__' . $sControllerName] = $aPluginActions;
                }
            }
        }

        return $aResources;
    }

    public function removeValuesFromCheckbox(Array $array) {
        $r = []; //return
        foreach ($array as $controller => $action) {
            $r[$controller] = array_keys($action);
        }
        return json_encode($r);
    }

    public function check($controller, $action, $lista) {
        if (@$lista) {
            $lista = json_decode($lista);
            foreach ($lista as $_controller => $_actions) {
                foreach ($_actions as $_a) {
                    if (strtolower($controller) == strtolower($_controller) && strtolower($action) == strtolower($_a)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}
