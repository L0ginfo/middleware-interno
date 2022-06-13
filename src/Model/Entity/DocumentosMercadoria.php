<?php
namespace App\Model\Entity;

use App\Controller\ResvsController;
use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use App\Util\UniversalCodigoUtil;
use Cake\Datasource\ConnectionManager;
use App\Util\ResponseUtil;
use App\Util\DoubleUtil;
use App\Util\ErrorUtil;
use App\Util\EntityUtil;
use App\RegraNegocio\GerenciamentoEstoque\ProdutosControlados;

/**
 * DocumentosMercadoria Entity
 *
 * @property int $id
 * @property string|null $numero_documento
 * @property \Cake\I18n\Date|null $data_emissao
 * @property string|null $lote_codigo
 * @property float|null $valor_cif_moeda
 * @property float|null $valor_cif_real
 * @property float|null $peso_liquido
 * @property float|null $peso_bruto
 * @property \Cake\I18n\Date|null $data_vencimento_regime
 * @property float|null $valor_frete_moeda
 * @property float|null $valor_seguro_moeda
 * @property float|null $m3
 * @property string|null $numero_voo
 * @property int|null $volume
 * @property int|null $modal_id
 * @property int|null $cliente_id
 * @property int|null $despachante_id
 * @property int|null $agente_id
 * @property int|null $parceiro_id
 * @property int|null $regimes_aduaneiro_id
 * @property int|null $moeda_id
 * @property int|null $documento_mercadoria_id_master
 * @property int|null $documento_transporte_id
 * @property int|null $pais_origem_id
 * @property int|null $moeda_frete_id
 * @property int|null $moeda_seguro_id
 * @property int|null $natureza_carga_id
 * @property int|null $tratamento_carga_id
 * @property int|null $tipo_documento_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\Moeda $moeda
 * @property \App\Model\Entity\DocumentosTransporte $documentos_transporte
 * @property \App\Model\Entity\Pal $pal
 * @property \App\Model\Entity\NaturezasCarga $naturezas_carga
 * @property \App\Model\Entity\TratamentosCarga $tratamentos_carga
 * @property \App\Model\Entity\TiposDocumento $tipos_documento
 */
class DocumentosMercadoria extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     * 
     * default array:
     * 'numero_documento' => true,
     *  'data_emissao' => true,
     *  'lote_codigo' => true,
     *  'valor_cif_moeda' => true,
     *  'valor_cif_real' => true,
     *  'peso_liquido' => true,
     *  'peso_bruto' => true,
     *  'data_vencimento_regime' => true,
     *  'valor_frete_moeda' => true,
     *  'valor_seguro_moeda' => true,
     *  'm3' => true,
     *  'numero_voo' => true,
     *  'volume' => true,
     *  'modal_id' => true,
     *  'cliente_id' => true,
     *  'despachante_id' => true,
     *  'agente_id' => true,
     *  'parceiro_id' => true,
     *  'regimes_aduaneiro_id' => true,
     *  'moeda_id' => true,
     *  'documento_mercadoria_id_master' => true,
     *  'documento_transporte_id' => true,
     *  'pais_origem_id' => true,
     *  'moeda_frete_id' => true,
     *  'moeda_seguro_id' => true,
     *  'natureza_carga_id' => true,
     *  'tratamento_carga_id' => true,
     *  'tipo_documento_id' => true,
     *  'tipo_mercadoria_id' => true,
     *  'cliente_mantra' => true,
     *  'tipo_mercadoria' => true,
     *  'digito_receita' => true,
     *  'procedencia_origem_id' => true,
     *  'procedencia_origem' => true,
     *  'procedencia_destino_id' => true,
     *  'procedencia_destino' => true,
     *  'empresa_id' => true,
     *  'serie_nf' => true,
     *  'modal' => true,
     *  'empresa' => true,
     *  'regimes_aduaneiro' => true,
     *  'moeda' => true,
     *  'documentos_transporte' => true,
     *  'pais' => true,
     *  'naturezas_carga' => true,
     *  'tratamentos_carga' => true,
     *  'tipos_documento' => true,
     *  'documentos_mercadorias_item' => true,
     * 
     * numero_processo_importacao
     */
    
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function beautifyListingMercadorias( $oRelations )
    {
        $sReturn = array();

        if ( !$oRelations )
            return '';
            
        $oRelations = json_decode($oRelations);
        $iHaveHouse = 0;
        $iHaveMaster = 0;

        $sReturn[] = '<ul class="list-relations no-dots-list">';

        foreach ($oRelations as $keyMaster => $Relation) {

            if (is_array($Relation)){
                $iHaveHouse++;
                // $sReturn[] = '<li><span class="master"><b>#' . $keyMaster . '</b></span>';
                $sReturn[] = '<li><b>#' . $keyMaster . '</b>';

                $sReturn[] = '<ul>';

                foreach ($Relation as $keyHouse => $sHouse) {
                    // $sReturn[] = '<li><span class="house">#'.$sHouse.'</span></li>';
                    $sReturn[] = '<div>#'.$sHouse.'</div>';
                }

                $sReturn[] = '</ul>';
                $sReturn[] = '</li>';

            }else {
                $iHaveMaster++;

                if ($iHaveMaster === 1) 
                    $sReturn[] = '<li>';
                
                // $sReturn[] = ' <span class="master"><b>#'.$Relation.'</b></span>';
                $sReturn[] = ' <div><b>#'.$Relation.'</b></div>';
            }
        }

        if ($iHaveMaster) {
            $sReturn[] = '</li>';
        }

        $sReturn[] = '</ul>';

        return implode($sReturn);
    }

    public function generateLoteCodigo( $that, $iDocTransID, $bGerarSeTerResv = false, $bEvitaSobrescreverLote = true )
    {

        if ($bGerarSeTerResv) {
            $oResvsTransporte =  LgDbUtil::get('ResvsDocumentosTransportes')->find()
                ->where([
                    'documento_transporte_id' => $iDocTransID
                ])
                ->first();

            if (!$oResvsTransporte)
                return false;
        }

        $oDocumentosMercadorias = LgDbUtil::get('DocumentosMercadorias')->find()
            ->where([
                'documento_transporte_id' => $iDocTransID
            ])
            ->toArray();

        foreach ($oDocumentosMercadorias as $keyMerc => $oDocumentoMercadoria) {

            //Se for o master, salva um lote zerado para nao gerar um lote em cima dele
            if (!$oDocumentoMercadoria->documento_mercadoria_id_master && !$oDocumentoMercadoria->lote_codigo) {
                $oDocumentoMercadoria->lote_codigo = str_pad('', 15, '0', STR_PAD_LEFT);
                LgDbUtil::get('DocumentosMercadorias')->save($oDocumentoMercadoria);
                continue;
            }

            if ($bEvitaSobrescreverLote) {
                if ($oDocumentoMercadoria->lote_codigo == ''){
                    $oDocumentoMercadoria->lote_codigo = UniversalCodigoUtil::codigoLoteMercadoria( $that );
                    $oDocumentoMercadoria->digito_receita = UniversalCodigoUtil::codigoDigitoLoteReceita( $oDocumentoMercadoria->lote_codigo );
                    LgDbUtil::get('DocumentosMercadorias')->save($oDocumentoMercadoria);
                }
            }else {
                $oDocumentoMercadoria->lote_codigo = UniversalCodigoUtil::codigoLoteMercadoria( $that );
                $oDocumentoMercadoria->digito_receita = UniversalCodigoUtil::codigoDigitoLoteReceita( $oDocumentoMercadoria->lote_codigo );
                LgDbUtil::get('DocumentosMercadorias')->save($oDocumentoMercadoria);
            }
        }
    }

    public static function getDocumentos($empresa_id, $data_inicio, $data_fim)
    {
        $sSql = 
        'SELECT 
            DocumentosMercadorias.peso_bruto AS peso_mercadoria,
            DocumentosMercadorias.volume AS volume_mercadoria,
            OrdemServicosDescarga.data_hora_fim AS data_emissao,
            DocumentosMercadorias.numero_documento AS HAWB,
            DocumentosMercadoriasMaster.numero_documento AS AWB,
            Cliente.descricao AS cliente,
            DocumentosTransportes.numero AS TERMO,
            DocumentosTransportes.numero_voo AS VOO,
            Natureza.codigo AS natureza,
            DocumentosMercadoriasItens.id AS item, 
            Estoques.peso_saldo AS peso_saldo,
            Estoques.qtde_saldo AS qtde_saldo,
            Areas.descricao AS area_descicao,
            Locais.descricao AS local_descricao,
            EtiquetaProdutos.lote_codigo AS lote_codigo,
            EtiquetaProdutos.lote_item AS lote_item,
            UnidadeMedida.descricao AS unidade_medida,
            EtiquetaProdutos.codigo_barras AS barras,
            Enderecos.cod_composicao1 AS cod1,
            Enderecos.cod_composicao2 AS cod2,
            Enderecos.cod_composicao3 AS cod3,
            Enderecos.cod_composicao4 AS cod4,
            LiberacoesDocumentais.numero_documento_liberacao AS liberacao,
            EtiquataCarregamento.quantidade_carregada AS quantidade_carregada,
            EtiquataCarregamento.peso_carregada AS peso_carregado,
            
            (SELECT 1 FROM ordem_servicos AS ordem 
                INNER JOIN resvs_liberacoes_documentais AS resv ON resv.resv_id = ordem.resv_id
                WHERE resv.liberacao_documental_id = LiberacoesDocumentais.id ) AS ORDEM
            FROM etiqueta_produtos AS EtiquetaProdutos
            LEFT JOIN  documentos_mercadorias_itens  AS DocumentosMercadoriasItens ON 
            DocumentosMercadoriasItens.id = EtiquetaProdutos.documento_mercadoria_item_id
            LEFT JOIN  documentos_mercadorias  AS DocumentosMercadorias ON 
            DocumentosMercadorias.id = DocumentosMercadoriasItens.documentos_mercadoria_id
            LEFT JOIN  documentos_mercadorias  AS DocumentosMercadoriasMaster ON 
            DocumentosMercadoriasMaster.id = DocumentosMercadorias.documento_mercadoria_id_master
            LEFT JOIN  resvs_documentos_transportes  AS ResvsDocumentosTransportes ON 
            ResvsDocumentosTransportes.documento_transporte_id = DocumentosMercadorias.documento_transporte_id
            LEFT JOIN  ordem_servicos  AS OrdemServicosDescarga ON 
            OrdemServicosDescarga.resv_id = ResvsDocumentosTransportes.resv_id   
            LEFT JOIN empresas AS Cliente ON 
            Cliente.id = DocumentosMercadorias.cliente_id
            LEFT JOIN naturezas_cargas AS Natureza ON 
            Natureza.id = DocumentosMercadorias.natureza_carga_id
            LEFT JOIN documentos_transportes as DocumentosTransportes ON 
            DocumentosMercadorias.documento_transporte_id = DocumentosTransportes.id
            LEFT JOIN  estoques  AS Estoques ON 
            EtiquetaProdutos.lote_codigo = Estoques.lote_codigo AND
            EtiquetaProdutos.lote_item = Estoques.lote_item AND
            EtiquetaProdutos.unidade_medida_id = Estoques.unidade_medida_id AND
                EtiquetaProdutos.empresa_id = Estoques.empresa_id
            LEFT JOIN unidade_medidas as UnidadeMedida ON 
            UnidadeMedida.id = EtiquetaProdutos.unidade_medida_id
            LEFT JOIN enderecos as Enderecos ON 
            Enderecos.id = EtiquetaProdutos.endereco_id
            LEFT JOIN areas as Areas ON 
            Areas.id = Enderecos.area_id
            LEFT JOIN locais as Locais ON 
            Locais.id = Areas.local_id
            LEFT JOIN ordem_servico_etiqueta_carregamentos AS EtiquataCarregamento ON 
            EtiquataCarregamento.etiqueta_produto_id = EtiquetaProdutos.id
            LEFT JOIN ordem_servicos AS OrdemServicos ON 
            OrdemServicos.id = EtiquataCarregamento.ordem_servico_id
            LEFT JOIN resvs_liberacoes_documentais AS ResvsLiberacoesDocumentais  ON
                OrdemServicos.resv_id = ResvsLiberacoesDocumentais.resv_id
            LEFT JOIN liberacoes_documentais AS LiberacoesDocumentais ON 
            LiberacoesDocumentais.id = ResvsLiberacoesDocumentais.liberacao_documental_id
            WHERE DocumentosMercadorias.empresa_id = "'.$empresa_id.'"
            AND OrdemServicosDescarga.data_hora_fim >= "'.$data_inicio->format('Y-m-d').'"
            AND OrdemServicosDescarga.data_hora_fim <= "'.$data_fim->format('Y-m-d').'"
            AND OrdemServicosDescarga.data_hora_fim IS NOT NULL
            ORDER BY ORDEM, AWB, HAWB, TERMO, cod1, cod2, cod3, cod4';
    
        $connection = ConnectionManager::get('default');
        $aDocumentos = $connection->execute( $sSql )->fetchAll('assoc');
        return $aDocumentos;
    }


    public static function getListOfEtiquetasEstoque($numero_documento, $empresa_id){
        $sSql ='SELECT
            DocumentosMercadoriasItens.descricao AS item,
            EtiquetaProdutos.produto_id AS produto, 
            EtiquetaProdutos.lote_codigo AS lote_codigo,
            EtiquetaProdutos.lote_item AS lote_item,
            UnidadeMedidas.descricao AS unidade_medida,
            (EtiquetaProdutos.qtde - COALESCE(OrdemServicoEtiquetaCarregamentos.quantidade_carregada, 0)) AS qtde_saldo,
            (EtiquetaProdutos.peso - COALESCE(OrdemServicoEtiquetaCarregamentos.peso_carregada, 0)) AS peso_saldo,
            EtiquetaProdutos.codigo_barras AS codigo_barras,
            Enderecos.cod_composicao1 AS cod1,
            Enderecos.cod_composicao2 AS cod2,
            Enderecos.cod_composicao3 AS cod3,
            Enderecos.cod_composicao4 AS cod4
        FROM etiqueta_produtos AS EtiquetaProdutos 
        LEFT JOIN ordem_servico_etiqueta_carregamentos AS OrdemServicoEtiquetaCarregamentos ON
            OrdemServicoEtiquetaCarregamentos.etiqueta_produto_id = EtiquetaProdutos.id
        LEFT JOIN enderecos AS Enderecos ON
            Enderecos.id = EtiquetaProdutos.endereco_id
        LEFT JOIN unidade_medidas AS UnidadeMedidas ON
            UnidadeMedidas.id = EtiquetaProdutos.unidade_medida_id
        INNER JOIN documentos_mercadorias_itens AS DocumentosMercadoriasItens ON 
            DocumentosMercadoriasItens.id = EtiquetaProdutos.documento_mercadoria_item_id
        INNER JOIN documentos_mercadorias AS DocumentosMercadorias ON 
            DocumentosMercadorias.id = DocumentosMercadoriasItens.documentos_mercadoria_id
        WHERE 
            DocumentosMercadorias.empresa_id = "'.$empresa_id.'" AND 
            DocumentosMercadorias.numero_documento = "'.$numero_documento.'"';

        $connection = ConnectionManager::get('default');
        $aDocumentos = $connection->execute( $sSql )->fetchAll('assoc');
        return $aDocumentos;
    }
    
    public static function getListOfMOV($numero_documento, $empresa_id){
        $sSql =
        'SELECT DISTINCT 
            MovimentacoesEstoques.id AS id,
            EtiquetaProdutos.produto_id AS produto_codigo,
            EtiquetaProdutos.lote_codigo AS lote_codigo,
            EtiquetaProdutos.lote_item AS lote_item,
            UnidadeMedidas.descricao AS  unidade_medida,
            TipoMovimentacoes.descricao AS tipo_movimentacao,
            EnderecosOrigem.cod_composicao1 AS origem_cod1,
            EnderecosOrigem.cod_composicao2 AS origem_cod2,
            EnderecosOrigem.cod_composicao3 AS origem_cod3,
            EnderecosOrigem.cod_composicao4 AS origem_cod4,
            EnderecosDestino.cod_composicao1 AS destino_cod1,
            EnderecosDestino.cod_composicao2 AS destino_cod2,
            EnderecosDestino.cod_composicao3 AS destino_cod3,
            EnderecosDestino.cod_composicao4 AS destino_cod4
        FROM etiqueta_produtos AS EtiquetaProdutos 
        INNER JOIN estoques AS Estoques ON 
            EtiquetaProdutos.lote_codigo = Estoques.lote_codigo AND
            EtiquetaProdutos.lote_item = Estoques.lote_item AND
            EtiquetaProdutos.produto_id = Estoques.produto_id AND
            EtiquetaProdutos.lote = Estoques.lote AND
            EtiquetaProdutos.serie = Estoques.serie AND
            EtiquetaProdutos.validade = Estoques.validade AND
            EtiquetaProdutos.unidade_medida_id = Estoques.unidade_medida_id AND
            EtiquetaProdutos.empresa_id = Estoques.empresa_id
        INNER JOIN movimentacoes_estoques AS MovimentacoesEstoques ON 
            (
                MovimentacoesEstoques.lote_codigo = EtiquetaProdutos.lote_codigo AND
                MovimentacoesEstoques.lote_item = EtiquetaProdutos.lote_item AND
                MovimentacoesEstoques.lote = EtiquetaProdutos.lote AND
                MovimentacoesEstoques.serie = EtiquetaProdutos.serie AND
                MovimentacoesEstoques.validade = EtiquetaProdutos.validade AND
                MovimentacoesEstoques.produto_id = EtiquetaProdutos.produto_id AND
                (
                    MovimentacoesEstoques.unidade_medida_anterior_id = EtiquetaProdutos.unidade_medida_id OR
                    MovimentacoesEstoques.unidade_medida_nova_id = EtiquetaProdutos.unidade_medida_id 
                )
            )
        INNER JOIN documentos_mercadorias_itens AS DocumentosMercadoriasItens ON 
            DocumentosMercadoriasItens.id = EtiquetaProdutos.documento_mercadoria_item_id
        INNER JOIN documentos_mercadorias AS DocumentosMercadorias ON 
            DocumentosMercadorias.id = DocumentosMercadoriasItens.documentos_mercadoria_id
        LEFT JOIN enderecos AS EnderecosOrigem ON 
            MovimentacoesEstoques.endereco_origem_id = EnderecosOrigem.id
        LEFT JOIN enderecos AS EnderecosDestino ON 
            MovimentacoesEstoques.endereco_destino_id = EnderecosDestino.id
            
        LEFT JOIN tipo_movimentacoes AS TipoMovimentacoes ON 
            TipoMovimentacoes.id = MovimentacoesEstoques.tipo_movimentacao_id
        LEFT JOIN unidade_medidas AS UnidadeMedidas ON 
            UnidadeMedidas.id = EtiquetaProdutos.unidade_medida_id
        WHERE 
            DocumentosMercadorias.empresa_id = "'.$empresa_id.'" AND 
            DocumentosMercadorias.numero_documento = "'.$numero_documento.'"';
        $connection = ConnectionManager::get('default');
        $aDocumentos = $connection->execute( $sSql )->fetchAll('assoc');
        return $aDocumentos;
    } 

    public static function getClienteDescricao($sLoteCodigo)
    {
        $oDocumentoMercadoria = LgDbUtil::getFind('DocumentosMercadorias')
            ->contain([
                'Clientes',
                'DocumentosTransportes'
            ])
            ->where([
                'lote_codigo' => $sLoteCodigo
            ])
            ->first();

        return @$oDocumentoMercadoria->cliente->cnpj . ' - ' . @$oDocumentoMercadoria->cliente->descricao . '~' . @$oDocumentoMercadoria->documentos_transporte->navio_aeronave;
    }

    public static function getNumeroDocumento($sLoteCodigo)
    {
        if (!$sLoteCodigo)
            return '';
            
        $oDocumentoMercadoria = LgDbUtil::getFind('DocumentosMercadorias')
            ->where([
                'lote_codigo' => $sLoteCodigo
            ])
            ->first();

        return @$oDocumentoMercadoria->numero_documento;
    }

    public static function getValorTotal($iDocumentoTransporteID)
    {
        $oDocumentoTransporte = LgDbUtil::getFind('DocumentosTransportes')
            ->contain([
                'DocumentosMercadoriasMany' => [
                    'DocumentosMercadoriasItens'
                ]
            ])
            ->where(['DocumentosTransportes.id' => $iDocumentoTransporteID])
            ->first();

        $iValorTotal = 0;
        foreach ($oDocumentoTransporte->documentos_mercadorias as $oDocMercadoria) {
            if ($oDocMercadoria->documento_mercadoria_id_master != null) {
                foreach ($oDocMercadoria->documentos_mercadorias_itens as $oDocMercadoriaItem) {
                    $iValorTotal += $oDocMercadoriaItem->valor_total;
                }
            }
        }

        return number_format(str_replace(',', '.', $iValorTotal), 2, ',', '.');
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

        $aClientesWhere = [];
        if ($aDataQuery['cliente']['values'][0])
            $aClientesWhere += ['Empresas.id' => $aDataQuery['cliente']['values'][0]];
        $aClientes = LgdbUtil::get('Empresas')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->where($aClientesWhere)
            ->limit(1);

        $aRegimesAduaneiros = LgdbUtil::get('RegimesAduaneiros')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] );
        
        return [
            [
                'name'  => 'lote',
                'divClass' => 'col-lg-3',
                'label' => 'Protocolo/Lote',
                'table' => [
                    'className' => 'DocumentosMercadorias',
                    'field'     => 'lote_codigo',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'conhecimento',
                'divClass' => 'col-lg-3',
                'label' => 'Conhecimento/Nota Fiscal',
                'table' => [
                    'className' => 'DocumentosMercadorias',
                    'field'     => 'numero_documento',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'cliente',
                'divClass' => 'col-lg-3',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'Clientes',
                    'field'     => 'id',
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
                        'options_ajax' => $aClientes,
                        'value'        => null,
                        'selected'     => null,
                    ]
                ]
            ],
            [
                'name'  => 'container',
                'divClass' => 'col-lg-3',
                'label' => 'Container',
                'table' => [
                    'className' => 'Containers',
                    'field'     => 'id',
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
                'name'  => 'regime',
                'divClass' => 'col-lg-3',
                'label' => 'Regime Aduaneiro',
                'table' => [
                    'className' => 'RegimesAduaneiros',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aRegimesAduaneiros
                ]
            ],
            [
                'name'  => 'data_hora_entrada',
                'divClass' => 'col-lg-4',
                'label' => 'Data Entrada',
                'table' => [
                    'className' => 'Resvs',
                    'field'     => 'data_hora_entrada',
                    'operacao'  => 'entre',
                    'type'      => 'date'
                ]
            ],
        ];
    }


    public static function buscaCargas($iDocumentoMercadoriaID)
    {
        $aContainers = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->select([
                'container_numero'  => 'Containers.numero',
                'container_tamanho' => 'ContainerTamanhos.tamanho',
                'container_iso'     => 'TipoIsos.descricao',
                'volumes'           => 'DocumentosMercadoriasItens.quantidade',
                'especie'           => 'UnidadeMedidas.descricao',
                'produto'           => 'Produtos.descricao',
                'peso_bruto'        => 'DocumentosMercadorias.peso_bruto',
                'tipo_documento'    => 'TipoDocumentos.descricao',
                'documento_entrada' => 'DocumentosMercadorias.numero_documento',
                'status_mapa'       => 'DocumentosMercadorias.numero_documento', // de onde vem?
            ])
            ->leftJoinWith('DocumentosMercadorias', function ($q) {
                return $q->leftJoinWith('TipoDocumentos');
            })
            ->leftJoinWith('Produtos')
            ->leftJoinWith('UnidadeMedidas')
            ->leftJoinWith('ItemContainers', function ($q) {
                return $q->leftJoinWith('Containers', function ($q) {
                    return $q->leftJoinWith('TipoIsos', function ($q) {
                        return $q->leftJoinWith('ContainerTamanhos');
                    });
                });
            })
            ->where(['DocumentosMercadorias.id' => $iDocumentoMercadoriaID])
            ->toArray();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'containers' => $aContainers
            ]);
    }

    public static function buscaLiberacoesDocumental($iDocumentoMercadoriaID)
    {
        $aLiberacoes = LgDbUtil::getFind('LiberacoesDocumentais')
            ->select([
                'lote_codigo'      => 'DocumentosMercadoriasLote.lote_codigo',
                'regime'           => 'RegimesAduaneiros.descricao',
                'numero_liberacao' => 'LiberacoesDocumentais.numero',
                'data_registro'    => 'LiberacoesDocumentais.data_registro',
                'data_desembaraco' => 'LiberacoesDocumentais.data_desembaraco',
                'tipo_documento'   => 'TipoDocumentos.descricao',
                'canal'            => 'Canais.descricao',
            ])
            ->leftJoinWith('TipoDocumentos')
            ->leftJoinWith('Canais')
            ->leftJoinWith('RegimesAduaneiros')
            ->leftJoinWith('LiberacoesDocumentaisItens', function ($q) {
                return $q->leftJoinWith('DocumentosMercadoriasLote');
            })
            ->where([
                'DocumentosMercadoriasLote.id' => $iDocumentoMercadoriaID
            ])
            ->toArray();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'liberacoes' => $aLiberacoes
            ]);
    }

    public static function buscaServicos($iDocumentoMercadoriaID)
    {
        $aServicos = LgDbUtil::getFind('OrdemServicos')
            ->select([
                'ordem_servico'    => 'OrdemServicos.id',
                'data_solicitacao' => 'OrdemServicos.created',
                'solicitante'      => 'InitiatedBy.nome',
                'data_agendamento' => 'Programacoes.data_hora_programada',
                'servico'          => 'OrdemServicoTipos.descricao',
                'data_entrada'     => 'Resvs.data_hora_entrada',
                'data_inicio'      => 'OrdemServicos.data_hora_inicio',
                'data_termino'     => 'OrdemServicos.data_hora_fim',
            ])
            ->select([
                'container' =>
                    "(SELECT GROUP_CONCAT(cnt.numero)
                    FROM container_entradas entrada, containers cnt
                    WHERE entrada.documento_transporte_id = DocumentosTransportes.id
                    AND cnt.id = entrada.container_id)"
            ])
            ->leftJoinWith('InitiatedBy')
            ->leftJoinWith('OrdemServicoTipos')
            ->leftJoinWith('OrdemServicoItens.DocumentosMercadoriasItens.DocumentosMercadorias.DocumentosTransportes')
            ->leftJoinWith('Resvs', function ($q) {
                return $q->leftJoinWith('Programacoes');
            })
            ->where([
                'DocumentosMercadorias.id' => $iDocumentoMercadoriaID
            ])
            ->group('OrdemServicos.id')
            ->toArray();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'servicos' => $aServicos
            ]);
    }

    public static function buscaTfa($iDocumentoMercadoriaID)
    {
        $aVistorias = LgDbUtil::getFind('Vistorias')
            ->select([
                'vistoria_id'         => 'Vistorias.id',
                'data_hora_vistoria'  => 'Vistorias.data_hora_vistoria',
                'data_hora_fim'       => 'Vistorias.data_hora_fim',
                'programacao_id'      => 'Programacoes.id',
                'vistoria_tipo_carga' => 'VistoriaTipoCargas.descricao',
                'vistoria_item_id'    => 'VistoriaItens.id',
                'ordem_servico_id',
            ])
            ->leftJoinWith('VistoriaItens')
            ->leftJoinWith('VistoriaTipoCargas')
            ->leftJoinWith('Programacoes', function ($q) {
                return $q->leftJoinWith('ProgramacaoDocumentoTransportes', function ($q) {
                    return $q->leftJoinWith('DocumentosTransportes', function ($q) {
                        return $q->leftJoinWith('DocumentosMercadoriasMany', function ($q) {
                            return $q->where(['DocumentosMercadoriasMany.documento_mercadoria_id_master IS NOT' => null]);
                        });
                    });
                });
            })
            ->where([
                'DocumentosMercadoriasMany.id' => $iDocumentoMercadoriaID
            ])
            ->toArray();

        if (!$aVistorias) {
            $aVistorias = LgDbUtil::getFind('Vistorias')
                ->select([
                    'vistoria_id'         => 'Vistorias.id',
                    'data_hora_vistoria'  => 'Vistorias.data_hora_vistoria',
                    'data_hora_fim'       => 'Vistorias.data_hora_fim',
                    'ordem_servico_id'    => 'OrdemServicos.id',
                    'vistoria_tipo_carga' => 'VistoriaTipoCargas.descricao',
                    'vistoria_item_id'    => 'VistoriaItens.id',
                    'programacao_id',
                ])
                ->leftJoinWith('VistoriaItens')
                ->leftJoinWith('VistoriaTipoCargas')
                ->leftJoinWith('OrdemServicos', function ($q) {
                    return $q->leftJoinWith('OrdemServicoItens', function ($q) {
                        return $q->leftJoinWith('Containers')->leftJoinWith('DocumentosMercadoriasItens', function ($q) {
                            return $q->leftJoinWith('DocumentosMercadorias');
                        });
                    });
                })
                ->where([
                    'DocumentosMercadorias.id' => $iDocumentoMercadoriaID
                ])
                ->toArray();
        }

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'vistorias' => $aVistorias
            ]);
    }

    public static function buscaPesagens($iDocumentoMercadoriaID)
    {
        $aPesagemRegistros = LgDbUtil::getFind('PesagemVeiculoRegistros')
            ->contain(['Pesagens' => ['Resvs' => ['OrdemServicos' => ['OrdemServicoItens']]]])
            ->leftJoinWith('Pesagens', function ($q) {
                return $q->leftJoinWith('Resvs', function ($q) {
                    return $q->leftJoinWith('OrdemServicos', function ($q) {
                        return $q->leftJoinWith('OrdemServicoItens', function ($q) {
                            return $q->leftJoinWith('DocumentosMercadoriasItens', function ($q) {
                                return $q->leftJoinWith('DocumentosMercadorias');
                            });
                        });
                    });
                });
            })
            ->where([
                'DocumentosMercadorias.id' => $iDocumentoMercadoriaID
            ])
            ->order(['Resvs.id' => 'DESC'])
            ->toArray();

        if ($aPesagemRegistros)
            $aPesagemRegistros = self::getArrayPesagensFormated($aPesagemRegistros);

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'pesagens' => $aPesagemRegistros
            ]);
    }

    private static function getArrayPesagensFormated($aPesagemRegistros)
    {
        $aPesagensFormated = [];
        $iCount            = -1;
        $iResvID           = null;
        foreach ($aPesagemRegistros as $oPesagemVeiculo) {

            if ($iResvID != $oPesagemVeiculo->pesagem->resv->id) {

                $iCount++;
                $aPesagensFormated[$iCount]['peso_armazenagem'] = 0;

                foreach ($oPesagemVeiculo->pesagem->resv->ordem_servicos as $oOrdemServico)
                    foreach ($oOrdemServico->ordem_servico_itens as $oOrdemServicoItens)
                        $aPesagensFormated[$iCount]['peso_armazenagem'] += $oOrdemServicoItens->peso;

            }

            if ($oPesagemVeiculo->pesagem_tipo_id == EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Entrada'))
                $aPesagensFormated[$iCount]['peso_entrada'] = $oPesagemVeiculo->peso;

            if ($oPesagemVeiculo->pesagem_tipo_id == EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Saida'))
                $aPesagensFormated[$iCount]['peso_saida'] = $oPesagemVeiculo->peso;

            $aPesagensFormated[$iCount]['resv_id'] = $oPesagemVeiculo->pesagem->resv->id;

            $iResvID = $oPesagemVeiculo->pesagem->resv->id;

        }

        return $aPesagensFormated;
    }

    public static function buscaAgendamentos($iDocumentoMercadoriaID)
    {
        $aProgramacoes = LgDbUtil::getFind('Programacoes')
            ->select([
                'numero_agendamento'   => 'Programacoes.id',
                'data_hora_programada' => 'Programacoes.data_hora_programada',
                'grade_horario'        => 'GradeHorarios.descricao',
                'data_hora_chegada'    => 'Programacoes.data_hora_chegada',
                'resv_id'              => 'Resvs.id',
                'data_hora_entrada'    => 'Resvs.data_hora_entrada',
                'doc'    => 'DocumentosMercadoriasMany.id',
            ])
            ->leftJoinWith('Resvs')
            ->leftJoinWith('ProgramacaoDocumentoTransportes', function ($q) {
                return $q->leftJoinWith('DocumentosTransportes', function ($q) {
                    return $q->leftJoinWith('DocumentosMercadoriasMany', function ($q) {
                        return $q->where(['DocumentosMercadoriasMany.documento_mercadoria_id_master IS NOT' => null]);
                    });
                });
            })
            ->leftJoinWith('GradeHorarios')
            ->where([
                'DocumentosMercadoriasMany.id' => $iDocumentoMercadoriaID
            ])
            ->toArray();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'agendamentos' => $aProgramacoes
            ]);
    }

    public static function buscaApreencoes($iDocumentoMercadoriaID)
    {
        $aApreensoesItens = LgDbUtil::getFind('ApreensaoItens')
            ->select([
                'numero'         => 'Apreensoes.numero_doc_apreensao',
                'tipo_documento' => 'TipoDocumentos.descricao',
                'data_apreesao'  => 'Apreensoes.data_apreensao',
                'item'           => 'ApreensaoItens.descricao',
                'quantidade'     => 'ApreensaoItens.quantidade',
            ])
            ->leftJoinWith('Apreensoes', function ($q) {
                return $q->leftJoinWith('DocumentosMercadorias')
                    ->leftJoinWith('TipoDocumentos');
            })
            ->where([
                'DocumentosMercadorias.id' => $iDocumentoMercadoriaID
            ])
            ->toArray();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'apreensoes' => $aApreensoesItens
            ]);
    }

    public static function getContainerLotes($sData)
    {
        $aData = explode('-', $sData);

        $oContainer = LgDbUtil::getFind('Containers')
            ->contain(['TipoIsos' => ['ContainerTamanhos', 'ContainerModelos']])
            ->where(['Containers.numero' => $aData[0]])
            ->first();

        $oContainerEntrada = LgDbUtil::getFind('DocumentosMercadorias')
            ->select([
                'entrada_saida_container_id' => 'ContainerEntradas.entrada_saida_container_id'
            ])
            ->leftJoinWith('DocumentosTransportes.ContainerEntradas')
            ->where([
                'DocumentosMercadorias.id'       => $aData[1],
                'ContainerEntradas.container_id' => $oContainer->id
            ])->first();

        $aLotes = LgDbUtil::getFind('DocumentosMercadorias')
            ->select([
                'lote'         => 'DocumentosMercadorias.lote_codigo',
                'conhecimento' => 'DocumentosMercadorias.numero_documento',
                'cliente'      => 'Clientes.descricao',
                'produtos'     => LgDbUtil::setConcatGroupByDb('Produtos.descricao'),
                'quantidade'   => 'SUM(DocumentosMercadoriasItens.quantidade)',
                'peso_bruto'   => 'SUM(DocumentosMercadoriasItens.peso_bruto)',
            ])
            ->leftJoinWith('DocumentosTransportes.ContainerEntradas')
            ->leftJoinWith('DocumentosMercadoriasItens.Produtos')
            ->leftJoinWith('DocumentosMercadoriasItens.ItemContainers')
            ->leftJoinWith('Clientes')
            ->where([
                'ItemContainers.container_id' => $oContainer->id,
                'DocumentosMercadorias.documento_mercadoria_id_master IS NOT NULL',
                'ContainerEntradas.entrada_saida_container_id IS' => $oContainerEntrada->entrada_saida_container_id
            ])
            ->toArray();

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'container' => $oContainer,
                'lotes' => $aLotes ?? null
            ]);
    }
}
