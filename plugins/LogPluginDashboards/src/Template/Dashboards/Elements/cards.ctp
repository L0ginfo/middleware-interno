<?php

use Cake\Routing\Router;

?>
<div class="row">
        <div class="col-lg-3 col-md-6">
            <a href="<?= Router::url('/documentacao-entrada', true) ?>">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-truck-loading  fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"> </div>
                                <div>Documentação<br> de Entrada</div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left"><?= $this->AclHtml->link('Acessar ', ['controller' => 'DocumentacaoEntrada', 'action' => 'index'], ['escape' => false]) ?></span>
                        <span class="pull-right"><?= $this->AclHtml->link('<i class="fa fa-arrow-circle-right"></i> ', ['controller' => 'DocumentacaoEntrada', 'action' => 'index'], ['escape' => false]) ?></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <a href="<?= Router::url('/liberacoes-documentais', true) ?>">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-alt  fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"> </div>
                                <div>Liberações Documentais</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"><?= $this->AclHtml->link('Acessar', ['controller' => 'LiberacoesDocumentais', 'action' => 'index'], ['escape' => false]) ?></span>
                            <span class="pull-right"><?= $this->AclHtml->link('<i class="fa fa-arrow-circle-right"></i>', ['controller' => 'LiberacoesDocumentais', 'action' => 'index'], ['escape' => false]) ?></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </a>
        </div>
        <!-- <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <a href="<?= Router::url('/faturamentos', true) ?>">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-file-invoice-dollar fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"></div>
                            <div>Faturamentos</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left"><?= $this->Html->link('Acessar', ['controller' => 'Faturamentos', 'action' => 'index'], ['escape' => false]) ?></span>
                        <span class="pull-right"><?= $this->Html->link('<i class="fa fa-arrow-circle-right"></i>', ['controller' => 'Faturamentos', 'action' => 'index'], ['escape' => false]) ?></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </a>
        </div> -->

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <a href="<?= Router::url('/resvs', true) ?>">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-torii-gate fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"></div>
                                <div>Controle de Gate</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"><?= $this->Html->link('Acessar', ['controller' => 'Resvs', 'action' => 'index'], ['escape' => false]) ?></span>
                            <span class="pull-right"><?= $this->Html->link('<i class="fa fa-arrow-circle-right"></i>', ['controller' => 'Resvs', 'action' => 'index'], ['escape' => false]) ?></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="panel panel-purple">                
                <a href="<?= Router::url('/manutencao-estoques', true) ?>">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-cogs  fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"> </div>
                                <div>Manutenções de Estoque</div>
                            </div>
                        </div>
                    </div>
                        <div class="panel-footer">
                            <span class="pull-left"><?= $this->Html->link('Acessar', ['controller' => 'ManutencaoEstoques', 'action' => 'index'], ['escape' => false]) ?></span>
                            <span class="pull-right"><?= $this->Html->link('<i class="fa fa-arrow-circle-right"></i>', ['controller' => 'ManutencaoEstoques', 'action' => 'index'], ['escape' => false]) ?></span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </a>
        </div>
    </div>