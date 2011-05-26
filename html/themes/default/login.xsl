<?xml version='1.0'?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css" media="screen">@import url(/themes/default/images/screen.css);</style>
<title><xsl:value-of select="/root/company"/> - <xsl:value-of select="/root/title"/></title>
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
		<div class="container" id="login">
			<span class="column grid_12" id="errors"></span>
			<span class="column grid_12" id="info"></span>
			<form id="signin" class="column grid_12" action="/user/login" method="post" status='open'>
				<h2>Sign in</h2>
				<label class="column grid_12">Username or email</label>
				<input type="text" name="username" class="column grid_6"/>
				<label class="column grid_12">Password</label>
				<input type="password" name="password" class="column grid_2"/>
				<p class="grid_12 column">
					<input type="button" id="postSignin" post="signin" name="submit" value="Sign In"/>
				</p>
				<p class="column grid_12">
					<a href="/user/login" form="register" onclick="return false">Create account</a> | <a href="/user/login" form="forgot" onclick="return false">Forgot password</a>
				</p>
			</form>
			<form id="register" class="column grid_12" action="/user/login" method="post" style="display:none;" status='closed'>
				<h2>Create account</h2>
				<label class="column grid_12">Email</label>
				<input type="text" name="email" class="column grid_6"/>
				<label class="column grid_12">Username</label>
				<input type="text" name="username" class="column grid_3"/>
				<label class="column grid_12">Password</label>
				<input type="password" name="password" class="column grid_2"/>
				<label class="column grid_12">Confirm password</label>
				<input type="password" name="confirm" class="column grid_2"/>
				<p class="grid_12 column">
					<input type="button" id="postRegister" post="register" name="submit" value="Register"/>
				</p>
				<p class="column grid_12">
					<a href="/user/login" form="signin" onclick="return false">Sign in</a> | <a href="/user/login" form="forgot" onclick="return false">Forgot password</a>
				</p>
			</form>
			<form id="forgot" class="column grid_12" action="/user/login" method="post" style="display:none;" status='closed'>
				<h2>Request password recovery token</h2>
				<label class="column grid_12">Email</label>
				<input type="text" name="email" class="column grid_6"/>
				<p class="grid_12 column">
					<input type="button" id="postForgot" post="forgot" name="submit" value="Email Me a Token"/>
				</p>
				<p class="column grid_12">
					<a href="/user/login" form="signin" onclick="return false">Sign in</a> | <a href="/user/login" form="register" onclick="return false">Create account</a> | <a href="/user/login" form="change" onclick="return false">Change Password</a>
				</p>
			</form>			
			<form id="change" class="column grid_12" action="/user/login" method="post" style="display:none;" status='closed'>
				<h2>Change password</h2>
				<label class="column grid_12">Email</label>
				<input type="text" name="email" class="column grid_6"/>
				<label class="column grid_12">Token</label>
				<input type="text" name="token" class="column grid_6"/>
				<label class="column grid_12">Password</label>
				<input type="password" name="password" class="column grid_2"/>
				<label class="column grid_12">Confirm password</label>
				<input type="password" name="confirm" class="column grid_2"/>
				<p class="grid_12 column">
					<input type="button" id="postChange" post="change" name="submit" value="Change Password"/>
				</p>
				<p class="column grid_12">
					<a href="/user/login" form="forgot" onclick="return false">Request password recovery token</a> | <a href="/user/login" form="signin" onclick="return false">Sign in</a> | <a href="/user/login" form="register" onclick="return false">Create account</a>
				</p>
			</form>
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
			<div class="column grid_4"><!--
				<strong><xsl:value-of select="/root/sections/directions/title"/></strong>
				<xsl:value-of select="/root/sections/directions/content" disable-output-escaping="yes"/>-->
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/libs/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="/js/libs/json2.js"></script>
	<script type="text/javascript" src="/js/core.js"></script>
	<script type="text/javascript" src="/js/sandbox.js"></script>
	<script type="text/javascript" src="/js/modules/login.js"></script>
	<script type="text/javascript">core.boot();</script>
</body>
</html>
</xsl:template>
</xsl:stylesheet>