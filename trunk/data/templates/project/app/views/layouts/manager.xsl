<?xml version="1.0" encoding="Windows-1251"?>

<!DOCTYPE xsl:stylesheet SYSTEM "../symbols.ent">

<xsl:stylesheet 
    version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
>

<xsl:import href="manager_buttons.xsl"/>

<xsl:output
    encoding="UTF-8"
    method="html"
    indent="yes"
/>

<xsl:param name="buttons" select="document('../manager/buttons.xml')/buttons"/>

<xsl:template match="/*[1]">
<html>
    <head>
        <xsl:call-template name="head" />
        
    </head>
    <body>
        <xsl:call-template name="header" />
        <xsl:call-template name="content" />
        <xsl:call-template name="footer" />
    </body>

</html>
</xsl:template>

<xsl:template name="content">
</xsl:template>

<!--
    HEAD АДМИНКИ
-->
<xsl:template name="head">
<head>
    <title>Панель управления</title>

    <link rel="stylesheet" type="text/css" href="/css/manager_styles.css"/>
    <link rel="stylesheet" type="text/css" href="/js/vendors/ajaxtabs/ajaxtabs.css"/>
    <link rel="icon" href="/ico/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="/ico/favicon.ico" type="image/x-icon"/>

    <script src="/js/vendors/prototype/prototype.js"></script>
    <script src="/js/vendors/backend/backend-prototype.js"></script>
    <script src="/js/vendors/backend/backend-date.js"></script>
    <script src="/js/vendors/backend/backend-manager.js"></script>
    <script src="/js/vendors/backend/backend-ajax.js"></script>
    <script src="/js/vendors/tablekit-fix/fastinit.js"></script>
    <script src="/js/project.js"></script>

    <!--link rel="stylesheet" type="text/css" href="/calendar.css"/>
    <script type="text/javascript" src="/lib/calendar/calendar.js"></script>
    <script type="text/javascript" src="/lib/calendar/calendar-ru.js"></script>
    <script type="text/javascript" src="/lib/calendar/calendar-setup.js"></script-->

</head>
</xsl:template>


<!-- 
    ШАПКА С НАВИГАЦИЕЙ 
-->
<xsl:template name="header">
<div id="loading" style="display: none;" class="overlay"><div class="loader"><img src="/images/loader.gif" width="32" height="32" border="0" alt="" /><p>Загрузка&#8230;</p></div></div>
<div id="error" style="display: none;">
    <form action="." method="post">
    <div id="errorMessage">Оппа, бля! Ошибка [<a href="#" onClick="Element.hide('error'); return false;" class="white">Закрыть этот стыд-позор</a>]</div>
    <div id="errorText"></div>
    <div class="options">
        <input type="submit" class="submit" name="ok" value="OK" onClick="Element.hide('error'); return false;" />
<!--
        <input type="submit" class="submit" name="send" value="Отправить отчет" onClick="Element.hide('error'); return false;" />
-->
    </div>
    </form>
</div>
<div class="logo">
    <xsl:if test="/root/url!='/manager/'">
    <a href="/manager/"><img src="/images/admin.gif" width="164" height="16" border="0" /></a>
    </xsl:if>
    <xsl:if test="/root/url='/manager/'">
    <img src="/images/admin.gif" width="164" height="16" border="0" />
    </xsl:if>
</div>
<div class="navBlock">
<!--
    <a href="" class="logout" title="Выйти"><img src="/images/t.gif" width="21" height="11" border="0" alt="" /></a>
-->
    <ul class="mainnav">
        <xsl:apply-templates select="$buttons/button" mode="first"/>
    </ul>
</div>
</xsl:template>

<!-- 
    НАВИГАЦИЯ ПО РАЗДЕЛАМ 
-->
<xsl:template name="sbnav">
<div class="sbnavBlock">
    <ul class="subnav">
        <xsl:variable name="firstButtonUrl"><xsl:value-of select="concat('/',/root/urlParts/row[1],'/',/root/urlParts/row[2],'/')"/></xsl:variable>
        <xsl:apply-templates select="$buttons/button[url=$firstButtonUrl]/button" mode="second"/>
    </ul>
</div>
</xsl:template>

<!-- 
    ФУТЕР 
-->
<xsl:template name="footer">
<div class="copyrights">&copy; 2008, Art-Stein/RockBee Design</div>
</xsl:template>

</xsl:stylesheet>
