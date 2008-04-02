<?
/**
 * Autoloader class.
 */
class Backend_Autoloader 
{
    /**
     * Adds path include_path.
     */
    static function includePath($path) {
        $paths = split(PATH_SEPARATOR, get_include_path());
        if (!in_array($path, $paths)) {
            set_include_path(get_include_path().PATH_SEPARATOR.$path);
        }
    }

    /**
     * Autoloads class/interface. 
     */
    static function autoload($className) 
    {
        if (class_exists($className, false) || interface_exists($className, false)) {
            return false;
        }

        $includePaths = split(PATH_SEPARATOR, get_include_path());

        // PEAR-style class name
        $classNameRep = str_replace('_', DIRECTORY_SEPARATOR, $className);
        foreach($includePaths as $path) {
            if (file_exists($path.DIRECTORY_SEPARATOR.$classNameRep.'.php')) {
                include_once($path.DIRECTORY_SEPARATOR.$classNameRep. '.php');
                return true;
            }
        }

        // Normal class naming style
        foreach($includePaths as $path) {
            if (file_exists($path.DIRECTORY_SEPARATOR.$className.'.php')) {
                include_once($path.DIRECTORY_SEPARATOR.$className . '.php');
                return true;
            }
        }
    }
}
?>