<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboard
 */
 
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Dashboard') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboards'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="dashboards view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Titulo') ?></dt>
            <dd><?= h($dashboard->titulo) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Perfil') ?></dt>
            <dd><?= $dashboard->has('perfil') ? $this->Html->link($dashboard->perfil->id, ['controller' => 'Perfis', 'action' => 'view', $dashboard->perfil->id]) : '' ?></dd>
        </dl>
    </div>
        

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Usuario') ?></dt>
            <dd><?= $dashboard->has('usuario') ? $this->Html->link($dashboard->usuario->id, ['controller' => 'Usuarios', 'action' => 'view', $dashboard->usuario->id]) : '' ?></dd>
        </dl>
    </div>
        

        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($dashboard->id) ?></dd>
        </dl>
    </div>
        


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Ordem') ?></dt>
            <dd><?= $this->Number->format($dashboard->ordem) ?></dd>
        </dl>
    </div>
        

    </table>

<div class="clearfix"></div>

    <!--div class="related">
        <h4><?= __('Related Dashboard Cards') ?></h4>
        <?php if (!empty($dashboard->dashboard_cards)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Titulo') ?></th>
                <th scope="col"><?= __('Ordem') ?></th>
                <th scope="col"><?= __('Cor') ?></th>
                <th scope="col"><?= __('Url') ?></th>
                <th scope="col"><?= __('Controller') ?></th>
                <th scope="col"><?= __('Action') ?></th>
                <th scope="col"><?= __('Icone') ?></th>
                <th scope="col"><?= __('Consulta Coluna Dado') ?></th>
                <th scope="col"><?= __('Dashboard Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($dashboard->dashboard_cards as $dashboardCards): ?>
            <tr>
                <td><?= h($dashboardCards->id) ?></td>
                <td><?= h($dashboardCards->titulo) ?></td>
                <td><?= h($dashboardCards->ordem) ?></td>
                <td><?= h($dashboardCards->cor) ?></td>
                <td><?= h($dashboardCards->url) ?></td>
                <td><?= h($dashboardCards->controller) ?></td>
                <td><?= h($dashboardCards->action) ?></td>
                <td><?= h($dashboardCards->icone) ?></td>
                <td><?= h($dashboardCards->consulta_coluna_dado) ?></td>
                <td><?= h($dashboardCards->dashboard_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DashboardCards', 'action' => 'view', $dashboardCards->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DashboardCards', 'action' => 'edit', $dashboardCards->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DashboardCards', 'action' => 'delete', $dashboardCards->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardCards->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div-->
    <!--div class="related">
        <h4><?= __('Related Dashboard Graficos') ?></h4>
        <?php if (!empty($dashboard->dashboard_graficos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Ordem') ?></th>
                <th scope="col"><?= __('Responsive Options') ?></th>
                <th scope="col"><?= __('Consulta Id') ?></th>
                <th scope="col"><?= __('Dashboard Id') ?></th>
                <th scope="col"><?= __('Dashboard Grafico Tipo Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($dashboard->dashboard_graficos as $dashboardGraficos): ?>
            <tr>
                <td><?= h($dashboardGraficos->id) ?></td>
                <td><?= h($dashboardGraficos->ordem) ?></td>
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
