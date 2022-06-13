<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardGrafico
 */
 
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Dashboard Grafico') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Graficos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="dashboardGraficos view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Responsive Options') ?></dt>
            <dd><?= h($dashboardGrafico->responsive_options) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Consulta') ?></dt>
            <dd><?= $dashboardGrafico->has('consulta') ? $this->Html->link($dashboardGrafico->consulta->id, ['controller' => 'Consultas', 'action' => 'view', $dashboardGrafico->consulta->id]) : '' ?></dd>
        </dl>
    </div>
        

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Dashboard') ?></dt>
            <dd><?= $dashboardGrafico->has('dashboard') ? $this->Html->link($dashboardGrafico->dashboard->descricao, ['controller' => 'Dashboards', 'action' => 'view', $dashboardGrafico->dashboard->id]) : '' ?></dd>
        </dl>
    </div>
        

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Dashboard Grafico Tipo') ?></dt>
            <dd><?= $dashboardGrafico->has('dashboard_grafico_tipo') ? $this->Html->link($dashboardGrafico->dashboard_grafico_tipo->descricao, ['controller' => 'DashboardGraficoTipos', 'action' => 'view', $dashboardGrafico->dashboard_grafico_tipo->id]) : '' ?></dd>
        </dl>
    </div>
        

        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($dashboardGrafico->id) ?></dd>
        </dl>
    </div>
        


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Ordem') ?></dt>
            <dd><?= $this->Number->format($dashboardGrafico->ordem) ?></dd>
        </dl>
    </div>
        

    </table>

<div class="clearfix"></div>

</div>
