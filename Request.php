<?php
/**
 * Request data.
 * @todo set public to all methods.
 * @todo write comments
 * @todo correct media-types
 * @todo mediat-type-table
 * @todo на хуй убрать переменные
 */
class Backend_Request
{   
    private $extMime = array(
        'js'=>'application/json',
        'json'=>'application/json',
        'xml'=>'text/xml',
        'html'=>'text/html'
    );

    protected $path;
    protected $pathParts;
    protected $httpRequest;
    protected $jsonRequest;
    protected $post;
    protected $headers;
    protected $postData;
    protected $wants;

    /**
     * Constructor. Reads environment variables (request uri, host, etc.)
     * @todo for remote_addrs: proxy handling.
     */
    public function __construct()
    {
        // lowercase to all header names.
        if (function_exists('getallheaders')) {
            $this->headers = getallheaders();
            $keys = array_keys($this->headers);

            $keys = array_map(
                create_function('$k', 'return strtolower($k);'), $keys
            );
            $this->headers = array_combine($keys, array_values($this->headers));
        }

        $p = parse_url($_SERVER['REQUEST_URI']);
        $this->path = $p['path'];
        $this->pathParts = split('/', $this->path);
        $this->pathParts = array_filter($this->pathParts, create_function('$el', 'return $el!="";'));

        $this->httpRequest = array_merge($_GET, $_POST);
        $this->postData = file_get_contents('php://input');
        $a = json_decode($this->getPostData(), true);
        $this->jsonRequest = is_array($a) ? $a : array();

        $this->request = array_merge($this->getJsonRequest(), $this->getHttpRequest());

        $this->wants = $this->whatHeWants();
    }

    /** 
     * Determines client's accept MIME-type.
     */
    protected function whatHeWants() 
    {
        $type = 'text/html';

        $parts = pathinfo($this->path);

        if ($parts['extension']) {
            if (isset($this->extMime[$parts['extension']]))
                return $this->extMime[$parts['extension']];
        }

        $xrq = $this->getHeader('X-Requested-With');
        if (strtolower($xrq) == 'xmlhttprequest') {
            $type = 'application/json';
        }

        return $type;        
    }

    /**
     * Returns HTTP method.
     */
    public function getMethod() 
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
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
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Gets port.
     */
    function getPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * Gets request query variables (join of GET and POST).
     */
    function getHttpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * Returns result of JSON deserializing raw post data.
     */
    function getJsonRequest() {
        return $this->jsonRequest;
    }

    /** 
     * Returns query (merged GET, POST and Json queries).
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * Returns request headers.
     */
    function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Returns request header by name.
     */
    function getHeader($name)
    {
        $name = strtolower($name);
        return $this->headers[$name];
    }

    /**
     * Returns remote IP address.
     */
    function getRemoteAddr()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns raw post data.
     */
    function getPostData() {
        return $this->postData;
    }

    /**
     * Returns MIME-type of client request.
     */
    function wants() {
        return $this->wants;
    }

    /**
     * Returns request parameter or default value.
     */
    public function getRequestParameter($name, $default = null)
    {
        $request = $this->getRequest();
        if ($request[$name]) {
            return $request[$name];
        } else {
            return $default;
        }
    }

    public function hasFiles()
    {
        return count($_FILES == 0);
    }

    public function getFile($id)
    {
        return $_FILES[$id];
    }
}
?>