<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * TabelasPrecosTiposFaturamento Entity
 *
 * @property int $id
 * @property int $tabela_preco_id
 * @property int $sequencia
 * @property int $tipo_faturamento_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\TiposFaturamento $tipos_faturamento
 */
class TabelasPrecosTiposFaturamento extends Entity
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
        'tabela_preco_id' => true,
        'sequencia' => true,
        'tipo_faturamento_id' => true,
        'tabelas_preco' => true,
        'tipos_faturamento' => true
    ];

    public static function insertManyTiposFaturamento($tabela_preco_id, $tipos_faturamento_id = []){

    
        if(empty($tipos_faturamento_id) || empty($tabela_precos_id)){
            return;
        }
        
        foreach ($tipos_faturamento_id as $key => $value) {
            LgDbUtil::saveNew('TabelasPrecosTiposFaturamentos', [
                'tabela_preco_id' => $tabela_preco_id, 
                'tipo_faturamento_id' => $value, 
                'sequencia' => $key
            ]);
        }
    }

    public static function updateManyTiposFaturamentos($tabela_preco_id, $inclusao = [], $delecao = [] , $sequencias = []){

        if(empty($inclusao) && empty($delecao)){
            return;
        }

        if(!empty($delecao)){
            LgDbUtil::deleteAll('TabelasPrecosTiposFaturamentos', [
                'tabela_preco_id' => $tabela_preco_id,
                'tipo_faturamento_id IN' => $delecao
            ]);
        }

        if(!empty($inclusao)){
            foreach ($inclusao as $key => $value) {
                LgDbUtil::saveNew('TabelasPrecosTiposFaturamentos', [
                    'tabela_preco_id' => $tabela_preco_id, 
                    'tipo_faturamento_id' => $value, 
                    'sequencia' => array_search($value, $sequencias)
                ]);
            }
        }
    }
}
