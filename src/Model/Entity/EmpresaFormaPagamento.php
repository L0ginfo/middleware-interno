<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmpresaFormaPagamento Entity
 *
 * @property int $id
 * @property string $destino
 * @property int $cliente_id
 * @property int $forma_pagamento_id
 *
 * @property \App\Model\Entity\Empresa $empresa
 * @property \App\Model\Entity\FormaPagamento $forma_pagamento
 */
class EmpresaFormaPagamento extends Entity
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
        'destino' => true,
        'cliente_id' => true,
        'forma_pagamento_id' => true,
        'empresa' => true,
        'forma_pagamento' => true
    ];
}
