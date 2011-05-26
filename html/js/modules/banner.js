core.register("banner", function(sandbox){
	return {
		init: function(){
			sandbox.banners = [];
			sandbox.listen(["banners.ready"], this.switchBanners);
			this.getBanners();
		},
		destroy: function(){
			
		},
		getBanners: function(event){
			$.get("/banner", function(response){
				if(typeof response == "object"){
					sandbox.banners = response;
					sandbox.notify({"type": "banners.ready"});
				}
			});
		},
		switchBanners: function(event){
			var banners = sandbox.banners;
			var i = 0;
			$("#controls ul li").unbind("mousedown").mousedown(function(event){
				var direction = $(this).attr("class").toString();
				i = direction === "next" ? ++i : --i;
				i = i >= banners.length ? 0 : i;
				i = i <= -1 ? 0 : i;
				$("#main .container").fadeOut("fast", "swing", function(){
					$("#controls span").html(banners[i].heading);
					$("#teaser .content h2").html(banners[i].title);
					$("#teaser .content div").html(banners[i].teaser);
					$(this).css({"background":"url("+banners[i].path+") 0 0 scroll no-repeat"}).fadeIn("slow", "swing");
				});				
			});
		}
	};
});