<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PlanoCargaPackingList Entity
 *
 * @property int $id
 * @property int|null $plano_carga_id
 * @property string $sequencia
 * @property string|null $produto_codigo
 * @property float|null $peso_bruto
 * @property float|null $peso_liquido
 * @property string|null $recebedor
 * @property int|null $porao
 * @property float|null $largura
 * @property float|null $espessura
 * @property float|null $diametro
 * @property int|null $doc_fiscal
 * @property string|null $municipio
 * @property string|null $localizacao
 * @property string|null $destino
 * @property string|null $emb
 * @property string|null $aspecto
 * @property string|null $grupo
 * @property string|null $sub
 * @property int|null $seq_nav
 * @property float|null $m3
 * @property string|null $cliente_1
 * @property int|null $cliente_2
 * @property float|null $cliente_3
 *
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 */
class PlanoCargaPackingList extends Entity
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
        
        'plano_carga_id' => true,
        'sequencia' => true,
        'produto_codigo' => true,
        'peso_bruto' => true,
        'peso_liquido' => true,
        'recebedor' => true,
        'porao' => true,
        'largura' => true,
        'espessura' => true,
        'diametro' => true,
        'doc_fiscal' => true,
        'municipio' => true,
        'localizacao' => true,
        'destino' => true,
        'emb' => true,
        'aspecto' => true,
        'grupo' => true,
        'sub' => true,
        'seq_nav' => true,
        'm3' => true,
        'cliente_1' => true,
        'cliente_2' => true,
        'cliente_3' => true,
        'plano_carga' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
