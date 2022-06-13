<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Integracao $integracao
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Edit ') . __('Integracao') ?>
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Integracoes'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($integracao) ?>

    <?= $this->element('../Integracoes/form'); ?>

    <div class="hasFooter clearfix"></div>
    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>

<?= $this->Form->end() ?>
