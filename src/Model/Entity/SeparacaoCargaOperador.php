<?php
namespace App\Model\Entity;

use App\Util\EntityUtil;
use App\Util\ResponseUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * SeparacaoCargaOperador Entity
 *
 * @property int $id
 * @property int $usuario_operador_id
 * @property int $separacao_carga_id
 *
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\SeparacaoCarga $separacao_carga
 */
class SeparacaoCargaOperador extends Entity
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
        'usuario_operador_id' => true,
        'separacao_carga_id' => true,
        'usuario' => true,
        'separacao_carga' => true,
    ];

    public static function setSeparacaoOperadores($aSeparacaoOperadores)
    {
        $oResponse = new ResponseUtil;

        foreach ($aSeparacaoOperadores as $aSeparacaoOperador) {
            TableRegistry::get('SeparacaoCargaOperadores')->deleteAll([
                'separacao_carga_id' => $aSeparacaoOperador['separacao_carga_id']
            ]);

            if (!$aSeparacaoOperador['operadores']) 
                continue;

            foreach ($aSeparacaoOperador['operadores'] as $key => $iOperador) {
                
                if (!$iOperador)
                    continue;

                $oSeparacaoOperador = TableRegistry::get('SeparacaoCargaOperadores')->newEntity([
                    'separacao_carga_id' => $aSeparacaoOperador['separacao_carga_id'],
                    'usuario_operador_id' => $iOperador
                ]);
    
                if ($oSeparacaoOperador->getErrors())
                    return $oResponse->setMessage(EntityUtil::dumpErrors($oSeparacaoOperador))->getArray();
    
                TableRegistry::get('SeparacaoCargaOperadores')->save($oSeparacaoOperador);
            }
        }

        return $oResponse->setMessage('OK')->setStatus(200);
    }
}