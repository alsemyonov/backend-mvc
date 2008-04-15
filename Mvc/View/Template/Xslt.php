<?php
/**
 * Transforms and passes data to XSLT template.
 *
 * Input could be DomDocument or hash.
 *
 * Gets hash as input.
 */
class Backend_Mvc_View_Template_Xslt extends Backend_Mvc_View_Template
{
    protected function createRenderer() {
        return new Backend_Mvc_TemplateRenderer_Xslt();
    }
}
?>