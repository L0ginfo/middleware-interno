<?php
namespace LogPluginIntegrador\Model\Entity;

use Cake\ORM\Entity;

/**
 * IntegracaoLog Entity
 *
 * @property int $id
 * @property int $integracao_id
 * @property int|null $integracao_traducao_id
 * @property string $url_requisitada
 * @property array|null $header_enviado
 * @property array|null $header_recebido
 * @property array|null $json_enviado
 * @property array|null $json_recebido
 * @property array|null $json_traduzido
 * @property int $status
 * @property string|null $descricao
 * @property string|null $stackerror
 *
 * @property \App\Model\Entity\Integracao $integracao
 * @property \App\Model\Entity\IntegracaoTraducao $integracao_traducao
 */
class IntegracaoLog extends Entity
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
        
        'integracao_id' => true,
        'integracao_traducao_id' => true,
        'url_requisitada' => true,
        'header_enviado' => true,
        'header_recebido' => true,
        'json_enviado' => true,
        'json_recebido' => true,
        'json_traduzido' => true,
        'status' => true,
        'descricao' => true,
        'stackerror' => true,
        'integracao' => true,
        'integracao_traducao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
