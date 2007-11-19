<?php
require_once 'Routes/Item.php';

class Backend_Mvc_Routes extends Backend_Routes
{
    function create()
    {
        return new Backend_Mvc_Routes_Item();
    }
}
?>