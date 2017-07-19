var SText = {
	auto : "Autoplay",
	click : "Click to play"
};
var slideTimer;
var slideHistory = [];
var slideItemHistory = [];
var srslide = [];
var slideList = null;
var kbucodeList = null;

jQuery(document).ready(function($) {
	jQuery('body').keyup(function(e) {
		$('.presentation-active').each(function() {
			var jqObj = $(this);
			if (e.keyCode == 39) { // right arrow
				processSlideClickEvents(jqObj);
			} else if (e.keyCode == 37) { // left arrow
				processSlideClickEvents(jqObj, true);
			}

		});

	});
	$('.presentation').each(function() {
		registerPresentationEvents($(this));
	});

});

function processSlideClickEvents(jqObj, back) {
	prepareSlide(jqObj);
	if (slideTimer != undefined) {
		if (slideTimer != null) {
			window.clearTimeout(slideTimer);
		}
	}
	if (jqObj.srgetData('mode') == 'auto') {
		jqObj.data('mode', 'click');
		jQuery('#pageMode').text(SText.click);
	}
	if (jqObj.srgetData('mode') == 'click') {
		if (back) {
			backSlide(jqObj);
		} else {

			signalPlaySlide(jqObj);
		}

	}
}

function backSlide(jqObj) {
	stopAudio();
	var pos = jqObj.srgetPos();
	var i = jqObj.srfindByData('position', pos);

	if (i != null) {
		i.hide();
		jqObj.data('currentpos', pos - 1);
	} else {
		jumpSlide(jqObj, false);
	}

	return;
}

function signalPlaySlide(jqObj) {
	// if (jqObj.attr('data-delay')) {
	// delay = jqObj.data('delay');
	// }
	var delay = jqObj.srgetData('delay');
	if (delay == null) {
		delay = 0;
	}
	// alert(jqObj.srgetData('mode')+' '+jqObj.srgetData('currentpos'));

	if (jqObj.srgetData('mode') == 'click') {
		slideTimer = null;
		playSlide(jqObj)
	} else if (jqObj.srgetData('mode') == 'button') {
		slideTimer = null;
		playSlide(jqObj)
	} else if (jqObj.srgetData('mode') == 'auto') {
		return setTimeout(function() {
			playSlide(jqObj)
		}, delay);
	}
}

function playSlide(o) {
	// var o = jqObj;

	var showpos = o.hasClass('show-positions');
	var hidepos = o.hasClass('hide-positions');
	var mode = o.srgetData('mode');
	var playnext = o.srgetData('pagenext');
	var playjump = o.srgetData('pagejump');

	// dump(pos);

	o.playSlideItem(o.srfindByData('position', o.increasePos()));

	// if(jqObj.srgetData('mode')=='auto'){
	// signalPlaySlide(jqObj);
	// }
}

function prepareSlide(jqObj) {

	if (!(typeof jqObj.srgetData === 'function')) {
		jqObj['srgetData'] = function(key) {
			return window.srgetData(key, jqObj);
		}
	}

	if (!(typeof jqObj.srfindByData === 'function')) {
		jqObj['srfindByData'] = function(key, val) {
			var t = jqObj.find('*[data-' + key + '="' + val + '"]');
			if (t.length > 0) {
				return t;
			} else {
				return null;
			}
		}
	}

	if (!(typeof jqObj.playSlideItem === 'function')) {
		jqObj['playSlideItem'] = function(i) {
			if (i == null) {
				return jumpSlide(jqObj, true);
			}
			i['srgetData'] = function(key) {
				return window.srgetData(key, jQuery(i));
			}

			stopAudio();
			i.show();

			var audioalias = i.srgetData('audioalias');
			if (audioalias != null) {
				var audiodelay = i.srgetData('audiodelay');
				if (audiodelay == null) {
					audiodelay = 0;
				}

				slideTimer = setTimeout(function() {
					playPhrase(audioalias, function() {
						var attr2 = [ 'delay', 'pagejump' ];
						for (var j = 0; j < attr2.length; j++) {
							var iattr = i.srgetData(attr2[j]);
							if (iattr != null) {
								jqObj.data(attr2[j], iattr);
							}
						}
						if (jqObj.refreshSlideMode() == 'auto') {
							slideTimer = signalPlaySlide((jqObj));

						}
					}, 0);
				}, audiodelay);

			} else {
				// jqObj.playSlideNext(i);
				var playnext = i.srgetData('pagenext');
				var playjump = i.srgetData('pagejump');
				var attr2 = [ 'delay', 'pagejump' ];
				for (var j = 0; j < attr2.length; j++) {
					var iattr = i.srgetData(attr2[j]);
					if (iattr != null) {
						jqObj.data(attr2[j], iattr);
					}
				}
				if (jqObj.refreshSlideMode() == 'auto') {
					slideTimer = signalPlaySlide((jqObj));

				}
			}

		}
	}
	if (!(typeof jqObj.nextSlideItem === 'function')) {
		jqObj['nextSlideItem'] = function() {
			var pos = jqObj.srgetPos();
			var i = jqObj.srfindByData('position', pos + 1);
			if (i == null)
				return null;
			if (!i.hasOwnProperty('srgetData')) {
				i['srgetData'] = function(key) {
					return window.srgetData(key, jQuery(i));
				}
			}
			return i;

		}
	}
	if (!(typeof jqObj.prevSlideItem === 'function')) {
		jqObj['prevSlideItem'] = function() {
			var pos = jqObj.srgetPos();
			var i = jqObj.srfindByData('position', pos - 1);
			if (i == null)
				return null;
			if (!i.hasOwnProperty('srgetData')) {
				i['srgetData'] = function(key) {
					return window.srgetData(key, jQuery(i));
				}
			}
			return i;

		}
	}

	if (!(typeof jqObj.srgetPos === 'function')) {
		jqObj['srgetPos'] = function() {
			var pos = jqObj.srgetData('currentpos');
			if (pos == null) {
				pos = 0;
			}
			return pos;

		}
	}
	if (!(typeof jqObj.increasePos === 'function')) {
		jqObj['increasePos'] = function() {
			var pos = jqObj.srgetPos();
			var item = jqObj.nextSlideItem();
			if (item == null) {
				// jqObj.data('currentpos', pos);
				pos = -1;
			} else {
				pos = parseInt(pos) + 1;
				jqObj.data('currentpos', pos);
			}
			return pos;

		}
	}
	if (!(typeof jqObj.refreshSlideMode === 'function')) {
		jqObj['refreshSlideMode'] = function() {
			var item = jqObj.nextSlideItem();
			// jqObj.children('[data-position]').show();
			if (item != null) {
				var iattr = item.srgetData('mode');
				if (iattr != null) {
					jqObj.data('mode', iattr);
					jQuery('#pageMode').text(SText[iattr]);
				}
			}
			return jqObj.srgetData('mode');
		}
	}

}
function initSlide(lessonpage) {
	lessonpage.each(function() {
		// var newo = jQuery(this).children('div.presentation-active').last();
		// registerPresentationEvents(newo);

	});
}
function jumpSlide(o, nextslide) {
	jQuery("#startLesson").each(function() {
		// $(this).show();
	});
	if (slideList == undefined || slideList == null) {
		return null;
	} else {
		var newo = null;
		if (o.hasClass('server-data')) {
			alert('server');
		} else if (o.hasClass('client-data')) {
			alert('client');
		} else {
			// alert('no method specified');
			// return;
		}

		// srslide[o.attr('id')] = o;
		var o_slideid = o.attr('id');
		var n_slideid;
		var newo;
		slideHistory[o_slideid] = o;
		for (var i = 0; i < slideList.length; i++) {
			if (slideList[i].id == o_slideid) {
				var o_slide = slideList[i];
				if (nextslide == true) {
					n_slideid = o_slide.nextpageid;
					newo = buildSlide(n_slideid, o);
				} else { // if we are going back;
					n_slideid = o_slide.prevpageid;
					// newo = slideHistory[n_slideid];
					newo = buildSlide(n_slideid, o);
				}

				if (newo != null) {
					o.hide();
					o.removeClass('presentation-active');
					// slideHistory[o.attr('id')] = o;
					// initSlide(newo.parent());
					prepareSlide(newo);
					newo.addClass('presentation-active');
					newo.show();
					if (newo.srgetData('mode') == 'auto') {
						newo.removeClass('manual-start');
						// prepareSlide(newo);
						// signalPlaySlide(newo);
						registerPresentationEvents(newo);
					} else if (newo.srgetData('mode') == 'click'
							|| newo.srgetData('mode') == 'button') {
						newo.addClass('manual-start');
						registerPresentationEvents(newo);
					}
				} else {
					showalert('no more pages to show');
				}
				break;
			}
		}

	}
}

function registerPresentationEvents(o) {
	var playMode;
	if (o.hasClass('manual-start')) {
		playMode = SText.click;
	} else {
		playMode = SText.auto;
	}
	jQuery('#pageMode').text(playMode);
	if (o.data('slideEventsAdded') != '1') {

		$ = jQuery;
		// var lastPage = $('.presentation').last();
		o.addClass('presentation');
		var pageid = o.parent().data('currentpage');
		if (o.attr('id') != undefined) {
			if (pageid != null && pageid != undefined) {
				o.attr('id', o.parent().data('currentpage'));
				o.addClass('presentation-active');
			}
		}

		o.addClass('presentation-active');
		prepareSlide(o);

		o.find('[data-position]').hide();
		if (o.hasClass('manual-start')) {

		} else {// auto-start by default
			signalPlaySlide(o);
		}

		o.mousedown(function(e) {
			if (e.which == 1) {
				processSlideClickEvents(o);
			}
		});
		o.data('slideEventsAdded', '1');
	}
}

function buildSlide(n_slideid, o) {
	var qstartiStr = 'qstarti-'+n_slideid;
	if(jQuery.cookie(qstartiStr) === null){
		jQuery.cookie(qstartiStr, '0');
	}
	qstarti_global = jQuery.cookie(qstartiStr);

	kbucodeList = new Object();
	var newo;
	var n_slide;
	if (n_slideid != undefined && n_slideid != null) {
		if (slideHistory[n_slideid] != undefined
				&& slideHistory[n_slideid] != null
				&& slideHistory[n_slideid].length > 0) {
			newo = slideHistory[n_slideid];// o.parent().children('#'
			// + n_slideid);
			return newo;
		} else { // fetching
			for (var i = 0; i < slideList.length; i++) {
				if (slideList[i].id == n_slideid) {
					n_slide = slideList[i];
					break;
				}
			}// end for loop
			if (n_slide != undefined && n_slide != null) {
				var _html = '';
				if (jQuery.inArray(parseInt(n_slide.qtype), [ 1, 3, 5 ]) > -1) {
					jQuery.cookie('qpassed', '0');
					_html += '<div id="page-1" class="manual-start show-positions" data-pagenext="1" data-pagejump="" data-delay="1000" data-mode="button">';
					_html += '<h3> Mã Kiến Thức: ' + n_slide.title + '</h3><div class="hide alert alert-block alert-error fade in"> <button type="button" class="close" data-dismiss="alert">×</button></div>';
				} else {
					_html += '<div id="page-1" class="auto-start show-positions" data-pagenext="1" data-pagejump="" data-delay="1000" data-mode="auto">';
					_html += '<h3>' + n_slide.title + '</h3>';
				}

				
				_html += buildSlideHtml(n_slide);
				_html += '</div>';
				newo = jQuery(_html, {}).appendTo(o.parent());
				newo.attr('id', n_slideid);
				addQuizEvents(qProcessorCallBack);
			}
			if (newo != undefined && newo != null) {
				// srslide[o.attr('id')] = newo;
				newo.parent().data('currentpage', n_slideid);

				return newo;
			} else {
				return null;
			}
		} // done fetching
	}
	
	function qProcessorCallBack(action, jqo, status) {
		if(action == 'checkanswer'){  
			if(jqo >= 100) { 
//				alert('ok to jump '+kbucodeList.passed);
				if(kbucodeList.passed==false){
					$(".alert").text('Bạn đã không làm đúng tất cả câu hỏi, vì thế bạn cần làm lại phần kiến thức này');
					var qstarti_global = parseInt(jQuery.cookie(qstartiStr));
					qstarti_global+=2;
					jQuery.cookie(qstartiStr, qstarti_global);
					newo.children().last().replaceWith(buildSlideQuizHtml(n_slide));
					$(".alert").show();
					$(".alert").alert();
					kbucodeList = new Object();
//					srhandbookQuiz = $('#srhandbook-quiz');
//					qProcessorCallBack(action, jqo, status); 
					addQuizEvents(qProcessorCallBack);
				}else{ // 'you passed, all questions were answered correctly';
					$(".alert").hide();
					jumpSlide(newo,true);
				}
				
			}
		} 
	else if (action == 'submitTF') {
			if (status == false) {
				jQuery.cookie('qpassed', '-1');
			} else if (jQuery.cookie('qpassed') == '0') {
				jQuery.cookie('qpassed', '1');

			}
			var _oname = jqo.attr('name');
			if(_oname==undefined){
				return;
			}
			var _onameArray = _oname.split(';');
			var _okbucode = _onameArray[1];
			var qid = -1;
			if (_onameArray.indexOf('match-') < 0) {
				qid = _onameArray[0];
			} else {
				qid = _onameArray[0].split('-')[1];
			}

			var importKbucodeQuery = 'index.php?option=com_srhandbook&view=submitTF&srctrler=ajax&format=raw&task=quiz&code='
					+ _okbucode + '&qid=' + qid;
			var submitTFQuery = 'index.php?option=com_srels&view=submitTF&srctrler=ajax&format=raw&task=quiz&pageid='
					+ n_slide.id
					+ '&lessonid='
					+ n_slide.lessonid
					+ '&attemptcorrect='
					+ (status == true ? 1 : 0)
					+ '&qid=' + qid;
			if (!kbucodeList.hasOwnProperty(_okbucode)) {
				kbucodeList[_okbucode] = status;
				kbucodeList.passed = status;
				jQuery.ajax({
					async: false,
					url : importKbucodeQuery,
					// +
					// "media/sunrise/json/handbook/user01.handbook01",
					success : function(result) {
						// callback(result, ajaxNavURL, ajaxLayout,
						// modal, params);
					}
				});

				jQuery.ajax({
					async: false,
					url : submitTFQuery,
					// +
					// "media/sunrise/json/handbook/user01.handbook01",
					success : function(result) {
						// callback(result, ajaxNavURL, ajaxLayout,
						// modal, params);
					}
				});
			} else {
			}

			if (status == false) {
				if (kbucodeList[_okbucode] == true) {
					jQuery.ajax({
						url : submitTFQuery,
						// +
						// "media/sunrise/json/handbook/user01.handbook01",
						success : function(result) {
							kbucodeList[_okbucode] = false;
							kbucodeList.passed = false;
							// callback(result, ajaxNavURL,
							// ajaxLayout, modal, params);
						}
					});

				}else{

				}
			}else{

			}

			// alert(submitTFQuery + 'hello processor ' + action + '
			// - ' + status
			// + ' - ' + jqo.attr('name') + ' -cookie- '
			// + jQuery.cookie('qpassed') + ' -result- '
			// + jqo.parents('.srquiz').find('.result').val());
			// dump(submitTFQuery);

		}
	}
	return newo;
}