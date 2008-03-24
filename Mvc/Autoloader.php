<?
/**
 * Autoloader class.
 */
class Backend_Mvc_Autoloader {
    /**
     * Adds folder to include_path.
     */
    static function includePath($path) {
        $paths = split(PATH_SEPARATOR, get_include_path());
        if (in_array($path, $paths)) return;
        set_include_path(get_include_path().PATH_SEPARATOR.$path);
    }

    /**
     * Autoloads class. 
     */
    static function autoload($className) 
    {
        $paths = split(PATH_SEPARATOR, get_include_path());
        foreach($paths as $path) {
            if (file_exists($path.DIRECTORY_SEPARATOR.$className.'.php'))
                include_once($path.DIRECTORY_SEPARATOR.$className . '.php');
        }

        if (!class_exists($className)) {
            $className = str_replace('_', DIRECTORY_SEPARATOR, $className);
            foreach($paths as $path) {
                if (file_exists($path.DIRECTORY_SEPARATOR.$className.'.php'))
                    include_once($path.DIRECTORY_SEPARATOR.$className . '.php');
            }
        }
    }
}
?>