
<div>

    <div class="col-lg-12 text-center">
        <h2>Paralisação detectada!</h2>
    </div>
    <div align="center">
    <div class="col-lg-12"> 
        <?= $this->element('selectpicker', [
            'name'         => 'modal_paralisacao_motivo_id',
            'label'        => 'Paralisacão Motivo',
            'options'      => $aParalisacaoMotivos,
            'search'       => true,
            'class' => 'not-fix-width'
        ]) ?>  
    </div>

    <div class="col-lg-12">
        <label for="placa-granel"> <?= __('Porão') ?> </label>
        <?= $this->Form->select('modal_porao_id', ['' => 'Selecione o Porão'], [
            'id'=>'porao_id', 
            'class' => 'form-control porao_id'
        ]); ?>
    </div>


    <div class="col-lg-12">
        <?= $this->Form->control('modal_descricao', [
            'label' => __('Descrição'),
            'type'=> 'textarea', 
            'class' => 'form-control'
        ]) ?>
    </div>
    </div>

</div>


