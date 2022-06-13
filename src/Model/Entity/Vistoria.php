<?php
namespace App\Model\Entity;

use App\Util\ArrayUtil;
use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class Vistoria extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        $aModais = LgdbUtil::get('Modais')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        return [
            [
                'name'  => 'veiculo',
                'divClass' => 'col-lg-3',
                'label' => 'Placa',
                'table' => [
                    'className' => 'Programacoes.Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'pessoa',
                'divClass' => 'col-lg-3',
                'label' => 'Motorista',
                'table' => [
                    'className' => 'Programacoes.Pessoas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'transportadora',
                'divClass' => 'col-lg-3',
                'label' => 'Transportadora',
                'table' => [
                    'className' => 'Programacoes.Transportadoras',
                    'field'     => 'razao_social',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'select_modal',
                'divClass' => 'col-lg-2',
                'label' => 'Modais',
                'table' => [
                    'className' => 'Modais',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aModais
                ]
            ]
        ];
    }

    public static function getFiltersVistoriados()
    {
        return [
            [
                'name'  => 'veiculo',
                'divClass' => 'col-lg-3',
                'label' => 'Placa',
                'table' => [
                    'className' => 'Vistorias.Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'pessoa',
                'divClass' => 'col-lg-3',
                'label' => 'Motorista',
                'table' => [
                    'className' => 'Vistorias.Pessoas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'lote',
                'divClass' => 'col-lg-3',
                'label' => 'Lote',
                'table' => [
                    'className' => 'Vistorias.VistoriaItens',
                    'field'     => 'lote_codigo',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'Vistorias.VistoriaItens.Containers',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }

    public static function getFiltersVistoriaExterna($aDataQuery)
    {
        $aDocumentosTransportesWhere = [];
        if ($aDataQuery['documento_transporte']['values'][0])
            $aDocumentosTransportesWhere += ['DocumentosTransportes.id' => $aDataQuery['documento_transporte']['values'][0]];
        $aDocumentosTransportes = LgdbUtil::get('DocumentosTransportes')
            ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
            ->select( ['id', 'numero'] )
            ->where($aDocumentosTransportesWhere)
            ->limit(1);

        $aContainersWhere = [];
        if ($aDataQuery['container']['values'][0])
            $aContainersWhere += ['Containers.id' => $aDataQuery['container']['values'][0]];
        $aContainers = LgdbUtil::get('Containers')
            ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
            ->select( ['id', 'numero'] )
            ->where($aContainersWhere)
            ->limit(1);

        $aVistoriaLacresWhere = [];
        if ($aDataQuery['vistoria_lacre']['values'][0])
            $aVistoriaLacresWhere += ['VistoriaLacres.id' => $aDataQuery['vistoria_lacre']['values'][0]];
        $aVistoriaLacres = LgdbUtil::get('VistoriaLacres')
            ->find('list', ['keyField' => 'id', 'valueField' => 'lacre_numero'])
            ->select( ['id', 'lacre_numero'] )
            ->where($aVistoriaLacresWhere)
            ->limit(1);

        $aTipoDocumentos = LgdbUtil::get('TipoDocumentos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'tipo_documento'])
            ->select( ['id', 'tipo_documento'] );

        $aVistoriaTipos = LgdbUtil::get('VistoriaTipos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        return [
            [
                'name'  => 'data_hora_programada',
                'divClass' => 'col-lg-4',
                'label' => 'Data Programada',
                'table' => [
                    'className' => 'Vistorias.Programacoes',
                    'field'     => 'data_hora_programada',
                    'operacao'  => 'entre',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'documento_transporte',
                'divClass' => 'col-lg-2',
                'label' => 'Documento',
                'table' => [
                    'className' => 'VistoriaItens.DocumentosTransportes',
                    'field'     => 'id',
                    'operacao'  => 'igual',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'documento_transporte_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'DocumentosTransportes', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'numero', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aDocumentosTransportes,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-2',
                'label' => 'Container',
                'table' => [
                    'className' => 'VistoriaItensOne.Containers',
                    'field'     => 'id',
                    'operacao'  => 'igual',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'container_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Containers', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'numero', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aContainers,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'vistoria_lacre',
                'divClass' => 'col-lg-2',
                'label' => 'Lacres',
                'table' => [
                    'className' => 'VistoriaItens.VistoriaLacres',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'vistoria_lacre_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'VistoriaLacres', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'lacre_numero', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aVistoriaLacres,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'tipo_documento',
                'divClass' => 'col-lg-2',
                'label' => 'Tipo Documento',
                'table' => [
                    'className' => 'VistoriaItens.DocumentosTransportes.TipoDocumentos',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aTipoDocumentos
                ]
            ],
            [
                'name'  => 'vistoria_tipo',
                'divClass' => 'col-lg-2',
                'label' => 'Tipo Vistoria',
                'table' => [
                    'className' => 'VistoriaTipos',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aVistoriaTipos
                ]
            ],
            
        ];
    }

    public static function getDadosIniciarVistoria($iProgramacaoID, $iResvID, $iContainerID, $iOrdemServicoId, $bIsCargaGeral) 
    {
        $aDadosIniciarVistoria = [];
        if ($iProgramacaoID) {

            $aDadosIniciarVistoria['sTipoRegistro'] = 'Programacao';

            $oRegistro = LgDbUtil::getFind('Programacoes')
                ->contain(['Resvs', 'Operacoes', 'Veiculos', 'Transportadoras', 'ProgramacaoContainers', 'Pessoas'])
                ->where(['Programacoes.id' => $iProgramacaoID])
                ->first();

            $aWhereVistoria = ['programacao_id' => $iProgramacaoID];

        } else if ($iResvID) {

            $aDadosIniciarVistoria['sTipoRegistro'] = 'Resv';

            $oRegistro = LgDbUtil::getFind('Resvs')
                ->contain(['Operacoes', 'Veiculos', 'Transportadoras', 'ResvsContainers', 'Pessoas'])
                ->where(['Resvs.id' => $iResvID])
                ->first();

            $aWhereVistoria = ['resv_id' => $iResvID];

        } else if ($iOrdemServicoId) {

            $aDadosIniciarVistoria['sTipoRegistro'] = 'OrdemServico';

            $oRegistro = LgDbUtil::getFind('OrdemServicos')
                ->contain(['OrdemServicoItens'])
                ->where(['OrdemServicos.id' => $iOrdemServicoId])
                ->first();

            $aWhereVistoria = ['ordem_servico_id' => $iOrdemServicoId];

        }
        if ($bIsCargaGeral) {
            $aWhereVistoria += ['vistoria_tipo_carga_id' => EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral')];
        } else {
            $aWhereVistoria += ['vistoria_tipo_carga_id' => EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container')];
        }

        $oVistoria = LgDbUtil::getFirst('Vistorias', $aWhereVistoria);
        $aDadosIniciarVistoria['oRegistro'] = $oRegistro;
        $aDadosIniciarVistoria['oVistoria'] = $oVistoria;

        return $aDadosIniciarVistoria;
    }

    public static function addVistoria($aDadosIniciarVistoria, $iContainerID)
    {
        $oResponse = new ResponseUtil();

        if ($aDadosIniciarVistoria['sTipoRegistro'] == 'Programacao') {

            $aDataInsert = [
                'programacao_id'     => $aDadosIniciarVistoria['oRegistro']->id,
                'data_hora_vistoria' => DateUtil::dateTimeToDB(date('Y-m-d H:i:s'))
            ];

            if ($iContainerID)
                $aDataInsert['vistoria_tipo_carga_id'] = EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container');
            else 
                $aDataInsert['vistoria_tipo_carga_id'] = EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral');

        } else if ($aDadosIniciarVistoria['sTipoRegistro'] == 'Resv') {

            $aDataInsert = [
                'resv_id' => $aDadosIniciarVistoria['oRegistro']->id,
                'data_hora_vistoria' => DateUtil::dateTimeToDB(date('Y-m-d H:i:s'))
            ];

            if ($iContainerID)
                $aDataInsert['vistoria_tipo_carga_id'] = EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container');
            else 
                $aDataInsert['vistoria_tipo_carga_id'] = EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral');

        } else if ($aDadosIniciarVistoria['sTipoRegistro'] == 'OrdemServico') {

            if ($iContainerID) {
                $aDataInsert = [
                    'ordem_servico_id'       => $aDadosIniciarVistoria['oRegistro']->id,
                    'vistoria_tipo_carga_id' => EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container'),
                    'data_hora_vistoria'     => DateUtil::dateTimeToDB(date('Y-m-d H:i:s'))
                ];
            } else {
                $aDataInsert = [
                    'ordem_servico_id'       => $aDadosIniciarVistoria['oRegistro']->id,
                    'vistoria_tipo_carga_id' => EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral'),
                    'data_hora_vistoria'     => DateUtil::dateTimeToDB(date('Y-m-d H:i:s'))
                ];
            }

        }

        $oVistoria = LgDbUtil::saveNew('Vistorias', $aDataInsert, true);
        if (!$oVistoria) 
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu algum erro ao iniciar a Vistoria');

        if ($aDadosIniciarVistoria['sTipoRegistro'] == 'OrdemServico' && !$iContainerID) {
            $oResponse = VistoriaItem::addVistoriaItensCargaGeral($oVistoria, $aDadosIniciarVistoria['oRegistro']);

            if ($oResponse->getStatus() != 200)
                return $oResponse;
        }

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oVistoria);
    }

    public static function getIdByParams($aData)
    {
        $oResponse = new ResponseUtil();

        $sColumn         = ArrayUtil::get($aData, 'sColumn');
        $uValue          = ArrayUtil::get($aData, 'uValue');
        $iRegistroID     = ArrayUtil::get($aData, 'iRegistroID');
        $sTipoRegistro   = ArrayUtil::get($aData, 'sTipoRegistro');

        if ($sTipoRegistro == 'Programacao') {
            $sEntity = 'Programacoes';
        } else if ($sTipoRegistro == 'Resv') {
            $sEntity = 'Resvs';
        }

        $oRegistro = LgDbUtil::getFind($sEntity)
            ->contain(['Pessoas', 'Veiculos'])
            ->where([$sEntity . '.id' => $iRegistroID])
            ->first();

        switch ($sColumn) {
            case 'placa':
                
                if ($oRegistro->veiculo->descricao == strtoupper($uValue) || $oRegistro->veiculo->veiculo_identificacao == strtoupper($uValue))
                    return $oResponse
                        ->setStatus(200)
                        ->setDataExtra($oRegistro->veiculo_id);

                return $oResponse
                    ->setStatus(400);

            break;
            
            case 'cpf':
                
                if ($oRegistro->pessoa->cpf == $uValue) 
                    return $oResponse
                        ->setStatus(200)
                        ->setDataExtra($oRegistro->pessoa_id);

                return $oResponse
                    ->setStatus(400);

            break;
        }

    }

    public static function saveInicioVistoria($aData, $aDadosIniciarVistoria)
    {
        $oResponse = new ResponseUtil();

        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain(['VistoriaTipoCargas'])
            ->where(['Vistorias.id' => $aData['vistoria_id']])
            ->first();

        if ($oVistoria) {
            $oVistoria->placa              = $aData['placa'];
            $oVistoria->veiculo_id         = $aData['veiculo_id'];
            $oVistoria->cpf_motorista      = $aData['cpf_motorista'];
            $oVistoria->pessoa_id          = $aData['pessoa_id'];
            $oVistoria->data_hora_vistoria = DateUtil::dateTimeToDB(date('Y-m-d H:i:s'));

            if ($aDadosIniciarVistoria['sTipoRegistro'] == 'Programacao') {
                $sEntityContainers = 'programacao_containers';
            } else if ($aDadosIniciarVistoria['sTipoRegistro'] == 'Resv') {
                $sEntityContainers = 'resvs_containers';
            }

            if ($aDadosIniciarVistoria['oRegistro']->{$sEntityContainers}) {
                $oVistoria->vistoria_tipo_carga_id = EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container');
            } else {
                $oVistoria->vistoria_tipo_carga_id = EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral');
            }

            if (!LgDbUtil::save('Vistorias', $oVistoria))
                return $oResponse
                    ->setStatus(400)
                    ->setMessage('Ocorreu um erro ao salvar o início da vistoria')
                    ->setTitle('Ops...!');
        }

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oVistoria);
    }

    public static function getDadosVistoriaContainer($iVistoriaId)
    {
        $aDadosVistoria = [];

        $oVistoriaEmptyContain = LgDbUtil::getFirst('Vistorias', ['id' => $iVistoriaId]);
        if ($oVistoriaEmptyContain->resv_id) {

            $aDadosVistoria['sTipoRegistro'] = 'Resv';
            $aDadosVistoria['oVistoria'] = LgDbUtil::getFind('Vistorias')
                ->contain([
                    'VistoriaTipoCargas',
                    'VistoriaItens' => ['VistoriaAvarias'],
                    'Resvs' => [
                        'Operacoes', 
                        'Veiculos', 
                        'Transportadoras', 
                        'ResvsContainers' => [
                            'Containers'
                        ]
                    ]
                ])
                ->where(['Vistorias.id' => $iVistoriaId])
                ->first();

        } else if ($oVistoriaEmptyContain->programacao_id) {

            $aDadosVistoria['sTipoRegistro'] = 'Programacao';
            $aDadosVistoria['oVistoria'] = LgDbUtil::getFind('Vistorias')
                ->contain([
                    'VistoriaTipoCargas',
                    'VistoriaItens' => ['VistoriaAvarias'],
                    'Programacoes' => [
                        'Operacoes', 
                        'Veiculos', 
                        'Transportadoras', 
                        'ProgramacaoContainers' => [
                            'Containers'
                        ]
                    ]
                ])
                ->where(['Vistorias.id' => $iVistoriaId])
                ->first();

        } else if ($oVistoriaEmptyContain->ordem_servico_id) {

            $aDadosVistoria['sTipoRegistro'] = 'OrdemServico';
            $aDadosVistoria['oVistoria'] = LgDbUtil::getFind('Vistorias')
                ->contain([
                    'VistoriaTipoCargas',
                    'VistoriaItens' => ['VistoriaAvarias'],
                    'OrdemServicos' => [
                        'OrdemServicoItens' => function ($q) {
                            return $q->contain(['Containers'])->where(['OrdemServicoItens.container_id IS NOT' => null]);
                        }
                    ]
                ])
                ->where(['Vistorias.id' => $iVistoriaId])
                ->first();

        }

        return $aDadosVistoria;
    }

    public static function getContainersVistoriar($aDadosVistoria)
    {
        if ($aDadosVistoria['sTipoRegistro'] == 'Resv') {
            $sEntity          = 'resv';
            $sEntityContainer = 'resvs_containers';
        } else if ($aDadosVistoria['sTipoRegistro'] == 'Programacao') {
            $sEntity          = 'programacao';
            $sEntityContainer = 'programacao_containers';
        } else if ($aDadosVistoria['sTipoRegistro'] == 'OrdemServico') {
            $sEntity          = 'ordem_servico';
            $sEntityContainer = 'ordem_servico_itens';
        }

        $oVistoria = $aDadosVistoria['oVistoria'];

        $aContainersVistoriar = [];
        foreach ($oVistoria->{$sEntity}->{$sEntityContainer} as $oRegistroContainer) {

            if ($oRegistroContainer->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga'))
                continue;

            $oContainer = $oRegistroContainer->container;

            $aContainersVistoriar[$oContainer->id]['container_id']     = $oContainer->id;
            $aContainersVistoriar[$oContainer->id]['container_numero'] = $oContainer->numero .  (isset($oRegistroContainer->tipo) ? ' - ' . $oRegistroContainer->tipo : '');
            $aContainersVistoriar[$oContainer->id]['tipo'] = $oRegistroContainer->tipo;

            foreach ($oVistoria->vistoria_itens as $oItem) {

                if ($oItem->container_id == $oContainer->id) {

                    $aContainersVistoriar[$oContainer->id]['vistoria_item']['id']                     = $oItem->id;
                    $aContainersVistoriar[$oContainer->id]['vistoria_item']['tipo_iso']               = $oItem->tipo_iso;
                    $aContainersVistoriar[$oContainer->id]['vistoria_item']['ano_fabricacao']         = $oItem->ano_fabricacao;
                    $aContainersVistoriar[$oContainer->id]['vistoria_item']['tara']                   = $oItem->tara;
                    $aContainersVistoriar[$oContainer->id]['vistoria_item']['mgw']                    = $oItem->mgw;
                    $aContainersVistoriar[$oContainer->id]['vistoria_item']['container_forma_uso_id'] = $oItem->container_forma_uso_id;
                    if ($oVistoria->vistoria_itens) {

                        foreach ($oVistoria->vistoria_itens as $aVistoriaItem) {

                            if ($aVistoriaItem->container_id == $oContainer->id && $aVistoriaItem->vistoria_avarias) {
                                $aContainersVistoriar[$oContainer->id]['avarias'] = $aVistoriaItem->vistoria_avarias;
                            }

                        }
                    
                    }

                }

            }

        }

        return $aContainersVistoriar;
    }

    public static function getDadosVistoriaCargaGeral($iVistoriaId)
    {
        $aDadosVistoria = [];

        $oVistoriaEmptyContain = LgDbUtil::getFirst('Vistorias', ['id' => $iVistoriaId]);
        if ($oVistoriaEmptyContain->resv_id) {

            $aDadosVistoria['sTipoRegistro'] = 'Resv';
            $aDadosVistoria['oVistoria'] = null;

        } else if ($oVistoriaEmptyContain->programacao_id) {

            $aDadosVistoria['sTipoRegistro'] = 'Programacao';
            $aDadosVistoria['oVistoria'] = null;

        } else if ($oVistoriaEmptyContain->ordem_servico_id) {

            $aDadosVistoria['sTipoRegistro'] = 'OrdemServico';
            $aDadosVistoria['oVistoria'] = LgDbUtil::getFind('Vistorias')
                ->contain([
                    'VistoriaTipoCargas',
                    'VistoriaItens' => function ($q) {
                        return $q->contain(['VistoriaAvarias' => ['Avarias'], 'Produtos', 'Enderecos' => ['Areas' => ['Locais']]])
                            ->where(['VistoriaItens.container_id IS' => null]);
                    },
                    'OrdemServicos' => ['OrdemServicoItens']
                ])
                ->where(['Vistorias.id' => $iVistoriaId])
                ->first();

        }

        return $aDadosVistoria;
    }

    public static function getDadosVistoriados($oVistoria)
    {
        if (!$oVistoria->vistoria_itens)
            return null;
        
        if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container'))
            $sDados = '<b>Containers:</b></br> ';
        else if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral'))
            $sDados = '<b>Lotes:</b></br> ';

        foreach ($oVistoria->vistoria_itens as $oVistoriaItem) {

            if ($oVistoriaItem->container_id) {
                $sDados .= $oVistoriaItem->container->numero . ';</br> ';
            }

            if ($oVistoriaItem->lote_codigo) {
                $sDados .= $oVistoriaItem->lote_codigo . ' - ' . $oVistoriaItem->lote_item . ';</br> ';
            }

        }

        return $sDados;
    }

    public static function getLinkVistoria($oVistoria)
    {
        $iTipoRegistro = $oVistoria->vistoria_tipo_carga_id;
        switch ($iTipoRegistro) {
            case EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container'):
                $aLink['Controller'] = 'Vistorias';
                $aLink['Action'] = 'VistoriaContainer';
                $aLink['Paramns'] = $oVistoria->id;
                break;

            case EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral'):
                $aLink['Controller'] = 'Vistorias';
                $aLink['Action'] = 'VistoriaCargaGeral';
                $aLink['Paramns'] = $oVistoria->id;
                break;

        }

        return $aLink;
    }

    public static function getIdByParamsOrCheckValue($aData)
    {
        $oResponse = new ResponseUtil();

        $sColumn      = ArrayUtil::get($aData, 'sColumn');
        $uValue       = ArrayUtil::get($aData, 'uValue');
        $iContainerId = ArrayUtil::get($aData, 'iContainerId');

        $oContainer = LgDbUtil::getFind('Containers')
            ->contain(['TipoIsos'])
            ->where(['Containers.id' => $iContainerId])
            ->first();

        switch ($sColumn) {
            case 'tipo_iso':
                
                if (strcasecmp($oContainer->tipo_iso->descricao, $uValue) == 0)
                    return $oResponse
                        ->setStatus(200)
                        ->setDataExtra($oContainer->tipo_iso_id);

                return $oResponse
                    ->setStatus(400);

            break;
            
            case 'tara':
                
                if ($oContainer->tara == $uValue) 
                    return $oResponse
                        ->setStatus(200);

                return $oResponse
                    ->setStatus(400);

            break;

            case 'mgw':
                
                if ($oContainer->mgw == $uValue) 
                    return $oResponse
                        ->setStatus(200);

                return $oResponse
                    ->setStatus(400);

            case 'ano_fabricacao':
        
                if ($oContainer->mes_ano_fabricacao == $uValue) 
                    return $oResponse
                        ->setStatus(200);

                return $oResponse
                    ->setStatus(400);

            break;
        }
    }

    public static function finalizarVistoriaContainer($aData)
    {
        $oResponse = new ResponseUtil();

        $oVistoria = LgDbUtil::getByID('Vistorias', $aData['vistoria_id']);
        if ($oVistoria) {

            $oVistoria->data_hora_fim =  DateUtil::dateTimeToDB(date('Y-m-d H:i:s'));

            if (!LgDbUtil::save('Vistorias', $oVistoria))
                return $oResponse
                    ->setStatus(400)
                    ->setMessage('Ocorreu um erro ao finalizar a vistoria')
                    ->setTitle('Ops...!');

            $oResponse = EntradaSaidaContainerVistoria::saveEntradaSaidaContainerVistoria($aData['vistoria_id']);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

        }

        return $oResponse
            ->setStatus(200)
            ->setMessage('Vistoria finalizada com sucesso!')
            ->setTitle('Sucesso!');
    }

    public static function finalizarVistoriaCarga($aData)
    {
        $oResponse = new ResponseUtil();

        $oVistoria = LgDbUtil::getByID('Vistorias', $aData['vistoria_id']);
        if ($oVistoria) {

            $oVistoria->data_hora_fim = DateUtil::dateTimeToDB(date('Y-m-d H:i:s'));
            $oVistoria->veiculo_id    = $aData['iVeiculoId'];
            $oVistoria->pessoa_id     = $aData['iPessoaId'];
            $oVistoria->placa         = $aData['sPlaca'];
            $oVistoria->cpf_motorista = $aData['sCpfMotorista'];

            if (!LgDbUtil::save('Vistorias', $oVistoria))
                return $oResponse
                    ->setStatus(400)
                    ->setMessage('Ocorreu um erro ao finalizar a vistoria')
                    ->setTitle('Ops...!');

            if ($aData['sTipoCarga'] == 'Container') {
                $oResponse = EntradaSaidaContainerVistoria::saveEntradaSaidaContainerVistoria($aData['vistoria_id']);
                if ($oResponse->getStatus() != 200)
                    return $oResponse;
            }
            
        }

        return $oResponse
            ->setStatus(200)
            ->setMessage('Vistoria finalizada com sucesso!')
            ->setTitle('Sucesso!');
    }

    public static function getDadosVistoriaContainersImprimir($iVistoriaItemID)
    {
        $oVistoriaItem = LgDbUtil::getFind('VistoriaItens')
            ->contain([
                'VistoriaFotos' => [
                    'Anexos'
                ], 
                'Vistorias', 
                'Containers', 
                'ContainerFormaUsos', 
                'VistoriaAvarias' => [
                    'Avarias', 
                    'VistoriaAvariaRespostas' => [
                        'AvariaRespostas'
                    ]
                ]
            ])
            ->where(['VistoriaItens.id' => $iVistoriaItemID])
            ->first();

        $aDadosVistoria = [];
        $aDadosVistoria['numero_termo']         = self::getNumeroTermo($iVistoriaItemID);
        $aDadosVistoria['empresa_padrao']       = self::getEmpresaPadrao();
        $aDadosVistoria['documento_transporte'] = self::getDocumentoTransportes($oVistoriaItem);
        $aDadosVistoria['datas_horas_veiculo']  = self::getDatasHorasVeiculo($oVistoriaItem);
        $aDadosVistoria['dados_vistoria']       = self::getDadosVistoria($oVistoriaItem);
        $aDadosVistoria['dados_avarias']        = $oVistoriaItem->vistoria_avarias;
        $aDadosVistoria['vistoria_fotos']       = $oVistoriaItem->vistoria_fotos;

        return $aDadosVistoria;
    }

    public static function getDadosVistoriaCargaGeralImprimir($iVistoriaID)
    {
        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain([
                'VistoriaItens' => [
                    'VistoriaFotos' => [
                        'Anexos'
                    ], 
                    'VistoriaAvarias' => [
                        'Avarias', 
                        'VistoriaAvariaRespostas' => [
                            'AvariaRespostas'
                        ]
                    ]
                ]
            ])
            ->where(['Vistorias.id' => $iVistoriaID])
            ->first();

        $aDadosVistoria = [];
        $aDadosVistoria['numero_termo']         = self::getNumeroTermo($iVistoriaID);
        $aDadosVistoria['empresa_padrao']       = self::getEmpresaPadrao();
        $aDadosVistoria['documento_transporte'] = self::getDocumentoTransportes(null, $oVistoria);
        $aDadosVistoria['datas_horas_veiculo']  = self::getDatasHorasVeiculo(null, $oVistoria);
        $aDadosVistoria['dados_vistoria']       = self::getDadosVistoria(null, $oVistoria);
        $aDadosVistoria['dados_avarias']        = $oVistoria->vistoria_itens;

        return $aDadosVistoria;
    }

    private static function getNumeroTermo($iVistoriaItemID)
    {
        $sAno = date('y') . '/';

        $sZeros = '';
        for ($i = strlen($iVistoriaItemID); $i < 6; $i++) { 
            $sZeros .= '0';
        }

        return $sAno . $sZeros . $iVistoriaItemID;
    }

    private static function getEmpresaPadrao()
    {
        $iEmpresaPadrao = Empresa::getEmpresaPadrao();
        $oEmpresa       = LgDbUtil::getFirst('Empresas', ['id' => $iEmpresaPadrao]);

        $aDadosEmpresa = [];
        $aDadosEmpresa['descricao'] = $oEmpresa->descricao;
        $aDadosEmpresa['cnpj']      = $oEmpresa->cnpj;

        return $aDadosEmpresa;
    }

    private static function getDocumentoTransportes($oVistoriaItem, $oVistoria = null)
    {
        if ($oVistoria)
            $sTipoRegistro = self::getTipoRegistroVistoria($oVistoria);
        else
            $sTipoRegistro = self::getTipoRegistroVistoria($oVistoriaItem->vistoria);

        switch ($sTipoRegistro) {
            case 'Resv':
                
                $aDadosDocumento = self::getDadosDocumentoFromResv($oVistoriaItem);
                return $aDadosDocumento;

                break;
            
            case 'Programacao':
                
                $aDadosDocumento = self::getDadosDocumentoFromProgramacao($oVistoriaItem);
                return $aDadosDocumento;

                break;

            case 'OrdemServico':

                if ($oVistoria)
                    $aDadosDocumento = self::getDadosDocumentoFromOrdemServico(null, $oVistoria);
                else 
                    $aDadosDocumento = self::getDadosDocumentoFromOrdemServico($oVistoriaItem);

                return $aDadosDocumento;

                break;
        }
    }

    private static function getDadosDocumentoFromResv($oVistoriaItem)
    {
        $aDados = [
            'numero_documento' => null,
            'procedencia_origem' => null,
            'transportadora' => null,
            'container' => null,
            'peso' => null,
            'valor' => null,
            'cliente' => null,
        ];

        $oVistoria = $oVistoriaItem->vistoria;
        if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container')) {

            $oResv = LgDbUtil::getFind('Resvs')
                ->contain([
                    'Transportadoras', 
                    'ResvsDocumentosTransportes' => [
                        'DocumentosTransportes' => [
                            'ContainerEntradas',
                            'DocumentosMercadoriasMany' => [
                                'ProcedenciasOrigens',
                                'Clientes',
                                'DocumentosMercadoriasItens'
                            ]
                        ]
                    ],
                    'ResvsContainers' => [
                        'Containers'
                    ]
                ])
                ->where(['Resvs.id' => $oVistoria->resv_id])
                ->first();

            foreach ($oResv->resvs_documentos_transportes as $oResvDocTransporte) {

                foreach ($oResvDocTransporte->documentos_transporte->container_entradas as $oContainerEntradas) {

                    if ($oVistoriaItem->container_id == $oContainerEntradas->container_id) {

                        $sAno    = DateUtil::dateTimeFromDB(@$oResvDocTransporte->documentos_transporte->data_emissao, 'Y');
                        $sNumero = @$oResvDocTransporte->documentos_transporte->numero;
                        $aDados['numero_documento'] = $sAno . '/' . $sNumero;
                        $aDados['valor'] = 'R$: ' . DocumentosMercadoria::getValorTotal($oResvDocTransporte->documentos_transporte->id);

                        foreach ($oResvDocTransporte->documentos_transporte->documentos_mercadorias as $oDocMercadoria) {

                            if ($oDocMercadoria->documento_mercadoria_id_master == null) {
                                $aDados['procedencia_origem'] = $oDocMercadoria->procedencias_origem->sigla;
                            } else {
                                $aDados['peso']    = $oDocMercadoria->peso_bruto . ' kg';
                                $aDados['cliente'] = $oDocMercadoria->cliente->descricao . ' (' . $oDocMercadoria->cliente->cnpj . ')';
                            }

                        }

                    }

                }

            }

            foreach ($oResv->resvs_containers as $oResvContainer) {

                if ($oVistoriaItem->container_id == $oResvContainer->container_id) {
                    
                    $aDados['transportadora']     = $oResv->transportadora->razao_social;
                    $aDados['container']          = $oResvContainer->container->numero;
                }

            }

        } else if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral')) {


        }

        return $aDados;
    }

    private static function getDadosDocumentoFromProgramacao($oVistoriaItem)
    {
        $aDados = [
            'numero_documento' => null,
            'procedencia_origem' => null,
            'transportadora' => null,
            'container' => null,
            'peso' => null,
            'valor' => null,
            'cliente' => null,
        ];

        $oVistoria = $oVistoriaItem->vistoria;
        if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container')) {

            $oProgramacao = LgDbUtil::getFind('Programacoes')
                ->contain([
                    'Transportadoras', 
                    'ProgramacaoDocumentoTransportes' => [
                        'DocumentosTransportes' => [
                            'ContainerEntradas',
                            'DocumentosMercadoriasMany' => [
                                'ProcedenciasOrigens',
                                'Clientes',
                                'DocumentosMercadoriasItens'
                            ]
                        ]
                    ],
                    'ProgramacaoContainers' => [
                        'Containers'
                    ]
                ])
                ->where(['Programacoes.id' => $oVistoria->programacao_id])
                ->first();

            foreach ($oProgramacao->programacao_documento_transportes as $oProgramacaoDocTransporte) {

                foreach ($oProgramacaoDocTransporte->documentos_transporte->container_entradas as $oContainerEntradas) {

                    if ($oVistoriaItem->container_id == $oContainerEntradas->container_id) {

                        $sAno    = DateUtil::dateTimeFromDB(@$oProgramacaoDocTransporte->documentos_transporte->data_emissao, 'Y');
                        $sNumero = @$oProgramacaoDocTransporte->documentos_transporte->numero;
                        $aDados['numero_documento'] = $sAno . '/' . $sNumero;
                        $aDados['valor'] = 'R$: ' . DocumentosMercadoria::getValorTotal($oProgramacaoDocTransporte->documentos_transporte->id);

                        foreach ($oProgramacaoDocTransporte->documentos_transporte->documentos_mercadorias as $oDocMercadoria) {

                            if ($oDocMercadoria->documento_mercadoria_id_master == null) {
                                $aDados['procedencia_origem'] = $oDocMercadoria->procedencias_origem->sigla;
                            } else {
                                $aDados['peso']    = $oDocMercadoria->peso_bruto . ' kg';
                                $aDados['cliente'] = $oDocMercadoria->cliente->descricao . ' (' . $oDocMercadoria->cliente->cnpj . ')';
                            }

                        }

                    }

                }

            }

            foreach ($oProgramacao->programacao_containers as $oProgramacaoContainer) {

                if ($oVistoriaItem->container_id == $oProgramacaoContainer->container_id) {

                    $aDados['transportadora']     = $oProgramacao->transportadora->razao_social;
                    $aDados['container']          = $oProgramacaoContainer->container->numero;

                }

            }

        } else if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral')) {


        }

        return $aDados;
    }

    private static function getDadosDocumentoFromOrdemServico($oVistoriaItem, $oVistoria = null) 
    {
        if (!$oVistoria)
            $oVistoria = $oVistoriaItem->vistoria;

        $oOrdemServico = LgDbUtil::getFind('OrdemServicos')
            ->contain([
                'OrdemServicoItens' => [
                    'Containers', 
                    'DocumentosMercadoriasItens' => [
                        'DocumentosMercadorias' => [
                            'ProcedenciasOrigens'
                        ]
                    ]
                ]
            ])
            ->where(['OrdemServicos.id' => $oVistoria->ordem_servico_id])
            ->first();

        if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container')) {
            
            foreach ($oOrdemServico->ordem_servico_itens as $oOrdemServicoItem) {

                if ($oVistoriaItem->container_id == $oOrdemServicoItem->container_id) {

                    $sAno    = DateUtil::dateTimeFromDB(@$oOrdemServicoItem->documentos_mercadorias_item->documentos_mercadoria->data_emissao, 'Y');
                    $sNumero = @$oOrdemServicoItem->documentos_mercadorias_item->documentos_mercadoria->numero_documento;

                    $aDados['numero_documento']   = $sAno . '/' . $sNumero;
                    $aDados['procedencia_origem'] = @$oOrdemServicoItem->documentos_mercadorias_item->documentos_mercadoria->procedencias_origem->sigla;
                    $aDados['transportadora']     = 'N/A';
                    $aDados['container']          = @$oOrdemServicoItem->container->numero;
                
                }

            }

        } else if ($oVistoria->vistoria_tipo_carga_id == EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Carga Geral')) {

            $sNumerosDocumentos   = '';
            $sProcedenciasOrigens = '';

            foreach ($oOrdemServico->ordem_servico_itens as $oOrdemServicoItem) {
                
                $sAno    = DateUtil::dateTimeFromDB($oOrdemServicoItem->documentos_mercadorias_item->documentos_mercadoria->data_emissao, 'Y');
                $sNumero = $oOrdemServicoItem->documentos_mercadorias_item->documentos_mercadoria->numero_documento;

                $sNumerosDocumentos   .= $sAno . '/' . $sNumero . '; ';
                $sProcedenciasOrigens .= @$oOrdemServicoItem->documentos_mercadorias_item->documentos_mercadoria->procedencias_origem->sigla . '; ';

            }

            $aDados['numero_documento']   = $sNumerosDocumentos;
            $aDados['procedencia_origem'] = $sProcedenciasOrigens;
            $aDados['transportadora']     = 'N/A';

        }

        return $aDados;
    }

    private static function getTipoRegistroVistoria($oVistoria)
    {
        if (!$oVistoria)
            return null;

        if ($oVistoria->resv_id)
            return 'Resv';
        else if ($oVistoria->programacao_id)
            return 'Programacao';
        else if ($oVistoria->ordem_servico_id)
            return 'OrdemServico';

        return null;
    }

    private static function getDatasHorasVeiculo($oVistoriaItem, $oVistoria = null)
    {
        if ($oVistoria)
            $sTipoRegistro = self::getTipoRegistroVistoria($oVistoria);
        else
            $sTipoRegistro = self::getTipoRegistroVistoria($oVistoriaItem->vistoria);

        $aDatas = [];
        switch ($sTipoRegistro) {

            case 'Resv':
                
                $oResv = LgDbUtil::getFirst('Resvs', ['Resvs.id' => $oVistoriaItem->vistoria->resv_id]);

                $aDatas['data_hora_um']['titulo']   = 'Data/Hora Chegada:';
                $aDatas['data_hora_dois']['titulo'] = 'Data/Hora Entrada:';
                $aDatas['data_hora_tres']['titulo'] = 'Data/Hora Saída:';

                $aDatas['data_hora_um']['data']   = DateUtil::dateTimeFromDB($oResv->data_hora_chegada, 'd/m/Y H:i', ' ');
                $aDatas['data_hora_dois']['data'] = DateUtil::dateTimeFromDB($oResv->data_hora_entrada, 'd/m/Y H:i', ' ');
                $aDatas['data_hora_tres']['data'] = DateUtil::dateTimeFromDB($oResv->data_hora_saida, 'd/m/Y H:i', ' ');

                break;
            
            case 'Programacao':

                $oProgramacao = LgDbUtil::getFirst('Programacoes', ['Programacoes.id' => $oVistoriaItem->vistoria->programacao_id]);

                $aDatas['data_hora_um']['titulo']   = 'Data/Hora Chegada:';
                $aDatas['data_hora_dois']['titulo'] = 'Data/Hora Entrada:';
                $aDatas['data_hora_tres']['titulo'] = 'Data/Hora Saída:';

                $aDatas['data_hora_um']['data']   = DateUtil::dateTimeFromDB($oProgramacao->data_hora_chegada, 'd/m/Y H:i', ' ');
                $aDatas['data_hora_dois']['data'] = DateUtil::dateTimeFromDB($oProgramacao->data_hora_entrada, 'd/m/Y H:i', ' ');
                $aDatas['data_hora_tres']['data'] = DateUtil::dateTimeFromDB($oProgramacao->data_hora_saida, 'd/m/Y H:i', ' ');
                
                break;

            case 'OrdemServico':

                if ($oVistoria)
                    $oOrdemServico = LgDbUtil::getFirst('OrdemServicos', ['OrdemServicos.id' => $oVistoria->ordem_servico_id]);
                else
                    $oOrdemServico = LgDbUtil::getFirst('OrdemServicos', ['OrdemServicos.id' => $oVistoriaItem->vistoria->ordem_servico_id]);
                
                $aDatas['data_hora_um']['titulo']   = 'Data/Hora Início:';
                $aDatas['data_hora_dois']['titulo'] = 'Data/Hora Fim:';

                $aDatas['data_hora_um']['data']   = DateUtil::dateTimeFromDB($oOrdemServico->data_hora_inicio, 'd/m/Y H:i', ' ');
                $aDatas['data_hora_dois']['data'] = DateUtil::dateTimeFromDB($oOrdemServico->data_hora_fim, 'd/m/Y H:i', ' ');

                break;

        }

        return $aDatas;
    }

    private static function getDadosVistoria($oVistoriaItem, $oVistoria = null)
    {
        $aDados = [];
        if ($oVistoriaItem) {

            $aDados['container_tara']      = $oVistoriaItem->tara;
            $aDados['container_mgw']       = $oVistoriaItem->mgw;
            $aDados['container_tipo_iso']  = $oVistoriaItem->tipo_iso;
            $aDados['container_forma_uso'] = @$oVistoriaItem->container_forma_uso->descricao;
            $aDados['data_hora_vistoria']  = DateUtil::dateTimeFromDB($oVistoriaItem->data_hora_vistoria, 'd/m/Y H:i', ' ');

        } else if ($oVistoria) {

            $aDados['data_hora_vistoria']  = DateUtil::dateTimeFromDB($oVistoria->data_hora_vistoria, 'd/m/Y H:i', ' ');

        }

        return $aDados;
    }

    public static function getVistoriaAvariaRespostas($iVistoriaId)
    {
        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain(['VistoriaAvarias' => ['VistoriaAvariaRespostas' => ['VistoriaAvarias' => ['VistoriaItens']]]])
            ->where(['Vistorias.id' => $iVistoriaId])
            ->first();


        if ($oVistoria->vistoria_avarias) {

            $aVistoriaAvariaRespostas = [];
            foreach ($oVistoria->vistoria_avarias as $oVistoriaAvaria) {
                
                if ($oVistoriaAvaria->vistoria_avaria_respostas) {

                    foreach ($oVistoriaAvaria->vistoria_avaria_respostas as $oVistoriaAvariaResposta) {
                        
                        $aVistoriaAvariaRespostas[$oVistoriaAvariaResposta->vistoria_avaria->vistoria_item->container_id][$oVistoriaAvariaResposta->avaria_resposta_id] = $oVistoriaAvariaResposta->avaria_resposta_id;
                    
                    }

                }

            }

            return $aVistoriaAvariaRespostas;

        }

        return null;
    }

    public static function getVistoriaAvarias($iVistoriaId)
    {
        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain(['VistoriaAvarias'])
            ->where(['Vistorias.id' => $iVistoriaId])
            ->first();


        if ($oVistoria->vistoria_avarias) {

            $aVistoriaAvarias = [];
            foreach ($oVistoria->vistoria_avarias as $oVistoriaAvaria) {
                
                $aVistoriaAvarias[$oVistoriaAvaria->vistoria_item_id][$oVistoriaAvaria->avaria_id] = $oVistoriaAvaria->avaria_id;

            }

            return $aVistoriaAvarias;

        }

        return null;
    }

    public static function verifyIsFerroviario($iProgramacaoID, $iResvID)
    {
        if ($iProgramacaoID) {

            $oRegistro = LgDbUtil::getFind('Programacoes')
                ->where(['Programacoes.id' => $iProgramacaoID])
                ->first();

        } else if ($iResvID) {

            $oRegistro = LgDbUtil::getFind('Resvs')
                ->where(['Resvs.id' => $iResvID])
                ->first();

        } else {

            return false;

        }

        if (!$oRegistro->viagem_id)
            return false;

        return true;
    }

    public static function gerarVistoriaExterna($iProgramacaoID)
    {
        $oResponse = new ResponseUtil();

        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain([
                'ProgramacaoContainers' => [
                    'Containers'
                ], 
                'Pessoas',
                'Veiculos',
                'GradeHorarios'
            ])
            ->where(['Programacoes.id' => $iProgramacaoID])
            ->first();

        if (!$oProgramacao->programacao_containers)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Adicione containers a esta Programação para poder gerar Vistorias!');
            
        return self::executeInsertsVistoriaExterna($oProgramacao);
    }

    private static function executeInsertsVistoriaExterna($oProgramacao)
    {
        $oResponse = new ResponseUtil();

        // Para cada container da programação, uma vistoria deve ser gerada;
        foreach ($oProgramacao->programacao_containers as $oProgContainer) {

            $aDataInsertVistoria = self::getInsertVistoriaExterna($oProgramacao);
            $oVistoria           = LgDbUtil::saveNew('Vistorias', $aDataInsertVistoria, true);
            if (!$oVistoria)
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao gerar a Vistoria!');

            $aDataInsertVistoriaItem = self::getInsertVistoriaItemExterna($oVistoria, $oProgContainer);
            if (!LgDbUtil::saveNew('VistoriaItens', $aDataInsertVistoriaItem, true))
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Ocorreu algum erro ao gravar os Itens da Vistoria!');

        }

        return $oResponse
            ->setStatus(200)
            ->setTitle('Sucesso!')
            ->setMessage('Vistoria (as) gerada (as) com sucesso!');
    }

    private static function getInsertVistoriaExterna($oProgramacao)
    {
        return [
            'cpf_motorista'          => trim($oProgramacao->pessoa->cpf),
            'pessoa_id'              => $oProgramacao->pessoa_id,
            'placa'                  => $oProgramacao->veiculo->descricao,
            'veiculo_id'             => $oProgramacao->veiculo_id,
            'vistoria_tipo_carga_id' => EntityUtil::getIdByParams('VistoriaTipoCargas', 'descricao', 'Container'),
            'programacao_id'         => $oProgramacao->id,
            'vistoria_tipo_id'       => $oProgramacao->grade_horario->vistoria_tipo_id,
        ];
    }

    public static function getInsertVistoriaItemExterna($oVistoria, $oProgContainer)
    {
        $oEntradaSaidaContainer = EntradaSaidaContainer::getLastByContainerId($oProgContainer->container_id);

        $oItemContainer = LgDbUtil::getFind('ItemContainers')
            ->where([
                'documento_transporte_id' => $oProgContainer->documento_transporte_id,
                'container_id'            => $oProgContainer->container_id
            ])
            ->first();

        return [
            'vistoria_id'                => $oVistoria->id,
            'container_id'               => $oProgContainer->container_id,
            'entrada_saida_container_id' => @$oEntradaSaidaContainer->id ?: null,
            'documento_transporte_id'    => $oProgContainer->documento_transporte_id,
            'documento_mercadoria_item_id' => @$oItemContainer->documento_mercadoria_item_id
        ];
    }

    public static function getDadosExecuteVistoriaExterna($oVistoria)
    {
        $oVistoriaItem = $oVistoria->vistoria_itens[0];

        return [
            'despachante' => null,
            'documento'   => self::getNumeroDocumentoTransporteVistoriaExterna($oVistoriaItem->documento_transporte_id),
            'itens'       => self::getInfosDocumentoMercadoria('Itens', $oVistoriaItem->documento_transporte_id, $oVistoriaItem->container, $oVistoriaItem->documento_mercadoria_item_id),
            'quantidade'  => self::getInfosDocumentoMercadoria('Quantidade', $oVistoriaItem->documento_transporte_id, $oVistoriaItem->container, $oVistoriaItem->documento_mercadoria_item_id)
        ];
    }

    public static function getInfosDocumentoMercadoria($sInfo, $iDocumentoTransporteID, $oContainer, $iDocMercItemId)
    {
        $iDocumentoTransporteID = $iDocumentoTransporteID;
        if (!$iDocumentoTransporteID)
            return '';

        $oDocMercItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->contain(['Produtos'])
            ->where([
                'DocumentosMercadoriasItens.id' => $iDocMercItemId
            ])
            ->first();

        $oItemContainer = LgDbUtil::getFind('ItemContainers')
            ->where([
                'documento_transporte_id' => $iDocumentoTransporteID,
                'documento_mercadoria_item_id' => $iDocMercItemId
            ])
            ->first();

            // ->matching('Tags', function ($q) {
            //     return $q->where(['Tags.name' => 'CakePHP']);
            // })
    
        if (!$oDocMercItem)
            return '';

        $uReturn = null;
        switch ($sInfo) {
            case 'Itens':

                $sItens = '';
                $sItens .= @$oDocMercItem->produto->codigo . ' - ' . @$oDocMercItem->produto->descricao . '; </br>';

                $uReturn = $sItens;

                break;

            case 'Quantidade':

                $iQuantidade = 0;
                $iQuantidade += $oItemContainer->quantidade;

                $uReturn = $iQuantidade;

                break;
        }

        return $uReturn;
    }

    public static function getNumeroDocumentoTransporteVistoriaExterna($iDocumentoTransporteID)
    {
        $iDocumentoTransporteID = $iDocumentoTransporteID;
        if (!$iDocumentoTransporteID)
            return '';

        $oDocumentoTransporte = LgDbUtil::getFind('DocumentosTransportes')
            ->where([
                'id' => $iDocumentoTransporteID
            ])
            ->first();
    
        if (!$oDocumentoTransporte)
            return '';

        return $oDocumentoTransporte->numero;
    }

    private static function getDocumentoTransporteId($oProgramacao, $oContainer)
    {
        $iDocumentoTransporteID = null;
        foreach ($oProgramacao->programacao_containers as $oProgContainer) {
            if ($oProgContainer->container_id == $oContainer->id)
                $iDocumentoTransporteID = $oProgContainer->documento_transporte_id;
        }

        return $iDocumentoTransporteID;
    }

    public static function setDataHoraVistoriaExterna($oVistoria)
    {
        $oResponse = new ResponseUtil();

        $oVistoria->data_hora_vistoria = DateUtil::dateTimeToDB(date('Y-m-d H:i:s'));

        if (!LgDbUtil::save('Vistorias', $oVistoria))
            return $oResponse
                ->setStatus(400)
                ->setMessage('Ocorreu um erro ao salvar o iniciar a vistoria externa!')
                ->setTitle('Ops...!');

        return $oResponse
            ->setStatus(200);
    }

    public static function finalizarExterna($aData)
    {
        $oResponse = new ResponseUtil();

        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain([
                'Programacoes' => [
                    'GradeHorarios'
                ],
                'VistoriaFotos'
            ])
            ->where([
                'Vistorias.id' => $aData['vistoria_id']
            ])
            ->first();

        $oGradeHorario = @$oVistoria->programacao->grade_horario;

        if ($oGradeHorario && $oGradeHorario->obriga_fotos_vistorias && !$oVistoria->vistoria_fotos) {
            return $oResponse
                ->setStatus(400)
                ->setMessage('Necessário registrar fotos do processo!')
                ->setTitle('Ops...!');
        }

        if (!$oVistoria->data_hora_fim)
            $oVistoria->data_hora_fim = DateUtil::dateTimeToDB(date('Y-m-d H:i:s'));
        else
            $oVistoria->updated_at = DateUtil::dateTimeToDB(date('Y-m-d H:i:s'));

        if (isset($aData['abertura_porta']) && $aData['abertura_porta'] == 'com_abertura')
            $oVistoria->abertura_porta = 1;

        if (!LgDbUtil::save('Vistorias', $oVistoria))
            return $oResponse
                ->setStatus(400)
                ->setMessage('Ocorreu um erro ao salvar o finalizar a vistoria externa! ' . EntityUtil::dumpErrors($oVistoria))
                ->setTitle('Ops...!');

        return $oResponse
            ->setStatus(200)
            ->setMessage('Vistoria Externa finalizada com sucesso!')
            ->setDataExtra($oVistoria)
            ->setTitle('Sucesso!');
    }

    public static function addVistoriaExterna($aData)
    {
        if (!isset($aData['documento_entrada_id']))
            return (new ResponseUtil())
                ->setMessage('Parâmetro de documento faltante.');

        $aVistoriaItens = [];
        if (!empty($aData['container_id']))
            $aVistoriaItens = VistoriaItem::getVistoriaItensByContainer(
                $aData['documento_entrada_id'], 
                $aData['container_id'], 
                $aData['busca_estoque'],
                @$aData['ordem_servico_id'] ?: null
            );
        else
            $aVistoriaItens = VistoriaItem::getVistoriaItensByDoc(
                $aData['documento_entrada_id'], 
                $aData['busca_estoque']
            );

        if (!$aVistoriaItens)
            return (new ResponseUtil())
                ->setMessage('Nenhum item encontrado para a vistoria.');

        $oVistoria = LgDbUtil::get('Vistorias')->newEntity($aData);
        $oVistoria->data_hora_vistoria = DateUtil::dateTimeToDB(date('Y-m-d H:i'));
        $oVistoria->created_at = DateUtil::dateTimeToDB(date('Y-m-d H:i'));

        if (LgDbUtil::get('Vistorias')->save($oVistoria)) {
            foreach ($aVistoriaItens as $key => $aVistoriaItem) {
                $aVistoriaItens[$key]['quantidade'] = null;
                $aVistoriaItens[$key]['peso'] = null;

                $aVistoriaItens[$key]['vistoria_id'] = $oVistoria->id;
                $aVistoriaItens[$key]['documento_transporte_id'] = $aData['documento_entrada_id'];
                if (isset($aData['container_id']))
                    $aVistoriaItens[$key]['container_id'] = $aData['container_id'];
            }

            $aVistoriaItensEntities = LgDbUtil::get('VistoriaItens')->newEntities($aVistoriaItens);

            if (LgDbUtil::get('VistoriaItens')->saveMany($aVistoriaItensEntities))
                return (new ResponseUtil())
                    ->setStatus(200)
                    ->setMessage('Vistoria criada com sucesso.')
                    ->setDataExtra($oVistoria);
        }
            
        return (new ResponseUtil())
            ->setMessage('Erro ao criar vistoria.');
    }

    public static function getDadosDecPesoLiquido($iVistoriaID)
    {
        $oVistoria = LgDbUtil::getFind('Vistorias')
            ->contain([
                'VistoriaItens' => [
                    'DocumentosMercadoriasItens' => [
                        'DocumentosMercadorias' => [
                            'DocumentosTransportes'
                        ],
                        'Produtos'
                    ],
                    'Containers'
                ]
            ])
            ->where(['Vistorias.id' => $iVistoriaID])
            ->first();


        $aDataAdicoes = [];
        $aTotalPesoAdicoes = [];
        $aTotalVolumeAdicoes = [];
        $sDocumento = '';
        $sContainer = '';
        foreach ($oVistoria->vistoria_itens as $key => $oVistoriaItem) {

            if (!$oVistoriaItem->peso)
                continue;

            if ($key == 0) {
                $sDocumento = $oVistoriaItem->documentos_mercadorias_item->documentos_mercadoria->documentos_transporte->numero;
                $sContainer = $oVistoriaItem->container->numero;
            }

            $oDocMercItem = $oVistoriaItem->documentos_mercadorias_item;
            $fPesoLiquido = ($oVistoriaItem->peso / $oVistoriaItem->quantidade) * $oVistoriaItem->volumes;

            if (isset($aTotalPesoAdicoes[$oDocMercItem->adicao_id]))
                $aTotalPesoAdicoes[$oDocMercItem->adicao_di] += $fPesoLiquido;
            else
                $aTotalPesoAdicoes[$oDocMercItem->adicao_di] = $fPesoLiquido;

            if (isset($aTotalVolumeAdicoes[$oDocMercItem->adicao_di]))
                $aTotalVolumeAdicoes[$oDocMercItem->adicao_di] += $oVistoriaItem->volumes;
            else
                $aTotalVolumeAdicoes[$oDocMercItem->adicao_di] = $oVistoriaItem->volumes;

            $aDataAdicoes[$oDocMercItem->adicao_di][$oDocMercItem->item_adicao] = [
                'produto' => $oDocMercItem->produto->descricao,
                'volume' => $oVistoriaItem->volumes,
                'peso' => $oVistoriaItem->peso / $oVistoriaItem->quantidade,
                'peso_liquido' => $fPesoLiquido
            ];
        }

        $aDados = [];
        $aDados['documento']            = $sDocumento;
        $aDados['container']            = $sContainer;
        $aDados['empresa_padrao']       = self::getEmpresaPadrao();
        $aDados['item_adicoes']         = $aDataAdicoes;
        $aDados['qtde_peso_adicoes']    = $aTotalPesoAdicoes;
        $aDados['qtde_volumes_adicoes'] = $aTotalVolumeAdicoes;

        return $aDados;
    }
}
