<?php 

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use DateTime;
use Cake\ORM\TableRegistry;
use DateInterval;

class DateUtil
{
    private static $aWeekNames = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira','Quinta-Feira','Sexta-Feira', 'Sabado');

    private static $aWeekDays = array(
        'domingo' => 0, 'segunda' => 1, 'segunda-feira' => 1, 'terça' => 2, 'terça-feira' => 2,
        'quarta' => 3, 'quarta-feira' => 3, 'quinta' => 4, 'quinta-feira' => 4, 'sexta' => 5,
        'sexta-feira' => 5, 'sabado' => 6
    );

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
    *  Formata data vinda do banco
    */
    public static function dateTimeToHTML($oDateTime) {

        return $oDateTime
            ? $oDateTime->format('Y-m-d') . 'T' . $oDateTime->format('H:i')
            : '';

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

    public static function getNowToDB()
    {
        $date = date_create( date('Y-m-d H:i:s') );
        date_add($date, date_interval_create_from_date_string('3 hours'));

        return date_format($date, 'Y-m-d H:i:s');
    }

    /*
    *  Adiciona tempo à data passada
    *  $date->modify('+2 hours');
    *  $date->modify('-2 hours');
    */
    public static function addTimeDiaUtil($sDateTime, $format, $days, $type = '+')
    {
        $countDays = 0;
        $date = new Date($sDateTime);
        
        while ($countDays != $days) {
            $date = $date->modify( $type . '1 day' );
            $dayOfWeek = $date->format('w');
            $checkFeriado = LgDbUtil::getFirst('Feriados', ['date' => $date]);
            
            // 0 = sabado, 6 = domingo
            if (!in_array($dayOfWeek, [0, 6]) && !$checkFeriado) {
                $countDays++;
            }
        }
        
        return $date->format($format);
    }

    /*
    *  Adiciona tempo à data passada
    *  $date->modify('+2 hours');
    *  $date->modify('-2 hours');
    */
    public static function addTimeDia($sDateTime, $format, $days, $type = '+', 
    $week = [1,2,3,4,5], $bConsideraFeriados = true)
    {
        $countDays = 0;
        $date = new Date($sDateTime);
        
        while ($countDays != $days) {
            $checkFeriado = false;
            $date = $date->modify( $type . '1 day' );
            $dayOfWeek = $date->format('w');

            if($bConsideraFeriados) $checkFeriado = LgDbUtil::getFirst('Feriados', [
                'date' => $date
            ]);
            
            if (in_array($dayOfWeek, $week) && !$checkFeriado) {
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

    public static function getDiffDate($dDataHoraUm, $dDataHoraDois, $sFormart)
    {
        $sDiferenca = $dDataHoraUm->diff($dDataHoraDois, true);
        
        return $sDiferenca->format($sFormart);
    }


    public static function getIntervalDiff($dDataHoraUm, $dDataHoraDois, $sInterval = 's', $bRelative = false){

       $diff = date_diff( $dDataHoraUm, $dDataHoraDois, !$bRelative);
      
       switch($sInterval){
           case "y":
               $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
           case "m":
               $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
               break;
           case "d":
               $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
               break;
           case "h":
               $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
               break;
           case "i":
               $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
               break;
           case "s":
               $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
               break;
        }

       if($diff->invert) return -1 * $total;
       return $total;
   }


    public static function dayOfWeek($sData){
        $iDay = self::dateTimeFromDB(self::dateTimeToDB($sData), 'w');
        return self::$aWeekNames[$iDay];
    }

    public static function getNameDayOfWeek($iDaySemana){
        return self::$aWeekNames[$iDaySemana];
    }

    public static function getValueDayOfWeek($sDaySemana){
        return self::$aWeekDays[$sDaySemana];
    }

    public static function addMoreOneDay($sData) {
        return $sData->add(new DateInterval("P1D"));
    }

    public static function removeOneDay($sData) {
        return $sData->sub(new DateInterval("P1D"));
    }

}
?>
