<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * ResvContainerLacre Entity
 *
 * @property int $id
 * @property string $lacre_numero
 * @property int $lacre_tipo_id
 * @property int $resv_container_id
 *
 * @property \App\Model\Entity\LacreTipo $lacre_tipo
 * @property \App\Model\Entity\ResvsContainer $resvs_container
 */
class ResvContainerLacre extends Entity
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
        
        'lacre_numero' => true,
        'lacre_tipo_id' => true,
        'resv_container_id' => true,
        'lacre_tipo' => true,
        'resvs_container' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveResvContainerLacres($that, $aDataLacres, $iResvContainerID, $aDocumentos = [])
    {
        $aLacres = json_decode($aDataLacres['lacres_json'], true);

        self::removeLacresDeletados($aLacres, $iResvContainerID);

        if ($aDocumentos) {
            $oResvContainer = LgDbUtil::getByID('ResvsContainers', $iResvContainerID);
            foreach ($aDocumentos as $key => $iDocId) {
                $aLacresDoc = LgDbUtil::getFind('Lacres')
                    ->where([
                        'documento_transporte_id' => $iDocId,
                        'container_id' => $oResvContainer->container_id
                    ])
                    ->toArray();
    
                foreach ($aLacresDoc as $oLacre) {
                    $oProgLacre = LgDbUtil::get('ResvContainerLacres')->newEntity([
                        'lacre_numero' => $oLacre->descricao,
                        'lacre_tipo_id' => $oLacre->lacre_tipo_id,
                        'resv_container_id' => $iResvContainerID
                    ]);

                    LgDbUtil::get('ResvContainerLacres')->save($oProgLacre);
                }
            }
        }

        foreach ($aLacres as $aLacre) {

            if ($aLacre['id']) {
                $aResvContainerLacresIDs[] = $aLacre['id'];
            }

            $aData = [
                'id'                => $aLacre['id'],
                'lacre_numero'      => $aLacre['lacre_descricao'],
                'lacre_tipo_id'     => $aLacre['lacre_tipo_id'],
                'resv_container_id' => $iResvContainerID,
            ];

            $oEntityResvContainerLacres = TableRegistry::getTableLocator()->get('ResvContainerLacres');

            $that->loadModel('ResvContainerLacres');
            $entidadeResvContainerLacres = $that->setEntity('ResvContainerLacres', $aData);

            $entidadeResvContainerLacres = $oEntityResvContainerLacres->patchEntity($entidadeResvContainerLacres, $aData);
            $oEntityResvContainerLacres->save($entidadeResvContainerLacres);
            $aResvContainerLacresIDs[] = $entidadeResvContainerLacres->id;

        }

    }

    public static function removeLacresDeletados($aLacres, $iResvContainerID)
    {
        $aResvContainerLacresIDs = [];
        foreach ($aLacres as $aLacre) {
            if ($aLacre['id']) 
                $aResvContainerLacresIDs[] = $aLacre['id'];
        }

        if ($aResvContainerLacresIDs) {
            $oEntityResvContainerLacres = TableRegistry::getTableLocator()->get('ResvContainerLacres');
            $oLacres = $oEntityResvContainerLacres->find()
                ->where([
                    'id NOT IN'         => $aResvContainerLacresIDs, 
                    'resv_container_id' => $iResvContainerID
                ])->toArray();

            $aLacresIDs = [];
            foreach ($oLacres as $oLacre) 
                $aLacresIDs[] = $oLacre->id;

            if ($aLacresIDs)
                $oEntityResvContainerLacres->deleteAll(array('id IN' => $aLacresIDs), false);
        }
    }

    public static function getStringAndJsonLacres($aResvContainerLacres)
    {
        if (!$aResvContainerLacres)
            return false;

        $aStringAndJson['json'] = json_encode($aResvContainerLacres);
        $sNumerosLacres = '';
        foreach ($aResvContainerLacres as $aResvContainerLacre) {
            
            $sNumerosLacres .= $aResvContainerLacre->lacre_numero . ",";
            $aStringAndJson['string'] = $sNumerosLacres;

        }

        return $aStringAndJson;
    }

    public static function deleteResvContainerLacres($aLacres)
    {
        $iResvContainerLacresIDs = [];
        foreach ($aLacres as $aLacre) {
            $iResvContainerLacresIDs[] = $aLacre->id;
        }

        if ($iResvContainerLacresIDs)
            TableRegistry::getTableLocator()->get('ResvContainerLacres')->deleteAll(array('ResvContainerLacres.id IN' => $iResvContainerLacresIDs), false);

    }
}
