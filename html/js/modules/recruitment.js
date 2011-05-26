core.register('recruitment', function(sandbox){
	return {
		init: function(){
			sandbox.education = [];
			sandbox.experience = [];
			sandbox.technologies = [];
			sandbox.experienceID = 0;
			this.editEducation();
			this.trashEducation();
			this.editExperience();
			this.trashExperience();
			this.getEducation();
			this.getExperience();
			sandbox.listen(['education.added', 'experience.added'], this.post);
			sandbox.listen(['education.added'], this.printEducation);
			sandbox.listen(['experience.added', 'experience.print'], this.printExperience);
			sandbox.listen(['technology.added', 'technologies.print'], this.printTechnology);
			sandbox.listen(['education.refresh'], this.getEducation);
			sandbox.listen(['experience.refresh'], this.getExperience);
		},
		destroy: function(){
			
		},
		navigate: function(){
			$('#recruitment h2').unbind('mousedown').mousedown(function(event){
				var form = $(this).attr("form");
				var status = $('#'+form).attr('status');
				$('#recruitment form[status="open"]').fadeOut('fast', 'swing').attr('status','closed');
				$('#recruitment h2.open').removeClass('open');
				if(status === 'closed'){
					$(this).addClass('open');
					$('#'+form).fadeIn('slow', 'swing').attr('status', 'open');					
				}
			});
			$('#recruitment input[type="reset"]').unbind("click").click(function(event){
				var module = $(this).attr('module');
				$('#recruitment h2[form="'+module+'"]').mousedown();
			});
			$('#nextPersonal').unbind('mousedown').mousedown(function(){
				$('#recruitment h2[form="education"]').mousedown();
			});
			$('#nextEducation').unbind('mousedown').mousedown(function(){
				$('#recruitment h2[form="experience"]').mousedown();
			});
			$('#previousExperience').unbind('mousedown').mousedown(function(){
				$('#recruitment h2[form="education"]').mousedown();
			});
		}(),
		getEducation: function(){
			$.get('/education', function(response){
				sandbox.education = response instanceof Array ? response : sandbox.education;
			});
		},
		getExperience: function(){
			$.get('/experience', function(response){
				sandbox.experience = response instanceof Array ? response : sandbox.experience;
			});
		},
		savePersonal: function(){
			$('#savePersonal').unbind("mousedown").mousedown(function(){
				var personal = {};
				$('#personal input[type="text"], #personal input[type="radio"], #personal input[type="checkbox"], #personal textarea').each(function(index, element){
					var expression = 'personal.'+sandbox.readElement(element);
					eval(expression);
				});
				$.post('/user/post', personal);
				$('#recruitment h2[form="personal"]').mousedown();
				$('#recruitment h2[form="education"]').mousedown();
			});
		}(),
		saveEducation: function(){
			$('#addEducation').unbind('mousedown').mousedown(function(event){
				var education = {};
				$('#education input[type="text"], #education input[type="text"], #education textarea, #education select').each(function(index, element){
					var expression = 'education.'+sandbox.readElement(element);
					eval(expression);
				});
				if(education.education > 0){
					for(i in sandbox.education){
						if(education.education == sandbox.education[i].ID){
							sandbox.education[i] = education;
						}
					}
				} else {
					sandbox.education.push(education);
				}
				$(this).next().click();
				sandbox.notify({"type": "education.added", "data": {"url": "/education/post", "data": education}});
			});
		}(),
		editEducation: function(event){
			$('#printEducation a[edit="education"]').unbind('click').click(function(event){
				var ID = $(this).attr("education");
				var education = function(ID){
					for(i in sandbox.education){
						var education = sandbox.education[i];
						if(education.ID == ID){
							sandbox.education.splice(i, 1);
							return education;
						}
					}
					return {};
				}(ID);
				sandbox.notify('education.print');
				education.education = education.ID ? education.ID : 0;
				$('#education input[type="hidden"], #education input[type="text"], #education textarea').each(function(index, element){
					for(i in education){
						if(i === $(element).attr('name')){
							$(element).val(education[i])
						}
					}
				});
				$('#addEducation').val('UPDATE');
				if($("#education").attr('status') === "closed"){
					$('#recruitment p.add[form="education"]').mousedown();
				}
				event.preventDefault();
			});
		},
		trashEducation: function(event){
			$('#printEducation a[trash="education"]').unbind('mousedown').mousedown(function(event){
				if(confirm("Are you sure you want to delete this item.")){
					$.post('/education/trash', {"education": $(this).attr("education")});
				}
			});
		},		
		post: function(event){
			$.post(event.data.url, event.data.data, function(response){
				sandbox.notify('technologies.refresh');
				$('#errors, #info').hide();
				if(typeof response.error == "string"){
					$('#errors').html('<p style="padding-left:10px">'+response.error+'</p>').show();
				}
				if(typeof response.info == "string"){
					$('#info').html('<p style="padding-left:10px">'+response.info+'</p>').show();
				}
				if(typeof response.redirect == "string"){
					window.location.assign(response.redirect);
				}
			})
		},
		printEducation: function(event){
			var html = '';
			for(i in sandbox.education){
				var education = sandbox.education[i];
				html += '<p>';
				html += '<strong class="nomargin grid_8">' + $('#certification option[value="'+education.certification+'"]').text().toString() + ' ' + education.program + ' - ' + education.institution + '</strong><em class="nomargin grid_4">' + education.start + ' - ' + education.completion + '</em>';
				html += '<span class="nomargin grid_10">' + education.notes + '</span><em class="nomargin grid_2">[ <a education="{'+education.ID+'}" class="edit" edit="education">edit</a> ] [ <a education="{'+education.ID+'}" class="trash" trash="education">delete</a> ]</em>';
				html += '</p>';
			}
			$('#printEducation').html(html);
		},
		addTechnology: function(){
			$("#addTechnology").unbind("mousedown").mousedown(function(event){
				var ID = $('#technology').val();
				var add = true;
				for(i in sandbox.technologies){
					if(sandbox.technologies[i].ID === ID){
						add = false;
					}
				}
				if(add){
					var fullname = $("#technology > option[value='"+ID+"']").text();
					sandbox.technologies.push({"ID": 0, "technology": ID, "fullname": fullname, "experience": sandbox.experienceID});
					sandbox.notify("technology.added");
				}
			});			
		}(),
		printTechnology: function(event){
			var html = '';
			var technologies = sandbox.technologies;
			for(i in technologies){
				var technology = technologies[i];
				var spacer = i == technologies.length ? "" : ", ";
				html += '<a key="'+i+'" value="'+technology.ID+'" title="click to remove">'+technology.fullname+spacer+'</a>';
			}
			$('#technologies').html(html).children('a').unbind('click').click(function(event){
				$.post('/recruitment/trashtechnology', {"experience_technology": $(this).attr('value')});
				$(this).fadeOut('slow','swing');
			});			
		},
		addExperience: function(){
			sandbox.technologiesLabel = $('#technologies').html();
			$('#addExperience').unbind("mousedown").mousedown(function(event){
				$('#technologies').html(sandbox.technologiesLabel);
				var experience = {};
				$("#experience input[type='hidden'], #experience input[type='text'], #experience textarea").each(function(index, element){
					var expression = sandbox.readElement(element);
					var expression = 'experience.'+expression;
					eval(expression);						
				});
				experience.technologies = sandbox.technologies;
				if(experience.experience > 0){
					for(i in sandbox.experience){
						if(experience.experience == sandbox.experience[i].ID){
							sandbox.experience[i] = experience;
						}
					}
				} else {
					sandbox.experience.push(experience);
				}				
				$(this).next().click();
				sandbox.notify({"type": "experience.added", "data": {"url": "/experience/post", "data": experience}});
			});
		}(),
		printExperience: function(event){
			var html = '';
			for(i in sandbox.experience){
				var experience = sandbox.experience[i];
				html += '<p>';
				html += '<strong class="nomargin grid_8">' + experience.role + ' - ' + experience.organisation + '</strong><em class="nomargin grid_4">' + experience.start + ' - ' + experience.completion + '</em>';
				html += '<span class="nomargin grid_10">'+function (){var text = '';for(j in experience.technologies){var technology = experience.technologies[i];text += technology.fullname;}return text;}()+'</span>';
				html += '<em class="nomargin grid_2">[ <a experience="{'+experience.ID+'}" class="edit" edit="experience">edit</a> ] [ <a experience="{'+experience.ID+'}" class="trash" trash="experience">delete</a> ]</em>';
				html += '<span class="nomargin grid_12">' + experience.notes + '</span>';
				html += '</p>';
			}
			$("#printExperience").html(html);
			sandbox.technologies = [];
		},
		editExperience: function(event){
			$('#printExperience a[edit="experience"]').unbind('mousedown').mousedown(function(event){
				var ID = $(this).attr("experience");
				sandbox.experienceID = ID;
				var experience = function(ID){
					for(i in sandbox.experience){
						var experience = sandbox.experience[i];
						if(experience.ID == ID){
							sandbox.technologies = sandbox.experience[i].technologies;
							sandbox.notify('technologies.print');
							sandbox.experience.splice(i, 1);
							return experience;
						}
					}
					return {};
				}(ID);
				experience.experience = experience.ID ? experience.ID : 0;
				$('#experience input[type="hidden"], #experience input[type="text"], #experience textarea').each(function(index, element){
					for(i in experience){
						if(i === $(element).attr('name')){
							$(element).val(experience[i])
						}
					}
				});
				if($("#experience").attr('status') === "closed"){
					$('#recruitment p.add[form="experience"]').mousedown();
				}
				$('#addExperience').val('UPDATE');
			});
		},
		trashExperience: function(event){
			$('#printExperience a[trash="experience"]').unbind('mousedown').mousedown(function(event){
				if(confirm("Are you sure you want to delete this item.")){
					$.post('/experience/trash', {"experience": $(this).attr("experience")});
				}
			});
		}
	};
});