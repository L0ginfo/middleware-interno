<?php 

namespace Integrador\Util;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use DateTime;
use Cake\ORM\TableRegistry;

class DateUtil
{
    /*
    *  Formata data para ir para o banco
    */
    public static function dateTimeToDB($sDateTime, $format = 'Y-m-d H:i', $after = ':00') 
    {        
        if (!$sDateTime)
            return '';

        $sDateTime = str_replace('/', '-', $sDateTime);
        $sDateTime = date($format, strtotime($sDateTime)) . $after;
        $sDateTime = new Time($sDateTime);

        return $sDateTime;
    }

    /*
    *  Formata data vinda do banco
    */
    public static function dateTimeFromDB($sDateTime, $format = 'Y-m-d H:i', $inner = '') 
    {
        if (!$sDateTime)
            return '';

        if ($sDateTime instanceof Time) {
            $sDateTime = $sDateTime->format($format);
        }else {
            $sDateTime = new Time($sDateTime);
            $sDateTime = $sDateTime->format($format);        
        }
        
        $sDateTime = str_replace(' ', $inner, $sDateTime);

        // dd($sDateTime);
        
        return $sDateTime;
    }

    /*
    *  Adiciona tempo à data passada
    *  $date->modify('+2 hours');
    *  $date->modify('-2 hours');
    */
    public static function addTime($DateTime, $format, $add)
    {
        $date = new Date($DateTime);
        $date->modify($add);
        return $date->format($format);
    }

    /*
    *  Adiciona tempo à data passada
    *  $date->modify('+2 hours');
    *  $date->modify('-2 hours');
    */
    public static function addTimeDiaUtil($sDateTime, $format, $days, $type = '+')
    {
        $oFeriado = TableRegistry::locator()->get('Feriados')->find();
        $countDays = 0;
        $date = new Date($sDateTime);
        
        while ($countDays != $days) {
            $date = $date->modify( $type . '1 day' );
            $dayOfWeek = $date->format('w');
            $checkFeriado = $oFeriado->where(['date' => $date])->first();
            if (!in_array($dayOfWeek, [0, 6]) && !$checkFeriado) {
                $countDays++;
            }
        }
        
        return $date->format($format);
    }


    public static function dateFromIntegration($data){
        return new \Datetime(substr($data, 0, 4).'-'.substr($data, 4, 2).'-'.substr($data, 6)); 
    }

    public static function defautDatetime($DateTime = null){
        return new \Datetime ($DateTime?:'now');
    }

    public static function getDatetimeLocalForView($datetime){
        return self::dateTimeFromDB($datetime, 'Y-m-d H:i', 'T');
    }

    public static function getDateLocalForView($datetime){
        return self::dateTimeFromDB($datetime, 'Y-m-d', '');
    }
  
    public static function getNowTime()
    {
        return new Time;
    }

}
?>
