<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Integracao Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property string $codigo_unico
 * @property array|null $json_header
 * @property string|null $url_endpoint
 * @property int $ativo
 * @property int $gravar_log
 * @property string|null $private_key
 * @property \Cake\I18n\Time|null $data_integracao
 * @property string $tipo
 * @property string|null $db_host
 * @property int|null $db_porta
 * @property string|null $db_database
 * @property string|null $db_user
 * @property string|null $db_pass
 *
 * @property \App\Model\Entity\IntegracaoLog[] $integracao_logs
 * @property \App\Model\Entity\IntegracaoTraducao[] $integracao_traducoes
 */
class Integracao extends Entity
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

        'nome' => true,
        'descricao' => true,
        'codigo_unico' => true,
        'json_header' => true,
        'url_endpoint' => true,
        'ativo' => true,
        'gravar_log' => true,
        'private_key' => true,
        'data_integracao' => true,
        'tipo' => true,
        'db_host' => true,
        'db_porta' => true,
        'db_database' => true,
        'db_user' => true,
        'db_pass' => true,
        'integracao_logs' => true,
        'integracao_traducoes' => true,

     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
