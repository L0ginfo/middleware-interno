<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IntegracaoTraducao $integracaoTraducao
 */

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Edit ') . __('Integracao Traducao') ?>
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Integracao Traducoes'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($integracaoTraducao) ?>

    <?= $this->element('../IntegracaoTraducoes/form'); ?>

    <div class="hasFooter clearfix"></div>
    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>

<?= $this->Form->end() ?>

