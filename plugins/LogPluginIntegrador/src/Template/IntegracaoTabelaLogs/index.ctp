<?php
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Integracao Tabela Logs') ?>
</h1>

<?= $this->Form->create('integracaoTabelaLogs') ?>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-condensed table-striped" id="resultados">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort( __('id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('integracao_id') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('tabela') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('coluna') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('operacao') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('status') ) ?></th>
                <th scope="col"><?= $this->Paginator->sort( __('create_at') ) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>


            <tr>
                <?php $this->Form->templates($form_templates['index']) ?>
                <td scope="col"><?= $this->Form->input('id') ?></td>
                <td scope="col"><?= $this->Form->input('integracao_id') ?></td>
                <td scope="col"><?= $this->Form->input('tabela') ?></td>
                <td scope="col"><?= $this->Form->input('coluna') ?></td>
                <td scope="col"><?= $this->Form->input('operacao') ?></td>
                <td scope="col"><?= $this->Form->input('status') ?></td>
                <td scope="col"><?= $this->Form->input('create_at') ?></td>
                <td> <?= $this->Html->link('<span class="glyphicon glyphicon-refresh" title="Limpar"></span>', ['action' => 'index'], ['escape' => false]) ?>
                </td>

            </tr>


        </thead>
        <tbody>
            <?php foreach ($integracaoTabelaLogs as $integracaoTabelaLog): ?>
            <tr>
                <td><?= $this->Number->format($integracaoTabelaLog->id) ?></td>
                <td><?= $integracaoTabelaLog->has('integracao') ? 
                    $this->Html->link($integracaoTabelaLog->integracao->descricao, ['controller' => 'Integracoes', 'action' => 'view', $integracaoTabelaLog->integracao->id]) : '' ?>
                </td>
                <td><?= h($integracaoTabelaLog->tabela) ?></td>
                <td><?= $this->Number->format($integracaoTabelaLog->coluna) ?></td>
                <td><?= h($integracaoTabelaLog->operacao) ?></td>
                <td><?= $this->Number->format($integracaoTabelaLog->status) ?></td>
                <td><?= $integracaoTabelaLog->create_at ?> </td>
                <td width='120px' class="column-actions" align="center">
                    <?= $this->element('Buttons/button-dropdown', [
                    'sTitle' => 'Ações',
                    'sDirOpen' => 'right',
                    'aLinks' => [
                        $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span> ' . __('Visualizar'), ['action' => 'view', $integracaoTabelaLog->id], ['escape' => false]),
                    ]
                ]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>


        <tfoot>
            <tr>
                <td scope="col"><?= $this->Paginator->sort( __('id') ) ?></td>
                <td scope="col"><?= $this->Paginator->sort( __('integracao_id') ) ?></td>
                <td scope="col"><?= $this->Paginator->sort( __('tabela') ) ?></td>
                <td scope="col"><?= $this->Paginator->sort( __('coluna') ) ?></td>
                <th scope="col"><?= $this->Paginator->sort( __('operacao') ) ?></th>
                <td scope="col"><?= $this->Paginator->sort( __('status') ) ?></td>
                <th scope="col"><?= $this->Paginator->sort( __('create_at') ) ?></th>
                <td scope="col" class="actions"><?= __('Actions') ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<?= $this->element('pagination') ?>
<?= $this->Form->end() ?>
<?= $this->Html->script(['pesquisa_tela']) ?>