function playStratSharesrc(plindex, playlist) {
    // reset_css = {'color':'black','font-weight':'normal'};
    playlistJQ = playlist[plindex][0][0];
    phraselist = playlist[plindex];
    var plist = [];
    for (var _x = 0; _x < phraselist.length; _x++) {
        plist[_x] = phraselist[_x][0];
    }


    changeMessage(playlist[plindex][0][0], 'Nghe từng câu một 1 AUDIo');

    playAudioParent(playlistJQ.data('audioalias'), function () {
        for (var i = 0; i < phraselist.length; i++) {
            for (var j = 0; j < phraselist[i].length; j++) {
                // phraselist[i][j].removeAttr("style").show();
                clearAudioStyle(phraselist[i][j]).show();
            }

        }
        // playlistJQ.removeAttr("style").show();
        clearAudioStyle(playlistJQ).show();
        // on ended
    }, 0, function () {
        var _pci = phraseCurrentIndex[jQuery(plist[0][0]).attr('id')]
        if (_pci == undefined || _pci == null || _pci < 0) {
            _pci = 1;
        }

        var _audiorange = jQuery(plist[_pci][0]).data('audiorange');
        var _rangearray = _audiorange.split(';');
        var _x1 = _rangearray[0];
        var _x2 = _rangearray[1];
        if (_x1 < song.currentTime) {
            var phraseObj = jQuery(plist[_pci][0]);
            jQuery("body").scrollTop(phraseObj.offset().top - 40);
            // phraseObj.css({'color':'darkred'});
            phraseObj.addClass('phrase-played');
            phraseObj.show();
        }


        if (_pci < plist.length - 1) {
            _audiorange = jQuery(plist[_pci + 1][0]).data('audiorange');
            _rangearray = _audiorange.split(';');
            var _y1 = _rangearray[0];
            var _y2 = _rangearray[1];

            if (_y1 < song.currentTime) {
                phraseCurrentIndex[jQuery(plist[0][0]).attr('id')] = _pci + 1;
            }
        }

//		jQuery("#globaldiv").text(song.currentTime +" plist.length "+plist.length+ " _pci "+_pci+" phraseCurrentIndex[jQuery(plist[0][0]).attr('id')] "+ phraseCurrentIndex[jQuery(plist[0][0]).attr('id')] + " --- "+ _x1 + " --- " + _y1 + " --- " + jQuery(plist[2][0]).data('audiorange'));
//		SAudio.currentTime = song.currentTime;
    });
    return;

}// /// STRATEGY 1
