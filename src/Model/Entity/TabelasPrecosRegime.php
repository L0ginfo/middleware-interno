<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * TabelasPrecosRegime Entity
 *
 * @property int $id
 * @property int $tabela_preco_id
 * @property int $sequencia
 * @property int $regime_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\RegimesAduaneiro $regimes_aduaneiro
 */
class TabelasPrecosRegime extends Entity
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
        'regime_id' => true,
        'tabelas_preco' => true,
        'regimes_aduaneiro' => true
    ];

    public static function insertManyRegimes($tabela_preco_id, $regimes_id = []){

        if(empty($regimes_id) || empty($tabela_precos_id)){
            return;
        }
        
        foreach ($regimes_id as $key => $value) {
            LgDbUtil::saveNew('TabelasPrecosRegimes', [
                'tabela_preco_id' => $tabela_preco_id, 
                'regime_id' => $value, 
                'sequencia' => $key
            ]);
        }
    }

    public static function updateManyRegimes($tabela_preco_id, $inclusao = [], $delecao = [] , $sequencias =[]){

        if(empty($inclusao) && empty($delecao)){
            return;
        }

        if(!empty($delecao)){
            LgDbUtil::deleteAll('TabelasPrecosRegimes', [
                'tabela_preco_id' => $tabela_preco_id,
                'regime_id IN' => $delecao
            ]);
        }

        if(!empty($inclusao)){
            foreach ($inclusao as $key => $value) {
                LgDbUtil::saveNew('TabelasPrecosRegimes', [
                    'tabela_preco_id' => $tabela_preco_id, 
                    'regime_id' => $value, 
                    'sequencia' => array_search($value, $sequencias)
                ]);
            }
        }
    }
}
