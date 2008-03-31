<?php
define(B_XSL_VIEW_XSL_FLAGS, LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_NSCLEAN);
define(B_XSL_VIEW_XML_FLAGS, LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_COMPACT);

/**
 * Xslt template frontend.
 */
class Backend_TemplateRenderer_Xslt extends Backend_TemplateRenderer
{
    private $xsltDoc = null;

    /**
     * Default options.
     */
    protected $options = array(
        'xslLoadFlags'=>B_XSL_VIEW_XSL_FLAGS,
        'xmlLoadFlags'=>B_XSL_VIEW_XML_FLAGS,
        'inEncoding'=>'UTF-8',
        'outEncoding'=>'UTF-8',
        'documentName'=>'root',
        'rowName'=>'row'
    );


    /**
     * Adds ability to load template from DomDocument object.
     */
    public function loadFrom($media, $arg)
    {
        if ($media == 'dom') {
            $this->loadFromDom($arg);
        }

        parent::loadFrom($media, $arg);
    }

    /**
     * Loads template from DOM document.
     */
    public function loadFromDom($xsl)
    {
        $this->content = $xsl;
    }

    /**
     * Loads template from file.
     */
    public function loadFromFile($data)
    {
        $content = DOMDocument::load($data, $this->options['xslLoadFlags']);
        $this->content = $content;
    }

    /**
     * Loads template from string.
     */
    public function loadFromString($data)
    {
        $content = DOMDocument::loadXML($data, $this->options['xslLoadFlags']);
        $this->content = $content;
    }

    /**
     * Transforms multidimentional hash/array to XML.
     */
    public static function asXml($vars, $inEncoding = 'UTF-8', $outEncoding = 'UTF-8', $rowName = 'row')
    {
        $encode = false;
        if ($inEncoding != $outEncoding) $encode = true;

        foreach ($vars as $key=>$value) {
            if ($encode) {
                $value = iconv($value, $inEncoding, $outEncoding);
            }
            if (is_numeric($key)) $key = $rowName;

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
     * Transforms multidimentional hash/array to XML document.
     */
    public static function asXmlDocument($data, $inEncoding = 'UTF-8', $outEncoding = 'UTF-8', $documentName = 'root', $rowName = 'row')
    {
        $xml = '<?xml version="1.0" encoding="'.$outEncoding.'"?>';

        $xml .= '<'.$documentName.'>';
        $xml .= self::asXml($data, $inEncoding, $outEncoding, $rowName);
        $xml .= '</'.$documentName.'>';

        return $xml;
    }

    /**
     * Formats and returns template.
     */
    public function format()
    {
        if (!$this->content) { 
            throw new Backend_Exception_TemplateRenderer('Template is empty');
        }

        if (!$this->content instanceof DomDocument) {
            throw new Backend_Exception_TemplateRenderer('Template is not DomDocument object');
        }

        $data = $this->getData();
        if (is_array($data)) {
            $xml = self::asXmlDocument(
                $data, 
                $this->options['inEncoding'], 
                $this->options['outEncoding'], 
                $this->options['documentName'],
                $this->options['rowName']
            );

            $data = DomDocument::loadXML($xml, $this->options['xmlLoadFlags']);
        }

        $processor = new XSLTProcessor();
        $processor->registerPHPFunctions();
        $processor->importStyleSheet($this->content);

        $html = $processor->transformToXml($data);

        return $html;
    }
}
?>