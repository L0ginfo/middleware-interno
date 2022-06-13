<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TipoMercadoria Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 *
 * @property \App\Model\Entity\DocumentosMercadoria[] $documentos_mercadorias
 */
class TipoMercadoria extends Entity
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
        'descricao' => true,
        'codigo' => true,
        'documentos_mercadorias' => true
    ];

    // Master que desconsolidam em house(s)
    public static function getTiposDesconsolidacao()
    {
        return [2, 6, 10, 20];
    }

    public static function isDesconsolidacao($iTipoMercadoriaID = null)
    {
        return in_array($iTipoMercadoriaID, self::getTiposDesconsolidacao());
    }

    // Master que nunca desconsolidam em house(s)
    public static function getTiposMasterPuro()
    {
        return [1, 5, 9, 13, 19];
    }
}
