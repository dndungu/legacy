<?xml version='1.0'?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" media="screen">@import url(/themes/default/images/screen.css);</style>
<title><xsl:value-of select="/root/story/title"/> - <xsl:value-of select="/root/company"/> - <xsl:value-of select="/root/title"/></title>
</head>
<body>
	<div id="top">
		<div class="container">
			<a class="logo"></a>
			<xsl:value-of select="/root/navigation/primary" disable-output-escaping="yes"/>
		</div>
	</div>
	<div class="dropup"></div>
	<div id="banner">
		<div class="container">
			<strong class="column grid_12"><xsl:value-of select="/root/sections/top/title"/></strong>
			<p class="column grid_9"><xsl:value-of select="/root/sections/top/content" disable-output-escaping="yes"/></p>
		</div>
	</div>
	<div class="dropdown"></div>
	<div id="page">
		<div class="container">
		<h2><xsl:value-of select="/root/story/title"/></h2>
		<xsl:value-of select="/root/story/content" disable-output-escaping="yes"/>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<div class="column grid_4">
				<strong><xsl:value-of select="/root/sections/kenya/title"/></strong>
				<xsl:value-of select="/root/sections/kenya/content" disable-output-escaping="yes"/>		
			</div>
			<div class="column grid_4">
				<strong><xsl:value-of select="/root/sections/denmark/title"/></strong>
				<xsl:value-of select="/root/sections/denmark/content" disable-output-escaping="yes"/>
			</div>
			<div class="column grid_4">
				<strong><xsl:value-of select="/root/sections/directions/title"/></strong>
				<xsl:value-of select="/root/sections/directions/content" disable-output-escaping="yes"/>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/libs/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="/js/libs/json2.js"></script>
	<script type="text/javascript" src="/js/core.js"></script>
	<script type="text/javascript" src="/js/sandbox.js"></script>
	<script type="text/javascript">core.boot();</script>
</body>
</html>
</xsl:template>
</xsl:stylesheet>