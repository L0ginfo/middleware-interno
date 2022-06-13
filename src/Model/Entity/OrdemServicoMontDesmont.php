<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrdemServicoMontDesmont Entity
 *
 * @property int $id
 * @property int|null $ordem_servico_id
 * @property int|null $produto_id
 * @property float|null $quantidade_solicitada
 * @property float|null $quantidade_mont_desmont
 *
 * @property \App\Model\Entity\OrdemServico $ordem_servico
 * @property \App\Model\Entity\Produto $produto
 */
class OrdemServicoMontDesmont extends Entity
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
        
        'ordem_servico_id' => true,
        'produto_id' => true,
        'quantidade_solicitada' => true,
        'quantidade_mont_desmont' => true,
        'ordem_servico' => true,
        'produto' => true,
    
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public static $aTipos = [
        'DESUNITIZACAO', 
        'UNITIZACAO'
    ];

    public static $DESUNITIZACAO = 'DESUNITIZACAO';
    public static $UNITIZACAO = 'UNITIZACAO';


    public static function isUnitizacao($oTipo){
       return $oTipo->descricao == self::$UNITIZACAO;
    }

    public static function isDesUnitizacao($oTipo){
        return $oTipo->descricao == 'DESUNITIZACAO';
    }

    public static function isUnitizacaoMD($oOrdemMountDesmont){
        return $oOrdemMountDesmont->ordem_servico_tipo->descricao == self::$UNITIZACAO;
    }
 
    public static function isDesUnitizacaoMD($oOrdemMountDesmont){
        return $oOrdemMountDesmont->ordem_servico_tipo->descricao == self::$DESUNITIZACAO;
    }

    public static function isUnitizacaoString($sTipo){
        return  $sTipo == self::$UNITIZACAO;
    }
 
    public static function isDesUnitizacaoString($sTipo){
        return  $sTipo == self::$DESUNITIZACAO;
    }
}
