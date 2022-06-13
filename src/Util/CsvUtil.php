<?php

namespace App\Util;

class CsvUtil 
{

    public static function toArray($sFilename = '', $cDelimiter = ';')
    {
        if (!file_exists($sFilename) || !is_readable($sFilename))
            return FALSE;

        $header = NULL;
        $data = array();

        if (($handle = fopen($sFilename, 'r')) !== FALSE) {

            while (($row = fgetcsv($handle, 1000, $cDelimiter)) !== FALSE) {

                foreach ($row as $key => $value) {
                    unset($row[$key]);
                    $row[trim($key)] = trim($value);
                }

                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);

            }

            fclose($handle);
        }
        
        return $data;
    }

    public static function extractFields($aData, $aFields) 
    {
        $aNewData = [];

        foreach ($aData as $rowKey => $rowValue) {

            foreach ($rowValue as $key => $value) {

                if (array_key_exists($key, $aFields)){
                    $aNewData[$rowKey][$aFields[$key]] = $value;
                }

            }

        }

        return $aNewData;
    }
    
}
