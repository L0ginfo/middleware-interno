<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StatusEstoque Entity
 *
 * @property int $id
 * @property string $descricao
 *
 * @property \App\Model\Entity\EstoqueEndereco[] $estoque_enderecos
 * @property \App\Model\Entity\MovimentacoesEstoque[] $movimentacoes_estoques
 */
class StatusEstoque extends Entity
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
        'estoque_enderecos' => true,
        'movimentacoes_estoques' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getStatus($sStatus)
    {
        if ($sStatus == 'bloqueado')
            return 3;

        return 1;
    }
}
