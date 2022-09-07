<?php

namespace App\Exceptions;

use Exception;

class ServiceException extends Exception
{
    protected $message;
    protected $status_code;

    /**
     * @param int $status_code
     * @param string $message
     */
    public function __construct($message, $status_code) {
        $this->message = $message;
        $this->status_code = $status_code;
    }

    public function getStatusCode() {
        return $this->status_code;
    }
}
