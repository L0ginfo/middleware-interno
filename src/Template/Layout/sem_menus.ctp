<!DOCTYPE html>
<?php

use Cake\Core\Configure;

$custom = Configure::read('App.custom');
$empresa = Configure::read('App.empresa');
$img = Configure::read('App.imageBaseUrl');
?>

<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="">

            <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
        <?= __($this->fetch('title')) ?>
        </title>

        <?php
        echo $this->Html->meta('favicon.ico', $img . '/favicon.ico', array('type' => 'icon'));
        // debug( $custom.'dist/css/sb-admin-2');die();
        // echo $this->Html->meta('icon');
        echo $this->Html->css([
            $custom . 'bootstrap/dist/css/bootstrap',
            'datatables.min',
            '/bower_components/metisMenu/dist/metisMenu.min',
            '/bower_components/font-awesome/css/font-awesome.min',
                'bootstrap-datepicker3',
            // 'jquery.fancybox',
            // 'jquery.fancybox-buttons',
            // 'jquery.fancybox-thumbs',
            'style',
            // 'jquery.qtip.min.css',
            '/bower_components/bootstrap-select/dist/css/bootstrap-select',
        ]);
        echo $this->Html->script([
            '/bower_components/jquery/dist/jquery.min',
            'datatables.min',
            $custom . 'bootstrap/dist/js/bootstrap.min',
            '/bower_components/metisMenu/dist/metisMenu.min',
            $custom . 'dist/js/sb-admin-2',
            'bootstrap-datepicker',
            '/locales/bootstrap-datepicker.pt-BR',
            'datepicker.config',
            // 'jquery.fancybox.pack',
            'jquery.mask.min',
            // 'jquery.qtip.min.js',
            '/bower_components/bootstrap-select/dist/js/bootstrap-select',
            'button',
            'geral'
        ]);
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
        <script>webroot = '<?= $this->request->webroot ?>'</script>
    </head>

    <body>

                    <div class="row" >
                    <div style='width: 100%'>

<?= $this->Flash->render() ?>
                        <!--   <div class="breadcrumb">
                        <?php
                        echo $this->Html->getCrumbs(' > ', [
                            'text' => '<span class="glyphicon glyphicon-home"></span>',
                            'url' => '/',
                            'escape' => false
                        ]);
                        ?>
                          </div>
                        <div  class="col-lg-4 text-right">
      <div class="fa fa-barcode " style="padding-right: 10px;font-size: 30px">
          <input name="barcode" id="barcode" class='pesquisar' style="width:200px"></div>
  </div>
                        -->
                        <div id="content">
<?= $this->fetch('content') ?>
                        </div>
                    </div>
                </div>


    </body>
</html>


