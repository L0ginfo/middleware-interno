<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * CredenciamentoPessoa Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time|null $data_inicio_acesso
 * @property \Cake\I18n\Time|null $data_fim_acesso
 * @property int $ativo
 * @property int $pessoa_id
 * @property int $credenciamento_perfil_id
 *
 * @property \App\Model\Entity\Pessoa $pessoa
 * @property \App\Model\Entity\CredenciamentoPerfi $credenciamento_perfi
 * @property \App\Model\Entity\ControleAcessoCodigo[] $controle_acesso_codigos
 * @property \App\Model\Entity\ControleAcessoLog[] $controle_acesso_logs
 * @property \App\Model\Entity\ControleAcessoSolicitacaoLeitura[] $controle_acesso_solicitacao_leituras
 * @property \App\Model\Entity\CredenciamentoPessoaArea[] $credenciamento_pessoa_areas
 * @property \App\Model\Entity\PessoaVeiculo[] $pessoa_veiculos
 */
class CredenciamentoPessoa extends Entity
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
        
        'data_inicio_acesso' => true,
        'data_fim_acesso' => true,
        'ativo' => true,
        'pessoa_id' => true,
        'credenciamento_perfil_id' => true,
        'pessoa' => true,
        'credenciamento_perfi' => true,
        'controle_acesso_codigos' => true,
        'controle_acesso_logs' => true,
        'controle_acesso_solicitacao_leituras' => true,
        'credenciamento_pessoa_areas' => true,
        'pessoa_veiculos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getAreasPermissoes($oCredenciamentoPessoa = null, $iCredenciamentoPessoaId = null)
    {
        if (!$oCredenciamentoPessoa && !$iCredenciamentoPessoaId)
            return [];

        if (!$oCredenciamentoPessoa)
            $oCredenciamentoPessoa = LgDbUtil::getFind('CredenciamentoPessoas')
                ->contain(['CredenciamentoPerfis' => [
                    'CredenciamentoPerfilAreas'
                ]])
                ->where([
                    'CredenciamentoPessoas.id' => $iCredenciamentoPessoaId
                ])
                ->first();

        $aCredenciamentoPerfilAreas = $oCredenciamentoPessoa->credenciamento_perfi->credenciamento_perfil_areas;
    
        $aAreasPermitidas = array_reduce($aCredenciamentoPerfilAreas, function($carry, $oCredenciamentoPerfilArea) {
            $carry[] = $oCredenciamentoPerfilArea->controle_acesso_area_id;

            return $carry;
        }, []);

        return $aAreasPermitidas;
    }

    public static function getFilters()
    {
        
        $aAtivos = [0 => 'Não', 1 => 'Sim'];

        $aCredenciamentoPerfis = LgdbUtil::get('CredenciamentoPerfis')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->toArray();

        return [
            [
                'name'  => 'pessoa_nome',
                'divClass' => 'col-lg-3',
                'label' => 'Pessoa',
                'table' => [
                    'className' => 'CredenciamentoPessoas.Pessoas',
                    'field'     => 'descricao',
                    'operacao'  => 'contem',
                    'type'      => 'text'
                ]
            ],
            [
                'name'  => 'pessoa_cpf',
                'divClass' => 'col-lg-3',
                'label' => 'CPF',
                'table' => [
                    'className' => 'CredenciamentoPessoas.Pessoas',
                    'field'     => 'cpf',
                    'operacao'  => 'contem',
                    'type'      => 'text'
                ]
            ],
            [
                'name'  => 'ativo',
                'divClass' => 'col-lg-2',
                'label' => 'Ativo',
                'table' => [
                    'className' => 'CredenciamentoPessoas',
                    'field'     => 'ativo',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aAtivos
                ]
            ],
            [
                'name'  => 'credenciamento_perfil',
                'divClass' => 'col-lg-2',
                'label' => 'Perfil',
                'table' => [
                    'className' => 'CredenciamentoPerfis',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'      => $aCredenciamentoPerfis
                ]
            ]
        ];
    }

    public static function countQtdeCrachaBiometria($aControleAcessoCodigos)
    {
        $aQtdePorTipoAcesso = [];
        foreach ($aControleAcessoCodigos as $oControleAcessoCodigo) {
            if (isset($aQtdePorTipoAcesso[$oControleAcessoCodigo->tipo_acesso_id]))
                $aQtdePorTipoAcesso[$oControleAcessoCodigo->tipo_acesso_id] += 1;
            else
                $aQtdePorTipoAcesso[$oControleAcessoCodigo->tipo_acesso_id] = 1;
        }

        return $aQtdePorTipoAcesso;
    }
}
