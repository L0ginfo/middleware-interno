<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Template[]|\Cake\Collection\CollectionInterface $templates
 */

?>

<h1 class="page-header">
    <?= __('Templates') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('New ') . __('Template'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create('templates') ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort( __('id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('descricao') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('codigo') ) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>


        <tr>
            <?php $this->Form->templates($form_templates['index']) ?>
            
            <td scope="col"><?= $this->Form->input('id') ?></td>
            <td scope="col"><?= $this->Form->input('descricao') ?></td>
            <td scope="col"><?= $this->Form->input('codigo') ?></td>
            <td> <?= $this->Html->link('<span class="glyphicon glyphicon-refresh" title="Limpar"></span>', ['action' => 'index'], ['escape' => false]) ?></td>

        </tr>


    </thead>
    <tbody>
        <?php foreach ($templates as $template): ?>
        <tr>
        <td><?= $this->Number->format($template->id) ?></td>
                    <td><?= h($template->descricao) ?></td>
            <td><?= h($template->codigo) ?></td>
            <td width='120px' class="column-actions" align="center">
                <?= $this->element('Buttons/button-dropdown', [
                    'sTitle' => 'Ações',
                    'sDirOpen' => 'right',
                    'aLinks' => [
                        //$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $template->id], ['escape' => false]),
                        $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ' . __('Editar'), ['action' => 'edit', $template->id], ['escape' => false]),
                        $this->Form->postLink(__(''), ['action' => 'delete', $template->id], ['confirm' => __('Are you sure you want to delete # {0}?', $template->id)])
                        .
                        $this->Form->postLink('<span class="glyphicon glyphicon-remove-circle"></span> ' . __('Excluir'), ['action' => 'delete', $template->id], ['confirm' => __('Are you sure you want to delete # {0}?', $template->id), 'escape' => false])
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
            <td scope="col"><?= $this->Paginator->sort( __('codigo') ) ?></td>
            <td scope="col" class="actions"><?= __('Actions') ?></td>
        </tr>
    </tfoot>
    </table>
</div>
    
<?= $this->element('pagination') ?>
<?= $this->Form->end() ?>
<?= $this->Html->script(['pesquisa_tela']) ?>