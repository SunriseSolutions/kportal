var SText = {
	auto : "Auto play",
	click : "Click to play",
	button : "Interaction",
	please_log_in : "Vui lòng đăng nhập",
	continue_lesson_msg : "Bạn muốn tiếp tục hay học lại từ đầu ?",
	continue_lesson_btn : "Tiếp tục bài đang học",
	start_lesson_again_btn : "Học lại từ đầu",
	view_submission : "Xem bài đã nộp",
	edit_submission : "Sửa bài làm",
	add_submission : "Nộp bài viết",
	feedback : "Phản hồi của giáo viên",
	view_feedback : "Xem đánh giá của giáo viên",
	graded : "Đã chấm điểm rồi nhé :-D",
	grade : "Điểm số",
	submission_status : "Bài nộp",
	grading_status : "Chấm bài",
	no_attempt : "Đã nộp bài",
	no_attempt : "Bạn chưa có nộp bài nhé ;)",
	not_graded : "Giáo viên chưa chấm bài",
	submitted : "Đã nộp bài",
	eyecolor : "blue"
};
var checkOnChange = false;
var hintOnChange = false;

function ajaxModuleLesson(uri, backurl) {
	var ajaxNavURL = uri;// + '&qstarti=' + qstarti;
	var params = {
		backurl : backurl
	};
	loadingHtml = ' <div id="courseLoading" style="font-size:16px; background-color:white; layer-background-color:white; height:100%; width:100%;"><TABLE width=100% height=100% align="center" valign="center"><TR valign="center"><TD align="center">  Chờ xíu nhé...  <br/><img src="'
			+ sroot
			+ 'media/sunrise/images/ajax-loader.gif" /> </TD></TR></TABLE></div>';
	courselayout.children().last().replaceWith(loadingHtml);
	srAjax(ajaxNavURL, courselayout, ajaxModuleLessonCallBack, params);

}

function ajaxModuleLessonCallBack(result, uri, ajaxLayout, params) {
	var lesson = mapObjToArray(JSON.parse(result));
	slideList = lesson;
	var currentPage;
	var firstPage;
	var lastPage;
	var ajaxHtml = '<div>';
	var extraHtml = '';
	var backurl = params.backurl;
	if (lesson[0] == false) {
		ajaxCourse(backurl);
		showalert(SText.please_log_in);
		return;
	}
	var lesson_length = lesson.length;
	var lesson_progress = 0;
	var lesson_question_count = 0;

	for (var i = 0; i < lesson_length; i++) {
		var _page = lesson[i];
		if (_page.prevpageid == 0) {
			firstPage = _page;
		}
		if (_page.nextpageid == 0) {
			lastPage = _page;
		}
		if (!jQuery.inArray(_page.qtype, [ 20, 21, 30, 31 ])) {
			lesson_question_count++;
		}
		if (_page.attempts.length > 0) {
			alert('bravo we have some progress');
			lesson_progress++;
			var _attempts = _page.attempts;
			var attempts_length = _attempts.length;
			var timeseen = 0;
			var _lastattemp = null;
			for (var j = 0; attempts_length; j++) {
				var _attempt = _attempts[j];
				if (_attempt.timeseen > timeseen) {
					timeseen = _attempt.timeseen;
					_lastattempt = _attempt;
				}
			}
			if (parseInt(_lastattempt.correct) == 1) {
				lesson_progress++;
			}
		}

	} // end for loop i < lesson_length
	ajaxHtml += '<div class="progress progress-info">  <div class="bar" style="width: '
			+ Math.round((lesson_progress / lesson_question_count) * 100)
			+ ';"></div></div>';
	if (lesson_progress > 0) {
		ajaxHtml += SText.continue_lesson_msg;
		ajaxHtml += '<button class="btn-primary btn btn-large">'
				+ SText.continue_lesson_btn + '</button>';
		ajaxHtml += '<button class="btn-inverse btn btn-large">'
				+ SText.start_lesson_again_btn + '</button>';
	} else {
		currentPage = firstPage;
	}

	ajaxHtml += '<div class="lesson-page" data-currentPage="' + currentPage.id
			+ '">';
	if (jQuery.inArray(parseInt(currentPage.qtype), [ 1, 3, 5 ]) == true) {
		alert(currentPage.qtype);

		ajaxHtml += '<div id="page-1" class="presentation manual-start show-positions" data-pagenext="1" data-pagejump="" data-delay="1000" data-mode="button">';
		ajaxHtml += '<h3>' + currentPage.title + '</h3>';
		ajaxHtml += buildSlideHtml(currentPage);
		ajaxHtml += '</div>';
		ajaxHtml += '</div>';

	} else if (currentPage.qtype == 20) {
		ajaxHtml += '<p><button id="pageMode" class="btn btn-info" data-playstrat="1" data-playlist="playlist2">Auto</button></p>';
		ajaxHtml += '<div id="page-1" class="presentation manual-start show-positions" data-pagenext="1" data-pagejump="" data-delay="1000" data-mode="auto">';
		ajaxHtml += '<h3>' + currentPage.title + '</h3>';
		ajaxHtml += buildSlideHtml(currentPage);
		ajaxHtml += '</div>';
		ajaxHtml += '</div>';
	}

	ajaxLayout.children().last().replaceWith(ajaxHtml);
	registerPresentationEvents(jQuery(".lesson-page").children('.presentation')
			.first());
	addQuizEvents(function() {
		alert('do it right');
	});
	$('#pageMode').click(function() {
		$(this).text(SText.auto);
		$('.presentation-active').each(function() {
			$(this).removeClass('manual-start');
			var jqObj = $(this);
			// if(test_counter == 0)
			prepareSlide(jqObj);
			// jqObj = registerPresentationEvents(jqObj);
			jqObj.data('mode', 'auto');
			signalPlaySlide(jqObj);

		});
	});
	// ajaxQuiz(ajaxLayout, qlistURI, 0, type);

} // end Lesson callback
function buildSlideQuizHtml(page) {
	var qstartiStr = 'qstarti-' + page.id;
	var qstarti = jQuery.cookie(qstartiStr);
    // apholder('qstarti ' + qstarti + ' cookie ' + jQuery.cookie(qstartiStr));
	if (qstarti == undefined || qstarti == null || qstarti < 0
			|| !jQuery.isNumeric(qstarti)) {
		qstarti = 0;
		jQuery.cookie(qstartiStr, 0);
	}
	// _html += '<strong>' + page.contents + '</strong>';
	var questionListURI = sroot
			+ 'index.php?option=com_srhandbook&view=srkbucode&srctrler=ajax&format=raw&task=quiz&code='
			+ page.title + '&qstarti=' + qstarti + '&length=2';
	var quizHtml = '';
	// srhandbookQuiz = $('#srhandbook-quiz');
	// ajaxQuiz(srhandbookQuiz,questionListURI,0);
	// quizHtml +=
	jQuery
			.ajax({
				url : questionListURI,
				// + "media/sunrise/json/handbook/user01.handbook01",
				async : false,
				success : function(result) {

					var qlistObj = JSON.parse(result);
					var qlist = mapObjToArray(qlistObj);
					var qlistLength = qlist.length;

					// quizHtml = '<div class="srquestions srquiz
					// sunrise_form_wrapper">';
					if (qlistLength > 0) {
						quizHtml += '<div class="srquestions srquiz sunrise_form_wrapper ">';
						quizHtml += '<input type="hidden" data-position="1" data-mode="button" />';
						quizHtml += '<input type="hidden" data-position="2" data-mode="button" />';
						quizHtml += '<input type="hidden" data-position="3" data-mode="button" />';
						quizHtml += '<table>';
						quizHtml += '<tr>';
						if (qlistLength == 2) {

							quizHtml += '<td style="vertical-align:top">';
							quizHtml += buildQuestionHtml(qlist[0]);
							quizHtml += '</td>';
							quizHtml += '<td style="vertical-align:top">';
							quizHtml += buildQuestionHtml(qlist[1]);
							quizHtml += '</td>';
						} else if (qlistLength == 1) {
							quizHtml += '<td style="vertical-align:top">';
							quizHtml += buildQuestionHtml(qlist[0]);
							quizHtml += '</td>';
						}
						quizHtml += '</tr>';
						quizHtml += '<tr><td></td><td><button class="btn btn-large btn-primary hint-answer check-answer" data-loading-text="Đang tải..." >Kiểm tra</button></td></tr>';
						quizHtml += '</table>';
					} else if (qlistLength == 0) {
						if (jQuery.cookie(qstartiStr) > 0) {
							jQuery.cookie(qstartiStr, 0);
							;
							quizHtml += buildSlideQuizHtml(page);
						}
					}

					;
				}
			});
	quizHtml += ' </div>';
	return quizHtml;
}
function buildSlideHtml(page) {
	var _html = '';
	if (page.qtype == 20) {
		// _html += '<h3>'+page.title+'</h3>';
		_html += page.contents;
	} else if (jQuery.inArray(parseInt(page.qtype), [ 1, 3, 5 ]) > -1) {
		_html += buildSlideQuizHtml(page);
	}

	return _html;
}

function ajaxModuleLessonSubmit(uri, ajaxLayout, backurl, viewonly) {
	jQuery.getScript(sroot + 'media/editors/tinymce/tinymce.min.js',
			function() {

				var params = {
					backurl : uri,
					backurl2 : backurl,
					viewonly : viewonly
				};
				srAjax(uri, ajaxLayout, ajaxModuleLessonSubmitCallback, true,
						params);
			});

}
function ajaxModuleLessonSubmitCallback(result, uri, ajaxLayout, modal, params) {
	var backurl = params.backurl;
	var viewonly = params.viewonly;
	var lesson = mapObjToArray(JSON.parse(result));
	ajaxHtml = '<div class="srquestions srquiz sunrise_form_wrapper modal-body">';
	ajaxHtml += '<form id="modulelessonSubmitForm" >';
	var obj = parseUrlToObj(uri);
	ajaxHtml += '<input type="hidden" name="option" value="com_srels" />';
	ajaxHtml += '<input type="hidden" name="id" value="' + obj.id + '"/>';
	ajaxHtml += '<input type="hidden" name="srctrler" value="ajax"/>';
	ajaxHtml += '<input type="hidden" name="format" value="raw"/>';
	ajaxHtml += '<input type="hidden" name="task" value="course"/>';
	ajaxHtml += '<input type="hidden" name="view" value="module"/>';
	ajaxHtml += '<input type="hidden" name="moduleid" value="' + obj.moduleid
			+ '"/>';
	ajaxHtml += '<input type="hidden" name="action" value="postSubmission"/>';
	if (viewonly != false) {
		ajaxHtml += '<button class="btn" type="submit" data-dismiss="modal" aria-hidden="true">Close</button>';
		ajaxHtml += '<div><br/>'
				+ (lesson.length > 0 ? lesson[0].onlinetext : '') + '</div>';

	} else {
		ajaxHtml += '<button id="modulelessonSubmitPost" class="btn btn-primary">Submit</button>';
		ajaxHtml += '<button class="btn" type="submit" data-dismiss="modal" aria-hidden="true">Cancel</button>';
		ajaxHtml += '<textarea id="lessonSubmissionOnlineText" name="lessonSubmissionOnlineText" style="width:100%">'
				+ (lesson.length > 0 ? lesson[0].onlinetext : '')
				+ '</textarea>';
	}

	ajaxHtml += '</form>';
	ajaxHtml += '</div>';
	ajaxLayout.children().last().replaceWith(ajaxHtml);
	// jQuery('#modulelessonSubmitPost').click(function(){
	jQuery('#modulelessonSubmitForm').submit(function(e) {
		e.preventDefault();
		// jQuery.post(uri+'action="postSubmission"',
		// jQuery('#modulelessonSubmitForm').serialize());
		tinyMCE.get('lessonSubmissionOnlineText').save();
		jQuery.ajax({
			type : "POST",
			url : uri + '&action=postSubmission',
			data : jQuery('#modulelessonSubmitForm').serialize(), // serializes
			// the
			// form's
			// elements.
			success : function(data) {
				// alert(data); // show response from the php script.
				ajaxLayout.modal('hide');
				ajaxModuleLesson(params.backurl, params.backurl2)
			}
		});
	});

	// after dynamically loading the core file:
	// if (!tinymce.dom.Event.domLoaded) {
	// tinymce.dom.Event.domLoaded = true;
	// }
	tinymce.suffix = '.min';
	tinymce.baseURL = sroot + 'media/editors/tinymce'; // change to your
	// correct value
	tinyMCE
			.init({
				// General
				directionality : "ltr",
				language : "en",
				mode : "specific_textareas",
				autosave_restore_when_empty : false,
				skin : "lightgray",
				theme : "modern",
				schema : "html5",
				selector : "textarea",
				// Cleanup/Output
				inline_styles : true,
				gecko_spellcheck : true,
				entity_encoding : "raw",
				// extended_valid_elements :
				// "span[style|id|class|align|title],li[data-target|data-slide-to|class],ol[class]",
				force_br_newlines : false,
				force_p_newlines : true,
				forced_root_block : 'p',
				toolbar_items_size : "small",
				invalid_elements : "script,applet,iframe",
				// Plugins
				plugins : "autolink,lists,image,charmap,print,preview,anchor,pagebreak,code,save,textcolor,importcss,searchreplace,insertdatetime,link,fullscreen,table,emoticons,media,hr,directionality,paste,visualchars,visualblocks,nonbreaking,template,print,wordcount,advlist,autosave,contextmenu",
				// Toolbar
				// toolbar1 : "bold italic underline strikethrough | alignleft
				// aligncenter alignright alignjustify | styleselect |
				// formatselect
				// fontselect fontsizeselect | inserttime cut copy paste |
				// visualchars visualblocks nonbreaking blockquote template |
				// print
				// preview",
				// toolbar2 : "searchreplace | bullist numlist | outdent indent
				// | undo redo | link unlink anchor image | code |
				// forecolor,backcolor | fullscreen | table | subscript
				// superscript | charmap emoticons media hr ltr rtl",
				// toolbar3: "table | subscript superscript | charmap emoticons
				// media hr ltr rtl ",
				// toolbar4: "inserttime cut copy paste | visualchars
				// visualblocks nonbreaking blockquote template | print
				// preview",
				removed_menuitems : "newdocument",
				// URL
				relative_urls : false,
				remove_script_host : true,
				document_base_url : sroot + "media/editors/tinymce/",
				rel_list : [ {
					title : 'Alternate',
					value : 'alternate'
				}, {
					title : 'Author',
					value : 'author'
				}, {
					title : 'Bookmark',
					value : 'bookmark'
				}, {
					title : 'Help',
					value : 'help'
				}, {
					title : 'License',
					value : 'license'
				}, {
					title : 'Lightbox',
					value : 'lightbox'
				}, {
					title : 'Next',
					value : 'next'
				}, {
					title : 'No Follow',
					value : 'nofollow'
				}, {
					title : 'No Referrer',
					value : 'noreferrer'
				}, {
					title : 'Prefetch',
					value : 'prefetch'
				}, {
					title : 'Prev',
					value : 'prev'
				}, {
					title : 'Search',
					value : 'search'
				}, {
					title : 'Tag',
					value : 'tag'
				} ],
				// Templates
				templates : [
						{
							title : 'Layout',
							description : 'HTMLLayout',
							url : sroot
									+ 'media/editors/tinymce/templates/layout1.html'
						},
						{
							title : 'Simple snippet',
							description : 'Simple HTML snippet',
							url : sroot
									+ 'media/editors/tinymce/templates/snippet1.html'
						} ],
				// Layout
				content_css : sroot + "templates/system/css/editor.css",
				importcss_append : true,
				// Advanced Options
				resize : "both",
				image_advtab : true,
				height : "550",
				width : "750",

			});

}