<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class DriveEspaco extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function verifyContainerInDriveEspaco($iDriveEspacoID, $aContainers)
    {
        $oResponse = new ResponseUtil();

        $oDriveEspaco = LgDbUtil::getFind('DriveEspacos')
            ->where(['id' => $iDriveEspacoID])
            ->contain(['DriveEspacoContainers'])
            ->first();

        if (!$oDriveEspaco->drive_espaco_containers)
            return $oResponse
                ->setStatus(200);

        if (!$aContainers)
            return $oResponse
                ->setStatus(400)
                ->setMessage('Este Drive necessita que o container esteja associado no cadastro do Drive (reserva)!');

        $aContainersInDrive = [];
        
        foreach ($oDriveEspaco->drive_espaco_containers as $oDriveEspacoContainer) {
            $aContainersInDrive[] = $oDriveEspacoContainer->container_id;
        }

        foreach ($aContainers as $iContainerID) {
            if ( !in_array($iContainerID, $aContainersInDrive) ) {
                $oContainer = LgDbUtil::getByID('Containers', $iContainerID);

                return $oResponse
                    ->setStatus(400)
                    ->setMessage('O container "' . $oContainer->numero . '" não está no Drive "' . $oDriveEspaco->descricao . '"!'); 
            }
        }

        return $oResponse
            ->setStatus(200); 
    }

    public static function checkQtdeContainer($oDriveEspaco, $iOperacaoID, $sTipoContainer)
    {
        $oResponse = new ResponseUtil;

        if (Resv::isCarga(null, $iOperacaoID)) {

            if ($sTipoContainer == 'VAZIO')
                $iMaxQtdeContainers = $oDriveEspaco->qtde_container_vazio_carga;
            else if ($sTipoContainer == 'CHEIO')
                $iMaxQtdeContainers = $oDriveEspaco->qtde_container_cheio_carga;

        } else if (Resv::isDescarga(null, $iOperacaoID)) {

            if ($sTipoContainer == 'VAZIO')
                $iMaxQtdeContainers = $oDriveEspaco->qtde_container_vazio_descarga;
            else if ($sTipoContainer == 'CHEIO')
                $iMaxQtdeContainers = $oDriveEspaco->qtde_container_cheio_descarga;

        }


        $iAtualQtdeContainers = self::getQtdeAtualContainers($oDriveEspaco, $sTipoContainer, $iOperacaoID);

        if ($iAtualQtdeContainers + 1 > $iMaxQtdeContainers)
            return $oResponse
                ->setMessage('Este Drive de Espaço não suporta mais este Container! A quantidade utilizada ' . $iAtualQtdeContainers . ', máximo permitido ' . $iMaxQtdeContainers . '.');

        return $oResponse
            ->setStatus(200);
    }

    public static function getQtdeAtualContainers($oDriveEspaco, $sTipoContainer, $iOperacaoID)
    {
        $iCount = LgDbUtil::getFind('EntradaSaidaContainers')
            ->distinct('EntradaSaidaContainers.container_id')
            ->select('EntradaSaidaContainers.container_id')
            ->matching('ResvsContainers')
            ->where([
                'EntradaSaidaContainers.resv_entrada_id IS NOT NULL',
                'EntradaSaidaContainers.resv_saida_id IS NULL',
                'EntradaSaidaContainers.drive_espaco_atual_id' => $oDriveEspaco->id,
                'EntradaSaidaContainers.tipo_atual' => $sTipoContainer,
                'ResvsContainers.operacao_id' => $iOperacaoID
            ])
            ->group('EntradaSaidaContainers.container_id')
            ->count();

        $iCount += LgDbUtil::getFind('ProgramacaoContainers')
        ->distinct('ProgramacaoContainers.container_id')
        ->select('ProgramacaoContainers.container_id')
        ->innerJoinWith('Programacoes')
        ->group('ProgramacaoContainers.container_id')
        ->where([
            'Programacoes.resv_id IS NULL', 
            'ProgramacaoContainers.drive_espaco_id' => $oDriveEspaco->id,
            'ProgramacaoContainers.operacao_id' => $iOperacaoID,
            'ProgramacaoContainers.tipo' => $sTipoContainer
        ])
        ->count();

        return $iCount;
    }

    public static function validaCapacidadeEstoque($iQuantidadeLiberar, $iDriveEspacoClassificacaoID, $iArmadorID, $iContainerTamanhoID, $iTipoIsoID, $iContainerFormaUsoID, $iSuperTestado)
    {
        $oResponse = new ResponseUtil();

        if ($iContainerFormaUsoID == "null")
            $iContainerFormaUsoID = 'IS NULL';

        if ($iSuperTestado == "null")
            $iSuperTestado = 'IS NULL';

        $iQuantidadeReservada = self::getQuantidadeReservada($iDriveEspacoClassificacaoID, $iArmadorID, $iContainerTamanhoID, $iTipoIsoID, $iContainerFormaUsoID, $iSuperTestado);
        $iQuantidadeEstoque   = self::getQuantidadeEstoque($iDriveEspacoClassificacaoID, $iArmadorID, $iContainerTamanhoID, $iTipoIsoID, $iContainerFormaUsoID, $iSuperTestado);

        if (((int)$iQuantidadeLiberar + $iQuantidadeReservada) > $iQuantidadeEstoque) {

            if ($iQuantidadeEstoque >= $iQuantidadeReservada) {

                $iQuantidadePossivel = $iQuantidadeEstoque - $iQuantidadeReservada;

                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Você está tentando reservar uma quantidade maior do que há em estoque, ou já está reservada!<b> É possível reservar ' . $iQuantidadePossivel . ' Containers</b>');
        
            } else if ($iQuantidadeEstoque < $iQuantidadeReservada) {
                return $oResponse
                    ->setStatus(400)
                    ->setTitle('Ops!')
                    ->setMessage('Não é possível reservar mais Containers para essas caracteristicas de Drive de Espaço!');
            }
            
        }
        
        return $oResponse
            ->setStatus(200);
    }

    private static function getQuantidadeReservada($iDriveEspacoClassificacaoID, $iArmadorID, $iContainerTamanhoID, $iTipoIsoID, $iContainerFormaUsoID, $iSuperTestado)
    {
        $iQuantidade = 0;
        
        $aWhere = [
            'operacao_id'                   => EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga'),
            'armador_id'                    => $iArmadorID,
            'drive_espaco_tipo_id'          => EntityUtil::getIdByParams('DriveEspacoTipos', 'descricao', 'Container'),
            'drive_espaco_classificacao_id' => $iDriveEspacoClassificacaoID,
            'conteiner_tamanho_id'          => $iContainerTamanhoID,
            'tipo_iso_id'                   => $iTipoIsoID,
            'OR' => [['data_hora_validade >' => DateUtil::getNowToDB()], ['data_hora_validade IS' => null]]
        ];

        if ($iContainerFormaUsoID == 'IS NULL')
            $aWhere += ['container_forma_uso_id IS' => null];
        else 
            $aWhere += ['container_forma_uso_id' => $iContainerFormaUsoID];

        if ($iSuperTestado == 'IS NULL')
            $aWhere += ['container_forma_uso_id IS' => null];
        else 
            $aWhere += ['container_forma_uso_id' => $iSuperTestado];

        $oDriveEspacos = LgDbUtil::getFind('DriveEspacos')
            ->where($aWhere)
            ->toArray();

        if ($oDriveEspacos) {

            foreach ($oDriveEspacos as $oDriveEspaco) {
                
                $iQuantidade += $oDriveEspaco->qtde_cnt_possivel;

            }

            return $iQuantidade;
        }

        return $iQuantidade;
    }

    private static function getQuantidadeEstoque($iDriveEspacoClassificacaoID, $iArmadorID, $iContainerTamanhoID, $iTipoIsoID, $iContainerFormaUsoID, $iSuperTestado)
    {
        $iQuantidade = 0;

        $aWhere = self::getWhereEstoqueEnderecos($iDriveEspacoClassificacaoID, $iArmadorID, $iContainerTamanhoID, $iTipoIsoID, $iContainerFormaUsoID, $iSuperTestado);

        $oEstoqueEnderecos = LgDbUtil::getFind('EstoqueEnderecos')
            ->contain(['Containers' => ['TipoIsos', 'EntradaSaidaContainers']])
            ->where($aWhere)
            ->group('EstoqueEnderecos.container_id')
            ->count();

        $iQuantidade = $oEstoqueEnderecos;

        return $iQuantidade;
    }

    private static function getWhereEstoqueEnderecos($iDriveEspacoClassificacaoID, $iArmadorID, $iContainerTamanhoID, $iTipoIsoID, $iContainerFormaUsoID, $iSuperTestado)
    {
        if ($iDriveEspacoClassificacaoID == EntityUtil::getIdByParams('DriveEspacoClassificacoes', 'descricao', 'Cheio')) {

            $aWhere = [
                'EstoqueEnderecos.produto_id IS NOT'            => null,
                'EstoqueEnderecos.container_id IS NOT'          => null,
                'Containers.armador_id'                         => $iArmadorID,
                'TipoIsos.id'                                   => $iTipoIsoID,
                'TipoIsos.container_tamanho_id'                 => $iContainerTamanhoID,
            ];

        } else if ($iDriveEspacoClassificacaoID == EntityUtil::getIdByParams('DriveEspacoClassificacoes', 'descricao', 'Vazio')) {

            $aWhere = [
                'EstoqueEnderecos.produto_id IS'                => null,
                'EstoqueEnderecos.unidade_medida_id IS'         => EntityUtil::getIdByParams('UnidadeMedidas', 'descricao', 'Container'),
                'EstoqueEnderecos.container_id IS NOT'          => null,
                'Containers.armador_id'                         => $iArmadorID,
                'TipoIsos.id'                                   => $iTipoIsoID,
                'TipoIsos.container_tamanho_id'                 => $iContainerTamanhoID,
            ];

        }

        $aWhere += ['OR' => [['EntradaSaidaContainers.container_destino_id !=' => EntityUtil::getIdByParams('ContainerDestinos', 'descricao', 'Apoio')], ['EntradaSaidaContainers.container_destino_id IS' => null]]];

        if ($iContainerFormaUsoID == 'IS NULL')
            $aWhere += ['EntradaSaidaContainers.container_forma_uso_id IS' => null];
        else 
            $aWhere += ['EntradaSaidaContainers.container_forma_uso_id' => $iContainerFormaUsoID];

        if ($iSuperTestado == 'IS NULL')
            $aWhere += ['EntradaSaidaContainers.super_testado IS' => null];
        else 
            $aWhere += ['EntradaSaidaContainers.super_testado' => $iSuperTestado];

        return $aWhere;
    }

    public static function getFilters($aDataQuery)
    {
        $aContainersWhere = [];
        if ($aDataQuery['container']['values'][0])
            $aContainersWhere += ['Containers.id' => $aDataQuery['container']['values'][0]];
        $aContainers = LgdbUtil::get('Containers')
            ->find('list', ['keyField' => 'id', 'valueField' => 'numero'])
            ->select( ['id', 'numero'] )
            ->where($aContainersWhere)
            ->limit(1);

        $aDriveEspacosWhere = [];
        if ($aDataQuery['drive_espaco']['values'][0])
            $aDriveEspacosWhere += ['DriveEspacos.id' => $aDataQuery['drive_espaco']['values'][0]];
        $aDriveEspacos = LgdbUtil::get('DriveEspacos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aDriveEspacosWhere)
            ->limit(1);

        $aEmpresasArmadorWhere = [];
        if ($aDataQuery['armador']['values'][0])
            $aEmpresasArmadorWhere += ['Empresas.id' => $aDataQuery['armador']['values'][0]];
        $aEmpresasArmador = LgdbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aEmpresasArmadorWhere)
            ->limit(1);

        $aEmpresasClienteWhere = [];
        if ($aDataQuery['cliente']['values'][0])
            $aEmpresasClienteWhere += ['Empresas.id' => $aDataQuery['cliente']['values'][0]];
        $aEmpresasCliente = LgdbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aEmpresasClienteWhere)
            ->limit(1);

        $aEmpresasBeneficiarioWhere = [];
        if ($aDataQuery['beneficiario']['values'][0])
            $aEmpresasBeneficiarioWhere += ['Empresas.id' => $aDataQuery['beneficiario']['values'][0]];
        $aEmpresasBeneficiario = LgdbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aEmpresasBeneficiarioWhere)
            ->limit(1);

        $aOperacoes = LgdbUtil::get('Operacoes')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        $aDriveEspacoTipos = LgdbUtil::get('DriveEspacoTipos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        $aTipoIsos = LgdbUtil::get('TipoIsos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        $aContainerFormaUsos = LgdbUtil::get('ContainerFormaUsos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );

        $aContainerTamanhos = LgdbUtil::get('ContainerTamanhos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'tamanho'])
            ->select( ['id', 'tamanho'] );

        return [
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'DriveEspacos.DriveEspacoContainers',
                    'field'     => 'container_id',
                    'operacao'  => 'contem',
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
                'name'  => 'drive_espaco',
                'divClass' => 'col-lg-3',
                'label' => 'Drive Espaço',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'drive_espaco_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'DriveEspacos', 'action' => 'filterQuerySelectpickerDriveEspacos'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aDriveEspacos,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'armador',
                'divClass' => 'col-lg-3',
                'label' => 'Armador',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'armador_id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'armador_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Empresas', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aEmpresasArmador,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-3',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'cliente_id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'cliente_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Empresas', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aEmpresasCliente,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'beneficiario',
                'divClass' => 'col-lg-3',
                'label' => 'Beneficiário',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'beneficiario_id',
                    'operacao'  => 'contem',
                    'type'      => 'select-ajax',
                    'arrayParamns' => [
                        'class'        => 'not-fix-width',
                        'label'        => false,
                        'null'         => true,
                        'search'       => true,
                        'name'         => 'beneficiario_id_find',
                        'options'      =>  [],
                        'url'          => ['controller' => 'Empresas', 'action' => 'filterQuerySelectpicker'],
                        'data'         => [
                            'busca' => '{{{q}}}',
                            'value' => 'descricao', 
                            'key'   => 'id'
                        ],
                        'options_ajax' => $aEmpresasBeneficiario,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'operacao',
                'divClass' => 'col-lg-2',
                'label' => 'Operação',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'operacao_id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aOperacoes
                ]
            ],
            [
                'name'  => 'tipo',
                'divClass' => 'col-lg-2',
                'label' => 'Tipo',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'drive_espaco_tipo_id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aDriveEspacoTipos
                ]
            ],
            [
                'name'  => 'tipo_iso',
                'divClass' => 'col-lg-2',
                'label' => 'Tipo Iso',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'tipo_iso_id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aTipoIsos
                ]
            ],
            [
                'name'  => 'forma_uso',
                'divClass' => 'col-lg-3',
                'label' => 'Forma Uso Container',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'container_forma_uso_id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aContainerFormaUsos
                ]
            ],
            [
                'name'  => 'container_tamanho',
                'divClass' => 'col-lg-2',
                'label' => 'Tamanho Container',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'conteiner_tamanho_id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aContainerTamanhos
                ]
            ],
            [
                'name'  => 'super_testado',
                'divClass' => 'col-lg-2',
                'label' => 'Super Testato?',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'super_testato',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => [0 => 'Não', 1 => 'Sim']
                ]
            ],
            [
                'name'  => 'data_hora_inicio',
                'divClass' => 'col-lg-4',
                'label' => 'Data',
                'table' => [
                    'className' => 'DriveEspacos',
                    'field'     => 'data_hora_ddl',
                    'operacao'  => 'entre',
                    'type'      => 'date'
                ]
            ],
        ];
    }

    public static function verifyExistsDriveEspaco($oDriveEspaco)
    {
        $oResponse = new ResponseUtil();

        $aWhere = [
            'DriveEspacos.descricao'  => $oDriveEspaco->descricao,
            'DriveEspacos.cliente_id' => $oDriveEspaco->cliente_id
        ];

        if (!$oDriveEspaco->isNew())
            $aWhere += ['DriveEspacos.id !=' => $oDriveEspaco->id];

        if ($oDriveEspaco->armador_id)
            $aWhere += ['DriveEspacos.armador_id' => $oDriveEspaco->armador_id];

        if ($oDriveEspaco->container_tamanho_id)
            $aWhere += ['DriveEspacos.container_tamanho_id' => $oDriveEspaco->container_tamanho_id];
        
        $oDriveEspacoExists = LgDbUtil::getFind('DriveEspacos')
            ->where($aWhere)
            ->first();

        if (!$oDriveEspacoExists)
            return $oResponse->setStatus(200);

        return $oResponse
            ->setStatus(400)
            ->setTitle('Ops!')
            ->setMessage('Impossível prosseguir. Já existe um Drive de Espaço com essas caracteristicas!');
    }

    public static function getContainersVinculados($iDriveEspacoID)
    {
        $aConditions = [
            'container_id IS NOT'    => null,
            'resv_saida_id IS'       => null,
            'resv_entrada_id IS NOT' => null,
            'drive_espaco_atual_id'  => $iDriveEspacoID
        ];
        
        $oEntradaSaidaContainers = LgDbUtil::getFind('EntradaSaidaContainers')
            ->contain(['Containers'])
            ->select('Containers.numero')
            ->where($aConditions)
            ->toArray();

        return $oEntradaSaidaContainers;
    }

}
