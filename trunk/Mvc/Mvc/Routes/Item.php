<?php
require_once 'Backend/Routes/Item.php';

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
    protected $actions = array();

    /** 
     * ������������� ��� ��� ������.
     */
    function view($view)
    {
        $this->view = $view;
        return $this;
    }

    /** 
     * ���������� ���.
     */
    function getView()
    {
        return $this->view;
    }

    /**
     * ��������� ��������.
     */
    function action()
    {
        $this->actions[] = func_get_args();

        return $this;
    }

    /**
     * ��������� ���������� ��������.
     */
    function getActions()
    {
        return $this->actions;
    }

    /**
     * ����� ������ ��������.
     */
    function using($template)
    {
        parent::using($template);
        $this->view = $template->view;
        $this->action = array_merge($this->actions, $template->actions);
        return $this;
    }
}
?>
