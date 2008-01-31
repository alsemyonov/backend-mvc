<?
define ('B_ENV_ID', 'develompent');
define ('B_PROJECT_TEMPLATE_DIR', 'c:/php/PEAR/Backend-dev/data/templates/project');
define ('B_VENDORS_DIR', '../vendors/');
define ('B_DSN_PROVIDER', '../app/database.php');
define ('B_SCAFFOLD_DIR', '../scaffold/');
define ('B_MODEL_DIR', '../app/models/');
define ('B_JS_DIR', '../www/js/');
define ('B_VIEW_DIR', '../app/views/manager/');
define ('B_CONTROLLER_DIR', '../app/controllers/manager/');

$config = array('data_fixtures_path'  =>  '../db/fixtures/',
                'models_path'         =>  B_MODEL_DIR,
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
    case 'create':
        createProject();
    break;

    case 'doctrine':
        array_shift($argv);
        callDoctrine($argv, $config);
    break;

    case 'scaffold':
        $model = $argv[1];
        scaffold($model);
    break;

    default:
        usage();
    break;
}

function usage() {
    echo "USAGE:\n";
    echo "  generate.php create - Create empty project.\n";
    echo "  generate.php doctrine [...] - Call Doctrine_Task.\n";
    echo "  generate.php apply - Apply migrations to a database.\n";
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

function scaffold($model) {
    $model = ucfirst($model);
    require_once B_SCAFFOLD_DIR.$model.'.php';

    $config = array(
        'pageId'=>strtolower($model),
        'pageClass'=>$model,
        'modelClass'=>$model
    );

    $config = array_merge($config, $scaffold);

    $js  = phpTpl(B_SCAFFOLD_DIR.'templates/page_js.php', $config);
    $php = phpTpl(B_SCAFFOLD_DIR.'templates/page_php.php', $config);
    $xsl = phpTpl(B_SCAFFOLD_DIR.'templates/page_xsl.php', $config);

//    file_put_contents(B_CONTROLLER_DIR.$model.'Controller.php', $php);
//    file_put_contents(B_VIEW_DIR.$model.'_index.xsl', $xsl);
    file_put_contents(B_JS_DIR.$model.'.js', $js);
}

function phpTpl($file, $vars)
{
    extract($vars);

    ob_start();
    include ($file);
    $contents = ob_get_contents();
    ob_end_clean();  

    return $contents;
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
