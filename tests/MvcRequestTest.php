<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Backend/Mvc/Request.php';

class MvcRequestTest extends PHPUnit_Framework_TestCase
{
    public function testMethod() 
    {
        $_SERVER['REQUEST_METHOD'] = 'post';

        $r = new Backend_Mvc_Request();

        $this->assertTrue($r->getMethod() == 'POST');
    }

    public function testPathRelated()
    {
        $_SERVER['REQUEST_URI'] = '/test/how/it/splits/';

        $r = new Backend_Mvc_Request();
        $this->assertTrue(count($r->getPathParts()) == 4);

        $_SERVER['REQUEST_URI'] = '/test///how/it//splits////';

        $r = new Backend_Mvc_Request();
        $this->assertTrue(count($r->getPathParts()) == 4);
    }

    public function testWants()
    {
        $_SERVER['REQUEST_URI'] = '/test/get.html';

        $r = new Backend_Mvc_Request();
        $this->assertTrue($r->wants() == 'text/html');

        $_SERVER['REQUEST_URI'] = '/test/get.js';

        $r = new Backend_Mvc_Request();
        $this->assertTrue($r->wants() == 'text/javascript');

        $_SERVER['REQUEST_URI'] = '/test/get.html/get.xml';

        $r = new Backend_Mvc_Request();
        $this->assertTrue($r->wants() == 'text/xml');
        
        $_SERVER['REQUEST_URI'] = '/test/get.shit';

        $r = new Backend_Mvc_Request();
        $this->assertTrue($r->wants() == 'text/html');
    }
}
?>
