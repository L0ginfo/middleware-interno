<div id="operacao" class="lf-content">
    <h3 class="lf-text-center lf-text-navio-viagem"></h3>
    <h1 class="lf-margin-small-top">Selecione o Tipo</h1>
    <div class="lf-container lf-text-center">
    
        <?=  $this->Form->button(__('1 - Lingada'), [
            'class' => 'btn btn-option-default lf-operacao', 
            'data-value' => 'EMBARQUE', 
            'id'=>'operacao_lingada'
        ]); ?>

        <?=  $this->Form->button(__('2 - Remoção'), [
            'class' => 'btn btn-option-default lf-remocao', 
        ]); ?>

        <?=  $this->Form->button(__('3 - Paralisação'), [
            'class' => 'btn btn-option-default lf-paralisacao', 
        ]); ?>

    </div>
</div>
