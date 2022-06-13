<div class="lf-container lf-text-center">

<?= $this->Form->create($this) ?>
<div align="center">
<div class="col-lg-12">
    <?= $this->Form->hidden('id', [
        'class' => 'form-control', 
    ]); ?>
</div>

<div class="col-lg-12"> 
    <?= $this->element('selectpicker', [
        'name'         => 'paralisacao_motivo_id',
        'id'           => 'paralisacao_motivo_id',
        'label'        => 'Paralisacão Motivo',
        'options'      => $aParalisacaoMotivos,
        'search'       => true,
        'class' => 'not-fix-width'
    ]) ?>  
</div>

<div class="col-lg-12">
    <label for="">Data Hora Início</label>
    <?= $this->Form->text('data_hora_inicio', ['class' => 'form-control time', 'type' => 'time', 'placeholder' => 'hh:mm']) ?>
</div>

<div class="col-lg-12">
    <label for="">Data Hora Fim</label>
    <?= $this->Form->text('data_hora_fim', ['class' => 'form-control time', 'type' => 'time', 'placeholder' => 'hh:mm']) ?>
</div>

<div class="col-lg-12">
    <label for="placa-granel"> <?= __('Porão') ?> </label>
    <?= $this->Form->select('porao_id', ['' => 'Selecione o Porão'], [
        'id'=>'porao_id', 
        'class' => 'form-control porao_id'
    ]); ?>
</div>

<div class="col-lg-12">
    <div><label for="">Descrição</label></div>
    <div>
        <?= $this->Form->textarea('descricao', [
            'class' => 'form-control'
        ]) ?>
    </div>
</div>

<div class="col-lg-12">
    <?= $this->Form->button(__('Submit'), [
        'class' => 'btn btn-primary salvar',
        'type' => 'button'
    ]) ?>
</div>

</div>
<?= $this->Form->end(); ?>

</div>
