<?php
require_once 'Backend/Mvc/Routes.php';

class Backend_Mvc_Routes extends Backend_Routes
{
    function create()
    {
        return new Backend_Mvc_Routes_Item();
    }
}
?>