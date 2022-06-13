<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * TabelasPrecosTratamento Entity
 *
 * @property int $id
 * @property int $tabela_preco_id
 * @property int $sequencia
 * @property int $tratamento_id
 *
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 * @property \App\Model\Entity\TratamentosCarga $tratamentos_carga
 */
class TabelasPrecosTratamento extends Entity
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
        'tratamento_id' => true,
        'tabelas_preco' => true,
        'tratamentos_carga' => true
    ];


    public static function insertManyTratamentos($tabela_preco_id, $tratamentos_id = []){

        if(empty($tratamentos_id) || empty($tabela_preco_id)){
            return;
        }
        
        foreach ($tratamentos_id as $key => $value) {
            LgDbUtil::saveNew('TabelasPrecosTratamentos', [
                'tabela_preco_id' => $tabela_preco_id, 
                'tratamento_id' => $value, 
                'sequencia' => $key
            ]);
        }
    }

    public static function updateManyTratamentos($tabela_preco_id, $inclusao = [], $delecao = [] , $sequencias = []){

        if(empty($inclusao) && empty($delecao)){
            return;
        }

        if(!empty($delecao)){
            LgDbUtil::deleteAll('TabelasPrecosTratamentos', [
                'tabela_preco_id' => $tabela_preco_id,
                'tratamento_id IN' => $delecao
            ]);
        }

        if(!empty($inclusao)){
            foreach ($inclusao as $key => $value) {
                LgDbUtil::saveNew('TabelasPrecosTratamentos', [
                    'tabela_preco_id' => $tabela_preco_id, 
                    'tratamento_id' => $value, 
                    'sequencia' => array_search($value, $sequencias)
                ]);
            }
        }
    }
}
