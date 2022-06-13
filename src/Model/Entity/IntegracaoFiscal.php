<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IntegracaoFiscal Entity
 *
 * @property int $id
 * @property string|null $numero_documento
 * @property string|null $cnpj_cliente
 * @property string|null $produto_codigo
 * @property int|null $liberacao_documental_id
 * @property int|null $liberacao_documental_item_id
 * @property int|null $produto_id
 * @property float|null $saldo
 * @property float|null $entrada
 * @property float|null $saida
 * @property \Cake\I18n\Date|null $date_created
 * @property \Cake\I18n\Time|null $hour_created
 * @property \Cake\I18n\Date|null $date_updated
 * @property \Cake\I18n\Time|null $hour_updated
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time|null $updated_at
 *
 * @property \App\Model\Entity\LiberacaoDocumental $liberacao_documental
 * @property \App\Model\Entity\LiberacaoDocumentalItem $liberacao_documental_item
 * @property \App\Model\Entity\Produto $produto
 */
class IntegracaoFiscal extends Entity
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
        
        'numero_documento' => true,
        'cnpj_cliente' => true,
        'produto_codigo' => true,
        'liberacao_documental_id' => true,
        'liberacao_documental_item_id' => true,
        'produto_id' => true,
        'saldo' => true,
        'entrada' => true,
        'saida' => true,
        'date_created' => true,
        'hour_created' => true,
        'date_updated' => true,
        'hour_updated' => true,
        'created_at' => true,
        'updated_at' => true,
        'liberacao_documental' => true,
        'liberacao_documental_item' => true,
        'produto' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
