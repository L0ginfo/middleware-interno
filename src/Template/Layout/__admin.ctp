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
        <meta nafme="description" content="">
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
            $custom . 'dist/css/sb-admin-2',
            'bootstrap-datepicker3',
            'jquery.fancybox',
            'jquery.fancybox-buttons',
            'jquery.fancybox-thumbs',
            'style',
            'jquery.qtip.min.css',
            '/bower_components/bootstrap-select/dist/css/bootstrap-select',
        ]);
        echo $this->Html->script([
            '/bower_components/jquery/dist/jquery.min',
            'datatables.min',
            'date-de.js',
            $custom . 'bootstrap/dist/js/bootstrap.min',
            '/bower_components/metisMenu/dist/metisMenu.min',
            $custom . 'dist/js/sb-admin-2',
            'bootstrap-datepicker',
                        'geral',
            '/locales/bootstrap-datepicker.pt-BR',
            'datepicker.config',
            'jquery.fancybox.pack',
            'jquery.mask.min',
            'jquery.qtip.min.js',
            '/bower_components/bootstrap-select/dist/js/bootstrap-select',
            'button',
            
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
        <style type="text/css">
            .sombra{
                box-shadow: 2px 2px 2px #363636;
                -webkit-box-shadow: 2px 2px 2px #363636;
                -moz-box-shadow: 2px 2px 2px #363636;
            }
        </style>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class="media">

                    </div>
                    <div class="navbar-left">

                        <img  class="logo_empresa"  src="<?= $this->request->webroot ?><?= $img ?>/nav-logo.png" alt="<?= $empresa ?> " height="70" width="83">
                    </div>
              

                    <!-- /.navbar-header -->
                    <!-- <div class="navbar-text">
                    <?=
                    __('Empresa selecionada:') . ' ' .
                    $this->Html->link($this->request->session()->read('nome_empresa') ? $this->request->session()->read('nome_empresa') : 'Escolha a empresa', ['controller' => 'Usuarios', 'action' => 'changeCompany'])
                    ?>
                    </div>
                    -->
                    <?php 
                           $primeiro_nome = explode(' ', $this->request->session()->read('Auth.User.nome'));
                           
                        
                        ?>
                        
                    <div class="navbar-left">
                        <ul class="nav navbar-top-links ">

                            <li class="navbar-text"><?= __('Bem-vindo(a)') . ' ' . $primeiro_nome[0]  ?></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">
                                            <?= $this->Html->link('<i class="fa fa-user fa-fw"></i>' . __('Meus dados'), ['controller' => 'usuarios', 'action' => 'meus-dados'], ['escape' => false]) ?>
                                    </li>
                                    <!--li>
                                    <?= $this->Html->link('<i class="fa fa-gear fa-fw"></i>' . __('Configurações'), ['controller' => 'usuarios', 'action' => 'configuracoes'], ['escape' => false]) ?>
                                    </li-->
                                    <li class="divider"></li>
                                    <li>
                                        <?= $this->Html->link('<i class="fa fa-sign-out fa-fw"></i>' . __('Sair'), ['controller' => 'usuarios', 'action' => 'logout'], ['escape' => false]) ?>
                                    </li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>
                    </div>  

                    <div class="navbar-header">
                          
                        <?php if (@IMAGEM_TOP) { ?>
                        <div style="margin-top: -10px; ">
                            <table  >
                                <tr>
                                    <td>
                                        <img style="margin-right:  10px; border: 1px; border-color:#EDBD26 " class="logo_empresa sombra" src="<?= $this->request->webroot ?>/<?= $img ?>banner_top/banner_1.jpg" alt="Rocha " height="68" width="300">       
                                    </td>
                                    <td>
                                           <img style="margin-right:  10px; border: 1px; border-color:#EDBD26 " class="logo_empresa sombra" src="<?= $this->request->webroot ?>/<?= $img ?>banner_top/banner_2.jpg" alt="Rocha " height="68" width="300">       
                                    </td>
                                    <td>
                                           <img style="margin-right:  10px; border: 1px; border-color:#EDBD26 " class="logo_empresa sombra" src="<?= $this->request->webroot ?>/<?= $img ?>banner_top/banner_3.jpg" alt="Rocha " height="68" width="300">       
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php } ?>

                    </div>
                </div>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <?= $this->Html->image('loader.gif', ['class' => 'ajaxloader']) ?>
                        <ul class="nav" id="side-menu">
                            <!--li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </li-->
                            <li>
                                <?= @$this->Html->link('<i class="glyphicon glyphicon-home fa-fw"></i> ' . __('Início'), '/inicio', ['escape' => false]) ?>
                            </li>
                            <?php
                            //if (
                            //        $this->AclHtml->link(null, ['controller' => 'usuarios', 'action' => 'index']) or
                            //        $this->AclHtml->link(null, ['controller' => 'UsuarioGrupos', 'action' => 'index'])
                            //) {
                            ?>


                            <?php
                            $menu = [
                                // controller, action, icone,nome
                                ['Usuarios', 'index', 'fa fa-user fa-fw'],
                                ['Perfis', 'index', 'fa fa-users fa-fw'],
                                ['Empresas', 'index', 'fa fa-institution fa-fw'],
                                ['Empresas', 'minhasEmpresas', 'fa fa-institution fa-fw', 'Clientes finais'],
                                ['Informativos', 'index', 'fa fa-institution fa-fw'],
                            ];
                            $submenu = [];
                            foreach ($menu as $m) {
                                $link = $this->AclHtml->link('<i class="' . $m[2] . '"></i> ' . __(@$m[3] ? $m[3] : $m[0]), ['controller' => $m[0], 'action' => $m[1]], ['escape' => false]);
                                if ($link) {
                                    $submenu [] = $link;
                                }
                            }
                            ?>
                            <?php if (count($submenu) > 0) { ?>
                                <li>
                                    <a href="javascript:return false;"><i class="fa fa-bar-chart-o fa-fw"></i> <?= __("Acesso") ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <?php
                                        //menu

                                        foreach ($submenu as $link) {
                                            ?>
                                            <li>
                                                <?= $link; ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </li>
                            <?php } ?>


                            <?php
                            $menu = [
                                // nome, action, icone,param, label
                                ['Horarios', 'index', 'glyphicon glyphicon-tasks', "", 'Horários'],
                                ['HorarioBloqueados', 'index', 'glyphicon glyphicon-tasks', "", 'Horários Bloqueados'],
                                ['HorarioDeRecursos', 'index', 'glyphicon glyphicon-tasks', "", 'Horários de Recursos'],
                                ['Operacoes', 'index', 'glyphicon glyphicon-resize-small', '', 'Tipos de Operações'],
                                ['TipoServicos', 'index', 'glyphicon glyphicon-th-list', '', 'Tipos de Serviços'],
                                ['TipoRecursos', 'index', 'glyphicon glyphicon-th-list', '', 'Tipos de Recursos'],
                            ];
                            $submenu = [];
                            foreach ($menu as $m) {
                                $link = $this->AclHtml->link('<i class="' . $m[2] . '"></i> ' . __(@$m[4] ? $m[4] : $m[0]), ['controller' => $m[0], 'action' => $m[1]], ['escape' => false]);
                                if ($link) {
                                    $submenu [] = $link;
                                }
                            }
                            ?>
                            <?php if (count($submenu) > 0) { ?>
                                <li>
                                    <a href="javascript:return false;"><i class="glyphicon glyphicon-cog"></i> <?= __("Configuração geral") ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <?php
                                        //menu

                                        foreach ($submenu as $link) {
                                            ?>
                                            <li>
                                                <?= $link; ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </li>
                            <?php } ?>



                            <?php
                            $menu = [
                                // nome, action, icone, parametros, label
                                ['Lotes', 'index', 'fa fa-unlock fa-fw', '', 'Processos'],
                                ['Entradas', 'index', 'fa fa-tasks fa-fw', '', 'Documentos de Entrada'],
                                ['Entradas', 'dtc', 'fa fa-book fa-fw', '', 'DTC'],
                                ['Agendamentos', 'calendario', 'fa fa-calendar fa-fw', '', CALENDARIO_LABEL],
                                ['Agendamentos', 'index', 'fa fa-book fa-fw', '', 'Programação'],
                                ['Agendamentos', 'transito', 'fa fa-book fa-fw', '', 'Agendamento Confirmado'],
                                ['Agendamentos', 'indicadores', 'fa fa-book fa-fw', '', 'Indicadores'],
                                // ['Agendamentos', 'selecionarItensCarga', 'fa fa-book fa-fw', '', 'Cargas do cliente'],
                                ['LiberadoClientefinais', 'index', 'fa fa-book fa-fw', '', 'Liberar para empresas'],
                            ];
                            $submenu = [];
                            foreach ($menu as $m) {
                                $link = $this->AclHtml->link('<i class="' . $m[2] . '"></i> ' . __((isset($m[4]) ? $m[4] : $m[0])), ['controller' => $m[0], 'action' => $m[1], (isset($m[3]) ? $m[3] : '')], ['escape' => false]);
                                if ($link) {
                                    $submenu [] = $link;
                                }
                            }
                            ?>
                            <?php if (count($submenu) > 0) { ?>
                                <li>
                                    <a href="javascript:return false;"><i class="fa fa-bars fa-fw"></i> <?= __("Agendamentos") ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <?php
                                        //menu

                                        foreach ($submenu as $link) {
                                            ?>
                                            <li>
                                                <?= $link; ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </li>
                            <?php } ?>
                            <?php
                            if (PENHOR_ATIVO) {

                                $menu = [
                                    // nome, action, icone, parametros, label
                                    ['InstituicoesFinanceiras', 'index', 'fa fa-bank fa-fw', '', 'Instituições Financeiras'],
                                    ['ContratosBloqueios', 'index', 'fa fa-tasks fa-fw', '', 'Contratos de Bloqueio'],
                                        //['LotesLiberados', 'index', 'fa fa-tasks fa-fw', '', 'Lotes Liberados']
                                ];
                                $submenu = [];
                                foreach ($menu as $m) {
                                    $link = $this->AclHtml->link('<i class="' . $m[2] . '"></i> ' . __((isset($m[4]) ? $m[4] : $m[0])), ['controller' => $m[0], 'action' => $m[1], (isset($m[3]) ? $m[3] : '')], ['escape' => false]);
                                    if ($link) {
                                        $submenu [] = $link;
                                    }
                                }
                                ?>


                                <?php if (count($submenu) > 0) { ?>
                                    <li>
                                        <a href="javascript:return false;"><i class="fa fa-bars fa-fw"></i> <?= __("Penhor") ?><span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <?php
                                            //menu

                                            foreach ($submenu as $link) {
                                                ?>
                                                <li>
                                                    <?= $link; ?>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>

                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            $menu = [
                                // nome, action, icone, parametros, label
                                ['Agendamentos', 'triagem', 'fa fa-book fa-fw', '1', 'Triagem'],
                                ['Agendamentos', 'aguardandoLiberacao', 'fa fa-book fa-fw', '', 'Aguardando Liberação'],
                                ['Lotes', 'entradas', 'fa fa-lock fa-fw', '', 'Lotes'],
                                ['LoteSolicitacoes', 'index', 'fa fa-lock fa-fw', '', 'Serviços'],
                            ];
                            $submenu = [];
                            foreach ($menu as $m) {
                                $link = $this->AclHtml->link('<i class="' . $m[2] . '"></i> ' . __((isset($m[4]) ? $m[4] : $m[0])), ['controller' => $m[0], 'action' => $m[1], (isset($m[3]) ? $m[3] : '')], ['escape' => false]);
                                if ($link) {
                                    $submenu [] = $link;
                                }
                            }
                            ?>
                            <?php if (count($submenu) > 0) { ?>
                                <li>
                                    <a href="javascript:return false;"><i class="fa fa-bars fa-fw"></i> <?= __("Operacional") ?><span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <?php
                                        //menu

                                        foreach ($submenu as $link) {
                                            ?>
                                            <li>
                                                <?= $link; ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </li>
                            <?php } ?>
                            <?php
//}
                            ?>

   <li>
                                    <a href="javascript:return false;"><i class="fa fa-bars fa-fw"></i> Mapa <span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        
                                            <li>
                                                <a href="http://agendamento.barradorio.com.br:7575/mapas/index/3"> Vistorias</a>
                                   
                                            </li>
                                      
                                    </ul>

                                </li>
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->


            </nav>
            <!-- Page Content -->
            <div id="page-wrapper">

                <div class="row" >
                    <div class="col-lg-12">

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

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

    </body>
</html>


