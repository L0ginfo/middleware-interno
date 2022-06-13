<div id="remocao" class="lf-content">
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
                    <?= $this->Form->select('Porão', ['' => 'selecione'], [
                        'id' => 'select_porao_remocao',
                        'class' => 'form-control'
                    ]); ?>
                </div>

                <div class="col-lg-12">
                    <label for="select-remocao"> <?= __('Remoção')?> </label>
                    <?= $this->Form->select('Remoção', $aRemocoes , ['class' => 'form-control', 'id'=>"select-remocao"]) ?>
                </div>

                <div class="col-lg-12 show-produto" style="display: none;">
                    <label for="produto"> <?= __('Produto')?> </label>
                        <?= $this->Form->control('Produto', [
                            'label'=>false , 
                            'type' => 'select', 
                            'id' => 'produto-remocao', 
                            'class' => 'form-control select-produto'
                        ]) ?>
                </div>

                <div class="col-lg-12 show-codigo">
                    <label for="codigo"> <?= __('Código') ?> </label>
                    <?= $this->Form->control('Codigo', [
                        'label' => false , 
                        'id' => 'codigo-remocao', 
                        'autocomplete' => 'off',
                        'class' => 'form-control', 
                    ]) ?>
                </div>

                <div class="col-lg-12 show-quantidade" style="display: none;">
                    <label for="quantidade"> <?= __('Quantidade') ?> </label>
                    <?= $this->Form->control('quantidade', ['label' => false , 'class' => 'form-control', 'autocomplete' => 'off']) ?>
                </div>

                <div class="col-lg-12 show-peso" style="display: none;">
                    <label for="peso"> <?= __('Peso') ?> </label>
                    <?= $this->Form->control('peso', ['label' => false, 'class' => 'form-control double', 'id' => 'peso', 'autocomplete' => 'off']) ?>
                </div>

                <div class="modal-caracteristicas">
                    <div class="modal-caracteristicas-content">
                        <div class="modal-caracteristicas-header">
                            Características
                        </div>
                        <div class="modal-caracteristicas-body">

                        </div>
                    </div>
                </div>

                <div class="col-lg-12" align="center" >
                    <div class="lf-margin-small-left lf-margin-small-right">
                        <?= $this->Form->button(__('Remover'), [
                            'id' => 'remocao-lingada',
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
                        <td>Remoção</td>
                        <td>Qnde</td>
                        <td>Hora</td>
                        <td>Ação</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="col-lg-12 lf-margin-medium-top lf-margin-small-bottom">
            Qtde / Peso: <strong id="remocao_total">0 / 0</strong>
        </div>
        <hr>
        <div class="lf-margin-top">
            <?= $this->Html->link(__('Histórico'), ['action' => 'index', 'historico-remocao'], ['class' => 'btn btn-grey lf-route']) ?>
            <?= $this->Form->button(__('Finalizar'), ['class' => 'btn btn-success', 'id'=> 'finalizar-remocao']) ?>
        </div>
    </div>
</div>
