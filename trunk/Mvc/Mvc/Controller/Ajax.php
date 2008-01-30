<?php
/* @todo �������� ���������. UTF globalizing? */
class Backend_Mvc_Controller_Ajax
{
    function getView() {
        $view = new Backend_Mvc_View_Json();
        return $view;
    }

    function ajax($req, $res, $args)
    {
        $view = $this->getView();

        $method = array_pop($req->getPathParts());

        if (!method_exists($this, $method)) return false;

        $r = $this->$method($req, $args); // ��������� ������� � ������������������. �� � ��������, �����.

        return $view->setHash($r);
    }
}
?>