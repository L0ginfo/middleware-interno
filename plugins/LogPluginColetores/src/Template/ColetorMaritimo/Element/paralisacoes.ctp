<div id="paralisacoes" class="lf-content">
    <h3 class="lf-text-center lf-margin-small-bottom">
        <span class="lf-text-navio-viagem"></span>
    </h3>
    <hr>
    <div class="lf-container lf-text-center">
        <div class="row">
            <?= $this->Form->create($this) ?>
                <div class="col-lg-12">
                    <h1><?= __('Cadastro de Paralisações')?></h1>
                </div>
            <div align="center">
                <div class="col-lg-12"> 
                    <?= $this->element('selectpicker', [
                        'name'         => 'paralisacao_motivo_id',
                        'id'           => 'paralisacao_motivo_id',
                        'label'        => 'Paralisacão Motivo',
                        'options'      => $aParalisacaoMotivos,
                        'search'       => true,
                        'class' => 'not-fix-width'
                    ]) ?>  
                </div>

                <div class="col-lg-12">
                    <?= $this->Form->control('data_inicio', ['class' => 'form-control time',    'placeholder' => 'dd/mm/yyyy hh:mm']) ?>
                </div>

                <div class="col-lg-12">
                    <?= $this->Form->control('data_fim', ['class' => 'form-control time',
                    'placeholder' => 'dd/mm/yyyy hh:mm']) ?>
                </div>

                <div class="col-lg-12">
                    <label for="placa-granel"> <?= __('Porão') ?> </label>
                    <?= $this->Form->select('porao_id', ['' => 'Selecione o Porão'], [
                        'id'=>'porao_id', 
                        'class' => 'form-control'
                    ]); ?>
                </div>

                <div class="col-lg-12">
                    <?= $this->Form->control('descricao', ['type'=> 'textarea', 'class' => 'form-control']) ?>
                </div>

                <div class="col-lg-12" align="center" >

                    <div class="lf-margin-small-left lf-margin-small-right">
                        <?= $this->Form->button(__('cadastrar'), [
                            'id' => 'registrar-paralisacao',
                            'type' =>'button', 
                            'class' => 'btn btn-primary lf-full-width'
                        ]) ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

