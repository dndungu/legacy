core.register('aspect', function(sandbox){
	return {
		init: function(){
			sandbox.item = {};
			sandbox.form = '';
			sandbox.items = [];
			sandbox.listen(['aspect.refresh'], this.refresh);
			sandbox.listen(['aspect.browse'], this.browse);
			sandbox.listen(['aspect.add'], this.form);
			sandbox.listen(['aspect.save'], this.post);
			sandbox.listen(['aspect.edit'], this.edit);
			sandbox.listen(['aspect.trash'], this.trash);
			sandbox.listen(['aspect.recycle'], this.recycle);
			sandbox.listen(['aspect.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/aspect/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
			$.get('/aspect/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/aspect/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
				sandbox.notify('aspect.browse');
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
			sandbox.post('/aspect/post', event.data);
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
			sandbox.item.aspect = sandbox.item.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.item[name]);});}).html(sandbox.form).change();			
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/aspect/trash', {"aspect": event.data.key});
				sandbox.notify('aspect.refresh');
			}
		},
		recycle: function(event){
			$.get('/aspect/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});
		},
		restore: function(event){
			$(event.data.element).parent().parent().fadeOut('slow');
			sandbox.post('/aspect/restore', {"aspect": event.data.key});
			$.get('/aspect/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/aspect/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
		}		
	};
});