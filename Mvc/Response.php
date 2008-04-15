<?php
/**
 * Response data.
 * @todo header functions: lcase.
 */
class Backend_Mvc_Response
{
    protected $out;
    protected $headers = array();
    protected $encoding = null;
    protected $contentType = null;
    protected $responseCode = null;

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

    /**
     * Sets current content-type.
     */
    function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * Gets current content-type.
     */
    function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Echoes data to internal output buffer.
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
     * Redirects user's browser.
     * @param bool $force If true, redirecting made immediately, function calls die().
     */
    function redirect($url, $force = true)
    {
        if ($force) {
            header('Location: ' . $url);
            die();
        }

        $this->setHeader('Location', $url);
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