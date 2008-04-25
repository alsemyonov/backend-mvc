<?php
class Backend_Exception_PageNotFound extends Backend_Exception 
{
    public function __construct() 
    {
        $message = 'Page not found';
        parent::__construct($message, $code);
    }
}
