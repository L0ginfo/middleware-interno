<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardGraficoFormato
 * Para gerar um form.ctp: <?= $this->element('../Dashboard Grafico Formatos/form') ?>
 */

?>

<?php

use App\Util\SaveBackUtil;

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Add ') . __('Dashboard Grafico Formato') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Grafico Formatos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($dashboardGraficoFormato) ?>



    <div class="col-lg-3"> 
        <?php echo $this->Form->control('descricao', [
            'class' => 'form-control'
        ]); ?>    
    </div>        
        
    <div class="hasFooter clearfix"></div>
    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    
<?= $this->Form->end() ?>

