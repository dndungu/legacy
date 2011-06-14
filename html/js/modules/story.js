core.register('story', function(sandbox){
	return {
		init: function(){
			this.refresh();
			sandbox.story = {};
			sandbox.form = '';
			sandbox.stories = [];
			sandbox.listen(['story.refresh'], this.refresh);
			sandbox.listen(['story.browse'], this.browse);
			sandbox.listen(['story.add'], this.form);
			sandbox.listen(['story.publish', 'story.save'], this.post);
			sandbox.listen(['story.edit'], this.edit);
			sandbox.listen(['story.trash'], this.trash);
			sandbox.listen(['story.recycle'], this.recycle);
			sandbox.listen(['story.restore'], this.restore);
		},
		destroy: function(){
			
		},
		getList: function(){
			$.get('/story/browse', function(response){
				sandbox.stories = response instanceof Array ? response : [];
			});
		}(),
		getForm: function(){
			$.get('/story/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});			
		}(),
		browse: function(event){
			var rows = sandbox.stories.length > 0 ? $('#main').html(sandbox.rows(sandbox.stories)) : false;
			var result = rows ? sandbox.notify('panel.browse') : false;
		},
		form: function(event){
			$('#main').html(sandbox.form).change();
			sandbox.notify('panel.form');
		},
		refresh: function(event){
			$.get('/story/browse', function(response){
				sandbox.stories = response instanceof Array ? response : [];
				sandbox.notify('story.browse');
			});
		},
		post: function(event){
			var data = event.data;
			var published = event.type == 'story.publish' ? {"name": "published", "value": "Yes"} : {"name": "published", "value": "No"};
			data.push(published);
			sandbox.post('/story/post', data);
		},
		edit: function(event){
			var key = event.data.key;
			sandbox.story = function(){
							for(i in sandbox.stories){
								if(sandbox.stories[i].ID == key){
									return sandbox.stories[i];
								}
							}
						}();
			sandbox.story.story = sandbox.story.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="radio"],#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');if($(element).attr('type') == 'radio' && $(element).attr('value') == sandbox.story[name]){$(element).click();}else{$(element).val(sandbox.story[name]);}});}).html(sandbox.form).change();
		},
		trash: function(event){
			if(confirm('Are you absolutely sure you want to delete this item?')){
				$(event.data.element).parent().parent().fadeOut('slow');
				sandbox.post('/story/trash', {"story": event.data.key});
				sandbox.notify('story.refresh');
			}
		},
		recycle: function(event){
			$.get('/story/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});
		},
		restore: function(event){
			$(event.data.element).parent().parent().fadeOut('slow');
			sandbox.post('/story/restore', {"story": event.data.key});
			$.get('/story/recycle', function(response){
				var garbage = response instanceof Array ? $('#main').html(sandbox.garbage(response)) : false;
				var result = garbage ? sandbox.notify('panel.browse') : false;
			});			
			$.get('/story/browse', function(response){
				sandbox.stories = response instanceof Array ? response : [];
			});
		}
	};
});