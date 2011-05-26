core.register('setting', function(sandbox){
  return {
    init: function(){
      sandbox.setting = [];
      sandbox.listen(["setting.save"], this.save);
      sandbox.listen(["setting.list.on"], this.print);
      this.activate();
    },
    destroy: function(){
      
    },
    save: function(event){
      var form = {};
      $('#content div[module="setting"] .form').each(function(index, element){
        var name = $(element).attr("name");
        var value = $(element).val();
        form[name] = value;
      });
      var setting = $('#content div[module="setting"][tab="add"] input[name="setting"]').val();
      var action = setting.length ? "edit" : "add";
      sandbox.get("/setting/post.php", {"action": action,"form": form}, function(response){
        sandbox.setting = response;
        $('#tabs a[module="setting"][tab="list"]').mousedown();
        sandbox.notify({"type": "setting.list.on"});
      });
    },
    print: function(){
      var html = "";
      for(i in sandbox.setting){
        var setting = sandbox.setting[i];
        var update_time = new Date(setting.update_time*1000);
        html += '<a href="javascript:return false;" class="row" key="'+setting.ID+'"><span class="eight column">'+setting.setting_notes+'</span><span class="two column">'+update_time.toUTCString()+'</span></a>';
      }
      $('#content div[module="setting"][tab="list"] .rows').html(html).change();
    },
    activate: function(event){
      sandbox.get("/setting/get.php", {"action": "list"}, function(response){
        sandbox.setting = response;
        sandbox.notify({"type": "setting.list.on"});
      });
      $('#content div[module="setting"][tab="add"] input[type="submit"]').unbind("mousedown").mousedown(function(event){
        sandbox.notify({"type": "setting.save"});
      });    
      $('#content div[module="setting"][tab="list"] .rows').unbind("change").change(function(event){
        $('#content div[module="setting"][tab="list"] .rows .row').unbind("mousedown").mousedown(function(event){
          $('#tabs a[module="setting"][tab="add"]').mousedown();
          var settingID = $(this).attr("key");
          var setting = {};
          for(i in sandbox.setting){
            setting = sandbox.setting[i];
            if(setting.ID == settingID){
              break;
            }
          }
          $('#content div[module="setting"] input[name="setting"]').val(settingID);
          $('#content div[module="setting"] .form').each(function(index, element){
            var name = $(element).attr("name");
            if(typeof setting[name] !== "undefined"){
              $('#content div[module="setting"] *[name="'+name+'"]').val(setting[name]);
            }
          });
        });
      });
    }
  };
});