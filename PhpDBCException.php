<?php
/**
 * Created by PhpStorm.
 * User: Pawel
 * Date: 2016-05-02
 * Time: 14:16
 */

class PhpDBCException extends Exception {

    public function __construct($message = null, $code = 0) {
        parent::__construct($message , $code);
    }

} 