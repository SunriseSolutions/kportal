var moduleList = [];
function ajaxCourse(uri) {
	var courseNavURL = uri;// + '&qstarti=' + qstarti;
	var params = null;
	loadingHtml = ' <div id="courseLoading" style="font-size:16px; background-color:white; layer-background-color:white; height:100%; width:100%;"><TABLE width=100% height=100% align="center" valign="center"><TR valign="center"><TD align="center">  Chờ xíu nhé...  <br/><img src="'
			+ sroot
			+ 'media/sunrise/images/ajax-loader.gif" /> </TD></TR></TABLE></div>';
	courselayout.children().last().replaceWith(loadingHtml);
	var ajaxLayout = courselayout;
	srAjax(uri, courselayout, ajaxCourseCallBack, false, params);

}

function ajaxCourseCallBack(result, uri, ajaxLayout, params) {
	// alert(result);
	// var qstarti = params[0];
	var jsonObj = JSON.parse(result);
	var ajaxArray = mapObjToArray(jsonObj);
	var sectionArray = mapObjToArray(ajaxArray[1])
	var ajaxHtml;
	var ajaxLength = ajaxArray.length;

	// qstarti += ajaxLength;

	if (ajaxLength > 0) {

		ajaxHtml = "<div>";
		// ajaxLayout.children().last().replaceWith(ajaxHtml);

		ajaxHtml += '<ul class="nav nav-tabs" data-srtablevel="1">';
		var sectionName;
		var section;
		for (var i = 0; i < sectionArray.length; i++) {
			section = sectionArray[i];

			if (section.name == null) {
				sectionName = 'Section ' + section.id;
			} else {
				sectionName = section.name;
			}
			ajaxHtml += '<li class="' + ((i == 0) ? 'active' : '') + '">';
			ajaxHtml += '<a href="#' + section.id
					+ '" data-original-title="" title="">' + sectionName
					+ '</a>';
			ajaxHtml += '</li>';
		}
		ajaxHtml += '</ul>';
		ajaxHtml += '<div class="tab-content">';
		for (var i = 0; i < sectionArray.length; i++) {
			section = sectionArray[i];

			if (section.name == null) {
				sectionName = 'Section ' + section.id;
			} else {
				sectionName = section.name;
			}
			ajaxHtml += '<div id="' + section.id + '" class="tab-pane '
					+ ((i == 0) ? 'active' : '') + '">';

			if (section.hasOwnProperty('_modules')) {
				var _moduleArray = mapObjToArray(section._modules);
				ajaxHtml += '<ul class="nav nav-list">';

				for (var j = 0; j < _moduleArray.length; j++) {
					ajaxHtml += '<li>';
					var moduleItem = _moduleArray[j];
					var instance = moduleItem._instance;
					ajaxHtml += '<i class="icon-file"></i> <strong> <a class="course-module text-info" data-name="'
							+ moduleItem.name
							+ '" href="'
							+ (uri + '&view=module&moduleid=' + moduleItem.id)
							+ '">';
					ajaxHtml += '' + instance.name + '';
					ajaxHtml += '</a></strong>';
					ajaxHtml += '</li>';
				}
				ajaxHtml += '</ul>';

			}

			ajaxHtml += '</div>';
		}
		ajaxHtml += '</div>';
		// dump(instanceArray[0]);
		// dump(mapObjToArray(instanceArray[0]));
		// dump(mapObjToArray(instanceArray[0])[0]);
		// dump(instanceArray[1]);
		// dump(mapObjToArray(instanceArray[1]));
		// dump(instanceArray[2]);
		// dump(mapObjToArray(instanceArray[2]));
		// dump(instanceArray[3]);
		// dump(mapObjToArray(instanceArray[3]));
		// dump(instanceArray[4]);
		// dump(mapObjToArray(instanceArray[4]));
		// dump(instanceArray[5]);
		// dump(mapObjToArray(instanceArray[5]));
		// ajaxHtml += '<div id="profile"
		// class="tab-pane">..Profile level 1.';
		// ajaxHtml += '<ul id="backupsr_tab2" class="nav
		// nav-tabs" data-srtablevel="2">';
		// ajaxHtml += '<li class="active"><a href="#home-SUB"
		// data-original-title="" title="">Home</a></li>';
		// ajaxHtml += '<li class=""><a href="#profileSUB"
		// data-original-title="" title="">Profile</a></li>';
		// ajaxHtml += '<li class=""><a href="#messagesSUB"
		// data-original-title="" title="">Messages</a></li>';
		// ajaxHtml += '<li class=""><a href="#settingsSUB"
		// data-original-title="" title="">Settings</a></li>';
		// ajaxHtml += '</ul>';
		// ajaxHtml += '<div class="tab-content">';
		// ajaxHtml += '<div id="home-SUB" class="tab-pane
		// active">.Home level 2..jump to <a class="srtab-jump"
		// href="#profile/messagesSUB/profileGRANDCHILD"
		// data-original-title=""
		// title="">profile/messagesSUB/profileGRANDCHILD</a></div>';
		// ajaxHtml += '<div id="profileSUB"
		// class="tab-pane">..Profile 2.</div>';
		// ajaxHtml += '<div id="messagesSUB"
		// class="tab-pane">.Messages Level 2..';
		// ajaxHtml += '<ul id="backupsr_tab3" class="nav
		// nav-tabs" data-srtablevel="3">';
		// ajaxHtml += '<li class=""><a href="#homeGRANDCHILD"
		// data-original-title="" title="">Home</a></li>';
		// ajaxHtml += '<li class=""><a
		// href="#profileGRANDCHILD" data-original-title=""
		// title="">Profile</a></li>';
		// ajaxHtml += '<li class=""><a
		// href="#messagesGRANDCHILD" data-original-title=""
		// title="">Messages</a></li>';
		// ajaxHtml += '<li class="active"><a
		// href="#settingsGRANDCHILD" data-original-title=""
		// title="">Settings</a></li>';
		// ajaxHtml += '</ul>';
		// ajaxHtml += '<div class="tab-content">';
		// ajaxHtml += '<div id="homeGRANDCHILD"
		// class="tab-pane">.HOME LEVEL 3..</div>';
		// ajaxHtml += '<div id="profileGRANDCHILD"
		// class="tab-pane">..Profile LEVEL 3.</div>';
		// ajaxHtml += '<div id="messagesGRANDCHILD"
		// class="tab-pane">.Messages .LEVEL 3.</div>';
		// ajaxHtml += '<div id="settingsGRANDCHILD"
		// class="tab-pane active">.Settings.LEVEL 3.</div>';
		// ajaxHtml += '</div>';

		// ajaxHtml += '<div id="settingsSUB"
		// class="tab-pane">..SettingSUB 2.</div>';
		// ajaxHtml += '</div>';
		// ajaxHtml += '</div>';
		// ajaxHtml += '<div id="messages"
		// class="tab-pane">.Messages level 1..</div>';
		// ajaxHtml += '<div id="settings"
		// class="tab-pane">Settings level 1...</div>';
		ajaxHtml += '</div></div>';

		ajaxLayout.children().last().replaceWith(ajaxHtml);
		initialiseTabs();
		selectTabsFromHash(window.location.hash);

		jQuery('.course-module').click(
				function(e) {
					e.preventDefault();
					var $ = jQuery;
					var destination_url = jQuery(this).attr('href');
					var methodName = $(this).data('name');
					if(moduleList.hasOwnProperty(methodName)){
						window['ajaxModule' + methodName.charAt(0).toUpperCase() + methodName.slice(1)](destination_url, uri);					    
					}else{
						moduleList[methodName]=1;
						jQuery.getScript(sroot
								+ '/media/sunrise/js/course-modules/'
								+ methodName  + '.js', function() {
							window['ajaxModule' + methodName.charAt(0).toUpperCase() + methodName.slice(1)](destination_url, uri);

						});
					}
					
					// ajaxQuiz($, qlistURI, qstarti, type);

					// alert('loading ok');

				});

		return null;
		ajaxHtml = '<div class="srquestions srquiz sunrise_form_wrapper modal-body">';
		// ajaxHtml += '<span class="icon
		// icon-information">&nbsp;</span>';
		// ajaxHtml += '<div
		// class="alert">';
		// ajaxHtml += 'Using the words in
		// parentheses, complete the text
		// below with the appropriate
		// tenses, then click the "Check"
		// button to check your answers.';
		// ajaxHtml += '</div>';
		ajaxHtml += '<table>';
		var _matchArr = [];
		var _mai = 0;
		// ////////// FIRST COLUMN ////////
		ajaxHtml += '<tr><td style="vertical-align:top">';
		ajaxHtml += '<ol start="' + '">';
		for (i = 0; i < splitIndex; i++) {
			var question = qlist[i];
			ajaxHtml += '<li>';
			ajaxHtml += generateQuestionHtml(qlist[i]);
			ajaxHtml += '</li>';
			if (qlist[i].qtype == "match") {
				_matchArr[_mai] = qlist[i].id;
				_mai++;
			}
		}
		if (qlistLength > 1) {
			ajaxHtml += '</ol>';
			ajaxHtml += '</td>';

			// ////////// SECOND COLUMN ////////
			ajaxHtml += '<td width="50%" style="vertical-align:top">';
			ajaxHtml += '<ol start="'
					+ (qstarti - qlistLength + 1 + splitIndex) + '">';
			// ajaxHtml += '<tr><td>';
			for (i = splitIndex; i < qlistLength; i++) {
				var question = qlist[i];
				ajaxHtml += '<li>';
				ajaxHtml += generateQuestionHtml(qlist[i]);
				if (qlist[i].qtype == "match") {
					_matchArr[_mai] = qlist[i].id;
					_mai++;
				}
				ajaxHtml += '</li>';
			}
			// ajaxHtml += '</td></tr>';
			ajaxHtml += '<p><a class="quizNext btn btn-primary" href="'
					+ courseNavURL + '">Tiếp theo</a> ';
			ajaxHtml += '<button class="btn" data-dismiss="modal" aria-hidden="true">Đóng lại</button>';
			ajaxHtml += '</p>';
			ajaxHtml += '</ol>';
			ajaxHtml += '</td></tr>';
			ajaxHtml += '</table>';
			ajaxHtml += '</div>';

			// jQuery(ajaxHtml, {}).appendTo(ajaxLayout);
			ajaxLayout.children().last().replaceWith(ajaxHtml);
			addQuizEvents(jQuery);
			for (_maix = 0; _maix < _mai; _maix++) {
				jQuery('span.shuffle-match' + _matchArr[_maix]).shuffle();
			}

			// jQuery('<div>' + result + '</div>', {}).appendTo(
			// ajaxLayout);

		} else { // if only 1 column
			ajaxHtml += '<p><a class="quizNext btn btn-primary" href="'
					+ quizNavURL + '">Tiếp theo</a> ';
			ajaxHtml += '<button class="btn" data-dismiss="modal" aria-hidden="true">Đóng lại</button>';
			ajaxHtml += '</p>';
			ajaxHtml += '</ol>';
			ajaxHtml += '</tr>';
			ajaxHtml += '</table>';
			// ajaxHtml += '<div>' + result + '</div>';
			ajaxHtml += '</div>';
			// jQuery(, {}).appendTo(
			// ajaxLayout);
			// jQuery(ajaxHtml, {}).appendTo(ajaxLayout);
			ajaxLayout.children().last().replaceWith(ajaxHtml);

			addQuizEvents(jQuery);
			for (_maix = 0; _maix < _mai; _maix++) {
				jQuery('span.shuffle-match' + _matchArr[_maix]).shuffle();
			}

		}
	} else {
		ajaxHtml = '<h1>Bạn đã hoàn tất câu hỏi của ngày hôm nay ';
		// jQuery(ajaxHtml, {}).appendTo(ajaxLayout);
		ajaxHtml += '<button class="btn" data-dismiss="modal" aria-hidden="true">Đóng lại</button>';
		ajaxHtml += '</h1>';
		ajaxLayout.children().last().replaceWith(ajaxHtml);

	}

	//
	// ajaxLayout.chidren().last().show();
}
