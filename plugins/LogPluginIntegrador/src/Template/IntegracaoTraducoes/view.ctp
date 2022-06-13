<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IntegracaoTraducao $integracaoTraducao
 */
 
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Integracao Traducao') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Integracao Traducoes'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="integracaoTraducoes view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Integracao') ?></dt>
            <dd><?= $integracaoTraducao->has('integracao') ? $this->Html->link($integracaoTraducao->integracao->descricao, ['controller' => 'Integracoes', 'action' => 'view', $integracaoTraducao->integracao->id]) : '' ?></dd>
        </dl>
    </div>
        

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Nested Json Translate') ?></dt>
            <dd><?= h($integracaoTraducao->nested_json_translate) ?></dd>
        </dl>
    </div>


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($integracaoTraducao->id) ?></dd>
        </dl>
    </div>
        

    </table>

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Observacao') ?></dt>
            <dd><?= $this->Text->autoParagraph(h($integracaoTraducao->observacao)); ?></dd>
        </dl>
    </div>


<div class="clearfix"></div>

    <!--div class="related">
        <h4><?= __('Related Integracao Logs') ?></h4>
        <?php if (!empty($integracaoTraducao->integracao_logs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Integracao Id') ?></th>
                <th scope="col"><?= __('Integracao Traducao Id') ?></th>
                <th scope="col"><?= __('Url Requisitada') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Descricao') ?></th>
                <th scope="col"><?= __('Stackerror') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($integracaoTraducao->integracao_logs as $integracaoLogs): ?>
            <tr>
                <td><?= h($integracaoLogs->id) ?></td>
                <td><?= h($integracaoLogs->integracao_id) ?></td>
                <td><?= h($integracaoLogs->integracao_traducao_id) ?></td>
                <td><?= h($integracaoLogs->url_requisitada) ?></td>
                <td><?= h($integracaoLogs->status) ?></td>
                <td><?= h($integracaoLogs->descricao) ?></td>
                <td><?= h($integracaoLogs->stackerror) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'IntegracaoLogs', 'action' => 'view', $integracaoLogs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'IntegracaoLogs', 'action' => 'edit', $integracaoLogs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'IntegracaoLogs', 'action' => 'delete', $integracaoLogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $integracaoLogs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div-->
</div>
