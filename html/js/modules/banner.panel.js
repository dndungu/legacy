core.register('bannerPanel', function(sandbox){
	return {
		init: function(){
			sandbox.item = {};
			sandbox.form = '';
			sandbox.items = [];
			sandbox.listen(['banner.refresh'], this.refresh);
			sandbox.listen(['banner.browse'], this.browse);
			sandbox.listen(['banner.add'], this.form);
			sandbox.listen(['banner.save', 'banner.publish'], this.post);
			sandbox.listen(['banner.edit'], this.edit);
			sandbox.listen(['banner.trash'], this.trash);
			sandbox.listen(['banner.recycle'], this.recycle);
			sandbox.listen(['banner.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/banner/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
			$.get('/banner/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/banner/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
				sandbox.notify('banner.browse');
			});
		},
		browse: function(event){
			var items = [];
			for(i in sandbox.items){
				var item = sandbox.items[i];
				item.title = item.heading;
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
			var data = event.data;
			var published = event.type == 'item.publish' ? {"name": "published", "value": "Yes"} : {"name": "published", "value": "No"};
			data.push(published);
			sandbox.post('/banner/post', data);
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
			sandbox.item.banner = sandbox.item.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea,select').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.item[name]);});}).html(sandbox.form).change();			
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/banner/trash', {"banner": event.data.key});
				sandbox.notify('banner.refresh');
			}
		},
		recycle: function(event){
			$.get('/banner/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});
		},
		restore: function(event){
			$(event.data.element).parent().parent().fadeOut('slow');
			sandbox.post('/banner/restore', {"banner": event.data.key});
			$.get('/banner/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/banner/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
		}		
	};
});