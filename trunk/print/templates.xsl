<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="2.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    xmlns:fo="http://www.w3.org/1999/XSL/Format"
    xmlns:date="http://exslt.org/dates-and-times">

<!-- XSL-FO Stylesheet, Formatting templates for the Code4Lib Journal -->

<!-- 
Copyright (c) 2008 Ryan Wick 

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
-->


<xsl:template match="p">
	<fo:block space-after=".15in" font="11pt Times"><xsl:apply-templates/></fo:block>
</xsl:template>


<xsl:template match="h2">
	<fo:block space-after=".2in" font-size="14pt" font-weight="bold"><xsl:value-of select="."/></fo:block>
</xsl:template>

<xsl:template match="h3">
	<fo:block space-after=".2in" font-size="12pt" font-weight="bold"><xsl:value-of select="."/></fo:block>
</xsl:template>

<xsl:template match="h4">
	<fo:block space-after=".2in" font-size="11pt" font-weight="bold"><xsl:value-of select="."/></fo:block>
</xsl:template>



<xsl:template match="b">
	<fo:wrapper font-weight="bold"><xsl:value-of select="."/></fo:wrapper>
</xsl:template>
 
<xsl:template match="i">
	<fo:wrapper font-style="italic"><xsl:value-of select="."/></fo:wrapper>
</xsl:template>
 
<xsl:template match="u">
	<fo:wrapper text-decoration="underline"><xsl:value-of select="."/></fo:wrapper>
</xsl:template>


<!--
<xsl:template match="pre[@name='code']">
-->
<xsl:template match="pre">
	<fo:block font="8pt Courier" space-before=".25in" space-after=".25in" white-space-treatment="preserve" white-space-collapse="false" linefeed-treatment="preserve" keep-together.within-page="always" background-color="#EEEEEE"><xsl:value-of select="."/></fo:block>
</xsl:template>



<xsl:template match="a">
	<fo:basic-link external-destination="url({@href})" text-decoration="underline" color="blue"><xsl:value-of select="."/></fo:basic-link>
</xsl:template>



<xsl:template match="ol">
    <fo:list-block space-before="0.25in" space-after="0.25in" provisional-distance-between-starts=".3in" provisional-label-separation=".15in" start-indent=".5in"><xsl:apply-templates/></fo:list-block>
</xsl:template>

<xsl:template match="ol/li">
    <fo:list-item>
        <fo:list-item-label end-indent="label-end()" space-after=".25in">
            <fo:block font="11pt Times"><xsl:number/>. </fo:block>
        </fo:list-item-label>
        <fo:list-item-body start-indent="body-start()">
            <fo:block font="11pt Times"><xsl:apply-templates/></fo:block>
        </fo:list-item-body>
    </fo:list-item>
</xsl:template>



<xsl:template match="ul">
    <fo:list-block space-before="0.25in" space-after="0.25in" provisional-distance-between-starts=".3in" provisional-label-separation=".15in" start-indent=".5in"><xsl:apply-templates/></fo:list-block>
</xsl:template>

<xsl:template match="ul/li">
    <fo:list-item>
        <fo:list-item-label end-indent="label-end()" space-after=".25in">
			<fo:block>•</fo:block> 
        </fo:list-item-label>
        <fo:list-item-body start-indent="body-start()">
            <fo:block font="11pt Times"><xsl:apply-templates/></fo:block>
        </fo:list-item-body>
    </fo:list-item>
</xsl:template>



<xsl:template match="img">

<xsl:variable name="filename">

<!-- cut down to just the filename - split on / and grab last one -->
<xsl:value-of select="concat('images/', tokenize(@src, '/')[last()])"/>

</xsl:variable>

<xsl:message>  filename + replace = <xsl:value-of select="replace($filename, '\.(\w{3})', '_fullsize.$1')"/></xsl:message>

<fo:block>
<fo:external-graphic src="url({replace($filename, '\.(\w{3})', '_fullsize.$1')})"
	width="100%" content-width="scale-to-fit" scaling="uniform" content-height="100%"/>
</fo:block>

<!--
<xsl:choose>
<xsl:when test="../a">
	<fo:block><fo:external-graphic src="url({../a/@href})"/></fo:block>
</xsl:when>
<xsl:otherwise>
	<fo:block><fo:external-graphic src="url({@src})"/></fo:block>
</xsl:otherwise>
</xsl:choose>
-->

</xsl:template>

</xsl:stylesheet>
