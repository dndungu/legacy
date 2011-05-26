<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/js/libs/jquery.uploadify-v2.1.4/uploadify.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="/js/libs/jquery-1.5.2.min.js"></script>
		<script type="text/javascript" src="/js/libs/jquery.uploadify-v2.1.4/swfobject.js"></script>
		<script type="text/javascript" src="/js/libs/jquery.uploadify-v2.1.4/jquery.uploadify.v2.1.4.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			  $('#file_upload').uploadify({
			    'uploader'  : '/js/libs/jquery.uploadify-v2.1.4/uploadify.swf',
			    'script'    : '/media/postimage',
			    'cancelImg' : '/js/libs/jquery.uploadify-v2.1.4/cancel.png',
			    'folder'    : '/image/',
			    'auto'      : true,
			    'onError'	: function(event,ID,fileObj,errorObj){console.info(errorObj.type+' Error: '+errorObj.info)},
			    'onComplete' : function(event, ID, fileObj, response, data){window.parent.location.reload();}
			  });
			});
		</script>
	</head>
	<body>
		<input id="file_upload" name="file_upload" type="file" />
	</body>
</html>