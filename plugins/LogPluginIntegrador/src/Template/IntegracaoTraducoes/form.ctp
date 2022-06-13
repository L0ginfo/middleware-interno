<div class="col-lg-4">
    <?= $this->element('selectpicker', [
        'label' => 'Integração', 
        'name' => 'integracao_id', 
        'controller' => 'Integracoes', 
        'options' => $integracoes_options,
        'entity' => $integracaoTraducao
    ]); ?>
</div>

<div class="col-lg-12 lf-margin-top">
    <?= $this->Form->control('observacao', [
        'class' => 'form-control'
    ]); ?>
</div>

<div class="col-lg-12 lf-margin-top monaco-editor-init">
    <?= $this->Form->textarea('nested_json_translate', [
        'class' => 'form-control hide monaco-editor-code',
        'type' => 'textarea'
    ]); ?>
    <div class="monaco-editor-container" language='json'></div>
</div>

<?php 
    // Scripts
    $this->start('script');
        echo $this->Html->script([
            'Plugins/MonacoEditor/loader'
        ]);
    $this->end();
?>

<script>
    $(window).load(function() {
        MonacoEditorManager.init()
    })
</script>
