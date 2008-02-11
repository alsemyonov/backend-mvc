<?
foreach($listBody as $id=>$column) {
    $pairs = array();   
    $pairs[] = "id: '".$id."'";

    if ($column['type'] == 'date') {
        $calendars[$id] = $column;
    }

    if ($column['type'] == 'select') {
        $selects[$id] = $column;
    }   
    
    if ($column['cell']) $pairs[] = 'cellCallback: Project.cellTemplates.'.$column['cell'];
    if ($column['container']) $pairs[] = 'containerCallback: Project.containerTemplates.'.$column['container'];
    if ($column['formatter']) $pairs[] = 'formatter: Project.formatters.'.$column['formatter'];

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

Project.<?= $pageClassName; ?> = Class.create(Backend.Manager, {
    name: '<?=$pageId;?>',

    columns: [
        <?= $cToShow; ?>
    ],

    calendars: [
        <?= $calToShow; ?>
    ],

    initialize: function($super) {
        $super();
        <?= $selToShow; ?>
    }
});

FastInit.addOnLoad(function() {page = new Project.<?= $pageClassName; ?>(); });