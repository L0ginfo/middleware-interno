<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * Paralisacao Entity
 *
 * @property int $id
 * @property string|null $descricao
 * @property \Cake\I18n\Time $data_hora_inicio
 * @property \Cake\I18n\Time|null $data_hora_fim
 * @property int $detectada_automaticamente
 * @property int $paralisacao_motivo_id
 * @property int $planejamento_maritimo_id
 * @property int|null $plano_carga_id
 * @property int|null $plano_carga_porao_id
 * @property int|null $porao_id
 * @property int|null $plano_carga_tipo_mercadoria_id
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\ParalisacaoMotivo $paralisacao_motivo
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 * @property \App\Model\Entity\PlanoCargaPorao $plano_carga_porao
 * @property \App\Model\Entity\Porao $porao
 * @property \App\Model\Entity\PlanoCargaTipoMercadoria $plano_carga_tipo_mercadoria
 */
class Paralisacao extends Entity
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
        'data_hora_inicio' => true,
        'data_hora_fim' => true,
        'detectada_automaticamente' => true,
        'paralisacao_motivo_id' => true,
        'planejamento_maritimo_id' => true,
        'plano_carga_id' => true,
        'plano_carga_porao_id' => true,
        'porao_id' => true,
        'plano_carga_tipo_mercadoria_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'paralisacao_motivo' => true,
        'planejamento_maritimo' => true,
        'plano_carga' => true,
        'plano_carga_porao' => true,
        'porao' => true,
        'plano_carga_tipo_mercadoria' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getFilters()
    {
        $aPeriodos = LgDbUtil::get('PortoTrabalhoPeriodos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select( ['id', 'codigo'] );
        
        return [
            [
                'name'  => 'data_hora_inicio',
                'divClass' => 'col-lg-2',
                'label' => 'Data Inicio',
                'table' => [
                    'className' => 'Paralisacoes',
                    'field'     => 'data_hora_inicio',
                    'operacao'  => 'contem',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'data_hora_fim',
                'divClass' => 'col-lg-2',
                'label' => 'Data Fim',
                'table' => [
                    'className' => 'Paralisacoes',
                    'field'     => 'data_hora_fim',
                    'operacao'  => 'contem',
                    'type'      => 'date'
                ]
            ],
            [
                'name'  => 'porao',
                'divClass' => 'col-lg-2',
                'label' => 'Porão',
                'table' => [
                    'className' => 'Poroes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'planejamento_maritimo',
                'divClass' => 'col-lg-2',
                'label' => 'Planejamento Maritimo',
                'table' => [
                    'className' => 'PlanejamentoMaritimos',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'navio_id',
                'divClass' => 'col-lg-2',
                'label' => 'Navio',
                'table' => [
                    'className' => 'Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'viagem_numero',
                'divClass' => 'col-lg-2',
                'label' => 'Viagem',
                'table' => [
                    'className' => 'PlanejamentoMaritimos',
                    'field'     => 'viagem_numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'terno',
                'divClass' => 'col-lg-3',
                'label' => 'Terno',
                'table' => [
                    'className' => 'Ternos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'porto_trabalho_periodos',
                'divClass' => 'col-lg-3',
                'label' => 'Periodo',
                'table' => [
                    'className' => 'PortoTrabalhoPeriodos',
                    'field'     => 'id',
                    'operacao'  => 'in',
                    'type'      => 'select',
                    'options'   => $aPeriodos
                ]
            ],
        ];
    }
}
