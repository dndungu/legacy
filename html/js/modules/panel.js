core.register('panel', function(sandbox){
	return {
		init: function(){
			sandbox.tinymce = {};
			sandbox.tinymceOptions = this.tinymceOptions();
			sandbox.module = 'story';
			sandbox.view = 'browse';
			sandbox.listen(['view'], this.view);
			sandbox.listen(['panel.browse'], this.browse);
			sandbox.listen(['panel.form'], this.form);
			sandbox.listen(['panel.form'], this.editor);
		},
		destroy: function(){
			
		},
		tinymceOptions: function(){
			return {
				mode : "textareas",
				theme : "advanced",
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

				// Theme options
				theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

				// Example content CSS (should be your site CSS)
				content_css : "css/content.css",

				// Drop lists for link/image/media/template dialogs
				template_external_list_url : "",
				external_link_list_url : "",
				external_image_list_url : "/media/imagelistjs",
				media_external_list_url : "",

				// Style formats
				style_formats : [
					{title : 'Bold text', inline : 'b'},
					{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
					{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
					{title : 'Example 1', inline : 'span', classes : 'example1'},
					{title : 'Example 2', inline : 'span', classes : 'example2'},
					{title : 'Table styles'},
					{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
				],

				// Replace values for the template plugin
				template_replace_values : {
					username : "Some User",
					staffid : "991234"
				}
			};
		},		
		navigate: function(){
			$(document).ready(function(){
				var hash = window.location.hash.toString();
				var tab = hash.length ? hash.replace('#', '') : 'story.browse';
				var commands = tab.split('.');
				$('#navigation ul li ul li[module="'+commands[0]+'"][view="'+commands[1]+'"]').parent().parent().mousedown().children('ul').children('li[module="'+commands[0]+'"][view="'+commands[1]+'"]').mousedown();
			});
			$('#navigation > ul > li').unbind('mousedown').mousedown(function(event){
				$('#navigation > ul > li[class="open"]').removeClass('open').children('ul').hide();
				$(this).addClass('open').children('ul').fadeIn('slow', 'swing');
				sandbox.notify("view");
			});
			$('#navigation > ul > li > ul > li').unbind().mousedown(function(event){
				event.stopPropagation();
				$('#navigation > ul > li[class="open"] > ul > li[class="open"]').removeClass('open');
				$(this).addClass('open');
				sandbox.notify("view");
			});
			$('#navigation form[module="search"]').unbind("submit").submit(function(event){
				event.preventDefault();
				var keywords = $(this).children('input[name="keywords"]').val();
				var type = sandbox.module+'.search'
				sandbox.notify({"type": type, "data": keywords});
			});
		}(),
		view: function(event){
			sandbox.module = $('#navigation > ul > li[class="open"] > ul > li[class="open"]').attr("module").toString();
			sandbox.view = $('#navigation > ul > li[class="open"] > ul > li[class="open"]').attr("view").toString();
			sandbox.notify(sandbox.module+'.'+sandbox.view);
			window.location.hash = sandbox.module+'.'+sandbox.view;
		},
		browse: function(event){
			$('#main .add').unbind('mousedown').mousedown(function(event){
				sandbox.notify(sandbox.module+'.add');
			});
			$('#main .edit').unbind('mousedown').mousedown(function(event){
				sandbox.notify({"type": sandbox.module+'.edit', "data": {"key": $(this).attr('key'), "element": this}});
			});
			$('#main .trash').unbind('mousedown').mousedown(function(event){
				sandbox.notify({"type": sandbox.module+'.trash', "data": {"key": $(this).attr('key'), "element": this}});
			});
			$('#main .restore').unbind('mousedown').mousedown(function(event){
				sandbox.notify({"type": sandbox.module+'.restore', "data": {"key": $(this).attr('key'), "element": this}});
			});
		},
		form: function(event){
			$('#main input[do="submit"]').unbind('mousedown').mousedown(function(event){
				sandbox.notify({"type": sandbox.module+'.'+$(this).attr("name"), "data": $('#main form').serializeArray()});
			});
			$('#main input[type="reset"]').unbind('mousedown').mousedown(function(event){
				sandbox.notify(sandbox.module+'.browse');
			});
			tinyMCE.init(sandbox.tinymceOptions);
		},
		search: function(){
			
		}
	};
});