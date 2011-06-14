<?xml version='1.0'?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
			<head>
				<title><xsl:value-of select="/root/company" /> - <xsl:value-of select="/root/title" /></title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<link href="themes/default/images/panel.css" rel="stylesheet" type="text/css" />
			</head>
			<body>
				<div id="navigation">
					<ul class="column grid_5">
						<li>
							<a href="/">Home</a>
						</li>
						<li class="open">
							<a>Content</a>
							<ul>
								<li class="open" module="story" view="browse">
									<a>articles</a>
								</li>
								<li module="page" view="browse">
									<a>pages</a>
								</li>
								<li module="widget" view="browse">
									<a>widgets</a>
								</li>
								<li module="banner" view="browse">
									<a>banners</a>
								</li>
							</ul>
						</li>
						<li>
							<a>Users</a>
							<ul>
								<li class="open" module="recruitment" view="browse">
									<a>applicants</a>
								</li>
								<li module="technology" view="browse">
									<a>technologies</a>
								</li>
								<li module="certification" view="browse">
									<a>certifications</a>
								</li>
							</ul>
						</li>
						<li>
							<a>Media</a>
							<ul>
								<li class="open" module="media" view="browse">
									<a>images</a>
								</li><!--
								<li module="aspect" view="browse">
									<a>image sizes</a>
								</li>-->
							</ul>
						</li>
						<li>
							<a>Settings</a>
							<ul>
								<li class="open" module="setting" view="browse">
									<a>global</a>
								</li>
								<li module="section" view="browse">
									<a>categories</a>
								</li>
								<li module="navigation" view="browse">
									<a>menu</a>
								</li>
							</ul>
						</li>
						<li>
							<a>Trash</a>
							<ul>
								<li class="open" module="story" view="recycle">
									<a>articles</a>
								</li>
								<li module="page" view="recycle">
									<a>pages</a>
								</li>
								<li class="open" module="section" view="recycle">
									<a>categories</a>
								</li>
								<li module="widget" view="recycle">
									<a>widget</a>
								</li>
								<li module="user" view="recycle">
									<a>users</a>
								</li>
								<li module="media" view="recycle">
									<a>images</a>
								</li><!--
								<li module="aspect" view="recycle">
									<a>image sizes</a>
								</li>-->
								<li module="technology" view="recycle">
									<a>technologies</a>
								</li>
								<li module="navigation" view="recycle">
									<a>menu</a>
								</li>
								<li module="certification" view="recycle">
									<a>certifications</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="/user/signout">Sign Out</a>
						</li>
					</ul>
					<form class="column grid_5" method="post" action="/user/panel" module="search">
						<input type="text" name="keywords"/>
						<a class="add">ADD NEW</a>
					</form>
				</div>
				<div id="main">

				</div>
				<div id="footer">
					<p class="column grid_10">
						<xsl:value-of select="/root/copyright" disable-output-escaping="yes" />
					</p>
				</div>
				<script type="text/javascript" src="/js/libs/jquery-1.5.2.min.js"></script>
				<script type="text/javascript" src="/js/libs/tiny_mce/tiny_mce.js"></script>
				<script type="text/javascript" src="/js/libs/json2.js"></script>
				<script type="text/javascript" src="/js/core.js"></script>
				<script type="text/javascript" src="/js/sandbox.js"></script>
				<script type="text/javascript" src="/js/modules/panel.js"></script>
				<script type="text/javascript" src="/js/modules/story.js"></script>
				<script type="text/javascript" src="/js/modules/page.js"></script>
				<script type="text/javascript" src="/js/modules/widget.js"></script>
				<script type="text/javascript" src="/js/modules/banner.panel.js"></script>
				<script type="text/javascript" src="/js/modules/technology.js"></script>
				<script type="text/javascript" src="/js/modules/certification.js"></script>
				<script type="text/javascript" src="/js/modules/section.js"></script>
				<script type="text/javascript" src="/js/modules/aspect.js"></script>
				<script type="text/javascript" src="/js/modules/navigation.js"></script>
				<script type="text/javascript" src="/js/modules/setting.js"></script>
				<script type="text/javascript" src="/js/modules/recruitment.panel.js"></script>
				<script type="text/javascript" src="/js/modules/media.js"></script>
				<script type="text/javascript">core.boot();</script>

			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>