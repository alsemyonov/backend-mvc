<?

define('B_APP', realpath('../app/').DIRECTORY_SEPARATOR);
define('B_WWW', realpath('./').DIRECTORY_SEPARATOR);
define('B_VENDORS', realpath('../vendors/').DIRECTORY_SEPARATOR);

set_include_path(
    get_include_path() . PATH_SEPARATOR .
    B_APP . PATH_SEPARATOR .
    B_VENDORS
);

require_once 'application.php';

$application = new Application();
$application->run();
?>