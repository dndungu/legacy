core.register('login', function(sandbox){
	return {
		init: function(){
		},
		destroy: function(){
			
		},
		switchForms: function(){
			$('#login > form > p > a').unbind('mousedown').mousedown(function(event){
				var form = $(this).attr('form').toString();
				var open = $('#login form[status="open"]').attr('id');
				$('#'+open).hide().attr('status', 'closed');
				$('#'+form).fadeIn(1500, 'swing').attr('status', 'open');
				$('#errors, #info').hide();
			});
		}(),
		postForms: function(){
			$('#login input[name="submit"]').unbind('mousedown').mousedown(function(event){
				var post = $(this).attr("post").toString();
				var data = {};
				$('#'+post+' input[type="text"], #'+post+' input[type="password"]').each(function(index, element){
					var expression = 'data.'+sandbox.readElement(element);
					eval(expression);
				});
				$.post('/user/'+post, data, function(response){
					$('#errors, #info').hide();
					if(typeof response.error == 'string'){
						$('#errors').html('<p style="padding-left:10px">'+response.error+'</p>').show();
					}
					if(typeof response.redirect == 'string') {
						window.location.assign(response.redirect);
					}
					if(typeof response.open == 'string'){
						$('#info').html('<p style="padding-left:10px">'+response.info+'</p>').show();
						var form = response.open;
						var open = $('#login form[status="open"]').attr('id');
						$('#'+open).hide().attr('status', 'closed');
						$('#'+form).fadeIn(1500, 'swing').attr('status', 'open');						
					}
				});
			});
		}()
	};
});