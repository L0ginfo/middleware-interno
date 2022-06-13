<div id="historico" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom">
        <span class="lf-text-navio-viagem"></span>
        <span> - </span>
        <span class="lf-text-operacao"></span>
    </h3>
    <hr>
    <h1 class="lf-margin-top">Histórico</h1>
    <div class="lf-container lf-text-center">
        <div class="row">
            <div class="col-lg-12">
                <?= $this->Form->control('Pesquisa', ['class' => 'form-control', 'id'=>'search-field']) ?>
            </div>
        </div>
        <div class="lf-table">
            <table class="lf-table-content lf-margin-top">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Porão</td>
                        <td>Placa</td>
                        <td>Item</td>
                        <td>Qtde</td>
                        <td>Peso</td>
                        <td>Data/Hora</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 lf-margin-medium-top lf-margin-small-bottom">
            Qtde / Peso: <strong id="historico_total"> 0 / 0</strong>
        </div>
    </div>
</div>
