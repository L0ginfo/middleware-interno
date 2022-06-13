<?php

use Cake\Routing\Router;
?>
<div id="avarias" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom">
        <span class="lf-text-navio-viagem"></span>
        <span> - </span>
        <span class="lf-text-operacao"></span>
    </h3>
    <hr>
    <div  class="lf-container lf-text-center">  

        <?php echo $this->Form->create(null, ['id' => 'avarias-form']); ?>
            <?= $this->Form->control('tipo_avaria_id', ['class' => 'form-control', 'options' => $aAvarias]); ?>
            <?= $this->Form->control('descricao', ['class' => 'form-control', 'id' => 'avaria-descricao']); ?>

                <?= $this->Form->button('Fotos', [ 
                    'escape' => false, 
                    'id'=>'capture',
                    'class'=> 'btn btn-primary',
                    'type' => 'button'
                ]); ?>

                <?= $this->Form->button('Salvar', [
                    'escape' => false, 
                    'id'=>'salvar-fotos',
                    'class' => 'btn btn-success',
                    'type' => 'button'
                ]); ?>

                <?= $this->Form->file('fotos_avarias', [
                    'style'=> 'display:none',
                    'id'=> 'fotos-avarias', 
                    'accept'=>"image/png, image/jpeg",
                    'multiple',
                    'capture'
                ]); ?>
        <?= $this->Form->end() ?>
    </div>

    <div class="lf-table">
        <table class="lf-table-content lf-margin-top">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Avaria</td>
                    <td>Descrição</td>
                    <td>Fotos</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


