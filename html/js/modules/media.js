core.register('media', function(sandbox){
	return {
		init: function(){
			sandbox.item = {};
			sandbox.form = '';
			sandbox.items = [];
			sandbox.listen(['media.refresh'], this.refresh);
			sandbox.listen(['media.browse'], this.browse);
			sandbox.listen(['media.add'], this.form);
			sandbox.listen(['media.save'], this.post);
			sandbox.listen(['media.edit'], this.edit);
			sandbox.listen(['media.trash'], this.trash);
			sandbox.listen(['media.recycle'], this.recycle);
			sandbox.listen(['media.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/media/browseimages', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
			$.get('/media/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/media/browseimages', function(response){
				sandbox.items = response instanceof Array ? response : [];
				sandbox.notify('media.browse');
			});
		},
		browse: function(event){
			var html = sandbox.form;
			$('#main').html(function(){
				html += '<div class="list imagegallery">';
				for(i in sandbox.items){
					var item = sandbox.items[i];
					html += '<div class="column grid_1" style="text-align:center;margin-top:20px;"><img image="'+item.image+'" src="'+item.path+'" height="100"/><br/><a class="trash" style="width:25px;height:25px;float:left:clear:both;display:inline-block;"></a></div>'
				}
				html += '</div>';
				return html;
			}());
		},
		form: function(event){
			$('#main').html(sandbox.rows(sandbox.items));
			$('#main').html(sandbox.form);
			sandbox.notify('panel.form');			
		},
		post: function(event){
			sandbox.post('/media/post', event.data);
		},		
		edit: function(event){
			var key = event.data.key;
			sandbox.item = function(){
							for(i in sandbox.items){
								if(sandbox.items[i].ID == key){
										return sandbox.items[i];
								}
							}
						}();
			sandbox.item.media = sandbox.item.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.item[name]);});}).html(sandbox.form).change();			
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/media/trash', {"media": event.data.key});
				sandbox.notify('media.refresh');
			}
		},
		recycle: function(event){
			$.get('/media/recycle', function(response){
				function adjust(response){
					var items = [];
					for(i in response){
						var item = response[i];
						item.title = item.content;
						items.push(item);
					}
					return items;
				};
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(adjust(response))) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});
		},
		restore: function(event){
			$(event.data.element).parent().parent().fadeOut('slow');
			sandbox.post('/media/restore', {"media": event.data.key});
			function adjust(response){
				var items = [];
				for(i in response){
					var item = response[i];
					item.title = item.content;
					items.push(item);
				}
				return items;
			};
			$.get('/media/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(adjust(response))) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/media/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
		}		
	};
});