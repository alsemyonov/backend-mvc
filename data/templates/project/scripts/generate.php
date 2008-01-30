<?
define ('B_ENV_ID', 'develompent');
define ('B_PROJECT_TEMPLATE_DIR', 'c:/php/PEAR/Backend-dev/data/templates/project');
define ('B_VENDORS_DIR', '../vendors/');
define ('B_DSN_PROVIDER', '../app/database.php');

$config = array('data_fixtures_path'  =>  '../db/fixtures/',
                'models_path'         =>  '../app/models/',
                'migrations_path'     =>  '../db/migrate/',
                'sql_path'            =>  '../db/sql/',
                'yaml_schema_path'    =>  '../db/');

require_once 'Console/Getopt.php';
require_once 'File/Find.php';

$con  = new Console_Getopt();
$argv = $con->readPHPArgv();
array_shift($argv);

$action = $argv[0];

switch($action) {
    case 'project':
        createProject();
    break;

    case 'doctrine':
        array_shift($argv);
        callDoctrine($argv, $config);
    break;

    default:
        usage();
    break;
}

function usage() {
    echo "USAGE:\n";
    echo "  generate.php create - Create empty project.";
    echo "  generate.php doctrine [...] - Call Doctrine_Task.";
    echo "  generate.php apply - Apply migrations to a database.";
}

function createProject() {
    echo "Creating empty project...";
    xcopy(B_PROJECT_TEMPLATE_DIR, '.');
}

function callDoctrine($argv, $config) {
    require_once B_VENDORS_DIR.'/doctrine/lib/Doctrine.php';
    require_once B_DSN_PROVIDER;

    spl_autoload_register(array('Doctrine', 'autoload'));

    Doctrine_Manager::connection(getDsn(B_ENV_ID));
    $cli = new Doctrine_Cli($config);
    $cli->run($argv);
}

function xcopy($src, $trg) {
    list($directories, $files) = File_Find::maptree($src);

    foreach($directories as $dir) {
        if (strpos($dir, '.svn') != false) continue;
        $dir = substr($dir, strlen($src));
        @mkdir($trg.'/'.$dir, 0777, true);
    }

    foreach($files as $file) {
        $dstFile = $trg.substr($file, strlen($src));
        if (strpos($file, '.svn') != false) continue;
        copy($file, $dstFile);
    }
}
?>
