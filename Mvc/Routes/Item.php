<?php
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
    protected $action = array();

    /** 
     * Устанавливает вид для адреса.
     */
    function view($view)
    {
        return $this->param('view', $view);
    }

    /**
     * Добавляет действие.
     */
    function action()
    {
        $this->action = func_get_args();

        return $this;
    }

    /**
     * Добавляет возвращает действия.
     */
    function getAction()
    {
        return $this->action;
    }

    /**
     * Задаёт шаблон элемента.
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
