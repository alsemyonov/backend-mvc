<?= '<?xml version="1.0" encoding="Windows-1251"?>'; ?>

<!DOCTYPE xsl:stylesheet SYSTEM "../symbols.ent">

<xsl:stylesheet 
    version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
>

<xsl:import href="Common.xsl"/>

<xsl:output
    encoding="UTF-8"
    method="html"
    indent="yes"
/>

<xsl:template match="/*[1]">
<html>

<xsl:call-template name="head"/>
<script src="/site/js/<?= $pageId; ?>.js"></script>

<body onload="javascript: page.load();">

<xsl:call-template name="header"/>

<div class="sbnavBlock"><ul class="subnav">
	<li><nobr><a href="#" onclick="javascript:page.edit(); return false;">Добавить</a></nobr></li>
</ul></div>

<h1 class="index"><?= $pageTitle; ?></h1>

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
foreach($columns as $column) {
    if ($column['show']) {
?>
    <th width="3%"><?=$column['title'];?></th>
<?
    }
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
<div class="close"><a href="#" onClick="javascript:page.close(); return false;"><img src="/images/close.gif" width="16" height="16" border="0" alt="" /></a></div>
<h2><?= $formTitle; ?></h2>
<input type="hidden" name="id"/>
<? foreach($sets as $set) { ?>
<fieldset>
	<legend><?= $set['legend'];?></legend>
    <? foreach ($set['fields'] as $field) {
        foreach($columns as $cur)
         if ($cur['id'] == $field) { $column = $cur; break; }
    ?>
	<div>
		<label><?= $column['title']; ?></label>
		<input type="text" name="values[<?=$column['id'];?>]"/>
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

<xsl:call-template name="footer"/>

</body>
</html>
</xsl:template>

</xsl:stylesheet>