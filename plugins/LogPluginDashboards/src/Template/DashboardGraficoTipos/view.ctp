<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardGraficoTipo
 */
 
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Dashboard Grafico Tipo') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Grafico Tipos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="dashboardGraficoTipos view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Descricao') ?></dt>
            <dd><?= h($dashboardGraficoTipo->descricao) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Grafico Params') ?></dt>
            <dd><?= h($dashboardGraficoTipo->grafico_params) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Dashboard Grafico Formato') ?></dt>
            <dd><?= $dashboardGraficoTipo->has('dashboard_grafico_formato') ? $this->Html->link($dashboardGraficoTipo->dashboard_grafico_formato->descricao, ['controller' => 'DashboardGraficoFormatos', 'action' => 'view', $dashboardGraficoTipo->dashboard_grafico_formato->id]) : '' ?></dd>
        </dl>
    </div>
        

        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($dashboardGraficoTipo->id) ?></dd>
        </dl>
    </div>
        

    </table>

<div class="clearfix"></div>

    <!--div class="related">
        <h4><?= __('Related Dashboard Graficos') ?></h4>
        <?php if (!empty($dashboardGraficoTipo->dashboard_graficos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Responsive Options') ?></th>
                <th scope="col"><?= __('Consulta Id') ?></th>
                <th scope="col"><?= __('Dashboard Id') ?></th>
                <th scope="col"><?= __('Dashboard Grafico Tipo Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($dashboardGraficoTipo->dashboard_graficos as $dashboardGraficos): ?>
            <tr>
                <td><?= h($dashboardGraficos->id) ?></td>
                <td><?= h($dashboardGraficos->responsive_options) ?></td>
                <td><?= h($dashboardGraficos->consulta_id) ?></td>
                <td><?= h($dashboardGraficos->dashboard_id) ?></td>
                <td><?= h($dashboardGraficos->dashboard_grafico_tipo_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DashboardGraficos', 'action' => 'view', $dashboardGraficos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DashboardGraficos', 'action' => 'edit', $dashboardGraficos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DashboardGraficos', 'action' => 'delete', $dashboardGraficos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardGraficos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div-->
</div>
