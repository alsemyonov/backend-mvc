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
        array_unshift($argv, 'doctrine');
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
    echo "  generate.php scaffold - Autogenerate manager page.\n";
}

function createProject() {
    echo "Creating empty project...";
    xcopy(B_PROJECT_TEMPLATE_DIR, '.');
}

function initDoctrine() {
    require_once B_VENDORS_DIR.'/doctrine/lib/Doctrine.php';
    require_once B_DSN_PROVIDER;

    spl_autoload_register(array('Doctrine', 'autoload'));

    Doctrine_Manager::connection(getDsn(B_ENV_ID));
}

function callDoctrine($argv, $config) {
    initDoctrine();

    $cli = new Doctrine_Cli($config);
    $cli->run($argv);
}

function scaffold($model) {
    initDoctrine();
    Doctrine::loadModels(B_MODEL_DIR);

    $config = prepareScaffold($model);

    $js  = phpTpl(B_SCAFFOLD_DIR.'templates/page_js.php', $config);
    $php = phpTpl(B_SCAFFOLD_DIR.'templates/page_php.php', $config);
    $xsl = phpTpl(B_SCAFFOLD_DIR.'templates/page_xsl.php', $config);

    file_put_contents(B_CONTROLLER_DIR.$model.'ManagerController.php', $php);
    file_put_contents(B_VIEW_DIR.$model.'_index.xsl', $xsl);
    file_put_contents(B_JS_DIR.$model.'.js', $js);
}

function prepareScaffold($model) {
    // Название модели - с большой буквы, имя файла должно совпадать.
    $model = ucfirst($model);
    require_once B_SCAFFOLD_DIR.$model.'.php';

    // Класс модели должен существовать
    if (!class_exists($model)) {
        die ('Model class does not exists');
    }

    // Загружаем информацию о полях и связях (связь == поле).
    $modelObj = new $model;
    $fields = $modelObj->getTable()->getColumns();
    $relsObj = $modelObj->getTable()->getRelations();

    $relations = array();
    $columns = array();

    // Превращаем связи в хэш.
    foreach($relsObj as $relation) {
        $relations[$relation->getLocalFieldName()] = $relation;
    }

            //'table'=>$relation->getTable()->getTableName(),
            //'field'=>$relation->getForeignFieldName(),
            //'isOneToOne'=>$relation->isOneToOne(),
            //'relation'=>$relation

    // Цикл по существующим в модели полям
    foreach($fields as $id=>$field){
        // Если это не связь, то информация из настроек дополняется информацией из модели.
        if (!$relations[$id]) {
            $columns[$id] = array(
                'type'=>$field['type'],
                'length'=>$field['length'],
                'values'=>$field['values'],
                'default'=>$field['default']
            );
        } else {
            // Если это связь, то тип замещается.
            $columns[$id]['type'] = 'select';
            $columns[$id]['relation'] = $relations[$id];
        }
    }

    $config = array(
        'pageId'=>strtolower($model),
        'pageClassName'=>$model,
        'modelClassName'=>$model,
        'columns'=>$columns
    );

    $config = array_merge_recursive($config, $scaffold);
   
    // Подготовка списка для вывода
    $listHeader = array();
    $listBody = array();

    foreach($config['list']['columns'] as $id=>$params)
    {
        if (is_numeric($id)) $id = $params;
        if (!is_array($params)) $params = array();
        
        $column = $config['columns'][$id];
        if (!$column) $column = array();
        $column = array_merge($column, $params);
        
        $listHeader[] = $column['title'];
        $listBody[$id] = $column;
    }
    
    $config['listHeader'] = $listHeader;
    $config['listBody'] = $listBody;
    
    return $config;
}

function phpTpl($file, $vars) {
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
