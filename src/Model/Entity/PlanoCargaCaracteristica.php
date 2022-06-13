<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * PlanoCargaCaracteristica Entity
 *
 * @property int $id
 * @property int $plano_carga_id
 * @property int $caracteristica_id
 *
 * @property \App\Model\Entity\PlanoCarga $plano_carga
 * @property \App\Model\Entity\Caracteristica $caracteristica
 */
class PlanoCargaCaracteristica extends Entity
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
        'caracteristica_id' => true,
        'plano_carga' => true,
        'caracteristica' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public function isCliente(){
        $oTipoCaracteristica = @$this->tabela_tipo_caracteristica->tipo_caracteristica;
        return $oTipoCaracteristica && $oTipoCaracteristica->descricao == 'Cliente';
    }


    public function getCliente(){

        if(!$this->tabela_tipo_caracteristica || !is_numeric($this->tabela_tipo_caracteristica->valor)){
            return null;
        }
        
        if(!$this->isCliente()){
            return null;
        }

        return $this->tabela_tipo_caracteristica->valor;
    }

    public static function list($iPlanoCargaId){
       return LgDbUtil::get('PlanoCargaCaracteristicas')
            ->find('list', ['keyField' => 'id', 'valueField' => function($q){

                if($q->caracteristica){
                    $sTipo = $q->caracteristica->tipo_caracteristica->descricao;
                    $sValor = $q->caracteristica->descricao;
                    return "Tipo: $sTipo / Valor: $sValor";
                }

                if($q->tabela_tipo_caracteristica){
                    $sTipo = $q->tabela_tipo_caracteristica->tipo_caracteristica->descricao;
                    $sTabela = $q->tabela_tipo_caracteristica->tabela;
                    $sColuna = $q->tabela_tipo_caracteristica->coluna;
                    $svalor = $q->tabela_tipo_caracteristica->valor;
                    return "Tipo: $sTipo / Tabela: $sTabela / Coluna: $sColuna / Valor: $svalor";
                }

                return "Indefinido";
            }])
            ->where([
                'Plano_carga_id' => $iPlanoCargaId
            ])
            ->contain([
                'Caracteristicas' => 'TipoCaracteristicas',
                'TabelaTipoCaracteristicas' => 'TipoCaracteristicas'
            ])
            ->toArray();
    }
}
