var STextQuiz = {
	VIP_ONLY : "Chỉ có thành viên VIP mới có thể sử dụng chức năng này...",
	eyecolor123 : "blue"
};


function ajaxQuiz(ajaxLayout, qlistURI, qstarti, length,strat) {
	var quizNavURL = qlistURI + '&qstarti=' + qstarti;
	var params = []; 
	if(length != undefined){
		if(length > 0){
			quizNavURL +=  '&length=' + length;
			params['length']=length;
		}
	}
	if(strat!=undefined){
		if(strat != null){
			quizNavURL += '&strat=' + strat;
			params['strat']=strat;
		}
	}

	params['qlistURI'] = qlistURI;
	params['qstarti']=qstarti;

	
	srAjax(quizNavURL, ajaxLayout, ajaxQuizCallback, true, params);	
}
function ajaxQuizCallback(result, quizNavURL, srhandbookQuiz, modal, params) {
	// alert(result);
	var $ = jQuery;
	var qlistURI = params.qlistURI;
	var qstarti = params.qstarti;
	var length = params.length;
	var strat = params.strat;

	var qlistObj = JSON.parse(result);
	var qlist = mapObjToArray(qlistObj);
	

	
	qlistLength = qlist.length;
	splitIndex = qlistLength / 2;
	if (qlistLength % 2 == 1) {
		splitIndex = Math.floor(splitIndex) + 1;
	}

	qstarti += qlistLength;

	if (qlistLength > 0) {
		quizHtml = '<div class="srquestions srquiz sunrise_form_wrapper modal-body">';
		// quizHtml += '<span class="icon
		// icon-information">&nbsp;</span>';
		// quizHtml += '<div
		// class="alert">';
		// quizHtml += 'Using the words in
		// parentheses, complete the text
		// below with the appropriate
		// tenses, then click the "Check"
		// button to check your answers.';
		// quizHtml += '</div>';
		
		if (qlist[0] == false) {
			 
			showalert(STextQuiz[qlistObj.message]);
			quizHtml += '<h1>'+STextQuiz[qlistObj.message] + '</h1> <a class="btn btn-info" href="'+sroot+'thanh-vien-vip.html">Xem thông tin về VIP Membre</a> <button class="btn" data-dismiss="modal" aria-hidden="true">Đóng lại</button>';
			srhandbookQuiz.children().last().replaceWith(quizHtml);
			return
		}
		
		quizHtml += '<table>';
		var _matchArr = [];
		var _mai = 0;
		// ////////// FIRST COLUMN ////////
		quizHtml += '<tr><td style="vertical-align:top">';
		quizHtml += '<ol start="' + (qstarti - qlistLength + 1) + '">';
		for (i = 0; i < splitIndex; i++) {
			var question = qlist[i];
			quizHtml += '<li>';
			quizHtml += buildQuestionHtml(qlist[i]);
			quizHtml += '</li>';
			if (qlist[i].qtype == "match") {
				_matchArr[_mai] = qlist[i].id;
				_mai++;
			}
		}
		if (qlistLength > 1) {
			quizHtml += '</ol>';
			quizHtml += '</td>';

			// ////////// SECOND COLUMN ////////
			quizHtml += '<td width="50%" style="vertical-align:top">';
			quizHtml += '<ol start="'
					+ (qstarti - qlistLength + 1 + splitIndex) + '">';
			// quizHtml += '<tr><td>';
			for (i = splitIndex; i < qlistLength; i++) {
				var question = qlist[i];
				quizHtml += '<li>';
				quizHtml += buildQuestionHtml(qlist[i]);
				if (qlist[i].qtype == "match") {
					_matchArr[_mai] = qlist[i].id;
					_mai++;
				}
				quizHtml += '</li>';
			}
			// quizHtml += '</td></tr>';
			quizHtml += '<p><a class="quizNext btn btn-primary" href="'
					+ quizNavURL + '">Tiếp theo</a> ';
			quizHtml += '<button class="btn" data-dismiss="modal" aria-hidden="true">Đóng lại</button>';
			quizHtml += '</p>';
			quizHtml += '</ol>';
			quizHtml += '</td></tr>';
			quizHtml += '</table>';
			quizHtml += '</div>';

			// jQuery(quizHtml, {}).appendTo(srhandbookQuiz);
			srhandbookQuiz.children().last().replaceWith(quizHtml);
			addQuizEvents(function(){});
			for (_maix = 0; _maix < _mai; _maix++) {
				jQuery('span.shuffle-match' + _matchArr[_maix]).shuffle();
			}

			// jQuery('<div>' + result + '</div>', {}).appendTo(
			// srhandbookQuiz);

		} else { // if only 1 column
			quizHtml += '<p><a class="quizNext btn btn-primary" href="'
					+ quizNavURL + '">Tiếp theo</a> ';
			quizHtml += '<button class="btn" data-dismiss="modal" aria-hidden="true">Đóng lại</button>';
			quizHtml += '</p>';
			quizHtml += '</ol>';
			quizHtml += '</tr>';
			quizHtml += '</table>';
			// quizHtml += '<div>' + result + '</div>';
			quizHtml += '</div>';
			// jQuery(, {}).appendTo(
			// srhandbookQuiz);
			// jQuery(quizHtml, {}).appendTo(srhandbookQuiz);
			srhandbookQuiz.children().last().replaceWith(quizHtml);

			addQuizEvents(function(){});
			for (_maix = 0; _maix < _mai; _maix++) {
				jQuery('span.shuffle-match' + _matchArr[_maix]).shuffle();
			}

		}
	} else {
		quizHtml = '<h1>Bạn đã hoàn tất câu hỏi của phần này ';
		// jQuery(quizHtml, {}).appendTo(srhandbookQuiz);
		quizHtml += '<button class="btn" data-dismiss="modal" aria-hidden="true">Đóng lại</button>';
		quizHtml += '</h1>';
		srhandbookQuiz.children().last().replaceWith(quizHtml);

	}

	$('.quizNext').click(function(e) {
		e.preventDefault();
		ajaxQuiz(srhandbookQuiz, qlistURI, qstarti, length,strat);

	});

	//
	// srhandbookQuiz.chidren().last().show();
}