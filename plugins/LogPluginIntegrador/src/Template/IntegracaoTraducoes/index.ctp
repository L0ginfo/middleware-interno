<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IntegracaoTraducao[]|\Cake\Collection\CollectionInterface $integracaoTraducoes
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Integracao Traducoes') ?>
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('New ') . __('Integracao Traducao'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create('integracaoTraducoes') ?>
    <div class="table-responsive lf-overflow-unset">
        <table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort( __('id') ) ?></th>
                        <th scope="col"><?= $this->Paginator->sort( __('integracao_id') ) ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($integracaoTraducoes as $integracaoTraducao): ?>
                <tr>
                    <td><?= $this->Number->format($integracaoTraducao->id) ?></td>
                    <td><?= $integracaoTraducao->has('integracao') ? $this->Html->link($integracaoTraducao->integracao->descricao, ['controller' => 'Integracoes', 'action' => 'view', $integracaoTraducao->integracao->id]) : '' ?></td>
                    <td width='120px' class="column-actions" align="center">
                        <?= $this->element('Buttons/button-dropdown', [
                            'sTitle' => 'Ações',
                            'sDirOpen' => 'right',
                            'aLinks' => [
                                $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $integracaoTraducao->id], ['escape' => false]),
                                $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ' . __('Editar'), ['action' => 'edit', $integracaoTraducao->id], ['escape' => false]),
                                $this->Form->postLink(__(''), ['action' => 'delete', $integracaoTraducao->id], ['class' => 'hide', 'confirm' => __('Are you sure you want to delete # {0}?', $integracaoTraducao->id)])
                                .
                                $this->Form->postLink('<span class="glyphicon glyphicon-remove-circle"></span> ' . __('Excluir'), ['action' => 'delete', $integracaoTraducao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $integracaoTraducao->id), 'escape' => false])
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

<?php 
    // Scripts
    $this->start('script');
        echo $this->Html->script([
            //'Datatables/datatables-tools',
        ]);
    $this->end();
?>
