<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $dashboardGraficoTipos
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Dashboard Grafico Tipos') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('New ') . __('Dashboard Grafico Tipo'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create('dashboardGraficoTipos') ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort( __('id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('descricao') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('grafico_params') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('dashboard_grafico_formato_id') ) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>


        <tr>
            <?php $this->Form->templates($form_templates['index']) ?>
            
            <td scope="col"><?= $this->Form->input('id') ?></td>
            <td scope="col"><?= $this->Form->input('descricao') ?></td>
            <td scope="col"><?= $this->Form->input('grafico_params') ?></td>
            <td scope="col"><?= $this->Form->input('dashboard_grafico_formato_id') ?></td>
            <td> <?= $this->Html->link('<span class="glyphicon glyphicon-refresh" title="Limpar"></span>', ['action' => 'index'], ['escape' => false]) ?></td>

        </tr>


    </thead>
    <tbody>
        <?php foreach ($dashboardGraficoTipos as $dashboardGraficoTipo): ?>
        <tr>
        <td><?= $this->Number->format($dashboardGraficoTipo->id) ?></td>
                    <td><?= h($dashboardGraficoTipo->descricao) ?></td>
            <td><?= h($dashboardGraficoTipo->grafico_params) ?></td>
            <td><?= $dashboardGraficoTipo->has('dashboard_grafico_formato') ? $this->Html->link($dashboardGraficoTipo->dashboard_grafico_formato->descricao, ['controller' => 'DashboardGraficoFormatos', 'action' => 'view', $dashboardGraficoTipo->dashboard_grafico_formato->id]) : '' ?></td>
            <td width='120px' class="column-actions" align="center">
                <?= $this->element('Buttons/button-dropdown', [
                    'sTitle' => 'Ações',
                    'sDirOpen' => 'right',
                    'aLinks' => [
                        $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $dashboardGraficoTipo->id], ['escape' => false]),
                        $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ' . __('Editar'), ['action' => 'edit', $dashboardGraficoTipo->id], ['escape' => false]),
                        $this->Form->postLink(__(''), ['action' => 'delete', $dashboardGraficoTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardGraficoTipo->id)])
                        .
                        $this->Form->postLink('<span class="glyphicon glyphicon-remove-circle"></span> ' . __('Excluir'), ['action' => 'delete', $dashboardGraficoTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardGraficoTipo->id), 'escape' => false])
                    ]
                ]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>


    <tfoot>
        <tr>
            <td scope="col"><?= $this->Paginator->sort( __('id') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('descricao') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('grafico_params') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('dashboard_grafico_formato_id') ) ?></td>
            <td scope="col" class="actions"><?= __('Actions') ?></td>
        </tr>
    </tfoot>
    </table>
</div>
    
<?= $this->element('pagination') ?>
<?= $this->Form->end() ?>
<?= $this->Html->script(['pesquisa_tela']) ?>