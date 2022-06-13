<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use stdClass;

/**
 * Checklist Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $descricao_detalhada
 * @property string|null $footer
 * @property int $checklist_tipo_id
 *
 * @property \App\Model\Entity\ChecklistTipo $checklist_tipo
 * @property \App\Model\Entity\ChecklistPergunta[] $checklist_perguntas
 * @property \App\Model\Entity\ChecklistResv[] $checklist_resvs
 */
class Checklist extends Entity
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
        
        'descricao' => true,
        'descricao_detalhada' => true,
        'footer' => true,
        'checklist_tipo_id' => true,
        'checklist_tipo' => true,
        'checklist_perguntas' => true,
        'checklist_resvs' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function getParamDescarga()
    {
        $sParam = ParametroGeral::getParametroWithValue('PARAM_HABILITA_CHECKLIST_GENERICO_DESCARGA_CARGA_GERAL') ?: '{}';
        $oParam = json_decode($sParam);

        if (!$oParam) {
            $oParam = new stdClass();
            $oParam->ativo = 0;
            $oParam->checklist_id = 0;
        }
        
        return $oParam;
    }
}
