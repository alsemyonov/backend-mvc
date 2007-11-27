<?
abstract class Backend_CL_Control
{
    private $cfg;

    function __construct($cfg)
    {
        $this->cfg = $cfg;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getName()
    {
        return $this->name;
    }

    function getChildren()
    {
    }

    function addChild($child)
    {
    }

    function addChilds()
    {
    }

    function removeChild()
    {
    }

    abstract function render();
}
?>