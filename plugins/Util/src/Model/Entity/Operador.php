<?php
namespace Util\Model\Entity;

use Util\Core\ErrorUtil;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Operadore Entity
 *
 * @property int $id
 * @property string|null $descricao
 */
class Operador extends Entity
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

    public static function getResultValidacao( $oOperador, $uValor, $uValorInicio, $uValorFim )
    {
        $sValor = self::toString($uValor);
        $sValorInicio =  self::toString($uValorInicio); 
        $sValorFim = self::toString($uValorFim);

        if (!isset( $oOperador ))
            return [
                'message' => __('Objeto de Operação não foi vinculado à sua Operação atual!'),
                'status'  => 400
            ];

        if ($oOperador->descricao == 'entre') {
            if ($uValor >= $uValorInicio && $uValor <= $uValorFim) 
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
            if ($uValor == $uValorInicio) 
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
            if ($uValor != $uValorInicio) 
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
            if ($uValor < $uValorInicio) 
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
            if ($uValor > $uValorInicio) 
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
            if ($uValor <= $uValorInicio) 
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
            if ($uValor <= $uValorInicio) 
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

    public static function getSymbolExpression($sOperador = 'null')
    {
        $sSymbol = '';

        $oOperador = TableRegistry::get('Operadores')->find()
            ->where([
                'descricao' => $sOperador
            ])
            ->first();

        if (!$oOperador)
            ErrorUtil::custom(__('O Operador condicional') . ' '. __('"' . $sOperador . '"') . ' ' . __('não está cadastrado no banco!'));

        switch ($oOperador->descricao) {
            case 'igual':
                $sSymbol = '[field] = [aspas][field_value][aspas]';
                break;

            case 'diferente':
                $sSymbol = '[field] <> [aspas][field_value][aspas]';
                break;

            case 'menor':
                $sSymbol = '[field] < [aspas][field_value][aspas]';
                break;

            case 'maior':
                $sSymbol = '[field] > [aspas][field_value][aspas]';
                break;

            case 'entre':
                $sSymbol = '[field] BETWEEN [aspas][field_value][aspas] and [aspas][field_value][aspas]';
                break;

            case 'menor ou igual':
                $sSymbol = '[field] <= [aspas][field_value][aspas]';
                break;

            case 'maior ou igual':
                $sSymbol = '[field] >= [aspas][field_value][aspas]';
                break;

            case 'contem':
                $sSymbol = '[field] LIKE([aspas]%[field_value]%[aspas])';
                break;
            
            default:
                ErrorUtil::custom(__('O Operador condicional') . ' '. __('"' . $sOperador . '"') . ' ' . __('não está parametrizado!'));
                break;
        }

        return $sSymbol;
    }

    public static function toString($uValue){

        if ($uValue instanceof \DateTime){
            return $uValue->format('Y-m-d H:i:s');
        }

        return $uValue;
    }
}
