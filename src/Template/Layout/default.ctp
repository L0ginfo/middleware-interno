<!DOCTYPE html>
<?php
use Cake\Core\Configure;

$custom  = Configure::read('App.custom');
$empresa  = Configure::read('App.empresa');
$img  = Configure::read('App.imageBaseUrl');?>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="">

        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Login - <?= $empresa ?>
        </title>

        <?=  $this->Html->meta('tab_logo.png', $sLogoImgTab, array('type' => 'icon'));
        ?>
        <?=
        $this->Html->css([
            $custom.'bootstrap/dist/css/bootstrap.min',
            '/node_modules/sweetalert2/dist/sweetalert2.min'
        ])
        ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>

        <?= $this->Html->script([
            '/bower_components/jquery/dist/jquery.min',
            '/js/LoadingClass',
            '/js/Utils',
            '/node_modules/sweetalert2/dist/sweetalert2.min'
        ]); ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>

    </body>
</html>
