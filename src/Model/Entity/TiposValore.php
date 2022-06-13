<?php
namespace App\Model\Entity;

use App\Util\LgDbUtil;
use Cake\ORM\Entity;

/**
 * TiposValore Entity
 *
 * @property int $id
 * @property string $descricao
 * @property string|null $formula
 */
class TiposValore extends Entity
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
        'formula' => true
    ];

    public static function calculaValorDinamico( $that, $dValor, $dValorMinimo, $iTipoValorID, $oObj, $iCampoValorSistemaID )
    {
        $oCampoValorSistema = LgDbUtil::get('SistemaCampos')->get( $iCampoValorSistemaID );
        $dValorCalculado = 0;
        $sCodigo = $oCampoValorSistema->codigo;
        $sCodigo = strtolower($sCodigo);
        
        if (strpos($sCodigo, '.') !== false)
            $sCodigo = explode('.', $sCodigo)[1];

        if (isset($oObj->{$sCodigo})) {
            $dCampoValor = $oObj->{$sCodigo};

            if ($iTipoValorID == 1){
                $dValorCalculado = $dValor * $dCampoValor;
            }else if ($iTipoValorID == 2){
                $dValorCalculado = $dCampoValor * (($dValor / 100));
            }
        }   
        
        if ($dValorMinimo)
            return ($dValorCalculado < $dValorMinimo) ? $dValorMinimo : $dValorCalculado;
        
        return $dValorCalculado;
    }
}
