<?php
/**
 * Base controller class (using it as base Controller class is optional).
 *
 * @todo text/javascript: html/javascript and another javascript- MIME. Implement header-view mapping.
 * @todo default view class.
 * @todo change view class for page (args?).
 * @todo Backend_Mvc_IHashView
 */
class Backend_Mvc_Controller
{
    protected $ajaxMethods;

    /**
     * Creates view. Type of a view depends on Accept header.
     * XsltView for text/html. JsonView for text/javascript.
     */
    function createView($ret, $viewName, $req) {
        $accept = $req->getHeader('Accept');
        if (strpos($accept, 'text/javascript') !== false) {
            $view = new Backend_Mvc_View_Json();
            return $view->setHash($ret);
        } else {
            $view = new Backend_Mvc_View_TemplateXslt();
            return $view->fromHash($ret)->resolve($viewName);
        }
    }

    /**
     * Ajax dispatch method
     */
    function ajax($req, $res, $args)
    {      
        $method = $args['methodName'];
        if (!$method) $method = array_pop($req->getPathParts());
        if ($this->ajaxMethods[$method]) $method = $this->ajaxMethods[$method];

        if (!method_exists($this, $method)) return false;
        $r = $this->$method($req, $args);

        return $this->createView($r, $args['view'], $req);
    }

    /**
     * Displays empty page.
     */
    function index($req, $res, $args)
    {
        return $this->createView(array(), $args['view'], $req);
    }

    /**
     * Default authentification function.
     */
    static function auth($auth) {
        $cgiAuth = $_REQUEST['http_authorization'];
        if ($cgiAuth)
        {
            $auth = split( ' ', $cgiAuth);
            $loginPw = split( ':', base64_decode( $auth[1] ) );
            
            $_SERVER['PHP_AUTH_USER'] = $loginPw[ 0 ];
            $_SERVER['PHP_AUTH_PW'] = $loginPw[ 1 ];
        }

        if ($_REQUEST['logout']) {
            header('WWW-Authenticate: Basic realm="'.$realm.'"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        }

        if (!isset($_SERVER['PHP_AUTH_USER'])) 
        {
            header('WWW-Authenticate: Basic realm="'.$realm.'"');
            header('HTTP/1.0 401 Unauthorized');
            die;
        } else {
            if (($_SERVER['PHP_AUTH_USER'] != $auth) || ($_SERVER['PHP_AUTH_PW'] != $auth))
            {
                header('WWW-Authenticate: Basic realm="'.$realm.'"');
                header('HTTP/1.0 401 Unauthorized');
                die;
            }
        }
    }

}