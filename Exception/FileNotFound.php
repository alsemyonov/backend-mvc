<?
class Backend_Exception_FileNotFound extends Backend_Exception
{
    public function __construct($message, $code = 0) 
    {
        $message = 'File not found: '.$message;
        parent::__construct($message, $code);
    }
}