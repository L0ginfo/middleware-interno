<?php
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Integracao Tabela Log') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Integracao Tabela Logs'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="integracaoTabelaLogs view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Integracao') ?></dt>
            <dd><?= $integracaoTabelaLog->has('integracao') ? $this->Html->link($integracaoTabelaLog->integracao->descricao, ['controller' => 'Integracoes', 'action' => 'view', $integracaoTabelaLog->integracao->id]) : '' ?></dd>
        </dl>
    </div>
        

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Tabela') ?></dt>
            <dd><?= h($integracaoTabelaLog->tabela) ?></dd>
        </dl>
    </div>


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($integracaoTabelaLog->id) ?></dd>
        </dl>
    </div>
        


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Coluna') ?></dt>
            <dd><?= $this->Number->format($integracaoTabelaLog->coluna) ?></dd>
        </dl>
    </div>
        


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Status') ?></dt>
            <dd><?= $this->Number->format($integracaoTabelaLog->status) ?></dd>
        </dl>
    </div>
        

    </table>

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Data') ?></dt>
            <dd><?= $this->Text->autoParagraph(h($integracaoTabelaLog->data)); ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Error') ?></dt>
            <dd><?= $this->Text->autoParagraph(h($integracaoTabelaLog->error)); ?></dd>
        </dl>
    </div>


<div class="clearfix"></div>

</div>
