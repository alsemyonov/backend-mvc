<?php
/**
 * @todo header functions: lcase.
 */
class Backend_Mvc_Response
{
    protected $out;
    protected $headers = array();
    protected $handlers = array();

    /**
     * Registers output filter.
     */
    function addOutputFilter($callback)
    {
        $this->handlers[] = $callback;
    }

    function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    function getHeader($name)
    {
        return $this->headers[$name];
    }

    function getHeaders()
    {
        return $this->headers;
    }

/*
    function setEncoding()
    {
    }

    function getEncoding()
    {
    }

    function setContentType()
    {
    }

    function getContentType()
    {
    }
*/

    /**
     * "Echo sprintf(...)" to internal output buffer.
     */
    function out($str)
    {
        $this->out .= $str;
    }

    /**
     * Returns output buffer.
     * @todo Handlers...
     */
    function getOutput()
    {
        return $this->out;
    }

    /**
     * Redirect function.
     */
    function sendRedirect($url)
    {
    }

    function send()
    {
        // hgeaders
        echo $this->getOutput();
    }
}
?>