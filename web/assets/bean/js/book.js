var x = "adfds+fsdf-sdf . why dont you love me? oh babe, I love you, I really love you! Ok ?";

// var separators = [' ', '\\\+', '-', '\\\(', '\\\)', '\\*', '/', ':', '\\\?'];
var separators = [ '\\!', ';', '\\\?', '\\.' ];
// console.log(separators.join('|'));
var tokens = x.split(new RegExp(separators.join('|'), 'g'));
// console.log(tokens);

for (var i = 0; i < tokens.length; i++) {
	var token = tokens[i].trim();
	console.log(token);
}

var currentChapter;
function BookChapter(jchapter) {
	var __construct = function(that) {

		that.splitContent = function(content) {
			// var separators = [ '\\!', ';', '\\\?', '\\.' ];

			// return content.split(new RegExp(separators.join('|'), 'g'));
			return content.split(new RegExp('{::separator::}', 'g'));
		}

	}(this)

	this.buildStoryPageHtml = function() {
		var content = jchapter.content;
		// var separators = [ '\\!', ';', '\\\?', '\\.' ];
		// that.phraseList = content.split(new RegExp(separators.join('|'),
		// 'g'));
		var _tcontent = replaceAll('&nbsp;', ' {space}', content);
		_tcontent = replaceAll('<p>', '{p}', _tcontent);
		_tcontent = replaceAll('</p>', ' {/p}', _tcontent);
		_tcontent = replaceAll('<strong>', '{strong}', _tcontent);
		_tcontent = replaceAll('</strong>', '{/strong}', _tcontent);
		_tcontent = replaceAll('<br />', ' {break}', _tcontent);
		_tcontent = replaceAll('<br/>', ' {break}', _tcontent);
		_tcontent = replaceAll('...', '{3dots}', _tcontent);
		_tcontent = stripHTML(_tcontent);

		_tcontent = replaceAll('{p}', '{p}{::separator::}', _tcontent);
		_tcontent = replaceAll('{/p}', '{::separator::}{/p}', _tcontent);
		_tcontent = replaceAll('!', '!{::separator::}', _tcontent);
		_tcontent = replaceAll(';', ';{::separator::}', _tcontent);
		_tcontent = replaceAll('?', '?{::separator::}', _tcontent);
		_tcontent = replaceAll('.', '.{::separator::}', _tcontent);
		this.phraseList = this.splitContent(_tcontent);

		var phraseList = this.phraseList;
		var pHtml = '';
		for (var i = 0; i < phraseList.length; i++) {
			var phrase = (phraseList[i]);
			if (phrase == '{p}' || phrase == '{/p}') {
				phrase = replaceAll('{p}', '<p>', phrase);
				phrase = replaceAll('{/p}', '</p>', phrase);
				pHtml += phrase;
				continue;
			}
			phrase = replaceAll('{space}', '&nbsp;', phrase);
			phrase = replaceAll('{strong}', '<strong>', phrase);
			phrase = replaceAll('{/strong}', '</strong>', phrase);
			phrase = replaceAll('{break}', '<br/>', phrase)
			phrase = replaceAll('{3dots}', '...', phrase)
			pHtml += '<div class="book-phrase">' + phrase + '</div>';
			// pHtml += replaceAll(phrase, '<span class="book-phrase">' + phrase
			// + '.</span>', phraseList[i]);
			// alert(phrase);
		}
		return pHtml + " modified.";
	}

	this.indexOf = function(phrase) {
		return jQuery.inArray(phrase.trim(), this.phraseList);
	}

	this.buildStaticPageHtml = function() {
		var content = jchapter.content;
		var pHtml = jchapter.title;
		pHtml += content;

		return pHtml + " modified.";
	}
}

function ajaxBook(uri, ajaxLayout, tocLayout) {
	// + '&qstarti=' + qstarti;
	var bookuri = uri + '&task=book&view=chapter';
	var tocuri = uri + '&task=book&view=toc';
	var params = null;
	loadingHtml = ' <div id="courseLoading" style="font-size:16px; background-color:white; layer-background-color:white; height:100%; width:100%;"><TABLE width=100% height=100% align="center" valign="center"><TR valign="center"><TD align="center">  Chờ xíu nhé...  <br/><img src="'
			+ sroot
			+ 'media/sunrise/images/ajax-loader.gif" /> </TD></TR></TABLE></div>';
	ajaxLayout.children().last().replaceWith(loadingHtml);
	tocLayout.children().last().replaceWith(loadingHtml);
	srAjax(bookuri, ajaxLayout, ajaxBookCallBack, false, params);
	srAjax(tocuri, tocLayout, ajaxTocCallBack, false, params);
	jQuery.ajax({
		url : uri + '&task=book&view=nextchapter&srctrler=ajax&format=raw',
		// + "media/sunrise/json/handbook/user01.handbook01",
		success : function(result) {
			if (result.success == false) {
				jQuery('#book-next-page').show();
			}
		}
	});
}

function ajaxTocCallBack(result, uri, ajaxLayout, params) {
	var jsonObj = JSON.parse(result);
	var ajaxArray = mapObjToArray(jsonObj.toc);
	var ajaxHtml = '';
	var ajaxLength = ajaxArray.length;
	// qstarti += ajaxLength;
	book = ajaxArray[0];
	currentChapter = ajaxArray[1];
	if (jsonObj.success == false) {
		ajaxLayout.children().last().replaceWith('<h1>Vui lòng đăng nhập</h1>');
		return false;
	}

	if (ajaxLength > 0) {
		// dump(result);
		// ajaxLayout.children().last().replaceWith('<div>'+jsonObj+'</div>');
		// dump(jsonObj);
		ajaxHtml += '<ol>';
		var parenti = null;
		var firstSub = false;
		for (var i = 0; i < ajaxLength; i++) {
			var _toci = ajaxArray[i];
			if (_toci.subchapter == '0') {
				if (firstSub == true) {
					firstSub = false;
					ajaxHtml += '</ol>';
				}
				parenti = _toci;
			} else {
				if (firstSub == false) {
					firstSub = true;
					ajaxHtml += '<ol>';
				}
				
			}
			ajaxHtml += '<li>' + _toci.title + '</li>';

		}

		if (firstSub == true) {
			firstSub = false;
			ajaxHtml += '</ol>';
		}
		ajaxHtml += '</ol>';
		ajaxLayout.children().last().replaceWith('<div>' + ajaxHtml + '</div>');
	}
}
function ajaxBookCallBack(result, uri, ajaxLayout, params) {
	// alert(result);
	// var qstarti = params[0];
	var jsonObj = JSON.parse(result);
	var ajaxArray = mapObjToArray(jsonObj);
	var ajaxHtml;
	var ajaxLength = ajaxArray.length;
	// qstarti += ajaxLength;
	book = ajaxArray[0];
	currentChapter = ajaxArray[1];
	if (jsonObj.success == false) {
		ajaxLayout.children().last().replaceWith('<h1>Vui lòng đăng nhập</h1>');
		return false;
	}
	var chapter = new BookChapter(currentChapter);
	var bHtml = '<p><button class="btn btn-info btn-large">Bookmark trang này</button> <button id="book-prev-page" class="btn hide">Trang trước</button><button id="book-next-page" class="btn  hide">Tiếp theo</button></p>';
	if (book.booktype == SBookConfig.STATIC) {
		bHtml += chapter.buildStaticPageHtml();
	} else if (book.type == SBookConfig.STORY) {
		bHtml += chapter.buildStoryPageHtml();
	}
	ajaxLayout.children().last().replaceWith('<div>' + bHtml + '</div>');
	if (chapter.id > 1) {
		jQuery('#book-last-page').show();
	}

	if (ajaxLength > 0) {
		// dump(result);
		// ajaxLayout.children().last().replaceWith('<div>'+jsonObj+'</div>');
		// dump(jsonObj);
	}
}
