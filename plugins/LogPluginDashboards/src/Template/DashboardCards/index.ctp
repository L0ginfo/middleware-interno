<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $dashboardCards
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Dashboard Cards') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('New ') . __('Dashboard Card'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create('dashboardCards') ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort( __('id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('titulo') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('ordem') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('cor') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('url') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('controller') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('action') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('icone') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('consulta_coluna_dado') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('dashboard_id') ) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>


        <tr>
            <?php $this->Form->templates($form_templates['index']) ?>
            
            <td scope="col"><?= $this->Form->input('id') ?></td>
            <td scope="col"><?= $this->Form->input('titulo') ?></td>
            <td scope="col"><?= $this->Form->input('ordem') ?></td>
            <td scope="col"><?= $this->Form->input('cor') ?></td>
            <td scope="col"><?= $this->Form->input('url') ?></td>
            <td scope="col"><?= $this->Form->input('controller') ?></td>
            <td scope="col"><?= $this->Form->input('action') ?></td>
            <td scope="col"><?= $this->Form->input('icone') ?></td>
            <td scope="col"><?= $this->Form->input('consulta_coluna_dado') ?></td>
            <td scope="col"><?= $this->Form->input('dashboard_id') ?></td>
            <td> <?= $this->Html->link('<span class="glyphicon glyphicon-refresh" title="Limpar"></span>', ['action' => 'index'], ['escape' => false]) ?></td>

        </tr>


    </thead>
    <tbody>
        <?php foreach ($dashboardCards as $dashboardCard): ?>
        <tr>
        <td><?= $this->Number->format($dashboardCard->id) ?></td>
                    <td><?= h($dashboardCard->titulo) ?></td>
        <td><?= $this->Number->format($dashboardCard->ordem) ?></td>
                    <td><?= h($dashboardCard->cor) ?></td>
            <td><?= h($dashboardCard->url) ?></td>
            <td><?= h($dashboardCard->controller) ?></td>
            <td><?= h($dashboardCard->action) ?></td>
            <td><?= h($dashboardCard->icone) ?></td>
            <td><?= h($dashboardCard->consulta_coluna_dado) ?></td>
            <td><?= $dashboardCard->has('dashboard') ? $this->Html->link($dashboardCard->dashboard->descricao, ['controller' => 'Dashboards', 'action' => 'view', $dashboardCard->dashboard->id]) : '' ?></td>
            <td width='120px' class="column-actions" align="center">
                <?= $this->element('Buttons/button-dropdown', [
                    'sTitle' => 'Ações',
                    'sDirOpen' => 'right',
                    'aLinks' => [
                        $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $dashboardCard->id], ['escape' => false]),
                        $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ' . __('Editar'), ['action' => 'edit', $dashboardCard->id], ['escape' => false]),
                        $this->Form->postLink(__(''), ['action' => 'delete', $dashboardCard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardCard->id)])
                        .
                        $this->Form->postLink('<span class="glyphicon glyphicon-remove-circle"></span> ' . __('Excluir'), ['action' => 'delete', $dashboardCard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardCard->id), 'escape' => false])
                    ]
                ]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>


    <tfoot>
        <tr>
            <td scope="col"><?= $this->Paginator->sort( __('id') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('titulo') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('ordem') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('cor') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('url') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('controller') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('action') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('icone') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('consulta_coluna_dado') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('dashboard_id') ) ?></td>
            <td scope="col" class="actions"><?= __('Actions') ?></td>
        </tr>
    </tfoot>
    </table>
</div>
    
<?= $this->element('pagination') ?>
<?= $this->Form->end() ?>
<?= $this->Html->script(['pesquisa_tela']) ?>