
<?php
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?= __('Add ') . __('Integracao Tabela Log') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Integracao Tabela Logs'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>

<?= $this->Form->create($integracaoTabelaLog) ?>

    <div class="col-lg-3 to-save-back"> 
        <?= $this->element('selectpicker', [
            'name'         => 'integracao_id',
            'label'        => 'Integracoes',
            'options'      => $integracoes_options,
            'null'         => true,
            'disableNulls' => true,
            'search'       => true,
            'entity'       => $integracaoTabelaLog
        ]) ?>  

    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('coluna', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('tabela', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('data', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('error', [
            'class' => 'form-control'
        ]); ?>    
    </div>


    <div class="col-lg-3"> 
        <?php echo $this->Form->control('status', [
            'class' => 'form-control'
        ]); ?>    
    </div>    <div class="hasFooter clearfix"></div>
    <div class="footer">
        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
<?= $this->Form->end() ?>
