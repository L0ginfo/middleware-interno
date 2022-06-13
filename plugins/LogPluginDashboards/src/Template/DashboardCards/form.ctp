<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardCard
 */
?>

<?php

use App\Util\SaveBackUtil;

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Edit ') . __('Dashboard Card') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Cards'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($dashboardCard) ?>



    <div class="col-lg-3"> 
        <?php echo $this->Form->control('titulo', [
            'class' => 'form-control'
        ]); ?>    
    </div>

    <div class="col-lg-3"> 
        <?php echo $this->Form->control('ordem', [
            'class' => 'form-control'
        ]); ?>    
    </div>

    <div class="col-lg-3"> 
        <?php echo $this->Form->control('ativo', [
            'class' => 'form-control',
            'options' => ['Não', 'Sim'], 
            'default' => 1 
        ]); ?>    
    </div>

    <div class="col-lg-3"> 
        <?php echo $this->Form->control('cor', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('url', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('controller', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('action', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('icone', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('consulta_coluna_dado', [
            'class' => 'form-control'
        ]); ?>    
    </div>
    <div class="col-lg-3 to-save-back"> 
        <?= $this->element('selectpicker', [
            'name'         => 'dashboard_id',
            'label'        => __('Dashboard'),
            'options'      => $dashboards_options,
            'null'         => true,
            'disableNulls' => true,
            'search'       => true
        ]) ?>  
        <?= SaveBackUtil::doLink($this, [
            'controller' => 'Dashboards', 
            'action' => 'add'
        ]); ?>
    </div>        
        
    <div class="hasFooter clearfix"></div>
    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    
<?= $this->Form->end() ?>

