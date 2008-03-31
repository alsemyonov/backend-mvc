<?php
/**
 * Renders PHP template.
 * @todo Implement loadFromString.
 */
class Backend_Mvc_TemplateRenderer_Php extends Backend_Mvc_TemplateRenderer
{
    private $fileName;

    function loadFromFile($file) 
    {   
        if (!file_exists($file)) {
            throw new Backend_Excpetion_FileNotFound($file);
        }
        $this->fileName = $file;
    }

    function loadFromString($string) 
    {
        throw new Backend_Exception_TemplateRenderer('LoadFromString for PHP templates does not implemented yet');
    }

    function format() {
        if (is_array($this->getData())) {
            extract($this->getData());
        }

        ob_start();
        include ($this->fileName);
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
}
?>