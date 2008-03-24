<?php
/**
 * Template renderer base class.
 *
 * It receives template filename, template content and input data (hash). 
 *
 * @todo Strip out getters?
 */
abstract class Backend_Mvc_TemplateRenderer
{
    /**
     * Template hash data.
     */
    private $hash = array();

    /**
     * Template file name.
     */
    private $fileName;

    /**
     * Template body.
     */
    private $content;

    /**
     * Sets input hash for template (hash).
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * Gets input hash for template.
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Sets template file name.
     * @todo throws
     */
    public function setFileName($fileName)
    {
        if (!file_exists($fileName)) throw new Backend_Mvc_Exception('File not found: '.$fileName);
        $this->fileName = $fileName;
    }

    /**
     * Gets template file name.
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Sets template content.
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    /**
     * Gets template content.
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Applies template to data and returns result.
     */
    abstract public function format();
}
?>