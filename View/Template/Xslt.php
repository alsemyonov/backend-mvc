<?php
/**
 * Transforms and passes data to XSLT template.
 *
 * Input could be DomDocument or hash.
 *
 * Gets hash as input.
 */
class Backend_View_Template_Xslt extends Backend_View_Template
{
    protected function createRenderer() 
    {
        return new Backend_TemplateRenderer_Xslt();
    }
}
?>