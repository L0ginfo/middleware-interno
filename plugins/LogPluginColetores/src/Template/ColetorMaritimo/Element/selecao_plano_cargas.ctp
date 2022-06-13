<div id="selecao-plano-cargas" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom lf-text-navio-viagem"></h3>
    <h1 class="lf-margin-small-top">Selecionar o Plano de Carga</h1>
    <p class="lf-text-center lf-text-operacao"></p>
    <hr>
    <div class="lf-container lf-text-center">
        <div align="center">
            <div class="col-lg-12">
                <label for="">Tipo de Mercadoria</label>
                <?= $this->Form->select('tipo_mercadoria', [
                    '' => 'Selecione'], ['id'=>'tipo-mercadoria', 'class' => 'form-control'
                ]); ?>
            </div>

            <div class="col-lg-12">
                <label for="">Operador Portuário</label>
                <?= $this->Form->select('operador', [
                    '' => 'Selecione'], ['id'=>'operador', 'class' => 'form-control'
                ]); ?>
            </div>

            <div class="col-lg-12">
                <?= $this->Form->button('Selecionar', ['id' => 'selecionar-plano-carga', 'class' => 'btn btn-default'])?>
            </div>
        </div>
    </div>
</div>

<style>
    #selecao-plano-cargas button {
        width: 90%;
        margin: 6px;
    }
</style>
