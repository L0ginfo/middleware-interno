<div id="associacao-terno-porao" class="lf-content">
    <h3 class="lf-text-navio-viagem lf-text-center lf-margin-small-bottom"></h3>
    <p class="lf-text-operacao lf-text-center"></p>
    <hr>
    <div class="lf-container lf-text-center">
        <h3 class="lf-text-center lf-margin-small-bottom">Associar Terno ao Porão</h3>
        <div class="row">
            <?= $this->Form->create('selecao-porao',['action' => 'associacao-terno-porao/add', 'class' => 'lf-route']) ?>
                <div class="col-lg-6">
                    <?= $this->Form->select('porao', ['' => 'Selecione'], [
                        'class' => 'form-control', 
                        'id' => 'select_porao_associacao',
                    ]); ?>
                </div>
                <div class="col-lg-6">
                    <?= $this->Form->select('Terno', [], [
                        'class' => 'form-control',
                        'id' => 'select_termo_associacao',
                    ]); ?>
                </div>
                <div class="col-lg-12">

                    <?=  $this->Form->button('Associar', [
                        'type'=>'button', 
                        'id' => 'add-association',
                        'class' => 'btn btn-primary', 'escape' => false
                    ]); ?>

                    <?= $this->Form->button(__('Conferir'), [
                        'type' => 'button', 
                        'id' => 'save-association',
                        'class' => 'btn btn-grey']) 
                    ?>      
                </div>
            <?= $this->Form->end() ?>
        </div>

        <div class="lf-table">
            <table class="lf-table-content lf-margin-top">
                <thead>
                    <tr>
                        <td>Porão</td>
                        <td>Terno</td>
                        <td>Periodo</td>
                        <td>Data</td>
                        <td>Ação</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
