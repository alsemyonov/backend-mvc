<?php
/**
 * Transforms and passes data to view template.
 */
class Backend_Mvc_View
{
    var $viewRenderer;
    var $fileName;

    function __construct($class, $fileName)
    {
        $this->viewRenderer = $this->createViewRenderer($class);
        $this->fileName = $fileName;
    }

    function createViewRenderer($class)
    {
        return $class.'ViewRenderer';
    }

    function show($data, $response)
    {
        $renderer = $this->viewRenderer;
        $renderer->setVariables($data);
        if ($this->fileName) $renderer->load($this->fileName);
        $response->print($renderer->format());
    }
}
?>