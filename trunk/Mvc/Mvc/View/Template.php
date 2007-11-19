<?php
/**
 * Template view.
 */
abstract class Backend_Mvc_View_Template extends Backend_Mvc_View
{
    protected $renderer;
    protected static $resolverCallback = null;

    /**
     * Sets template resolver callback.
     * @todo throw
     */
    public static function setResolver($resolver)
    {
        if (!is_callable($resolver));
        self::$resolver = $resolver;
    }

    /**
     * Resolves view from storage
     */
    function resolve($uri)
    {
        // Lazy initialization of standard resolver.
        if (is_null(self::$resolverCallback)) {
            self::$resolverCallback = array(new Backend_Mvc_TemplateResolver(), 'resolve');
        }

        call_user_func_array(
            self::$resolverCallback,
            array($this->getRenderer(), $uri)
        );
        return $this;
    }

    /**
     * Gets attached renderer.
     */
    function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Sets data hash data.
     */
    function fromHash($data)
    {
        $this->getRenderer()->setData($data);
        return $this;
    }

    /**
     * Shows view.
     *
     * By default, it exports some request variables: url, splitted url and host.
     * @todo Request parameters?
     */
    function show($request, $response)
    {
        $data = $this->getRenderer()->getHash();

        $data['url'] = $request->getPath();
        $data['urlParts'] = $request->getPathParts();
        $data['host'] = $request->getHost();

        $this->getRenderer()->setHash($data);

        $response->out($this->getRenderer()->format());
    }
}
?>