<?php
/**
 * Handles response.
 * @todo header functions: lcase.
 * @todo outputfilter process
 * @todo output filter throug native methods?
 */
class Backend_Mvc_Response
{
    protected $out;
    protected $headers = array();
    protected $handlers = array();
    protected $encoding = null;
    protected $contentType = null;
    protected $responseCode = null;

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

    function setResponseCode($code) {
        $this->responseCode = $code;
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
    function sendRedirect($url, $force = true)
    {
        header('Location: ' . $url);
        if ($force) {
            die();
        }
    }

    /**
     * Sets 404 Not Found request header.
     */
    function notFound() {
        $this->setResponseCode('404 Not Found');
    }

    function send()
    {
        if (($this->encoding) || ($this->contentType)) {
            $contentType = $this->contentType ? $this->contentType : 'text/html';
            $this->setHeader('Content-type', $contentType.($this->encoding ? '; charset='.$this->encoding : '' ) );
        }
        if ($this->responseCode) {
            header('HTTP/1.0 '.$this->responseCode);
        }
        foreach($this->getHeaders() as $name=>$header)
        {
            header($name.': '.$header);
        }

        echo $this->getOutput();
    }
}
?>