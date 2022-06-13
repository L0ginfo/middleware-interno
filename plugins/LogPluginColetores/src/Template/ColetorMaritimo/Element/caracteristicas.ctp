<div id="caracteristicas" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom lf-text-navio-viagem"></h3>
        <p class="lf-text-center lf-text-operacao"></p>
    <hr>
    <div class="lf-container lf-text-center">
        <h3 class="lf-text-center lf-margin-small-bottom">Selecionar Características </h3>
        <?= $this->Form->create('caracteristicas') ?>

            <!-- <div id="lista-caracteristicas">
            </div> -->

            <?= $this->Form->button(__('Escolher Característica'), [
                'id' => 'select-caracterisca' ,
                'class' => 'btn btn-grey', 
                'type' => 'button'
            ]) ?>

        <?= $this->Form->end() ?>
    </div>
</div>
