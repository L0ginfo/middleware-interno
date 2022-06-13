<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * OrdemServicoItemLingada Entity
 *
 * @property int $id
 * @property string $codigo
 * @property float|null $qtde
 * @property float|null $peso
 * @property int $ordem_servico_id
 * @property int $sentido_id
 * @property int $terno_id
 * @property int $resv_id
 * @property int $plano_carga_porao_id
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Sentido $sentido
 * @property \App\Model\Entity\Terno $terno
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\PlanoCargaPorao $plano_carga_porao
 * @property \App\Model\Entity\LingadaRemocao[] $lingada_remocoes
 */
class OrdemServicoItemLingada extends Entity
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
        'qtde' => true,
        'peso' => true,
        'ordem_servico_id' => true,
        'sentido_id' => true,
        'terno_id' => true,
        'resv_id' => true,
        'plano_carga_porao_id' => true,
        'ordem_servico' => true,
        'sentido' => true,
        'terno' => true,
        'resv' => true,
        'plano_carga_porao' => true,
        'lingada_remocoes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public function getClienteCnpj($oPlanejamentoMaritimo){

        $oCliente = @$this->plano_carga_porao
            ->documentos_mercadorias_item
            ->documentos_mercadoria->cliente;

        if(isset($oCliente)){
            return $oCliente->cnpj;
        }

        $oPacklist = @$this->plano_carga_porao
            ->plano_carga_packing_list;

        if(isset($oPacklist->cnpj)){
            return $oPacklist->cnpj;
        }

        return @$oPlanejamentoMaritimo->cliente->cnpj?:'';
    }

    public function getClienteNome($oPlanejamentoMaritimo){

        $oCliente = @$this->plano_carga_porao
            ->documentos_mercadorias_item
            ->documentos_mercadoria->cliente;

        if(isset($oCliente)){
            return $oCliente->descricao;
        }

        $oPacklist = @$this->plano_carga_porao
            ->plano_carga_packing_list;

        if(isset($oPacklist->recebedor)){
            return $oPacklist->recebedor;
        }

        return @$oPlanejamentoMaritimo->cliente->descricao ?:'';
    }

    public static function getFilters()
    {
        $aPeriodos = LgDbUtil::get('PortoTrabalhoPeriodos')
            ->find('list', ['keyField' => 'id', 'valueField' => 'codigo'])
            ->select( ['id', 'codigo'] );
        
        return [
            [
                'name'  => 'resv',
                'divClass' => 'col-lg-2',
                'label' => 'Resv',
                'table' => [
                    'className' => 'Resvs',
                    'field'     => 'id',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'placa',
                'divClass' => 'col-lg-2',
                'label' => 'Placa',
                'table' => [
                    'className' => 'Resvs.Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'planejamento_maritimo',
                'divClass' => 'col-lg-3',
                'label' => 'Planejamento Maritimo',
                'table' => [
                    'className' => 'PlanoCargaPoroes.PlanoCargas.PlanejamentoMaritimos',
                    'field'     => 'numero',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'navio',
                'divClass' => 'col-lg-2',
                'label' => 'Navio',
                'table' => [
                    'className' => 'PlanoCargaPoroes.PlanoCargas.PlanejamentoMaritimos.Veiculos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'viagem_numero',
                'divClass' => 'col-lg-2',
                'label' => 'Viagem',
                'table' => [
                    'className' => 'PlanoCargaPoroes.PlanoCargas.PlanejamentoMaritimos',
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
            [
                'name'  => 'porao',
                'divClass' => 'col-lg-3',
                'label' => 'Porão',
                'table' => [
                    'className' => 'Poroes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
            [
                'name'  => 'produto',
                'divClass' => 'col-lg-3',
                'label' => 'Produto',
                'table' => [
                    'className' => 'Produtos',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],
        ];
    }
}
