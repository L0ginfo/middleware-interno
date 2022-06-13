<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $dashboardGraficoFormato
 */
 
 (isset($customTitlePage) ? $this->assign('title', $customTitlePage) : '');
?>

<h1 class="page-header">
    <?=  __('Listando ') . __('Dashboard Grafico Formato') ?>    
    <div class="btn-group pull-right" role="group">
        <?= $this->Html->link( __('List ') . __('Dashboard Grafico Formatos'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    </div>
</h1>


<div class="dashboardGraficoFormatos view large-9 medium-8 columns content">

    <table class="vertical-table">

    <div class="col-lg-3">
        <dl>
            <dt><?= __('Descricao') ?></dt>
            <dd><?= h($dashboardGraficoFormato->descricao) ?></dd>
        </dl>
    </div>


        <div class="col-lg-3">
        <dl>
            <dt><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($dashboardGraficoFormato->id) ?></dd>
        </dl>
    </div>
        

    </table>

<div class="clearfix"></div>

    <!--div class="related">
        <h4><?= __('Related Dashboard Grafico Tipos') ?></h4>
        <?php if (!empty($dashboardGraficoFormato->dashboard_grafico_tipos)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Descricao') ?></th>
                <th scope="col"><?= __('Grafico Params') ?></th>
                <th scope="col"><?= __('Dashboard Grafico Formato Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($dashboardGraficoFormato->dashboard_grafico_tipos as $dashboardGraficoTipos): ?>
            <tr>
                <td><?= h($dashboardGraficoTipos->id) ?></td>
                <td><?= h($dashboardGraficoTipos->descricao) ?></td>
                <td><?= h($dashboardGraficoTipos->grafico_params) ?></td>
                <td><?= h($dashboardGraficoTipos->dashboard_grafico_formato_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DashboardGraficoTipos', 'action' => 'view', $dashboardGraficoTipos->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DashboardGraficoTipos', 'action' => 'edit', $dashboardGraficoTipos->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DashboardGraficoTipos', 'action' => 'delete', $dashboardGraficoTipos->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dashboardGraficoTipos->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div-->
</div>
