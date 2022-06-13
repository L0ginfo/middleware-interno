<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class ProgramacaoContainerLacre extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveProgramacaoContainerLacres($that, $aDataLacres, $iProgramacaoContainerID, $aDocumentos = [])
    {
        $aLacres = json_decode($aDataLacres['lacres_json'], true);
        $aLacres = $aLacres ?: [];
        self::removeLacresDeletados($aLacres, $iProgramacaoContainerID);
        if ($aDocumentos) {
            $oProgramacaoContainer = LgDbUtil::getByID('ProgramacaoContainers', $iProgramacaoContainerID);
            foreach ($aDocumentos as $key => $iDocId) {
                $aLacresDoc = LgDbUtil::getFind('Lacres')
                    ->where([
                        'documento_transporte_id' => $iDocId,
                        'container_id' => $oProgramacaoContainer->container_id
                    
                    ])
                    ->toArray();
    
                foreach ($aLacresDoc as $oLacre) {
                    $oProgLacre = [
                        'lacre_numero' => $oLacre->descricao,
                        'lacre_tipo_id' => $oLacre->lacre_tipo_id,
                        'programacao_container_id' => $iProgramacaoContainerID
                    ];

                    LgDbUtil::getOrSaveNew('ProgramacaoContainerLacres', $oProgLacre);
                }
            }
        } else {
            foreach ($aLacres as $aLacre) {

                if ($aLacre['id']) {
                    $aProgramacaoContainerLacresIDs[] = $aLacre['id'];
                }
    
                $aData = [
                    'id'                => $aLacre['id'],
                    'lacre_numero'      => $aLacre['lacre_descricao'],
                    'lacre_tipo_id'     => $aLacre['lacre_tipo_id'],
                    'programacao_container_id' => $iProgramacaoContainerID,
                ];
    
                if (!$aData['id']) {
                    $oProgramacaoContainerLacreEntity = LgDbUtil::get('ProgramacaoContainerLacres')->newEntity($aData);
                    LgDbUtil::get('ProgramacaoContainerLacres')->save($oProgramacaoContainerLacreEntity);
                    $aProgramacaoContainerLacresIDs[] = $oProgramacaoContainerLacreEntity->id;
                }
    
            }    
        }

    }

    public static function removeLacresDeletados($aLacres, $iProgramacaoContainerID)
    {
        $aProgramacaoContainerLacresIDs = [];
        foreach ($aLacres as $aLacre) {
            if ($aLacre['id']) 
                $aProgramacaoContainerLacresIDs[] = $aLacre['id'];
        }

        if ($aProgramacaoContainerLacresIDs) {
            $oLacres = LgDbUtil::get('ProgramacaoContainerLacres')->find()
                ->where([
                    'id NOT IN'         => $aProgramacaoContainerLacresIDs, 
                    'programacao_container_id' => $iProgramacaoContainerID
                ])->toArray();

            $aLacresIDs = [];
            foreach ($oLacres as $oLacre) 
                $aLacresIDs[] = $oLacre->id;

            if ($aLacresIDs)
                LgDbUtil::get('ProgramacaoContainerLacres')->deleteAll(array('id IN' => $aLacresIDs), false);
        }
    }

    public static function getStringAndJsonLacres($aProgramacaoContainerLacres)
    {
        if (!$aProgramacaoContainerLacres)
            return false;

        $aStringAndJson['json'] = json_encode($aProgramacaoContainerLacres);
        $sNumerosLacres = '';
        foreach ($aProgramacaoContainerLacres as $aProgramacaoContainerLacre) {
            
            $sNumerosLacres .= $aProgramacaoContainerLacre->lacre_numero . ",";
            $aStringAndJson['string'] = $sNumerosLacres;

        }

        return $aStringAndJson;
    }

    public static function deleteProgramacaoContainerLacres($aLacres)
    {
        $iProgramacaoContainerLacresIDs = [];
        foreach ($aLacres as $aLacre) {
            $iProgramacaoContainerLacresIDs[] = $aLacre->id;
        }

        if ($iProgramacaoContainerLacresIDs)
            LgDbUtil::get('ProgramacaoContainerLacres')->deleteAll(array('ProgramacaoContainerLacres.id IN' => $iProgramacaoContainerLacresIDs), false);

    }
}
