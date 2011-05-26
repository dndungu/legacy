var sharedlisteners = new Array();
var debug = true;
core = function(){
  var moduleData = {};
  return {
    register: function (moduleId, creator){
      moduleData[moduleId] = {
        creator: creator,
        instance: null
      }
    },
    start: function(moduleId){
      var module = moduleData[moduleId];
      module.instance = module.creator(new sandbox(module.creator));
      try {
        module.instance.init();
      } catch(e){
        
      }
    },
    stop: function(moduleId){
      var data = moduleData[moduleId];
      if(data.instance){
        data.instance.kill();
        data.instance = null;
      }
    },
    boot: function(){
      for (moduleId in moduleData){
        if(moduleData.hasOwnProperty(moduleId)){
          this.start(moduleId);
        }
      }
    },
    halt: function(){
     for(var moduleId in moduleData){
       if(moduleData.hasOwnProperty(moduleId)){
         this.stop(moduleId);
       }
     } 
    },
    load: function(url, callback){
      var script = document.createElement("script");
      if(typeof callback == 'function'){
        if (script.readyState) {
          script.onreadystatechange = function(){
            if(script.readyState == "loaded" || script.readyState == "complete"){
              script.onreadystatechange = null;
              callback();
            }
          };        
        } else {
          script.onload = function(){
              callback();
          };        
        }        
      }
      script.type = 'text/javascript';
      script.async = true;
      script.src = url;
      var scripts = document.getElementsByTagName('script');
      var lastScript = scripts[0];
      lastScript.parentNode.insertBefore(script, lastScript);
    }
  }
}();