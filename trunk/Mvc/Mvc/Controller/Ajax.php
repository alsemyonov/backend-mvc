<?php
/* @todo Блядская кодировка. UTF globalizing? */
class Backend_Mvc_Controller_Ajax
{
    function ajax($req, $res, $args)
    {
        $view = new Backend_Mvc_View_Json();

        $method = array_pop($req->getPathParts());

        if (!method_exists($this, $method)) return false;

        $r = call_user_func_array(array($this, $method), array($req, $args));

        return $view->setHash($r);
    }
}
?>