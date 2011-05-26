core.register('section', function(sandbox){
	return {
		init: function(){
			sandbox.item = {};
			sandbox.form = '';
			sandbox.items = [];
			sandbox.listen(['section.refresh'], this.refresh);
			sandbox.listen(['section.browse'], this.browse);
			sandbox.listen(['section.add'], this.form);
			sandbox.listen(['section.save'], this.post);
			sandbox.listen(['section.edit'], this.edit);
			sandbox.listen(['section.trash'], this.trash);
			sandbox.listen(['section.recycle'], this.recycle);
			sandbox.listen(['section.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/section/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
			$.get('/section/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/section/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
				sandbox.notify('section.browse');
			});
		},
		browse: function(event){
			var items = [];
			for(i in sandbox.items){
				var item = sandbox.items[i];
				item.title = item.name;
				items.push(item);
			}
			var rows = sandbox.items.length > 0 ? function(){$('#main').html(sandbox.rows(items));return true;}() : false;
			var result = rows ? sandbox.notify('panel.browse') : false;
		},
		form: function(event){
			$('#main').html(sandbox.form);
			sandbox.notify('panel.form');			
		},
		post: function(event){
			sandbox.post('/section/post', event.data);
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
			sandbox.item.section = sandbox.item.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.item[name]);});}).html(sandbox.form).change();			
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/section/trash', {"section": event.data.key});
				sandbox.notify('section.refresh');
			}
		},
		recycle: function(event){
			$.get('/section/recycle', function(response){
				function adjust(response){
					var items = [];
					for(i in response){
						var item = response[i];
						item.title = item.name;
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
			sandbox.post('/section/restore', {"section": event.data.key});
			$.get('/section/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/section/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
		}		
	};
});