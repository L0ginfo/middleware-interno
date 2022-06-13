<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\SistemaCampo;
use App\Model\Entity\LiberacoesDocumental;
use App\Model\Entity\ParametroGeral;
use App\Model\Entity\MoedasCotacao;
use App\Model\Entity\Operadore;
use App\Model\Entity\TiposValore;
use App\Model\Entity\OrdemServicoServexec;
use App\Model\Entity\FaturamentoBaixa;
use App\RegraNegocio\Faturamento\FaturamentoAdicoesManager;
use App\RegraNegocio\Faturamento\FaturamentoBaixasManager;
use App\RegraNegocio\Faturamento\FaturamentoComplementares;
use App\RegraNegocio\Faturamento\FaturamentoComplementaresManager;
use App\RegraNegocio\Faturamento\FaturamentosManager;
use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\ErrorUtil;
use App\Util\LgDbUtil;
use App\Util\UniversalCodigoUtil;
use App\Util\ResponseUtil;
use App\Util\SystemUtil;
use Cake\ORM\TableRegistry;
use Exception;

/**
 * Faturamento Entity
 *
 * @property int $id
 * @property string $numero_faturamento
 * @property \Cake\I18n\Time $data_hora_emissao
 * @property float $valor_armazenagem
 * @property float $valor_servicos
 * @property int $forma_pagamento_id
 * @property int $liberacao_documental_id
 * @property int $tabela_preco_id
 * @property int $regime_aduaneiro_id
 * @property int $cliente_id
 * @property int $tipo_faturamento_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\FormaPagamento $forma_pagamento
 * @property \App\Model\Entity\LiberacoesDocumental $liberacoes_documental
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\TiposFaturamento $tipos_faturamento
 * @property \App\Model\Entity\FaturamentoArmazenagem[] $faturamento_armazenagens
 * @property \App\Model\Entity\FaturamentoBaixa[] $faturamento_baixas
 * @property \App\Model\Entity\FaturamentoServico[] $faturamento_servicos
 */
class Faturamento extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'numero_faturamento' => true,
        'data_hora_emissao' => true,
        'valor_armazenagem' => true,
        'valor_servicos' => true,
        'count_dai_primario' => true,
        'count_dai_secundario' => true,
        'count_dae_primario' => true,
        'count_dae_secundario' => true,
        'count_dape_primario' => true,
        'count_dape_secundario' => true,
        'count_dapesc_primario' => true,
        'count_dapesc_secundario' => true,
        'count_generic_completo' => true,
        'count_generic_primario' => true,
        'count_generic_secundario' => true,
        'count_generic_dv' => true,
        'forma_pagamento_id' => true,
        'tipo_servico_bancario_id' => true,
        'tipo_servico_bancario' => true,
        'liberacao_documental_id' => true,
        'tabela_preco_id' => true,
        'regime_aduaneiro_id' => true,
        'cliente_id' => true,
        'cliente' => true,
        'tipo_faturamento_id' => true,
        'empresa_id' => true,
        'forma_pagamento' => true,
        'liberacoes_documental' => true,
        'tabelas_preco' => true,
        'regimes_aduaneiro' => true,
        'empresa' => true,
        'tipos_faturamento' => true,
        'faturamento_armazenagens' => true,
        'faturamento_baixas' => true,
        'faturamento_servicos' => true,
        'escolhe_auto_tp_fat_complementar' => true,
        'observacao' => true,
        'valor_retencao' => true,
        'retencao' => true
    ];

    public $oLiberacaoDocumental;
    public $oTabelaPreco;
    public $sDataFinalizacaoDescarga;
    public $sDataFinalizacaoDescargaSemAddDia;
    public $that;
    public $_LiberacaoDocumental;
    public $_Beneficiario;
    
    public function __construct( $that )
    {
        parent::__construct();

        $this->that = $that;
        $this->_LiberacaoDocumental = new LiberacoesDocumental;

        if (!is_object($that))
            return;
        
        $aModels = [
            'MoedasCotacoes',
            'Faturamentos',
            'FaturamentoFechamentoItens',
            'FaturamentoBaixas',
            'TabelasPrecos',
            'TabelasPrecosRegimes',
            'RegimeAduaneiroTipoFaturamentos',
            'TabelasPrecosTiposFaturamentos',
            'TabelasPrecosTratamentos',
            'TabelasPrecosPeriodosArms',
            'TabelasPrecosServicos',
            'TabPrecosValidaPerArms',
            'TabelasPrecosServicos',
            'TabPrecosValidaServicos',
            'EmpresaFormaPagamentos',
            'FaturamentoArmazenagens',
            'FaturamentoServicos',
            'TiposFaturamentos',
            'OrdemServicos',
            'Empresas',
            'Faturamentos',
            'Servicos',
            'Operadores',
            'SistemaCampos',
            'EtiquetaProdutos',
            'OrdemServicoItens',
            'OrdemServicoServexecs',
            'DocumentosMercadorias',
            'DocumentosMercadoriasItens',
            'LiberacoesDocumentaisItens',
            'Estoques',
            'LiberacoesDocumentais'
        ];

        foreach ($aModels as $aModel) {
            $that->loadModel($aModel);
        }

    }
    
    public static function getCodigoFaturamentoByID($iFaturamentoID)
    {
        $oFaturamento = LgDbUtil::getFind('Faturamentos')
            ->contain('TiposFaturamentos')
            ->where([
                'Faturamentos.id' => $iFaturamentoID
            ])
            ->first();
        
        if ($oFaturamento){
            $str_tipo_fatu = strtolower($oFaturamento->that['tipos_faturamento']->descricao);
            $cod_pri = 'count_' . $str_tipo_fatu . '_primario';
            $cod_sec = 'count_' . $str_tipo_fatu . '_secundario';
            $cod = $oFaturamento->that[$cod_pri] . '.' . $oFaturamento->that[$cod_sec];

            return $cod;
        }

        return $oFaturamento;        
    }
    
    public static function getTipoFaturamentoByID($iFaturamentoID)
    {
        $oFaturamento = LgDbUtil::getFind('Faturamentos')
            ->contain('TiposFaturamentos')
            ->where([
                'Faturamentos.id' => $iFaturamentoID
            ])
            ->first();
        
        if ($oFaturamento){
            return $oFaturamento->that['tipos_faturamento']->descricao;
        }

        return $oFaturamento;        
    }

    public function gerarFaturamento( $iLiberacaoDocumentalID, $sOrigem, $iFaturamentoAncetessorID = null, $bOnlyReturnTabelaPreco = false, $iFaturamentoID = null)
    {
        $aDataExtra = array();
        SystemUtil::setFusoHorario(true);

        if (!$sOrigem)
            return [
                'message' => __('Faltam parâmetros para iniciar a geração do faturamento!'),
                'status'  => 406
            ];

        $oLiberacaoDocumental = LgDbUtil::getFind('LiberacoesDocumentais')
            ->contain(['RecintoAduaneiros'])
            ->where(['LiberacoesDocumentais.id' => $iLiberacaoDocumentalID])
            ->first();
                
        $sDataFinalizacaoDescarga = $this->getMercadoriaDataFinalizacaoDescarga(
             $iLiberacaoDocumentalID 
        );

        $this->sDataFinalizacaoDescargaSemAddDia = $sDataFinalizacaoDescarga;
        $this->sDataFinalizacaoDescarga = $sDataFinalizacaoDescarga;

        // // $sDataFinalizacaoDescarga = new \DateTime(DateUtil::addTimeDiaUtil( $sDataFinalizacaoDescarga, 'Y-m-d', 1, '-' ));
        // $this->sDataFinalizacaoDescarga = $sDataFinalizacaoDescarga;

        if ($sOrigem == 'demonstrativo') {
            $oExistsFaturamento = $this->checkIfExistsFaturamento( $iLiberacaoDocumentalID );
            
            if ($oExistsFaturamento && !$bOnlyReturnTabelaPreco)
                return [
                    'message' => __('Faturamento já foi gerado para essa Liberação Documental.'),
                    'dataExtra' => $this->getFaturamentoByLiberacao( $iLiberacaoDocumentalID, $iFaturamentoID),
                    'status'  => 202
                ];

        }else if ($sOrigem != 'complementar' || !$iFaturamentoAncetessorID) {
            return [
                'message' => __('Faltam parâmetros para poder gerar esse faturamento!'),
                'status'  => 202
            ];
        }

        $aTratamentosIDs = $this->getMercadoriasTratamentos( $iLiberacaoDocumentalID );

        if (!$aTratamentosIDs) 
            return [
                'message' => __('Não foi possível localizar os tratamentos dos itens liberados!'),
                'status'  => 406
            ];
        
        $this->setLiberacaoDocumental( $oLiberacaoDocumental );

        $oTabelaPreco = $this->getTabelaPreco(
            $oLiberacaoDocumental, $aTratamentosIDs, $sOrigem, $iFaturamentoAncetessorID
        );

        if (!$oTabelaPreco) 
            return [
                'message' => __('Não foi possível localizar a Tabela de Preço!'),
                'status'  => 406
            ];
            
        $sDataDescarga = FaturamentosManager::getDataDescargaPeriocidade($this, $oTabelaPreco);
        $this->sDataFinalizacaoDescarga = $sDataDescarga;
        
        if ($bOnlyReturnTabelaPreco)
            return [
                'status'  => 200,
                'dataExtra' => $oTabelaPreco
            ];  
            
        if(FaturamentoAdicoesManager::hasAdicoes(
            $oLiberacaoDocumental->id, $oTabelaPreco->id, $sOrigem, $iFaturamentoAncetessorID)
        ){
            $oRespose = FaturamentoAdicoesManager::execute(
                $this, $oLiberacaoDocumental, $oTabelaPreco, $iFaturamentoAncetessorID
            );

            if($oRespose->getStatus() == 200){
                return [
                    'message'   => __('Faturamento foi gerado com sucesso!'),
                    'dataExtra' => $this->getFaturamentoByLiberacao( $iLiberacaoDocumentalID ),
                    'status'    => 200
                ];
            }

            return [
                'message'   => $oRespose->getMessage(),
                'status'    => $oRespose->getStatus()
            ];
            
        }
        
        $oPeriodosArm = $this->getPeriodosArm( $oTabelaPreco, $sOrigem, $iFaturamentoAncetessorID );
        
        if (!$oPeriodosArm) 
            return [
                'message' => __('Não foi possível localizar os Períodos de Armazenagem!'),
                'status'  => 406
            ];
        
        $this->oTabelaPreco = $oTabelaPreco;
        
        if ($sOrigem == 'complementar' && $iFaturamentoAncetessorID){
            $aPeriodosGerados = FaturamentoComplementaresManager::gerarPeriodos(
                $this, $oPeriodosArm, $sOrigem, $iFaturamentoAncetessorID);

        }else{
            $aPeriodosGerados = $this->gerarPeriodos( $oPeriodosArm, $sOrigem );
        }

        $aServicosGerados = $this->gerarServicos($oTabelaPreco, $iFaturamentoAncetessorID);
        $aPeriodosGerados = $this->gerarPeriodoSomaServico( $aPeriodosGerados, $aServicosGerados );
        $aPeriodosGerados = $this->removeValorServicoRestricoes($oTabelaPreco, $aPeriodosGerados);

        $aPeriodosGerados = FaturamentosManager::calculaDescontoRegime(
            $aPeriodosGerados, $oLiberacaoDocumental->regime_aduaneiro_id
        );

        $aPeriodosGerados = FaturamentosManager::calculaValorRetencao(
            $aPeriodosGerados, $oLiberacaoDocumental, $iFaturamentoAncetessorID
        );

        if ($sOrigem == 'complementar' && $iFaturamentoAncetessorID) {
            $aPeriodosGerados = FaturamentoBaixasManager::decrementaValorBaixaPeriodo( $aPeriodosGerados, $aServicosGerados, $iLiberacaoDocumentalID,$iFaturamentoAncetessorID);
        }

        $aFaturamentoGerado = $this->gerarFaturamentoArray($aPeriodosGerados, $aServicosGerados, $sOrigem);
        $iFaturamentoID = $this->insereFaturamento($aFaturamentoGerado, $iFaturamentoAncetessorID);
        $this->inserePeriodos( $aPeriodosGerados, $iFaturamentoID );
        $this->insereServicos( $aServicosGerados, $iFaturamentoID );
        
        return [
            'message'   => __('Faturamento foi gerado com sucesso!'),
            'dataExtra' => $this->getFaturamentoByLiberacao( $iLiberacaoDocumentalID ),
            'status'    => 200
        ];
    }

    public function gerarPeriodoSomaServico( $aPeriodosGerados, $aServicosGerados )
    {
        $dTotalServicos = 0;
        foreach ($aServicosGerados as $key => $servico) {
            $dTotalServicos += $servico['valor_total'];
        }

        foreach ($aPeriodosGerados as $key => $periodo) {
            $aPeriodosGerados[$key]['servico_gerados'] = $aServicosGerados;
            $aPeriodosGerados[$key]['valor_total_servico'] = $dTotalServicos;
            $aPeriodosGerados[$key]['valor_periodo_servico'] = $periodo['valor_periodo'] + $dTotalServicos;
            $aPeriodosGerados[$key]['valor_acumulado_servico'] = $periodo['valor_acumulado'] + $dTotalServicos;
        }

        return $aPeriodosGerados;
    }

    public function removeValorServicoRestricoes($oTabelaPreco, $aPeriodosGerados){

        $aRestricoes = LgDbUtil::getFind('TabelaPrecoServicoPeriodoRestricoes')
            ->contain(['TabelasPrecosServicos', 'TabelasPrecosPeriodosArms'])
            ->where(['TabelasPrecosServicos.tabela_preco_id' => $oTabelaPreco->id])
            ->toArray();
        
        foreach ($aPeriodosGerados as $key => $aPeriodosGerado) {
            $aPeriodosRestricoes = [];
            foreach ($aPeriodosGerado['servico_gerados'] as $aServicoGerado) {
                $aRestricao = array_reduce($aRestricoes, function($aSum, $oRestricao) use($aServicoGerado, $aPeriodosGerado){

                    $valido = $aServicoGerado['tabela_preco_servico_id'] == $oRestricao->tabela_preco_servico_id &&
                    $aPeriodosGerado['tab_preco_per_arm_id'] == $oRestricao->tabela_preco_periodo_arm_id;

                    if($valido) $aSum[
                        $oRestricao->tabela_preco_servico_id."_".$oRestricao->tabela_preco_periodo_arm_id
                    ] = $oRestricao;

                    return $aSum;
                        
                }, []);

                $aPeriodosRestricoes = $aPeriodosRestricoes + $aRestricao;
            }
            
            $dTotalServicos = 0;
            $dTotalRetricoesServicos = 0;
            foreach ($aPeriodosGerado['servico_gerados'] as $aServicoGerado) {
                $sName = $aServicoGerado['tabela_preco_servico_id'] .'_'.$aPeriodosGerado['tab_preco_per_arm_id'];
                
                if(!array_key_exists($sName, $aPeriodosRestricoes)){
                    $dTotalServicos += $aServicoGerado['valor_total'];
                }
                
                if(array_key_exists($sName, $aPeriodosRestricoes)){
                    $dTotalRetricoesServicos += $aServicoGerado['valor_total'];
                }

            }

            $aPeriodosGerados[$key]['restricao_servicos'] 
                = $aPeriodosRestricoes;
            $aPeriodosGerados[$key]['valor_total_restricao_servico'] 
                = $dTotalRetricoesServicos;
            $aPeriodosGerados[$key]['valor_total_final_servico'] 
                = $dTotalServicos;
            $aPeriodosGerados[$key]['valor_periodo_servico'] = 
                $aPeriodosGerado['valor_periodo'] + $dTotalServicos;
            $aPeriodosGerados[$key]['valor_acumulado_servico'] = 
                $aPeriodosGerado['valor_acumulado'] + $dTotalServicos;

        }

        return $aPeriodosGerados;
    }


    private function getMercadoriasTratamentos( $iLiberacaoDocumentalID )
    {
        $aMercTrats = LgDbUtil::getFind('LiberacoesDocumentaisItens')
            ->select('DocumentosMercadorias.tratamento_carga_id')
            ->innerJoinWith('Estoques', function($q) {

                return $q
                    ->innerJoinWith('EtiquetaProdutos', function($q) { 

                        $q->innerJoinWith('DocumentosMercadoriasItens', function($q) { 
                            
                            return $q
                                ->innerJoinWith('DocumentosMercadorias', function($q) { 
                                    return $q;
                                });

                        })
                        ->where([
                            'Estoques.lote_item         = EtiquetaProdutos.lote_item',
                            'Estoques.lote_codigo       = EtiquetaProdutos.lote_codigo',
                            'Estoques.unidade_medida_id = EtiquetaProdutos.unidade_medida_id',
                            'Estoques.empresa_id        = EtiquetaProdutos.empresa_id'
                        ]);

                        return $q;
                    });

            })
            ->where([
                'liberacao_documental_id' => $iLiberacaoDocumentalID
            ])
            ->toArray();
 

        if (!$aMercTrats) {
            $aMercTrats = LgDbUtil::getFind('LiberacoesDocumentaisItens')
                ->select('DocumentosMercadoriasLote.tratamento_carga_id')
                ->innerJoinWith('DocumentosMercadoriasLote')
                ->where([
                    'liberacao_documental_id' => $iLiberacaoDocumentalID
                ])
                ->toArray();
        }
        
        if (!$aMercTrats)
            return false;

        $aTratamentosIDs = array();

        foreach ($aMercTrats as $key => $aMercTrat) {
            $aTratamentosIDs[] = @$aMercTrat->_matchingData['DocumentosMercadorias']->tratamento_carga_id;
            $aTratamentosIDs[] = @$aMercTrat->_matchingData['DocumentosMercadoriasLote']->tratamento_carga_id;
        }

        return $aTratamentosIDs;
    }

    public function getMercadoriaDataFinalizacaoDescarga( $iLiberacaoDocumentalID )
    {
        $oDataFinalizacaoDescarga = LgDbUtil::getFind('LiberacoesDocumentaisItens')
            ->select([
                'data_hora_fim' => 'distinct OrdemServicos.data_hora_fim'
            ])
            ->innerJoinWith('Estoques', function($q) {

                return $q->innerJoinWith('EtiquetaProdutos', function($q) { 
                        $q->innerJoinWith('DocumentosMercadoriasItens', function($q) {                             
                            return $q->innerJoinWith('DocumentosMercadorias', function($q) {                                     
                                return $q->innerJoinWith('DocumentosTransportes', function($q) {
                                    return $q->innerJoinWith('Resvs', function($q) {
                                        return $q->innerJoinWith('OrdemServicos', function($q) {
                                            return $q->where([
                                                'OrdemServicos.data_hora_fim IS NOT NULL'
                                            ]);
                                        });
                                    });
                                });
                            });
                        })
                        ->where([
                            'Estoques.lote_item         = EtiquetaProdutos.lote_item',
                            'Estoques.lote_codigo       = EtiquetaProdutos.lote_codigo',
                            'Estoques.unidade_medida_id = EtiquetaProdutos.unidade_medida_id',
                            'Estoques.empresa_id        = EtiquetaProdutos.empresa_id'
                        ]);

                        return $q;
                    });

            })
            ->where([
                'liberacao_documental_id' => $iLiberacaoDocumentalID
            ])
            ->first();

        if (!$oDataFinalizacaoDescarga)
            return date('Y-m-d');

        return $oDataFinalizacaoDescarga->data_hora_fim;
    }

    public function checkIfExistsFaturamento( $iLiberacaoDocumentalID )
    {
        return $this->that->Faturamentos->find()
            ->where([
                'liberacao_documental_id' => $iLiberacaoDocumentalID,
                'count_dape_primario IS NULL'
                ])
            ->first();

    }

    public function getFaturamentoByLiberacao( $iLiberacaoDocumentalID , $iFaturamentoID = null)
    {
        if (!Empresa::getEmpresaPadrao())
            return [
                'message' => __('O seu usuário precisa estar vinculado à alguma empresa antes!'),
                'status'  => 400
            ];

        $aFaturamentoWhere = [];

        $aFaturamentoWhere = [
            'OR' =>[
                'count_dai_secundario'    => '000',
                'count_dae_secundario'    => '000',
                'count_dape_secundario'   => '000',
                'count_dapesc_secundario' => '000',
                'OR' =>[
                    'count_dai_secundario'    => '00',
                    'count_dae_secundario'    => '00',
                    'count_dape_secundario'   => '00',
                    'count_dapesc_secundario' => '00',
                ]
            ],
        ];
        
        if($iFaturamentoID){
            $aFaturamentoWhere = ['Faturamentos.id' => $iFaturamentoID];
        }

        $that = $this->that;
        $aFaturamentos = array();

        $oLiberacaoDocumental = LgDbUtil::getFirst('LiberacoesDocumentais', [
            'id' => $iLiberacaoDocumentalID
        ]);

        $oFaturamentos = LgDbUtil::getFind('Faturamentos')
            ->contain([
                'TiposFaturamentos',
                'TipoServicoBancarios',
                'FaturamentoArmazenagens',
                'FaturamentoServicos',
                'FaturamentoAdicoes' => [
                    'LiberacaoDocumentalDecisaoTabelaPrecoAdicoes' => [
                        'Moedas' => ['MoedasCotacoes' => function($q) use($oLiberacaoDocumental){
                            return $q->where([
                                'MoedasCotacoes.data_cotacao' => $oLiberacaoDocumental->data_registro
                            ]);
                        }],  
                    ]
                ],
                'TabelasPrecos',
                'FaturamentoArmazenagens.TabelasPrecosPeriodosArms.Servicos',
                'FaturamentoServicos.TabelasPrecosServicos.Servicos',
                'Clientes',
                'LiberacoesDocumentais',
                'LiberacoesDocumentais.RegimesAduaneiros',
                'LiberacoesDocumentais.MoedaCif',
                'LiberacoesDocumentais.TipoDocumentos',
                'LiberacoesDocumentais.TipoDocumentosLiberacao',
                'LiberacoesDocumentais.LeftPessoas',
                'LiberacoesDocumentais.LiberacoesDocumentaisItensLeftMany.DocumentosMercadoriasLote'
            ])
            ->where($aFaturamentoWhere)
            ->where([
                'Faturamentos.liberacao_documental_id' => $iLiberacaoDocumentalID,
                'Faturamentos.empresa_id' => Empresa::getEmpresaPadrao(),
                'Faturamentos.count_dape_primario IS NULL'
            ])
            ->toArray();
            
        foreach ($oFaturamentos as $key => $oFaturamento) {
            $aFaturamentos[$key] = (object) $oFaturamento->that;
            $aFaturamentos[$key]->liberacoes_documental = MoedasCotacao::setValoresMoedasLiberacao( $that, $aFaturamentos[$key]->liberacoes_documental);
            
            $aFaturamentos[$key]->hawb = $this->_LiberacaoDocumental->getLiberacaoDocumentalHAWBs( $this->that, $aFaturamentos[$key]->liberacoes_documental->id );
            $aFaturamentos[$key]->awb = $this->_LiberacaoDocumental->getLiberacaoDocumentalAWBs( $this->that, $aFaturamentos[$key]->liberacoes_documental->id );
            $aFaturamentos[$key]->doc_transp = $this->_LiberacaoDocumental->getLiberacaoDocumentalDocumentoTransporte( $this->that, $aFaturamentos[$key]->liberacoes_documental->id );
            
        }
        
        return [
            'faturamento' => $aFaturamentos
        ];
    }

    public function getFaturamentoArrayTabela( $aFaturamentos )
    {
        $aFaturamentoTable = array();

        $iLiberacao     = @$aFaturamentos[0]->liberacao_documental_id;
        $oTabelaPreco   = @$aFaturamentos[0]->tabelas_preco;

        $sDataFinalizacaoDescarga = $this->getMercadoriaDataFinalizacaoDescarga(
            $iLiberacao 
        );

        $this->sDataFinalizacaoDescarga = $sDataFinalizacaoDescarga;
        $this->sDataFinalizacaoDescargaSemAddDia = $sDataFinalizacaoDescarga;

        $sDataDescarga = FaturamentosManager::getDataDescargaPeriocidade(
            $this, $oTabelaPreco
        );
        
        $this->sDataFinalizacaoDescarga = $sDataDescarga;

        foreach ($aFaturamentos as $keyFatu => $aFaturamento) {
            $dTotalServicos = 0;

            $oEmpresaMaster = LgDbUtil::getByID(
                'Empresas', Empresa::getEmpresaPadrao()
            );


            $sNumeroDocumentoArrecadacaoFormatado = UniversalCodigoUtil::getNumeroDocumentoArrecadacao($aFaturamento);
            $sNumeroDocumentoArrecadacao = str_replace('.', '', $sNumeroDocumentoArrecadacaoFormatado);

            $sNossoNumero = $aFaturamento->tipo_faturamento_id;
            $sNossoNumero .= $sNumeroDocumentoArrecadacao;

            //$sNossoNumero = $aFaturamento->numero_faturamento;

            $aFaturamentoTable[$keyFatu] = array(
                'faturamento_object'        => $aFaturamento,
                'numero_documento_arrecadacao' => $sNumeroDocumentoArrecadacaoFormatado,
                'faturamento_id'            => $aFaturamento->id,
                'tipo_faturamento'          => $aFaturamento->tipos_faturamento->descricao,
                'numero_faturamento'        => $aFaturamento->numero_faturamento,
                'data_emissao'              => DateUtil::dateTimeFromDB( $aFaturamento->data_hora_emissao, 'd/m/Y H:i:s', ' '),
                'beneficiario'              => $aFaturamento->cliente->descricao,
                'cliente'                   => $aFaturamento->cliente,
                'pessoa'                    => $aFaturamento->liberacoes_documental->pessoa,
                'empresa_master'            => $oEmpresaMaster,
                'peso_bruto'                => $aFaturamento->liberacoes_documental->peso_bruto,
                'peso_liquido'              => $aFaturamento->liberacoes_documental->peso_liquido,
                'volume_total'              => FaturamentosManager::getVolumeTotal($aFaturamento),
                'moeda_cif_nome'            => $aFaturamento->liberacoes_documental->moeda_cif->descricao,
                'moeda_cif_cotacao'         => $aFaturamento->liberacoes_documental->cotacao_moeda_cif,
                'moeda_cif_valor'           => $aFaturamento->liberacoes_documental->valor_cif_moeda,
                'moeda_cif_resultado'       => $aFaturamento->liberacoes_documental->resultado_moeda_cif,
                'tabela_preco_id'           => $aFaturamento->tabelas_preco->id,
                'tabela_preco'              => $aFaturamento->tabelas_preco->descricao,
                'count_dai_primario'        => $aFaturamento->count_dai_primario,
                'count_dai_secundario'      => $aFaturamento->count_dai_secundario,
                'count_dae_primario'        => $aFaturamento->count_dae_primario,
                'count_dae_secundario'      => $aFaturamento->count_dae_secundario,
                'count_dape_primario'       => $aFaturamento->count_dape_primario,
                'count_dape_secundario'     => $aFaturamento->count_dape_secundario,
                'tipo_servico_bancario'     => $aFaturamento->tipo_servico_bancario,
                'tipo_servico_bancario_id'  => $aFaturamento->tipo_servico_bancario_id,
                'hawb'                      => $aFaturamento->hawb,
                'awb'                       => $aFaturamento->awb,
                'doc_transp'                => $aFaturamento->doc_transp,
                'liberacoes_documental'     => $aFaturamento->liberacoes_documental,
                'adicoes'                   => FaturamentoAdicoesManager::getAdicoesDemostrativo($aFaturamento),
                'data_finalizacao_descarga' => DateUtil::dateTimeFromDB(
                    $this->sDataFinalizacaoDescarga, 'd/m/Y H:i:s', ' '
                ),
                'data_finalizacao_descarga_sem_add_dia' => DateUtil::dateTimeFromDB(
                    $this->sDataFinalizacaoDescargaSemAddDia, 'd/m/Y H:i:s', ' '
                ),
                'infos_codigo_barra_boleto' => [
                    'IDEN_PRODUTO'        => ParametroGeral::getParametroWithValue('FATU_COD_BARRA_IDEN_PRODUTO')?: 8,
                    'IDEN_SEGMENTO'       =>ParametroGeral::getParametroWithValue('FATU_COD_BARRA_IDEN_SEGMENTO')?: 6,
                    'IDEN_VALOR_REAL_REF' =>ParametroGeral::getParametroWithValue('FATU_COD_BARRA_IDEN_VALOR_REAL_REF')?: 7,
                    'AGENCIA_UNIDADE_PTN' =>ParametroGeral::getParametroWithValue('AGENCIA_UNIDADE_PTN')?: 0,
                    'CONTA_CORRENTE_UNIDADE_PTN' =>ParametroGeral::getParametroWithValue('CONTA_CORRENTE_UNIDADE_PTN')?: 0,
                    'DESCRICAO_BOLETO_DAPE_UNIDADE_PTN' =>ParametroGeral::getParametroWithValue('DESCRICAO_BOLETO_DAPE_UNIDADE_PTN')?: 0,
                    'CNPJ_MASTER'         => substr($oEmpresaMaster->cnpj, 0, 8),
                    'CNPJ_MASTER_COMPLETO' => $oEmpresaMaster->cnpj,
                    'CODIGO_EMPRESA'      => $oEmpresaMaster->codigo,
                    'NOSSO_NUMERO'        => $sNossoNumero
                ]
            );

            $fDesconto = (int) @$aFaturamento->faturamento_armazenagens[0]['desconto'];
            $fDesconto = $aFaturamento->tabelas_preco->desconto_percentual ?: $fDesconto;
            
            $aFaturamentoTable[$keyFatu]['linha_periodos'] = array(
                'tabela'   => $aFaturamento->tabelas_preco->descricao,
                'regime'   => $aFaturamento->liberacoes_documental->regimes_aduaneiro->id . '//' . $aFaturamento->liberacoes_documental->regimes_aduaneiro->descricao,
                'servico'  => @$aFaturamento->faturamento_armazenagens[0]->tabelas_precos_periodos_arm->servico->id . '//' . @$aFaturamento->faturamento_armazenagens[0]->tabelas_precos_periodos_arm->servico->descricao,
                'desconto' => $fDesconto,
                'periodos' => array(),
                'periodos_acumulado' => array(),
                'periodos_servicos' => array(),
                'periodos_acumulado_servicos' => array(),
                'periodos_numeros' => array(),
                'periodos_isentos' => array(),
                'periodos_datas_vencimentos' => array()
            );

            foreach ($aFaturamento->faturamento_armazenagens as $key => $aArmazenagem) {
                // $valor_periodo_atual = $aArmazenagem->valor_periodo;

                // $valor_periodo = (count($aFaturamentoTable[$keyFatu]['linha_periodos']['periodos']) > 1 && $key > 0) 
                //     ? $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos'][ count($aFaturamentoTable[$keyFatu]['linha_periodos']['periodos']) - 1 ] + $valor_periodo_atual 
                //     : end($aFaturamentoTable[$keyFatu]['linha_periodos']['periodos']) + $valor_periodo_atual;

                $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos_acumulado_servicos'][] = $aArmazenagem->valor_acumulado_servico;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos_servicos'][] = $aArmazenagem->valor_periodo_servico;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos_numeros'][] = $aArmazenagem->numero_periodo;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos_isentos'][] = $aArmazenagem->isento;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos'][] = $aArmazenagem->valor_periodo;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos_acumulado'][] = $aArmazenagem->valor_acumulado;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['periodos_datas_vencimentos'][] = $aArmazenagem->vencimento_periodo;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['valor_total_final_servicos'][] = $aArmazenagem->valor_total_final_servico;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['valor_retencao'][] = 
                $aArmazenagem->valor_retencao;
                $aFaturamentoTable[$keyFatu]['linha_periodos']['valor_total_devido'][] = 
                $aArmazenagem->valor_total_devido;
            }

            foreach ($aFaturamento->faturamento_servicos as $key => $aServicos) {   
                $aFaturamentoTable[$keyFatu]['linha_servicos'][] = array(
                    'tabela'   => $aFaturamento->tabelas_preco->descricao,
                    'servico'  => $aServicos->tabelas_precos_servico->servico->id . '//' . $aServicos->tabelas_precos_servico->servico->descricao,
                    'regime'   => $aFaturamento->liberacoes_documental->regimes_aduaneiro->id . '//' . $aFaturamento->liberacoes_documental->regimes_aduaneiro->descricao,
                    'desconto' => $aServicos->tabelas_precos_servico->desconto_percentual_serv,
                    'valor'    => $aServicos->valor_total
                );
                
                $dTotalServicos += $aServicos->valor_total;
            }
            
            $aFaturamentoTable[$keyFatu]['total_armazenagem'] = end($aFaturamentoTable[$keyFatu]['linha_periodos']['periodos']);
            $aFaturamentoTable[$keyFatu]['total_servicos'] = $dTotalServicos;
        }
        
        return $aFaturamentoTable;
    }

    public function insereServicos( $aServicosGerados, $iFaturamentoID )
    {
        foreach ($aServicosGerados as $key => $aServicoGerado) {
            $aServicoGerado['faturamento_id']   = $iFaturamentoID;
            $aServicoGerado['valor_unitario']   = round(@$aServicoGerado['valor_unitario'], 4);
            $aServicoGerado['valor_total']      = round(@$aServicoGerado['valor_total'], 2);
            $oFaturamentoServicos = $this->that->FaturamentoServicos->newEntity();
            $oFaturamentoServicos = $this->that->FaturamentoServicos->patchEntity($oFaturamentoServicos, $aServicoGerado);

            if (!$result = $this->that->FaturamentoServicos->save($oFaturamentoServicos))
                ErrorUtil::custom('Houve algum problema ao gravar os serviços do faturamento! ' . EntityUtil::dumpErrors($oFaturamentoServicos));
        }
    }

    public function inserePeriodos( $aPeriodosGerados, $iFaturamentoID )
    {
        foreach ($aPeriodosGerados as $key => $aPeriodoGerado) {
            $sVencimentoPeriodo = DateUtil::dateTimeToDB(
                $aPeriodoGerado['vencimento_periodo'], 'Y-m-d', ''
            );

            $aPeriodoGerado['faturamento_id'] = $iFaturamentoID;            
            $aPeriodoGerado['vencimento_periodo'] = $sVencimentoPeriodo;

            $aPeriodoGerado['valor_periodo'] = 
                round(@$aPeriodoGerado['valor_periodo'], 2);
            $aPeriodoGerado['valor_minimo'] = 
                round(@$aPeriodoGerado['valor_minimo'], 2);
            $aPeriodoGerado['valor_periodo_sem_minimo'] = 
                round(@$aPeriodoGerado['valor_periodo_sem_minimo'], 2);

            $aPeriodoGerado['valor_acumulado'] = 
                round(@$aPeriodoGerado['valor_acumulado'], 2);
            $aPeriodoGerado['valor_acumulado_no_periodo'] = 
                round(@$aPeriodoGerado['valor_acumulado_no_periodo'], 2);
            $aPeriodoGerado['valor_periodo_servico'] = 
                round(@$aPeriodoGerado['valor_periodo_servico'], 2);
            $aPeriodoGerado['valor_acumulado_servico'] = 
                round(@$aPeriodoGerado['valor_acumulado_servico'], 2);

            $aPeriodoGerado['valor_total_servico'] = 
                round(@$aPeriodoGerado['valor_total_servico'], 2);
            $aPeriodoGerado['valor_restricao_servico'] = 
                round(@$aPeriodoGerado['valor_total_restricao_servico'], 2);
            $aPeriodoGerado['valor_total_final_servico'] = 
                round(@$aPeriodoGerado['valor_total_final_servico'], 2);
            $aPeriodoGerado['restricao_servico'] = 
                empty($aPeriodoGerado['restricao_servicos']) ? 0 : 1;

            $aPeriodoGerado['valor_periodo_sem_desconto'] = 
                round(@$aPeriodoGerado['valor_periodo_sem_desconto'], 2);
            $aPeriodoGerado['valor_acumulado_sem_desconto'] = 
                round(@$aPeriodoGerado['valor_acumulado_sem_desconto'], 2);
            $aPeriodoGerado['valor_acumulado_no_periodo_sem_desconto'] = 
                round(@$aPeriodoGerado['valor_acumulado_no_periodo_sem_desconto'], 2);
            $aPeriodoGerado['valor_acumulado_servico_sem_desconto'] = 
                round(@$aPeriodoGerado['valor_acumulado_servico_sem_desconto'], 2);

            $oFaturamentoArmazenagens = $this->that->FaturamentoArmazenagens->newEntity();
            $oFaturamentoArmazenagens = $this->that->FaturamentoArmazenagens->patchEntity($oFaturamentoArmazenagens, $aPeriodoGerado);   
            
            if (!$result = $this->that->FaturamentoArmazenagens->save($oFaturamentoArmazenagens))
                ErrorUtil::custom('Houve algum problema ao gravar os períodos do faturamento! ' . EntityUtil::dumpErrors($oFaturamentoArmazenagens));
        }
    }

    public function insereFaturamento( $aData, $iFaturamentoAncetessorID = null )
    {        
        $oFaturamento = null;
        $oFaturamentoOld = null;
        $sCountPrimario = '';
        $sCountSecundario = '';
        $sCountDigitoVerificador = '';
        $sCountGenericCompleto = '';

        if($iFaturamentoAncetessorID) {
            $oFaturamento = LgDbUtil::getFirst('Faturamentos', [
                'id' => $iFaturamentoAncetessorID
            ]);

            $oFaturamento = isset($oFaturamento) 
                ? (object) $oFaturamento->that 
                : null;
            
            $oFaturamentoOld = $oFaturamento;
        }

        $aData['valor_armazenagem'] = round(@$aData['valor_armazenagem'], 2);
        $aData['valor_servicos']    = round(@$aData['valor_servicos'], 2);
        $aData['valor_retencao']    = round(@$aData['valor_retencao'], 2);

        $oFaturamento = $this->that->Faturamentos->newEntity();
        $oFaturamento = $this->that->Faturamentos->patchEntity($oFaturamento, $aData);
        
        if (!$result = $this->that->Faturamentos->save($oFaturamento))
            ErrorUtil::custom('Houve algum problema ao gravar o faturamento! ' . EntityUtil::dumpErrors($oFaturamento));

        if ($aData['tipo_faturamento_id'] == 2) { //DAI

            //$oFaturamento->count_dai_primario = @$oFaturamento->count_dai_primario ?: UniversalCodigoUtil::codigoFaturamentoDAI($this->that);
            $oFaturamento->count_dai_primario = @$oFaturamentoOld->count_dai_primario ?: UniversalCodigoUtil::geraCodigoPrimarioFaturamento($oFaturamento);
            $oFaturamento->count_dai_secundario = UniversalCodigoUtil::geraCodigoSecundarioFaturamento($oFaturamentoOld, @$oFaturamentoOld->count_dai_secundario);
            
            $sCountPrimario = $oFaturamento->count_dai_primario;
            $sCountSecundario = $oFaturamento->count_dai_secundario;

        }else if ($aData['tipo_faturamento_id'] == 1) { 

            //$oFaturamento->count_dae_primario = @$oFaturamento->count_dae_primario ?:UniversalCodigoUtil::codigoFaturamentoDAE($this->that);
            $oFaturamento->count_dae_primario = @$oFaturamentoOld->count_dae_primario ?: UniversalCodigoUtil::geraCodigoPrimarioFaturamento($oFaturamento);
            $oFaturamento->count_dae_secundario = UniversalCodigoUtil::geraCodigoSecundarioFaturamento($oFaturamentoOld, @$oFaturamentoOld->count_dae_secundario);

            $sCountPrimario = $oFaturamento->count_dae_primario;
            $sCountSecundario = $oFaturamento->count_dae_secundario;

        }else if ($aData['tipo_faturamento_id'] == 3) { //DAPE
            
            //$oFaturamento->count_dape_primario = UniversalCodigoUtil::codigoFaturamentoDAPE($this->that, $aData);
            $oFaturamento->count_dape_primario = UniversalCodigoUtil::geraCodigoPrimarioFaturamento($oFaturamento);
            $oFaturamento->count_dape_secundario = UniversalCodigoUtil::codigoFaturamentoDAPESecundario($this->that, $aData);

            $sCountPrimario = $oFaturamento->count_dape_primario;
            $sCountSecundario = $oFaturamento->count_dape_secundario;

        }else if ($aData['tipo_faturamento_id'] == 4) { //DAPE SEM CARGA

            //$oFaturamento->count_dapesc_primario = UniversalCodigoUtil::codigoFaturamentoDAPESemCarga($this->that, $aData);
            $oFaturamento->count_dapesc_primario = UniversalCodigoUtil::geraCodigoPrimarioFaturamento($oFaturamento);
            $aData['count_dapesc_primario'] = $oFaturamento->count_dapesc_primario;
            $oFaturamento->count_dapesc_secundario = UniversalCodigoUtil::codigoFaturamentoDAPESemCargaSecundario($this->that, $aData);

            $sCountPrimario = $oFaturamento->count_dapesc_primario;
            $sCountSecundario = $oFaturamento->count_dapesc_secundario;

        }else {
            $sCountPrimario = $oFaturamentoOld->count_generic_primario ?: UniversalCodigoUtil::geraCodigoPrimarioFaturamento($oFaturamento);
            $sCountSecundario = UniversalCodigoUtil::geraCodigoSecundarioFaturamento($oFaturamentoOld, '0');
        }

        $oFaturamento->count_generic_primario = $sCountPrimario;
        $oFaturamento->count_generic_secundario = $sCountSecundario;
        $oFaturamento->count_generic_dv = UniversalCodigoUtil::codigoFaturamentoDigitoVerificador($oFaturamento);
        $oFaturamento->count_generic_completo = UniversalCodigoUtil::codigoFaturamentoCompleto($oFaturamento);

        if (!$result = $this->that->Faturamentos->save($oFaturamento))
            ErrorUtil::custom('Houve algum problema ao gravar o faturamento! ' . EntityUtil::dumpErrors($oFaturamento));

        $oFaturamento->numero_faturamento = UniversalCodigoUtil::codigoFaturamento($oFaturamento->id);
        $this->that->Faturamentos->save($oFaturamento);

        return $oFaturamento->id;
    }

    private function gerarFaturamentoArray($aPeriodosGerados, $aServicosGerados, $sOrigem)
    {
        $iValorArmazenagem = 0;
        $iValorServicos    = 0;
        $oTipoServicoBancario = $this->that->Empresas->find()
            ->contain('TipoServicoBancarios')
            ->where([
                'Empresas.id' => $this->oLiberacaoDocumental->cliente_id
            ])
            ->first();

        if (!isset($oTipoServicoBancario->tipo_servico_bancario)) 
            ErrorUtil::custom('Falta cadastrar o Tipo de Serviço Bancário do cliente (cadastro de empresas)!');

        $aPeriodosGerado = empty($aPeriodosGerados) ? [] : end($aPeriodosGerados);
        $iValorArmazenagem = @$aPeriodosGerado['valor_acumulado'] ?: 0;
        $iValorServicos = @$aPeriodosGerado['valor_total_final_servico'] ?: 0;
        $iEnableAutoTpComplementar = FaturamentoComplementaresManager::isTc4(
            $this->oLiberacaoDocumental->id
        );
        
        return array(
            'numero_faturamento'       => '0',
            'data_hora_emissao'        => DateUtil::dateTimeToDB(date('Y-m-d H:i:s'), 'Y-m-d H:i:s', ''),
            'valor_armazenagem'        => $iValorArmazenagem,
            'valor_servicos'           => $iValorServicos,
            'tipo_servico_bancario_id' => $oTipoServicoBancario->tipo_servico_bancario->id,
            'liberacao_documental_id'  => $this->oLiberacaoDocumental->id,
            'tabela_preco_id'          => $this->oTabelaPreco->id,
            'regime_aduaneiro_id'      => $this->oLiberacaoDocumental->regime_aduaneiro_id,
            'cliente_id'               => $this->oLiberacaoDocumental->cliente_id,
            'tipo_faturamento_id'      => $this->oTabelaPreco->_matchingData['RegimeAduaneiroTipoFaturamentos']->tipo_faturamento_id,
            'empresa_id'               => $this->that->getEmpresaAtual(),
            'escolhe_auto_tp_fat_complementar' => $iEnableAutoTpComplementar
        );
        
    }

    public function gerarServicos( $oTabelaPreco, $iAntecessorId = null)
    {
        $oBaixado = null;
        $oAntessesor = LgDbUtil::getFirst('Faturamentos', ['id' => $iAntecessorId]);
        $aWhere = [
            'TabelasPrecosServicos.tabela_preco_id' => $oTabelaPreco->id,
        ];

        if($oAntessesor) {
            $oBaixado = LgDbUtil::getFind('FaturamentoBaixas')
                ->innerJoinWith('Faturamentos')
                ->where([
                    'Faturamentos.count_dai_primario IS'    => @$oAntessesor->that["count_dai_primario"],
                    'Faturamentos.count_dae_primario IS'    => @$oAntessesor->that["count_dae_primario"],
                    'Faturamentos.count_dape_primario IS'   => @$oAntessesor->that["count_dape_primario"],
                    'Faturamentos.count_dapesc_primario IS' => @$oAntessesor->that["count_dapesc_primario"],
                ])->first();
        }


        if($oBaixado){
            $aWhere = [
                'TabelasPrecosServicos.tabela_preco_id' => $oTabelaPreco->id,
                'TabelasPrecosServicos.gera_cobranca_faturamento_complementar_com_baixas' => 1
            ];
        }

        $oServicos = LgDbUtil::get('TabelasPrecosServicos')->find()
            ->contain(['SistemaCampos'])
            ->where($aWhere)
            ->toArray();

        $aServicos = array();
        foreach ($oServicos as $key => $oServico) {
            $aReturnValidacaoServ = $this->getValidacaoServ( $oServico );
            $bServicoPertencente = ( strpos($oServico->sistema_campo->codigo, 'SERVEXEC') !== false ) ? true : false;  
            
            if ($aReturnValidacaoServ != 'sem_validacao' && $aReturnValidacaoServ->status != 200 || $bServicoPertencente)
                continue;

            $oServico->valor_total = TiposValore::calculaValorDinamico( $this->that, $oServico->valor, $oServico->valor_minimo, $oServico->tipo_valor_id, $this->oLiberacaoDocumental, $oServico->campo_valor_sistema_id );
            
            $oServico->valor_total = ($oServico->desconto_percentual_serv > 0) 
                    ? $oServico->valor_total - (( $oServico->desconto_percentual_serv / 100 ) * $oServico->valor_total) 
                    : $oServico->valor_total;

            $oServico->valor_total = ($this->oTabelaPreco->desconto_percentual > 0) 
                    ? $oServico->valor_total - (( $this->oTabelaPreco->desconto_percentual / 100 ) * $oServico->valor_total)
                    : $oServico->valor_total;

            $oServico->valor_total = $oServico->valor_total < 0 ? 0 : $oServico->valor_total;


            $aServicos[] = array(
                'quantidade'              => 1,
                'valor_unitario'          => round($oServico->valor, 2),
                'valor_total'             => round($oServico->valor_total, 2),
                'tabela_preco_servico_id' => $oServico->id,
                'faturamento_id'          => null,
                'empresa_id'              => Empresa::getEmpresaAtual(),
                'fatura_complementar_com_baixas' => 
                    $oServico->gera_cobranca_faturamento_complementar_com_baixas
            );
        }

        return $aServicos;
    }

    public function gerarPeriodosComplementares( $oPeriodosArm, $sOrigem, $iFaturamentoAncetessorID )
    {
        $aPeriodosFatuAntecessor = $this->that->FaturamentoArmazenagens->find()
            ->where([
                'FaturamentoArmazenagens.faturamento_id' => $iFaturamentoAncetessorID
            ])
            ->toArray();
        
        $sUltimaDataGerada = $aPeriodosFatuAntecessor[ count($aPeriodosFatuAntecessor) - 1 ]->vencimento_periodo;

        if ($sUltimaDataGerada)
            $sUltimaDataGerada = new \DateTime(DateUtil::addTimeDiaUtil( $sUltimaDataGerada, 'Y-m-d', 1, '-' ));

        $iParamQtdMaxPeriodos = ($x = ParametroGeral::getParametro( $this->that, 'QTD_PERIODOS_GERAR_FATU')) ? $x->valor : 8;
        $iNumeroPeriodo = $aPeriodosFatuAntecessor[ count($aPeriodosFatuAntecessor) - 1 ]->numero_periodo + 1;
        $iPeriodosGerados = 0;
        $aPeriodos = array();
        
        foreach ($oPeriodosArm as $key => $oPeriodo) {
            
            if ( $oPeriodo->periodo_final == $oPeriodo->periodo_inicial ) {
                $aReturnPeriodo = $this->getPeriodoFormated( $oPeriodo, $aPeriodos, $iNumeroPeriodo, $sUltimaDataGerada ); 
                
                if ($aReturnPeriodo == 'continue')
                    continue;

                $aPeriodos[] = $aReturnPeriodo;                
                $iNumeroPeriodo++;

            }else {
                $bContinuaGerando = true;
                $iPeriodosAGerar = $oPeriodo->periodo_final - $oPeriodo->periodo_inicial;

                while ( $bContinuaGerando ) {
                    
                    $aReturnPeriodo = $this->getPeriodoFormated( $oPeriodo, $aPeriodos, $iNumeroPeriodo, $sUltimaDataGerada ); 
                    
                    if ($aReturnPeriodo == 'continue')
                        break;

                    $aPeriodos[] = $aReturnPeriodo;
                    $iNumeroPeriodo++;

                    if ( $iPeriodosGerados < $iParamQtdMaxPeriodos && $iPeriodosAGerar ){
                        $iPeriodosAGerar--;
                    }else {
                        $bContinuaGerando = false;
                        break;
                    }

                    if ($iPeriodosGerados + 1 == $iParamQtdMaxPeriodos) {
                        $bContinuaGerando = false;
                        break;
                    }

                    $iPeriodosGerados++;
                }
            }

            if ($iPeriodosGerados == $iParamQtdMaxPeriodos)
                break;

            $iPeriodosGerados++;
        }

        $aPeriodos = $this->removePeriodosMenoresQueHoje($aPeriodos);
        $valor_acumulado = 0;

        foreach ($aPeriodos as $key => $aPeriodo) {
            $valor_acumulado += $aPeriodo['valor_periodo'];
            $aPeriodos[$key]['valor_acumulado'] = $valor_acumulado;
        }

        return $aPeriodos;
    }

    public function gerarPeriodos( $oPeriodosArm, $sOrigem )
    {
        $aPeriodos = FaturamentosManager::getPeriodos($this, $oPeriodosArm);
        $aPeriodos = FaturamentosManager::calculaValorAcumadoPeriodos($aPeriodos);
        $aPeriodos = $this->removePeriodosMenoresQueHoje($aPeriodos);
        return $aPeriodos;
    }

    public function removePeriodosMenoresQueHoje( $aPeriodos )
    {
        foreach ($aPeriodos as $key => $aPeriodo) {
            if ( strtotime($aPeriodo['vencimento_periodo']) < strtotime(date('Y-m-d')) ) {
                unset($aPeriodos[$key]);
            }
        }

        return $aPeriodos;
    }

    private function getPeriodoFormated( $oPeriodo, $aPeriodos, $iNumeroPeriodo = 1, $sUltimaDataGerada = false )
    {
        return FaturamentosManager::getPeriodoFormated($this, $oPeriodo, $aPeriodos, $iNumeroPeriodo, $sUltimaDataGerada);
    }

    private function getValidacaoServ( $oServico )
    {
        $oValidaServs = $this->that->TabPrecosValidaServicos->find()
            ->where([
                'tab_preco_servico_id' => $oServico->id
            ])
            ->toArray();

        if ( !$oValidaServs ) 
            return 'sem_validacao';

        foreach ($oValidaServs as $key => $oValidaServ) {            
            $oOperador = $this->that->Operadores->get( $oValidaServ->operador_id );
            $oCampoSistema = $this->that->SistemaCampos->get( $oValidaServ->campo_sistema_id );
            
            $sValor = '';
            $sCampoFormatado = strtolower($oCampoSistema->codigo);

            if ( isset($this->oLiberacaoDocumental->{$sCampoFormatado}) ) {
                $sValor = $this->oLiberacaoDocumental->{$sCampoFormatado};
            }
    
            $aResultValidacao = Operadore::getResultValidacao( $oOperador, $sValor, $oValidaServ->valor_inicio, $oValidaServ->valor_final );

            if ($aResultValidacao['status'] == 400)
                return $aResultValidacao;
    
            if ($aResultValidacao['status'] == 400)
                return[
                    'message' => 'Operador "'.$oOperador->descricao.'" informado na validação não está programado! Favor escolher outro operador já cadastrado anteriormente',
                    'status'  => $aResultValidacao['status']
                ];
    
            $oValidaServ->status = $aResultValidacao['status'];
        }

        return $oValidaServ;
    }

    public function getValidacaoPerArm( $oPeriodo )
    {
        $aValidaPerArms = $this->that->TabPrecosValidaPerArms->find()
            ->where([
                'tab_preco_per_arm_id' => $oPeriodo->id
            ])
            ->toArray();

        if ( !$aValidaPerArms ) 
            return 'sem_validacao';

        foreach ($aValidaPerArms as $key => $oValidaPerArm) {            
            $oOperador = $this->that->Operadores->get( $oValidaPerArm->operador_id );
            $oCampoSistema = $this->that->SistemaCampos->get( $oValidaPerArm->campo_sistema_id );
            
            $sValor = '';
            $sCampoFormatado = strtolower($oCampoSistema->codigo);
    
            if ( isset($this->oLiberacaoDocumental->{$sCampoFormatado}) ) {
                $sValor = $this->oLiberacaoDocumental->{$sCampoFormatado};
            }

            $oValidaPerArm->valor_inicio = DoubleUtil::toDBUnformat($oValidaPerArm->valor_inicio);
            $oValidaPerArm->valor_final = DoubleUtil::toDBUnformat($oValidaPerArm->valor_final);
            
            $aResultValidacao = Operadore::getResultValidacao( $oOperador, $sValor, $oValidaPerArm->valor_inicio, $oValidaPerArm->valor_final );
            
            if ($aResultValidacao['status'] == 400)
                ErrorUtil::custom($aResultValidacao['message']);
    
            if ($aResultValidacao['status'] == 401)
                ErrorUtil::custom('Operador "'.$oOperador->descricao.'" informado na validação não está programado! Favor escolher outro operador já cadastrado anteriormente');
    
            $oValidaPerArm->status = $aResultValidacao['status'];
        }

        return $oValidaPerArm;
    }

    public function getPeriodosArm( $oTabelaPreco, $sOrigem = '', $iFaturamentoAncetessorID = '' )
    {
        $aExtraWhere = [];
        $oTabelasPrecosPeriodos = $this->that->TabelasPrecosPeriodosArms;

        if ($sOrigem == 'complementar' && $iFaturamentoAncetessorID) {
            $iUltimoPeriodo = $this->that->FaturamentoArmazenagens->find()
                ->where([
                    'FaturamentoArmazenagens.faturamento_id' => $iFaturamentoAncetessorID
                ])
                ->order('FaturamentoArmazenagens.numero_periodo DESC')
                ->limit(1)
                ->first();

            $iUltimoPeriodo = ($iUltimoPeriodo) ? $iUltimoPeriodo->numero_periodo : 0;

            $oPeriodoMatch = $oTabelasPrecosPeriodos->find()
                ->where([
                    'tabela_preco_id' => $oTabelaPreco->id,
                    $iUltimoPeriodo . ' BETWEEN periodo_inicial AND periodo_final',
                    'periodo_final > ' => $iUltimoPeriodo
                ])->first();

            if (!$oPeriodoMatch)
                $oPeriodoMatch = $oTabelasPrecosPeriodos->find()
                    ->where([
                        'tabela_preco_id' => $oTabelaPreco->id,
                        'periodo_inicial > ' => $iUltimoPeriodo
                    ])->first();

            if (!$oPeriodoMatch)
                ErrorUtil::custom('Não há períodos de armazenagens (consistentes no cadastro) para poder gerar esse Faturamento Complementar!');

            $aExtraWhere = [
                'TabelasPrecosPeriodosArms.id >=' => $oPeriodoMatch->id
            ];
        }
        
        $aPeriodos = $oTabelasPrecosPeriodos->find()
            ->contain(['TabelaPrecoPeriodicidades'])
            ->where([
                'tabela_preco_id' => $oTabelaPreco->id
            ] + $aExtraWhere
            )
            ->order([
                'TabelasPrecosPeriodosArms.periodo_inicial', 
                'TabelasPrecosPeriodosArms.id' 
            ])
            ->toArray();

        if (!$aPeriodos)
            ErrorUtil::custom('Não há períodos de armazenagens para poder gerar esse Faturamento!');

        return $aPeriodos;
    }

    public function getTabelaPreco( $oLiberacaoDocumental, $aTratamentosIDs, $sOrigem = null, $iFaturamentoAncetessorID = null )
    {
        $oTabelasPrecos = LgDbUtil::get('TabelasPrecos')->find();
        $oFaturamentoAntecessor = LgDbUtil::getFirst('Faturamentos', ['id' => $iFaturamentoAncetessorID]);
        $iIsEnable = FaturamentoComplementaresManager::isEnableAutoTratamento($oFaturamentoAntecessor);

        if ($sOrigem == 'complementar' && $oFaturamentoAntecessor && !$iIsEnable) {
            return TabelasPreco::getTabelaPrecoByFatuAntecessor(
                $oTabelasPrecos, 
                $this->that, 
                $oFaturamentoAntecessor
            )->first();
        }

        $oTabelaPreco = FaturamentosManager::getTabelaPrecoCliente(
            $aTratamentosIDs, $oLiberacaoDocumental
        );

        if($oTabelaPreco) return $oTabelaPreco;
        
        return  TabelasPreco::getTabelaPrecoByParams(
            $oTabelasPrecos, 
            $this->that, 
            $aTratamentosIDs, 
            $oLiberacaoDocumental
        )->first();

        return $oTabelaPreco;
    }

    public function setLiberacaoDocumental( $oLiberacaoDocumental)
    {        
        $this->oLiberacaoDocumental = MoedasCotacao::setValoresMoedasLiberacao( $this->that, $oLiberacaoDocumental );
    }

    public function setTabelaPreco( $oTabelaPreco )
    {        
        $this->oTabelaPreco = $oTabelaPreco;
    }

    public function getListagemFaturamento()
    {
        $that = $this->that;
        $oLiberacoesDocumentais = $this->that->LiberacoesDocumentais->find()
            ->contain([
                'RegimesAduaneiros',
                'TipoDocumentos',
                'Clientes'
            ])
            ->innerJoinWith('RegimesAduaneiros.RegimeAduaneiroTipoFaturamentos', function(\Cake\ORM\Query $q) use($that) {
                return $q->innerJoinWith('TiposFaturamentos', function(\Cake\ORM\Query $q) use($that) {
                    return $q->select($that->TiposFaturamentos);
                });
            })
            ->toArray();

        if (!$oLiberacoesDocumentais)
            return false;

        foreach ($oLiberacoesDocumentais as $key => $oLiberacaoDocumental) {
            $oLiberacoesDocumentais[$key]->data_fim_descarga = OrdemServico::getDataFimByLiberacaoDocumental( $this->that, $oLiberacaoDocumental, 1 );
            $oLiberacoesDocumentais[$key]->data_fim_carga = OrdemServico::getDataFimByLiberacaoDocumental( $this->that, $oLiberacaoDocumental, 2 );
            $oLiberacoesDocumentais[$key]->faturamentos = LiberacoesDocumental::haveFaturamento( $this->that, $oLiberacaoDocumental->id );
        }

        return $oLiberacoesDocumentais;
    }

    public function getOSServexecsNaoFaturados( $oLiberacaoDocumental )
    {
        $aReturn = OrdemServicoServexec::getServexecsByLiberacaoDocumental( $this->that, $oLiberacaoDocumental );
        $aServexecsIDs = $aReturn['ids'];
        $oServexecs    = $aReturn['objs'];
        $aDocMercs     = $aReturn['doc_mercs'];
        $aFaturamentoServexecsIDs = array();
        $oServexecsParaFaturar = array();

        if (!$aServexecsIDs)
            return [
                'servexecs_faturar' => [],
                'servexecs_base' => [],
                'doc_mercs' => []
            ];

        $oFaturamentoServicos = $this->that->FaturamentoServicos->find()
            ->contain('Faturamentos')
            ->where([
                'Faturamentos.liberacao_documental_id' => $oLiberacaoDocumental->id,
                'Faturamentos.count_dape_primario IS NOT NULL',
                'FaturamentoServicos.ordem_servico_servexec_id IN' => $aServexecsIDs
            ])
            ->toArray();

        foreach ($oFaturamentoServicos as $key => $oFaturamentoServico) 
            $aFaturamentoServexecsIDs[] = $oFaturamentoServico->ordem_servico_servexec_id;

        foreach ($oServexecs as $key => $oServexec) 
            if (!in_array($oServexec->id, $aFaturamentoServexecsIDs))
                $oServexecsParaFaturar[] = $oServexec;

        return [
            'servexecs_faturar' => $oServexecsParaFaturar,
            'servexecs_base' => $oServexecs,
            'doc_mercs' => $aDocMercs
        ];
    }

    public function gerarFaturamentoDAPE( $aServexecs, $aDocMercs, $oLiberacaoDocumental, $iBeneficiarioID )
    {
        $this->_Beneficiario = $iBeneficiarioID;
        $aRetorno = $this->getMercadoriasTratamentosDAPE( $aDocMercs );

        if (!isset($aRetorno['tratamentos']) || !isset($aRetorno['servicos'])) 
            return [
                'message' => __('Não foi possível localizar os tratamentos e/ou serviços dos itens liberados!'),
                'status'  => 406
            ];
            
        $aTratamentosIDs = $aRetorno['tratamentos'];

        $this->setLiberacaoDocumental( $oLiberacaoDocumental );

        $oTabelaPreco = $this->getTabelaPreco( $oLiberacaoDocumental, $aTratamentosIDs );

        if (!$oTabelaPreco) 
            return [
                'message' => __('Não foi possível localizar a Tabela de Preço!'),
                'status'  => 406
            ];
            
        $this->oTabelaPreco = $oTabelaPreco;

        $aServicosGerados = $this->gerarServicosDAPE( $oTabelaPreco, $aServexecs );

        $aFaturamentoGerado = $this->gerarFaturamentoArrayDAPE( $aServicosGerados );

        $iFaturamentoID = $this->insereFaturamento( $aFaturamentoGerado );
        $this->insereServicos( $aServicosGerados, $iFaturamentoID );
        
        return [
            'message'   => __('Faturamento foi gerado com sucesso!'),
            'dataExtra' => LgDbUtil::get('Faturamentos')->find()
                ->contain('FaturamentoServicos')
                ->where(['Faturamentos.id' => $iFaturamentoID])
                ->first()
                ->that,
            'status'    => 200
        ];
    }

    private function gerarFaturamentoArrayDAPE( $aServicosGerados )
    {
        $iValorArmazenagem = 0;
        $iValorServicos    = 0;
        $oTipoServicoBancario = $this->that->Empresas->find()
            ->contain('TipoServicoBancarios')
            ->where([
                'Empresas.id' => $this->oLiberacaoDocumental->cliente_id
            ])
            ->first();

        if (!isset($oTipoServicoBancario->tipo_servico_bancario)) 
            ErrorUtil::custom('Falta cadastrar o Tipo de Serviço Bancário do cliente (cadastro de empresas)!');
        
        foreach ($aServicosGerados as $key => $aServicoGerado) {
            $iValorServicos += $aServicoGerado['valor_total'];
        }
        
        return array(
            'numero_faturamento'       => '0',
            'data_hora_emissao'        => DateUtil::dateTimeToDB(date('Y-m-d H:i:s'), 'Y-m-d H:i:s', ''),
            'valor_armazenagem'        => 0,
            'valor_servicos'           => $iValorServicos,
            'tipo_servico_bancario_id' => $oTipoServicoBancario->tipo_servico_bancario->id,
            'liberacao_documental_id'  => $this->oLiberacaoDocumental->id,
            'tabela_preco_id'          => $this->oTabelaPreco->id,
            'regime_aduaneiro_id'      => $this->oLiberacaoDocumental->regime_aduaneiro_id,
            'cliente_id'               => $this->_Beneficiario ?: $this->oLiberacaoDocumental->cliente_id,
            'tipo_faturamento_id'      => 3, //DAPE
            'empresa_id'               => $this->that->getEmpresaAtual()
        );
    }

    public function gerarServicosDAPE( $oTabelaPreco, $aServexecs )
    {
        $aServicosServexecsIDs = array();
        foreach ($aServexecs as $key => $aServexec) {
            $aServicosServexecsIDs[] = $aServexec->servico_id;
        }

        $aServicos = array();
        $oServicos = $this->that->TabelasPrecosServicos->find()
            ->contain('SistemaCampos')
            ->where([
                'tabela_preco_id' => $oTabelaPreco->id,
                'servico_id IN'   => $aServicosServexecsIDs,
                'SistemaCampos.codigo LIKE' => '%SERVEXEC.%'

            ])
            ->all();
            
        foreach ($aServexecs as $key => $aServexec) { 
                            
            foreach ($oServicos as $key => $oServico) {
                
                if ($oServico->servico_id != $aServexec->servico_id)
                    continue;

                $aReturnValidacaoServ = $this->getValidacaoServ( $oServico );

                if ($aReturnValidacaoServ != 'sem_validacao' && $aReturnValidacaoServ->status != 200)
                    continue;

                $oServico->valor_total = TiposValore::calculaValorDinamico( $this->that, $oServico->valor, $oServico->valor_minimo, $oServico->tipo_valor_id, $aServexec, $oServico->campo_valor_sistema_id );
                
                $oServico->valor_total = ($oServico->desconto_percentual_serv > 0) 
                        ? $oServico->valor_total - (( $oServico->desconto_percentual_serv / 100 ) * $oServico->valor_total) 
                        : $oServico->valor_total;

                $oServico->valor_total = ($this->oTabelaPreco->desconto_percentual > 0) 
                        ? $oServico->valor_total - (( $this->oTabelaPreco->desconto_percentual / 100 ) * $oServico->valor_total)
                        : $oServico->valor_total;

                $oServico->valor_total = $oServico->valor_total < 0 ? 0 : $oServico->valor_total;

                $aServicos[] = array(
                    'quantidade'              => 1,
                    'valor_unitario'          => $oServico->valor,
                    'valor_total'             => $oServico->valor_total,
                    'tabela_preco_servico_id' => $oServico->id,
                    'ordem_servico_servexec_id' => $aServexec->id,
                    'faturamento_id'          => null,
                    'empresa_id'              => $this->that->getEmpresaAtual()
                );
            }
        }

        return $aServicos;
    }


    private function getMercadoriasTratamentosDAPE( $aDocMercs )
    {
        $aMercTrats = $this->that->OrdemServicos->find()
            ->select([
                'DocumentosMercadorias.tratamento_carga_id',
                'Servicos.id'
            ])            
            ->innerJoinWith('DocumentosMercadorias')
            ->innerJoinWith('OrdemServicoServexecs', function ($q) {
                return $q
                    ->innerJoinWith('Servicos', function ($q) {
                        return $q;
                    })
                    ->where([
                        'OrdemServicoServexecs.data_hora_fim IS NOT NULL'
                    ]);
            })          
            ->where([
                'DocumentosMercadorias.id IN' => $aDocMercs,
                'OrdemServicos.data_hora_fim IS NOT NULL',
                'cancelada = 0'
            ])
            ->toArray();

        if (!$aMercTrats)
            return false;

        $aTratamentosIDs = array();
        $aServicosIDs = array();

        foreach ($aMercTrats as $key => $aMercTrat) {
            if (!in_array($aMercTrat->_matchingData['DocumentosMercadorias']->tratamento_carga_id, $aTratamentosIDs))
                $aTratamentosIDs[] = $aMercTrat->_matchingData['DocumentosMercadorias']->tratamento_carga_id;
            
            if (!in_array($aMercTrat->_matchingData['Servicos']->id, $aServicosIDs))
                $aServicosIDs[] = $aMercTrat->_matchingData['Servicos']->id;
        }

        return [
            'tratamentos' => $aTratamentosIDs,
            'servicos'    => $aServicosIDs
        ];
    }

    public function getFaturamentoByServexecs( $aServexecs )
    {
        $aServexecsIDs = array();
        foreach ($aServexecs as $key => $aServexec) {
            $aServexecsIDs[] = $aServexec->id;
        }
        
        $oFaturamento = $this->that->Faturamentos->find()
            ->contain([
                'FaturamentoServicos' => function ($q) use($aServexecsIDs) {
                    return $q->where([
                        'FaturamentoServicos.ordem_servico_servexec_id IN' => $aServexecsIDs
                    ]);
                }
            ])
            ->first()
            ->that;

        return [
            'message' => __('Já foi gerado um faturamento para essas OS!'),
            'dataExtra' => $oFaturamento,
            'status' => 201
        ];
    }

    public function getOSServexecsFaturamento( $aDocumentosMercadoriasIDs )
    {
        $aRetorno = array();
        $aData = [
            'doc_mercs_ids' => $aDocumentosMercadoriasIDs,
            'that' => $this->that
        ];

        $aFaturamentoIDs = $this->getFaturamentosIDsDocMercs( $aData );
        
        $aFaturamentos = $this->that->Faturamentos->find()
            ->contain([
                'FaturamentoServicos',
                'FaturamentoServicos.OrdemServicoServexecs',
                'FaturamentoServicos.OrdemServicoServexecs.Servicos',
                'FaturamentoServicos.OrdemServicoServexecs.OrdemServicos',
                'TiposFaturamentos',
                'Clientes'
            ])
            ->where([
                'Faturamentos.id IN' => $aFaturamentoIDs
            ])
            ->toArray();

        foreach ($aFaturamentos as $key => $aFaturamento) {
            $aRetorno[] = $aFaturamento->that;
        }
        
        return $aRetorno;
    }

    public function getFaturamentosIDsDocMercs( $aData )
    {
        
        $aData['doc_mercs_ids'] = explode(',', $aData['doc_mercs_ids']);
        
        $aIDs = array();
        $oFaturamentos = $this->that->Faturamentos->find()
            ->innerJoinWith('FaturamentoServicos', function ($q) use($aData) {
                return 
                    $q
                    ->innerJoinWith('OrdemServicoServexecs', function ($q) use($aData) {
                        return 
                            $q->innerJoinWith('OrdemServicos', function ($q) use($aData) {
                                return $q->where([
                                    'documentos_mercadoria_id IN' => $aData['doc_mercs_ids']
                                ]);
                            });
                    });
            })
            ->toArray();

        if (!$oFaturamentos)
            return array();

        foreach ($oFaturamentos as $key => $oFaturamento) {
            $id = $oFaturamento->that['id'];

            if (!in_array($id, $aIDs))
                $aIDs[] = $id;
        }
        
        return $aIDs;
    }

    public function getFaturamentoArrayTabelaDAPE( $iFaturamentoID, $isDapeSemCarga = false )
    {
        $aFaturamentoTable = array();
        $aFaturamentos = array();
        
        if ($isDapeSemCarga)
            $aContainComplement = [
                'FaturamentoServicos' => ['Servicos']
            ];
        else 
            $aContainComplement = [
                'FaturamentoServicos' => [
                    'DocumentosMercadorias' => 'TipoDocumentos',
                    'LeftServicos'
                ],
                'FaturamentoServicos.OrdemServicoServexecs',
                'FaturamentoServicos.OrdemServicoServexecs.LeftOrdemServicos',
                'FaturamentoServicos.OrdemServicoServexecs.LeftOrdemServicos.DocumentosMercadorias',
                'FaturamentoServicos.OrdemServicoServexecs.LeftOrdemServicos.DocumentosMercadorias.TipoDocumentos',
                'FaturamentoServicos.OrdemServicoServexecs.LeftServicos',
            ];

        $oFaturamentos = $this->that->Faturamentos->find()
            ->contain([
                'TiposFaturamentos',
                'TipoServicoBancarios',
                'Clientes',
                'TabelasPrecos',
            ] + $aContainComplement)
            ->where([
                'Faturamentos.id' => $iFaturamentoID
            ])
            ->toArray();

        foreach ($oFaturamentos as $key => $oFaturamento) {
            $aFaturamentos[] = (object) $oFaturamento->that; 
        }

        foreach ($aFaturamentos as $keyFatu => $aFaturamento) {
            $dTotalServicos = 0;
            $oEmpresaMaster = $this->that->Empresas->get( $this->that->getEmpresaAtual() );

            $sNumeroDocumentoArrecadacaoFormatado = UniversalCodigoUtil::getNumeroDocumentoArrecadacao($aFaturamento);
            $sNumeroDocumentoArrecadacao = str_replace('.', '', $sNumeroDocumentoArrecadacaoFormatado);

            $sNossoNumero = $aFaturamento->tipo_faturamento_id;
            $sNossoNumero .= $sNumeroDocumentoArrecadacao;
            
            //$sNossoNumero = $aFaturamento->numero_faturamento;

            $aFaturamentoTable[$keyFatu] = array(
                'faturamento_object'        => $aFaturamento,
                'numero_documento_arrecadacao' => $sNumeroDocumentoArrecadacaoFormatado,
                'faturamento_id'            => $aFaturamento->id,
                'tipo_faturamento'          => $aFaturamento->tipos_faturamento->descricao,
                'numero_faturamento'        => $aFaturamento->numero_faturamento,
                'data_emissao'              => $aFaturamento->data_hora_emissao->format('d/m/Y H:i:s'),
                'beneficiario'              => $aFaturamento->cliente->descricao,
                'cliente'                   => $aFaturamento->cliente,
                'empresa_master'            => $oEmpresaMaster,
                'tabela_preco'              => $aFaturamento->tabelas_preco->descricao,
                'count_dape_primario'       => $aFaturamento->count_dape_primario,
                'count_dape_secundario'     => $aFaturamento->count_dape_secundario,
                'count_dapesc_primario'     => $aFaturamento->count_dapesc_primario,
                'count_dapesc_secundario'   => $aFaturamento->count_dapesc_secundario,
                'tipo_servico_bancario'     => $aFaturamento->tipo_servico_bancario,
                'observacao'                => $aFaturamento->observacao,
                'infos_codigo_barra_boleto' => [
                    'IDEN_PRODUTO'        => ParametroGeral::getParametro( $this->that, 'FATU_COD_BARRA_IDEN_PRODUTO')->valor ?: 8,
                    'IDEN_SEGMENTO'       => ParametroGeral::getParametro( $this->that, 'FATU_COD_BARRA_IDEN_SEGMENTO')->valor ?: 6,
                    'IDEN_VALOR_REAL_REF' => ParametroGeral::getParametro( $this->that, 'FATU_COD_BARRA_IDEN_VALOR_REAL_REF')->valor ?: 7,
                    'AGENCIA_UNIDADE_PTN' => ParametroGeral::getParametro( $this->that, 'AGENCIA_UNIDADE_PTN')->valor ?: 0,
                    'CONTA_CORRENTE_UNIDADE_PTN' => ParametroGeral::getParametro( $this->that, 'CONTA_CORRENTE_UNIDADE_PTN')->valor ?: 0,
                    'DESCRICAO_BOLETO_DAPE_UNIDADE_PTN' => ParametroGeral::getParametro( $this->that, 'DESCRICAO_BOLETO_DAPE_UNIDADE_PTN')->valor ?: 0,
                    'CNPJ_MASTER'         => substr($oEmpresaMaster->cnpj, 0, 8),
                    'CNPJ_MASTER_COMPLETO' => $oEmpresaMaster->cnpj,
                    'CODIGO_EMPRESA'      => $oEmpresaMaster->codigo,
                    'NOSSO_NUMERO'        => $sNossoNumero
                ]
            ); 

            foreach ($aFaturamento->faturamento_servicos as $key => $aServicos) {

                if ($aServicos->ordem_servico_servexec){
                    $servico = $aServicos->ordem_servico_servexec->servico->id . ' - ' . $aServicos->ordem_servico_servexec->servico->descricao;
                    $sDocumento = 
                        @$aServicos->ordem_servico_servexec->ordem_servico
                            ->documentos_mercadoria->numero_documento . ' - ' . 
                        @$aServicos->ordem_servico_servexec->ordem_servico
                            ->documentos_mercadoria->tipo_documento->descricao;
                    $inicio = @$aServicos->ordem_servico_servexec->data_hora_inicio;
                    $fim = @$aServicos->ordem_servico_servexec->data_hora_fim;
                    
                }else{
                    $servico = @$aServicos->servico->id . ' - ' . @$aServicos->servico->descricao;
                    $sDocumento = @$aServicos->documentos_mercadoria->numero_documento . ' - ' .
                        @$aServicos->documentos_mercadoria->tipo_documento->descricao;
                    $inicio = @$aFaturamento->data_hora_emissao;
                    $fim = @$aFaturamento->data_hora_emissao;
                }

                $aFaturamentoTable[$keyFatu]['linha_servicos'][] = array(
                    'servico'          => $servico,
                    'quantidade'       => $aServicos->quantidade,
                    'valor_unitario'   => $aServicos->valor_unitario,
                    'ficha'            => @$aServicos->ordem_servico_servexec->id . ' - ' . $aServicos->id,
                    'data_hora_inicio' => $inicio ? $inicio->format('d/m/Y H:i:s') : $inicio, 
                    'data_hora_fim'    => $fim ? $fim->format('d/m/Y H:i:s') : $fim, 
                    'observacao'       => @$aServicos->ordem_servico_servexec->ordem_servico->observacao,
                    'documento_mercadoria_numero_tipo' => $sDocumento,
                    'valor'            => $aServicos->valor_total
                );
                
                $dTotalServicos += $aServicos->valor_total;
            }
            
            $aFaturamentoTable[$keyFatu]['total_servicos'] = $dTotalServicos;
            $aFaturamentoTable[$keyFatu]['retencao'] = $aFaturamento->retencao;
            $aFaturamentoTable[$keyFatu]['valor_retencao'] = $aFaturamento->valor_retencao;
        }

        return $aFaturamentoTable;
    }

    public function podeGerarComplementar( $iFaturamentoID )
    {
        $oResponse = new ResponseUtil();

        if(empty($iFaturamentoID))
            return $oResponse->setMessage('Esse faturamento não existe!');
        
        $oFaturamento = LgDbUtil::getFirst('Faturamentos', ['id' => $iFaturamentoID]);

        if (!$oFaturamento)
            return $oResponse->setMessage('Esse faturamento não existe!');

        return $oResponse->setMessage('OK')->setStatus(200);

        // $aTeveAlgumaBaixa = $oFaturamentoBaixa->teveAlgumaBaixa( $this->that, $iFaturamentoID );
        // $oBaixaViaRetorno = @$aTeveAlgumaBaixa['oBaixaViaRetorno'];
        // $oBaixaViaManual  = @$aTeveAlgumaBaixa['oBaixaViaManual'];

        
        // if ($oBaixaViaRetorno && !$oBaixaViaManual || !$oBaixaViaRetorno && $oBaixaViaManual) 
        //     $oBaixa = $oBaixaViaRetorno ?: $oBaixaViaManual;
        // elseif ($oBaixaViaRetorno && $oBaixaViaManual) 
        //     if ($oBaixaViaRetorno->data_baixa < $oBaixaViaManual->data_baixa )          
        //         $oBaixa = $oBaixaViaManual;
        //     elseif ($oBaixaViaRetorno->data_baixa > $oBaixaViaManual->data_baixa)
        //         $oBaixa = $oBaixaViaRetorno;
        //     elseif ($oBaixaViaRetorno->id > $oBaixaViaManual->id)
        //         $oBaixa = $oBaixaViaRetorno;
        //     else 
        //         $oBaixa = $oBaixaViaManual;
           
        // if ($oBaixa) 
        //     if ($oBaixa->data_baixa < date('Y-m-d H:i:s'))
        //         return true;
        // else 
        //     return false;
    }

    public function gerarComplementar($iFaturamentoID)
    {
        $oFaturamento = $this->that->Faturamentos->get($iFaturamentoID);
        $oFaturamentoBaixa = new FaturamentoBaixa;
        
        return $this->gerarFaturamento(
            $oFaturamento->that['liberacao_documental_id'], 
            'complementar', 
            $iFaturamentoID 
        );        
    }

    public function gerarDapeSemCarga($aServicosGerados, $iValorTotal, $iTipoFaturamentoId = null, $aExtras = [])
    {
        $oResponse = new ResponseUtil();
        $aFaturamentoGerado = $this->gerarFaturamentoDapeSemCarga(
            $aServicosGerados, $iValorTotal, $iTipoFaturamentoId, $aExtras
        );
        
        $iFaturamentoID = $this->insereFaturamento($aFaturamentoGerado);
        $this->insereServicos($aServicosGerados, $iFaturamentoID);

        $oResponse->setMessage('OK');
        $oResponse->setStatus(200);
        $oResponse->setDataExtra([
            'faturamento_id' => $iFaturamentoID
        ]);

        return $oResponse;
    }

    public function gerarFaturamentoDapeSemCarga($aServicosGerados, $iValorTotal, $iTipoFaturamentoId = null, $aExtras = [])
    {
        $fRetencao = $aExtras['retencao'];
        $fValorRetencao = $aExtras['valor_retencao'];
        $iValorArmazenagem  = 0;
        $iValorServicos     = $iValorTotal;
        $iTipoFaturamentoId = $iTipoFaturamentoId?:4; 
        $iClienteID         = $aServicosGerados[ array_keys($aServicosGerados)[0] ]['cliente_id'];
        $oTipoServicoBancario = $this->that->Empresas->find()
            ->contain('TipoServicoBancarios')
            ->where([
                'Empresas.id' => $iClienteID
            ])
            ->first();
            
        if (!isset($oTipoServicoBancario->tipo_servico_bancario))
            ErrorUtil::custom('Falta cadastrar o Tipo de Serviço Bancário do cliente (cadastro de empresas)!');

        return array(
            'numero_faturamento'       => '0',
            'data_hora_emissao'        => DateUtil::dateTimeToDB(date('Y-m-d H:i:s'), 'Y-m-d H:i:s', ''),
            'valor_armazenagem'        => $iValorArmazenagem,
            'valor_servicos'           => $iValorServicos,
            'tipo_servico_bancario_id' => $oTipoServicoBancario->tipo_servico_bancario->id,
            'liberacao_documental_id'  => null,
            'cliente_id'               => $iClienteID,
            'tabela_preco_id'          => @$aServicosGerados[key($aServicosGerados)]['tabela_preco_id']?:null,
            'regime_aduaneiro_id'      => @$aServicosGerados[key($aServicosGerados)]['regime_aduaneiro_id']?:null,
            'observacao'               => @$aServicosGerados[key($aServicosGerados)]['observacao']?:null,
            'tipo_faturamento_id'      => $iTipoFaturamentoId, //DAPE Sem carga
            'empresa_id'               => $this->that->getEmpresaAtual(),
            'valor_retencao'           => $fValorRetencao,
            'retencao'                 => $fRetencao
        );
    }

    public function validaEstorno($iFaturamentoID)
    {
        $oResponse = new ResponseUtil;
        $oFaturamentoBaixa = new FaturamentoBaixa;
        $oFaturamento = LgDbUtil::get('Faturamentos')->find()->where(['id' => $iFaturamentoID])->first();

        if (!$oFaturamento){ 
            return $oResponse->setMessage('Esse Faturamento não existe!');
        }

        $oFaturamento = (object) $oFaturamento->that;

        $oLast = LgDbUtil::get('Faturamentos')
            ->find()
            ->where([
                'count_dai_primario IS'     => $oFaturamento->count_dai_primario,
                'count_dae_primario IS'     => $oFaturamento->count_dae_primario,
                'count_dape_primario IS'    => $oFaturamento->count_dape_primario,
                'count_dapesc_primario IS'  => $oFaturamento->count_dapesc_primario,
                'count_generic_primario IS'  => $oFaturamento->count_generic_primario,
            ])->order([
                'count_dai_secundario'      => 'DESC',
                'count_dae_secundario'      => 'DESC',
                'count_dape_secundario'     => 'DESC',
                'count_dapesc_secundario'   => 'DESC',
                'count_generic_primario'    => 'DESC',
            ])->first();

        if (!$oLast){ 
            return $oResponse->setMessage('Esse Faturamento não existe!');
        };

        $oLast = (object) $oLast->that;

        if(empty($oLast) || @$oFaturamento->id != @$oLast->id){
            return $oResponse->setMessage('Existe Faturamento(s) Complementar(es) derivados desse Faturamento.');
        }
        
        $oFaturamentoFechamentoItem = LgDbUtil::get('FaturamentoFechamentoItens')
            ->find()->where(['faturamento_id' => $iFaturamentoID])->first();

        if ($oFaturamentoFechamentoItem){ 
            return $oResponse->setMessage('Esse Faturamento está no fechamento!');
        }

        $aTeveAlgumaBaixa = $oFaturamentoBaixa->teveAlgumaBaixa( $this->that, $iFaturamentoID );

        if ($aTeveAlgumaBaixa){
            return $oResponse->setMessage('Já existe alguma baixa para esse faturamento!');
        }

        return $oResponse->setMessage('OK')->setStatus(200);
    }
    
}
