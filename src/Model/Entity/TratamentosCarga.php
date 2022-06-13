<?php
namespace App\Model\Entity;

use App\Util\DateUtil;
use App\Util\LgDbUtil;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use DateTime;

/**
 * TratamentosCarga Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string $codigo
 */
class TratamentosCarga extends Entity
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
        'descricao' => true,
        'codigo' => true,
        'limite_horas_vencimento' => true,
    ];

    public function getTratamentoViaMantra( $that, $sCodigoProcedencia )
    {
        $sCodigo = 'TC' . $sCodigoProcedencia;
        $oProcedencia = $that->TratamentosCargas->find()
            ->where([
                'codigo' => $sCodigo
            ])
            ->first();

        if (!$oProcedencia) { 
            $aData = [
                'descricao' => $sCodigo,
                'codigo' => $sCodigo
            ];
            $oProcedencia = $that->TratamentosCargas->newEntity($aData);
            $oProcedencia = $that->TratamentosCargas->save($oProcedencia);
        }

        return $oProcedencia->id;
    }

    public function calculaDataLimite($dInicio){   
        if($this->limite_horas_vencimento <= 0) return $dInicio;
        if(empty($dInicio)) return $dInicio;
        $oTime = new Time($dInicio);
        $sAddTime = '+'.$this->limite_horas_vencimento.' hours';
        $oTime->modify($sAddTime);
        return $oTime;
    }

    public static function getDataLimiteTc4($dDataDescarga){
        $oTratamento = LgDbUtil::getFirst('TratamentosCargas', ['codigo' => 'TC4']);
        if(empty($oTratamento)) return $dDataDescarga;
        return $oTratamento->calculaDataLimite($dDataDescarga);

    }
}
