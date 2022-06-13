<div class="col-lg-12 lf-padding-remove">
    <div class="col-lg-3">
        <?= $this->Form->control('tipo', ['type' => 'select', 'class' => 'form-control', 'options' => ['API' => 'API', 'Database' => 'Database']]); ?>
    </div>
</div>

<div class="col-lg-4 lf-margin-top">
    <?= $this->Form->control('nome', ['class' => 'form-control']); ?>
</div>
<div class="col-lg-4 lf-margin-top">
    <?= $this->Form->control('codigo_unico', ['class' => 'form-control']); ?>
</div>
<div class="col-lg-2 lf-margin-top">
    <?= $this->Form->control('ativo', ['class' => 'form-control', 'options' => ['Não', 'Sim'], 'default' => 1 ]); ?>
</div>
<div class="col-lg-2 lf-margin-top">
    <?= $this->Form->control('gravar_log', ['class' => 'form-control', 'options' => [0 => 'Não', 1 => 'Sim'], 'default' => 1]); ?>
</div>
<div class="col-lg-6 lf-margin-top">
    <?= $this->Form->control('url_endpoint', ['class' => 'form-control']); ?>
</div>

<div class="col-lg-4 lf-margin-top">
    <?= $this->Form->control('db_host', ['label' => 'Host', 'class' => 'form-control']); ?>
</div>

<div class="col-lg-2 lf-margin-top">
    <?= $this->Form->control('db_porta', ['label' => 'Porta', 'class' => 'form-control']); ?>
</div>
<div class="col-lg-6 lf-margin-top">
    <?= $this->Form->control('private_key', ['class' => 'form-control']); ?>
</div>

<div class="col-lg-3 lf-margin-top">
    <?= $this->Form->control('db_database', ['label' => 'Database', 'class' => 'form-control']); ?>
</div>

<div class="col-lg-3 lf-margin-top">
    <?= $this->Form->control('db_user', ['label' => 'Usuário', 'class' => 'form-control']); ?>
</div>

<div class="col-lg-3 lf-margin-top">
    <?= $this->Form->control('db_pass', ['label' => 'Senha', 'class' => 'form-control']); ?>
</div>

<div class="col-lg-12 lf-margin-top">
    <?= $this->Form->control('json_header', ['class' => 'form-control', 'type' => 'textarea']); ?>
</div>

<div class="col-lg-12 lf-margin-top">
    <?= $this->Form->control('descricao', ['class' => 'form-control']); ?>
</div>

<div class="col-lg-12 monaco-editor-init">
    <label for="">JSON Parametros</label>
    <?= $this->Form->textarea('json_parametros', [
        'class' => 'form-control hide monaco-editor-code'
    ]);?>
    <div class="monaco-editor-container" language='json'></div>
</div>


<script>
    $(document).ready(function(){

        function changeType(){
            var option = $('#tipo').find('option:selected').val();
            var showInputsByType = {
                api: [
                    'url-endpoint',
                    'json-header',
                ],
                db: [
                    'db-host',
                    'db-porta',
                    'db-database',
                    'db-user',
                    'db-pass',
                ]
            };

            if(option == 'API') {
                showInputsByType.api.forEach(function(item, index){
                    console.log($('#' + item));
                    $('#' + item).closest('div[class*="col-"]').show();
                })
                showInputsByType.db.forEach(function(item, index){
                    $('#' + item).closest('div[class*="col-"]').hide();
                })
            }
            else {
                showInputsByType.api.forEach(function(item, index){
                    $('#' + item).closest('div[class*="col-"]').hide();
                })
                showInputsByType.db.forEach(function(item, index){
                    $('#' + item).closest('div[class*="col-"]').show();
                })
            }
        }
        $('#tipo').change(function(){
            changeType();
        })

        changeType();
    })
</script>

<?= $this->Html->script([
    'Plugins/MonacoEditor/loader'
]) ?>

<script>
    $(window).load(function() {
        MonacoEditorManager.init()
    })
</script>