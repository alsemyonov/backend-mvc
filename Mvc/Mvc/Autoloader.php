<?
class Mvc_Autoloader {
    private static $classNames;

    static function registerClass($className, $fileName) {
        self::$classNames[$className] = $fileName;
    }

    static function unregisterClass($className) {
        unset(self::$classNames[$className]);
    }

    static function register() {
        spl_autoload_register(array('Mvc_Autoloader', 'autoload'));
    }

    static function registerFolder($folder) {
        $folder = glob($folder.'/*');
        foreach($folder as $fn) {
            $pi = pathinfo($fn);
            $className = $pi['filename'];
            self::registerClass($className, $fn);
        }
    }

    static function autoload($className) {             
        if (self::$classNames[$className]) {
            require_once(self::$classNames[$className]);
            return true;
        }
    }
}
?>