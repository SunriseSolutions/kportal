function playStratRepeat(plindex, playlist) {
//reset_css = {'color':'black','font-weight':'normal'};
    playlistJQ = playlist[plindex][0][0];
    phraselist = playlist[plindex];
    var plist = [];
    for (_x = 0; _x < phraselist.length; _x++) {
        plist[_x] = phraselist[_x][0];
    }

    // Nghe toan bai
    // reset show hide to fit the strategy
    for (i = 0; i < phraselist.length; i++) {
        for (j = 0; j < phraselist[i].length; j++) {
            // phraselist[i][j].removeAttr("style").show();
            clearAudioStyle(phraselist[i][j]).show();
        }

    }
    // playlistJQ.removeAttr("style").show();
    clearAudioStyle(playlistJQ).show();


//	playlist[plindex][0][0].children('.message').text("Nghe toàn bài").append("<hr/>");
    changeMessage(playlist[plindex][0][0], 'Nghe toàn bài');
    playAudioParent(playlist[plindex][0][0].data('audioalias'), function () {
            // Nghe tung cau
            // reset show hide to fit the strategy
            // iterate phrase
            for (i = 1; i < phraselist.length; i++) {
                // phraselist[i][0].removeAttr("style").hide();
                clearAudioStyle(phraselist[i][0]).hide();
                // iterate subphrase
                for (j = 1; j < phraselist[i].length; j++) {
                    // phraselist[i][j].removeAttr("style").show();
                    clearAudioStyle(phraselist[i][j]).show();
                }
            }

            changeMessage(playlist[plindex][0][0], 'Nghe từng câu một');
            _nghetungcau(phraselist, plist, 1);

        }// end callback function nghe toan bai
        , 1000); // end

    // end
    phraselist = playlist[plindex];
    // _nghetungtu(phraselist, 1);
    // /////////////// nghe tung cau ///////////////////////
    function _nghetungcau(_phraselist, _plist, index) {
        playPhraseList(_plist, index, function () {
            // Nghe tung tu
            // reset show hide to fit the strategy
            // iterate phrase
            for (i = 1; i < _phraselist.length; i++) {
                // _phraselist[i][0].removeAttr("style").hide();
                clearAudioStyle(_phraselist[i][0]).hide();
                // iterate subphrase
                for (j = 1; j < _phraselist[i].length; j++) {
                    // _phraselist[i][j].removeAttr("style").show();
                    clearAudioStyle(_phraselist[i][j]).show();
                }
            }

            changeMessage(playlist[plindex][0][0], 'Tách từng từ riêng biệt');
            _nghetungtu(phraselist, 1);

        }, function (obj) {
            obj.show();
        }, 1000, 1);
    }

    // /////// END nghe tung cau /////////////////////


    // //////// NGHE TUNG TU //////////////////////
    function _nghetungtu(phraselist, phraseindex) {
        var i = phraseindex;
        //console.log('1 i is '+i);
        setTimeout(function () {
            if (i < phraselist.length) {
                var _plist1 = [];
                for (_x = 0; _x < phraselist[i].length; _x++) {
                    _plist1[_x] = phraselist[i][_x];
                }

                phraselist[i][0].show();
                //console.log('2 i is '+i);
                playPhrase(phraselist[i][0].data('audioalias'), function () { //console.log('3 i is '+i);
                    playPhraseList(_plist1, 1, function () { //console.log('4 i is '+i);
                        playPhrase(phraselist[i][0].data('audioalias'), function () { //console.log('5 i is '+i);
                            for (_x = 0; _x < _plist1.length; _x++) {
                                // _plist1[_x].removeAttr("style");
                                clearAudioStyle(_plist1[_x]);
                            }
                            // _plist1[0].css({'color':'darkred'});
                            _plist1[0].addClass('phrase-played');

                            repeatPhrase(plist, 1, i + 1, function () {
                                _nghetungtu(phraselist, i + 1);
                            }, 500);
                        }, 500);
                    }, function (obj) {
                        // obj.css({'color':'darkblue','font-weight':'bold'});
                        obj.addClass('word-played');
                    }, 500, false);

                }, 500);

            } // i is >= phraselist.length;
            else { // da nghe het doan hoi thoai
                changeMessage(playlist[plindex][0][0], 'Nghe lại lần cuối');
                playAudioParent(playlist[plindex][0][0].data('audioalias'), function () {
                    changeMessage(playlist[plindex][0][0], 'Kết thúc bài nghe');
                    // reset to default style
                    for (i = 0; i < phraselist.length; i++) {
                        for (j = 0; j < phraselist[i].length; j++) {
                            // phraselist[i][j].removeAttr("style").show();
                            clearAudioStyle(phraselist[i][j]).show();
                        }
                    }
                    clearAudioStyle(playlistJQ).show();
                }, 1000);
            }

        }, 500);

    }

    // ////////////////////// END Nghe tung tu ////////////////////////////
}///// STRATEGY 1
