<?xml version='1.0'?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" />
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
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
		<div class="container" id="recruitment">
			<div class="column grid_12" id="errors"></div>
			<div class="column grid_12" id="info"></div>		
			<div class="column grid_12">
				<h2 class="open" form="personal">Personal information</h2>
				<p class="add open" form="personal"><a>edit</a></p>
				<form id="personal" action="/user" onsubmit="return false" method="post" style="column grid_12" status="open">
					<label class="column grid_12">First name</label>
					<input class="column grid_6" type="text" name="firstName" value="{/root/user/firstName}"/>
					<label class="column grid_12">Last name</label>
					<input class="column grid_6" type="text" name="lastName" value="{/root/user/lastName}"/>
					<p class="column grid_12">
						<input type="radio" name="gender" value="Female"><xsl:if test="/root/user/gender='Female'"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input> Female <input type="radio" name="gender" value="Male"><xsl:if test="/root/user/gender='Male'"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input> Male
					</p>
					<label class="column grid_12">Date of birth</label>
					<input class="column grid_2 datepicker" type="text" name="dob" value="{/root/user/DOB}"/>
					<label class="column grid_12">E-mail</label>
					<input class="column grid_6" type="text" name="email" value="{/root/user/email}"/>
					<label class="column grid_12">Phone</label>
					<input class="column grid_6" type="text" name="phone" value="{/root/user/phone}"/>
					<label class="column grid_12">Mailing Address</label>
					<textarea rows="3" cols="10" class="column grid_12" name="address"><xsl:value-of select="/root/user/address"/></textarea>
					<label class="column grid_12">Website</label>
					<input class="column grid_12" type="text" name="website" value="{/root/user/website}"/>
					<label class="column grid_12">Notice in days</label>
					<input class="column grid_1" maxlength="3" type="text" name="notice"  value="{/root/user/notice}"/>
					<label class="column grid_12">Availability</label>
					<p class="column grid_12">
						<input type="checkbox" name="fulltime" value="Yes"><xsl:if test="/root/user/fulltime='Yes'"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input> Fulltime <input type="checkbox" name="freelancer" value="Yes"><xsl:if test="/root/user/freelancer='Yes'"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input> Project based
					</p>
					<label class="column grid_12">Cover letter</label>
					<textarea rows="15" cols="10" class="column grid_12" name="about"><xsl:value-of select="/root/user/about"/></textarea>					
					<p class="column grid_12">
						<input type="button" id="savePersonal" value="SAVE"/> <input type="reset" module="personal" value="CANCEL"/>
					</p>
				</form>
			</div>
			<div class="column grid_12">
				<h2 form="education">Education</h2>
				<span id="printEducation">
					<xsl:for-each select="/root/education">
						<p>
							<strong class="nomargin grid_8"><xsl:value-of select="name"/> - <xsl:value-of select="program"/> - <xsl:value-of select="institution"/></strong><em class="nomargin grid_4"><xsl:value-of select="start"/> - <xsl:value-of select="completion"/></em>
							<span class="nomargin grid_10"><xsl:value-of select="notes"/></span><em class="nomargin grid_2">[ <a education="{ID}" class="edit" edit="education">edit</a> ] [ <a education="{ID}" class="trash" trash="education">delete</a> ]</em>
						</p>
					</xsl:for-each>				
				</span>
				<p class="add" form="education"><a>add</a></p>
				<form id="education" action="/education" onsubmit="return false" method="post" style="column grid_12" status="closed">
					<label class="column grid_12">Grade</label>
					<input type="text" class="column grid 1" name="grade"/>
					<label class="column grid_12">Certification</label>
					<select name="certification" class="column grid_3" id="certification"><xsl:for-each select="/root/recruitment/certification"><option value="{ID}"><xsl:value-of select="name"/></option></xsl:for-each></select>
					<label class="column grid_12">Program</label>
					<input class="column grid_6" type="text" name="program"/>
					<label class="column grid_12">Institution</label>
					<input class="column grid_6" type="text" name="institution"/>
					<label class="column grid_12">Start date</label>
					<input class="column grid_2 datepicker" type="text" name="start"/>					
					<label class="column grid_12">Completion date</label>
					<input class="column grid_2 datepicker" type="text" name="completion"/>
					<label class="column grid_12">Description</label>
					<input name="education" type="hidden" value="0"/>
					<textarea name="notes" class="column grid_12" rows="2"></textarea>
					<p class="column grid_12">
						<input type="button" value="ADD" id="addEducation"/> <input type="reset" module="education" value="CANCEL"/>
					</p>
				</form>
			</div>
			<div class="column grid_12">
				<h2 form="experience">Experience</h2>
				<span id="printExperience">
					<xsl:for-each select="/root/experience">
						<p>
							<strong class="nomargin grid_8"><xsl:value-of select="role"/> - <xsl:value-of select="organisation"/></strong><em class="nomargin grid_4"><xsl:value-of select="start"/> - <xsl:value-of select="completion"/></em>
							<span class="nomargin grid_10"><xsl:value-of select="technologies"/></span><em class="nomargin grid_2">[ <a experience="{ID}" class="edit" edit="experience">edit</a> ] [ <a experience="{ID}" class="trash" trash="experience">delete</a> ]</em>
							<span class="nomargin grid_12"><xsl:value-of select="notes"/></span>
						</p>
					</xsl:for-each>
				</span>
				<p class="add" form="experience"><a>add</a></p>		
				<form id="experience" action="/experience" onsubmit="return false" method="post" column="column grid_12" status="closed">
					<label class="column grid_12">Role</label>
					<input class="column grid_6" type="text" name="role"/>					
					<label class="column grid_12">Organisation</label>
					<input class="column grid_6" type="text" name="organisation"/>
					<label class="column grid_12" id="technologies">Technologies</label>
					<p class="nomargin grid_12">
						<select class="column grid_3" id="technology">
							<xsl:for-each select="/root/technologies/technology">
								<option value="{ID}"><xsl:value-of select="fullname"></xsl:value-of></option>
							</xsl:for-each>
						</select>
						<input name="submit" type="button" id="addTechnology" value="ADD" class="column grid_1"/>
					</p>
					<label class="column grid_12">Start date</label>
					<input class="column grid_2 datepicker" type="text" name="start"/>					
					<label class="column grid_12">Completion date</label>
					<input class="column grid_2 datepicker" type="text" name="completion"/>
					<label class="column grid_12">Team size</label>
					<input class="column grid_1" maxsize="5" type="text" name="team"/>
					<label class="column grid_12">Description</label>
					<input name="experience" type="hidden" value="0"/>
					<textarea name="notes" class="column grid_12" rows="3"></textarea>					
					<p class="column grid_12">
						<input type="button" value="ADD" id="addExperience"/> <input type="reset" module="experience" value="CANCEL"/>
					</p>					
				</form>
			</div>
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
				<xsl:value-of select="/root/sections/directions/content" disable-output-escaping="yes"/> -->
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/js/libs/jquery-1.5.2.min.js"></script>
	<script type="text/javascript" src="/js/libs/jquery-ui-1.8.11.custom.min.js"></script>
	<script type="text/javascript" src="/js/libs/json2.js"></script>
	<script type="text/javascript" src="/js/core.js"></script>
	<script type="text/javascript" src="/js/sandbox.js"></script>
	<script type="text/javascript" src="/js/modules/recruitment.js"></script>
	<script type="text/javascript">core.boot();$(".datepicker").datepicker();</script>
</body>
</html>
</xsl:template>
</xsl:stylesheet>