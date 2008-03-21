<?php
/**
 * Renders PHP template.
 *
 * @todo file_exists
 * @todo content handling
 */
class Backend_Mvc_TemplateRenderer_Php extends Backend_Mvc_TemplateRenderer
{
    function setContent() {
        throw new Backend_Mvc_Exception('setContent() form TemplateRenderer_Php Not implemented yet');
    }

    function format() {
        extract($this->getHash());

        ob_start();
        include ($this->getFileName());
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
}
?>