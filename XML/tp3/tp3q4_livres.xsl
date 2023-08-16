<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="utf-8"/>
    <!-- template général -->
    <xsl:template match="/">
        <html>
            <head>
                <title>travail pratique #3</title>
                <style>
                    table { border-style: outset; border-width: 1px; }
                    th, td { border-style: groove; border-width: 1px; }
                    td:first-of-type { font-style: italic; }
                    tr:first-of-type { background-color: #9acd32; }
                </style>
            </head>
            <body>
                <xsl:apply-templates/>
            </body>
        </html>
    </xsl:template>
    <!-- template de tous les livres -->
    <xsl:template match="livres">
        <h1>Mes livres - Question 4</h1>
        <table>
            <tr>
                <th>Titre</th>
                <th>Langue</th>
                <th>CD inclus</th>
                <th>Auteurs</th>
            </tr>
            <xsl:apply-templates/>
        </table>
    </xsl:template>
    <!-- template de chaque livre -->
    <xsl:template match="livre">
        <!-- création d'une variable -->
        <xsl:variable name="langue">
            <xsl:value-of select="@langue">
            </xsl:value-of>
        </xsl:variable>
        <tr>
            <!-- attribut de stylisation selon une condition -->
            <xsl:attribute name="style">
                <xsl:text>background-color:</xsl:text>
                <xsl:choose>
                    <xsl:when test="@langue='francais'">#909090</xsl:when>
                    <xsl:when test="@langue='anglais'">#C0C0C0</xsl:when>
                    <xsl:otherwise>#FFFFFF</xsl:otherwise>
                </xsl:choose>
            </xsl:attribute>
            <!-- application des templates -->
            <xsl:apply-templates select="titre"/>
            <td><xsl:value-of select="$langue"/></td>
            <xsl:apply-templates select="cd_inclus"/>
            <xsl:apply-templates select="auteurs"/>
        </tr>
    </xsl:template>
    <!-- template des titres -->
    <xsl:template match="titre">
        <td>
            <xsl:value-of select="text()"/>
        </td>
    </xsl:template>
    <!-- template des cd qui sont inclus -->
    <xsl:template match="cd_inclus">
        <td>
            <!-- attribut de stylisation selon une condition -->
            <xsl:attribute name="style">
                <xsl:text>color:</xsl:text>
                <xsl:choose>
                    <xsl:when test="text()='oui'">blue</xsl:when>
                    <xsl:when test="text()='non'">red</xsl:when>
                    <xsl:otherwise>black</xsl:otherwise> 
                </xsl:choose>
            </xsl:attribute>
            <xsl:value-of select="text()"/>
        </td>
    </xsl:template>
    <!-- template des auteurs, puis du format « liste » -->
    <xsl:template match="auteurs">
        <td>
            <ul>
                <xsl:apply-templates select="auteur"/>
            </ul>
        </td>
    </xsl:template>
    <!-- template de la liste prénom et nom par auteur-->
    <xsl:template match="auteur">
        <li>
            <xsl:value-of select="prenom/text()"/>
            <xsl:text> </xsl:text>
            <xsl:value-of select="nom/text()"/>
        </li>
    </xsl:template>
</xsl:stylesheet>

