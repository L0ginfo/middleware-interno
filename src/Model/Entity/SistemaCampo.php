<?php
namespace App\Model\Entity;
use App\Util\SaveBackUtil;

use Cake\ORM\Entity;

/**
 * SistemaCampo Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 */
class SistemaCampo extends Entity
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
        'codigo' => true,
        'descricao' => true
    ];
    
    private function getCampos()
    {
        return [
            'LiberacoesDocumentais.valor_fob_moeda',
            'LiberacoesDocumentais.valor_cif_moeda',
            'LiberacoesDocumentais.quantidade_total',
            'LiberacoesDocumentais.peso_bruto',
            'LiberacoesDocumentais.peso_liquido'
        ];
    }

    public function getCampo( $sLike )
    {
        $aCampos = $this->getCampos();

        foreach ($aCampos as $key => $aCampo) {
            if ( strpos($aCampo, $sLike) !== false ) 
                return $aCampo;
        }

        return false;
    }
}
