<?xml version="1.0" encoding="Windows-1251"?>

<!DOCTYPE xsl:stylesheet SYSTEM "../symbols.ent">

<xsl:stylesheet 
    version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
>

<xsl:output
    encoding="UTF-8"
    method="html"
    indent="yes"
/>

    <xsl:template match="/*[1]">
    <html>
        <head>
            <xsl:call-template name="head" />
            
        </head>
        <body>
            <xsl:call-template name="content" />
        </body>

    </html>
    </xsl:template>

    <xsl:template name="head">
    </xsl:template>

    <xsl:template name="content">
    </xsl:template>

</xsl:stylesheet>
