<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\DoubleUtil;
use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * LiberacaoDocumentalDecisaoTabelaPrecoAdicao Entity
 *
 * @property int $id
 * @property string $numero
 * @property int|null $liberacao_documental_decisao_tabela_preco_id
 * @property int|null $liberacao_documental_id
 * @property int|null $regime_aduaneiro_id
 * @property int|null $incoterm_id
 * @property int|null $moeda_id
 * @property int|null $ncm_id
 * @property float $vcmv
 * @property float $peso_liquido
 * @property int $reimportacao
 * @property int $insento
 *
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 * @property \App\Model\Entity\Incoterm $incoterm
 * @property \App\Model\Entity\Moeda $moeda
 * @property \App\Model\Entity\Ncm $ncm
 */
class LiberacaoDocumentalDecisaoTabelaPrecoAdicao extends Entity
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
        
        'numero' => true,
        'liberacao_documental_decisao_tabela_preco_id' => true,
        'liberacao_documental_id' => true,
        'regime_aduaneiro_id' => true,
        'incoterm_id' => true,
        'moeda_id' => true,
        'ncm_id' => true,
        'vcmv' => true,
        'peso_liquido' => true,
        'reimportacao' => true,
        'insento' => true,
        'regimes_aduaneiro' => true,
        'incoterm' => true,
        'moeda' => true,
        'ncm' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function doData($aPost){
        $aTabelaPrecos = json_decode(
            ParametroGeral::getParametroWithValue('PARAM_TABELA_PRECO_ADICOES'), true
        );        
        $aPost['vcmv'] = DoubleUtil::toDBUnformat($aPost['vcmv']);
        $aPost['peso_liquido'] = DoubleUtil::toDBUnformat($aPost['peso_liquido']);
        $aPost['tabela_preco_id'] = @$aTabelaPrecos['tabela_preco_padrao_id'];
        
        if($aPost['reimportacao'] == 1) {
            $aPost['tabela_preco_id'] = @$aTabelaPrecos['tabela_preco_reimportacao_id'];
            return $aPost;
        }

        if(@$aPost['detalhamento_carga_id']) {

            $oTabelaPrecoDetalhamentoCargas = LgDbUtil::getFirst('TabelaPrecoDetalhamentoCargas', [
                'id' => $aPost['detalhamento_carga_id']
            ]);

            if(isset($oTabelaPrecoDetalhamentoCargas->tabela_preco_id)){
                $aPost['tabela_preco_id'] = $oTabelaPrecoDetalhamentoCargas->tabela_preco_id;
                return$aPost;
            }
        }

        if(@$aPost['objetivo_importacao_id']) {

            $oTabelaPrecoObjetivoImportacoes = LgDbUtil::getFirst('TabelaPrecoObjetivoImportacoes', [
                'id' => $aPost['objetivo_importacao_id']
            ]);

            if(isset($oTabelaPrecoObjetivoImportacoes->tabela_preco_id)){
                $aPost['tabela_preco_id'] = $oTabelaPrecoObjetivoImportacoes->tabela_preco_id;
                return$aPost;
            }
        }

        $aIds = json_decode(
            ParametroGeral::getParametroWithValue('PARAM_TABELA_PRECO_ADICAO_IDS_HABILITADOS'), true
        );

        if(empty($aIds)) return $aPost;

        $oTabelasPrecosRegimes = LgDbUtil::getFind('TabelasPrecosRegimes')
            ->where([
                'TabelasPrecosRegimes.regime_id' => $aPost['regime_aduaneiro_id'],
                'TabelasPrecosRegimes.tabela_preco_id IN' => $aIds
            ])->first();

        if(isset($oTabelasPrecosRegimes->tabela_preco_id)) 
            $aPost['tabela_preco_id'] = $oTabelasPrecosRegimes->tabela_preco_id;

        return $aPost;
    }

    public static function isInvalidDrawback($aPost){

        $oRegime = LgDbUtil::getFirst('RegimesAduaneiros', [
            'id' => $aPost['regime_aduaneiro_id'], 'UPPER(descricao)' => 'DRAWBACK'
        ]);

        if(isset($oRegime) && ($aPost['reimportacao'] == 1 || $aPost['insento'] == 1)) {
            return (new ResponseUtil())->setMessage(
                __('Não foi possível salvar, Por favor verificar os campos informados.')
            );
        }

        return (new ResponseUtil())->setStatus(200);
    }

    public static function save($aDataPost, $oAdicao){
        $aDataPost = LiberacaoDocumentalDecisaoTabelaPrecoAdicao::doData($aDataPost);

        if(empty($oAdicao)){
            $oAdicao = LgDbUtil::get('LiberacaoDocumentalDecisaoTabelaPrecoAdicoes')->newEntity();
        }

        if(empty($aDataPost['tabela_preco_id'])){
            return (new ResponseUtil())->setDataExtra($oAdicao)->setMessage('Não foi possível definir a tabela de preços, por favor verificar os cadastros.');
        }

        $oResponse = LiberacaoDocumentalDecisaoTabelaPrecoAdicao::isInvalidDrawback($aDataPost);
        if($oResponse->getStatus() != 200) return $oResponse->setDataExtra($oAdicao);
     
        $oAdicao = LgDbUtil::get('LiberacaoDocumentalDecisaoTabelaPrecoAdicoes')->patchEntity($oAdicao, $aDataPost);
        $bSave = LgDbUtil::get('LiberacaoDocumentalDecisaoTabelaPrecoAdicoes')->save($oAdicao);

        if($bSave) return (new ResponseUtil())->setStatus(200)->setDataExtra($oAdicao);

        return (new ResponseUtil())->setDataExtra($oAdicao)->setMessage(__('Liberacao Documental Decisao Tabela Preco Adicao') . __(' could not be saved. Please, try again.'));
    }

    public static function divergencias($oLiberacao, $aAdicoes){
        $fTotal = self::valorTotalVcmv($aAdicoes);
        $fTotal = round($fTotal, 2);

        $cotacao_fob = LgDbUtil::get('MoedasCotacoes')->find()
            ->where([
                'moeda_id' => $oLiberacao->moeda_fob_id, 
                'data_cotacao' => $oLiberacao->data_registro
            ])
            ->order('data_cotacao', 'DESC')
            ->first();

        $cotacao_fob= $cotacao_fob ? $cotacao_fob->valor_cotacao: 1;
        $fValorFob = $oLiberacao->valor_fob_moeda *  $cotacao_fob;
        $fValorFob = round($fValorFob, 2);

        return (new ResponseUtil())->setStatus(200);

        if($fTotal != $fValorFob){
            return (new ResponseUtil())->setStatus(400)->setMessage('O valor do FOB ('.DoubleUtil::fromDBUnformat($fValorFob). ') é diferente do valor total do VCMV ('.DoubleUtil::fromDBUnformat($fTotal).').');
        }

        return (new ResponseUtil())->setStatus(200);

    }

    public static function valorTotalVcmv($aAdicoes){
        $fTotal = 0;

        foreach ($aAdicoes as $key => $value) {
            $cotacao = @$value->moeda->moedas_cotacoes[0];
            $cotacao = $cotacao ? $cotacao->valor_cotacao: 1;
            $fTotal += ($value->vcmv * $cotacao);
        }

        return  $fTotal;
    }
}
