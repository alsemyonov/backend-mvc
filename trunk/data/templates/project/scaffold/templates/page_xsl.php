<?= '<?xml version="1.0" encoding="Windows-1251"?>'; ?>

<!DOCTYPE xsl:stylesheet SYSTEM "../symbols.ent">

<xsl:stylesheet 
    version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
>

<xsl:import href="../layouts/manager.xsl"/>

<xsl:output
    encoding="UTF-8"
    method="html"
    indent="yes"
/>

<xsl:template name="content">
<div class="sbnavBlock"><ul class="subnav">
    <li><nobr><a href="#" onclick="javascript:page.edit(); return false;">Добавить</a></nobr></li>
</ul></div>

<h1 class="index"><?= $list['title']; ?></h1>

<div class="tbl">

<!--                    
<div class="pageNav">
<span class="digits">
    <span class="small"><b>Страницы</b> (всего&nbsp;12):</span>
    <span><a href="/?">2</a></span>
    <span><a href="/?">3</a></span>
    <span class="chosen">4</span>
    <span><a href="/?">5</a></span>
    <span><a href="/?">6</a></span>
</span>
</div>
-->
                    
<div class="clearing">
<table class="listTb" width="100%" cellspacing="0">
<thead>
<tr>
<?
foreach($listHeader as $title) {       
?>
    <th width="3%"><?=$title;?></th>
<?
}
?>
</tr>
</thead>
<tbody id="<?=$pageId;?>Items">
</tbody>
</table>
</div>

</div>

<div id="editFormDiv" class="w700" style="display: none;">
<form action="/manager/<?= $pageId; ?>/ajax/save/" method="post" enctype="multipart/form-data" id="<?=$pageId;?>">
<div class="tblPopup w700"><div class="tblInner">
<div class="close"><a href="#" onClick="javascript:page.close(); return false;"><img src="/img/close.gif" width="16" height="16" border="0" alt="" /></a></div>
<h2><?= $form['title']; ?></h2>
<? foreach($form['sets'] as $set) { ?>
<fieldset>
    <legend><?= $set['legend'];?></legend>
    <? foreach ($set['fields'] as $id) {
        $column = $columns[$id];
    ?>
    <div>
        <label><?= $column['title']; ?></label>
        <?
            switch($column['type']) {
                case 'string':
        ?>
        <input type="text" name="values[<?=$id;?>]" maxLength="<?=$column['length'];?>" value="<?$column['default'];?>"/>
        <?
                break;
                case 'integer':
        ?>
        <input type="text" name="values[<?=$id;?>]" maxLength="11" value="<?$column['default'];?>"/>
        <?
                break;
                case 'clob':
        ?>
        <textarea name="values[<?=$id;?>]"><?$column['default'];?></textarea>
        <?
                break;
                case 'date':
        ?>
        <span class="dateInput" style="cursor: pointer;" id="<?=$id;?>Container">
        <span id="<?=$id;?>Show">&nbsp;</span>
        <input type="hidden" name="values[<?=$id;?>]" id="<?=$id;?>"/>
        <?
                break;
                case 'select':
        ?>
        <select name="values[<?=$id;?>]"></select>
        <?
                break;           
                case 'enum':
                    foreach ($column['values'] as $key=>$value) {
        ?>
        <input type="radio" name="values[<?=$id;?>]" value="<?=$value;?>" class="checks"></input><?= $column['valueTitles'][$value]; ?>
        <?
                    }
                break;
                case 'boolean':
        ?>
            <input type="hidden" class="checkbox <?=$id.'cb';?>" name="values[<?=$id;?>]" value="0"/>
            <input type="checkbox" class="checkbox checks" id="<?=$id.'cb';?>" name="values[<?=$id;?>]" value="1"/>        
        <?
                break;
            }
        ?>
    </div>
    <? } ?>
</fieldset>
<? } ?>
<div>
    <input type="submit" class="submit" name="save" value="Сохранить" onClick="javascript:page.save(); return false;" />
    <input type="submit" class="submit" name="insert" value="Отмена" onClick="javascript:page.close(); return false;" />
</div>
</div></div>
</form>
</div>
</xsl:template>

</xsl:stylesheet>