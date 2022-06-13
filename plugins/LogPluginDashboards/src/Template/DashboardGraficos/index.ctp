<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $dashboardGraficos
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Dashboard Graficos') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('New ') . __('Dashboard Grafico'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create('dashboardGraficos') ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort( __('id') ) ?></th>
            <th scope="col"><?= $this->Paginator->sort( __('titulo') ) ?></th>
            <th scope="col"><?= $this->Paginator->sort( __('ordem') ) ?></th>
            <th scope="col"><?= $this->Paginator->sort( __('consulta_id') ) ?></th>
            <th scope="col"><?= $this->Paginator->sort( __('dashboard_id') ) ?></th>
            <th scope="col"><?= $this->Paginator->sort( __('dashboard_grafico_tipo_id') ) ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dashboardGraficos as $dashboardGrafico): ?>
        <tr>
            <td><?= $this->Number->format($dashboardGrafico->id) ?></td>
            <td><?= $dashboardGrafico->titulo ?></td>
            <td><?= $this->Number->format($dashboardGrafico->ordem) ?></td>
            <td><?= $dashboardGrafico->has('consulta') ? $this->Html->link($dashboardGrafico->consulta->codigo, ['controller' => 'Consultas', 'action' => 'view', $dashboardGrafico->consulta->id]) : '' ?></td>
            <td><?= $dashboardGrafico->has('dashboard') ? $this->Html->link($dashboardGrafico->dashboard->titulo, ['controller' => 'Dashboards', 'action' => 'view', $dashboardGrafico->dashboard->id]) : '' ?></td>
            <td><?= $dashboardGrafico->has('dashboard_grafico_tipo') ? $this->Html->link($dashboardGrafico->dashboard_grafico_tipo->descricao, ['controller' => 'DashboardGraficoTipos', 'action' => 'view', $dashboardGrafico->dashboard_grafico_tipo->id]) : '' ?></td>
            <td width='120px' class="column-actions" align="center">
                <?= $this->element('Buttons/button-dropdown', [
                    'sTitle' => 'Ações',
                    'sDirOpen' => 'right',
                    'aLinks' => [
                        $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $dashboardGrafico->id], ['escape' => false]),
                        $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ' . __('Editar'), ['action' => 'edit', $dashboardGrafico->id], ['escape' => false]),
                        $this->Form->postLink(__(''), ['action' => 'delete', $dashboardGrafico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardGrafico->id)])
                        .
                        $this->Form->postLink('<span class="glyphicon glyphicon-remove-circle"></span> ' . __('Excluir'), ['action' => 'delete', $dashboardGrafico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardGrafico->id), 'escape' => false])
                    ]
                ]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>
    
<?= $this->element('pagination') ?>
<?= $this->Form->end() ?>
<?= $this->Html->script(['pesquisa_tela']) ?>