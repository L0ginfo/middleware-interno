<div id="lingada-granel" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom">
        <span class="lf-text-navio-viagem"></span>
        <span> - </span>
        <span class="lf-text-operacao"></span>
    </h3>
    <hr>
    <div class="lf-container lf-text-center">
        <div class="row">
            <?= $this->Form->create($this) ?>
            <div align="center">
                <div class="col-lg-12">
                    <label for="placa-granel"> <?= __('Porão') ?> </label>
                    <?= $this->Form->select('porao', ['' => 'Selecione'], [
                        'id'=> 'select_porao_lingada_granel', 'class' => 'form-control'
                    ]); ?>
                </div>

                <div class="col-lg-12">
                    <label for="placa-granel"> <?= __('Placa') ?> </label>
                    <?= $this->Form->control('Placa', ['label' => false, 'class' => 'form-control', 'id' => 'placa-granel', 'autocomplete' => 'off']) ?>
                </div>

                <div class="col-lg-12">
                    <label for="produto"> <?= __('Produto')?> </label>
                    <?= $this->Form->control('Produto', [
                        'label'=>false , 
                        'type' => 'select',
                        'id' => 'produto-granel', 
                        'class' => 'form-control select-produto'
                    ]) ?>
                </div>


                <div class="modal-caracteristicas">
                    <div class="modal-caracteristicas-content">
                        <div class="modal-caracteristicas-header">Características</div>
                        <div class="modal-caracteristicas-body"></div>
                    </div>
                </div>

                <div class="col-lg-12" align="center" >
                    <div class="lf-margin-small-left lf-margin-small-right">
                        <?= $this->Form->button(__('Adicionar'), [
                            'id' => 'add-lingada-granel',
                            'type' =>'button',
                            'class' => 'btn btn-primary lf-full-width'
                        ]) ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
        <div class="lf-table">
            <table class="lf-table-content lf-margin-top">
                <thead>
                    <tr>
                        <td>Item</td>
                        <td>Terno</td>
                        <td>Hora</td>
                        <td>Ação</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 lf-margin-medium-top lf-margin-small-bottom">
            Peso / Saldo: <strong id="lingada_granel_total"> 0 / 0</strong>
        </div>
        <hr>
        <hr class="lf-margin-medium-top">
        <div class="lf-margin-top">
            <?= $this->Html->link(__('Histórico'), ['action' => 'index', 'historico'], ['class' => 'btn btn-grey lf-route lf-btn-historico']) ?>
            <?= $this->Form->button(__('Finalizar'), ['class' => 'btn btn-success', 'id' => 'finalizar-lingada-granel']) ?>
        </div>

        <div class="lf-margin-top">
            <?= $this->Html->link(__('Paralisações'), ['action' => 'index', 'paralisacoes'], ['class' => 'btn btn-grey lf-route']) ?>
            <?= $this->Html->link(__('Saldo Porões'), ['action' => 'index', 'saldo-poroes'], ['class' => 'btn btn-grey lf-route lf-btn-saldo-poroes']) ?>
        </div>
    </div>
</div>
