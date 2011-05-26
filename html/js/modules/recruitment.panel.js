core.register('recruitment', function(sandbox){
	return {
		init: function(){
			sandbox.page = 1;
			sandbox.pages = 0;
			sandbox.item = {};
			sandbox.items = [];
			sandbox.listen(['recruitment.refresh'], this.refresh);
			sandbox.listen(['recruitment.browse'], this.browse);
			sandbox.listen(['recruitment.search'], this.search);
		},
		destroy: function(){
			
		},
		load: function(){
			$.get('/recruitment/browse', function(response){
				sandbox.items = response.users instanceof Array ? response.users : [];
				sandbox.pages = response.pages ? response.pages : 0;
			});
		}(),
		refresh: function(event){
			$.get('/recruitment/browse', function(response){
				sandbox.items = response instanceof Array ? response : [];
				sandbox.notify('recruitment.browse');
			});
		},
		browse: function(event){
			var html = '<div class="list"><div class="heading"><span class="column grid_4">applicant\'s name</span><span class="column grid_2">Email</span><span class="column grid_2">Phone</span><span class="column grid_2">updated on</span></div>';
			var style = 'even';
			for (i in sandbox.items) {
				var row = sandbox.items[i];
				var updateTime = new Date(row.updateTime * 1000);
				html += '<div class="row '
						+ style
						+ '"><span class="column grid_4"><input type="checkbox" user="'+row.ID+'"/> '+row.firstName+' '+row.lastName+'</span>'
						+ '<span class="column grid_2">'+row.email+'</span>'
						+ '<span class="column grid_2">'+row.phone+'</span>'
						+ '<span class="column grid_2"><small>'
						+ updateTime.toLocaleString()
						+ '</small></span></div>';
				style = style == 'odd' ? 'even' : 'odd';
			}
			html += '</div><div class="nomargin grid_10"><a class="export">export</a></div>';
			var rows = sandbox.items.length > 0 ? function(){$('#main').html(html).find('.export').unbind('mousedown').mousedown(function(){
				var users = [];
				$('#main input[type="checkbox"]').each(function(index,element){
					if(element.checked){
						users.push({"user": $(element).attr("user")});
					}
				});
				if(users.length){
					var html = '<form action="/recruitment/exporttoexcel" method="post">';
					for(i in users){
						html += '<input type="text" name="users[]" value="'+users[i].user+'"/>';
					}
					html += '</form>';
					$(html).appendTo('body').submit().remove();
				}
			});return true;}() : false;
		},
		search: function(event){
			$.post('/recruitment/search', {"keywords": event.data}, function(response){
				sandbox.items = response instanceof Array ? response : [];
				return sandbox.items.length ? sandbox.notify('recruitment.browse') : $('#main').html('<div class="list"><span class="column grid_10">No applications found.</span></div>');
			});
		},
	};
});