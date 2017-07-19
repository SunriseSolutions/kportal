var SText = {
	please_log_in : "Vui lòng đăng nhập",
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

function ajaxModuleAssign(uri, backurl) {
	var ajaxNavURL = uri;// + '&qstarti=' + qstarti;
	var params = {
		backurl : backurl
	};
	loadingHtml = ' <div id="courseLoading" style="font-size:16px; background-color:white; layer-background-color:white; height:100%; width:100%;"><TABLE width=100% height=100% align="center" valign="center"><TR valign="center"><TD align="center">  Chờ xíu nhé...  <br/><img src="'
			+ sroot
			+ 'media/sunrise/images/ajax-loader.gif" /> </TD></TR></TABLE></div>';
	courselayout.children().last().replaceWith(loadingHtml);
	srAjax(ajaxNavURL, courselayout, ajaxModuleAssignCallBack, params);

}

function ajaxModuleAssignCallBack(result, uri, ajaxLayout, params) {
	var assign = mapObjToArray(JSON.parse(result));
	var ajaxHtml = '<div>';
	var extraHtml = '';
	var backurl = params.backurl;
	if (assign[0] == false) {
		ajaxCourse(backurl);
		showalert(SText.please_log_in);
		return;
	}
	if (assign.length == 0) {

		submissionStatus = SText.no_attempt;
		gradingStatus = SText.no_attempt;
		extraHtml += '<br/><button id="moduleAssignSubmit" class="btn btn-primary">';
		extraHtml += SText.add_submission;
		extraHtml += '</button> ';
		// Submission status Submitted for grading
		// Grading status Graded
		// Due date Monday, 17 February 2014, 12:00 AM
		// Time remaining 5 days 8 hours
		// Last modified Monday, 10 February 2014, 4:23 PM
		// Online text
	} else {

		submissionStatus = '<br/><button id="moduleAssignView" class="btn btn-info">';
		submissionStatus += SText.view_submission;
		submissionStatus += '</button> ';
		if (assign[0].gradeid == null) {
			gradingStatus = SText.not_graded;
			extraHtml += '<br/><button id="moduleAssignSubmit" class="btn btn-primary">';
			extraHtml += SText.edit_submission;
			extraHtml += '</button><br/> ';
		} else {

			gradingStatus = SText.graded;
			extraHtml += '<br/><strong>' + SText.grade + ': ' + '</strong>'
					+ '<h3  class="badge badge-inverse">' + Math.round(assign[0].gradevalue) + '</h3><br/>';
			if (assign[0].feedbackid != null) {
				extraHtml += '<strong><button id="moduleAssignFeedback" class="btn btn-info">'
						+ SText.view_feedback + '</button></strong>';
			}
		}

	}
	ajaxHtml += '<strong>' + SText.submission_status + ': ' + submissionStatus
			+ '</strong>';
	ajaxHtml += '<br/><br/><strong>' + SText.grading_status + ': '
			+ '</strong>' + gradingStatus;
	ajaxHtml += extraHtml;
	ajaxHtml += '<p></p><button id="ajaxBackModuleAssign" class="btn ">Back</button>';
	ajaxHtml += '<div id="ajaxModuleAssignSubmitLayout"><div></div></div>';
	ajaxHtml += '</div>';
	ajaxLayout.children().last().replaceWith(ajaxHtml);
	jQuery('#ajaxBackModuleAssign').click(function() {
		ajaxCourse(backurl);
		;
	});
	jQuery('#moduleAssignSubmit')
			.click(
					function() {
						ajaxModuleAssignSubmit(uri,
								jQuery("#ajaxModuleAssignSubmitLayout"),
								backurl, false);
					});

	jQuery('#moduleAssignView')
			.click(
					function() {
						ajaxModuleAssignSubmit(uri,
								jQuery("#ajaxModuleAssignSubmitLayout"),
								backurl, true);
					});
	jQuery('#moduleAssignFeedback')
			.click(
					function() {
						// ajaxModuleAssignSubmit(uri,
						// jQuery("#ajaxModuleAssignSubmitLayout"),
						// backurl,true);
						srAjax(
								uri,
								jQuery("#ajaxModuleAssignSubmitLayout"),
								function(result, uri, ajaxLayout, modal, params) {
									var assign = mapObjToArray(JSON
											.parse(result));
									ajaxHtml = '<div class="srquestions srquiz sunrise_form_wrapper modal-body">';
									ajaxHtml += '<button class="btn" type="submit" data-dismiss="modal" aria-hidden="true">Cancel</button>';
									ajaxHtml += '<div><br/>'
											+ (assign.length > 0 ? assign[0].commenttext
													: '') + '';

									ajaxHtml += '</div>';
									ajaxHtml += '</div>';
									ajaxLayout.children().last().replaceWith(
											ajaxHtml);
								}, true, params);
					});
}
function ajaxModuleAssignSubmit(uri, ajaxLayout, backurl, viewonly) {
	jQuery.getScript(sroot + 'media/editors/tinymce/tinymce.min.js',
			function() {

				var params = {
					backurl : uri,
					backurl2 : backurl,
					viewonly : viewonly
				};
				srAjax(uri, ajaxLayout, ajaxModuleAssignSubmitCallback, true,
						params);
			});

}
function ajaxModuleAssignSubmitCallback(result, uri, ajaxLayout, modal, params) {
	var backurl = params.backurl;
	var viewonly = params.viewonly;
	var assign = mapObjToArray(JSON.parse(result));
	ajaxHtml = '<div class="srquestions srquiz sunrise_form_wrapper modal-body">';
	ajaxHtml += '<form id="moduleAssignSubmitForm" >';
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
				+ (assign.length > 0 ? assign[0].onlinetext : '') + '</div>';

	} else {
		ajaxHtml += '<button id="moduleAssignSubmitPost" class="btn btn-primary">Submit</button>';
		ajaxHtml += '<button class="btn" type="submit" data-dismiss="modal" aria-hidden="true">Cancel</button>';
		ajaxHtml += '<textarea id="assignSubmissionOnlineText" name="assignSubmissionOnlineText" style="width:100%">'
				+ (assign.length > 0 ? assign[0].onlinetext : '')
				+ '</textarea>';
	}

	ajaxHtml += '</form>';
	ajaxHtml += '</div>';
	ajaxLayout.children().last().replaceWith(ajaxHtml);
	// jQuery('#moduleAssignSubmitPost').click(function(){
	jQuery('#moduleAssignSubmitForm').submit(function(e) {
		e.preventDefault();
		// jQuery.post(uri+'action="postSubmission"',
		// jQuery('#moduleAssignSubmitForm').serialize());
		tinyMCE.get('assignSubmissionOnlineText').save();
		jQuery.ajax({
			type : "POST",
			url : uri + '&action=postSubmission',
			data : jQuery('#moduleAssignSubmitForm').serialize(), // serializes
			// the
			// form's
			// elements.
			success : function(data) {
				// alert(data); // show response from the php script.
				ajaxLayout.modal('hide');
				ajaxModuleAssign(params.backurl, params.backurl2)
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