<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ControleAcessoControladora Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $codigo
 * @property int $situacao
 * @property string|null $ip
 * @property string|null $porta
 * @property string|null $offline_interval
 * @property int $anti_dupla
 * @property int $area_de_id
 * @property int $area_para_id
 * @property int $direcao_controladora_id
 * @property int|null $modelo_equipamento_id
 * @property int $tipo_equipamento_id
 *
 * @property \App\Model\Entity\ControleAcessoArea $controle_acesso_area
 * @property \App\Model\Entity\DirecaoControladora $direcao_controladora
 * @property \App\Model\Entity\ModeloEquipamento $modelo_equipamento
 * @property \App\Model\Entity\TipoEquipamento $tipo_equipamento
 * @property \App\Model\Entity\ControleAcessoLog[] $controle_acesso_logs
 * @property \App\Model\Entity\ControleAcessoSolicitacaoLeitura[] $controle_acesso_solicitacao_leituras
 */
class ControleAcessoControladora extends Entity
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
        
        'descricao' => true,
        'codigo' => true,
        'situacao' => true,
        'ip' => true,
        'porta' => true,
        'offline_interval' => true,
        'anti_dupla' => true,
        'area_de_id' => true,
        'area_para_id' => true,
        'direcao_controladora_id' => true,
        'modelo_equipamento_id' => true,
        'tipo_equipamento_id' => true,
        'controle_acesso_area' => true,
        'direcao_controladora' => true,
        'modelo_equipamento' => true,
        'tipo_equipamento' => true,
        'controle_acesso_logs' => true,
        'controle_acesso_solicitacao_leituras' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
