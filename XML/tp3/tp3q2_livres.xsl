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
        <h1>Mes livres - Question 2</h1>
    <table>
        <tr>
            <th>Titre</th>
            <th>Langue</th>
            <th>Édition</th>
            <th>ISBN</th>
            <th>Auteurs</th>
            <th>Contenu</th>
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
            <xsl:apply-templates select="edition"/>
            <xsl:apply-templates select="isbn"/>
            <xsl:apply-templates select="auteurs"/>
            <xsl:apply-templates select="contenu"/>
        </tr>
    </xsl:template>
    <!-- template des titres -->
    <xsl:template match="titre">
        <td>
            <xsl:value-of select="text()"/>
        </td>
    </xsl:template>
    <!-- template des editions -->
    <xsl:template match="edition">
        <td>
            <xsl:value-of select="text()"/>
        </td>
    </xsl:template>
    <!-- template des isbn -->
    <xsl:template match="isbn">
        <td>
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
    <!-- template des contenus -->
    <xsl:template match="contenu">
        <td>
            <xsl:value-of select="text()"/>               
        </td>
    </xsl:template>
</xsl:stylesheet>
