<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use App\Util\SessionUtil;
use Cake\ORM\Entity;

/**
 * LiberacaoDocumentalTransportadora Entity
 *
 * @property int $id
 * @property int $transportadora_id
 * @property int $liberacao_documental_id
 * @property \Cake\I18n\Time|null $data_fim_retirada
 * @property \Cake\I18n\Time|null $data_inicio_retirada
 * @property string|null $tolerancia
 * @property string|null $numero_pedido
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Transportadora $transportadora
 * @property \App\Model\Entity\LiberacoesDocumental $liberacoes_documental
 * @property \App\Model\Entity\LiberacaoDocumentalTransportadoraItem[] $liberacao_documental_transportadora_itens
 */
class LiberacaoDocumentalTransportadora extends Entity
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
     /* Default fields

        'transportadora_id' => true,
        'liberacao_documental_id' => true,
        'data_fim_retirada' => true,
        'data_inicio_retirada' => true,
        'tolerancia' => true,
        'numero_pedido' => true,
        'created_at' => true,
        'updated_at' => true,
        'transportadora' => true,
        'liberacoes_documental' => true,
        'liberacao_documental_transportadora_itens' => true,

     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getCarregamentoPorVeiculos($iLiberacaoDocumentalTranspID)
    {
        $aResvs = self::queryResvs(null, $iLiberacaoDocumentalTranspID);

        foreach ($aResvs as $oResv) {
            $oResv->peso_carga = 0;
            $oResv->peso_liquido = 0;
            $oResv->peso_entrada = 0;
            $oResv->peso_saida = 0;
            $oResv->ordem_servicos = [];
            $aPesagemData = [
                'peso_entrada' => 0.0,
                'peso_saida'   => 0.0,
            ];

            foreach ($oResv->resvs_liberacoes_documentais as $oResvLiberacaoDocumental) {
                $oResv->ordem_servicos[0] = $oResvLiberacaoDocumental->ordem_servico;
                foreach ($oResvLiberacaoDocumental->ordem_servico->ordem_servico_carregamentos as $oOrdemServicoCarregamento) {
                    $oResv->peso_carga += $oOrdemServicoCarregamento->quantidade_carregada * 1000;
                }
            }

            foreach ($oResv->pesagens as $oPesagem) {
                foreach ($oPesagem->pesagem_veiculos as $oPesagemVeiculo) {
                    foreach ($oPesagemVeiculo->pesagem_veiculo_registros as $oPesagemVeiculoRegistros) {
                        if ($oPesagemVeiculoRegistros->pesagem_tipo_id == 1)
                            $aPesagemData['peso_entrada'] = $oPesagemVeiculoRegistros->peso;
                        elseif ($oPesagemVeiculoRegistros->pesagem_tipo_id == 2)
                            $aPesagemData['peso_saida'] = $oPesagemVeiculoRegistros->peso;
                    }
                    $oResv->peso_liquido += $aPesagemData['peso_entrada'] && $aPesagemData['peso_saida']
                        ? abs($aPesagemData['peso_entrada'] - $aPesagemData['peso_saida']) / 1000
                        : 0;
                }
            }
        }

        return $aResvs;
    }

    public static function queryResvs($iLiberacaoDocumentalID = null, $iLiberacaoDocumentalTranspID = null)
    {

        if (!$iLiberacaoDocumentalID) {

            $oLiberacaoDocumentalTransp = LgDbUtil::getByID('LiberacaoDocumentalTransportadoras', $iLiberacaoDocumentalTranspID);
            $iLiberacaoDocumentalID = $oLiberacaoDocumentalTransp->liberacao_documental_id;
        }

        $aResvs = LgDbUtil::getFind('Resvs')
            ->distinct('Resvs.id')
            ->contain([
                'ResvsLiberacoesDocumentais' => function($q) use($iLiberacaoDocumentalID, $iLiberacaoDocumentalTranspID) {

                    if ($iLiberacaoDocumentalID)
                        $q = $q->where([
                            'ResvsLiberacoesDocumentais.liberacao_documental_id' => $iLiberacaoDocumentalID
                        ]);

                    if ($iLiberacaoDocumentalTranspID)
                        $q = $q->where([
                            'ResvsLiberacoesDocumentais.liberacao_documental_transportadora_id' => $iLiberacaoDocumentalTranspID
                        ]);

                    $q = $q->contain([
                        'OrdemServicos' => [
                            'OrdemServicoCarregamentos' => function($x) use($iLiberacaoDocumentalID) {
                                $x = $x->where([
                                    'OrdemServicoCarregamentos.liberacao_documental_id' => $iLiberacaoDocumentalID
                                ]);

                                return $x;
                            }
                        ]
                    ]);

                    return $q;
                },
                'Veiculos',
                'Pessoas',
                'Transportadoras',
                'Pesagens' => [
                    'PesagemVeiculos' => [
                        'PesagemVeiculoRegistros' => function($q) {
                            return $q
                                ->where([
                                    'PesagemVeiculoRegistros.pesagem_tipo_id IN' => [1,2]
                                ])
                                ->order([
                                    'PesagemVeiculoRegistros.pesagem_tipo_id' => 'ASC',
                                    'PesagemVeiculoRegistros.id' => 'DESC'
                                ]);
                        }
                    ]
                ]
            ])
            ->matching('ResvsLiberacoesDocumentais', function($q) use($iLiberacaoDocumentalID, $iLiberacaoDocumentalTranspID) {

                if ($iLiberacaoDocumentalID)
                    $q->where([
                        'ResvsLiberacoesDocumentais.liberacao_documental_id' => $iLiberacaoDocumentalID
                    ]);

                if ($iLiberacaoDocumentalTranspID)
                    $q->where([
                        'ResvsLiberacoesDocumentais.liberacao_documental_transportadora_id' => $iLiberacaoDocumentalTranspID
                    ]);

                return $q;
            })
            ->where()
            ->toArray();
        
        return $aResvs;
    }

    public static function getFilters()
    {
        return [
            [
                'name'  => 'li',
                'divClass' => 'col-lg-2',
                'label' => 'Liberação',
                'table' => [
                    'className' => 'LiberacaoDocumentalTransportadoras',
                    'field'     => 'numero_liberacao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'transp',
                'divClass' => 'col-lg-2',
                'label' => 'Transportadora',
                'table' => [
                    'className' => 'Transportadoras',
                    'field'     => 'razao_social',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }

    public static function verifyIfExistByNumber($iLiberacaoDocumentalID, $sNumber)
    {
        $aLiberacaoDocumentalTransp = LgDbUtil::getFirst('LiberacaoDocumentalTransportadoras', [
             'liberacao_documental_id' => $iLiberacaoDocumentalID,
             'numero_liberacao' => $sNumber
        ]);

        if (!$aLiberacaoDocumentalTransp)
            return false;

        return true;
    }

    public function duplicate($oOldLiberacaoDocumental,
    $oNewLiberacaoDocumental, $iQuantidade = 0){
        $oThat = $this;
        $oRespose = (new ResponseUtil())->setStatus(200);

        if(empty($oOldLiberacaoDocumental) || empty($oNewLiberacaoDocumental)){
            return $oRespose
                ->setStatus(400)
                ->setMessage(__('Falha ao localizar a') . __('liberacao documental'));
        }

        if($oOldLiberacaoDocumental->cliente_id != $oNewLiberacaoDocumental->cliente_id ){
            return $oRespose
                ->setStatus(400)
                ->setMessage(__('Falha ao duplicar, clientes são diferentes.'));
        }

        $oNewLiberacaoTransporte =
            LgDbUtil::getFirst('LiberacaoDocumentalTransportadoras',[
                'liberacao_documental_id' => $oNewLiberacaoDocumental->id,
                'transportadora_id' => $this->transportadora_id,
                'numero_liberacao' => $this->numero_liberacao
            ]);

        if ($oNewLiberacaoTransporte) 
            return $oRespose
                ->setStatus(400)
                ->setMessage('Já existe uma Liberação com o mesmo número cadastrado para este documento!');

        if(empty($oNewLiberacaoTransporte)){
            $aDataTransporte = $this->toArray();
            unset($aDataTransporte['id']);
            unset($aDataTransporte['created_at']);
            $aDataTransporte['liberacao_documental_id'] =
                $oNewLiberacaoDocumental->id;
            $oNewLiberacaoTransporte =
                LgDbUtil::saveNew('LiberacaoDocumentalTransportadoras',
                    $aDataTransporte, true);
        }

        if(empty($oNewLiberacaoTransporte)){
            return $oRespose
                ->setStatus(400)
                ->setMessage( __('Falha ao duplicar a') . __('liberacao documental transportadora'));
        }

        $aLiberacaoDocumentalItens =
            LgDbUtil::getFind('LiberacoesDocumentaisItens')
            ->contain(
                [
                    'Produtos',
                    'LiberacaoDocumentalTransportadoraItens' =>
                    function($q) use($oThat){
                    return $q->where([
                        'liberacao_documental_transportadora_id'
                            => $oThat->id
                    ]);
                }
            ])
            ->matching('LiberacaoDocumentalTransportadoraItens' ,
                function($q) use($oThat){
                return $q->where([
                    'liberacao_documental_transportadora_id'
                        => $oThat->id
                ]);
            })
            ->where([
                'LiberacoesDocumentaisItens.liberacao_documental_id'
                    => $oOldLiberacaoDocumental->id
            ])
            ->toArray();
        
        $aLiberacaoDocumentalItemErros = [];
        $aLiberacaoDocumentalItemTransportadoras = [];
        foreach ($aLiberacaoDocumentalItens as $oLiberacaoDocumentalItem) {

            $aLibDocTransItens =
                @$oLiberacaoDocumentalItem
                    ->liberacao_documental_transportadora_itens;

            $oNewLiberacaoDocumentalItem =
                self::getFirstLibDocItensDuplicated(
                    $oNewLiberacaoDocumental, $oLiberacaoDocumentalItem);

            if(empty($oNewLiberacaoDocumentalItem)){
                $oRespose
                ->setMessage('')
                ->setStatus(400);
                $sDocumento = "Documento: $oNewLiberacaoDocumental->numero";
                $sProduto = 
                    isset($oLiberacaoDocumentalItem->produto) ?
                    'e Produto: '.
                    $oLiberacaoDocumentalItem
                        ->produto
                        ->codigo .' - '.
                    $oLiberacaoDocumentalItem
                        ->produto
                        ->descricao : '';

                array_push($aLiberacaoDocumentalItemErros, 
                    "Liberação Documental Item não encontrada para o $sDocumento $sProduto"
                );
                
                continue;
            }

            if(!empty($aLibDocTransItens)){
                foreach ($aLibDocTransItens as $oLibDocTransItem) {

                    $oNewLibDocTransItem =
                        self::getFirstLibDocTransItensDuplicated(
                            $oNewLiberacaoTransporte, $oNewLiberacaoDocumentalItem);

                    if(empty($oNewLibDocTransItem)){
                        $aDataLibDocTransItem =
                            $oLibDocTransItem->toArray();
                        unset($aDataLibDocTransItem['id']);
                        unset($aDataLibDocTransItem['created_at']);
                        $aDataLibDocTransItem[
                            'liberacao_documental_transportadora_id'] =
                                $oNewLiberacaoTransporte->id;
                        $aDataLibDocTransItem[
                            'liberacao_documental_item_id'] =
                                $oNewLiberacaoDocumentalItem->id;
                        $aDataLibDocTransItem[
                            'quantidade_liberada'] = $iQuantidade;
                        $oNewLibDocTransItem =
                            LgDbUtil::saveNew(
                            'LiberacaoDocumentalTransportadoraItens',
                                $aDataLibDocTransItem, true);
                    }

                    if(empty($oNewLibDocTransItem)){

                        $oRespose
                            ->setMessage('')
                            ->setStatus(400);
                            
                        $sDocumento =   
                            "Documento: $oNewLiberacaoTransporte->numero";
                        $sProduto = 
                            isset($oLiberacaoDocumentalItem->produto) ?
                            'e Produto: '.
                            $oLiberacaoDocumentalItem
                                ->produto
                                ->codigo .' - '.
                            $oLiberacaoDocumentalItem
                                ->produto
                                ->descricao : '';

                        array_push($aLiberacaoDocumentalItemTransportadoras, 
                            "Falha ao duplicar o Item da Liberação Documental Transportadoras $sDocumento $sProduto"
                        );
                    }
                }
            }

        }

        return $oRespose
            ->setDataExtra([
                'LiberacaoTransporteID' => $oNewLiberacaoTransporte->id
            ])
            ->setError(
                $aLiberacaoDocumentalItemErros+$aLiberacaoDocumentalItemTransportadoras
            );
    }


    public static function getFirstLibDocItensDuplicated(
        $oNewLiberacaoDocumental,$oLiberacaoDocumentalItem){

        return LgDbUtil::getFirst('LiberacoesDocumentaisItens', [
            'liberacao_documental_id' => $oNewLiberacaoDocumental->id,
            'regime_aduaneiro_id is' => $oLiberacaoDocumentalItem
                ->regime_aduaneiro_id,
            'tabela_preco_id is' => $oLiberacaoDocumentalItem
                ->tabela_preco_id,
            'lote is' => $oLiberacaoDocumentalItem
                ->lote,
            'validade is' => $oLiberacaoDocumentalItem
                ->validade,
            'unidade_medida_id is' => $oLiberacaoDocumentalItem
                ->unidade_medida_id,
            'endereco_id is' => $oLiberacaoDocumentalItem
                ->endereco_id,
            'empresa_id is' => $oLiberacaoDocumentalItem
                ->empresa_id,
            'container_id is' => $oLiberacaoDocumentalItem
                ->container_id,
            'liberacao_por_produto is' => $oLiberacaoDocumentalItem
                ->liberacao_por_produto
        ]);
    }
    public static function getFirstLibDocTransItensDuplicated(
        $oNewLiberacaoTransporte, $oNewLiberacaoDocumentalItem){
        return LgDbUtil::getFirst('LiberacaoDocumentalTransportadoraItens', [
            'liberacao_documental_transportadora_id' =>
                $oNewLiberacaoTransporte->id,
            'liberacao_documental_item_id' => 
                $oNewLiberacaoDocumentalItem->id
        ]);
    }

    public static function acessoRestrito(){

        $iPerfilId = SessionUtil::getPerfilUsuario();

        $aParameter = json_decode(
            ParametroGeral::getParametroWithValue(
                'PARAM_PERFIS_RESTRITOS_ViSUALIZACAO_POR_TRANSPORTADORA'), true);

        if(empty($aParameter)){
            return false;
        }    

        return in_array($iPerfilId, @$aParameter['perfis']);

    }
}
