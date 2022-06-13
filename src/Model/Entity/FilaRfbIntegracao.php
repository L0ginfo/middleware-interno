<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;

/**
 * FilaRfbIntegracao Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property string $rfb_endpoint_envio
 * @property string|null $rfb_body_retorno
 * @property string|null $rfb_headers_retorno
 * @property int|null $rfb_status_retorno
 * @property string|null $cliente_body_envio
 * @property string|null $cliente_headers_envio
 * @property int|null $numero_tentativas
 * @property int|null $status_recebimento
 * @property int|null $status_integracao
 * @property \Cake\I18n\Time $data_recebimento
 * @property \Cake\I18n\Time|null $data_ultima_tentativa
 * @property string|null $stack_error
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\Cliente $cliente
 */
class FilaRfbIntegracao extends Entity
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
        
        'cliente_id' => true,
        'rfb_endpoint_envio' => true,
        'rfb_body_retorno' => true,
        'rfb_headers_retorno' => true,
        'rfb_status_retorno' => true,
        'cliente_body_envio' => true,
        'cliente_headers_envio' => true,
        'numero_tentativas' => true,
        'status_recebimento' => true,
        'status_integracao' => true,
        'data_recebimento' => true,
        'data_ultima_tentativa' => true,
        'stack_error' => true,
        'created_at' => true,
        'updated_at' => true,
        'cliente' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public static function getFilters(){
        return [
            [
                'name'  => 'cliente_id',
                'divClass' => 'col-lg-2',
                'label' => 'Cliente',
                'table' => [
                    'className' => 'Clientes',
                    'field'     => 'descricao',
                    'operacao'  => 'contem'
                ]
            ],

            [
                'name'  => 'nome_endpoint',
                'divClass' => 'col-lg-2',
                'label' => 'Nome do Endpoint',
                'table' => [
                    'className' => 'FilaRfbIntegracoes',
                    'field'     => 'nome_endpoint',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ],

            [
                'name'  => 'nome_model',
                'divClass' => 'col-lg-2',
                'label' => 'Nome do Modelo',
                'table' => [
                    'className' => 'FilaRfbIntegracoes',
                    'field'     => 'nome_model',
                    'operacao'  => 'contem',
                    'typeVar'   => 'string'
                ]
            ],
            
            [
                'name'  => 'created_at',
                'divClass' => 'col-xs-6',
                'label' => 'Data criação',
                'table' => [
                    'className' => 'FilaRfbIntegracoes',
                    'field'     => 'created_at',
                    'operacao'  => 'entre',
                    'type'      => 'date',
                ]
            ],
            [
                'name'  => 'integrar',
                'divClass' => 'col-lg-2',
                'label' => 'Faz Integração',
                'table' => [
                    'className' => 'FilaRfbIntegracoes',
                    'field'     => 'integrar',
                    'operacao'  => 'igual',
                    'typeVar'   => 'integer',
                ]
            ]
        ];
    }

    
}
