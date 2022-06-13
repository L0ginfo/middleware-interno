<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\Faturamento;
use App\RegraNegocio\Faturamento\FaturamentoCorrentistas;
use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\Core\Configure;


/**
 * FaturamentoDape Entity
 *
 */
class FaturamentoDape extends Entity
{
    public function index($that, $bComCarga = false)
    {
        $that->paginate = ['limit' => 15];
        $aWhere = ['tipo_faturamento_id' => 4];
        $aMachtWhere = ['FaturamentoServicos.documento_mercadoria_id IS NULL'];

        $oFaturamentos = $that->Faturamentos->find()
            ->contain([
                'FaturamentoServicos' => [
                    'Servicos'
                ],
                'Clientes',
                'TipoServicoBancarios',
                'TabelasPrecos'
            ])
            ->distinct('Faturamentos.id')
            ->order('Faturamentos.id DESC');

        if($bComCarga){
            $aWhere = ['tipo_faturamento_id' => 3];
            $aMachtWhere = ['FaturamentoServicos.documento_mercadoria_id IS NOT NULL'];
        }

        $oFaturamentos->where($aWhere)->matching('FaturamentoServicos', function($q)use($aMachtWhere){
            return $q->where($aMachtWhere);
        });

        $oFaturamentos = $that->paginate($oFaturamentos);

        $that->set('_serialize', ['oFaturamentos']);
        $that->set('form_templates', Configure::read('Templates'));
        $that->set(compact('oFaturamentos'));
    }  

    public function gerar($that)
    {
        $oFaturamento = new Faturamento($that);

        if ($that->request->isPost()){
            $iTabelaPrecoID = $that->request->getData('tabela_preco_id');
            $iClienteID = $that->request->getData('cliente_id');
            $sObservacao = $that->request->getData('observacao');

            $oEmpresasRetencoes = LgDbUtil::getFirst('EmpresasRetencoes', [
                'empresa_id' => $iClienteID
            ]);

            $fRetencao = @$oEmpresasRetencoes->valor ?:0;

            $aServicosGerados = $that->request->getData('selected_servico');
            unset($aServicosGerados['__servico_increment__']);
            
            $aRetornoFormatado = $this->formatarServicos(
                $that, $iTabelaPrecoID, $iClienteID, $aServicosGerados, $sObservacao, $fRetencao
            );

            $oReturn = $oFaturamento->gerarDapeSemCarga($aRetornoFormatado['servicos'], $aRetornoFormatado['valor_total'], null, $aRetornoFormatado);

            if ($oReturn->status == 200) {
                self::gerarBaixaCorrentista($oReturn->getDataExtra());
                $that->Flash->success(__('Faturamento DAPE Sem carga Gerado com sucesso!'));
                return $that->redirect(['action' => 'dape-sem-carga', 'index']);
            }else {
                $that->Flash->error(__('Houve algum problema ao gerar o Faturamento DAPE Sem Carga!'));
            }
        }

        $oTabelasPrecos = $that->TabelasPrecos->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->where(['ativo' => 1])->toArray();
        $oClientes      = $that->Empresas->find('list', ['keyField' => 'id', 'valueField' => 'cnpj_descricao'])
            ->select([
                'id',
                'cnpj_descricao' => 'CONCAT(descricao, \' - \', cnpj)'
            ])
            ->toArray();

        $oServicos = $that->Servicos->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])->toArray();

        $that->set(compact(
            'oTabelasPrecos',
            'oClientes',
            'oServicos'
        ));
    }

    public function gerarComCarga($that)
    {
        $oFaturamento = new Faturamento($that);

        if ($that->request->isPost()){
            $iTabelaPrecoID = $that->request->getData('tabela_preco_id');
            $iClienteID = $that->request->getData('cliente_id');
            $sObservacao = $that->request->getData('observacao');
            $aServicosGerados = $that->request->getData('selected_servico');
            unset($aServicosGerados['__servico_increment__']);
            if(!empty($aServicosGerados)) {

                $oEmpresasRetencoes = LgDbUtil::getFirst('EmpresasRetencoes', [
                    'empresa_id' => $iClienteID
                ]);
    
                $fRetencao = @$oEmpresasRetencoes->valor ?:0;
            
                foreach ($aServicosGerados as $key => $value) {
                    $oMercadoria = LgDbUtil::getFirst('DocumentosMercadorias', [
                        'id' => $value['documento_mercadoria_id']
                    ]);

                    $aServicosGerados[$key]['regime_aduaneiro_id'] 
                        = @$oMercadoria->regimes_aduaneiro_id;
                }

                $aRetornoFormatado = $this->formatarServicos(
                    $that, $iTabelaPrecoID, $iClienteID, $aServicosGerados, $sObservacao, $fRetencao
                );

                $oReturn = $oFaturamento->gerarDapeSemCarga(
                    $aRetornoFormatado['servicos'], $aRetornoFormatado['valor_total'], 3, $aRetornoFormatado
                );

                if ($oReturn->status == 200) {
                    self::gerarBaixaCorrentista($oReturn->getDataExtra());
                    $that->Flash->success(__('Faturamento DAPE com carga Gerado com sucesso!'));
                    return $that->redirect(['action' => 'dape-com-carga', 'index']);
                }
            }

            $that->Flash->error(__('Houve algum problema ao gerar o Faturamento DAPE com Carga!'));
        }

        $oTabelasPrecos = $that->TabelasPrecos->find('list',[
            'keyField' => 'id', 'valueField' => 'descricao'
        ])->where(['ativo' => 1])->toArray();
            
        $oClientes      = $that->Empresas->find('list', [
            'keyField' => 'id', 'valueField' => 'cnpj_descricao'
        ])
        ->select([
            'id',
            'cnpj_descricao' => 'CONCAT(descricao, \' - \', cnpj)'
        ])->toArray();

        $oServicos = $that->Servicos->find('list', [
            'keyField' => 'id', 'valueField' => 'descricao'
        ])->toArray();

        $that->set(compact(
            'oTabelasPrecos',
            'oClientes',
            'oServicos'
        ));
    }
    
    public function formatarServicos($that, $iTabelaPrecoID, $iClienteID, $aServicosGerados, $sObservacao = null, $fRetencao = 0)
    {
        $iValorTotal = 0;
        $iValorRetencao = 0;

        foreach ($aServicosGerados as $key => $aServicoGerado) {
            $fQuantidade    = DoubleUtil::toDBUnformat($aServicoGerado['quantidade']);
            $fValorUnitario = DoubleUtil::toDBUnformat($aServicoGerado['valor_unitario']);
            $fValorTotal    = DoubleUtil::toDBUnformat($aServicoGerado['valor_total']);
            $fValorRetencao = $fValorTotal * ($fRetencao / 100);
            $aServicosGerados[$key]['retencao'] = $fRetencao; 
            $aServicosGerados[$key]['tabela_preco_id'] = $iTabelaPrecoID; 
            $aServicosGerados[$key]['cliente_id'] = $iClienteID;
            $aServicosGerados[$key]['observacao'] = $sObservacao?:null;
            $aServicosGerados[$key]['empresa_id'] = $that->getEmpresaAtual();
            $aServicosGerados[$key]['quantidade'] = $fQuantidade;
            $aServicosGerados[$key]['valor_unitario']   = round($fValorUnitario, 4);
            $aServicosGerados[$key]['valor_retencao']   = round($fValorRetencao, 2);
            $aServicosGerados[$key]['valor_total']      = round($fValorTotal, 2);
            $iValorTotal    += ($fValorTotal - $fValorRetencao);
            $iValorRetencao += $fValorRetencao;
        }

        return [
            'servicos'          => $aServicosGerados, 
            'valor_total'       => $iValorTotal, 
            'valor_retencao'    => $iValorRetencao,
            'retencao'          => $fRetencao
        ];

    }

    public static function gerarBaixaCorrentista($aData){
        $iFaturamentoID = $aData['faturamento_id'];
        return FaturamentoCorrentistas::baixarFaturamentoDape($iFaturamentoID);
    }
}
