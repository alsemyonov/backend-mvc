<?php
/**
 * Request class.
 */
class Backend_Request
{   
    protected $path;
    protected $pathParts;
    protected $httpQuery;
    protected $jsonQuery;
    protected $post;
    protected $headers;
    protected $postData;
    protected $wants;

    /**
     * Constructor. Reads environment variables (request uri, host, etc.)
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
        $this->pathParts = array_values(array_filter($this->pathParts, create_function('$el', 'return $el!="";')));

        $this->httpQuery = array_merge($_GET, $_POST);
        $this->postData = file_get_contents('php://input');
        $a = json_decode($this->getPostData(), true);
        $this->jsonQuery = is_array($a) ? $a : array();

        $this->query = array_merge($this->getJsonQuery(), $this->getHttpQuery());

        $this->wants = $this->clientAccepts();
    }

    /** 
     * Determines client's accept MIME-type.
     */
    protected function clientAccepts() 
    {
        $parts = pathinfo($this->path);
        if ($parts['extension']) {
            switch($parts['extension']) {
                case 'js':
                case 'json':
                    return 'application/json';
                break;
                case 'xml':
                    return 'text/xml';
                break;
                case 'html':
                case 'php':
                    return 'text/html';
                break;
                default:
                    $xrq = $this->getHeader('X-Requested-With');
                    if (strtolower($xrq) == 'xmlhttprequest') {
                        return 'application/json';
                    }
                break;
            }
        }

        return 'text/html';
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Gets request path splitted by '/'.
     */
    public function getPathParts()
    {
        return $this->pathParts;
    }

    /**
     * Gets request HTTP host.
     */
    public function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Gets port.
     */
    public function getPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * Gets request query variables (join of GET and POST).
     */
    public function getHttpQuery()
    {
        return $this->httpQuery;
    }

    /**
     * Returns result of JSON deserializing raw post data.
     */
    function getJsonQuery() {
        return $this->jsonQuery;
    }

    /** 
     * Returns query (merged GET, POST and Json query parameters).
     * Merging priority: JSON <- GET <- POST
     */
    public public function getQuery() {
        return $this->query;
    }

    /**
     * Returns request headers.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Returns request header by name.
     */
    public function getHeader($name)
    {
        $name = strtolower($name);
        return $this->headers[$name];
    }

    /**
     * Returns remote IP address.
     */
    public function getRemoteAddr()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns raw post data.
     */
    public function getPostData() {
        return $this->postData;
    }

    /**
     * Returns MIME-type of client request.
     */
    public function wants() {
        return $this->wants;
    }

    /**
     * Returns request parameter or default value.
     */
    public function getParameter($name, $default = null)
    {
        return isset($this->query[$name]) ? $this->query[$name] : $default;
    }

    /**
     * Returns count of uploaded file.
     */
    public function hasFiles()
    {
        return count($_FILES == 0);
    }

    /**
     * Returns file by id.
     */
    public function getFile($id)
    {
        if (!is_array($_FILES[$id]['name'])) {
            return $_FILES[$id];
        } else {
            $files = array();
            $keys = array_keys($_FILES[$id]);
            foreach($_FILES[$id]['name'] as $n=>$value) {
                $file = array();
                foreach($keys as $key) {
                    $file[$key] = $_FILES[$id][$key][$n];
                }
                $files[] = $file;
            }
        }

        return $files;
    }

    /**
     * Returns all uploaded files.
     */
    public function getAllFiles() 
    {
        $files = array();
        foreach($_FILES as $id=>$file) {
            $files[] = $this->getFile($id);
        }
        return $files;
    }
}
?>