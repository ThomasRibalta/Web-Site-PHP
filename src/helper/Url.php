<?php

namespace App\Helper;

class Url {  

  /**
   * getIntValue method to get the value of a parameter in the URL (only integer values)
   *
   * @param  mixed $value
   * @param  mixed $Null
   * @return int
   */
  public static function getIntValue(string $value, bool $Null = false) : int {
    if (!isset($_GET[$value]) && $Null === false) {
      return 1;
    }
    if (!isset($_GET[$value]) && $Null === true) {
      return 0;
    }
    if ($_GET[$value] === '0' && $Null === false) {
      return 1;
    }
    if ($_GET[$value] === '0' && $Null === true) {
      return 0;
    }
    $value = (int)$_GET[$value];
    if ($value <= 0) {
      return 1;
    }
    return $value;
  }
}