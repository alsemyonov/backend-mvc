<?xml version="1.0" encoding="Windows-1251"?>

<!DOCTYPE xsl:stylesheet SYSTEM "../symbols.ent">

<xsl:stylesheet 
    version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
>

<!--
    ����� /root/url

    ��������� ������ �������� �� ������� xml, ��� ���������� ������� � ������ � ���� xml,
    ������ �� �������� xml �������� ����������. ���������� ������ trick.
-->
<xsl:param name="url" select="/root/url"/>

<!--
    ������ ������� ������
-->
<xsl:template match="button" mode="first">

<!--�������� ���� ���������� � ���� ������-->
<xsl:variable name="startsWith"><xsl:value-of select="starts-with($url, @url)"/></xsl:variable>

<!--�������� ���� ��������� ��������� � ����, ����������� � ������-->
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
    ������ ������� ������
-->
<xsl:template match="button" mode="second">

<!--�������� ���� ���������� � ���� ������-->
<xsl:variable name="startsWith"><xsl:value-of select="starts-with($url, @url)"/></xsl:variable>

<!--�������� ���� ��������� ��������� � ����, ����������� � ������-->
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
    ������ �������� ������
-->
<xsl:template match="button" mode="third">

<!--�������� ���� ���������� � ���� ������-->
<xsl:variable name="startsWith"><xsl:value-of select="starts-with($url, @url)"/></xsl:variable>

<!--�������� ���� ��������� ��������� � ����, ����������� � ������-->
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