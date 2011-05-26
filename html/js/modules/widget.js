core.register('widget', function(sandbox){
	return {
		init: function(){
			sandbox.item = {};
			sandbox.form = '';
			sandbox.items = [];
			sandbox.listen(['widget.refresh'], this.refresh);
			sandbox.listen(['widget.browse'], this.browse);
			sandbox.listen(['widget.add'], this.form);
			sandbox.listen(['widget.save', 'widget.publish'], this.post);
			sandbox.listen(['widget.edit'], this.edit);
			sandbox.listen(['widget.trash'], this.trash);
			sandbox.listen(['widget.recycle'], this.recycle);
			sandbox.listen(['widget.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/widget/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
			$.get('/widget/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/widget/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
				sandbox.notify('widget.browse');
			});
		},
		browse: function(event){
			var rows = sandbox.items.length > 0 ? function(){$('#main').html(sandbox.rows(sandbox.items));return true;}() : false;
			var result = rows ? sandbox.notify('panel.browse') : false;
		},
		form: function(event){
			$('#main').html(sandbox.form);
			sandbox.notify('panel.form');			
		},
		post: function(event){
			var data = event.data;
			var published = event.type == 'item.publish' ? {"name": "published", "value": "Yes"} : {"name": "published", "value": "No"};
			data.push(published);
			sandbox.post('/widget/post', data);
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
			sandbox.item.widget = sandbox.item.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.item[name]);});}).html(sandbox.form).change();			
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/widget/trash', {"widget": event.data.key});
				sandbox.notify('widget.refresh');
			}
		},
		recycle: function(event){
			$.get('/widget/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});
		},
		restore: function(event){
			$(event.data.element).parent().parent().fadeOut('slow');
			sandbox.post('/widget/restore', {"widget": event.data.key});
			$.get('/widget/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/widget/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
		}		
	};
});