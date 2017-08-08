// /////////////////////// AUDIO //////////////////////////
var SAudio = {
    currentTime: 0,
    start: -1,
    end: -1,
    shared: false,
    song_cache: []
};

var stratList = [];
var song_paused = true;
// var song_cache = [];
// var audio_server_url = 'http://localhost/001/social-teaching/joomla/file-server';
// inner variables
// var song_list = ['01','02','03','04','05','06','07'];
var song_list = [];
var song_index;
var song = null;
var auto_next = false;

function playOnEnded(_auto_next) {
    auto_next = _auto_next;
}

function clearAudioStyle(playlistJQ) {
    playlistJQ.removeClass("word-played");
    playlistJQ.removeClass("phrase-played");
    playlistJQ.removeAttr("style");
    return playlistJQ;
}

function initAudio(alias) {
    if (alias != undefined && alias != null && alias != '#'
        && alias.trim().length > 0) {

        var _scache = SAudio.song_cache[alias];
        if (_scache == undefined || _scache == null) {
            SAudio.song_cache[alias] = new Audio(audio_server_url
                + '/file.php?f=' + alias + '.mp3');
        } else {
        }
        song = SAudio.song_cache[alias];
    }
    // song = new Audio(audio_server_url + '/file.php?ext=mp3&alias=' + alias);//
    // song_cache[alias];
    // song = document.getElementById('globalaudio');

    // song.src = audio_server_url + '/file.php?ext=mp3&alias=' + alias;
    if (song != undefined && song != null) {
        jQuery(song).off();
    }

    // song.removeEvent
    // jQuery("#globalaudio");
    // timeupdate event listener

}

function seekAudio(pos) {
    if (song != undefined && song != null) {
        song.currentTime = pos;
    }
}

function playAudio() {
    if (song != undefined && song != null) {
        song.play();
    }
}

function stopAudio() {
    if (song != undefined && song != null) {
        song.pause();
    }
}

function changeMessage(playlistObj, message) {
    playlistObj.children('.message').text(message).append("<hr/>");
}

function repeatPhrase(list, begin, end, _repeatfinishCallBack, _delay) {
    setTimeout(function () {
        var _i = begin
        if (_i < end) {
            // phraselist[i][0].attr('id'));
            // phraselist[_i][0].show();
            playPhrase(list[_i].data('audioalias'), function () {
                    repeatPhrase(list, ++_i, end, _repeatfinishCallBack, _delay);
                }// end callback function nghe tung cau
                , _delay);
        } else {
            // playPhraseList(_phraselist,list,end,function(){},_delay);
            _repeatfinishCallBack();
        }
    }, _delay);
}

var phraseCurrentIndex = [];

function playPhraseList(_plist, index_to_play, _onendedCallBack,
                        _phraseEffectCallBack, _delay, _type, _shared) {
    setTimeout(
        function () {
            if (song_paused == false) {
                phraseCurrentIndex[jQuery(_plist[0][0]).attr('id')] = index_to_play;
                var i = index_to_play;
                if (i < _plist.length) {
                    _phraseEffectCallBack(_plist[i]);
                    ++i;
                    if (_type == 1) {
                        playPhrase(_plist[i - 1].data('audioalias'),
                            function () {
                                repeatPhrase(_plist, 1, i, function () {
                                    playPhraseList(_plist, i,
                                        _onendedCallBack,
                                        _phraseEffectCallBack,
                                        _delay, _type, _shared)
                                }, 500);
                            }, _delay, _shared);
                    } else if (_type == 0) {
                        playPhrase(_plist[i - 1].data('audioalias'),
                            function () {
                                playPhraseList(_plist, i,
                                    _onendedCallBack,
                                    _phraseEffectCallBack, _delay,
                                    _type, _shared)
                            }, _delay, _shared);
                    }
                } else {
                    phraseCurrentIndex[jQuery(_plist[0][0]).attr('id')] = null;
                    _onendedCallBack();
                    jQuery('.startPlaylist').button('reset');
                }
            }
        }, _delay);
}

function playPhrase(audioalias, _onendedCallBack, _delay, range) {
    if (range == undefined || range == null) {
        range = -1;
        stopAudio();
        initAudio(audioalias);
        jQuery(song).on('ended', function () {
                setTimeout(_onendedCallBack(), _delay);
                // alert('in phrase ' + audioalias);
            }// end callback function nghe toan bai
        );
        playAudio();
    }

}

function playAudioParent(audioalias, _onendedCallBack, _delay,
                         _ontimeupdateCallBack) {

    setTimeout(
        function () {
            // playlistJQ = _playlist;
            // Nghe toan bai
            stopAudio();
            initAudio(audioalias);
            playAudio();
            jQuery(song).on('ended', function () {
                    setTimeout(_onendedCallBack(), _delay);
                    // alert(audioalias);
                }// end callback function nghe toan bai
            );
            if (_ontimeupdateCallBack != undefined
                && _ontimeupdateCallBack != null) {
                jQuery(song).on('timeupdate', _ontimeupdateCallBack);
            }

        }, _delay);

}

function playNextAudio() {
    stopAudio();

    var next = song_index + 1;
    if (next >= song_list.length) {
        next = 0
    }
    initAudio(next);
    playAudio();
}
