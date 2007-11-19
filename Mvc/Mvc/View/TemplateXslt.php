<?php
/**
 * Transforms and passes data to XSLT template.
 *
 * Input could be DomDocument or hash.
 *
 * Gets hash as input.
 */
class Backend_Mvc_View_TemplateXslt extends Backend_Mvc_View_Template
{
    function __construct()
    {
        $this->renderer = new Backend_Mvc_TemplateRenderer_Xslt();
    }

    function fromXml($xml)
    {
        $this->getRenderer()->setXml($xml);
        return $this;
    }
}
?>