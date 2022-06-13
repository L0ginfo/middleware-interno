<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * ProgramacaoVeiculo Entity
 *
 * @property int $id
 * @property int $veiculo_id
 * @property int $programacao_id
 *
 * @property \App\Model\Entity\Veiculo $veiculo
 * @property \App\Model\Entity\Programacao $programacao
 */
class ProgramacaoVeiculo extends Entity
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
        
        'veiculo_id' => true,
        'programacao_id' => true,
        'veiculo' => true,
        'programacao' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function saveReboques($aReboquesFront, $iProgramacaoID) 
    {
        $aVeiculoReboqueIDs = [];
        $aCondition = ['programacao_id' => $iProgramacaoID];
        $aProgramacaoVeiculos = LgDbUtil::getFind('ProgramacaoVeiculos')->where($aCondition)->toArray();

        foreach ($aReboquesFront as $iSequenciaReboque => $aReboqueFront) {
            if ($aReboqueFront['veiculo_id']) {
                $aVeiculoReboqueIDs[$iSequenciaReboque] = $aReboqueFront['veiculo_id'];
            }
        }
        
        if (!$aVeiculoReboqueIDs) {

            if ($aProgramacaoVeiculos)
                LgDbUtil::get('ProgramacaoVeiculos')->deleteAll($aCondition);

            return false;
        }

        $aProgramacaoVeiculosDelete = LgDbUtil::getFind('ProgramacaoVeiculos');

        foreach ($aVeiculoReboqueIDs as $iSequenciaReboque => $aVeiculoReboque) {
            $aData['OR'][] = [
                'veiculo_id IS NOT' => $aVeiculoReboque,
                'sequencia_veiculo IS' => $iSequenciaReboque + 1,
                'programacao_id' => $iProgramacaoID
            ];
        }

        $aProgramacaoVeiculosDelete = $aProgramacaoVeiculosDelete->where($aData);
        $aProgramacaoVeiculosDelete = $aProgramacaoVeiculosDelete->extract('id')->toArray();
        
        if ($aProgramacaoVeiculosDelete) {
            LgDbUtil::get('ProgramacaoVeiculos')->deleteAll([
                'id IN' => $aProgramacaoVeiculosDelete
            ]);
        }

        $aProgramacaoVeiculosInsert = [];
        $aProgramacaoVeiculos = LgDbUtil::getFind('ProgramacaoVeiculos')->where($aCondition)->toArray();

        foreach ($aVeiculoReboqueIDs as $iSequenciaReboque => $iVeiculoID) {
            $bInsere = true;
            $iSequenciaReboque++;
            
            foreach ($aProgramacaoVeiculos as $oProgramacaoVeiculo) {
                if ($oProgramacaoVeiculo->sequencia_veiculo == $iSequenciaReboque && $oProgramacaoVeiculo->veiculo_id == $iVeiculoID) {
                    $bInsere = false;
                }
            }

            if (!$bInsere)
                continue; 

            $aProgramacaoVeiculosInsert[] = [
                'veiculo_id'        => $iVeiculoID,
                'sequencia_veiculo' => $iSequenciaReboque,
                'programacao_id'           => $iProgramacaoID
            ];
        }

        foreach ($aProgramacaoVeiculosInsert as $aProgramacaoVeiculo) {
            LgDbUtil::saveNew('ProgramacaoVeiculos', $aProgramacaoVeiculo);
        }

        return true;
    }
}
