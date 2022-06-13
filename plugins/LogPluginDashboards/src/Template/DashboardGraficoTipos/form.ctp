<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardGraficoTipo
 */
?>

<?php

use App\Util\SaveBackUtil;

 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Edit ') . __('Dashboard Grafico Tipo') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Grafico Tipos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($dashboardGraficoTipo) ?>

    <div class="col-lg-3"> 
        <?php echo $this->Form->control('descricao', [
            'class' => 'form-control'
        ]); ?>    
    </div>

    <div class="col-lg-3 to-save-back"> 
        <?= $this->element('selectpicker', [
            'name'         => 'dashboard_grafico_formato_id',
            'label'        => __('DashboardGraficoFormato'),
            'options'      => $dashboardGraficoFormatos_options,
            'null'         => true,
            'disableNulls' => true,
            'search'       => true,
            'entity'       => $dashboardGraficoTipo
        ]) ?>  
        <?= SaveBackUtil::doLink($this, [
            'controller' => 'DashboardGraficoFormatos', 
            'action' => 'add'
        ]); ?>
    </div>
    
    <div class="col-lg-10 monaco-editor-init"> 
        <label for="">Gráfico Params</label>
        <?php echo $this->Form->textarea('grafico_params', [
            'class' => 'form-control hide monaco-editor-code'
        ]); ?>
        <div class="monaco-editor-container" language='json'></div>
    </div>
        
    <div class="hasFooter clearfix"></div>
    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    
<?= $this->Form->end() ?>

<?= $this->Html->script([
    'Plugins/MonacoEditor/loader'
]) ?>

<script>
    $(window).load(function() {
        MonacoEditorManager.init()
    })
</script>