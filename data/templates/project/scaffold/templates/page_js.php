<?
foreach($columns as $column) {
    $pairs = array();
    foreach($column as $key=>$value) {
        $cnt = false;
        switch($key) {
            case 'id':
                $value = "'".$value."'";
            break;
            case 'show':
            case 'title':
                $cnt = true;
            break;
        }
        if ($cnt) continue;
        $pairs[] = $key.':'.$value;
    }
    $cTmp[] = '{ '.implode($pairs, ', ').' }';
}
$cToShow = implode($cTmp, ",\n");
?>

Project.<?= $pageClass; ?> = Class.create(Backend.Manager, {
    name: '<?=$pageId;?>',

    columns: [
        <?= $cToShow; ?>
    ]
});

FastInit.addOnLoad(function() {page = new Project.<?= $pageClass; ?>(); });