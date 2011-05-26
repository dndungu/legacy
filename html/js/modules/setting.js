core.register('setting', function(sandbox){
	return {
		init: function(){
			sandbox.item = {};
			sandbox.form = '';
			sandbox.items = [];
			sandbox.listen(['setting.refresh'], this.refresh);
			sandbox.listen(['setting.browse'], this.browse);
			sandbox.listen(['setting.add'], this.form);
			sandbox.listen(['setting.save', 'setting.publish'], this.post);
			sandbox.listen(['setting.edit'], this.edit);
			sandbox.listen(['setting.trash'], this.trash);
			sandbox.listen(['setting.recycle'], this.recycle);
			sandbox.listen(['setting.restore'], this.restore);			
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/setting/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
			});
			$.get('/setting/form', function(response){
				sandbox.form = typeof response === 'string' ? response : '';
			});
		}(),
		refresh: function(event){
			$.get('/setting/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
				sandbox.notify('setting.browse');
			});
		},
		browse: function(event){
			var html = '<div class="list"><div class="heading"><span class="column grid_1">Setting</span><span class="column grid_6">Value</span><span class="column grid_2">updated on</span><span class="column grid_1">actions</span></div>';
			var style = 'even';
			for (i in sandbox.items) {
				var row = sandbox.items[i];
				var updateTime = new Date(row.updateTime * 1000);
				html += '<div class="row '
						+ style
						+ '"><span class="column grid_1">'+row.key+'</span><span class="column grid_6">'
						+ row.value
						+ '</span><span class="column grid_2"><small>'
						+ updateTime.toLocaleString()
						+ '</small></span><span class="column grid_1"><a key="'
						+ row.ID
						+ '" class="edit button"></a>'
						+ '</span></div>';
				style = style == 'odd' ? 'even' : 'odd';
			}
			html += '</div>';			
			var rows = sandbox.items.length > 0 ? function(){$('#main').html(html);return true;}() : false;
			var result = rows ? sandbox.notify('panel.browse') : false;
		},
		form: function(event){
			$('#main').html(sandbox.form);
			sandbox.notify('panel.form');			
		},
		post: function(event){
			sandbox.post('/setting/post', event.data);
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
			sandbox.item.setting = sandbox.item.ID;
			$('#main').unbind('change').change(function(event){$(this).unbind('change');sandbox.notify('panel.form');$('#main form input[type="text"],#main form input[type="hidden"],textarea').each(function(index,element){var name=$(element).attr('name');$(element).val(sandbox.item[name]);});}).html(sandbox.form).change();			
		}
	};
});