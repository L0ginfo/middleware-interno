<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\OrdemServico;
use App\Util\EntityUtil;
use App\Model\Entity\Endereco;
use Cake\ORM\TableRegistry;

/**
 * Inventario Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $data_geracao
 * @property int $situacao
 *
 * @property \App\Model\Entity\InventarioItem[] $inventario_itens
 */
class Inventario extends Entity
{
    const SITUACAO_AGUARDANDO_INICIO = 1;
    const SITUACAO_EM_ANDAMENTO      = 2;
    const SITUACAO_CONCLUIDO         = 3;
    const SITUACAO_ENCERRADO         = 4;

    const ARRAY_SITUACOES   = [
        self::SITUACAO_AGUARDANDO_INICIO => 'Aguardando Início',
        self::SITUACAO_EM_ANDAMENTO      => 'Em Andamento',
        self::SITUACAO_CONCLUIDO         => 'Concluído',
        self::SITUACAO_ENCERRADO         => 'Encerrado'
    ];

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    public static function getComposicoes($that, $oInventario)
    {
        $aInventarioItens   = self::getInventarioItensComposicoes($that, $oInventario);
        $aArrayCodigos      = self::getArrayCodigos($aInventarioItens);
        $aComposicoesMinMax = self::getComposicoesMinMax($aArrayCodigos, $oInventario);

        $sComposicoes       = self::getStringComposicoes($aComposicoesMinMax);

        return $sComposicoes;
    }

    private static function getInventarioItensComposicoes($that, $oInventario)
    {
        return $that->InventarioItens->find('all')
            ->contain(['Enderecos'])
            ->where(['inventario_id' => $oInventario->id])
            ->order([
                'Enderecos.area_id' => 'ASC',
                'cod_composicao1'   => 'ASC',
                'cod_composicao2'   => 'ASC',
                'cod_composicao3'   => 'ASC',
                'cod_composicao4'   => 'ASC'
        ]);
    }

    private static function getArrayCodigos($aInventarioItens)
    {
        $aArrayCodigos = [];
        foreach ($aInventarioItens as $key => $aItem) {
            $oEndereco = $aItem->endereco;

            for ($i = 1; $i <= 4; $i++) {
                $iCodComposicao = 'cod_composicao' . $i;
                if ($oEndereco->{$iCodComposicao}) {
                    $aArrayCodigos[$key][$oEndereco->area_id][$i] = $oEndereco->{$iCodComposicao};
                }
            }
        }

        return $aArrayCodigos;
    }

    private static function getComposicoesMinMax($aArrayCodigos, $oInventario)
    {
        $aComposicoesMinMax = [];
        for ($i = 1; $i <= 4; $i++) { 
            $aComposicoesMinMax['min'.$i] = 9999;
            $aComposicoesMinMax['max'.$i] = 0;
        }
        
        foreach ($aArrayCodigos as $a) {
            for ($i = 1; $i <= 4; $i++) { 
                if (array_key_exists($i, $a[$oInventario->area_id])) {
                    if ($a[$oInventario->area_id][$i] < $aComposicoesMinMax['min'.$i]) {
                        $aComposicoesMinMax['min'.$i] = $a[$oInventario->area_id][$i];
                    }
                    if ($a[$oInventario->area_id][$i] > $aComposicoesMinMax['max'.$i]) {
                        $aComposicoesMinMax['max'.$i] = $a[$oInventario->area_id][$i];
                    }
                } else {
                    unset($aComposicoesMinMax['min'.$i]);
                    unset($aComposicoesMinMax['max'.$i]);
                }
            }
        }

        return $aComposicoesMinMax;
    }

    private static function getStringComposicoes($aComposicoesMinMax)
    {
        return $sComposicoes = 
            (isset($aComposicoesMinMax['min1']) ? $aComposicoesMinMax['min1'] . " > " . $aComposicoesMinMax['max1'] . "</br>" : '') .
            (isset($aComposicoesMinMax['min2']) ? $aComposicoesMinMax['min2'] . " > " . $aComposicoesMinMax['max2'] . "</br>" : '') .
            (isset($aComposicoesMinMax['min3']) ? $aComposicoesMinMax['min3'] . " > " . $aComposicoesMinMax['max3'] . "</br>" : '') .
            (isset($aComposicoesMinMax['min4']) ? $aComposicoesMinMax['min4'] . " > " . $aComposicoesMinMax['max4'] . "</br>" : '');
    }

    public static function gerarOsInventario($that, $iInventarioId)
    {
        $iOrdemSerivoId = self::gerarOrdemServico();
        if ($iOrdemSerivoId) {
            $bgerarOsInventario = self::gerarOrdemServicoInventario($that, $iOrdemSerivoId, $iInventarioId);
            if ($bgerarOsInventario) {
                return true;
            }
            return false;
        }
        return false;
    }

    private static function gerarOrdemServico ()
    {
        $aData                          = [];
        $aData['retroativo']            = 0;
        $aData['ordem_servico_tipo_id'] = EntityUtil::getIdByParams('OrdemServicoTipos', 'descricao', 'Inventário');
        
        $aResponse = (new OrdemServico())->gerarOs(null, $aData);
        if ($aResponse['dataExtra']->id) {
            return $aResponse['dataExtra']->id;
        }
        return false;
    }

    private static function gerarOrdemServicoInventario($that, $iOrdemSerivoId, $iInventarioId)
    {
        $oOsInventario = $that->OrdemServicoInventarios->newEntity();
        $oOsInventario->ordem_servico_id = $iOrdemSerivoId;
        $oOsInventario->inventario_id    = $iInventarioId;
        if ($that->OrdemServicoInventarios->save($oOsInventario)) {
            return true;
        }
        return false;
    }

    public static function getComposicoesEnderecos ($aInventarioItens)
    {
        foreach ($aInventarioItens as $aItem) {
            $sComposicaoEndereco = Endereco::getEnderecoCompletoByID(null, null, $aItem->endereco, ['com_local_area' => true]);
            $aItem->endereco->composicao = $sComposicaoEndereco;
        }
    }

    public static function setStatusByOSID ($iOSID, $iStatus)
    {
        $oOrdemServicoInventarios = TableRegistry::get('OrdemServicoInventarios')->find()->where(['ordem_servico_id' => $iOSID])->first();
        
        $oInventarios = TableRegistry::get('Inventarios');
        $oInventario = $oInventarios->find()->where(['id' => $oOrdemServicoInventarios->inventario_id])->first();
        $oInventario->situacao = $iStatus;

        $oInventarios->save($oInventario);
    }

    public static function setStatusEstoqueEnderecos ($iOSID, $sStatus)
    {
        $oOrdemServicoInventarios = TableRegistry::get('OrdemServicoInventarios')->find()->where(['ordem_servico_id' => $iOSID])->first();
        $oInventarios = TableRegistry::get('Inventarios');
        $oInventario = $oInventarios->find()->contain(['InventarioItens'])->where(['id' => $oOrdemServicoInventarios->inventario_id])->first();

        $EstoqueEnderecos = TableRegistry::get('EstoqueEnderecos');
        foreach ($oInventario->inventario_itens as $oItem) {
            $oEstoqueEnderecos = $EstoqueEnderecos->find()->where(['endereco_id' => $oItem->endereco_id])->toArray();
            if ($oEstoqueEnderecos) {
                foreach ($oEstoqueEnderecos as $oEstoqueEndereco) {
                    $iStatusBloqueado = EntityUtil::getIdByParams('StatusEstoques', 'descricao', $sStatus);
                    $oEstoqueEndereco->status_estoque_id = $iStatusBloqueado;
                    $EstoqueEnderecos->save($oEstoqueEndereco);

                    $aResultMovimentacao = MovimentacoesEstoque::saveMovimentacao(null, [
                        'quantidade_movimentada'     => $oEstoqueEndereco->qtde_saldo,
                        'estoque_id'                 => $oEstoqueEndereco->estoque_id,
                        'endereco_origem_id'         => $oEstoqueEndereco->endereco_id,
                        'endereco_destino_id'        => $oEstoqueEndereco->endereco_id,
                        'lote'                       => $oEstoqueEndereco->lote,
                        'serie'                      => $oEstoqueEndereco->serie,
                        'validade'                   => $oEstoqueEndereco->validade,
                        'created_at_estoque'         => $oEstoqueEndereco->created_at,
                        'unidade_medida_anterior_id' => $oEstoqueEndereco->unidade_medida_id,
                        'tipo_movimentacao_id'       => 3,
                        'status_estoque_id'          => $oEstoqueEndereco->status_estoque_id
                    ]);
                }
            }
        }
    }

}
