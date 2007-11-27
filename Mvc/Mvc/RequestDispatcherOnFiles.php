<?
/**
 * Standard request dispatcher.
 */
class Backend_Mvc_RequestDispatcherOnFiles extends Backend_Mvc_RequestDispatcher
{
    /**
     * Returns true if request dispatched and false if request is not dispatched.
     *
     * @returns list Result objects and view object or false.
     */
    public function dispatch($request, $response)
    {
        if ($request->getPath() != '/')
        {        
            $parts = $request->getPathParts();

            $xmlFileName = 'views/'.implode('-', $parts).'.xml';
            $xslFileName = 'views/'.implode('-', $parts).'.xsl';
        } else {
            $xmlFileName = 'views/index.xml';
            $xslFileName = 'views/index.xsl';
        }

        if (!file_exists($xslFileName)) return false;

        $view = new Backend_Mvc_View_TemplateXslt();
        if (file_exists($xmlFileName))
        {
            $xml = DomDocument::load($xmlFileName, LIBXML_DTDLOAD | LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_COMPACT);
            $view->fromXml($xml);
        }

        return $view->resolve($xslFileName);
    }
}
?>