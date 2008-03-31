<?php
/**
 * Base abstract request dispatcher class.
 */
abstract class Backend_RequestDispatcher
{
    /**
     * Dispatch function.
     */
    abstract public function dispatch($request, $response);
}
?>