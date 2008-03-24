<?php
/**
 * Template view renderer.
 * @todo think about to make resolver non-static.
 */
abstract class Backend_Mvc_View_Template extends Backend_Mvc_View
{
    protected $renderer;

    public function __construct() {
        $this->renderer = $this->createRenderer();
    }

    /**
     * Gets attached renderer.
     */
    function getRenderer() {
        return $this->renderer;
    }

    /**
     * Shows view.
     *
     * By default, it exports some request variables: url, splitted url and host.
     * @todo Request parameters?
     */
    function show($request, $response){
        $data = $this->getRenderer()->getHash();

        $data['url'] = $request->getPath();
        $data['urlParts'] = $request->getPathParts();
        $data['host'] = $request->getHost();

        $this->getRenderer()->setHash($data);

        $response->out($this->getRenderer()->format());
    }

    abstract protected function createRenderer();
}
?>