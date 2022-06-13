<!DOCTYPE html>
<?php

use App\Model\Entity\ParametroGeral;
use App\RegraNegocio\ControleCampos\ControleCamposManager;
use App\Util\LoginfoAnalyticsUtil;
use App\Util\SessionUtil;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

$custom = Configure::read('App.custom');
$full_url = Configure::read('App.full_url');
$empresa = Configure::read('App.empresa');
$full_url = Router::url('/', true);


(isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');

?>

<html translate="no">
    <head>
        <meta name="google" content="notranslate">
        <meta http-equiv="X-UA-Compatible Content-Security-Policy" content="IE=edge upgrade-insecure-requests">
        <meta nafme="description" content="">
        <meta name="author" content="">

        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title>
            <?=  __( Cake\Utility\Inflector::humanize( $this->fetch('title') ) ) ?>
        </title>

        <script>webroot = '<?= $this->request->webroot ?>'</script>
        <script>url = '<?= $full_url ?>'</script>
        <script>custom = url + '<?= $custom ?>'</script>
        <script>controller = '<?= str_replace('_', '-', Inflector::underscore($this->request->params['controller']))  ?>'</script>
        <script>action = '<?= str_replace('_', '-', Inflector::underscore($this->request->params['action']))  ?>'</script>

        <script>
            const sNameController= '<?=$this->request->params['controller']?>';
            const sNameAction ='<?=$this->request->params['action']?>';
            const sPerfilUsurio = '<?= SessionUtil::getPerfilUsuario()?>';
            const oControleCampos = <?= ControleCamposManager::getJson()?>;
        </script>
    
        <?php
        echo $this->Html->meta('tab_logo.png', $sLogoImgTab, array('type' => 'icon'));
        
        echo $this->Html->css([
            //$custom . 'bootstrap/dist/css/bootstrap',
            //'datatables.min',
            //'/bower_components/metisMenu/dist/metisMenu.min',
            //'/bower_components/assets/css/demo',
            //'/bower_components/assets/vendor/linearicons/style',
            //'/bower_components/font-awesome/css/font-awesome.min',
            //$custom . 'dist/css/sb-admin-2',
            //'bootstrap-datepicker3',
            //'jquery.fancybox',
            //'jquery.fancybox-buttons',
            //'jquery.fancybox-thumbs',
            //'style',
            //'jquery.qtip.min.css',
            //'/bower_components/bootstrap-select/dist/css/bootstrap-select',
            //'/bower_components/assets/css/main',
            //'/custom_pontanegra/fontawesome/css/all.css',
            '/node_modules/sweetalert2/dist/sweetalert2.min.css',
            //'/node_modules/icheck-material/icheck-material.min.css',
            //'menu.css',
            '/node_modules/metismenu/dist/metisMenu.min',
            //'all_styles.css?v='.date('YmdHis'),
            //'animations.css'
        ]);

        echo $this->Html->script([
            // '/dist/bundle-js.min.js?v='.date('Ymd'),
            // '/dist/bundle-css.min.js?v='.date('Ymd')
             '/dist/bundle.js?v='.date('Ymd')
            // '/dist/bundle-all.min.js?v='.date('Ymd')
        ]);

        echo $this->Html->script([
            'ControleCamposManager'
        ]);

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');

        
        ?>

        <?php if(isset($sMainColor) && isset($sMainColorDarker) && isset($sMainColorBorder)):?>
            <style>
                :root {
                    --main-color: <?= $sMainColor ?> !important;
                    --main-color-darker: <?= $sMainColorDarker ?> !important;
                    --main-color-border: <?= $sMainColorBorder ?> !important; 
                }

                <?php if ($sMainColorFundoTopBar) : ?>
                    .top-bar, .top-bar .dropdown-toggle, .top-bar .dropdown-menu {
                        background: <?= $sMainColorFundoTopBar ?> !important;
                    }

                    .top-bar .dropdown-menu li a{
                        background: <?= $sMainColorFundoTopBar ?> !important;
                    }
                <?php endif; ?>

                <?php if ($sMainColorFonteMenu) : ?>
                    .top-bar a, .top-bar span, .top-bar i {
                        color: <?= $sMainColorFonteMenu ?> !important;
                    }

                    .vertical-nav .nav-list a, .vertical-nav .nav-list span, .vertical-nav .nav-list i, .vertical-nav .nav-list div {
                        color: <?= $sMainColorFonteMenu ?> !important;
                    }

                    .vertical-nav .profile i{
                        color: <?= $sMainColorFonteMenu ?> !important;
                    }

                <?php endif; ?>

                <?php if ($sMainColorFundoMenu) : ?>
                    .vertical-nav {
                        background: <?= $sMainColorFundoMenu ?> !important;
                    }
                    .vertical-nav .branding {
                        background: <?= $sMainColorFundoMenu ?> !important;
                    }

                    .vertical-nav .profile {
                        background: <?= $sMainColorFundoMenu ?> !important;
                    }
                <?php endif; ?>
            
            </style>
        <?php endif;?>        
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class='main-class <?= Cake\Utility\Inflector::dasherize( $this->name ) . ' ' . $this->request->params['action'] ?>'>
        <?= $this->element('Loader/loader') ?> 
        <div class="hidden std-class" data-class='<?= Cake\Utility\Inflector::dasherize( $this->name ) ?>'></div>
        <?php $primeiro_nome = explode(' ', $this->request->session()->read('Auth.User.nome')); ?>
        <div id="wrapper">
          
            <!-- Header -->
            <?= $this->element('header'); ?>

            <!-- Sidebar - Menu -->
            <?= $this->element('menu'); ?>
            
            <!-- Main -->
            <div >
                <div class="main-content">
                    <div class="container-fluid">
                        <?= $this->Flash->render() ?>
                        <div class="panel panel-headline" id="content">
                            <?= $this->fetch('content') ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $this->element('Components/Modal/generic', [
                'name' => '',
                'id' => 'modal-save-back',
                'footer' => false,
                'form' => function () {
                    return '';
                }
            ]); ?>
            
        </div>

        <?php if (@$_SESSION['focus_to']) :?>
            <script>
                $(window).load(function() {
                    setTimeout(function() {
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $('<?= $_SESSION['focus_to'] ?>').offset().top
                        }, 400);

                        setTimeout(function() {
                            $('<?= $_SESSION['focus_to'] ?>').focus()
                        }, 410)
                    }, 500)
                })
            </script>

            <?php unset($_SESSION['focus_to']) ?>
        <?php endif; ?>

        <?= LoginfoAnalyticsUtil::initEntry($this) ?>
    </body>
</html>
