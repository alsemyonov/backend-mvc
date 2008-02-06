<?xml version="1.0" encoding="Windows-1251"?>

<!DOCTYPE xsl:stylesheet SYSTEM "../symbols.ent">

<xsl:stylesheet 
    version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
>

<!--
    КОПИЯ /root/url

    Поскольку кнопки хранятся во внешнем xml, при применении шаблона к данным в этом xml,
    данные из главного xml страницы недоступны. Приходится делать trick.
-->
<xsl:param name="url" select="/root/url"/>

<!--
    КНОПКА ПЕРВОГО УРОВНЯ
-->
<xsl:template match="button" mode="first">

<!--Открытый путь начинается с пути кнопки-->
<xsl:variable name="startsWith"><xsl:value-of select="starts-with($url, @url)"/></xsl:variable>

<!--Открытый путь полностью совпадает с путём, прописанным в кнопке-->
<xsl:variable name="equals"><xsl:value-of select="@url=$url"/></xsl:variable>
<li>
<xsl:if test="$startsWith='true' and $equals='false'"><xsl:attribute name="class">chosen</xsl:attribute></xsl:if>
<xsl:if test="$startsWith='true' and $equals='true'"><xsl:attribute name="class">chosen</xsl:attribute></xsl:if>
<xsl:if test="$startsWith='false'"><xsl:attribute name="class"></xsl:attribute></xsl:if>

<xsl:choose>
    <xsl:when test="$startsWith!='true' or ($startsWith='true' and $equals!='true')"><nobr><a class="white" href="{@url}"><xsl:value-of select="@name" disable-output-escaping="yes"/></a></nobr></xsl:when>
    <xsl:otherwise><xsl:value-of select="@name" disable-output-escaping="yes"/></xsl:otherwise>
</xsl:choose>
</li>
</xsl:template>

<!--
    КНОПКА ВТОРОГО УРОВНЯ
-->
<xsl:template match="button" mode="second">

<!--Открытый путь начинается с пути кнопки-->
<xsl:variable name="startsWith"><xsl:value-of select="starts-with($url, @url)"/></xsl:variable>

<!--Открытый путь полностью совпадает с путём, прописанным в кнопке-->
<xsl:variable name="equals"><xsl:value-of select="@url=$url"/></xsl:variable>
<li>
    <xsl:if test="$startsWith='true' and $equals='false'"><xsl:attribute name="class">chosen</xsl:attribute></xsl:if>
    <xsl:if test="$startsWith='true' and $equals='true'"><xsl:attribute name="class">chosen</xsl:attribute></xsl:if>
    <xsl:if test="$startsWith='false'"><xsl:attribute name="class"></xsl:attribute></xsl:if>

    <xsl:choose>
        <xsl:when test="$startsWith!='true' or ($startsWith='true' and $equals!='true')"><nobr><a href="{@url}">
        <xsl:if test="$startsWith='true' and $equals='false'"><xsl:attribute name="class">sub</xsl:attribute></xsl:if>
        <xsl:value-of select="@name" disable-output-escaping="yes"/></a></nobr></xsl:when>
        <xsl:otherwise><xsl:value-of select="@name" disable-output-escaping="yes"/></xsl:otherwise>
    </xsl:choose>
</li>
</xsl:template>

<!--
    КНОПКА ТРЕТЬЕГО УРОВНЯ
-->
<xsl:template match="button" mode="third">

<!--Открытый путь начинается с пути кнопки-->
<xsl:variable name="startsWith"><xsl:value-of select="starts-with($url, @url)"/></xsl:variable>

<!--Открытый путь полностью совпадает с путём, прописанным в кнопке-->
<xsl:variable name="equals"><xsl:value-of select="@url=$url"/></xsl:variable>
<div>
    <xsl:if test="$startsWith='true' and $equals='false'"><xsl:attribute name="class">navi_sub</xsl:attribute></xsl:if>
    <xsl:if test="$startsWith='true' and $equals='true'"><xsl:attribute name="class">navi_chosen</xsl:attribute></xsl:if>
    <xsl:if test="$startsWith='false'"><xsl:attribute name="class">navi</xsl:attribute></xsl:if>

    <xsl:choose>
        <xsl:when test="$startsWith!='true' or ($startsWith='true' and $equals!='true')"><nobr><a href="{@url}">
        <xsl:value-of select="@name" disable-output-escaping="yes"/></a></nobr></xsl:when>
        <xsl:otherwise><xsl:value-of select="@name" disable-output-escaping="yes"/></xsl:otherwise>
    </xsl:choose>
</div>
</xsl:template>

</xsl:stylesheet>