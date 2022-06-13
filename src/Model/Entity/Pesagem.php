<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Pesagem Entity
 *
 * @property int $id
 * @property int $resv_id
 *
 * @property \App\Model\Entity\Resv $resv
 * @property \App\Model\Entity\PesagemVeiculo[] $pesagem_veiculos
 */
class Pesagem extends Entity
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
        
        'resv_id' => true,
        'resv' => true,
        'pesagem_veiculos' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static function geraCapaPesagens($oPesagem)
    {
        self::geraCapaCavalo($oPesagem);
        //self::geraCapaReboques($oPesagem);
    }

    private static function geraCapaReboques($oPesagem)
    {
        $aResvsVeiculos = LgDbUtil::get('ResvsVeiculos')->find()
            ->contain([
                'Veiculos'
            ])
            ->where(['ResvsVeiculos.resv_id' => $oPesagem->resv_id])
            ->toArray();

        foreach ($aResvsVeiculos as $oResvVeiculo) {
            $oAlreadyCreated = LgDbUtil::get('PesagemVeiculos')->find()
                ->where([
                    'veiculo_id' => $oResvVeiculo->veiculo_id,
                    'pesagem_id' => $oPesagem->id
                ])->first();

            if ($oAlreadyCreated) 
                continue;

            self::saveCapaVeiculo($oResvVeiculo->veiculo_id, $oPesagem->id);
        }
    }

    private static function geraCapaCavalo($oPesagem)
    {
        $oResv = LgDbUtil::get('Resvs')->find()
            ->contain([
                'Veiculos'
            ])
            ->where(['Resvs.id' => $oPesagem->resv_id])
            ->first();

        $oVeiculo = $oResv->veiculo;

        $oAlreadyCreated = LgDbUtil::get('PesagemVeiculos')->find()
            ->where([
                'veiculo_id' => $oVeiculo->id,
                'pesagem_id' => $oPesagem->id
            ])->first();

        if ($oAlreadyCreated) {
            return;
        }

        self::saveCapaVeiculo($oVeiculo->id, $oPesagem->id, 1);
    }

    private static function saveCapaVeiculo($iVeiculoID, $iPesagemID, $iCavalo = 0) 
    {
        LgDbUtil::get('PesagemVeiculos')->save(
            LgDbUtil::get('PesagemVeiculos')->newEntity([
                'cavalo'     => $iCavalo,
                'veiculo_id' => $iVeiculoID,
                'pesagem_id' => $iPesagemID
            ])
        );
    }

    public static function getPesagemRegistros($oResv)
    {
        if (!$oResv || !$oResv->id)
            return [];

        $aPesagemVeiculoRegistros = LgDbUtil::getFind('PesagemVeiculoRegistros')
            ->contain([
                'PesagemVeiculos' => [
                    'Pesagens'
                ]
            ])
            ->where([
                'Pesagens.resv_id' => $oResv->id
            ])
            ->toArray();

        return $aPesagemVeiculoRegistros;
    }
}
