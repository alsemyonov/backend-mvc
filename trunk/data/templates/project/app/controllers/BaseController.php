<?php
class BaseController
{
    function createView($ret, $viewName, $req) {
        $accept = $req->getHeader('Accept');
        if (strpos($accept, 'text/javascript') != FALSE) {
            $view = new Backend_Mvc_View_Json();
        } else {
            $view = new Backend_Mvc_View_TemplateXslt();
        }
        return $view->fromHash($ret)->resolve($viewName);
    }

    function ajax($req, $res, $args)
    {
        $method = array_pop($req->getPathParts());
        if (!method_exists($this, $method)) return false;
        $r = $this->$method($req, $args);

        return $this->createView($r, $args['view'], $req);
    }

    function index($req, $res, $args)
    {
        return $this->createView(array(), $args['view'], $req);
    }
}