jQuery(function($) {
	addQuizEvents();
});
// $('.check-qtext')
function addQuizEvents(qProcessor) {
	$ = jQuery;
	var result = 0;
	var srquiz_list = [];
	$('.srquiz').each(function(index, element) {
		srquiz_list[index] = $(this);
		jQuery('<input/>', {
			type : 'hidden',
			class : 'total-question',
			value : $(this).find('.srquestion').length
		}).appendTo($(this));
		jQuery('<input/>', {
			type : 'hidden',
			name : 'result',
			class : 'result',
			value : 0
		}).appendTo($(this));

	});

	$('.check-qtext').keypress(function(e) {
		if ($(this).data('live') <= 1 && e.which == 13) {
			e.preventDefault();
			checkAnswer($(this));
		}
	});

	// result = parseFloat($(listid + ' .result').val());

	$('.hint-answer')
			.click(
					function() {
						var srquiz = $(this).parents('.srquiz');
						var srquestion_list = srquiz.find('.srquestion');
						// showalert('let s go ' +
						// srquiz.attr('id')+'----'+srquestion_list.length);
						for (var i = 0; i < srquestion_list.length; i++) {
							// questionObj = $(qid);
							var srquestionObj = $(srquestion_list[i]); // because
							// srquiz.find('.question')
							// returns DOM element and
							// not JQuery element
							// alert("i is "+i+" --- "+questionObj.val());

							if (!$(srquestion_list[i]).is('input:text')) {
								// not input text hint
								if (!hintMultipleChoiceQuestion(srquestionObj))
									break;
							} else { // input text hint
								var answer = srquestionObj.data('answer')
										.trim();
								var length_a = answer.length;
								var question = srquestionObj.val();
								var length_q = question.length;
								var current = '';
								if (question != answer) {
									if (length_q > 0) {
										for (var j = 0; j < length_q; j++) {
											current += answer.charAt(j);
											if (question.charAt(j)
													.toLowerCase() != answer
													.charAt(j).toLowerCase()) {
												srquestionObj.val(current);
												showalert(
														'Một ký tự đã được thêm vào.',
														'warning');
												break;
											}
										}
										if (length_q < length_a) {
											current += answer.charAt(length_q);
											srquestionObj.val(current);
											showalert(
													'Một ký tự đã được thêm vào.',
													'warning');
											break;
										}
									} else {
										srquestionObj.val(answer.charAt(0));
										showalert(
												'Một ký tự đã được thêm vào.',
												'warning');
										break;
									}
								}
							}// end input text hint in if else check input
							// type
						}// end for loop
					});

	$('.hint-choice').change(function() {
		hintMultipleChoiceQuestion($(this));
	});
	$('.check-choice').change(function() {
		checkAnswer($(this));
	});
	function checkAnswer(questionObj) {

		var srquiz = questionObj.parents('.srquiz');
		var srquestion_list = srquiz.find('.srquestion');

		var total_question = srquiz.children('.total-question').val();
		var resultObj = srquiz.children('.result');
		var result = parseFloat(resultObj.val());

		// questionObj = $(qid);
		result = checkSrquestion(questionObj, total_question, resultObj, result);

		var incorrect = '';
		result = Math.ceil(result.toFixed(4) * 100) / 100;
		if (result < 100)
			incorrect = '<break>Những câu trả lời không chính xác <break>được chừa lại để bạn chỉnh sửa.';
		else
			result = 100;
		showalert('Bạn đã hoàn tất ' + result + '%. '
				+ incorrect.replace(/break/g, 'br/'), 'success');

		if (srquiz.find('.alert').length > 0) {
			srquiz.find('.alert')[0].textContent = ('Bạn đúng được ' + result
					+ '%. ' + incorrect.replace(/<break>/g, ''));
		}
		
	}
	function hintMultipleChoiceQuestion(srquestionObj) {
		// questionchoiceObj = $(list[index]);
		// var _parent = questionchoiceObj.parent(); // require direct parent

		if (srquestionObj.find("input[type=checkbox]").length > 0) {
			// checkbox hint
			messageObj = srquestionObj.children('.message');
			// srquestionchoice_list =
			// srquestionObj.children("input[type=checkbox]");
			// get all the checked inputs with name
			// skills
			var checked = srquestionObj.find("input[type=checkbox]:checked");

			// an array containing values of all
			// checked inputs
			var values = checked.map(function() {
				return this.value
			}).get();
			var answers = srquestionObj.data('answer').split(',');
			if ($(values).not(answers).length == 0
					&& $(answers).not(values).length == 0) {
				messageObj.text(" ").removeClass('incorrect-answer-hint')
						.addClass('correct-answer-hint');
				;
				checked.each(function(index, element) {
					data_hint = $(this).data('hint');
					if (data_hint.trim() != '') {
						messageObj.append(data_hint);
						jQuery('<br/>', {}).appendTo(messageObj);
					}
				});
				// result += 1/total*100;
				// $(listid+' .result').val(result);
				// $(qspan).addClass('correct').text(answerObj.val());
				return true;
			} else {
				// if wrong checked
				messageObj.text(srquestionObj.data('hint')).removeClass(
						'correct-answer-hint')
						.addClass('incorrect-answer-hint');
				;
				checked.each(function(index, element) {
					data_hint = $(this).data('hint');
					if (data_hint.trim() != ''
							&& answers.indexOf($(this).val()) < 0) {
						jQuery('<br/>', {}).appendTo(messageObj);
						messageObj.append(data_hint);
					}
				});
				return false;
			}

		} else if (srquestionObj.find("input[type=radio]").length > 0) {

			// radio button
			messageObj = srquestionObj.children('.message');
			var selected = srquestionObj.find("input[type=radio]:checked");
			if (selected.length == 0) {
				// nothing selected
				messageObj.text(srquestionObj.data('hint')).removeClass(
						'correct-answer-hint')
						.addClass('incorrect-answer-hint');
				;
				return false;
			} else if (selected.val() != srquestionObj.data('answer')) {
				// incorrect
				messageObj.text(srquestionObj.data('hint')).removeClass(
						'correct-answer-hint')
						.addClass('incorrect-answer-hint');
				;
				data_hint = selected.data('hint');
				if (data_hint.trim() != '') {
					jQuery('<br/>', {}).appendTo(messageObj);
					messageObj.append(data_hint);
				}
				return false;
			} else { // correct
				data_hint = selected.data('hint');
				if (data_hint.trim() != '') {
					messageObj.text(data_hint).removeClass(
							'incorrect-answer-hint').addClass(
							'correct-answer-hint');
					;
				}
				return true;
			}

		} else if (srquestionObj.prop('type') == 'select-one') {// select list
			messageObj = srquestionObj.parent().children('.message');
			data_hint = srquestionObj.find(':selected').data('hint');
			if (srquestionObj.data('answer') == srquestionObj.val()) { // correct
				if (data_hint.trim() != '') {
					messageObj.text(data_hint).removeClass(
							'incorrect-answer-hint').addClass(
							'correct-answer-hint');
					;
				}
				return true;
			} else { // incorrect
				messageObj.text(srquestionObj.data('hint')).removeClass(
						'correct-answer-hint')
						.addClass('incorrect-answer-hint');
				if (data_hint != null) {
					if (data_hint.trim() != '') {
						jQuery('<br/>', {}).appendTo(messageObj);
						messageObj.append(data_hint);
					}
				}
				return false;
			}

		} else {// nothing
			return true;
		}
	}

	$('.check-answer')
			.click(
					function() {
						$(this).button('loading');
						var srquiz = $(this).parents('.srquiz');
						var srquestion_list = srquiz.find('.srquestion');

						var total_question = srquiz.children('.total-question')
								.val();
						var resultObj = srquiz.children('.result');
						var result = parseFloat(resultObj.val());

						for (var i = 0; i < srquestion_list.length; i++) {
							// questionObj = $(qid);
							result = checkSrquestion($(srquestion_list[i]),
									total_question, resultObj, result);
							/*
							 * because srquiz.find('.question') returns DOM
							 * element and not JQuery element alert("i is "+i+"
							 * --- "+questionObj.val());
							 */
						}// end for loop

						var incorrect = '';
						result = Math.ceil(result.toFixed(4) * 100) / 100;
						if (result < 100)
							incorrect = '<break>Những câu trả lời không chính xác <break>được chừa lại để bạn chỉnh sửa.';
						else
							result = 100;
						showalert('Bạn đã hoàn tất ' + result + '%. '
								+ incorrect.replace(/break/g, 'br/'), 'success');
						var _srquizalert = srquiz.find('.alert');
						if (_srquizalert.length > 0) {
							_srquizalert[0].textContent = ('Bạn đúng được '
									+ result + '%. ' + incorrect.replace(
									/<break>/g, ''));
						}
						qProcessor('checkanswer',result);
						$(this).button('reset');
					});
	function calculateResult(resultObj, result, total_question, inputtype) {
		result += (1 / total_question) * 100;
		resultObj.val(result);
		return result;
	}
	function checkSrquestion(srquestionObj, total_question, resultObj, result) {
		// var srquestionObj = jqObj;

		// fid = '#list-1 input[name="4-f-male"]';
		if (!srquestionObj.is('input:text')) {
			// not input text hint
			if (srquestionObj.find("input[type=checkbox]").length > 0) {
				// checkbox hint
				var checked = srquestionObj
						.find("input[type=checkbox]:checked");
				// an array containing values of all
				// checked inputs
				var values = checked.map(function() {
					return this.value
				}).get();
				var answers = srquestionObj.data('answer').split(',');
				if ($(values).not(answers).length == 0
						&& $(answers).not(values).length == 0) {
					// ///////////////////////////////////////////////
					result = calculateResult(resultObj, result, total_question);
					// ///////////////////////////////////////////////
					var _x = 0;
					srquestionObj
							.find("input[type=checkbox]")
							.each(
									function(index, element) {
										focusNextSrquestion(srquestionObj);
										if ($(this).is(':checked')) {
											qProcessor('submitTF', $(this),
													true);
											_span_text = $(this).next("span")
													.text();
											$(this).next("span").remove();

											$(this)
													.replaceWith(
															'<span class="correct btn disabled">'
																	+ _span_text
																	+ ((_x == 0) ? ' &nbsp;&nbsp; '
																			: '')
																	+ ' </span>');
										} else {
											$(this).parent().remove();
										}

										_x++;
									});
					;

				} else {/* if wrong checked DO NOTHING */

					qProcessor('submitTF', srquestionObj.find(
							"input[type=checkbox]").first(), false);
				}
			} else if (srquestionObj.find("input[type=radio]").length > 0) {
				// radio button
				var selected = srquestionObj.find("input[type=radio]:checked");
				if (selected.length > 0)
					if (selected.val() == srquestionObj.data('answer')) {
						// correct
						result = calculateResult(resultObj, result,
								total_question);
						var _x = 0;
						srquestionObj
								.find("input[type=radio]")
								.each(
										function(index, element) {
											if ($(this).is(':checked')) {
												focusNextSrquestion(srquestionObj);
												qProcessor('submitTF', $(this),
														true);
												_span_text = $(this).next(
														"span").text();
												$(this).next("span").remove();

												$(this)
														.replaceWith(
																'<span class="correct btn disabled">'
																		+ _span_text
																		+ ((_x == 0) ? ' &nbsp;&nbsp; '
																				: '')
																		+ ' </span>');
											} else {
												$(this).parent().remove();
											}
											_x++;
										});// end of each
						// JQuery

					} else {
						qProcessor('submitTF', srquestionObj.find(
								"input[type=radio]").first(), false);
					}
			} else {// select list hint

				if (srquestionObj.data('answer') == srquestionObj.val()) { // correct
					result = calculateResult(resultObj, result, total_question);
					focusNextSrquestion(srquestionObj);
					$(srquestionObj).replaceWith(
							'<span class="correct">'
									+ srquestionObj.find(':selected').text()
									+ ' </span>');
					qProcessor('submitTF', srquestionObj, true);
				} else { // incorrect DO NOTHING
					qProcessor('submitTF', srquestionObj, false);
				}

			}
		} else { // input text hint
			var answer = srquestionObj.data('answer').toLowerCase().trim();
			var question = srquestionObj.val().trim();
			if (question == answer) {
				result = calculateResult(resultObj, result, total_question);
				focusNextSrquestion(srquestionObj);
				srquestionObj.replaceWith('<span class="correct">' + answer
						+ '</span>');
				qProcessor('submitTF', srquestionObj, true);
			} else {
				qProcessor('submitTF', srquestionObj, false);
			}
		}// end input text hint in if-else check input
		// type

		return result;
	}
	function focusNextSrquestion(srquestionObj) {
		srquestionlist = srquestionObj.parents().find('.srquestion');
		if (srquestionlist.length > 1) {
			srqIndex = srquestionlist.index(srquestionObj);
			if (srqIndex + 1 >= srquestionlist.length) {
				srqIndex = 0;
			} else {
				srqIndex++;
			}
			nextElement = srquestionlist[srqIndex];
			// dump(nextElement);
			nextElementjqObj = $(nextElement);
			if (nextElementjqObj.is('select')) {
				nextElement.focus();
			} else if (nextElementjqObj.is('input')) {
				nextElement.focus();
			} else if (nextElementjqObj.is('span')) {
				nextElementjqObj.find('input').first().focus();
			} else {
				focusNextSrquestion(nextElementjqObj);
			}
			// alert(srqIndex);
			// dump([1]);//.focus();
		}
	}

}