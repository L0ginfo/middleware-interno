<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $coletor
 */
?>

<?= $this->element('header') ?>

<div class="lf-pages">
    <?= $this->element('../ColetorMaritimo/Element/menu') ?>
    <?= $this->element('../ColetorMaritimo/Element/operacao') ?>
    <?= $this->element('../ColetorMaritimo/Element/selecao-porao') ?>
    <?= $this->element('../ColetorMaritimo/Element/associacao-terno-porao') ?>
    <?= $this->element('../ColetorMaritimo/Element/lingada') ?>
    <?= $this->element('../ColetorMaritimo/Element/lingada-granel') ?>
    <?= $this->element('../ColetorMaritimo/Element/remocao') ?>
    <?= $this->element('../ColetorMaritimo/Element/historico') ?>
    <?= $this->element('../ColetorMaritimo/Element/historico-remocao') ?>
    <?= $this->element('../ColetorMaritimo/Element/saldo-poroes') ?>
    <?= $this->element('../ColetorMaritimo/Element/avarias') ?>
    <?= $this->element('../ColetorMaritimo/Element/avaria_fotos') ?>
    <?= $this->element('../ColetorMaritimo/Element/caracteristicas') ?>
    <?= $this->element('../ColetorMaritimo/Element/selecao_plano_cargas') ?>
    <?= $this->element('../ColetorMaritimo/Paralisacoes/add') ?>
    <?= $this->element('../ColetorMaritimo/Paralisacoes/edit') ?>
    <?= $this->element('../ColetorMaritimo/Paralisacoes/index') ?>
    
    <?= $this->element('modal', [
            'id' => 'modal-paralisacoes',
            'title' => 'Notificação',
            'content' => $this->element('../ColetorMaritimo/Element/Templates/modal_paralisacoes_template'),
            'btnSucessTitle' => 'Cadastrar'
    ]) ?>

</div>

<?= $this->element('footer') ?>

<?= $this->Html->script([
    'LogPluginColetores.ColetorMaritimo/Controllers/MenuController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/OperacaoController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/LingadaController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/LingadasGranelController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/RemocoesController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/HistoricoController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/SaldoPoroesController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/ParalisacoesController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/AssociacaoTernosController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/CaracteristicasController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/PlanoCargasController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Controllers/AppController' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/RequestService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/ColetorMaritimoService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/MenuService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/OperacaoService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/LingadaService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/LingadaGranelService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/LingadaGranelService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/RemocoesService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/HistorioService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/SaldoPoroesService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/ParalisacoesService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/AssociacoesTernosService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/CaracteristicasService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Services/PlanoCargasService' . $aRemoveCache['js'],
    'LogPluginColetores.ColetorMaritimo/Renders/ParalisacoesRender' . $aRemoveCache['js'],
    
]); ?>



<script>
    oColetorApp.templates.sLingadas = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingadas_template'));?>;
    oColetorApp.templates.sSelect = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/select_template'));?>;
    oColetorApp.templates.sAssociacaoTernos = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/associacao_ternos_template'));?>;
    oColetorApp.templates.sLingadasgGranel = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingadas_granel_template'));?>;
    oColetorApp.templates.sLingadaRemocoes = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingada_remocoes_template'));?>;
    oColetorApp.templates.sHistorico = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingadas_histotico_template'));?>;
    oColetorApp.templates.sHistoricoRemocoes = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingadas_histotico_remocoes_template'));?>;
    oColetorApp.templates.sSaldoPoroes = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingadas_saldo_poroes_template'));?>;
    oColetorApp.templates.sLingadaAvarias = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingada_avarias_template'));?>;
    oColetorApp.templates.sLingadaAvariaFotos = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/lingada_avarias_fotos_template'));?>;
    oColetorApp.templates.sCaracteriscas = 
        <?= json_encode($this->element('../ColetorMaritimo/Element/Templates/caracteriscas_template'));?>;

    oColetorApp.templates.paralisacoes = 
    <?= json_encode($this->element('../ColetorMaritimo/Paralisacoes/Templates/index_template'));?>;
</script>

<?= $this->element('../ColetorMaritimo/Element/nested_tree');?>


<style>

    .modal-caracteristicas{
        width: 96%;
        margin: 0 auto;
        display: none;
    }
    .modal-caracteristicas-content{
        border: 1px solid #000;
        width: 100%;
        float: left;
        margin: 0 0 10px 0;
    }
    .modal-caracteristicas-header{
        padding-top: 5px;
        font-size: 16px;
        font-weight: bold;
    }

    .modal-caracteristicas-body{
        padding-top: 10px;
    }

</style>
