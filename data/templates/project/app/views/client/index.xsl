<?xml version="1.0" encoding="Windows-1251"?>

<!DOCTYPE xsl:stylesheet SYSTEM "../symbols.ent">

<xsl:stylesheet 
    version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    xmlns:php="http://php.net/xsl"
    xsl:extension-element-prefixes="php"
>

<xsl:import href="../layouts/default.xsl"/>

<xsl:param name="pageTitle">Админка - Клиенты</xsl:param>

<xsl:output
    encoding="UTF-8"
    method="html"
    indent="yes"
    doctype-public="-//W3C//DTD HTML 4.01 Transitional//EN"
/>

<xsl:namespace-alias stylesheet-prefix="php" result-prefix="xsl" />

<xsl:template name="content">
    <div class="content">
        <div id="dashboard" style="margin: 0 5% 0 5%;">
            <h1>Наши клиенты</h1>
                <ul>
                    <xsl:for-each select="/root/clients/row">
                    <li>
                        <a href="/clients/{url}/"><xsl:value-of select="name" disable-output-escaping="yes" /></a>
                    </li>
                    </xsl:for-each>
                </ul>
<!--
                <div id="UploadsManagers">
                    
                </div>
-->            
        </div>
        <div style="clear: both;"></div>
    </div>
</xsl:template>

</xsl:stylesheet>