sandbox = function() {
	return {
		listen : function(types, listener) {
			for (i in types) {
				var type = types[i];
				if (typeof sharedlisteners[type] == 'undefined') {
					sharedlisteners[type] = [];
				}
				sharedlisteners[type].push(listener);
			}
		},
		notify : function(event) {
			if (typeof event == 'string') {
				var data = new Object();
				event = {
					type : event,
					data : data
				};
			}
			if (typeof event.data == "undefined") {
				event.data = new Object();
			}
			if (sharedlisteners[event.type] instanceof Array) {
				var listeners = sharedlisteners[event.type];
				var i = listeners.length - 1;
				do {
					if (typeof listeners[i] == 'function') {
						try {
							listeners[i](event);
						} catch (e) {

						}
					}
				} while (i--);
			}
		},
		ignore : function(types, listener) {
			for (k in types) {
				var type = types[k];
				if (sharedlisteners[event.type] instanceof Array) {
					var listeners = sharedlisteners[type];
					var i = listeners.length;
					do {
						if (listener == listeners[i]) {
							listeners[i].splice(i, 1);
							break;
						}
					} while (i--);
				}
			}
		},
		log : function(severity, message) {
			if (debug) {
				if (typeof console == 'object') {
					switch (severity) {
					case 1:
						console.error(message);
						break
					case 2:
						console.warn(message);
						break;
					case 3:
						console.info(message);
						break;
					}
				}
			}
		},
		load : core.load,
		parse : JSON.parse,
		stringify : JSON.stringify,
		base : function(subject, oldBase, newBase) {
			subject = (newBase == 36) ? parseInt(subject) + 123456789012
					: subject;
			subject = subject.toString().toLowerCase();
			var list = "0123456789abcdefghijklmnopqrstuvwxyz";
			var dec = 0;
			for ( var i = 0; i <= subject.length; i++) {
				dec += (list.indexOf(subject.charAt(i)))
						* (Math.pow(oldBase, (subject.length - i - 1)));
			}
			subject = "";
			var magnitude = Math.floor((Math.log(dec)) / (Math.log(newBase)));
			for ( var i = magnitude; i >= 0; i--) {
				var amount = Math.floor(dec / Math.pow(newBase, i));
				subject = subject + list.charAt(amount);
				dec -= amount * (Math.pow(newBase, i));
			}
			subject = (newBase == 10) ? parseInt(subject) - 123456789012
					: subject;
			return subject;
		},
		get : function(script, data, callback) {
			if (script.indexOf('http:') == -1 && script.indexOf('https:') == -1) {
				var url = "/" + script + '?';
			} else {
				if (script.indexOf('?') == -1) {
					var url = script + '?';
				} else {
					var url = script;
				}
			}
			if (arguments.length == 2 && typeof data == "function") {
				callback = data;
			} else {
				var query = $.param(data);
				if (query.length) {
					url += query;
				}
			}
			vubeglobal.tracker++;
			var fn = "vubeglobal.callbacks.fn" + vubeglobal.tracker;
			vubeglobal.listen([ fn ], function(event) {
				if (typeof callback == "function") {
					callback(event.data);
				}
			});
			eval(fn + '=function(response){vubeglobal.notify({"type": "' + fn
					+ '", "data": response});}');
			url += '&callback=' + fn + '&refresh=' + Math.random();
			core.load(url);
		},
		fit : function(input, size) {
			if (typeof size == 'undefined') {
				var size = 120;
			}
			if (input.length < size) {
				return input;
			} else {
				var text = input.substring(0, size);
				var stop = text.lastIndexOf(' ')
				if (stop == -1) {
					stop = size;
				}
				;
				return text.substr(0, stop);
			}
		},
		readElement : function(element) {
			var name = $(element).attr("name").toString();
			var value = $(element).val().toString();
			return name + ' = "' + value + '"'
		},
		rows : function(data) {
			var html = '<div class="list"><div class="add">ADD NEW</div><div class="heading"><span class="column grid_7">Title</span><span class="column grid_2">updated on</span><span class="column grid_1">actions</span></div>';
			var style = 'even';
			for (i in data) {
				var row = data[i];
				var updateTime = new Date(row.updateTime * 1000);
				html += '<div class="row '
						+ style
						+ '"><span class="column grid_7">'
						+ row.ID + '. '
						+ row.title
						+ '</span><span class="column grid_2"><small>'
						+ updateTime.toLocaleString()
						+ '</small></span><span class="column grid_1"><a key="'
						+ row.ID
						+ '" class="edit button"></a><a key="'
						+ row.ID
						+ '" class="trash button" title="delete"></a></span></div>';
				style = style == 'odd' ? 'even' : 'odd';
			}
			html += '</div>';
			return html;
		},
		garbage : function(data) {
			var html = '<div class="list"><div class="heading"><span class="column grid_7">Title</span><span class="column grid_2">updated on</span><span class="column grid_1">actions</span></div>';
			var style = 'even';
			for (i in data) {
				var row = data[i];
				var updateTime = new Date(row.updateTime * 1000);
				html += '<div class="row '
						+ style
						+ '"><span class="column grid_7">'
						+ row.title
						+ '</span><span class="column grid_2"><small>'
						+ updateTime.toLocaleString()
						+ '</small></span><span class="column grid_1"><a key="'
						+ row.ID
						+ '" class="restore button" title="restore"></a></span></div>';
				style = style == 'odd' ? 'even' : 'odd';
			}
			html += '</div>';
			return html;
		},
		post : function(url, data) {
			var that = this;
			$.post(url, data, function(response) {
				if (typeof response.redirect == "string") {
					that.notify({
						"type" : response.redirect
					});
				}
				if (typeof response.error == "string") {
					that.log(2, response.error);
				}
			});
		}
	};
};