core.register('technologyPanel', function(sandbox){
	return {
		init: function(){
			sandbox.item = {};
			sandbox.form = '';
			sandbox.items = [];
			sandbox.count = 0;
			sandbox.listen(['technology.refresh'], this.refresh);
			sandbox.listen(['technology.browse'], this.browse);
			sandbox.listen(['technology.add'], this.form);
			sandbox.listen(['technology.save'], this.post);
			sandbox.listen(['technology.edit'], this.edit);
			sandbox.listen(['technology.trash'], this.trash);
			sandbox.listen(['technology.recycle'], this.recycle);
			sandbox.listen(['technology.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/technology/browse', function(response){
				sandbox.items = typeof response.rows == 'object' && response.rows instanceof Array ? response.rows : [];
				sandbox.count = sandbox.rows.length ? Number(response.count) : 0;
			});
			$.get('/technology/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/technology/browse', function(response){
				sandbox.items = typeof response.rows == 'object' && response.rows instanceof Array ? response.rows : [];
				sandbox.count = sandbox.rows.length ? Number(response.count) : 0;
				sandbox.notify('technology.browse');
			});
		},
		browse: function(event){
			var items = [];
			for(i in sandbox.items){
				var item = sandbox.items[i];
				item.title = item.fullname;
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
			sandbox.post('/technology/post', event.data);
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
			sandbox.item.technology = sandbox.item.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.item[name]);});}).html(sandbox.form).change();			
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/technology/trash', {"technology": event.data.key});
				sandbox.notify('technology.refresh');
			}
		},
		recycle: function(event){
			$.get('/technology/recycle', function(response){
				function adjust(response){
					var items = [];
					for(i in response){
						var item = response[i];
						item.title = item.fullname;
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
			sandbox.post('/technology/restore', {"technology": event.data.key});
			$.get('/technology/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/technology/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
		}		
	};
});