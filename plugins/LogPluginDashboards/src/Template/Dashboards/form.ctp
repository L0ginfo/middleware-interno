<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboard
 */
?>

<?php

use App\Util\SaveBackUtil;

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Edit ') . __('Dashboard') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboards'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($dashboard) ?>



    <div class="col-lg-3"> 
        <?php echo $this->Form->control('titulo', [
            'class' => 'form-control'
        ]); ?>    
    </div>
    <div class="col-lg-3 to-save-back"> 
        <?= $this->element('selectpicker', [
            'name'         => 'perfil_id',
            'label'        => __('Perfil'),
            'options'      => $perfis_options,
            'null'         => true,
            'disableNulls' => true,
            'search'       => true
        ]) ?> 
        <?= SaveBackUtil::doLink($this, [
            'controller' => 'Perfis', 
            'action' => 'add'
        ]); ?>
    </div>
    <div class="col-lg-3 to-save-back"> 
        <?= $this->element('selectpicker', [
            'name'         => 'usuario_id',
            'label'        => __('Usuario'),
            'options'      => $usuarios_options,
            'null'         => true,
            'disableNulls' => true,
            'search'       => true
        ]) ?> 
        <?= SaveBackUtil::doLink($this, [
            'controller' => 'Usuarios', 
            'action' => 'add'
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
        
    <div class="hasFooter clearfix"></div>
    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    
<?= $this->Form->end() ?>

