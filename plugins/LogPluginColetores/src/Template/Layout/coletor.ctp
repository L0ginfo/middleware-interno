<?php

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

$custom = Configure::read('App.custom');
$full_url = Configure::read('App.full_url');
$empresa = Configure::read('App.empresa');
$full_url = Router::url('/', true);

(isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<!DOCTYPE html>
<html translate="no">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?=  __(Inflector::humanize(Inflector::tableize($this->fetch('title')))) ?>
        </title>

        <?= $this->Html->meta('tab_logo.png', $sLogoImgTab, array('type' => 'icon')); ?>

        <script>webroot = '<?= Router::url(["plugin" => "LogPluginColetores", "controller" => "ColetorMaritimo", "action" => "index"], false) ?>'</script>
        <script>url = '<?= $full_url ?>'</script>
        <script>custom = url + '<?= $custom ?>'</script>
        <script>controller = '<?= str_replace('_', '-', Inflector::underscore($this->request->params['controller']))  ?>'</script>

        <script>
            var showSwalOnReady = false;
        </script>

        <?= $this->Html->css([
            '/custom_pontanegra/bootstrap/dist/css/bootstrap.css',
            '/LogPluginColetores/css/all_styles' . $aRemoveCache['css'],
            '/LogPluginColetores/css/styles' . $aRemoveCache['css'],
            '/LogPluginColetores/css/util' . $aRemoveCache['css'],
            '/LogPluginColetores/libs/font-awesome/css/font-awesome.min',
            '/LogPluginColetores/libs/font-awesome/css/font-awesome-ie7.min',
            '/node_modules/ajax-bootstrap-select/dist/css/ajax-bootstrap-select' . $aRemoveCache['css'],
            '/sass/bootstrap-tagsinput.css',
        ]); ?>

        <?= $this->Html->script([
            '/bower_components/jquery/dist/jquery.min' . $aRemoveCache['js'],
            '/js/jquery.mask.min' . $aRemoveCache['js'],
            '/custom_pontanegra/bootstrap/dist/js/bootstrap.min' . $aRemoveCache['js'],
            '/bower_components/bootstrap-select/dist/js/bootstrap-select' . $aRemoveCache['js'],
            '/node_modules/ajax-bootstrap-select/dist/js/ajax-bootstrap-select.min' . $aRemoveCache['js'],
            '/node_modules/ajax-bootstrap-select/dist/js/locale/ajax-bootstrap-select.pt-BR' . $aRemoveCache['js'],
            '/node_modules/sweetalert2/dist/sweetalert2.min' . $aRemoveCache['js'],
            'LoadingClass' . $aRemoveCache['js'],
            'LogPluginColetores.core/coletor-app' . $aRemoveCache['js'],
            'LogPluginColetores.ColetorMaritimo/routes' . $aRemoveCache['js'],
            'LogPluginColetores.core/routes-manager' . $aRemoveCache['js'],
            'LogPluginColetores.core/online' . $aRemoveCache['js'],
            'LogPluginColetores.core/prevent-load-page' . $aRemoveCache['js'],
            'LogPluginColetores.core/doJson' . $aRemoveCache['js'],
            'LogPluginColetores.core/simpleRequest' . $aRemoveCache['js'],
            'LogPluginColetores.core/simpleRender' . $aRemoveCache['js'],
            'LogPluginColetores.core/simpleMask' . $aRemoveCache['js'],
            'LogPluginColetores.core/simpleRules' . $aRemoveCache['js'],
            'LogPluginColetores.core/simpleNumber' . $aRemoveCache['js'],
            'LogPluginColetores.core/simpleDate' . $aRemoveCache['js'],
            'LogPluginColetores.core/array_polyfill' . $aRemoveCache['js'],
            'LogPluginColetores.core/string_polyfill' . $aRemoveCache['js'],
            'LogPluginColetores.core/inputMasks' . $aRemoveCache['js'],
            'LogPluginColetores.core/subject' . $aRemoveCache['js'],
            'LogPluginColetores.core/state' . $aRemoveCache['js'],
            'LogPluginColetores.core/object-util' . $aRemoveCache['js'],
            'StateClass' . $aRemoveCache['js'],
            '/js/Utils'. $aRemoveCache['js'],
        ]); ?>

        <?php
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="coletor-app">
        <?= $this->element('Loader/loader') ?> 

        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>

        <div class="offline hide">Sem conexão com a internet!</div>
    </body>
</html>
