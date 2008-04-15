<?php
/**
 * Base class to emulate mixins.
 */
class Backend_Mixin
{
    private $mixins = array();

    /**
     * Load mixin. Should be called from constructor.
     */
    function loadMixin($className)
    {
        $this->mixins[] = new $className();
    }

    function __call($method, $params) 
    {
        return Backend_Mixin::call($this->mixins, $method, $params);
    }

    static public function call($mixins, $method, $params)
    {
        foreach($mixins as $mixin) {
            if (is_callable(array($mixin, $method))) {
                return call_user_func_array(array($mixin, $method), $params);
            }
        }

        throw new Backend_Mixin_Exception_MethodNotFound('Method '.$method.' not found');
    }

    /**
     * Checks if method is callable.
     */
    function isCallable($method) {
        foreach($this->mixins as $mixin) {
            if (is_callable(array($mixin, $method))) {
                return true;
            }
        }

        return false;
    }
}
