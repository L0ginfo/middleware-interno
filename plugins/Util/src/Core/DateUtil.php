<?php 
namespace Util\Core;

use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use DateTime;

class DateUtil
{
    public static function getNowTime()
    {
        return new Time;
    }

    /*
    *  Formata data para ir para o banco
    */
    public static function dateTimeToDB($sDateTime, $format = 'Y-m-d H:i', $after = ':00') 
    {
        if(strlen($sDateTime) == 0)
            return null;

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
        if(strlen($sDateTime) == 0)
            return null;
        
        if ($sDateTime instanceof Time) {
            $sDateTime = $sDateTime->format($format);
        }
        else {
            $sDateTime = new Time($sDateTime);
            $sDateTime = $sDateTime->format($format);        
        }
        
        $sDateTime = str_replace(' ', $inner, $sDateTime);
        return $sDateTime;
    }

    /*
    *  Adiciona tempo à data passada
    *  $date->modify('+2 hours');
    */
    public static function addTime($sDateTime, $format, $add)
    {
        $date = new Date($sDateTime);

        $date->modify($add);

        return $date->format($format);
    }

    public static function addTimeMinutes($sDateTime, $format, $add)
    {
        $date = new DateTime($sDateTime);

        $date->modify($add);

        return $date->format($format);
    }

    public static function addDateUtil($sDateTime, $format, $days)
    {
        $countDays = 0;
        $date = date_create($sDateTime);
        
        while ($countDays != $days) {
            $newDate = date_modify($date, '+1 day');
            $dayOfWeek = $newDate->format('w');
            if (!in_array($dayOfWeek, [0, 6])) {
                $countDays++;
            }
        }

        $time = date('H:i', $newDate->getTimestamp());

        if (!($time >= '08:00' && $time <= '18:00')) {
            if ($time < '08:00') {
                $newDate->setTime(8, 00);
            } else {
                $newDate = date_modify($newDate, '+1 day');
                $newDate->setTime(8, 00);
            }
        }
        
        return DateUtil::dateTimeToDB($newDate->format($format));
    }

}
?>