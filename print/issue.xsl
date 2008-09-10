<?xml version='1.0'?>
<xsl:stylesheet version="2.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
    xmlns:fo="http://www.w3.org/1999/XSL/Format"
    xmlns:date="http://exslt.org/dates-and-times">


<!-- XSL-FO Stylesheet, Issue PDFs for The Code4Lib Journal -->

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

<xsl:include href="templates.xsl"/>

<xsl:variable name="journal">The Code4Lib Journal</xsl:variable>
<xsl:variable name="issn">ISSN 1940-5758</xsl:variable>

<xsl:variable name="title" select="issue/title"/>
<xsl:variable name="date" select="issue/date"/>



<xsl:template match="/">

<xsl:message><xsl:value-of select="$title"/> <xsl:value-of select="$date"/></xsl:message>

<fo:root>

<fo:layout-master-set>
		
<fo:simple-page-master master-name="firstpage"
		page-height="11in" 
		page-width="8.5in"
		margin-top="0in" 
		margin-bottom="0in"
		margin-left="0.15in" 
		margin-right="0.15in">

<fo:region-body region-name="body"
		margin-top="0.7in" 
		margin-bottom="0.5in" 
	  	margin-left="0.35in" 
		margin-right="0.35in"/>

<fo:region-after region-name="footer" extent="0.20in" background-color="#FFFFFF"/>

</fo:simple-page-master>
 		
 		
<fo:simple-page-master master-name="article"
		page-height="11in" 
		page-width="8.5in"
		margin-top="0.1in" 
		margin-bottom="0in"
		margin-left="0.15in" 
		margin-right="0.15in">

<fo:region-body region-name="body"
		margin-top="0.5in" 
		margin-bottom="0.5in" 
  		margin-left="0.35in" 
		margin-right="0.35in"/>

<fo:region-before region-name="header" extent="0.20in" background-color="#FFFFFF"/>
<fo:region-after region-name="footer" extent="0.20in" background-color="#FFFFFF"/>

</fo:simple-page-master>
		
</fo:layout-master-set>



<fo:page-sequence master-reference="firstpage">

<fo:static-content flow-name="footer">
	<fo:block font="9pt Times">
		PDF Created <xsl:value-of select="date:month-name()"/>&#160;<xsl:value-of select="date:day-in-month()"/>, <xsl:value-of select="date:year()"/>
	</fo:block>
</fo:static-content>

<fo:flow flow-name="body">

<fo:block font-size="14pt" font-weight="bold"><xsl:value-of select="$journal"/></fo:block>
<fo:block font-size="10pt"><xsl:value-of select="$issn"/></fo:block>

<fo:block font-size="12pt" space-before=".25in"><xsl:value-of select="$title"/>, <xsl:value-of select="$date"/></fo:block>



<fo:block font-size="12pt" font-weight="bold" space-before=".5in">Table of Contents</fo:block>

<fo:block>

<xsl:for-each select="issue/article">

<xsl:variable name="file" select="concat('C:/code4lib/journal/', ../id, '/article', ., '.xml')"/>
<xsl:variable name="title" select="document($file)/html/body/div[@id='page']/div[@id='content']/div[@class='article']/h1[@class='articletitle']/a"/>

<fo:block font-size="11pt" space-before=".20in" text-align-last="justify">

<fo:basic-link internal-destination="article{.}">

<xsl:value-of select="$title"/>

<fo:leader leader-pattern="dots" leader-alignment="reference-area"/>

</fo:basic-link>

<fo:basic-link internal-destination="article{.}" text-decoration="underline" color="blue">

<fo:page-number-citation>
	<xsl:attribute name="ref-id">article<xsl:value-of select="."/></xsl:attribute>
</fo:page-number-citation>

</fo:basic-link>

</fo:block>

<fo:block font-size="10pt" text-align="left"><xsl:value-of select="document($file)/html/body/div[@id='page']/div[@id='content']/div[@class='article']/div[@class='entry']/p[1]"/></fo:block>

</xsl:for-each>


</fo:block>


</fo:flow>

</fo:page-sequence>





<fo:page-sequence master-reference="article">
<fo:static-content flow-name="header">
	<fo:table>
		<fo:table-column column-width="80%"/>
		<fo:table-column column-width="20%"/>
		<fo:table-body>
			<fo:table-row>
				<fo:table-cell><fo:block font="9pt Times"><xsl:value-of select="$title"/>, <xsl:value-of select="$date"/></fo:block></fo:table-cell>
				<fo:table-cell><fo:block font="9pt Times" text-align="right">Page <fo:page-number/> of <fo:page-number-citation ref-id="last-page"/></fo:block></fo:table-cell>
		   </fo:table-row>
		</fo:table-body>
	</fo:table>
</fo:static-content>


<fo:static-content flow-name="footer">
	<fo:table>
		<fo:table-column column-width="50%"/>
		<fo:table-column column-width="50%"/>
		<fo:table-body>
			<fo:table-row>
				<fo:table-cell><fo:block font="9pt Times"><xsl:value-of select="$journal"/>, <xsl:value-of select="$issn"/> — <fo:basic-link external-destination="url(http://journal.code4lib.org)">http://journal.code4lib.org</fo:basic-link></fo:block></fo:table-cell>
				<fo:table-cell><fo:block font="9pt Times" text-align="right">
		PDF Created <xsl:value-of select="date:month-name()"/>&#160;<xsl:value-of select="date:day-in-month()"/>, <xsl:value-of select="date:year()"/>
	</fo:block></fo:table-cell>
		   </fo:table-row>
		</fo:table-body>
	</fo:table>	
</fo:static-content>


<fo:flow flow-name="body">



<xsl:for-each select="issue/article">

<xsl:variable name="file" select="concat('C:/code4lib/journal/', ../id, '/article', ., '.xml')"/>
<xsl:variable name="title" select="document($file)/html/body/div[@id='page']/div[@id='content']/div[@class='article']/h1[@class='articletitle']/a"/>

<fo:block id="article{.}" font-size="14pt" font-weight="bold">

<xsl:value-of select="$title"/>

</fo:block>



<fo:block font-size="11pt" space-before=".25in" page-break-after="always">

<xsl:apply-templates select="document($file)/html/body/div[@id='page']/div[@id='content']/div[@class='article']/div[@class='entry']"/>

</fo:block>

</xsl:for-each>

<fo:block id="last-page"/>
	
</fo:flow>
</fo:page-sequence>	
				
</fo:root>
</xsl:template>

</xsl:stylesheet>
