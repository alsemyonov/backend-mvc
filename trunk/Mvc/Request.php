<?php
/**
 * Interface to request data.
 *
 * @todo _GET/_POST?
 */
class Backend_Mvc_Request
{   
    protected $path;
    protected $pathParts;
    protected $host;
    protected $port;
    protected $query;
    protected $post;
    protected $headers;
    protected $remoteAddr;

    /**
     * 
     */
    function __construct()
    {
        $this->headers = getallheaders();
        $p = parse_url($_SERVER['REQUEST_URI']);
        $this->path = $p['path'];
        $this->pathParts = split('/', $this->path);
        $this->pathParts = array_filter($this->pathParts, create_function('$el', 'return $el=="";'));
        $this->port = $_SERVER['SERVER_PORT'];
        $this->query = array_merge($_GET, $_POST);
        $this->remoteAddr = $_SERVER['REMOTE_ADDR'];
        $this->host = $_SERVER['HTTP_HOST'];
    }

    function getPath()
    {
        return $this->path;
    }

    function getPathParts()
    {
        return $this->pathParts;
    }

    function getHost()
    {
        return $this->host;
    }

    function getPort()
    {
        return $this->port;
    }

    function getQuery()
    {
        return $this->query;
    }

    function getHeaders()
    {
        return $this->headers;
    }

    function getHeader($name)
    {
        return $this->headers[$name];
    }

    function getRemoteAddr()
    {
        return $this->remoteAddr;
    }
}
?>