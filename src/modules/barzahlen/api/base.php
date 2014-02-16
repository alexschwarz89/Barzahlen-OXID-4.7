<?php
/**
 * Barzahlen Payment Module SDK (OXID eShop)
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 of the License
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses/
 *
 * @copyright   Copyright (c) 2012 Zerebro Internet GmbH (http://www.barzahlen.de)
 * @author      Alexander Diebler
 * @license     http://opensource.org/licenses/GPL-3.0  GNU General Public License, version 3 (GPL-3.0)
 */

abstract class Barzahlen_Base {

  const APIDOMAIN = 'https://api.barzahlen.de/v1/transactions/'; //!< call domain (productive use)
  const APIDOMAINSANDBOX = 'https://api-sandbox.barzahlen.de/v1/transactions/'; //!< sandbox call domain

  const HASHALGO = 'sha512'; //!< hash algorithm
  const SEPARATOR = ';'; //!< separator character
  const MAXATTEMPTS = 2; //!< maximum of allowed connection attempts

  protected $_debug = false; //!< debug mode on / off
  protected $_logFile; //!< log file for debug output

  /**
   * Sets debug settings.
   *
   * @param boolean $debug debug mode on / off
   * @param string $logFile position of log file
   */
  final public function setDebug($debug, $logFile) {
    $this->_debug = $debug;
    $this->_logFile = $logFile;
  }

  /**
   * Write debug message to log file. -> modified for oxid
   *
   * @param string $message debug message
   * @param array $data related data (optional)
   */
  final protected function _debug($message, $data = array()) {

    if($this->_debug == true) {
      oxUtils::getInstance()->writeToLog(date('c') . " - " . $message . " - " . serialize($data) . "\n", $this->_logFile);
    }
  }

  /**
   * Generates the hash for the request array.
   *
   * @param array $requestArray array from which hash is requested
   * @param string $key private key depending on hash type
   * @return hash sum
   */
  final protected function _createHash(array $hashArray, $key) {

    $hashArray[] = $key;
    $hashString = implode(self::SEPARATOR, $hashArray);
    return hash(self::HASHALGO, $hashString);
  }

  /**
   * Removes empty values from arrays.
   *
   * @param array $array array with (empty) values
   */
  final protected function _removeEmptyValues(array &$array) {

    foreach($array as $key => $value) {
      if($value == '') {
        unset($array[$key]);
      }
    }
  }
}
?>