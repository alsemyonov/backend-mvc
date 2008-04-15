<?php
/**
 * Gets XML document or hash as input data.
 * @todo Handle content
 * @todo load flags == constant/setOptions/getOptions
 */
class Backend_Mvc_TemplateRenderer_Xslt extends Backend_Mvc_TemplateRenderer
{
    private $xsltDoc = null;
    private $xmlDoc = null;

    /**
     * Transforms multidimentional hash/array to XML.
     */
    public static function asXml( $vars )
    {
        foreach ($vars as $key=>$value) {
            if (is_numeric($key)) $key = 'row';

            $xml .= '<'.$key.'>';

            if (!is_array($value) && (!is_object($value))) {
                $xml .= "<![CDATA[".$value."]]>";
            }

            if (is_array($value)) {
                $xml .= self::asXml($value);
            }
            $xml .= "</".$key.">\n";
        }

        return $xml;
    }

    /**
     * @todo Encoding!!!
     */
    protected function generate($data)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';

        $xml .= '<root>';
        $xml .= self::asXml($data);
        $xml .= "</root>";

        return $xml;
    }

    /**
     * Sets XML DomDocument object. It has highest priority as data source.
     */
    public function setXml($xml)
    {
        $this->xmlDoc = $xml;
    }

    public function getXml()
    {
        return $this->xmlDoc;
    }

    public function setXslt($xslt)
    {
        $this->xsltDoc = $xslt;
    }

    public function getXslt()
    {
        return $this->xsltDoc;
    }

    /**
     * @todo throws if not loaded
     */
    function format()
    {
        if (!$this->xsltDoc) {
            if (!file_exists($this->getFileName())) { 
                throw new Exception('Template file not found found: '.$this->getFileName());
            }
            $xsltDoc = DOMDocument::load($this->getFileName(), LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_NSCLEAN);
            $this->setXslt($xsltDoc);
        }

        if (!$this->getXml()) {
            $generated = $this->generate($this->getHash());
            $xml = DomDocument::loadXML($generated, LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_COMPACT);
            $this->setXml($xml);
        }

        $processor = new XSLTProcessor();
        $processor->registerPHPFunctions();
        $processor->importStyleSheet( $this->getXslt() );

        $html = $processor->transformToXml( $this->getXml() );    

        return $html;
    }
}
?>