<?php
/**
 * Template view renderer.
 */
abstract class Backend_View_Template extends Backend_View
{
    protected $renderer;

    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->renderer = $this->createRenderer();
    }

    /**
     * Gets attached renderer.
     */
    function getRenderer() 
    {
        return $this->renderer;
    }

    /**
     * Shows view.
     */
    function show(Backend_Request $request, Backend_Response $response)
    {
        $data = $this->getRenderer()->getData();
        if (is_array($data)) {
            $data['url'] = $request->getPath();
            $data['urlParts'] = $request->getPathParts();
            $data['host'] = $request->getHost();
            $this->getRenderer()->setData($data);
        }

        $response->out($this->getRenderer()->format());
    }

    abstract protected function createRenderer();
}
?>