<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * Viagem Entity
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $descricao
 * @property int|null $transportadora_id
 * @property int|null $terminal_origem_id
 * @property int|null $terminal_destino_id
 * @property \Cake\I18n\Time|null $previsao_chegada
 * @property int|null $vagoes_cheios
 * @property int|null $vagoes_vazios
 * @property int|null $modal_id
 * @property int|null $operador_id
 *
 * @property \App\Model\Entity\Transportadora $transportadora
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\Operador $operador
 * @property \App\Model\Entity\Programacao[] $programacoes
 * @property \App\Model\Entity\Resv[] $resvs
 */
class Viagem extends Entity
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
        
        'codigo' => true,
        'descricao' => true,
        'transportadora_id' => true,
        'terminal_origem_id' => true,
        'terminal_destino_id' => true,
        'previsao_chegada' => true,
        'vagoes_cheios' => true,
        'vagoes_vazios' => true,
        'modal_id' => true,
        'operador_id' => true,
        'transportadora' => true,
        'empresa' => true,
        'modal' => true,
        'operador' => true,
        'programacoes' => true,
        'resvs' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getVagoes($iViagemId)
    {
        $aProgramacoes = LgDbUtil::getFind('Programacoes')
            ->contain(['Veiculos'])
            ->where([
                'Programacoes.viagem_id' => $iViagemId
            ])->toArray();

        $aVagoes = [];
        if ($aProgramacoes) {
            foreach ($aProgramacoes as $oProgramacao) {
                $aVagoes[$oProgramacao->id] = $oProgramacao;
            }
        }
            
        return $aVagoes;
    }

    public static function getDocEntradas($iViagemId, $aProgDocEntradas = null)
    {
        $aProgDocEntradas = $aProgDocEntradas ?: LgDbUtil::getFind('ProgramacaoDocumentoTransportes')
            ->contain(['Programacoes', 'DocumentosTransportes' => ['DocumentosMercadoriasMany' => ['Clientes']]])
            ->where([
                'Programacoes.viagem_id' => $iViagemId
            ])->toArray();

            
        foreach ($aProgDocEntradas as $oProgDocEntrada) {
                
            $sCliente = '';
            foreach ($oProgDocEntrada->documentos_transporte->documentos_mercadorias as $oDocumentoMercadoria) {
                if ($sCliente) break;
            
                if ($oDocumentoMercadoria->cliente)
                    $sCliente = $oDocumentoMercadoria->cliente->descricao . ' ' . $oDocumentoMercadoria->cliente->cnpj;
            }
            $oProgDocEntrada->cliente = $sCliente;
        }

        $aViagemDocEntradas = [];
        if ($aProgDocEntradas) {
            foreach ($aProgDocEntradas as $oProgramacaoDocEntrada) {
                $aViagemDocEntradas[$oProgramacaoDocEntrada->programacao_id][] = $oProgramacaoDocEntrada;
            }
        }
            
        return $aViagemDocEntradas;
    }

    public static function getDocSaidas($iViagemId, $aProgramacaoLiberacaoDocumentais = null)
    {
        $aProgramacaoLiberacaoDocumentais = $aProgramacaoLiberacaoDocumentais ?: LgDbUtil::get('ProgramacaoLiberacaoDocumentais')
            ->find()
            ->contain([
                'Programacoes',
                'LiberacoesDocumentais' => ['Clientes'],
                'LiberacaoDocumentalTransportadoras',
                'ProgramacaoLiberacaoDocumentalItens'
            ])
            ->where(['Programacoes.viagem_id' => $iViagemId])
            ->toArray();

        $aViagemDocSaidas = [];
        if ($aProgramacaoLiberacaoDocumentais) {
            foreach ($aProgramacaoLiberacaoDocumentais as $oProgramacaoLiberacaoDocumental) {
                $aViagemDocSaidas[$oProgramacaoLiberacaoDocumental->programacao_id][] = $oProgramacaoLiberacaoDocumental;
            }
        }
            
        return $aViagemDocSaidas;
    }

    public static function getContainers($iViagemId)
    {
        $aProgramacaoContainers = LgDbUtil::get('ProgramacaoContainers')
            ->find()
            ->contain([
                'Programacoes',
                'Containers',
                'DocumentosTransportes',
                'Operacoes',
                'Empresas',
                'DriveEspacos',
                'ProgramacaoContainerLacres' => [
                    'LacreTipos'
                ]
            ])
            ->where(['Programacoes.viagem_id' => $iViagemId])
            ->toArray();

        $aViagemContainers = [];
        if ($aProgramacaoContainers) {
            foreach ($aProgramacaoContainers as $oProgramacaoContainer) {
                $aViagemContainers[$oProgramacaoContainer->programacao_id][] = $oProgramacaoContainer;
            }
        }
            
        return $aViagemContainers;
    }
}
