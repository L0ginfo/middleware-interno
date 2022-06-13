<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Integracao[]|\Cake\Collection\CollectionInterface $integracoes
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Integrações') ?>
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('New ') . __('Integracao'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create('integracoes') ?>
    <div class="table-responsive lf-overflow-unset">
        <table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort( __('tipo') ) ?></th>
                    <th scope="col"><?= $this->Paginator->sort( __('nome') ) ?></th>
                    <th scope="col"><?= $this->Paginator->sort( __('codigo_unico') ) ?></th>
                    <th scope="col"><?= $this->Paginator->sort( __('ativo') ) ?></th>
                    <th scope="col"><?= $this->Paginator->sort( __('gravar_log') ) ?></th>
                    <th scope="col"><?= $this->Paginator->sort( __('data_integracao') ) ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($integracoes as $integracao): ?>
                <tr>
                    <td><?= h($integracao->tipo) ?></td>
                    <td><?= h($integracao->nome) ?></td>
                    <td><?= h($integracao->codigo_unico) ?></td>
                    <td><?= h( ($integracao->ativo) ? 'Sim' : 'Não' ) ?></td>
                    <td><?= $this->Number->format($integracao->gravar_log) ?></td>
                    <td><?= h($integracao->data_integracao) ?></td>
                    <td width='120px' class="column-actions" align="center">
                        <?= $this->element('Buttons/button-dropdown', [
                            'sTitle' => 'Ações',
                            'sDirOpen' => 'right',
                            'aLinks' => [
                                $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $integracao->id], ['escape' => false]),
                                $this->Html->link('<span class="glyphicon glyphicon-edit"></span> ' . __('Editar'), ['action' => 'edit', $integracao->id], ['escape' => false]),
                                $this->Form->postLink(__(''), ['action' => 'delete', $integracao->id], ['class' => 'hide', 'confirm' => __('Are you sure you want to delete # {0}?', $integracao->id)])
                                .
                                $this->Form->postLink('<span class="glyphicon glyphicon-remove-circle"></span> ' . __('Excluir'), ['action' => 'delete', $integracao->id], ['confirm' => __('Are you sure you want to delete # {0}?', $integracao->id), 'escape' => false])
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
