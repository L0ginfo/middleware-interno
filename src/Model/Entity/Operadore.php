<?php
namespace App\Model\Entity;

use App\Util\ErrorUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Operadore Entity
 *
 * @property int $id
 * @property string|null $descricao
 */
class Operadore extends Entity
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
        'descricao' => true
    ];

    public static function getResultValidacao( $oOperador, $sValor, $sValorInicio, $sValorFim )
    {
        if (!isset( $oOperador ))
            return [
                'message' => __('Objeto de Operação não foi vinculado à sua Operação atual!'),
                'status'  => 400
            ];

        if ($oOperador->descricao == 'entre') {
            if ($sValor >= $sValorInicio && $sValor <= $sValorFim) 
                return [
                    'message' => __('OK'),
                    'status'  => 200
                ];
            else
                return [
                    'message' => __('Não passou na validação "'.$oOperador->descricao.'", com os dados: '.$sValorInicio.' <= '. $sValor.' >= '.$sValorFim),
                    'status'  => 406
                ];
        }elseif ($oOperador->descricao == 'igual'){
            if ($sValor == $sValorInicio) 
                return [
                    'message' => __('OK'),
                    'status'  => 200
                ];
            else
                return [
                    'message' => __('Não passou na validação "'.$oOperador->descricao.'", com os dados: '.$sValorInicio.' == '. $sValor),
                    'status'  => 406
                ];
        }elseif ($oOperador->descricao == 'diferente'){
            if ($sValor != $sValorInicio) 
                return [
                    'message' => __('OK'),
                    'status'  => 200
                ];
            else
                return [
                    'message' => __('Não passou na validação "'.$oOperador->descricao.'", com os dados: '.$sValorInicio.' != '. $sValor),
                    'status'  => 406
                ];
        }elseif ($oOperador->descricao == 'menor'){
            if ($sValor < $sValorInicio) 
                return [
                    'message' => __('OK'),
                    'status'  => 200
                ];
            else
                return [
                    'message' => __('Não passou na validação "'.$oOperador->descricao.'", com os dados: '.$sValorInicio.' < '. $sValor),
                    'status'  => 406
                ];
        }elseif ($oOperador->descricao == 'maior'){
            if ($sValor > $sValorInicio) 
                return [
                    'message' => __('OK'),
                    'status'  => 200
                ];
            else
                return [
                    'message' => __('Não passou na validação "'.$oOperador->descricao.'", com os dados: '.$sValorInicio.' > '. $sValor),
                    'status'  => 406
                ];
        }elseif ($oOperador->descricao == 'menor ou igual'){
            if ($sValor <= $sValorInicio) 
                return [
                    'message' => __('OK'),
                    'status'  => 200
                ];
            else
                return [
                    'message' => __('Não passou na validação "'.$oOperador->descricao.'", com os dados: '.$sValorInicio.' <= '. $sValor),
                    'status'  => 406
                ];
        }elseif ($oOperador->descricao == 'maior ou igual'){
            if ($sValor <= $sValorInicio) 
                return [
                    'message' => __('OK'),
                    'status'  => 200
                ];
            else
                return [
                    'message' => __('Não passou na validação "'.$oOperador->descricao.'", com os dados: '.$sValorInicio.' >= '. $sValor),
                    'status'  => 406
                ];
        }

        return [
            'message' => __('Validação "'.$oOperador->descricao.'" não programada ainda'),
            'status'  => 401
        ];
    }

}
