$(document).ready(function(){
    oColetorApp.oRoutes = {
        index: {
            id: 'menu',
            url: webroot,
            controller: 'MenuContoller',
            action: 'index'
        },

        menu: {
            id: 'menu',
            url: webroot + '/menu',
            controller: 'Menu',
            action: 'index'
        },

        operacao: {
            id: 'operacao',
            url: webroot+'/operacao',
            controller: 'OperacaoContoller',
            action: 'index'
        },
    
        selecao_porao: {
            id: 'selecao-porao',
            url: webroot + '/selecao-porao',
            controller: 'LingadaController',
            action: 'index'
        },
        associacao_terno_porao: {
            id: 'associacao-terno-porao',
            url: webroot + '/associacao-terno-porao',
            controller: 'AssociacaoTernosController',
            action: 'association'
        },
        lingada: {
            id: 'lingada',
            url: webroot + '/lingada',
            controller: 'LingadaController',
            action: 'index'
        },
        lingada_granel: {
            id: 'lingada-granel',
            url: webroot + '/lingada-granel',
            controller: 'LingadasGranelController',
            action: 'index'
        },
        remocao: {
            id: 'remocao',
            url: webroot + '/remocao',
        },
        historico: {
            id: 'historico',
            url: webroot + '/historico',
        },
        historico_remocao: {
            id: 'historico-remocao',
            url: webroot + '/historico-remocao',
        },
        avarias: {
            id: 'avarias',
            url: webroot + '/avarias',
        },
        avaria_fotos: {
            id: 'avaria-fotos',
            url: webroot + '/avaria-fotos',
        },
        caracteristicas: {
            id: 'caracteristicas',
            url: webroot + '/caracteristicas',
            controller: 'CaracteristicasController',
        },
        selecao_plano_cargas: {
            id: 'selecao-plano-cargas',
            url: webroot + '/selecao-plano-cargas',
            controller: 'PlanoCargasController',
        },
        paralisacoes: {
            id: 'paralisacoes',
            url: webroot + '/paralisacoes',
            controller: 'ParalisacoesController',
        },
        paralisacoes_adicionar: {
            id: 'paralisacoes-adicionar',
            url: webroot + '/paralisacoes/adicionar',
            controller: 'ParalisacoesController',
        },
        paralisacoes_editar: {
            id: 'paralisacoes-editar',
            url: webroot + '/paralisacoes/editar',
            controller: 'ParalisacoesController',
        },
        saldo_poroes: {
            id: 'saldo-poroes',
            url: webroot + '/saldo-poroes',
        },
    };
})
