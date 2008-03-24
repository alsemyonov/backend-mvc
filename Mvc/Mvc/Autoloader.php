<?
/** @todo $class = self::getPath() . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php'; */

/**
 * Autoloader class.
 * @todo THROUGH INI_SET!!!!
 */
class Backend_Mvc_Autoloader {
    /**
     * Registered classes.
     */
    private static $classNames;

    /**
     * Registers autoload function.
     */
    static function register() {
        spl_autoload_register(array(self, 'autoload'));
    }

    // Registers class
    static function registerClass($className, $fileName) {
        self::$classNames[$className] = $fileName;
    }

    static function registerClasses($cn) {
        foreach($cn as $className=>$file) {
            self::registerClass($className, $file);
        }
    }

    static function unregisterClass($className) {
        unset(self::$classNames[$className]);
    }

    // Registers folder
    static function registerFolder($folder, $namespace = '') {
        $folder = glob($folder.'/*');
        foreach($folder as $fn) {
            $pi = pathinfo($fn);
            $className = $pi['filename'];
            self::registerClass($namespace.$className, $fn);
        }
    }

    /**
     * Autoloads class. First, checks for existance class in 
     */
    static function autoload($className) 
    {
        if (self::$classNames[$className]) {
            include_once self::$classNames[$className];
            return true;
        }
    }
}

Backend_Mvc_Autoloader::register();
?>