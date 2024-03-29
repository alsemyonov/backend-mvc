<?php
/**
 * Template renderer base class.
 */
abstract class Backend_TemplateRenderer
{
    /**
     * Template data data.
     */
    protected $data = array();

    /**
     * Template body.
     */
    protected $content = null;

    /**
     * Template engine options.
     */
    protected $options = array();

    /**
     * Creates template renderer.
     */
    public function __construct($media = null, $arg = null, array $data = null, array $options = null) {
        if ($options != null) $this->setOptions($options);
        if ($media != null) $this->load($media, $arg);
        if ($data != null) $this->setData($data);
    }

    /**
     * Sets options for template engine.
     */
    public function setOptions($options) 
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }    

    /**
     *
     */
    public function getOptions($options)
    {
        return $this->options;
    }

    /**
     * Sets input data.
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Gets input data.
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Load dispatcher function.
     */
    public function loadFrom($media, $arg)
    {
        switch(strtolower($media)) {
            case 'file':
                $this->loadFromFile($arg);
            break;
            case 'string':
                $this->loadFromString($arg);
            break;
        }
        return $this;
    }

    /**
     * Loads template from file.
     */
    public function loadFromFile($fileName)
    {
        if (!file_exists($fileName)) {
            throw new Backend_Exception_FileNotFound($fileName);
        }
        $this->loadFromString(file_get_contents($fileName));
        return $this;
    }

    /**
     * Loads template from string.
     */
    public function loadFromString($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Applies template and returns result.
     */
    abstract public function format();
}
?>