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
                    /* la classe « t » fait référence à des éléments du second tableau */
                    td:first-of-type:not(.t) { font-style: italic; }
                    tr:first-of-type:not(.t) { background-color: #9acd32; }
                </style>
            </head>
            <body>
                <xsl:apply-templates/>
            </body>
        </html>
    </xsl:template>
    <!-- template de tous les livres -->
    <xsl:template match="livres">
        <h1>Mes livres - Question 3</h1>
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
    <!-- template des cd qui sont inclus-->
    <xsl:template match="cd_inclus">
        <td>
            <!-- attribut de stylisation selon une condition-->
            <xsl:attribute name="style">
                <xsl:text>background-color:</xsl:text>
                <xsl:choose>
                    <xsl:when test="text()='oui'">red</xsl:when>
                    <xsl:when test="text()='non'">yellow</xsl:when>
                    <xsl:otherwise>white</xsl:otherwise>
                </xsl:choose>
            </xsl:attribute>
            <xsl:value-of select="text()"/>
        </td>
    </xsl:template>
    <!-- template des auteurs, puis du format « sous-tableau » -->
    <xsl:template match="auteurs">
        <td>
            <table style="border: 0; text-align: left;">
                <tr class="t">
                    <th style="border: 0;">Prénom</th>
                    <th style="border: 0;">Nom</th>
                </tr>
                    <xsl:apply-templates select="auteur"/>
            </table>
        </td>
    </xsl:template>
    <!-- template du sous-tableau prénom et nom par auteur-->
    <xsl:template match="auteur">
            <tr>
                <td style="border: 0;" class="t">
                <xsl:value-of select="prenom/text()"/>
                </td>
                <td style="border: 0;">
                <xsl:value-of select="nom/text()"/>
                </td>
            </tr>
    </xsl:template>
</xsl:stylesheet>

