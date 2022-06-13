<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * ControleAcessoLog Entity
 *
 * @property int $id
 * @property int|null $controle_acesso_controladora_id
 * @property string|null $ip
 * @property int|null $area_de_id
 * @property int|null $area_para_id
 * @property int|null $direcao_controladora_id
 * @property string|null $liberado
 * @property string|null $cracha
 * @property string|null $mensagem
 * @property \Cake\I18n\Time|null $data_hora
 * @property string|null $tipo_acesso_id
 * @property int|null $credenciamento_pessoa_id
 * @property int|null $controle_acesso_evento_id
 * @property int|null $controle_acesso_equipamento_id
 * @property int|null $status
 *
 * @property \App\Model\Entity\ControleAcessoControladora $controle_acesso_controladora
 * @property \App\Model\Entity\AreaDe $area_de
 * @property \App\Model\Entity\AreaPara $area_para
 * @property \App\Model\Entity\DirecaoControladora $direcao_controladora
 * @property \App\Model\Entity\TipoAcesso $tipo_acesso
 * @property \App\Model\Entity\CredenciamentoPessoa $credenciamento_pessoa
 * @property \App\Model\Entity\ControleAcessoEvento $controle_acesso_evento
 */
class ControleAcessoLog extends Entity
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
        
        'controle_acesso_controladora_id' => true,
        'ip' => true,
        'area_de_id' => true,
        'area_para_id' => true,
        'direcao_controladora_id' => true,
        'liberado' => true,
        'cracha' => true,
        'mensagem' => true,
        'data_hora' => true,
        'tipo_acesso_id' => true,
        'credenciamento_pessoa_id' => true,
        'controle_acesso_evento_id' => true,
        'controle_acesso_equipamento_id' => true,
        'status' => true,
        'controle_acesso_controladora' => true,
        'area_de' => true,
        'area_para' => true,
        'direcao_controladora' => true,
        'tipo_acesso' => true,
        'credenciamento_pessoa' => true,
        'controle_acesso_evento' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        $aTipoAcessos = LgDbUtil::get('TipoAcessos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->toArray();

        $aControladoras = LgDbUtil::get('ControleAcessoControladoras')
            ->find('list', ['keyField' => 'id', 'valueField' => 'descricao'])
            ->select( ['id', 'descricao'] )
            ->toArray();

        return [
            [
                'name'  => 'pessoa_nome',
                'divClass' => 'col-lg-3',
                'label' => 'Pessoa',
                'table' => [
                    'className' => 'ControleAcessoLogs.CredenciamentoPessoas.Pessoas',
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
                    'className' => 'ControleAcessoLogs.CredenciamentoPessoas.Pessoas',
                    'field'     => 'cpf',
                    'operacao'  => 'contem',
                    'type'      => 'text'
                ]
            ],
            [
                'name'  => 'controladora',
                'divClass' => 'col-lg-2',
                'label' => 'Controladora',
                'table' => [
                    'className' => 'ControleAcessoLogs.ControleAcessoControladoras',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aControladoras
                ]
            ],
            [
                'name'  => 'tipo_acesso',
                'divClass' => 'col-lg-2',
                'label' => 'Tipo Acesso',
                'table' => [
                    'className' => 'ControleAcessoLogs.TipoAcessos',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aTipoAcessos
                ]
            ],
            [
                'name'  => 'data_log',
                'divClass' => 'col-lg-4',
                'label' => 'Data',
                'table' => [
                    'className' => 'ControleAcessoLogs',
                    'field'     => 'data_hora',
                    'operacao'  => 'entre',
                    'type'      => 'datetime-local'
                ]
            ]
        ];
    }
}
