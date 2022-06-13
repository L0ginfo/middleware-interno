<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $dashboards
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Dashboards') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('New ') . __('Dashboard'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create('dashboards') ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort( __('id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('titulo') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('perfil_id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('usuario_id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('ordem') ) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>


        <tr>
            <?php $this->Form->templates($form_templates['index']) ?>
            
            <td scope="col"><?= $this->Form->input('id') ?></td>
            <td scope="col"><?= $this->Form->input('titulo') ?></td>
            <td scope="col"><?= $this->Form->input('perfil_id') ?></td>
            <td scope="col"><?= $this->Form->input('usuario_id') ?></td>
            <td scope="col"><?= $this->Form->input('ordem') ?></td>
            <td> <?= $this->Html->link('<span class="glyphicon glyphicon-refresh" title="Limpar"></span>', ['action' => 'index'], ['escape' => false]) ?></td>

        </tr>


    </thead>
    <tbody>
        <?php foreach ($dashboards as $dashboard): ?>
        <tr>
        <td><?= $this->Number->format($dashboard->id) ?></td>
                    <td><?= h($dashboard->titulo) ?></td>
            <td><?= $dashboard->has('perfil') ? $this->Html->link($dashboard->perfil->id, ['controller' => 'Perfis', 'action' => 'view', $dashboard->perfil->id]) : '' ?></td>
            <td><?= $dashboard->has('usuario') ? $this->Html->link($dashboard->usuario->id, ['controller' => 'Usuarios', 'action' => 'view', $dashboard->usuario->id]) : '' ?></td>
        <td><?= $this->Number->format($dashboard->ordem) ?></td>
                    <td width='120px' class="column-actions" align="center">
                <?= $this->element('Buttons/button-dropdown', [
                    'sTitle' => 'Ações',
                    'sDirOpen' => 'right',
                    'aLinks' => [
                        $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $dashboard->id], ['escape' => false]),
                        $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ' . __('Editar'), ['action' => 'edit', $dashboard->id], ['escape' => false]),
                        $this->Form->postLink(__(''), ['action' => 'delete', $dashboard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboard->id)])
                        .
                        $this->Form->postLink('<span class="glyphicon glyphicon-remove-circle"></span> ' . __('Excluir'), ['action' => 'delete', $dashboard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboard->id), 'escape' => false])
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
            <td scope="col"><?= $this->Paginator->sort( __('perfil_id') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('usuario_id') ) ?></td>
            <td scope="col"><?= $this->Paginator->sort( __('ordem') ) ?></td>
            <td scope="col" class="actions"><?= __('Actions') ?></td>
        </tr>
    </tfoot>
    </table>
</div>
    
<?= $this->element('pagination') ?>
<?= $this->Form->end() ?>
<?= $this->Html->script(['pesquisa_tela']) ?>