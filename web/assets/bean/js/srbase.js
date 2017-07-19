/**
 * Of course, it has to be in noconflict mode
 */

var backURL = undefined;
var checkOnChange = true;
var hintOnChange = true;

function parseUrlToObj(url) {
    var url = url.substring(url.indexOf('?') + 1);
    var arr1 = url.split('&');
    var arr2 = [];
    var obj = {};
    for (var i = 0; i < arr1.length; i++) {
        arr2[i] = arr1[i].split('=');
    }
    for (var i = 0; i < arr2.length; i++) {
        obj[arr2[i][0]] = arr2[i][1];
    }
    return obj;
}

function srAjax(ajaxNavURL, ajaxLayout, callback, modal, params) {
    if (modal == true) {
        if (!ajaxLayout.hasClass('modal')) {
            ajaxLayout.addClass('modal');
            ajaxLayout.data('backdrop', 'static');
            ajaxLayout.attr('role', 'dialog');
            ajaxLayout.attr('aria-hidden', 'true');
            preHtml = '<div class="modal-header">';
            preHtml += '<button type="button" class="close" data-dismiss="modal"';
            preHtml += ' aria-hidden="true">×</button>';
            preHtml += '</div>';
            ajaxLayout.prepend(preHtml);
        }
        ajaxLayout.modal();
    }

    loadingHtml = ' <div id="courseLoading" style="font-size:16px; background-color:white; layer-background-color:white; height:100%; width:100%;"><TABLE width=100% height=100% align="center" valign="center"><TR valign="center"><TD align="center">  Chờ xíu nhé...  <br/><img src="'
        + sroot
        + 'media/sunrise/images/ajax-loader.gif" /> </TD></TR></TABLE></div>';
    ajaxLayout.children().last().replaceWith(loadingHtml);
    ajaxNavURL += '&srctrler=ajax&format=raw';
    jQuery.ajax({
        url: ajaxNavURL,
        // + "media/sunrise/json/handbook/user01.handbook01",
        success: function (result) {
            callback(result, ajaxNavURL, ajaxLayout, modal, params);
        }
    });

}

jQuery(document)
    .ready(
        function ($) {
            // $('#modalLoading').ajaxStart(function() {
            // $(this).show(); // show Loading Div
            // }).ajaxStop(function() {
            // $(this).hide(); // hide loading div
            // });

            // //////////////// SRHANDBOOK QUIZ
            // ///////////////////////////////
            jQuery(
                '<div id="srhandbook-quiz" class="fade hide"><div>quizholder</div></div>',
                {}).appendTo('body');

            $('.srkbupractice')
                .click(
                    function (e) {
                        e.preventDefault();
                        var kbucode = $(this).data('srkbucode');
                        var questionListURI = sroot
                            + 'index.php?option=com_srhandbook&view=srkbucode&srctrler=ajax&format=raw&task=quiz&code='
                            + kbucode;
                        srhandbookQuiz = $('#srhandbook-quiz');
                        ajaxQuiz(srhandbookQuiz,
                            questionListURI, 0);
                        // srhandbookQuiz.modal();
                    });

            // //////////////// END OF SRHANDBOOK QUIZ
            // ///////////////////////////////
            // //////////////// AFFIX
            // ///////////////////////////////
            _affix = $('.bs-docs-sidebar');
            // alert(olaffix.length);
            jQuery(
                '<ol class="affix" data-spy="affix" data-offset-top="40">',
                {}).appendTo(_affix);
            olaffix = _affix.children('ol');
            $('.srconsec').each(
                function (i, e) {
                    _str = '<li><a href="#'
                        + $(this).attr('id')
                        + '" data-original-title="" title="">'
                        + $(this).find(".srconsec-heading")
                            .text() + '</a></li>';
                    jQuery(_str, {}).appendTo(olaffix);
                });

            // //////////////// END OF AFFIX
            // ///////////////////////////////
            $('[title]').tooltip();
            $('span[data-content]').popover({
                placement: 'bottom'
            });
            // $('#sr_tab a:last').tab('show');

            initialiseTabs();

            selectTabsFromHash(window.location.hash);

            // //////////////// SORT TABLES
            // ///////////////////////////////
            // $(".tablesorter").tablesorter( {sortList: [[0,0]],
            // widgets: ['zebra']});
            $(".tablesorter").each(function (i, e) {
                this_table = $(e);
                if (this_table.next().hasClass('pager')) {
                    this_table.tablesorter({
                        sortList: [[0, 0]],
                        widthFixed: true,
                        widgets: ['zebra']
                    }).tablesorterPager({
                        container: this_table.next(),
                        size: 40
                    });
                } else {
                    this_table.tablesorter({
                        sortList: [[0, 0]],
                        widthFixed: true,
                        widgets: ['zebra']
                    });
                }

            });

            // //////////////END OF SORT TABLES
            // ///////////////////////////////

            // ///////////////// FILTER TABLES
            // /////////////////////////////
            // $('.tablefilter').filterTable();

            // ///////////////// END OF FILTER TABLES
            // /////////////////////////////

            // /////////////// MEMORY MATCHING GAME
            // //////////////////////
            // $('#tutorial-memorygame').quizyMemoryGame({
            //     openDelay: 1000,
            //     itemWidth: 156,
            //     itemHeight: 156,
            //     itemsMargin: 5,
            //     colCount: 4,
            //     animType: 'none',
            //     resultIcons: true
            // });
            // /////////////// END OF MEMORY MATCHING GAME
            // ///////////////
            // ////////////// AUDIO //////////////////////
            $('[data-audioalias]').each(function (index, element) {
                // var this_class = $(this).attr('class');
                // var audioName = $(this).data("audioalias");
                // var audioId = $(this).attr('id');
                // // console.log( $( this ).text() );
                // song_list[audioId] = audioName;

                initAudio($(this).data("audioalias"));
            });
            // alert(playAudio_list.length);
            $('.playAudioOnClick').click(function () {
                var audioalias = $(this).data('audioalias');
                stopAudio();
                initAudio(audioalias);
                playAudio();
            });

            $('.playlist [data-audioalias]')
                .click(
                    function (e) {
                        e.preventDefault();
                        if ($(this).parent().hasClass(
                                'playlist')) {
                            var plid = $(this).parent().attr(
                                'id');
                            var phraseIndex = $(this).index();
                            // alert($(this).index()
                            // + " "
                            // + plid + " "
                            // + phraseCurrentIndex[plid]);
                            phraseCurrentIndex[plid] = $(this)
                                .index();

                            stopAudio();
                            var audioalias = $(this).data(
                                'audioalias');
                            initAudio(audioalias);

                            if (audioalias == '#') {
                                initAudio($(this).parent()
                                    .data('audioalias'));


                                var plindex = plid;
                                var playlistJQ = playlist[plindex][0][0];
                                var phraselist = playlist[plindex];
                                var plist = [];
                                for (var _x = 0; _x < phraselist.length; _x++) {
                                    plist[_x] = phraselist[_x][0];
                                }

                                var _audiorange = $(this).data(
                                    'audiorange');
                                var _rangearray = _audiorange
                                    .split(';');
                                var _x1 = _rangearray[0];
                                var _x2 = _rangearray[1];
                                try {
                                    seekAudio(_x1);
                                } catch (e) {
                                    console.log(e.message);
                                }
                                var _pci = $(this).index();

                                if (_pci < plist.length - 1) {
                                    _audiorange = jQuery(
                                        plist[_pci + 1][0])
                                        .data('audiorange');
                                    _rangearray = _audiorange
                                        .split(';');
                                    var _y1 = _rangearray[0];
                                    var _y2 = _rangearray[1];

                                }

                                playAudioParent(
                                    audioalias,
                                    function () {// on ended
                                    },
                                    0,
                                    function () {

                                        var _audiorange = jQuery(
                                            plist[_pci][0])
                                            .data(
                                                'audiorange');
                                        var _rangearray = _audiorange
                                            .split(';');
                                        var _x1 = _rangearray[0];
                                        var _x2 = _rangearray[1];
                                        if (_x1 < song.currentTime) {
                                            var phraseObj = jQuery(plist[_pci][0]);
                                            jQuery("body")
                                                .scrollTop(
                                                    phraseObj
                                                        .offset().top - 40);
                                            phraseObj
                                                .css({
                                                    'color': 'darkred'
                                                });
                                            phraseObj
                                                .show();
                                        }

                                        if (_x2 > 0
                                            && song.currentTime >= _x2) {
                                            song.pause()
                                        }
                                        if (_y1 != undefined
                                            && _y1 != null
                                            && song.currentTime >= _y1) {
                                            song.pause();
                                        }

                                        ;

                                        jQuery("#globaldiv")
                                            .text(
                                                song.currentTime
                                                + " plist.length"
                                                + plist.length
                                                + " _pci "
                                                + _pci
                                                + "phraseCurrentIndex[jQuery(plist[0][0]).attr('id')]"
                                                + phraseCurrentIndex[jQuery(
                                                    plist[0][0])
                                                    .attr(
                                                        'id')]
                                                + " --- x1 is  "
                                                + _x1
                                                + "		 --- y1 is  "
                                                + _y1
                                                + " --- audiorange index 2  "
                                                + jQuery(
                                                    plist[2][0])
                                                    .data(
                                                        'audiorange'));
                                        // SAudio.currentTime
                                        // =
                                        // song.currentTime;
                                    });
                            }

                            playAudio();
                            $('.startPlaylist').button('reset');
                            var phraselist = playlist[plid];
                            for (var i = 1; i < phraseIndex + 1; i++) {
                                phraselist[i][0].css({
                                    'color': 'darkred'
                                }).show();
                                // iterate subphrase
                                for (var j = 1; j < phraselist[i].length; j++) {
                                    phraselist[i][j].css({
                                        'color': 'darkred'
                                    }).show();
                                }
                            }
                            for (var i = phraseIndex + 1; i < phraselist.length; i++) {
                                phraselist[i][0].removeAttr(
                                    "style").show();
                                // iterate subphrase
                                for (var j = 1; j < phraselist[i].length; j++) {
                                    phraselist[i][j]
                                        .removeAttr("style")
                                        .show();
                                }
                            }
                            song_paused = true;

                        }
                    });

            // initialization - first element in playlist

            // play click
            $('.play').click(function (e) {
                e.preventDefault();
                playAudio();
            });

            // pause click
            $('.pause').click(function (e) {
                e.preventDefault();
                stopAudio();
            });

            // /////////////// PLAYLIST - DIALOGUE - TEXTE Play
            // Strategies
            // //////////////////////
            var playlist = [];
            // var phraselist = [];

            // var audioitemlist = [];

            // pli 0 0 is div jobject
            // pli 1 0 is span object for phrase
            // pli 1 1 is span object for subphrase

            $('.playlist')
                .each(
                    function (index, element) {

                        playlist_index = $(this).attr('id');
                        playlist[playlist_index] = [];
                        playlist[playlist_index][0] = [];
                        playlist[playlist_index][0][0] = $(this);
                        // $(this).hide();
                        $(this)
                            .children('[data-audioalias]')
                            .each(
                                function (index1,
                                          element1) {
                                    playlist[playlist_index][index1 + 1] = [];
                                    playlist[playlist_index][index1 + 1][0] = $(this);
                                    // $(this).hide();

                                    // item list -
                                    // subphrase list
                                    $(this)
                                        .children(
                                            '[data-audioalias]')
                                        .each(
                                            function (index2,
                                                      element1) {
                                                playlist[playlist_index][index1 + 1][index2 + 1] = $(this);
                                                // $(this).hide();

                                            });
                                });

                        // event

                    });

            $('.startPlaylist').click(
                function (e) {
                    e.preventDefault();

                    var methodName = $(this).data("playstrat");
                    if (song_paused == true) {
                        song_paused = false;
                        window['playStrat'
                        + methodName.charAt(0)
                            .toUpperCase()
                        + methodName.slice(1)]($(this)
                            .data("playlist"), playlist);
                        $(this).button('playing');
                    } else if (song_paused == false) {
                        song_paused = true;
                        stopAudio();
                        $(this).button('clicktoplay');
                    }

                });// end for click

            $('.startPlaylist').each(
                function () {
                    var methodName = $(this).data("playstrat");
                    if (!stratList.hasOwnProperty(methodName)) {
                        stratList[methodName] = 1;
                        jQuery.getScript(sroot
                            + '/media/sunrise/js/audio-strats/'
                            + methodName + '.js', function () {
                        });
                    }
                });

        });

function initialiseTabs() {
    jQuery('.nav-tabs' + ' a').click(
        function (e) {
            e.preventDefault();
            window.history.pushState(jQuery(this).attr('href'),
                jQuery(this).attr('href'), buildURLHash(jQuery(this)));
            jQuery(this).tab('show');
        });

    jQuery('.srtab-jump').click(
        function (e) {
            var wlocation = window.location.href + '#';
            e.preventDefault();
            a_tag = jQuery(this);
            window.history.pushState(a_tag.attr('href'),
                a_tag.attr('href'), wlocation.substring(0, wlocation
                    .indexOf('#'))
                + a_tag.attr('href'));
            var tag_selected = selectTabsFromHash(a_tag.attr('href'));
            jQuery("body").scrollTop(tag_selected.offset().top);
        });
}
function buildURLHash(queryObj) {
    var wlocation = window.location.href + '#';
    level = queryObj.parents('ul').data('srtablevel');

    return wlocation.substring(0, wlocation.indexOf('#')) + '#'
        + helper("", 1, level, queryObj);
    function helper(_harsh, counter, level, _obj) {
        if (counter <= level) {
            if (counter == 1) {
                _harsh += _obj.attr('href').substring(1);
            } else {
                _harsh = _obj.attr('id') + '/' + _harsh;
            }
            counter++;
            return helper(_harsh, counter, level, _obj.parents('.tab-pane'));
        } else {
            return _harsh;
        }
    }
}

function selectTabsFromHash(sr_hash) {

    var sr_hash_list = sr_hash.substring(1).split('/');
    var last_tag_selected = null;
    sr_hash_list_length = sr_hash_list.length;
    if (sr_hash_list_length > 0)
        for (var i = 0; i < sr_hash_list_length; i++) {
            last_tag_selected = selectTabs(sr_hash_list[i]);
        }
    return last_tag_selected;
}
function selectTabs(tagNAME) {// select tab by its name or href, tagNAME must
    // be unique because it links to the tab content
    // id
    // var i = level + 1;
    if (tagNAME !== '') {
        sr_tab = '.nav-tabs' + ' a[href=#' + tagNAME + ']';
        jQuery(sr_tab).tab('show'); // Select tab by name
        return jQuery(sr_tab);
    }
    return null;
}
function mapObjToArray(obj) {
    return jQuery.map(obj, function (value, index) {
        return [value];
    });
}

function dump(obj) {
    var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }

    // alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}
function stripHTML(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}

function buildQuestionHtml(qData, params) {
    // isEmbedded = (params['embedded']==undefined?)
    // alert(params); => undefined
    // var params = [];
    // alert(params['embedded']); => undefined
    var isEmbedded = false;
    var kbucode = qData.kbucode;
    if (params != undefined) {
        if (params['embedded'] != undefined) {
            isEmbedded = params['embedded'];
        }
        if (params['kbucode'] != undefined) {
            kbucode = params['kbucode'];
        }
    }
    var qhtml = '';

    if (qData.qtype == 'multianswer') {
        var correctans = qData.correctanswer[0];
        var _qtext = qData.questiontext;

        var _qlist = qData.questionlist;
        var _qlistLength = qData.questionlist.length;
        var _qhtml_multianswer = "";
        var _params = [];
        for (var _x = 0; _x < _qlistLength; _x++) {
            var _multichoiceQuestiontext = _qlist[_x].questiontext;
            _params['embedded'] = true;
            _params['kbucode'] = kbucode;
            if (_multichoiceQuestiontext.indexOf('MULTICHOICE_') < 0) {
                if (_multichoiceQuestiontext.indexOf('MULTICHOICE') > -1) {
                    _qlist[_x].qtype = 'selectbox';
                }
            }
            _qhtml_multianswer = buildQuestionHtml(_qlist[_x], _params);
            _qtext = _qtext.replace('{#' + (_x + 1).toString() + '}',
                _qhtml_multianswer);

        }
        qhtml += _qtext;
        // 'no no no<strong>aaa</strong><br/>' + _qhtml_multianswer);

        // qhtml += '<span>';
        // qhtml += '<input class="srquestion check-qtext" data-live="1" name="'
        // + qData.id + '" type="text" value="" style="width:'
        // + (correctans.length * 6.25 + 2) + 'px" data-answer="'
        // + correctans + '" />';
        // qhtml += '</span> ';
    } else if (qData.qtype == 'shortanswer') {
        correctans = qData.correctanswer[0];
        if (!isEmbedded) {
            qhtml += qData.questiontext;
        }
        qhtml += '<span>';
        qhtml += '<input ' + '"  class="srquestion '
            + (true ? 'check-qtext ' : ' ') + '" data-live="1" name="'
            + qData.id + ';' + kbucode
            + '" type="text" value="" style="width:'
            + (correctans.length * 6.25 + 2) + 'px" data-answer="'
            + correctans + '" />';
        qhtml += '</span>  ';
    } else if (qData.qtype == 'match') {
        if (!isEmbedded) {
            qhtml += stripHTML(qData.questiontext);
        }
        subquestionlist = qData.subquestionlist;
        qhtml += '<br/><span>';
        for (_j = 0; _j < subquestionlist.length; _j++) {
            var _subq = subquestionlist[_j];
            qhtml += '<span class="shuffle-match' + qData.id + '" >';
            qhtml += stripHTML(_subq.question);

            qhtml += ' <select ' + '" class="srquestion '
                + (hintOnChange ? 'hint-choice ' : ' ')
                + (checkOnChange ? 'check-choice ' : ' ')
                + '" name="match-' + qData.id + '-'
                + stripHTML(_subq.subid) + ';' + kbucode + '" data-hint="'
                + stripHTML(qData.generalfeedback) + '" data-answer="'
                + stripHTML(_subq.answer) + '" id="6-q">';
            qhtml += '   <option value="none" data-hint="Vui lòng chọn câu trả lời đúng" >--- select ---</option>';
            for (_k = 0; _k < subquestionlist.length; _k++) {
                qhtml += '<option value="'
                    + stripHTML(subquestionlist[_k].answer)
                    + '" data-hint="Câu trả lời '
                    + ((_k != _j) ? 'chưa' : '') + ' chính xác" >'
                    + stripHTML(subquestionlist[_k].answer) + '</option>';
            }
            qhtml += '</select>';
            qhtml += ' <span class="message"></span><br/>';
            qhtml += '</span>';

        }

        qhtml += '</span>';

    } else if (qData.qtype == 'multichoice') {
        _isSingle = qData.single;
        _typeArr = ['checkbox', 'radio'];
        if (_isSingle == 1) {
            correctans = qData.correctanswer[0];
        } else if (_isSingle == 0) {

            var _arr = [];
            for (_j = 0; _j < qData.correctanswer.length; _j++) {
                _arr[_j] = qData.correctanswer[_j];
            }
            correctans = _arr.join(',');
        }
        anslist = qData.answerlist;
        anslistLength = anslist.length;
        qhtml += '<span   data-hint="' + stripHTML(qData.generalfeedback)
            + '" data-answer="' + correctans + '"  class="srquestion '
            + (hintOnChange ? 'hint-choice ' : ' ')
            + (checkOnChange ? 'check-choice ' : ' ') + '">'
            + (!isEmbedded ? qData.questiontext : '') + '';
        for (_i = 0; _i < anslistLength; _i++) {
            if (qData.questiontext.indexOf('MULTICHOICE_V') > -1) {
                qhtml += '<br/>';
            }
            qhtml += '<label class="btn">';
            qhtml += '      <input   name="' + qData.id + ';' + kbucode
                + '" type="' + _typeArr[_isSingle] + '" value="'
                + anslist[_i].id + '" data-hint="'
                + stripHTML(anslist[_i].feedback) + '"/><span>'
                + stripHTML(anslist[_i].text) + '</span>';
            qhtml += '</label> ';

        }

        qhtml += '<br/>';
        qhtml += '<span class="message"></span>';
        qhtml += '</span>';

    } else if (qData.qtype == 'selectbox') {
        if (!isEmbedded) {
            qhtml += stripHTML(qData.questiontext);
        }
        subquestionlist = qData.answerlist;
        qhtml += '<br/><span>';
        qhtml += '<span class="selectbox-' + qData.id + '" >';

        qhtml += ' <select ' + '"  class="srquestion '
            + (hintOnChange ? 'hint-choice ' : ' ')
            + (checkOnChange ? 'check-choice ' : ' ') + '"' + ' name="'
            + qData.id + ';' + kbucode + '" data-hint="'
            + stripHTML(qData.generalfeedback) + '" data-answer="'
            + stripHTML(qData.correctanswer[0]) + '" >';

        qhtml += '  <option value="none" data-hint="Vui lòng chọn câu trả lời đúng" >--- select ---</option>';
        for (_j = 0; _j < subquestionlist.length; _j++) {
            var _subq = subquestionlist[_j];

            qhtml += '<option value="' + stripHTML(_subq.id)
                + '" data-hint="Câu trả lời '
                + ((_subq.id == qData.correctanswer[0]) ? '' : 'chưa')
                + ' chính xác" >' + stripHTML(_subq.text) + '</option>';
        }
        qhtml += '</select>';
        qhtml += '<span class="message"></span>';
        qhtml += '</span>';

        qhtml += '</span>';
    }
    return qhtml;
}

function srgetData(key, jqo) {
    var t1 = jqo.data(key);
    if (t1 != undefined && t1) {
        return t1;
    } else if (jqo.attr('data-' + key)) {
        return jqo.data(key);
    } else {
        return null;
    }
}
var toppanel = undefined;
function showalert(content, atype) {
    if (toppanel != undefined) {
        toppanel.close();
    }
    var n = noty({
        text: content,
        layout: 'top',
        type: atype
    });
    toppanel = n;
    setTimeout(function () {
        n.close();
    }, 3000);
}

function ucfirst(str) {
    return str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
        return letter.toUpperCase();
    });
}

function escapeRegExp(str) {
    return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

function replaceAll(find, replace, str) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}
