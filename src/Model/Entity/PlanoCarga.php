<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * PlanoCarga Entity
 *
 * @property int $id
 * @property int|null $planejamento_maritimo_id
 * @property int|null $unidade_medida_id
 * @property int|null $sentido_id
 * @property int|null $tipo_mercadoria_id
 * @property \Cake\I18n\Date|null $emissao
 *
 * @property \App\Model\Entity\PlanejamentoMaritimo $planejamento_maritimo
 * @property \App\Model\Entity\UnidadeMedida $unidade_medida
 * @property \App\Model\Entity\Sentido $sentido
 * @property \App\Model\Entity\TipoMercadoria $tipo_mercadoria
 * @property \App\Model\Entity\PlanoCargaDocumento[] $plano_carga_documentos
 * @property \App\Model\Entity\PlanoCargaPorao[] $plano_carga_poroes
 */
class PlanoCarga extends Entity
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
        
        'planejamento_maritimo_id' => true,
        'unidade_medida_id' => true,
        'sentido_id' => true,
        'tipo_mercadoria_id' => true,
        'emissao' => true,
        'planejamento_maritimo' => true,
        'unidade_medida' => true,
        'sentido' => true,
        'tipo_mercadoria' => true,
        'plano_carga_documentos' => true,
        'plano_carga_poroes' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];


    public function isGranel(){
        $oTipoMercadoria = LgDbUtil::getFirst('PlanoCargaTipoMercadorias', ['id' => $this->tipo_mercadoria_id]);

        if(empty($oTipoMercadoria)){
            return false;
        }

        return $oTipoMercadoria->codigo == 'GRANEL';
    }
}
