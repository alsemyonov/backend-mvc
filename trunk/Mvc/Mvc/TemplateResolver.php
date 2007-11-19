<?
/**
 * Base class to create template resolver. It gets template content from storage and passes it to
 * TemplateRenderer as filename, string or object.
 *
 * You could extend this class to load template content for example from database, or implement 
 * search here.
 */
class Backend_Mvc_TemplateResolver
{
    public function resolve($renderer, $uri)
    {
        $renderer->setFileName($uri);
    }
}
?>