<?php
require_once 'Backend/Routes/Item.php';

/**
 * Элемент карты адресов для сайта, использующего MVC.
 */
class Backend_Mvc_Routes_Item extends Backend_Routes_Item
{
    /**
     * Вид, связанный с адресом.
     * @var string
     */
    protected $view = null;

    /**
     * Массив действий.
     * @var array
     */
    protected $actions = array();

    /** 
     * Устанавливает вид для адреса.
     */
    function view($view)
    {
        $this->view = $view;
        return $this;
    }

    /** 
     * Возвращает вид.
     */
    function getView()
    {
        return $this->view;
    }

    /**
     * Добавляет действие.
     */
    function action()
    {
        $this->actions[] = func_get_args();

        return $this;
    }

    /**
     * Добавляет возвращает действия.
     */
    function getActions()
    {
        return $this->actions;
    }

    /**
     * Задаёт шаблон элемента.
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
