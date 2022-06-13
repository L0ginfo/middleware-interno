<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Util\DoubleUtil;

/**
 * TermoAvaria Entity
 *
 * @property int $id
 * @property string $termo_codigo
 * @property float $volume
 * @property float $peso
 * @property float $lacre
 * @property int $avaria_id
 * @property int $ordem_servico_id
 * @property int $ordem_servico_item_id
 *
 * @property \App\Model\Entity\Avaria $avaria
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\OrdemServicoItem $ordem_servico_item
 */
class TermoAvaria extends Entity
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
        'termo_codigo' => true,
        'volume' => true,
        'peso' => true,
        'lacre' => true,
        'avaria_id' => true,
        'ordem_servico_id' => true,
        'ordem_servico_item_id' => true,
        'avaria' => true,
        'ordem_servico' => true,
        'ordem_servico_item' => true
    ];

    public function saveTermoAvaria( $that, $aAvarias, $iOSItemID, $iNumTermo )
    {
        if (!$aAvarias)
            return [
                'message' => 'OK',
                'status'  => 200
            ];

        $aDataReturn = array();

        foreach ($aAvarias as $keyAvaria => $aAvaria) {
            $aAvaria['ordem_servico_item_id'] = $iOSItemID;
            $aAvaria['termo_codigo'] = $iNumTermo;
            $aAvaria['volume'] =  ($aAvaria['volume']) ? DoubleUtil::toDBUnformat($aAvaria['volume']) : 0;
            $aAvaria['peso']   =  ($aAvaria['peso'])   ? DoubleUtil::toDBUnformat($aAvaria['peso'])   : 0;
            $aAvaria['lacre']  =  ($aAvaria['lacre'])  ? DoubleUtil::toDBUnformat($aAvaria['lacre'])  : 0;

            $oAvaria = $that->setEntity('TermoAvarias', $aAvaria);
            $isNew   = $oAvaria->isNew();
            $oAvaria = $that->TermoAvarias->patchEntity($oAvaria, $aAvaria);

            $result = $that->TermoAvarias->save($oAvaria);
            
            if ($isNew)
                $aDataReturn['avarias'][]['id'] = $oAvaria->id;
        }

        return [
            'message'   => 'OK',
            'status'    => 200,
            'dataExtra' => $aDataReturn
        ];
    }
}
