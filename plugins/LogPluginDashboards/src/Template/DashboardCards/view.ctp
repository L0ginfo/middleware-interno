<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardCard
 */
 
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Dashboard Card') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Cards'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="dashboardCards view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Titulo') ?></dt>
            <dd><?= h($dashboardCard->titulo) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Cor') ?></dt>
            <dd><?= h($dashboardCard->cor) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Url') ?></dt>
            <dd><?= h($dashboardCard->url) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Controller') ?></dt>
            <dd><?= h($dashboardCard->controller) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Action') ?></dt>
            <dd><?= h($dashboardCard->action) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Icone') ?></dt>
            <dd><?= h($dashboardCard->icone) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Consulta Coluna Dado') ?></dt>
            <dd><?= h($dashboardCard->consulta_coluna_dado) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Dashboard') ?></dt>
            <dd><?= $dashboardCard->has('dashboard') ? $this->Html->link($dashboardCard->dashboard->descricao, ['controller' => 'Dashboards', 'action' => 'view', $dashboardCard->dashboard->id]) : '' ?></dd>
        </dl>
    </div>
        

        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($dashboardCard->id) ?></dd>
        </dl>
    </div>
        


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Ordem') ?></dt>
            <dd><?= $this->Number->format($dashboardCard->ordem) ?></dd>
        </dl>
    </div>
        

    </table>

<div class="clearfix"></div>

</div>
