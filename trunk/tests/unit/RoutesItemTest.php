<?php
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Backend/Routes/Item.php';

class RoutesItemTest extends PHPUnit_Framework_TestCase
{
    public function testSimple() {
        $item = new Backend_Routes_Item();
        $item->url('/root/');

        $this->assertTrue($item->match('/root/'));
        $this->assertFalse($item->match('/root'));
        $this->assertFalse($item->match('root/'));
    }

    public function testMatches() {
        $item = new Backend_Routes_Item();
        $item->url('/root/($one)/');

        $this->assertFalse($item->match('/root/'));

        $item->match('/root/1/', &$matches);
        $this->assertTrue($matches['one']==1);
        $this->assertFalse($item->match('/root/1', &$matches));
    }

    public function testSpecialSymbols() {
        $item = new Backend_Routes_Item();
        $item->url('/root/($one)/');

        $item->match('/root/__--./', &$matches);        
        $this->assertTrue($matches['one'] == '__--.');   
    }

    public function testDot() {
        $item = new Backend_Routes_Item();
        $item->url('/root/($one)');

        $item->match('/root/1.html', &$matches);        
        $this->assertTrue($matches['one'] == '1.html');       
    }

    public function testMultipleMasks() {
        $item = new Backend_Routes_Item();
        $item->url('/root/($one).($method)');

        $item->match('/root/1.html', &$matches);        
        $this->assertTrue($matches['one'] == '1');
        $this->assertTrue($matches['method'] == 'html');     
    }

    public function testMultipleMaskedUrl() {
        $item = new Backend_Routes_Item();
        $item->url('/root/($one).($method)');
        $item->url('/root/($one)');

        $item->match('/root/1.html', &$matches);        
        $this->assertTrue($matches['one'] == '1');
        $this->assertTrue($matches['method'] == 'html');

        $matches = array();       

        $item->match('/root/1', &$matches);
        $this->assertTrue($matches['one'] == '1');
        $this->assertTrue($matches['method'] == null);
    }

    public function testMaskAndExt() {
        $item = new Backend_Routes_Item();
        $item->url('/root/($one).js');

        $item->match('/root/one.js', &$matches);        
        $this->assertTrue($matches['one'] == 'one');
    }

}
?>
