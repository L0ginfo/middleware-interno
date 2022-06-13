<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Template $template
 */
 
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Template') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Templates'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="templates view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Descricao') ?></dt>
            <dd><?= h($template->descricao) ?></dd>
        </dl>
    </div>


    <div class="col-lg-3">
        <dl>
            <dt><?= __('Codigo') ?></dt>
            <dd><?= h($template->codigo) ?></dd>
        </dl>
    </div>


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($template->id) ?></dd>
        </dl>
    </div>
        

    </table>

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Template') ?></dt>
            <dd><?= $this->Text->autoParagraph(h($template->template)); ?></dd>
        </dl>
    </div>


<div class="clearfix"></div>

</div>
