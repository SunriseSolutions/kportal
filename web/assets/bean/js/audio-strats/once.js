function playStratOnce(plindex, playlist) {
    // reset_css = {'color':'black','font-weight':'normal'};
    var playlistJQ = playlist[plindex][0][0];
    var phraselist = playlist[plindex];
    var plist = [];
    for (var _x = 0; _x < phraselist.length; _x++) {
        plist[_x] = phraselist[_x][0];
    }


    changeMessage(playlist[plindex][0][0], 'Nghe từng câu một');


    var _pci = phraseCurrentIndex[jQuery(plist[0][0]).attr('id')]
    if (_pci == undefined || _pci == null || _pci < 0) {
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

        // Nghe tung cau
        // reset show hide to fit the strategy
        // iterate phrase
        for (var i = 1; i < phraselist.length; i++) {
            // phraselist[i][0].removeAttr("style").show();
            clearAudioStyle(phraselist[i][0]).show();
            // iterate subphrase
            for (j = 1; j < phraselist[i].length; j++) {
                // phraselist[i][j].removeAttr("style").show();
                clearAudioStyle(phraselist[i][j]).show();
            }
        }
        _nghetungcau(phraselist, plist, 1);
    } else {
        _nghetungcau(phraselist, plist, _pci);
    }
    // end
    phraselist = playlist[plindex];
    // _nghetungtu(phraselist, 1);
    // /////////////// nghe tung cau ///////////////////////
    function _nghetungcau(_phraselist, _plist, index) {
        playPhraseList(_plist, index, function () {
            for (var i = 0; i < phraselist.length; i++) {
                for (var j = 0; j < phraselist[i].length; j++) {
                    // phraselist[i][j].removeAttr("style").show();
                    clearAudioStyle(phraselist[i][j]).show();
                }
            }
            song_paused = true;
            ;
        }, function (obj) {
            jQuery("body").scrollTop(obj.offset().top - 40);
            // obj.css({'color':'darkred'});
            obj.addClass('phrase-played');
            obj.show();

        }, 0, 0);
    }

    // /////// END nghe tung cau /////////////////////

}// /// STRATEGY 1
