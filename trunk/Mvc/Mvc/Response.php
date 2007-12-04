<?php
/**
 * @todo header functions: lcase.
 */
class Backend_Mvc_Response
{
    protected $out;
    protected $headers = array();
    protected $handlers = array();
    protected $encoding = null;
    protected $contentType = null;

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

    function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    function getEncoding()
    {
        return $this->encoding;
    }

    function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    function getContentType()
    {
        return $this->contentType;
    }

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
        if (($this->encoding) || ($this->contentType)) {
            $contentType = $this->contentType ? $this->contentType : 'text/html';
            $this->setHeader('Content-type', $contentType.($this->encoding ? '; charset='.$this->encoding : '' ) );
        }
        foreach($this->getHeaders() as $name=>$header)
        {
            header($name.': '.$header);
        }

        echo $this->getOutput();
    }
}
?>