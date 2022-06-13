<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * CredenciamentoPerfilArea Entity
 *
 * @property int $id
 * @property int $credenciamento_perfil_id
 * @property int $controle_acesso_area_id
 *
 * @property \App\Model\Entity\CredenciamentoPerfi $credenciamento_perfi
 * @property \App\Model\Entity\ControleAcessoArea $controle_acesso_area
 */
class CredenciamentoPerfilArea extends Entity
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
        
        'credenciamento_perfil_id' => true,
        'controle_acesso_area_id' => true,
        'credenciamento_perfi' => true,
        'controle_acesso_area' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function consisteManyAreas($iPerfilId, $aData)
    {
        $aDataSelected = array_filter($aData, function($selected) {
            return $selected != 0;
        });

        $aCredenciamentoPerfilAreas = LgDbUtil::getFind('CredenciamentoPerfilAreas')
            ->where([
                'credenciamento_perfil_id' => $iPerfilId
            ])
            ->toArray();

        $aControleAcessoAreaIds = array_reduce($aCredenciamentoPerfilAreas, function($carry, $oCredenciamentoPerfilArea) {
            $carry[] = $oCredenciamentoPerfilArea->controle_acesso_area_id;

            return $carry;
        }, []);

        $aAreasEntities = [];
        $aIdsToRemove = array_filter($aControleAcessoAreaIds, function($iControleAcessoArea) use ($aDataSelected, $aControleAcessoAreaIds) {
            return !in_array($iControleAcessoArea, array_intersect($aDataSelected, $aControleAcessoAreaIds));
        });
        $aDataSelectedWithoutIntersect = array_filter($aDataSelected, function($selected) use ($aDataSelected, $aControleAcessoAreaIds) {
            return !in_array($selected, array_intersect($aDataSelected, $aControleAcessoAreaIds));
        });

        foreach ($aDataSelectedWithoutIntersect as $selected) {
            
            $aAreasEntities[] = LgDbUtil::get('CredenciamentoPerfilAreas')->newEntity([
                'credenciamento_perfil_id' => $iPerfilId,
                'controle_acesso_area_id' => $selected
            ]);
        }

        if ($aAreasEntities)
            LgDbUtil::get('CredenciamentoPerfilAreas')->saveMany($aAreasEntities);

        if ($aIdsToRemove) {
            LgDbUtil::get('CredenciamentoPerfilAreas')->deleteAll([
                'controle_acesso_area_id IN' => $aIdsToRemove
            ]);
        }


    }
}
