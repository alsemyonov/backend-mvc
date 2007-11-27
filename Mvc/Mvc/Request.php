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
    protected $method;

    /**
     * Constructor. Reads environment variables (request uri, host, etc.)
     * @todo for IP: proxy handling.
     */
    function __construct()
    {
        if (function_exists('getallheaders')) {
            $this->headers = getallheaders();
        }

        $p = parse_url($_SERVER['REQUEST_URI']);
        $this->path = $p['path'];
        $this->pathParts = split('/', $this->path);
        $this->pathParts = array_filter($this->pathParts, create_function('$el', 'return $el!="";'));
        $this->port = $_SERVER['SERVER_PORT'];
        $this->query = array_merge($_GET, $_POST);
        $this->remoteAddr = $_SERVER['REMOTE_ADDR'];
        $this->host = $_SERVER['HTTP_HOST'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Gets request path.
     */
    function getPath()
    {
        return $this->path;
    }

    /**
     * Gets request path splitted by '/'.
     */
    function getPathParts()
    {
        return $this->pathParts;
    }

    /**
     * Gets request HTTP host.
     */
    function getHost()
    {
        return $this->host;
    }

    /**
     * Gets port.
     */
    function getPort()
    {
        return $this->port;
    }

    /**
     * Gets query variables (join of GET and POST).
     */
    function getQuery()
    {
        return $this->query;
    }

    /**
     * Gets request headers.
     */
    function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Gets request header by name.
     *
     * @todo tolower() for header name and headers name in array.
     */
    function getHeader($name)
    {
        return $this->headers[$name];
    }

    /**
     * Gets remote IP address.
     */
    function getRemoteAddr()
    {
        return $this->remoteAddr;
    }

    /**
     * Returns HTTP method.
     */
    function getMethod()
    {
        return $this->method;
    }
}
?>