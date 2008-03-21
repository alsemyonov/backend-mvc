<?
class Backend_Mvc_Autoloader {
    private static $classNames;

    static function register() {
        spl_autoload_register(array('Mvc_Autoloader', 'autoload'));
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

    static function autoload($className) {             
        if (self::$classNames[$className]) {
            require_once(self::$classNames[$className]);
            return true;
        }
    }
}

Mvc_Autoloader::register();
?>