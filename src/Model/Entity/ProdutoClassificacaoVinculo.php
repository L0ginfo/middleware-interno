<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * ProdutoClassificacaoVinculo Entity
 *
 * @property int $id
 * @property string $texto_comparar
 * @property int $produto_classificacao_id
 *
 * @property \App\Model\Entity\ProdutoClassificacao $produto_classificacao
 */
class ProdutoClassificacaoVinculo extends Entity
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
        
        'texto_comparar' => true,
        'produto_classificacao_id' => true,
        'produto_classificacao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getProdutoClassificacaoByDescricao($sProdutoDescricao)
    {
        $oDefaultClassificacao = TableRegistry::get('ProdutoClassificacaoVinculos')->find()
            ->where(["texto_comparar LIKE " => "*"])
            ->first();

        $iClassificacaoDefault = null;

        if ($oDefaultClassificacao)
            $iClassificacaoDefault = $oDefaultClassificacao->produto_classificacao_id;
        
        if (!$sProdutoDescricao)
            return $iClassificacaoDefault;

        $aClassificacoes = TableRegistry::get('ProdutoClassificacaoVinculos')->find()
            ->where(['texto_comparar IS NOT' => null, 'texto_comparar NOT LIKE ' => "*"])
            ->toArray();

        $iClassificacao = null;

        foreach ($aClassificacoes as $oClassificao) {
            if (strpos($sProdutoDescricao, $oClassificao->texto_comparar) !== false) {
                $iClassificacao = $oClassificao->produto_classificacao_id;
                break;
            }
        }

        return $iClassificacao ?: $iClassificacaoDefault;
    }
}
