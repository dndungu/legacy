core.register('page', function(sandbox){
	return {
		init: function(){
			sandbox.page = {};
			sandbox.form = '';
			sandbox.pages = [];
			sandbox.listen(['page.refresh'], this.refresh);
			sandbox.listen(['page.browse'], this.browse);
			sandbox.listen(['page.add'], this.form);
			sandbox.listen(['page.publish', 'page.save'], this.post);
			sandbox.listen(['page.edit'], this.edit);
			sandbox.listen(['page.trash'], this.trash);
			sandbox.listen(['page.recycle'], this.recycle);
			sandbox.listen(['page.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/page/browse', function(response){
				sandbox.pages = response instanceof Array ? response : [];
			});
			$.get('/page/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/page/browse', function(response){
				sandbox.pages = response instanceof Array ? response : [];
				sandbox.notify('page.browse');
			});
		},
		browse: function(event){
			var rows = sandbox.pages.length > 0 ? function(){$('#main').html(sandbox.rows(sandbox.pages));return true;}() : false;
			var result = rows ? sandbox.notify('panel.browse') : false;
		},
		form: function(event){
			$('#main').html(sandbox.form);
			sandbox.notify('panel.form');			
		},
		post: function(event){
			var data = event.data;
			var published = event.type == 'page.publish' ? {"name": "published", "value": "Yes"} : {"name": "published", "value": "No"};
			data.push(published);
			sandbox.post('/page/post', data);
		},		
		edit: function(event){
			var key = event.data.key;
			sandbox.page = function(){
							for(i in sandbox.pages){
								if(sandbox.pages[i].ID == key){
										return sandbox.pages[i];
								}
							}
						}();
			sandbox.page.page = sandbox.page.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.page[name]);});}).html(sandbox.form).change();			
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/page/trash', {"page": event.data.key});
				sandbox.notify('page.refresh');
			}
		},
		recycle: function(event){
			$.get('/page/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});
		},
		restore: function(event){
			$(event.data.element).parent().parent().fadeOut('slow');
			sandbox.post('/page/restore', {"page": event.data.key});
			$.get('/page/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/page/browse', function(response){
				sandbox.pages = response instanceof Array ? response : [];
			});
		}		
	};
});