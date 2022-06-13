<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * ResvsVeiculo Entity
 *
 * @property int $id
 * @property int $sequencia_veiculo
 * @property int $veiculo_id
 * @property int $resv_id
 *
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\Resv $resv
 */
class ResvsVeiculo extends Entity
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
        'sequencia_veiculo' => true,
        'veiculo_id' => true,
        'resv_id' => true,
        'veiculo' => true,
        'resv' => true
    ];

    public static function saveReboques($aReboquesFront, $iResvID) 
    {
        $aVeiculoReboqueIDs = [];
        $aCondition = ['resv_id' => $iResvID];
        $aResvsVeiculos = LgDbUtil::getFind('ResvsVeiculos')->where($aCondition)->toArray();

        foreach ($aReboquesFront as $iSequenciaReboque => $aReboqueFront) {
            if ($aReboqueFront['veiculo_id']) {
                $aVeiculoReboqueIDs[$iSequenciaReboque] = $aReboqueFront['veiculo_id'];
            }
        }
        
        if (!$aVeiculoReboqueIDs) {

            if ($aResvsVeiculos)
                LgDbUtil::get('ResvsVeiculos')->deleteAll($aCondition);

            return false;
        }

        $aResvsVeiculosDelete = LgDbUtil::getFind('ResvsVeiculos');

        foreach ($aVeiculoReboqueIDs as $iSequenciaReboque => $aVeiculoReboque) {
            $aData['OR'][] = [
                'veiculo_id IS NOT' => $aVeiculoReboque,
                'sequencia_veiculo IS' => $iSequenciaReboque + 1,
                'resv_id' => $iResvID
            ];
            
        }
        $aResvsVeiculosDelete = $aResvsVeiculosDelete->where($aData);
        $aResvsVeiculosDelete = $aResvsVeiculosDelete->extract('id')->toArray();
        
        if ($aResvsVeiculosDelete) {
            LgDbUtil::get('ResvsVeiculos')->deleteAll([
                'id IN' => $aResvsVeiculosDelete
            ]);
        }

        $aResvsVeiculosInsert = [];
        $aResvsVeiculos = LgDbUtil::getFind('ResvsVeiculos')->where($aCondition)->toArray();

        foreach ($aVeiculoReboqueIDs as $iSequenciaReboque => $iVeiculoID) {
            $bInsere = true;
            $iSequenciaReboque++;
            
            foreach ($aResvsVeiculos as $oResvVeiculo) {
                if ($oResvVeiculo->sequencia_veiculo == $iSequenciaReboque && $oResvVeiculo->veiculo_id == $iVeiculoID) {
                    $bInsere = false;
                }
            }

            if (!$bInsere)
                continue; 

            $aResvsVeiculosInsert[] = [
                'veiculo_id'        => $iVeiculoID,
                'sequencia_veiculo' => $iSequenciaReboque,
                'resv_id'           => $iResvID
            ];
        }

        foreach ($aResvsVeiculosInsert as $aResvVeiculo) {
            LgDbUtil::saveNew('ResvsVeiculos', $aResvVeiculo);
        }

        return true;
    }
}
