<?php
namespace App\Model\Entity;

use App\RegraNegocio\GerenciamentoEstoque\DecrementoEstoqueProdutos;
use App\RegraNegocio\GerenciamentoEstoque\IncrementoEstoqueProdutos;
use App\Util\DoubleUtil;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

class PlanejamentoMovimentacaoInterna extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getLastByResv($oResv)
    {
        $oResponse = new ResponseUtil();

        $oPlanejamentoMovimentacaoInterna = LgDbUtil::getFind('PlanejamentoMovimentacaoInternas')
            ->where([
                'PlanejamentoMovimentacaoInternas.resv_id'                => $oResv->id,
                'PlanejamentoMovimentacaoInternas.endereco_destino_id IS' => null,
            ])
            ->order(['PlanejamentoMovimentacaoInternas.id' => 'DESC'])
            ->first();

        if (!$oPlanejamentoMovimentacaoInterna)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não existe nenhum Planejamento de Movimentação Interna para essa Resv!');

        return $oResponse
            ->setStatus(200)
            ->setDataExtra($oPlanejamentoMovimentacaoInterna);
    }

    public static function setEndereco($oPlanejamentoMovimentacaoInterna, $iEnderecoID, $oResv)
    {
        $oResponse = new ResponseUtil();

        if ($oResv->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga'))
            $oPlanejamentoMovimentacaoInterna->endereco_destino_id = $iEnderecoID;
        else if ($oResv->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga')) 
            $oPlanejamentoMovimentacaoInterna->endereco_origem_id = $iEnderecoID;
        else if ($oResv->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Movimentação Interna')) 
            $oPlanejamentoMovimentacaoInterna->endereco_destino_id = $iEnderecoID;

        $oPlanejamentoMovimentacaoInterna = LgDbUtil::save('PlanejamentoMovimentacaoInternas', $oPlanejamentoMovimentacaoInterna, true);
        if ($oPlanejamentoMovimentacaoInterna->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao gravar o Endereço de Destino no Planejamento de Movimentações Internas!');

        return $oResponse
            ->setStatus(200);
    }

    public static function setByResv($iResvID, $iProgramacaoID)
    {
        $oResponse = new ResponseUtil();

        $iParamGerarMovimentacao = ParametroGeral::getParametroWithValue('PARAM_GERAR_PLANEJAMENTO_MOVIMENTACAO_INTERNA');
        if ($iParamGerarMovimentacao != 1)
            return $oResponse
                ->setStatus(200);

        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain([
                'ProgramacaoDocumentoTransportes',
                'ProgramacaoLiberacaoDocumentais',
            ])
            ->where([
                'Programacoes.id' => $iProgramacaoID
            ])->first();

        if ($oProgramacao->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Movimentação Interna'))
            return $oResponse
                ->setStatus(200);

        $aProdLote = self::getProdutoAndLoteFromDocumento($oProgramacao);

        $oPlanejamentoResponse = PlanejamentoMovimentacaoProduto::getByResv($oProgramacao, $aProdLote['produto_id']);
        $oPlanejamentoProduto  = $oPlanejamentoResponse->getDataExtra();

        if ($oPlanejamentoProduto) {
            $oResponse = self::checkVeiculos(null, $oPlanejamentoProduto->id, $iResvID);
            if ($oResponse->getStatus() != 200)
                return $oResponse;
        }

        return self::insert($oPlanejamentoProduto, $iResvID, $aProdLote);
    }

    private static function insert($oPlanejamentoProduto, $iResvID, $aProdLote, $iEnderecoID = null)
    {
        $oResponse = new ResponseUtil();

        $aDataInsert = [
            'planejamento_movimentacao_produto_id' => $oPlanejamentoProduto ? $oPlanejamentoProduto->id : null,
            'resv_id'                              => $iResvID,
            'endereco_origem_planejado_id'         => $oPlanejamentoProduto ? $oPlanejamentoProduto->endereco_origem_id : null,
            'endereco_destino_planejado_id'        => $oPlanejamentoProduto ? $oPlanejamentoProduto->endereco_destino_id : null,
            'lote_codigo'                          => $aProdLote['lote_codigo'],
            'produto_id'                           => $aProdLote['produto_id'],
            'endereco_origem_id'                   => $iEnderecoID,
        ];

        $oPlanejamentoInterna = LgDbUtil::saveNew('PlanejamentoMovimentacaoInternas', $aDataInsert, true);

        if ($oPlanejamentoInterna->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao gravar o Plano de Movimentação Interna!');
            
        return $oResponse
            ->setStatus(200);
    }

    public static function getProdutoAndLoteFromDocumento($oProgramacao)
    {
        if ($oProgramacao->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Descarga')) {

            $oHouse = LgDbUtil::getFind('DocumentosMercadorias')
                ->where([
                    'DocumentosMercadorias.documento_transporte_id'               => $oProgramacao->programacao_documento_transportes[0]->documento_transporte_id,
                    'DocumentosMercadorias.documento_mercadoria_id_master IS NOT' => null,
                ])
                ->first();
        
            $oDocMercItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
                ->where([
                    'DocumentosMercadoriasItens.documentos_mercadoria_id' => $oHouse->id
                ])
                ->first();

            return [
                'lote_codigo' => $oHouse->lote_codigo,
                'produto_id'  => $oDocMercItem->produto_id
            ];

        } else if ($oProgramacao->operacao_id == EntityUtil::getIdByParams('Operacoes', 'descricao', 'Carga')) {

            $oLiberacaoDocumental = LgDbUtil::getFind('LiberacoesDocumentais')
                ->contain(['LiberacoesDocumentaisItens'])
                ->where(['LiberacoesDocumentais.id' => $oProgramacao->programacao_liberacao_documentais[0]->liberacao_documental_id])
                ->first();

            return [
                'lote_codigo' => $oLiberacaoDocumental->liberacoes_documentais_item->lote_codigo,
                'produto_id'  => $oLiberacaoDocumental->liberacoes_documentais_item->produto_id
            ];

        }

        return false;
    }

    public static function managerMovimentacaoInterna($oResv, $iEnderecoID)
    {
        $oResponse = new ResponseUtil();

        $oResponse = self::getLastByResv($oResv);
        if ($oResponse->getStatus() == 200) {
            $oPlanejamentoMovimentacaoInterna = $oResponse->getDataExtra();

            $oResponse = self::checkVeiculos($oResv, $oPlanejamentoMovimentacaoInterna->planejamento_movimentacao_produto_id);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

            $oResponse = self::checkPesagens($oResv, $oPlanejamentoMovimentacaoInterna->planejamento_movimentacao_produto_id, true);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

            $oResponse = self::setEndereco($oPlanejamentoMovimentacaoInterna, $iEnderecoID, $oResv);
            if ($oResponse->getStatus() != 200)
                return $oResponse;

            return self::managerEstoques($oPlanejamentoMovimentacaoInterna, $iEnderecoID, $oResv);
        }

        $oPlanejamentoResponse = PlanejamentoMovimentacaoProduto::getByEnderecoOrigem($oResv, $iEnderecoID);
        if ($oPlanejamentoResponse->getStatus() != 200)
            return $oPlanejamentoResponse;

        $oPlanejamentoProduto = $oPlanejamentoResponse->getDataExtra();

        $oResponse = self::checkVeiculos($oResv, $oPlanejamentoProduto->id);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oResponse = self::checkPesagens($oResv, $oPlanejamentoProduto->id, false);
        if ($oResponse->getStatus() != 200)
            return $oResponse;
        
        $aProdLote = self::getProdutoAndLoteFromPlanejamentoProduto($oPlanejamentoProduto);

        return self::insert($oPlanejamentoProduto, $oResv->id, $aProdLote, $iEnderecoID);
    }

    private static function getProdutoAndLoteFromPlanejamentoProduto($oPlanejamentoProduto)
    {
        $DocMercItem = LgDbUtil::getFind('DocumentosMercadoriasItens')
            ->contain(['DocumentosMercadorias'])
            ->where(['DocumentosMercadoriasItens.produto_id' => $oPlanejamentoProduto->produto_id])
            ->order(['DocumentosMercadoriasItens.id' => 'DESC'])
            ->first();

        return [
            'lote_codigo' => $DocMercItem->documentos_mercadoria->lote_codigo,
            'produto_id'  => $DocMercItem->produto_id
        ];
    }

    private static function managerEstoques($oPlanejamentoMovimentacaoInterna, $iEnderecoID, $oResv)
    {
        $oResponse = new ResponseUtil();

        $oEstoqueEndereco = LgDbUtil::getFind('EstoqueEnderecos')
            ->where([
                'lote_codigo' => $oPlanejamentoMovimentacaoInterna->lote_codigo,
                'produto_id'  => $oPlanejamentoMovimentacaoInterna->produto_id,
                'endereco_id' => $oPlanejamentoMovimentacaoInterna->endereco_origem_planejado_id
            ])
            ->first();

        $iQuantidade = self::getQuantidadeByPesagens($oResv);
        if (!$iQuantidade)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Não foi possível encontrar o Peso de Entrada ou de Saída do Veículo!');

        $oResponse = self::setQtdeMovimentada($oPlanejamentoMovimentacaoInterna, $iQuantidade);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oResponse = self::decrementaEstoque($oEstoqueEndereco, $iQuantidade);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        $oResponse = self::incrementaEstoque($oEstoqueEndereco, $iQuantidade, $iEnderecoID);
        if ($oResponse->getStatus() != 200)
            return $oResponse;

        return $oResponse
            ->setStatus(200);
    }

    private static function setQtdeMovimentada($oPlanejamentoMovimentacaoInterna, $iQuantidade)
    {
        $oResponse = new ResponseUtil();

        $oPlanejamentoMovimentacaoInterna->qtde_movimentada = DoubleUtil::toDBUnformat($iQuantidade);
        
        $oPlanejamentoInterna = LgDbUtil::save('PlanejamentoMovimentacaoInternas', $oPlanejamentoMovimentacaoInterna, true);

        if ($oPlanejamentoInterna->hasErrors())
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Ocorreu um erro ao gravar a quantidade movimentada do Plano de Movimentação Interna!');
            
        return $oResponse
            ->setStatus(200);
    }

    private static function getQuantidadeByPesagens($oResv)
    {
        $oPesagem = LgDbUtil::getFind('Pesagens')
            ->contain(['PesagemVeiculoRegistros'])
            ->where(['Pesagens.resv_id' => $oResv->id])
            ->order(['Pesagens.id' => 'DESC'])
            ->first();

        $aPesagemData = [];
        foreach ($oPesagem->pesagem_veiculo_registros as $oPesagemVeiculoRegistro) {
            if ($oPesagemVeiculoRegistro->pesagem_tipo_id == EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Entrada'))
                $aPesagemData['peso_entrada'] = $oPesagemVeiculoRegistro->peso;
            else if ($oPesagemVeiculoRegistro->pesagem_tipo_id == EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Saída'))
                $aPesagemData['peso_saida'] = $oPesagemVeiculoRegistro->peso;
        }

        if (!$aPesagemData['peso_entrada'] || !$aPesagemData['peso_saida'])
            return null;

        return abs(($aPesagemData['peso_saida'] - $aPesagemData['peso_entrada']) / 1000);
    }

    private static function decrementaEstoque($oEstoqueEndereco, $iQuantidade)
    {
        $aProdutoReferencia = self::getProdutoReferencia($oEstoqueEndereco, $iQuantidade, $oEstoqueEndereco->endereco_id);
        return DecrementoEstoqueProdutos::manageRetiradaEstoque(
            $aProdutoReferencia, 
            false, 
            [
                'ignora_lote_documental' => false
            ]
        );
    }

    private static function incrementaEstoque($oEstoqueEndereco, $iQuantidade, $iEnderecoID)
    {
        $aProdutoReferencia = self::getProdutoReferencia($oEstoqueEndereco, $iQuantidade, $iEnderecoID);
        return IncrementoEstoqueProdutos::manageIncrementoEstoque(
            $aProdutoReferencia, 
            false, 
            [
                'movimentacao_tipo_id'  => EntityUtil::getIdByParams('TipoMovimentacoes', 'descricao', 'DESCARGA - ENTRADA'),
                'ignora_lote_documental' => false
            ]
        );
    }

    private static function getProdutoReferencia($oEstoqueEndereco, $iQuantidade, $iEnderecoID)
    {
        $aProdutosReferencias[] = [
            'conditions' => [
                'produto_id'        => $oEstoqueEndereco->produto_id,
                'lote'              => $oEstoqueEndereco->lote,
                'serie'             => $oEstoqueEndereco->serie,
                'validade'          => $oEstoqueEndereco->validade,
                'unidade_medida_id' => $oEstoqueEndereco->unidade_medida_id,
                'empresa_id'        => 1,
                'endereco_id'       => $iEnderecoID
            ],
            'order' => [
                'qtde' => 'ASC'
            ],
            'dataExtra' => [
                'status_estoque_id' => 1,
                'qtde'              => $iQuantidade,
                'peso'              => $iQuantidade,
                'm2'                => 0,
                'm3'                => 0,
                'lote_codigo'       => $oEstoqueEndereco->lote_codigo,
                'lote_item'         => $oEstoqueEndereco->lote_item,
                'container_id'      => null,
            ]
        ];

        return $aProdutosReferencias;
    }

    private static function checkPesagens($oResv, $iPlanejamentoMovimentacaoProdutoID, $bIsDescarga)
    {
        $oResponse = new ResponseUtil();

        $aPesagens['entrada'] = self::getPesagem($oResv, EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Entrada'));
        $aPesagens['saida']   = self::getPesagem($oResv, EntityUtil::getIdByParams('PesagemTipos', 'descricao', 'Saída'));

        if (!$aPesagens['entrada'])
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parece que o veiculo não possui uma Pesagem de Entrada!');

        if (!$bIsDescarga)
            return $oResponse->setStatus(200);

        if (!$aPesagens['saida'])
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parece que o veiculo não possui uma Pesagem de Saída!');

        return self::checkSolicitacaoPesagem($aPesagens, $iPlanejamentoMovimentacaoProdutoID);

    }

    private static function getPesagem($oResv, $iPesagemTipoID)
    {
        return LgDbUtil::getFind('PesagemVeiculoRegistros')
            ->innerJoinWith('Pesagens', function( $q ) use ( $oResv ) {
                return $q->where(['Pesagens.resv_id' => $oResv->id]);
            })
            ->where(['PesagemVeiculoRegistros.pesagem_tipo_id' => $iPesagemTipoID])
            ->order(['PesagemVeiculoRegistros.id' => 'DESC'])
            ->first();
    }

    private static function checkSolicitacaoPesagem($aPesagens, $iPlanejamentoMovimentacaoProdutoID)
    {
        $oResponse = new ResponseUtil();

        $oSolicitacaoPesagem = LgDbUtil::getFind('PlanejamentoSolicitacaoPesagens')
            ->where(['PlanejamentoSolicitacaoPesagens.planejamento_movimentacao_produto_id' => $iPlanejamentoMovimentacaoProdutoID])
            ->order(['PlanejamentoSolicitacaoPesagens.id' => 'DESC'])
            ->first();

        if (!$oSolicitacaoPesagem)
            return $oResponse->setStatus(200);

        if ($oSolicitacaoPesagem->data_hora_solicitacao > $aPesagens['saida']->created_at)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parece que existe uma solicitação de pesagem para esse veículo. Favor realizar pesagem no GATE!');

        return $oResponse->setStatus(200); 
    }

    public static function getByControleProducaoId($iControleProducaoID)
    {
        return LgDbUtil::getFind('PlanejamentoMovimentacaoInternas')
            ->contain([
                'Produtos',
                'EnderecoOrigem' => [
                    'Areas' => [
                        'Locais'
                    ]
                ],
                'EnderecoDestino' => [
                    'Areas' => [
                        'Locais'
                    ]
                ],
                'Resvs' => [
                    'Veiculos'
                ]
            ])
            ->innerJoinWith('PlanejamentoMovimentacaoProdutos', function ($q) use ($iControleProducaoID) {
                return $q->innerJoinWith('ControleProducoes', function ($q) use ($iControleProducaoID) {
                    return $q->where(['ControleProducoes.id' => $iControleProducaoID]);
                });
            })
            ->toArray();
    }
    
    public static function getByPlanejamentoMovimentacaoProdutoId($iPlanejamentoMovimentacaoProdutoID)
    {
        return LgDbUtil::getFind('PlanejamentoMovimentacaoInternas')
            ->contain([
                'Produtos',
                'EnderecoOrigem' => [
                    'Areas' => [
                        'Locais'
                    ]
                ],
                'EnderecoDestino' => [
                    'Areas' => [
                        'Locais'
                    ]
                ],
                'Resvs' => [
                    'Veiculos'
                ]
            ])
            ->innerJoinWith('PlanejamentoMovimentacaoProdutos', function ($q) use ($iPlanejamentoMovimentacaoProdutoID) {
                return $q->where(['PlanejamentoMovimentacaoProdutos.id' => $iPlanejamentoMovimentacaoProdutoID]);
            })
            ->toArray();
    }

    public static function checkVeiculos($oResv, $iPlanejamentoMovimentacaoProdutoID, $iResvID = null)
    {
        $oResponse = new ResponseUtil();

        if (!$oResv)
            $oResv = LgDbUtil::getByID('Resvs', $iResvID);

        $oPlanejamentoMovimentacaoVeiculo = LgDbUtil::getFind('PlanejamentoMovimentacaoVeiculos')
            ->where(['PlanejamentoMovimentacaoVeiculos.planejamento_movimentacao_produto_id' => $iPlanejamentoMovimentacaoProdutoID])
            ->first();

        if (!$oPlanejamentoMovimentacaoVeiculo)
            return $oResponse
                ->setStatus(200);

        $oPlanejamentoMovimentacaoVeiculo = LgDbUtil::getFind('PlanejamentoMovimentacaoVeiculos')
            ->where([
                'PlanejamentoMovimentacaoVeiculos.planejamento_movimentacao_produto_id' => $iPlanejamentoMovimentacaoProdutoID,
                'PlanejamentoMovimentacaoVeiculos.veiculo_id'                           => $oResv->veiculo_id
            ])
            ->first();

        if (!$oPlanejamentoMovimentacaoVeiculo)
            return $oResponse
                ->setStatus(400)
                ->setTitle('Ops!')
                ->setMessage('Parece que esse veículo não está liberado para esse Planejamento de Movimentação de Produtos!');

        return $oResponse
            ->setStatus(200);
    }

}
