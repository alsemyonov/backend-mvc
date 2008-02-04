<?
foreach($columns as $columnId=>$column) {
    $pairs = array();
    $column['id'] = $columnId;

    if ($column['type'] == 'date') {
        $calendars[$columnId] = $column;
    }

    if ($column['type'] == 'select') {
        $selects[$columnId] = $column;
    }

    foreach($column as $key=>$value) {
        $cnt = false;
        switch($key) {
            case 'id':
                $value = "'".$value."'";
            break;
            case 'isColumn':
            case 'title':
            case 'type':
            case 'length':
            case 'relation':
                $cnt = true;
            break;
        }
        if ($cnt) continue;
        $pairs[] = $key.':'.$value;
    }
    $cTmp[] = '{ '.implode($pairs, ', ').' }';
}
$cToShow = implode($cTmp, ",\n");

if (is_array($calendars))
{
    foreach($calendars as $id=>$column) {
        $calToShow[] = '
        {
            inputField     :    "'.$id.'",
            ifFormat       :    "%Y-%m-%d",
            displayArea    :    "'.$id.'Show",
            daFormat       :    "%e %b %Y £.",
            button         :    "'.$id.'Container",
            align          :    "Br",
            singleClick    :    true,
            weekNumbers    :    false
        }
        ';
    }

    $calToShow = implode(',', $calToShow);
}

if (is_array($selects))
{
    foreach($selects as $id=>$column) {
        $selToShow[] = "
            $('".$id."').loadOptions({
                url: '/manager/".strtolower($column['relation']['table'])."/ajax/getall/',
                labelField: '".($column['relation']['labelField'] ? $column['relation']['labelField'] : 'name')."'
            });
        ";
    }

    $selToShow = implode(',', $selToShow);
}
?>

<?= $projectName; ?>.<?= $pageClass; ?> = Class.create(Backend.Manager, {
    name: '<?=$pageId;?>',

    columns: [
        <?= $cToShow; ?>
    ],

    calendars: [
        <?= $calToShow; ?>
    ],

    initialize(): function($super) {
        $super();
        <?= $selToShow; ?>
    }
});

FastInit.addOnLoad(function() {page = new <?= $projectName; ?>.<?= $pageClass; ?>(); });