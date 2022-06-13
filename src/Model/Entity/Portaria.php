<?php
namespace App\Model\Entity;

use App\RegraNegocio\Integracoes\ServicoOcrs\Passagem;
use App\Util\EntityUtil;
use App\Util\LgDbUtil;
use App\Util\RequestUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Portaria Entity
 *
 * @property int $id
 * @property string $descricao
 * @property int $ativo
 * @property int $modal_id
 * @property int $empresa_id
 *
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Resv[] $resvs
 */
class Portaria extends Entity
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
        'descricao' => true,
        'ativo' => true,
        'modal_id' => true,
        'empresa_id' => true,
        'modal' => true,
        'empresa' => true,
        'resvs' => true
    ];


    public static function getPortariaId($iModal){
        $result = TableRegistry::getTableLocator()
            ->get('Portarias')
            ->find()
            ->where([
                'modal_id' => $iModal,
                'ativo' => 1,
                'empresa_id' => Empresa::getEmpresaAtual()
            ])
            ->first();

        if($result){
            return $result->id;
        }

        return null;
    }

    public static function buscaPassagens($iFluxoId)
    {
        $oIntegrador = LgDbUtil::getFind('Integracoes')
            ->where(['codigo_unico' => 'busca-passagens'])
            ->first();
        
        $oRetorno = Passagem::getPassagens($oIntegrador, [$iFluxoId]);

        $aPlacas = [];
        if ($oRetorno->getStatus() != 200)
            return $oRetorno->setDataExtra([]); 

        $placas = @$oRetorno->getDataExtra()['retorno']['placas'] ?: [];
        $aContainers = @$oRetorno->getDataExtra()['retorno']['containers'] ?: [];

        foreach ($placas as $placa) {
            $aPlacas[$placa['tipo'] . '_' . $placa['valor']] = $placa['foto'];
        }

        foreach ($aContainers as $aContainer) {
            $aPlacas[$aContainer['direcaoCamera'] . '_' . $aContainer['numero']] = $aContainer['foto'];
        }

        $aKeys = array_filter(array_keys($aPlacas), function($key) {
            $aInfoPlaca = explode('_', $key);
            return strlen($aInfoPlaca[1]) == 7;
        });

        $aPlacasFormated = [];
        foreach ($aKeys as $placa) {
            $aInfoPlaca = explode('_', $placa);
            $aPlacasFormated[] = [
                'tipo' => $aInfoPlaca[0],
                'placa' => $aInfoPlaca[1]
            ];
        }

        $aPlacasFormated = array_slice(array_reverse($aPlacasFormated), 0, 3);

        return (new ResponseUtil())
            ->setStatus(200)
            ->setDataExtra([
                'placas' => $aPlacasFormated, 
                'fotos' => $placas, 
                'passagem_id' => $oRetorno->getDataExtra()['retorno']['id'],
                'data_registro' => $oRetorno->getDataExtra()['retorno']['dataPassagem'],
                'containers' => $aContainers
            ]);
    }

    public static function validaProgramacao($placa, $reboque1, $reboque2, $iBalancaId)
    {
        $oSolicitacaoLeituraOrc = LgDbUtil::getFind('SolicitacaoLeituraOcrs')
            ->contain(['Balancas'])
            ->where(['Balancas.codigo' => $iBalancaId])
            ->first();

        if (!$oSolicitacaoLeituraOrc)
            return (new ResponseUtil())
                ->setMessage('Leitura de balança não cadastrada!');

        $bValidaCracha = ParametroGeral::getParametroWithValue('PARAM_HABILITA_VALIDACAO_CRACHA_GATE');
        if (!$oSolicitacaoLeituraOrc->cracha_json && $bValidaCracha)
            return (new ResponseUtil())
                ->setMessage('Necessário cadastrar cracha de motorista!');

        $aDataCracha = json_decode($oSolicitacaoLeituraOrc->cracha_json, true);

        $sCpf = isset($aDataCracha['cpf']) ? str_replace('.', '', str_replace('-', '', $aDataCracha['cpf'])) : '';
        if (!$sCpf && $bValidaCracha)
            return (new ResponseUtil())
                ->setMessage('Falta parâmetro de CPF do controle de acesso!');

        $aWherePessoa = [];
        if ($bValidaCracha) {
            $oPessoa = LgDbUtil::getFind('Pessoas')
                ->where(['cpf' => $sCpf])
                ->first();
    
            if (!$oPessoa)
                return (new ResponseUtil())
                    ->setMessage('Não existe pessoa cadastrada com este CPF ('.$sCpf.')!');

            $aWherePessoa['Pessoas.id'] = $oPessoa->id;
        }

        $oProgramacao = LgDbUtil::getFind('Programacoes')
            ->contain([
                'Veiculos',
                'Pessoas',
                'Transportadoras',
                'Operacoes',
                'ProgramacaoVeiculos' => ['Veiculos'], 
                'ProgramacaoLiberacaoDocumentais' => ['LiberacoesDocumentais'], 
                'ProgramacaoDocumentoTransportes' => ['DocumentosTransportes'],
                'ProgramacaoContainers' => [
                    'Containers'
                ]
            ])
            ->leftJoinWith('ResvsFirstLeft')
            ->where([
                'Veiculos.descricao' => $placa,
                'ResvsFirstLeft.data_hora_saida IS NULL'
            ] + $aWherePessoa)
            ->first();

        if (!$oProgramacao) {
            Programacao::consisteProgCarousel($placa);
            $oProgramacao = LgDbUtil::getFind('Programacoes')
                ->contain([
                    'Veiculos',
                    'Pessoas',
                    'Transportadoras',
                    'Operacoes',
                    'ProgramacaoVeiculos' => ['Veiculos'], 
                    'ProgramacaoLiberacaoDocumentais' => ['LiberacoesDocumentais'], 
                    'ProgramacaoDocumentoTransportes' => ['DocumentosTransportes'],
                    'ProgramacaoContainers' => [
                        'Containers'
                    ]
                ])
                ->leftJoinWith('ResvsFirstLeft')
                ->where([
                    'Veiculos.descricao' => $placa,
                    'ResvsFirstLeft.data_hora_saida IS NULL'
                ] + $aWherePessoa)
                ->first();
        }

        if (!$oProgramacao)
            return (new ResponseUtil())
                ->setStatus(204)
                ->setMessage('Sem programação para esta placa: ' . $placa);

        if (ParametroGeral::getParametroWithValue('PARAM_VALIDA_REBOQUES')) {
            $aReboques = array_reduce($oProgramacao->programacao_veiculos, function($carry, $oProgramacaoVeiculo) {
                $carry[$oProgramacaoVeiculo->veiculo->descricao . '_' . $oProgramacaoVeiculo->sequencia_veiculo] = true;
                return $carry;
            }, []);

            if (!isset($aReboques[$reboque1 . '_1']))
                return (new ResponseUtil())
                    ->setMessage('Sem programação para este reboque: <b>' . $reboque1 . '</b>')
                    ->setDataExtra([
                        'id' => $oProgramacao->id,
                        'motorista' => $oProgramacao->pessoa->descricao,
                        'transportadora' => $oProgramacao->transportadora->razao_social,
                        'operação' => $oProgramacao->operacao->descricao,
                        'documento' => ''
                    ]);

            if (!isset($aReboques[$reboque1 . '_2']))
                return (new ResponseUtil())
                    ->setMessage('Sem programação para este reboque: <b>' . $reboque2 . '</b>')
                    ->setDataExtra([
                        'id' => $oProgramacao->id,
                        'motorista' => $oProgramacao->pessoa->descricao,
                        'transportadora' => $oProgramacao->transportadora->razao_social,
                        'operação' => $oProgramacao->operacao->descricao,
                        'documento' => ''
                    ]);
        }

        if ($oProgramacao->operacao_id == 1 && !$oProgramacao->programacao_documento_transportes)
            return (new ResponseUtil())
                ->setMessage('Programação sem documentação de descarga.')
                ->setDataExtra([
                    'id' => $oProgramacao->id,
                    'motorista' => $oProgramacao->pessoa->descricao,
                    'transportadora' => $oProgramacao->transportadora->razao_social,
                    'operação' => $oProgramacao->operacao->descricao,
                    'documento' => ''
                ]);

        $sDocumento = [];
        if ($oProgramacao->operacao_id == 1) {
            $sDocumento = array_reduce($oProgramacao->programacao_documento_transportes, function($carry, $oProgramacaoDocTransp) {
                $carry[] = $oProgramacaoDocTransp->documentos_transporte->numero;
                return $carry;
            }, []);
        } elseif ($oProgramacao->operacao_id == 2) {
            $sDocumento = array_reduce($oProgramacao->programacao_liberacao_documentais, function($carry, $oProgramacaoLibDoc) {
                $carry[] = $oProgramacaoLibDoc->liberacoes_documental->numero;
                return $carry;
            }, []);
        }

        $aContainers = array_reduce($oProgramacao->programacao_containers, function($carry, $oProgContainer) {
            $carry[] = $oProgContainer->container->numero;
            return $carry;
        }, []);

        $bValidaContainers = ParametroGeral::getParametroWithValue('PARAM_HABILITA_VALIDACAO_CNT_GATE');

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Programação encontrada.')
            ->setDataExtra([
                'id' => $oProgramacao->id,
                'motorista' => $oProgramacao->pessoa->descricao,
                'transportadora' => $oProgramacao->transportadora->razao_social,
                'operação' => $oProgramacao->operacao->descricao,
                'documento' => implode(', ', $sDocumento),
                'containers' => $bValidaContainers ? implode(', ', $aContainers) : ''
            ]);
    }

    public static function validaCracha($iBalancaId)
    {
        $bValidaCracha = ParametroGeral::getParametroWithValue('PARAM_HABILITA_VALIDACAO_CRACHA_GATE');
        if (!$bValidaCracha)
            return (new ResponseUtil())
                ->setStatus(200)
                ->setMessage('Registro de cracha encontrado!');

        $oSolicitacaoLeituraOcr = LgDbUtil::getFind('SolicitacaoLeituraOcrs')
            ->contain(['Balancas'])
            ->where(['Balancas.codigo' => $iBalancaId])
            ->first();

        if (!$oSolicitacaoLeituraOcr)
            return (new ResponseUtil())
                ->setMessage('Leitura de balança não cadastrada!');

        if (!$oSolicitacaoLeituraOcr->cracha_json)
            return (new ResponseUtil())
                ->setMessage('Sem registro de cracha!');

        return (new ResponseUtil())
            ->setStatus(200)
            ->setMessage('Registro de cracha encontrado!');
    }
 }