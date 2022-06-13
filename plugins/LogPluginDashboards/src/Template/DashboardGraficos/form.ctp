<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardGrafico
 */
?>

<?php

use App\Util\SaveBackUtil;
use LogPluginDashboards\RegraNegocio\DashboardManager\DashboardMacrosStructure;

(isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');

$sDica = 'Você deve utilizar as seguintes tags para sua consulta: ' 
    . DashboardMacrosStructure::$sMacroTagExpr . ' (define o intervalo no where), '
    . DashboardMacrosStructure::$sMacroTagInitial . ' (retorna a data inicial do período), '
    . DashboardMacrosStructure::$sMacroTagFinal . ' (retorna a data final do período). ';
?>

<h1 class="page-header">
    <?= __('Edit ') . __('Dashboard Grafico') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Graficos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($dashboardGrafico) ?>
    <div class="col-lg-3"> 
        <?php echo $this->Form->control('titulo', [
            'class' => 'form-control'
        ]); ?>    
    </div>
    <div class="col-lg-1"> 
        <?php echo $this->Form->control('ordem', [
            'class' => 'form-control'
        ]); ?>    
    </div>
    <div class="col-lg-4"> 
        <?php echo $this->Form->control('descricao', [
            'class' => 'form-control'
        ]); ?>    
    </div>
    <div class="col-lg-1"> 
        <?php echo $this->Form->control('ativo', [
            'class' => 'form-control',
            'options' => ['Não', 'Sim'], 
            'default' => 1 
        ]); ?>    
    </div>
    <div class="col-lg-2"> 
        <?php echo $this->Form->control('extra_classes', [
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
            'search'       => true,
            'entity'       => $dashboardGrafico
        ]) ?>  
        <?= SaveBackUtil::doLink($this, [
            'controller' => 'Dashboards', 
            'action' => 'add'
        ]); ?>
    </div>
    <div class="col-lg-3 to-save-back"> 
        <?= $this->element('selectpicker', [
            'name'         => 'dashboard_grafico_tipo_id',
            'label'        => 'DashboardGraficoTipos',
            'options'      => $dashboardGraficoTipos_options,
            'null'         => true,
            'disableNulls' => true,
            'search'       => true,
            'entity'       => $dashboardGrafico
        ]) ?>  
        <?= SaveBackUtil::doLink($this, [
            'controller' => 'DashboardGraficoTipos', 
            'action' => 'add'
        ]); ?>
    </div>

    <div class="clearfix"></div>

    <div class="col-lg-3 to-save-back"> 
        <?= $this->element('selectpicker', [
            'name'         => 'consulta_id',
            'label'        => 'Consultas',
            'tooltip'      => $this->element('LogPluginDashboards./tooltip', ['descricao' => $sDica]),
            'options'      => $consultas_options,
            'null'         => true,
            'disableNulls' => true,
            'search'       => true,
            'entity'       => $dashboardGrafico
        ]) ?> 
        <?= SaveBackUtil::doLink($this, [
            'controller' => 'Consultas', 
            'action' => 'add'
        ]); ?>
    </div>
    
    <div class="col-lg-2"> 
        <?php echo $this->Form->control('usa_macros_periodos', [
            'class' => 'form-control',
            'label' => __('Utiliza Macro Período?'),
            'options' => ['Não', 'Sim'], 
            'default' => 1 
        ]); ?>    
    </div>
    
    <div class="col-lg-2"> 
        <?php echo $this->Form->control('campo_macro_dt_inicio', [
            'class' => 'form-control'
        ]); ?>    
    </div>

    <div class="col-lg-2"> 
        <?php echo $this->Form->control('campo_macro_dt_fim', [
            'class' => 'form-control'
        ]); ?>    
    </div>

    <div class="col-lg-2"> 
        <?php echo $this->Form->control('ordenacao_eixo_x', [
            'class' => 'form-control',
            'required'
        ]); ?>    
    </div>
    
    <div class="col-lg-10 monaco-editor-init"> 
        <?php echo $this->Form->control('responsive_options', [
            'class' => 'form-control hide monaco-editor-code'
        ]); ?>    
        <div class="monaco-editor-container" language='javascript'></div>
    </div>  
    
    <div class="col-lg-10 monaco-editor-init"> 
        <?php echo $this->Form->control('extra_script', [
            'class' => 'form-control hide monaco-editor-code'
        ]); ?>    
        <div class="monaco-editor-container" language='javascript'></div>
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
