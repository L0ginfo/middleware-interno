<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * TabelasPrecosModal Entity
 *
 * @property int $id
 * @property int $modal_id
 * @property int $tabela_preco_id
 *
 * @property \App\Model\Entity\Modal $modal
 * @property \App\Model\Entity\TabelasPreco $tabelas_preco
 */
class TabelasPrecosModal extends Entity
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
        
        'modal_id' => true,
        'tabela_preco_id' => true,
        'modal' => true,
        'tabelas_preco' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function insertManyTabelasPrecosModais($tabela_preco_id, $modais_id = []){

        if(empty($modais_id) || empty($tabela_precos_id)){
            return;
        }
        
        foreach ($modais_id as $key => $value) {
            LgDbUtil::saveNew('TabelasPrecosModais', [
                'tabela_preco_id' => $tabela_preco_id, 
                'modal_id' => $value, 
                'sequencia' => $key
            ]);
        }
    }

    public static function updateManyTabelasPrecosModais($tabela_preco_id, $inclusao = [], $delecao = [] , $sequencias = []){

        if(empty($inclusao) && empty($delecao)){
            return;
        }

        if(!empty($delecao)){
            LgDbUtil::deleteAll('TabelasPrecosModais', [
                'tabela_preco_id' => $tabela_preco_id,
                'modal_id IN' => $delecao
            ]);
        }

        if(!empty($inclusao)){
            foreach ($inclusao as $key => $value) {
                LgDbUtil::saveNew('TabelasPrecosModais', [
                    'tabela_preco_id' => $tabela_preco_id, 
                    'modal_id' => $value, 
                    'sequencia' => array_search($value, $sequencias)
                ]);
            }
        }
    }
}
