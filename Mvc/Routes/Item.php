<?php
/**
 * ������� ����� ������� ��� �����, ������������� MVC.
 */
class Backend_Mvc_Routes_Item extends Backend_Routes_Item
{
    /**
     * ���, ��������� � �������.
     * @var string
     */
    protected $view = null;

    /**
     * ������ ��������.
     * @var array
     */
    protected $action = array();

    /** 
     * ������������� ��� ��� ������.
     */
    function view($view)
    {
        return $this->param('view', $view);
    }

    /**
     * ��������� ��������.
     */
    function action()
    {
        $this->action = func_get_args();

        return $this;
    }

    /**
     * ��������� ���������� ��������.
     */
    function getAction()
    {
        return $this->action;
    }

    /**
     * ����� ������ ��������.
     */
    function using($template)
    {
        parent::using($template);
        $this->view = $template->view;
        $this->action = array_merge($this->action, $template->getAction());
        return $this;
    }
}
?>
