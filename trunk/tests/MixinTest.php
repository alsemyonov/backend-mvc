<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Backend/Mixin.php';
require_once 'Backend/Mixin/Exception/MethodNotFound.php';

class FooMixin
{
    function a()
    {
        return 3;
    }
};

class BarMixin
{
    function b()
    {
        return 4;
    }

    function a()
    {
        return 5;
    }
};

class FooBar extends Backend_Mixin
{
    function __construct() 
    {
    }

    function load() 
    {
        $this->loadMixin('FooMixin');
        $this->loadMixin('BarMixin');
    }
};

class MixinTest extends PHPUnit_Framework_TestCase
{
    public function testMethodNotFound() {
        $this->setExpectedException('Backend_Mixin_Exception_MethodNotFound');

        $fb = new FooBar();
        $fb->xxx();
    }

    public function testIsCallable() {
        $fb = new FooBar();
        $fb->load();

        $this->assertTrue($fb->isCallable('a'));
        $this->assertTrue($fb->isCallable('b'));
        $this->assertFalse($fb->isCallable('z'));
    }

    public function testSimple() {
        $fb = new FooBar();
        $fb->load();

        $this->assertTrue($fb->a() == 3);
        $this->assertTrue($fb->b() == 4);
    }
}