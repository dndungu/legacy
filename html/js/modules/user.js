core.register('page', function(sandbox){
	return {
		init: function(){
			sandbox.pages = [];
		},
		destroy: function(){
			
		},
		browse: function(){
			$.get('/page/browse', function(response){
				sandbox.pages = response instanceof Array ? response : [];
			});
		}()
	};
});