<?php

use Dompdf\Css\Style;
?>
<div id="lingada" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom">
        <span class="lf-text-navio-viagem"></span>
        <span> - </span>
        <span class="lf-text-operacao"></span>
    </h3>
    <hr>
    <div class="lf-container lf-text-center">
        <div class="row">
            <?= $this->Form->create($this) ?>
            <div style="display:none;">
                <input type="hidden" id="plano_carga_id" name="plano_carga_id" value="">
            </div>
            <div align="center">
                <div class="col-lg-12">
                    <label for="placa-granel"> <?= __('Porão') ?> </label>
                    <?= $this->Form->select('Porão', ['' => 'selecione'], [
                        'id' => 'select_liganda_porao',
                        'class' => 'form-control'
                    ]); ?>
                </div>
                
                <div class="col-lg-12">
                    <label for="placa"> <?= __('Placa') ?> </label>
                    <?= $this->Form->control('Placa', ['label' => false ,'class' => 'form-control', 'autocomplete' => 'off']) ?>
                </div>

                <div class="col-lg-12 show-produto" style="display: none;">
                    <label for="produto"> <?= __('Produto')?> </label>
                        <?= $this->Form->control('Produto', [
                            'label' => false,
                            'id'    => 'produto',
                            'type'  => 'select', 
                            'class' => 'form-control select-produto'
                        ]) ?>
                </div>

                <div class="col-lg-12 show-codigo"> 
                    <?= $this->element('selectpicker-ajax', [
                        'label' => __('Codigo'),
                        'escape' => false,
                        'id' => 'codigo',
                        'name' => 'Codigo',
                        'null' => true,
                        'search' => true,
                        'required' => true,
                        'options' =>  [],
                        'url'  => [
                            'controller' => 'PlanejamentoMaritimo', 
                            'action' => 'filterQuerySelectpicker'
                        ],
                        'data' => [
                            'input-plano_carga_id'=>'[name="plano_carga_id"]',
                            'input-porao_id'=>'[name="Porão"]',
                            'busca' => '{{{q}}}'
                        ],
                        'class' => 'not-fix-width'
                    ]); ?>
                </div>

                <div class="modal-caracteristicas">
                    <div class="modal-caracteristicas-content">
                        <div class="modal-caracteristicas-header">Características</div>
                        <div class="modal-caracteristicas-body"></div>
                    </div>
                </div>
                
                <div class="col-lg-12 show-quantidade" style="display: none;">
                    <label for="qtd"> <?= __('Qtd') ?> </label>
                    <?= $this->Form->control('Qtd', ['label' => false , 'class' => 'form-control', 'autocomplete' => 'off']) ?>
                </div>

                <div class="col-lg-12 show-peso" style="display: none;">
                    <label for="peso"> <?= __('Peso') ?> </label>
                    <?= $this->Form->control('peso', ['label' => false, 'class' => 'form-control double', 'id' => 'peso', 'autocomplete' => 'off']) ?>
                </div>

                <div class="col-lg-12 show-porao-origem">
                    <label for="porao_origem">Porão Operando</label>
                    <?= $this->Form->select('porao_origem', $aPoroes, [
                        'label' => false,
                        'id'    => 'porao_origem',
                        'class' => 'form-control'
                    ]) ?>  
                </div>

                <div class="col-lg-12">
                    <div class="lf-margin-small-left lf-margin-small-right">
                        <?= $this->Form->button(__('Adicionar'), [
                            'id' => 'add-lingada',
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
                        <td>Qtde</td>
                        <td>Peso</td>
                        <td>Hora</td>
                        <td>Ação</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="col-lg-12 lf-margin-medium-top lf-margin-small-bottom">
            Peso / Saldo: <strong id="lingada_total"> 0 / 0</strong>
        </div>
        <hr>

        <div class="lf-margin-top">
            <?= $this->Html->link(__('Histórico'), ['action' => 'index', 'historico'], ['class' => 'btn btn-grey lf-route lf-btn-historico']) ?>
            <?= $this->Form->button(__('Finalizar'), ['class' => 'btn btn-success', 'id' => 'finalizar-lingada']) ?>
        </div>

        <div class="lf-margin-top">
            <?= $this->Html->link(__('Saldo Porões'), ['action' => 'index', 'saldo-poroes'], ['class' => 'btn btn-grey lf-route lf-btn-saldo-poroes']) ?>
            <?= $this->Html->link(__('Paralisações'), ['action' => 'index', 'paralisacoes'], ['class' => 'btn btn-grey lf-route']) ?>
        </div>
    </div>
</div>
