<?php if ($oDashboardGraph->script) : ?>

    <div class="graph-content <?= $oDashboardGraph->extra_classes ?>">
        <div class="graph-header">
            <div class="graph-title"><?= $oDashboardGraph->titulo ?></div>

            <div class="macro-info flex-no-wrap lf-align-items-center">
                
                <i class="fa fa-filter" aria-hidden="true"></i>

                <?= $this->Form->control('macros', [
                    'options' => $oDashboardGraph->macros,
                    'label' => false,
                    'class' => 'macros lf-height-26',
                    'value' => $oDashboardGraph->macro_utilizada,
                    'graph' => $oDashboardGraph->id
                ]) ?>

                <?= $this->Form->text('date_initial', [
                    'label' => false,
                    'class' => 'graph-date hidden date-initial',
                    'type' => 'date'
                ]) ?>

                <?= $this->Form->text('date_final', [
                    'label' => false,
                    'class' => 'graph-date hidden date-final',
                    'type' => 'date'
                ]) ?>
            </div>
        </div>
        <div class="ct-chart graph_<?= $oDashboardGraph->id ?>"></div>
    </div>

    <script>
        $(window).load(function() { 
            <?= $oDashboardGraph->script ?> 
        })
    </script>

<?php endif; ?>