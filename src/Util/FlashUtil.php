<?php

/**
 * Autor: Silvio Regis da Silva Junior
 */

namespace App\Util;

class FlashUtil 
{
  public static function doResponse($oThat, $oResponse)
  {
    if (!$oResponse || !is_object($oResponse) || !$oThat || !is_object($oThat))
      return false;
  
    $sType = $oResponse->getStatus() == 200
      ? 'success'
      : ($oResponse->getStatus() != 400
          ? 'warning'
          : 'error');

    $oThat->Flash->{$sType}('', ['params' => [
      'title' => $oResponse->getTitle(),
      'html' => '<br>' . $oResponse->getMessage()
    ]]);

  }

}