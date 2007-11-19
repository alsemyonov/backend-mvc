<?php
/**
 * @todo file_exists
 */
class Backend_Mvc_TemplateRenderer_Php extends Backend_Mvc_TemplateRenderer
{
    private $fileName;

    function format()
    {
        extract($this->getHash());

        ob_start();
        include ($this->getFileName());
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
}
?>