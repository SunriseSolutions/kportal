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
var beanAudio = {};
beanAudio.currentAudio = {};
beanAudio.currentAudio.alias = '';
beanAudio.currentAudio.playing = false;

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

        beanAudio.currentAudio.alias = alias;
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

function isAudioPlaying() {
    return song !== undefined && !song.paused && song.currentTime > 0 && !song.ended;
}

// alert(playAudio_list.length);
jQuery('.playAudioOnClick').click(function () {
    var audioalias = jQuery(this).data('audioalias');
    if (beanAudio.currentAudio.alias !== audioalias) {
        stopAudio();
        initAudio(audioalias);
        playAudio();
    } else {
        if (isAudioPlaying()) {
            stopAudio();
        } else {
            playAudio();
        }
    }
});


// ////////////// AUDIO //////////////////////
jQuery('[data-audioalias]').each(function (index, element) {
    // var this_class = jQuery(this).attr('class');
    // var audioName = jQuery(this).data("audioalias");
    // var audioId = jQuery(this).attr('id');
    // // console.log( jQuery( this ).text() );
    // song_list[audioId] = audioName;

    initAudio(jQuery(this).data("audioalias"));
});


jQuery('.playlist [data-audioalias]')
    .click(
        function (e) {
            e.preventDefault();
            if (jQuery(this).parent().hasClass(
                    'playlist')) {
                var plid = jQuery(this).parent().attr(
                    'id');
                var phraseIndex = jQuery(this).index();
                // alert(jQuery(this).index()
                // + " "
                // + plid + " "
                // + phraseCurrentIndex[plid]);
                phraseCurrentIndex[plid] = jQuery(this)
                    .index();

                stopAudio();
                var audioalias = jQuery(this).data(
                    'audioalias');
                initAudio(audioalias);

                if (audioalias == '#') {
                    initAudio(jQuery(this).parent()
                        .data('audioalias'));


                    var plindex = plid;
                    var playlistJQ = playlist[plindex][0][0];
                    var phraselist = playlist[plindex];
                    var plist = [];
                    for (var _x = 0; _x < phraselist.length; _x++) {
                        plist[_x] = phraselist[_x][0];
                    }

                    var _audiorange = jQuery(this).data(
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
                    var _pci = jQuery(this).index();

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
//                                                    phraseObj
//                                                        .css({
//                                                            'color': 'darkred'
//                                                        });

                                phraseObj.addClass('phrase-played');
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
                jQuery('.startPlaylist').button('reset');
                var phraselist = playlist[plid];
                for (var i = 1; i < phraseIndex + 1; i++) {
//                                        phraselist[i][0].css({
//                                            'color': 'darkred'
//                                        }).show();

                    phraselist[i][0].addClass('phrase-played').show();

                    // iterate subphrase
                    for (var j = 1; j < phraselist[i].length; j++) {
//                                            phraselist[i][j].css({
//                                                'color': 'darkred'
//                                            }).show();
                        phraselist[i][j].addClass('phrase-played').show();
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
jQuery('.play').click(function (e) {
    e.preventDefault();
    playAudio();
});

// pause click
jQuery('.pause').click(function (e) {
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

jQuery('.playlist')
    .each(
        function (index, element) {

            playlist_index = jQuery(this).attr('id');
            playlist[playlist_index] = [];
            playlist[playlist_index][0] = [];
            playlist[playlist_index][0][0] = jQuery(this);
            // jQuery(this).hide();
            jQuery(this)
                .children('[data-audioalias]')
                .each(
                    function (index1,
                              element1) {
                        playlist[playlist_index][index1 + 1] = [];
                        playlist[playlist_index][index1 + 1][0] = jQuery(this);
                        // jQuery(this).hide();

                        // item list -
                        // subphrase list
                        jQuery(this)
                            .children(
                                '[data-audioalias]')
                            .each(
                                function (index2,
                                          element1) {
                                    playlist[playlist_index][index1 + 1][index2 + 1] = jQuery(this);
                                    // jQuery(this).hide();

                                });
                    });

            // event

        });

jQuery('.startPlaylist').click(
    function (e) {
        e.preventDefault();

        var methodName = jQuery(this).data("playstrat");
        if (song_paused == true) {
            song_paused = false;
            window['playStrat'
            + methodName.charAt(0)
                .toUpperCase()
            + methodName.slice(1)](jQuery(this)
                .data("playlist"), playlist);
            jQuery(this).button('playing');
        } else if (song_paused == false) {
            song_paused = true;
            stopAudio();
            jQuery(this).button('clicktoplay');
        }

    });// end for click

jQuery('.startPlaylist').each(
    function () {
        var methodName = jQuery(this).data("playstrat");
        if (!stratList.hasOwnProperty(methodName)) {
            stratList[methodName] = 1;
            jQuery.getScript(sroot
                + '/audio-strats/'
                + methodName + '.js', function () {
            });
        }
    });
