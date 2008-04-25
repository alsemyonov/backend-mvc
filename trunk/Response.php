<?php
/**
 * Response class.
 * @todo header functions: lcase.
 */
class Backend_Response
{
    protected $out;
    protected $headers = array();
    protected $encoding = null;
    protected $contentType = null;
    protected $code = null;

    /**
     * Sets response header.
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Sets response code.
     */
    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * Gets response header.
     */
    public function getHeader($name)
    {
        return $this->headers[$name];
    }

    /**
     * Gets response headers.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Sets response encoding.
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * Gets response encoding.
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sets current content-type.
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * Gets current content-type.
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Echoes data to internal output buffer.
     */
    public function out($str)
    {
        $this->out .= $str;
    }

    /**
     * Returns output buffer.
     */
    public function getOutput()
    {
        return $this->out;
    }

    /**
     * Redirects user's browser.
     * @param bool $force If true, redirecting made immediately, function calls die().
     */
    public function redirect($url, $force = true)
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
    public function notFound() 
    {
        $this->setCode('404 Not Found');
    }

    /**
     * Sends response to user.
     */
    public function send()
    {
        if (($this->encoding) || ($this->contentType)) {
            $contentType = $this->contentType ? $this->contentType : 'text/html';
            $this->setHeader('Content-type', $contentType.($this->encoding ? '; charset='.$this->encoding : '' ) );
        }
        if ($this->code) {
            header('HTTP/1.0 '.$this->code);
        }
        foreach($this->getHeaders() as $name=>$header)
        {
            header($name.': '.$header);
        }

        echo $this->getOutput();
    }
}
?>