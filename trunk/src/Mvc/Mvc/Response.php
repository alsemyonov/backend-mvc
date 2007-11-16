<?php
class Backend_Mvc_Response
{
    protected $out;
    protected $handlers = array();
    protected $headers = array();

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
    }

    function getHeaders()
    {
    }

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

    function out()
    {
        $s = call_user_func_array("sprintf", func_get_args());
        $this->out .= $s;
    }

    function getOutput()
    {
        return $this->out;
    }
}
?>