<?php
class Backend_Exception_PageNotFound extends Backend_Exception {
    public function __construct($message = '', $code = 0) 
    {
        $message = 'Page not found';
        header('HTTP/1.0 Not Found');
        parent::__construct($message, $code);
    }
}
