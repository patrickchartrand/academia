<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <!-- création d'une clé pour les livres selon une langue spécifique -->
    <xsl:key name="index-livre" match="livre" use="@langue"/>
    <!-- template général -->
    <xsl:template match="/">
        <xsl:apply-templates select="livres"/>
    </xsl:template>
    <!-- template de tous les livres -->
    <xsl:template match="livres">
        <html>
            <head>
                <title>travail pratique #3</title>
                <style>
                    table { border-style: outset; border-width: 1px; }
                    th, td { border-style: groove; border-width: 1px; }
                    td:first-of-type { font-style: italic; }
                    tr:first-of-type { background-color: #9acd32; }
                    /* pour alléger le code, j'ai ajouté ça ici */
                    tr { background-color: #909090; }
                </style>
            </head>
            <body>
                <h1>Mes livres - Question 5</h1>
                <table>
                    <tr>
                        <th>Titre</th>
                        <th>Image</th>
                        <th>Langue</th>
                        <th>CD inclus</th>
                        <th>Auteurs</th>
                    </tr>
                    <!-- spécification de la clé pour chaque livre en langue française -->
                    <xsl:for-each select="key('index-livre', 'francais')">
                        <xsl:call-template name="livre_fra"/>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
    <!-- template de chaque livre -->
    <xsl:template name="livre_fra">
        <!-- création d'une variable -->
        <xsl:variable name="langue">
            <xsl:value-of select="@langue">
            </xsl:value-of>
        </xsl:variable>
        <tr>
            <!-- application des templates -->
            <xsl:apply-templates select="titre"/>
            <xsl:apply-templates select="image"/>
            <td><xsl:value-of select="$langue"/></td>
            <xsl:call-template name="cd">
                <!-- ajout d'un paramètre -->
                <xsl:with-param name="no_livre">
                    <xsl:value-of select="position()"/>
                </xsl:with-param>
            </xsl:call-template>
            <xsl:apply-templates select="auteurs"/>
        </tr>
    </xsl:template>
    <!-- template des titres -->
    <xsl:template match="titre">
        <td>
            <xsl:value-of select="text()"/>
        </td>
    </xsl:template>
    <!-- template des images -->
    <xsl:template match="image">
        <!-- création d'une autre variable -->
        <xsl:variable name="img">
            <xsl:value-of select="@src"/>
        </xsl:variable>
        <td>
            <img src="images/{$img}"/>
        </td>
    </xsl:template>
    <!-- template des cd qui sont inclus, puis du format « bouton » -->
    <xsl:template name="cd">
        <xsl:param name="no_livre">0</xsl:param>
        <td>
            <!-- bouton « oui » -->
            <xsl:text>Oui </xsl:text>
            <input type="radio" value="oui">
                <xsl:attribute name="name">
                    cd_inclus<xsl:value-of select="$no_livre"/>
                </xsl:attribute>
                <xsl:if test="cd_inclus='oui'">
                    <xsl:attribute name="checked">
                        checked
                    </xsl:attribute>
                </xsl:if>
            </input>
            <!-- bouton « non » -->
            <xsl:text>Non </xsl:text>
            <input type="radio" value="non">
                <xsl:attribute name="name">
                    cd_inclus<xsl:value-of select="$no_livre"/>
                </xsl:attribute>
                <xsl:if test="cd_inclus='non'">
                    <xsl:attribute name="checked">
                        checked
                    </xsl:attribute>
                </xsl:if>
            </input>
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

