<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Template $template
 * Para gerar um form.ctp: <?= $this->element('../Templates/form') ?>
 */

?>

<?php

use App\Util\SaveBackUtil;

?>

<h1 class="page-header">
    <!--__('Add ')-->
    <?= ($template->isNew() ? __('Add ') : __('Edit ')) . __('Template') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Templates'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($template) ?>


    <div class="col-lg-6"> 
        <?php echo $this->Form->control('descricao', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-6"> 
        <?php echo $this->Form->control('codigo', [
            'class' => 'form-control'
        ]); ?>    
    </div>  
    
    <div class="col-lg-12" style="min-width: 500px;"> 
        <?php echo $this->Form->control('template', [
            'class' => 'form-control'
        ]); ?>    
    </div>

    <div class="hasFooter clearfix"></div>

    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>


    <?= $this->Html->script([
        '/node_modules/ckeditor4/ckeditor.js'
    ]) ?>

<script>
    CKEDITOR.replace('template');
</script>

<?= $this->Form->end() ?>

<script>


    $('.modal-body form').submit(function() {
        for(var instanceName in CKEDITOR.instances)
            CKEDITOR.instances[instanceName].updateElement();
    });
    
</script>



