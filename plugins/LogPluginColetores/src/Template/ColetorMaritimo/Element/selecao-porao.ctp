<div id="selecao-porao" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom lf-text-navio-viagem"></h3>
    <p class="lf-text-center lf-text-operacao"></p>
    <hr>
    <div class="lf-container lf-text-center">
        <?= $this->Form->select('portao', ['' => 'Selecione o Porão'], [
            'id'=>'select_poroes', 'class' => 'form-control']); ?>
        <?= $this->Form->button(__('Escolher Porão'), [
            'type' =>'button',
            'class' => 'btn btn-grey' , 
            'id'=>'selecionar-porao'
        ]) ?>
    </div>
</div>
