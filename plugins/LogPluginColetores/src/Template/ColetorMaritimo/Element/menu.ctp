<?php use App\Util\MaskUtil; ?>
<div id="menu" class="lf-content">
    <h1 class="lf-margin-small-top">Selecione o Navio/Viagem</h1>
    <div class="lf-container lf-text-center">
        <?php foreach ($aPlanejamentos as $key => $value):?>
            <?php $sViagem = strlen($value->viagem_numero) > 3 ?
                MaskUtil::mask($value->viagem_numero, '###/####'): $value->viagem_numero ;?>
            <?= $this->Form->button(
                $value->veiculo->descricao.' - '.$sViagem, [
                'type' => 'button', 
                'class' => 
                'btn btn-option-default', 
                'data-value' => $value->id
            ]) ?>
        <?php endforeach; ?>
    </div>
</div>
