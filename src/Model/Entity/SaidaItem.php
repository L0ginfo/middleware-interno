<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SaidaItem Entity.
 *
 * @property int $id
 * @property string $cod_cliente
 * @property string $nome_cliente
 * @property string $doc_saida
 * @property string $sequencia_item
 * @property string $desc_produto
 * @property string $doc_id
 * @property \App\Model\Entity\Doc $doc
 * @property int $quantidade_carregada
 * @property int $agendamento_id
 * @property \App\Model\Entity\Agendamento $agendamento
 */
class SaidaItem extends Entity
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
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
