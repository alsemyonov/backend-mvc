<?php
/**
 * Session object interface.
 * You could inherit this class to change session saving behavior.
 */
class Backend_Session
{
    /**
     * Creates session object.
     */
    public function __construct()
    {
        $this->start();
    }

    /**
     * Auto-starts session.
     */
    protected function start()
    {
        if (!ini_get('session.auto_start') || strtolower(ini_get('session.auto_start')) == 'off') {
            session_start();
        }
    }

    /**
     * Sets session variable.
     */
    public function __set($var, $value)
    {
        $_SESSION[$var] = $value;
    }

    /**
     * Gets session variable.
     */
    public function __get($var)
    {
        return $_SESSION[$var];
    }

    /**
     * Gets all session variables.
     */
    public function getAll()
    {
        return $_SESSION;
    }

    /**
     * Gets session ID.
     */
    public function getId()
    {
        return session_id();
    }

    public function destroy()
    {
        session_destroy();
    }
}