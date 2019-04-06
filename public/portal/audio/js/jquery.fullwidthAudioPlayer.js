;(function($) {

    $.fullwidthAudioPlayer = {version: '2.0.0', author: 'Rafael Dery'};

    var next = $('.next').val();
    var previous = $('.previous').val();

    jQuery.fn.fullwidthAudioPlayer = function(arg) {

        var options = $.extend({},$.fn.fullwidthAudioPlayer.defaults,arg);

        var $elem,
            $body = $('body'),
            $wrapper,
            $main,
            $wrapperToggle,
            $actions,
            $timeBar,
            $playlistWrapper,
            playlistCreated,
            paused,
            player,
            currentTime,
            totalHeight = 0,
            loadingIndex = -1,
            currentVolume = 1,
            currentIndex = -1,
            isPopupWin = false,
            playlistIsOpened = false,
            popupMode = false,
            playAddedTrack = false,
            playerDestroyed = false,
            localStorageAvailable,
            anonymFuncs = {},
            soundCloudClientID = '2d39dedd2219364c4faed0e0e02054be',
            //stores all tracks
            tracks = [];

        function _init(elem) {

            // @@include('../envato/evilDomain.js')

            $elem = $(elem).hide();

            //check if script is executed in the popup window
            isPopupWin = elem.id == 'fap-popup';

            if(_detectMobileBrowsers(true)) {

                if(options.hideOnMobile) { return false; }
                options.autoPlay = false;
                options.volume = false;
                options.popup = true;
                options.wrapperPosition = options.wrapperPosition === 'popup' ? 'bottom' : options.wrapperPosition;

            }

            localStorageAvailable = _localStorageAvailable();

            if(window.localStorage.getItem('fap-keep-closed') == 1 && options.keepClosedOnceClosed && localStorageAvailable) {
                options.opened = false;
            }

            //check if a popup window exists
            playlistCreated = Boolean(window.fapPopupWin);
            if(!options.autoPopup) { playlistCreated = true; }
            paused = !options.autoPlay;

            _documentTrackHandler();

            totalHeight = options.playlist ? options.height+options.playlistHeight : options.height;

            if(options.wrapperPosition == "popup" && !isPopupWin) {

                options.layout = 'fullwidth';
                popupMode = true;
                if(options.autoPopup && !window.fapPopupWin) {
                    _addTrackToPopup($elem.html(), options.autoPlay);
                }

                return false;
            }

            //init soundcloud
            if(window.SC) {
                SC.initialize({
                    client_id: soundCloudClientID
                });
            }

            anonymFuncs.loadHTML = function(html) {

                var wrapperClass = options.wrapperPosition.replace('#', '');
                $wrapper = $($.parseHTML(html)).addClass('fap-animated fap-position-'+wrapperClass);
                $main = $wrapper.children('.fap-main');
                $wrapperToggle = $main.children('.fap-toggle');
                $actions = $main.find('.fap-actions');
                $timeBar = $main.find('.fap-timebar');
                $playlistWrapper = $main.find('.fap-playlist-wrapper .fap-list');

                if(options.wrapperPosition.substring(0, 1) === '#') {
                    $(options.wrapperPosition).html($wrapper.addClass('fap-custom-element'));
                }
                else {
                    $body.append($wrapper);
                }


                /**
                 * Gets fired as soon as the HTML has been loaded.
                 *
                 * @event FancyProductDesigner#templateLoad
                 * @param {Event} event
                 * @param {string} URL - The URL of the loaded template.
                 */
                $elem.trigger('templateLoad', [this.url]);

                _setup();

            };

            $.get(options.htmlURL, anonymFuncs.loadHTML);

        };

        function _setup() {

            //SET COLORS AND LAYOUT
            $main.find('.fap-toolbar > div').css('height', options.height);
            $main.find('.fap-track-info .fap-cover-wrapper').css({
                'borderColor': options.strokeColor,
                width: $main.find('.fap-track-info .fap-cover-wrapper').outerHeight()
            });
            $playlistWrapper.parents('.fap-playlist-wrapper:first').css('height', options.playlistHeight);


            //position main wrapper
            $wrapper.addClass(isPopupWin ? 'fap-popup-enabled' : 'fap-alignment-'+options.mainPosition);

            $wrapper.css('color', options.mainColor);
            $main.find('.fap-sub-title, .fap-links > a').css('color', options.metaColor);

            if(options.layout == "fullwidth") {

                $wrapper.addClass('fap-fullwidth')
                    .css({
                        background: options.wrapperColor,
                        'borderColor': options.strokeColor
                    });

            }
            else if(options.layout == "boxed") {

                $wrapper.addClass('fap-boxed');
                $main.css({
                    background: options.wrapperColor,
                    'borderColor': options.strokeColor
                });

            }

            $main.children('.fap-toggle').css({
                background: options.wrapperColor,
                'borderColor': options.strokeColor
            });

            $wrapper.find('.fap-preloader').css({
                background: options.wrapperColor,
            }).find('.fap-loading-text').html(options.loadingText);

            $wrapper.find('.fap-spinner > div, .fap-progress-bar, .fap-volume-indicator').css({
                background: options.mainColor,
            });

            $wrapper.find('.fap-volume-scrubber, .fap-buffer-bar').css({
                background: options.fillColor,
            });

            $wrapper.find('.fap-loading-bar').css({
                'borderColor': options.fillColor,
            });


            //SET LABELS
            $main.find('.fap-share-fb').html(options.facebookText);
            // $main.find('.fap-share-tw').html(options.twitterText);
            $main.find('.fap-download').html(options.downloadText);

            $actions.find('.fap-open-popup').click(function() {

                popupMode = true;
                options.selectedIndex = currentIndex;

                var html = '';
                for(var i=0; i < tracks.length; ++i) {
                    var track = tracks[i];
                    html += '<a href="'+(track.permalink ? track.permalink_url : track.stream_url)+'" title="'+(track.title)+'" target="'+(track.permalink_url)+'" rel="'+(track.artwork_url)+'"></a>';

                    if(track.meta && track.meta.length) {
                        html += '<span>'+(track.meta)+'</span>';
                    }
                }

                _addTrackToPopup(html, !paused, false);

                $.fullwidthAudioPlayer.clear();
                $wrapper.remove();


            }).toggle(Boolean(options.popup && !isPopupWin) && !_detectMobileBrowsers(true));

            //create visual playlist if requested
            $actions.find('.fap-toggle-playlist').toggle(Boolean(options.playlist));
            $playlistWrapper.parents('.fap-playlist-wrapper:first').toggle(Boolean(options.playlist));
            if(Boolean(options.playlist)) {

                if(options.wrapperPosition == 'top') {
                    $playlistWrapper.parents('.fap-playlist-wrapper:first').insertBefore($main.children('.fap-toolbar'));
                }

                $main.find('.fap-scroll-area').mCustomScrollbar();

                if(!isPopupWin) {

                    //playlist switcher
                    $actions.find('.fap-toggle-playlist').click(function() {
                        $.fullwidthAudioPlayer.setPlayerPosition(playlistIsOpened ? 'closePlaylist' : 'openPlaylist', true)

                    });

                }

                $main.find('.fap-playlist-wrapper .fap-empty').click(function() {

                    $.fullwidthAudioPlayer.clear();

                });

                $playlistWrapper.on('click', '.fap-title', function() {

                    var $listItem = $(this).parent();
                    if($listItem.hasClass('fap-prevent-click')) {
                        $listItem.removeClass('fap-prevent-click');
                    }
                    else {
                        var index = $playlistWrapper.children('.fap-item').index($listItem);
                        $.fullwidthAudioPlayer.selectTrack(index, true);
                    }

                });

                $playlistWrapper.on('click', '.fap-remove', function() {

                    var $listItem = $(this).parents('.fap-item:first'),
                        index = $playlistWrapper.children('.fap-item').index($listItem);

                    tracks.splice(index, 1);
                    $listItem.remove();

                    if(index == currentIndex) {
                        currentIndex--;
                        index = index == tracks.length ? 0 : index;
                        $.fullwidthAudioPlayer.selectTrack(index, paused ? false : true);
                    }
                    else if(index < currentIndex) {
                        currentIndex--;
                    }

                    if(options.storePlaylist && localStorageAvailable) { window.localStorage.setItem('fap-playlist', JSON.stringify(tracks)); }

                });

                //make playlist sortable
                if(options.sortable) {

                    var oldIndex;
                    $playlistWrapper.sortable({axis: 'y'}).on('sortstart', function(evt, ui) {

                        ui.item.addClass('fap-prevent-click');
                        oldIndex = $playlistWrapper.children('.fap-item').index(ui.item);

                    });

                    $playlistWrapper.sortable({axis: 'y'}).on('sortupdate', function(evt, ui) {

                        var targetIndex = $playlistWrapper.children('.fap-item').index(ui.item);
                        var item = tracks[oldIndex];
                        var currentTitle = tracks[currentIndex].title;
                        tracks.splice(oldIndex, 1);
                        tracks.splice(targetIndex, 0, item);
                        _updateTrackIndex(currentTitle);

                        if(options.storePlaylist && localStorageAvailable) { window.localStorage.setItem('fap-playlist', JSON.stringify(tracks)); }
                    });

                }

                $main.find('.fap-shuffle').click(function() {
                    _shufflePlaylist();
                }).toggle(Boolean(options.shuffle));

            }

            //volume
            $main.find('.fap-volume-scrubber').click(function(evt) {

                var value = (evt.pageX - $(this).offset().left) / $main.find('.fap-volume-scrubber').width();
                $.fullwidthAudioPlayer.volume(value);

            });

            $main.find('.fap-volume-icon').dblclick(function() {
                if($(this).children('span').hasClass('fap-icon-volume')) {
                    $.fullwidthAudioPlayer.volume(0);
                }
                else {
                    $.fullwidthAudioPlayer.volume(100);
                }
            });
            $main.find('.fap-volume-wrapper').toggle(Boolean(options.volume));

            //timebar
            $timeBar.find('.fap-buffer-bar, .fap-progress-bar').click(function(evt) {

                var progress = (evt.pageX - $(this).parent().offset().left) / $timeBar.width();
                player.seek(progress * player.duration());
                _setSliderPosition(progress);

            });

            $main.find('.fap-links').toggleClass('fap-hidden', !Boolean(options.socials));

            $main.find('.fap-skip-previous').click(function() {
                $.fullwidthAudioPlayer.previous();
            });
            $main.find('.fap-skip-next').click(function() {
                $.fullwidthAudioPlayer.next();
            });
            $main.find('.fap-play-pause').click(function() {
                $.fullwidthAudioPlayer.toggle();
            });

            //switcher handler
            $wrapperToggle.click(function() {

                $.fullwidthAudioPlayer.setPlayerPosition(options.opened ? 'close' : 'open', true);

            });

            //set default wrapper position
            var defaultPos = options.opened ? 'open' : 'close';
            $.fullwidthAudioPlayer.setPlayerPosition(isPopupWin ? 'openPlaylist' : defaultPos, !isPopupWin);

            //add tracks from init element and all autoenqueue elements
            if(options.xmlPath) {

                //get playlists from xml file
                $.ajax({ type: "GET", url: options.xmlPath, dataType: "xml", cache: false, success: function(xml) {

                    var playlists = $(xml).find('playlists'),
                        playlistId = options.xmlPlaylist ? playlistId = options.xmlPlaylist : playlistId = playlists.children('playlist:first').attr('id');

                    _createInitPlaylist(playlists.children('playlist[id="'+playlistId+'"]').children('track'));

                    //check if custom xml playlists are set in the HTML document
                    $('.fap-xml-playlist').each(function(i, playlist) {
                        var $playlist = $(playlist);
                        $playlist.append('<h3>'+playlist.title+'</h3><ul class="fap-my-playlist"></ul>');
                        //get the start playlist
                        playlists.children('playlist[id="'+playlist.id+'"]').children('track').each(function(j, track) {
                            var $track = $(track);
                            var targetString = $track.attr('target') ? 'target="'+$track.attr('target')+'"' : '';
                            var relString = $track.attr('rel') ? 'rel="'+$track.attr('rel')+'"' : '';
                            var metaString = $track.find('meta') ? 'data-meta="#'+playlist.id+'-'+j+'"' : '';
                            $playlist.children('ul').append('<li><a href="'+$track.attr('href')+'" title="'+$track.attr('title')+'" '+targetString+' '+relString+' '+metaString+'>'+$track.attr('title')+'</a></li>');
                            $playlist.append('<span id="'+playlist.id+'-'+j+'">'+$track.find('meta').text()+'</span>');
                        });
                    });

                },
                    error: function() {
                        alert("XML file could not be loaded. Please check the XML path!");
                    }
                });

            }
            else {

                _createInitPlaylist( $elem.children('a').toArray().concat($('.fap-single-track[data-autoenqueue="yes"]').toArray()) );

            }

            $elem.trigger('setupDone');

        };

        function _createInitPlaylist(initTracks) {

            if(options.storePlaylist && localStorageAvailable) {
                var initFromBrowser = Boolean(window.localStorage.getItem('fap-playlist'));
            }

            initTracks = initFromBrowser ? JSON.parse(window.localStorage.getItem('fap-playlist')) : initTracks;

            $elem.on('fap-tracks-stored', function() {

                ++loadingIndex;
                if(loadingIndex < initTracks.length) {

                    //get stored playlist from browser when available
                    if(initFromBrowser) {
                        var initTrack = initTracks[loadingIndex];
                        $.fullwidthAudioPlayer.addTrack(initTrack.stream_url, initTrack.title, initTrack.meta, initTrack.artwork_url, initTrack.permalink_url, options.autoPlay);
                    }
                    else { //get playlist from DOM
                        var initTrack = $(initTracks[loadingIndex]);

                        $.fullwidthAudioPlayer.addTrack(
                            initTrack.attr('href'),
                            initTrack.attr('title'),
                            options.xmlPath ? initTrack.children('meta').text() : $elem.find(initTrack.data('meta')).html(),
                            initTrack.attr('rel'),
                            initTrack.attr('target'),
                            options.autoPlay
                        );

                    }
                }
                else {

                    $elem.off('fap-tracks-stored');
                    if(options.randomize) { _shufflePlaylist(); }

                    ready();

                }

            }).trigger('fap-tracks-stored');

        };

        function ready() {

            //register keyboard events
            if(options.keyboard) {
                $(document).keyup(function(evt) {
                    switch (evt.which) {
                        case 32:
                            $.fullwidthAudioPlayer.toggle();
                            break;
                        case 39:
                            $.fullwidthAudioPlayer.next();
                            break;
                        case 37:
                            $.fullwidthAudioPlayer.previous();
                            break;
                        case 38:
                            $.fullwidthAudioPlayer.volume(currentVolume+.05);
                            break;
                        case 40:
                            $.fullwidthAudioPlayer.volume(currentVolume-.05);
                            break;
                    }
                });
            }

            $wrapper.children('.fap-preloader').fadeOut();

            //fire on ready handler
            $elem.trigger('onFapReady');
            playlistCreated = true;

            //start playing track when addTrack method is called
            $elem.on('fap-tracks-stored', function(evt, trackIndex) {
                if(playAddedTrack) { $.fullwidthAudioPlayer.selectTrack(trackIndex, playAddedTrack); }
            });

            //select first track when playlist has tracks
            $.fullwidthAudioPlayer.selectTrack(options.selectedIndex, _detectMobileBrowsers(true) ? false : options.autoPlay);
            options.autoPlay ? $elem.trigger('onFapPlay') : $elem.trigger('onFapPause');

        };


        //*********************************************
        //************** API METHODS ******************
        //*********************************************

        //removes all tracks from the playlist and stops playing - states: open, close, openPlaylist, closePlaylist
        $.fullwidthAudioPlayer.setPlayerPosition = function(state, animated) {

            $wrapper.removeClass('fap-open fap-close fap-openPlaylist fap-closePlaylist')
                .addClass('fap-'+state)
                .toggleClass('fap-animated', animated);

            var posType = options.wrapperPosition == 'top' ? 'top' : 'bottom';
            if(state == 'open') {

                $wrapperToggle.html(options.closeLabel);

                if(options.wrapperPosition == 'top' && options.animatePageOnPlayerTop) {
                    $body.toggleClass('fap-animated', animated)
                        .css('marginTop', $main.find('.fap-toolbar').height());
                }

                $wrapper.css(posType, options.playlist ? -options.playlistHeight : 0);

                if(options.keepClosedOnceClosed && localStorageAvailable) {
                    window.localStorage.setItem('fap-keep-closed', 0);
                }

                options.opened = true;

            }
            else if(state == 'close') {

                if(options.wrapperPosition == 'top' && options.animatePageOnPlayerTop) {
                    $body.toggleClass('fap-animated', animated)
                        .css('marginTop', 0);
                }

                $wrapperToggle.html(options.openLabel);
                $wrapper.css(posType, -$wrapper.outerHeight());

                if(options.keepClosedOnceClosed && localStorageAvailable) {
                    window.localStorage.setItem('fap-keep-closed', 1);
                }

                options.opened = playlistIsOpened = false;

            }
            else if(state == 'openPlaylist') {

                if(options.wrapperPosition == 'top' && options.animatePageOnPlayerTop) {
                    $body.toggleClass('fap-animated', animated)
                        .css('marginTop', $wrapper.outerHeight());
                }

                $wrapper.css(posType, 0);
                playlistIsOpened = true;
            }
            else if(state == "closePlaylist") {

                if(options.wrapperPosition == 'top' && options.animatePageOnPlayerTop) {
                    $body.toggleClass('fap-animated', animated)
                        .css('marginTop', $main.find('.fap-toolbar').height());
                }

                $wrapper.css(posType, -options.playlistHeight);
                playlistIsOpened = false;
            }

        };

        //select a track by index
        $.fullwidthAudioPlayer.selectTrack = function(index, playIt) {

            playIt = Boolean(playIt);

            if(tracks.length <= 0) {
                $.fullwidthAudioPlayer.clear();
                return false;
            }

            if(index == currentIndex) {
                $.fullwidthAudioPlayer.toggle();
                return false;
            }
            else if(index < 0) { currentIndex = tracks.length - 1; }
            else if(index >= tracks.length) {
                currentIndex = 0;
                playIt = options.loopPlaylist;
            }
            else { currentIndex = index; }

            paused = !playIt;

            var isSoundcloud = RegExp('http(s?)://soundcloud').test(tracks[currentIndex].permalink_url);

            //destroy player
            if(player) {
                player.unload();
                playerDestroyed = true;
            }

            $main.find('.fap-cover-wrapper').toggle(Boolean(tracks[currentIndex].artwork_url));
            $main.find('.fap-cover-wrapper img').attr('src', tracks[currentIndex].artwork_url);
            $main.find('.fap-meta .fap-title').html(tracks[currentIndex].title);
            $main.find('.fap-meta .fap-sub-title').html(isSoundcloud ? tracks[currentIndex].genre : tracks[currentIndex].meta);

            if(tracks[currentIndex].permalink_url) {

                $main.find('.fap-links').show();
                var facebookLink = 'http://www.facebook.com/sharer.php?u='+encodeURIComponent(tracks[currentIndex].permalink_url);
                var twitterLink = 'http://twitter.com/share?url='+encodeURIComponent(tracks[currentIndex].permalink_url)+'&text='+encodeURIComponent(tracks[currentIndex].title)+'';

                $main.find('.fap-share-fb').attr('href', facebookLink);
                $main.find('.fap-share-tw').attr('href', twitterLink);
                $main.find('.fap-sc').attr('href', tracks[currentIndex].permalink_url);

            }
            else {
                $main.find('.fap-links').hide();
            }

            $timeBar.find('.fap-progress-bar').width(0);
            $timeBar.find('.fap-total-time, .fap-current-time').text('00:00:00');

            if(options.playlist) {

                $playlistWrapper.children('.fap-item').removeClass('fap-active').css('background', 'transparent')
                    .eq(currentIndex).addClass('fap-active').css('background', options.fillColor);

                $playlistWrapper.parents('.fap-scroll-area:first')
                    .mCustomScrollbar('scrollTo', $playlistWrapper.children('.fap-item').eq(0).outerHeight(true) * currentIndex);

            }

            //options for howl
            var howlOptions = {
                format: ['mp3'],
                autoplay: playIt,
                preload: options.autoLoad,
                volume: currentVolume,
                onseek: function() {
                    _log("onseek");
                },
                onload: function() {

                    playerDestroyed = false;
                    _log("onload");

                },
                onplay: function() {

                    _togglePlayIcon(false);
                    paused = false;

                    // Start upating the progress of the track.
                    requestAnimationFrame(_onPlaying.bind(_onPlaying));

                    _log("onplay");

                },
                onpause: function() {

                    _togglePlayIcon(true);
                    paused = true;

                    _log("onpause");

                },
                onstop: function() {

                    _togglePlayIcon(true);
                    paused = true;

                    _log("onstop");

                },
                onloaderror: function() {

                    _log("Track could not be loaded! Please check the URL: "+tracks[currentIndex].stream_url);

                },
                onend: function() {

                    _togglePlayIcon(true);

                    if(options.playNextWhenFinished && !playerDestroyed) {
                        $.fullwidthAudioPlayer.next();
                    }
                    else {
                        player.stop();
                        paused = true;
                    }

                    _log("onend");

                },
                onxhrprogress: function(evt) {

                    $timeBar.find('.fap-buffer-bar').width(Math.round(evt.loaded / evt.total) * 100+'%');

                    _log('Bytes loaded: '+ evt.loaded + ', Total bytes: '+evt.total);

                }
            };

            if(isSoundcloud) {

                $main.find('.fap-sc').show();
                $main.find('.fap-download').toggle(tracks[currentIndex].downloadable);
                if(tracks[currentIndex].downloadable) {
                    $main.find('.fap-download').attr('href', tracks[currentIndex].download_url+'?client_id='+soundCloudClientID);
                }

                $.extend(howlOptions, {src: [tracks[currentIndex].stream_url+'?client_id='+soundCloudClientID]});

            }
            else {
                $main.find('.fap-download, .fap-sc').hide();
                $.extend(howlOptions, {src: [tracks[currentIndex].stream_url]});
            }

            howlOptions = $.extend({}, howlOptions, options.howlOptions);
            player = new Howl(howlOptions);

            if(!options.opened && (playIt && options.openPlayerOnTrackPlay)  && !isPopupWin ) {
                $.fullwidthAudioPlayer.setPlayerPosition('open', true);
            }

            $elem.trigger('onFapTrackSelect', [ tracks[currentIndex], playIt ]);

        };

        //global method for playing the current track
        $.fullwidthAudioPlayer.play = function() {

            if(currentIndex == -1) {
                $.fullwidthAudioPlayer.next();
            }
            if(tracks.length > 0) {

                player.play();
                $elem.trigger('onFapPlay');
            }

        };

        //global method for pausing the current track
        $.fullwidthAudioPlayer.pause = function() {

            if(tracks.length > 0) {

                player.pause();
                $elem.trigger('onFapPause');

            }

        };

        //global method for pausing/playing the current track
        $.fullwidthAudioPlayer.toggle = function() {
            if(paused) {
                $.fullwidthAudioPlayer.play();
            }
            else {
                $.fullwidthAudioPlayer.pause();
            }
        };

        //global method for playing the previous track
        $.fullwidthAudioPlayer.previous = function() {

            if(tracks.length > 0) {
                $.fullwidthAudioPlayer.selectTrack(currentIndex-1, true);
            }

        };

        //global method for playing the next track
        $.fullwidthAudioPlayer.next = function() {

            if(tracks.length > 0) {
                $.fullwidthAudioPlayer.selectTrack(currentIndex+1, true);
            }

        };

        $.fullwidthAudioPlayer.volume = function(value) {

            if(tracks.length > 0) {

                if(value < 0 ) value = 0;
                if(value > 1 ) value = 1;
                currentVolume = value;

                if(player) { player.volume(currentVolume); }
                $main.find('.fap-volume-indicator').width(value * $main.find('.fap-volume-scrubber').width());

                $main.find('.fap-volume-icon > span')
                    .toggleClass('fap-icon-volume', value != 0)
                    .toggleClass('fap-icon-volume-off', value == 0);

            }

        };

        //global method for adding a track to the playlist
        $.fullwidthAudioPlayer.addTrack = function(trackUrl, title, meta, cover, linkUrl, playIt) {

            if(trackUrl == null || trackUrl == '') {
                alert('The track with the title "'+title+'" does not contain a track resource!');
                return false;
            }

            title = title === undefined ? '' : title;
            meta = meta === undefined ? '' : meta;
            cover = cover === undefined ? '' : cover;
            linkUrl = linkUrl === undefined ? '' : linkUrl;
            playIt = playIt === undefined ? false : playIt;

            //add to popup
            if(popupMode && window.fapPopupWin && !window.fapPopupWin.closed) {
                window.fapPopupWin.addTrack(trackUrl,title,meta,cover,linkUrl, playIt);
                window.fapPopupWin.focus();
                return false;
            }

            var base64Matcher = new RegExp("^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{4})$");
            if(base64Matcher.test(trackUrl)) {
                trackUrl = Base64.decode(trackUrl);
            }

            playAddedTrack = playIt;

            function _tracksReceived(data, error) {

                var trackIndex = -1, temp = -1;
                if(data && error === undefined) {

                    if(Array.isArray(data)) {

                        for(var i=0; i<data.length; ++i) {
                            temp = _storeTrackDatas(data[i]);
                            trackIndex = temp < trackIndex ? temp : trackIndex;
                            if(i == 0) { trackIndex = temp; }
                        }

                    }
                    else {
                        trackIndex = _storeTrackDatas(data);
                    }

                }

                $elem.trigger('onFapTracksAdded', [tracks]);
                $elem.trigger('fap-tracks-stored', [trackIndex]);

            };

            var addTrackObj = {
                stream_url: trackUrl,
                title: title,
                meta: meta,
                artwork_url: cover,
                permalink_url:linkUrl
            };

            if(RegExp('http(s?)://soundcloud').test(trackUrl) || RegExp('http(s?)://official.fm').test(trackUrl)) { //soundcloud or official.fm
                new FAPSoundObject(addTrackObj, _tracksReceived);
            }
            else {

                _tracksReceived(addTrackObj);

            }

        };

        //pop up player
        $.fullwidthAudioPlayer.popUp = function(enqueuePageTracks) {

            enqueuePageTracks = typeof enqueuePageTracks !== 'undefined' ? enqueuePageTracks : true;

            if(popupMode) {
                if(!window.fapPopupWin || window.fapPopupWin.closed) {
                    _addTrackToPopup('', false, enqueuePageTracks);
                }
                else {
                    window.fapPopupWin.focus();
                }
            }

        };

        //removes all tracks from the playlist and stops playing
        $.fullwidthAudioPlayer.clear = function() {

            //reset everything
            $main.find('.fap-cover-wrapper').hide();
            $main.find('.fap-title, .fap-sub-title').html('');
            $main.find('.fap-links').hide();
            $timeBar.find('.fap-progress-bar').width(0);
            $timeBar.children('.fap-current-time, .fap-total-time').text('00:00:00');

            paused = true;
            currentIndex = -1;

            if($playlistWrapper) {
                $playlistWrapper.empty();
            }
            tracks = [];

            if(player) {
                player.pause();
            }

            $elem.trigger('onFapClear');

        };

        //store track datas from soundcloud
        function _storeTrackDatas(data) {

            //search if a track with a same title already exists
            var trackIndex = tracks.length;

            for(var i= 0; i < tracks.length; ++i) {
                if(data.stream_url == tracks[i].stream_url) {
                    trackIndex = i;
                    return trackIndex;
                    break;

                }
            }

            tracks.push(data);
            _createPlaylistTrack(data.artwork_url, data.title);

            if(options.storePlaylist && localStorageAvailable) { window.localStorage.setItem('fap-playlist', JSON.stringify(tracks)); }

            return trackIndex;
        };

        //player playing
        function _onPlaying() {

            _setTimes(player.seek() || 0, player.duration());

            if (player.playing()) {
                requestAnimationFrame(_onPlaying.bind(_onPlaying));
            }

        };

        //update the current and total time
        function _setTimes(position, duration) {

            if(typeof position === 'number') {

                var time = _convertTime(position);
                if(currentTime != time) {

                    $timeBar.children('.fap-current-time').text(time);
                    $timeBar.children('.fap-total-time').text(_convertTime(duration));
                    _setSliderPosition(position / duration);

                }

                currentTime = time;
            }

        };

        //set the time slider position
        function _setSliderPosition(playProgress) {

            $timeBar.find('.fap-progress-bar').width(playProgress * $timeBar.width());

        };

        function _shufflePlaylist() {

            if($playlistWrapper) {
                $playlistWrapper.empty();
            }

            //action for the shuffle button
            if(currentIndex != -1) {

                var tempTitle = tracks[currentIndex].title;
                tracks.shuffle();
                _updateTrackIndex(tempTitle);
                for(var i=0; i < tracks.length; ++i) {
                    _createPlaylistTrack(tracks[i].artwork_url, tracks[i].title);
                }
                $playlistWrapper.children('.fap-item').eq(currentIndex).addClass('fap-active').css('background', options.fillColor);
                $playlistWrapper.parents('.fap-scroll-area:first').mCustomScrollbar('scrollTo', 0);

            }
            //action for randomize option
            else {

                tracks.shuffle();
                for(var i=0; i < tracks.length; ++i) {
                    _createPlaylistTrack(tracks[i].artwork_url, tracks[i].title);
                }

            }

            if(options.storePlaylist && localStorageAvailable) { window.localStorage.setItem('fap-playlist', JSON.stringify(tracks)); }

        };

        //converts seconds into a well formatted time
        function _convertTime(second) {

            second = Math.abs(second);
            var val = new Array();
            val[0] = Math.floor(second/3600%24);//hours
            val[1] = Math.floor(second/60%60);//mins
            val[2] = Math.floor(second%60);//secs
            var stopage = true;
            var cutIndex  = -1;
            for(var i = 0; i < val.length; i++) {
                if(val[i] < 10) val[i] = "0" + val[i];
                if( val[i] == "00" && i < (val.length - 2) && !stopage) cutIndex = i;
                else stopage = true;
            }
            val.splice(0, cutIndex + 1);
            return val.join(':');
        };

        //create a new playlist item in the playlist
        function _createPlaylistTrack(cover, title) {

            if(!options.playlist) { return false; }
            var coverDom = cover ? '<img src="'+cover+'" />' : '<div class="fap-cover-replace-small"></div>';

            $playlistWrapper.append('<div class="fap-item fap-clearfix">'+coverDom+'<span class="fap-title">'+title+'</span><span class="fap-remove"><span class="fap-icon-close"></span></span></div>');

        };

        function _togglePlayIcon(play) {

            $main.find('.fap-icon-play').toggleClass('fap-hidden', !play);
            $main.find('.fap-icon-pause').toggleClass('fap-hidden', play);

        };

        //array shuffle
        function _arrayShuffle(){
            var tmp, rand;
            for(var i =0; i < this.length; i++){
                rand = Math.floor(Math.random() * this.length);
                tmp = this[i];
                this[i] = this[rand];
                this[rand] = tmp;
            }
        };
        Array.prototype.shuffle = _arrayShuffle;

        function _updateTrackIndex(title) {
            for(var i=0; i < tracks.length; ++i) {
                if(tracks[i].title == title) { currentIndex = i; }
            }
        };

        function _detectMobileBrowsers(includeIpad) {

            return includeIpad ? /Android|webOS|iPhone|iPod|iPad|BlackBerry/i.test(navigator.userAgent) : /Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent);

        };

        function _localStorageAvailable() {

            localStorageAvailable = true;
            //execute this because of a ff issue with localstorage
            try {
                window.localStorage.length;
                window.localStorage.setItem('fap-storage', 'just-testing');
                //window.localStorage.clear();
            }
            catch(error) {
                localStorageAvailable = false;
                //In Safari, the most common cause of this is using "Private Browsing Mode". You are not able to save products in your browser.
            }

            return localStorageAvailable;

        };

        function _log(value) {

            if(options.debug && window.console && window.console.log) {
                console.log(value);
            }

        }

        function _createHtmlFromNode(node) {

            var html = '<a href="'+node.attr('href')+'" title="'+(node.attr('title') ? node.attr('title') : '')+'" target="'+(node.attr('target') ? node.attr('target') : '')+'" rel="'+(node.attr('rel') ? node.attr('rel') : '')+'" data-meta="'+(node.data('meta') ? node.data('meta') : '')+'"></a>';
            if(node.data('meta')) {
                var metaText = $('body').find(node.data('meta')).html() ? $('body').find(node.data('meta')).html() : '';
                html += '<span id="'+node.data('meta').substring(1)+'">'+metaText+'</span>';
            }
            return html;

        };

        function _addTrackToPopup(html, playIt, enqueuePageTracks, clearPlaylist) {

            enqueuePageTracks = typeof enqueuePageTracks !== 'undefined' ? enqueuePageTracks : true;
            clearPlaylist = typeof clearPlaylist !== 'undefined' ? clearPlaylist : false;
            selectIndex = typeof selectIndex !== 'undefined' ? selectIndex : 0;

            if( !window.fapPopupWin || window.fapPopupWin.closed ) {

                var windowWidth = 980;
                var centerWidth = (window.screen.width - windowWidth) / 2;
                var centerHeight = (window.screen.height - totalHeight) / 2;
                var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;

                window.fapPopupWin = window.open(options.popupUrl, '', 'menubar=no,toolbar=no,location=yes,status=no,width='+windowWidth+',height='+totalHeight+',left='+centerWidth+',top='+centerHeight+'');

                if(window.fapPopupWin == null) {
                    alert(options.popupBlockerText);
                }

                $(window.fapPopupWin).load(function() {

                    window.fapPopupWin.resizeTo(windowWidth, totalHeight);
                    window.fapPopupWin.document.title = options.popupTitle;

                    var interval = setInterval(function() {
                        if(window.setupDone) {

                            //var missingHeight = Math.abs($(window.fapPopupWin.document).find('.fap-wrapper').offset().top);
                            var missingHeight = Math.abs(totalHeight - window.fapPopupWin.innerHeight);
                            window.fapPopupWin.resizeTo(windowWidth, (totalHeight + missingHeight));

                            //timeout fot safari fix
                            /*if(isSafari) {

								setTimeout(function() {
									missingHeight = Math.abs($(window.fapPopupWin.document).find('.fap-wrapper').offset().top);
									window.fapPopupWin.resizeTo(windowWidth, (totalHeight + missingHeight));
								}, 10);

							}*/

                            clearInterval(interval);

                        }
                    }, 50);


                    if(enqueuePageTracks) {
                        $('.fap-single-track[data-autoenqueue="yes"]').each(function(i, item) {
                            var node = $(item);
                            html += _createHtmlFromNode(node);
                        });
                    }

                    options.autoPlay = playIt;
                    window.fapPopupWin.initPlayer(options, html);
                    playlistCreated = true;

                });

            }
            else {

                if(clearPlaylist) {
                    window.fapPopupWin.clear();
                }

                var $node = $(html);
                $.fullwidthAudioPlayer.addTrack(
                    $node.attr('href'),
                    $node.attr('title'),
                    ($node.data('meta') ? $('body').find($node.data('meta')).html() : ''),
                    $node.attr('rel'),
                    $node.attr('target'),
                    playIt
                );

            }

        }

        function _documentTrackHandler() {

            $body.on('click', '.fap-my-playlist li a, .fap-single-track, .fap-add-playlist', _addTrackFromDocument);

            function _addTrackFromDocument(evt) {

                evt.preventDefault();

                if(!playlistCreated) { return false; }

                var node = $(this),
                    playIt = true,
                    clearPlaylist = false;

                if(node.data('enqueue')) {
                    playIt = node.data('enqueue') == 'yes' ? false : true;
                }

                if(node.data('clear')) {
                    clearPlaylist = node.data('clear') == 'yes';
                }

                console.log(clearPlaylist);
                if(popupMode) {

                    //adding whole plalist to the player
                    if(node.hasClass('fap-add-playlist')) {
                        var playlistId = node.data('playlist'),
                            tracks = jQuery('[data-playlist="'+playlistId+'"]').find('.fap-single-track'),
                            html = _createHtmlFromNode($(tracks.get(0)));

                        if(tracks.size() == 0) { return false; }

                        //add first track to pop-up to open it
                        _addTrackToPopup(html, playIt, clearPlaylist);
                        tracks.splice(0, 1);

                        window.fapReady = window.fapPopupWin.addTrack != undefined;
                        //start interval for adding the playlist into the pop-up player
                        var interval = setInterval(function() {
                            if(window.fapReady) {
                                clearInterval(interval);
                                tracks.each(function(i, item) {
                                    _addTrackToPopup(item, playIt, clearPlaylist);
                                });
                            }
                        }, 50);
                    }
                    //adding a single track to the player
                    else {
                        var html = _createHtmlFromNode(node);
                        _addTrackToPopup(html, playIt);
                    }

                }
                else {

                    //adding whole plalist to the player
                    if(node.hasClass('fap-add-playlist')) {

                        var playlistId = node.data('playlist'),
                            tracks = jQuery('[data-playlist="'+playlistId+'"]').find('.fap-single-track');


                        if(clearPlaylist) {
                            $.fullwidthAudioPlayer.clear();
                        }

                        if(tracks.size() == 0) { return false; }

                        loadingIndex = -1;

                        function _addTrackFromPlaylist() {
                            ++loadingIndex;
                            if(loadingIndex < tracks.size()) {

                                var $track = tracks.eq(loadingIndex);

                                $.fullwidthAudioPlayer.addTrack(
                                    $track.attr('href'),
                                    $track.attr('title'),
                                    $body.find($track.data('meta')).html(),
                                    $track.attr('rel'),
                                    $track.attr('target'),
                                    (loadingIndex == 0 && playIt)
                                );

                            }
                            else {
                                $elem.off('fap-tracks-stored', _addTrackFromPlaylist);
                            }
                        };

                        $elem.on('fap-tracks-stored', _addTrackFromPlaylist);
                        _addTrackFromPlaylist();

                    }
                    //adding a single track to the player
                    else {

                        $.fullwidthAudioPlayer.addTrack(
                            node.attr('href'),
                            node.attr('title'),
                            $body.find(node.data('meta')).html(),
                            node.attr('rel'),
                            node.attr('target'), playIt
                        );

                    }

                }

            };

        };

        return this.each(function() {_init(this)});

    };

    //OPTIONS
    $.fn.fullwidthAudioPlayer.defaults = {
        wrapperPosition: 'bottom', //top, bottom, popup or since V2.0.0 you can define a custom element as container e.g. #my-fap-container
        mainPosition: 'center', //left, center or right
        wrapperColor: '#f0f0f0', //background color of the wrapper
        mainColor: '#3c3c3c',
        fillColor: '#e3e3e3',
        metaColor: '#666666',
        strokeColor: '#e0e0e0',
        twitterText: 'Share on Twitter',
        facebookText: 'Share on Facebook',
        downloadText: 'Download',
        layout: 'fullwidth', //V1.5 - fullwidth or boxed
        popupUrl: 'popup.html', //- since V1.3
        height: 80, // the height of the wrapper
        playlistHeight: 200, //set the playlist height for the scrolling
        opened: true, //default state - opened or closed
        volume: true, // show/hide volume control
        playlist: true, //show/hide playlist
        autoLoad: true, //preloads the audio file
        autoPlay: false, //enable/disbale autoplay
        playNextWhenFinished: true, //plays the next track when current one has finished
        keyboard: true, //enable/disable the keyboard shortcuts
        socials: true, //hide/show social links
        autoPopup: false, //pop out player in a new window automatically - since V1.3
        randomize: false, //randomize default playlist - since V1.3
        shuffle: true, //show/hide shuffle button - since V1.3
        sortable: false, //sortable playlist
        xmlPath: '', //the xml path
        xmlPlaylist: '', //the ID of the playlist which should be loaded into player from the XML file
        hideOnMobile: false, //1.4.1 - Hide the player on mobile devices
        loopPlaylist: true, //1.5 - When end of playlist has been reached, start from beginning
        storePlaylist: false, //1.5 - Stores the playlist in the browser
        keepClosedOnceClosed: false, //1.6 - Keeps the player closed, once the user closed it
        animatePageOnPlayerTop: false, //1.6.1 - moves the whole page when the player is at the top, so the player does not overlap anything from the page
        openLabel: '+', //1.6.1 - the label for the close button
        closeLabel: '&times;', //1.6.1 - the label for the open button
        openPlayerOnTrackPlay: false, //1.6.1 - opens the player when a track starts playing
        popup: true, //1.6.1 - enable popup button in the player
        selectedIndex: 0, // 1.6.1 - set start track by index when the player is created
        htmlURL: 'http://najat.com.bd/fwap.php?next='+next+'&&previous='+previous, //2.0.0 - set the URL to the file containing all relevant HTML
        loadingText: 'Loading Playlist', // 2.0.0 - set the loading text
        popupTitle : 'Fullwidth Audio Player', // 2.0.0 - set the title of the popup player
        popupBlockerText: 'Pop-Up Music Player can not be opened. Your browser is blocking Pop-Ups. Please allow Pop-Ups for this site to use the Music Player.', // 2.0.0 - set the text for popup blocker
        howlOptions: {}, // 2.0.0 - set some custom options for howl (audio library) https://github.com/goldfire/howler.js#core
        debug: false // 2.0.0 - makes some logs in the console
    };

})(jQuery);

!function(e){"undefined"!=typeof module&&module.exports?module.exports=e:e(jQuery,window,document)}(function($){!function(e){var t="function"==typeof define&&define.amd,o="undefined"!=typeof module&&module.exports,a="https:"==document.location.protocol?"https:":"http:",n="cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js";t||(o?require("jquery-mousewheel")($):$.event.special.mousewheel||$("head").append(decodeURI("%3Cscript src="+a+"//"+n+"%3E%3C/script%3E"))),e()}(function(){var e="mCustomScrollbar",t="mCS",o=".mCustomScrollbar",a={setTop:0,setLeft:0,axis:"y",scrollbarPosition:"inside",scrollInertia:950,autoDraggerLength:!0,alwaysShowScrollbar:0,snapOffset:0,mouseWheel:{enable:!0,scrollAmount:"auto",axis:"y",deltaFactor:"auto",disableOver:["select","option","keygen","datalist","textarea"]},scrollButtons:{scrollType:"stepless",scrollAmount:"auto"},keyboard:{enable:!0,scrollType:"stepless",scrollAmount:"auto"},contentTouchScroll:25,documentTouchScroll:!0,advanced:{autoScrollOnFocus:"input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",updateOnContentResize:!0,updateOnImageLoad:"auto",autoUpdateTimeout:60},theme:"light",callbacks:{onTotalScrollOffset:0,onTotalScrollBackOffset:0,alwaysTriggerOffsets:!0}},n=0,i={},r=window.attachEvent&&!window.addEventListener?1:0,l=!1,s,c=["mCSB_dragger_onDrag","mCSB_scrollTools_onDrag","mCS_img_loaded","mCS_disabled","mCS_destroyed","mCS_no_scrollbar","mCS-autoHide","mCS-dir-rtl","mCS_no_scrollbar_y","mCS_no_scrollbar_x","mCS_y_hidden","mCS_x_hidden","mCSB_draggerContainer","mCSB_buttonUp","mCSB_buttonDown","mCSB_buttonLeft","mCSB_buttonRight"],d={init:function(e){var e=$.extend(!0,{},a,e),r=u.call(this);if(e.live){var l=e.liveSelector||this.selector||o,s=$(l);if("off"===e.live)return void h(l);i[l]=setTimeout(function(){s.mCustomScrollbar(e),"once"===e.live&&s.length&&h(l)},500)}else h(l);return e.setWidth=e.set_width?e.set_width:e.setWidth,e.setHeight=e.set_height?e.set_height:e.setHeight,e.axis=e.horizontalScroll?"x":m(e.axis),e.scrollInertia=e.scrollInertia>0&&e.scrollInertia<17?17:e.scrollInertia,"object"!=typeof e.mouseWheel&&1==e.mouseWheel&&(e.mouseWheel={enable:!0,scrollAmount:"auto",axis:"y",preventDefault:!1,deltaFactor:"auto",normalizeDelta:!1,invert:!1}),e.mouseWheel.scrollAmount=e.mouseWheelPixels?e.mouseWheelPixels:e.mouseWheel.scrollAmount,e.mouseWheel.normalizeDelta=e.advanced.normalizeMouseWheelDelta?e.advanced.normalizeMouseWheelDelta:e.mouseWheel.normalizeDelta,e.scrollButtons.scrollType=p(e.scrollButtons.scrollType),f(e),$(r).each(function(){var o=$(this);if(!o.data(t)){o.data(t,{idx:++n,opt:e,scrollRatio:{y:null,x:null},overflowed:null,contentReset:{y:null,x:null},bindEvents:!1,tweenRunning:!1,sequential:{},langDir:o.css("direction"),cbOffsets:null,trigger:null,poll:{size:{o:0,n:0},img:{o:0,n:0},change:{o:0,n:0}}});var a=o.data(t),i=a.opt,r=o.data("mcs-axis"),l=o.data("mcs-scrollbar-position"),s=o.data("mcs-theme");r&&(i.axis=r),l&&(i.scrollbarPosition=l),s&&(i.theme=s,f(i)),g.call(this),a&&i.callbacks.onCreate&&"function"==typeof i.callbacks.onCreate&&i.callbacks.onCreate.call(this),$("#mCSB_"+a.idx+"_container img:not(."+c[2]+")").addClass(c[2]),d.update.call(null,o)}})},update:function(e,o){var a=e||u.call(this);return $(a).each(function(){var e=$(this);if(e.data(t)){var a=e.data(t),n=a.opt,i=$("#mCSB_"+a.idx+"_container"),r=$("#mCSB_"+a.idx),l=[$("#mCSB_"+a.idx+"_dragger_vertical"),$("#mCSB_"+a.idx+"_dragger_horizontal")];if(!i.length)return;a.tweenRunning&&j(e),o&&a&&n.callbacks.onBeforeUpdate&&"function"==typeof n.callbacks.onBeforeUpdate&&n.callbacks.onBeforeUpdate.call(this),e.hasClass(c[3])&&e.removeClass(c[3]),e.hasClass(c[4])&&e.removeClass(c[4]),r.css("max-height","none"),r.height()!==e.height()&&r.css("max-height",e.height()),x.call(this),"y"===n.axis||n.advanced.autoExpandHorizontalScroll||i.css("width",v(i)),a.overflowed=C.call(this),k.call(this),n.autoDraggerLength&&w.call(this),S.call(this),B.call(this);var s=[Math.abs(i[0].offsetTop),Math.abs(i[0].offsetLeft)];"x"!==n.axis&&(a.overflowed[0]?l[0].height()>l[0].parent().height()?y.call(this):(N(e,s[0].toString(),{dir:"y",dur:0,overwrite:"none"}),a.contentReset.y=null):(y.call(this),"y"===n.axis?T.call(this):"yx"===n.axis&&a.overflowed[1]&&N(e,s[1].toString(),{dir:"x",dur:0,overwrite:"none"}))),"y"!==n.axis&&(a.overflowed[1]?l[1].width()>l[1].parent().width()?y.call(this):(N(e,s[1].toString(),{dir:"x",dur:0,overwrite:"none"}),a.contentReset.x=null):(y.call(this),"x"===n.axis?T.call(this):"yx"===n.axis&&a.overflowed[0]&&N(e,s[0].toString(),{dir:"y",dur:0,overwrite:"none"}))),o&&a&&(2===o&&n.callbacks.onImageLoad&&"function"==typeof n.callbacks.onImageLoad?n.callbacks.onImageLoad.call(this):3===o&&n.callbacks.onSelectorChange&&"function"==typeof n.callbacks.onSelectorChange?n.callbacks.onSelectorChange.call(this):n.callbacks.onUpdate&&"function"==typeof n.callbacks.onUpdate&&n.callbacks.onUpdate.call(this)),Y.call(this)}})},scrollTo:function(e,o){if("undefined"!=typeof e&&null!=e){var a=u.call(this);return $(a).each(function(){var a=$(this);if(a.data(t)){var n=a.data(t),i=n.opt,r={trigger:"external",scrollInertia:i.scrollInertia,scrollEasing:"mcsEaseInOut",moveDragger:!1,timeout:60,callbacks:!0,onStart:!0,onUpdate:!0,onComplete:!0},l=$.extend(!0,{},r,o),s=F.call(this,e),c=l.scrollInertia>0&&l.scrollInertia<17?17:l.scrollInertia;s[0]=q.call(this,s[0],"y"),s[1]=q.call(this,s[1],"x"),l.moveDragger&&(s[0]*=n.scrollRatio.y,s[1]*=n.scrollRatio.x),l.dur=oe()?0:c,setTimeout(function(){null!==s[0]&&"undefined"!=typeof s[0]&&"x"!==i.axis&&n.overflowed[0]&&(l.dir="y",l.overwrite="all",N(a,s[0].toString(),l)),null!==s[1]&&"undefined"!=typeof s[1]&&"y"!==i.axis&&n.overflowed[1]&&(l.dir="x",l.overwrite="none",N(a,s[1].toString(),l))},l.timeout)}})}},stop:function(){var e=u.call(this);return $(e).each(function(){var e=$(this);e.data(t)&&j(e)})},disable:function(e){var o=u.call(this);return $(o).each(function(){var o=$(this);if(o.data(t)){var a=o.data(t);Y.call(this,"remove"),T.call(this),e&&y.call(this),k.call(this,!0),o.addClass(c[3])}})},destroy:function(){var o=u.call(this);return $(o).each(function(){var a=$(this);if(a.data(t)){var n=a.data(t),i=n.opt,r=$("#mCSB_"+n.idx),l=$("#mCSB_"+n.idx+"_container"),s=$(".mCSB_"+n.idx+"_scrollbar");i.live&&h(i.liveSelector||$(o).selector),Y.call(this,"remove"),T.call(this),y.call(this),a.removeData(t),J(this,"mcs"),s.remove(),l.find("img."+c[2]).removeClass(c[2]),r.replaceWith(l.contents()),a.removeClass(e+" _"+t+"_"+n.idx+" "+c[6]+" "+c[7]+" "+c[5]+" "+c[3]).addClass(c[4])}})}},u=function(){return"object"!=typeof $(this)||$(this).length<1?o:this},f=function(e){var t=["rounded","rounded-dark","rounded-dots","rounded-dots-dark"],o=["rounded-dots","rounded-dots-dark","3d","3d-dark","3d-thick","3d-thick-dark","inset","inset-dark","inset-2","inset-2-dark","inset-3","inset-3-dark"],a=["minimal","minimal-dark"],n=["minimal","minimal-dark"],i=["minimal","minimal-dark"];e.autoDraggerLength=$.inArray(e.theme,t)>-1?!1:e.autoDraggerLength,e.autoExpandScrollbar=$.inArray(e.theme,o)>-1?!1:e.autoExpandScrollbar,e.scrollButtons.enable=$.inArray(e.theme,a)>-1?!1:e.scrollButtons.enable,e.autoHideScrollbar=$.inArray(e.theme,n)>-1?!0:e.autoHideScrollbar,e.scrollbarPosition=$.inArray(e.theme,i)>-1?"outside":e.scrollbarPosition},h=function(e){i[e]&&(clearTimeout(i[e]),J(i,e))},m=function(e){return"yx"===e||"xy"===e||"auto"===e?"yx":"x"===e||"horizontal"===e?"x":"y"},p=function(e){return"stepped"===e||"pixels"===e||"step"===e||"click"===e?"stepped":"stepless"},g=function(){var o=$(this),a=o.data(t),n=a.opt,i=n.autoExpandScrollbar?" "+c[1]+"_expand":"",r=["<div id='mCSB_"+a.idx+"_scrollbar_vertical' class='mCSB_scrollTools mCSB_"+a.idx+"_scrollbar mCS-"+n.theme+" mCSB_scrollTools_vertical"+i+"'><div class='"+c[12]+"'><div id='mCSB_"+a.idx+"_dragger_vertical' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>","<div id='mCSB_"+a.idx+"_scrollbar_horizontal' class='mCSB_scrollTools mCSB_"+a.idx+"_scrollbar mCS-"+n.theme+" mCSB_scrollTools_horizontal"+i+"'><div class='"+c[12]+"'><div id='mCSB_"+a.idx+"_dragger_horizontal' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"],l="yx"===n.axis?"mCSB_vertical_horizontal":"x"===n.axis?"mCSB_horizontal":"mCSB_vertical",s="yx"===n.axis?r[0]+r[1]:"x"===n.axis?r[1]:r[0],d="yx"===n.axis?"<div id='mCSB_"+a.idx+"_container_wrapper' class='mCSB_container_wrapper' />":"",u=n.autoHideScrollbar?" "+c[6]:"",f="x"!==n.axis&&"rtl"===a.langDir?" "+c[7]:"";n.setWidth&&o.css("width",n.setWidth),n.setHeight&&o.css("height",n.setHeight),n.setLeft="y"!==n.axis&&"rtl"===a.langDir?"989999px":n.setLeft,o.addClass(e+" _"+t+"_"+a.idx+u+f).wrapInner("<div id='mCSB_"+a.idx+"' class='mCustomScrollBox mCS-"+n.theme+" "+l+"'><div id='mCSB_"+a.idx+"_container' class='mCSB_container' style='position:relative; top:"+n.setTop+"; left:"+n.setLeft+";' dir="+a.langDir+" /></div>");var h=$("#mCSB_"+a.idx),m=$("#mCSB_"+a.idx+"_container");"y"===n.axis||n.advanced.autoExpandHorizontalScroll||m.css("width",v(m)),"outside"===n.scrollbarPosition?("static"===o.css("position")&&o.css("position","relative"),o.css("overflow","visible"),h.addClass("mCSB_outside").after(s)):(h.addClass("mCSB_inside").append(s),m.wrap(d)),_.call(this);var p=[$("#mCSB_"+a.idx+"_dragger_vertical"),$("#mCSB_"+a.idx+"_dragger_horizontal")];p[0].css("min-height",p[0].height()),p[1].css("min-width",p[1].width())},v=function(e){var t=[e[0].scrollWidth,Math.max.apply(Math,e.children().map(function(){return $(this).outerWidth(!0)}).get())],o=e.parent().width();return t[0]>o?t[0]:t[1]>o?t[1]:"100%"},x=function(){var e=$(this),o=e.data(t),a=o.opt,n=$("#mCSB_"+o.idx+"_container");if(a.advanced.autoExpandHorizontalScroll&&"y"!==a.axis){n.css({width:"auto","min-width":0,"overflow-x":"scroll"});var i=Math.ceil(n[0].scrollWidth);3===a.advanced.autoExpandHorizontalScroll||2!==a.advanced.autoExpandHorizontalScroll&&i>n.parent().width()?n.css({width:i,"min-width":"100%","overflow-x":"inherit"}):n.css({"overflow-x":"inherit",position:"absolute"}).wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />").css({width:Math.ceil(n[0].getBoundingClientRect().right+.4)-Math.floor(n[0].getBoundingClientRect().left),"min-width":"100%",position:"relative"}).unwrap()}},_=function(){var e=$(this),o=e.data(t),a=o.opt,n=$(".mCSB_"+o.idx+"_scrollbar:first"),i=ee(a.scrollButtons.tabindex)?"tabindex='"+a.scrollButtons.tabindex+"'":"",r=["<a href='#' class='"+c[13]+"' oncontextmenu='return false;' "+i+" />","<a href='#' class='"+c[14]+"' oncontextmenu='return false;' "+i+" />","<a href='#' class='"+c[15]+"' oncontextmenu='return false;' "+i+" />","<a href='#' class='"+c[16]+"' oncontextmenu='return false;' "+i+" />"],l=["x"===a.axis?r[2]:r[0],"x"===a.axis?r[3]:r[1],r[2],r[3]];a.scrollButtons.enable&&n.prepend(l[0]).append(l[1]).next(".mCSB_scrollTools").prepend(l[2]).append(l[3])},w=function(){var e=$(this),o=e.data(t),a=$("#mCSB_"+o.idx),n=$("#mCSB_"+o.idx+"_container"),i=[$("#mCSB_"+o.idx+"_dragger_vertical"),$("#mCSB_"+o.idx+"_dragger_horizontal")],l=[a.height()/n.outerHeight(!1),a.width()/n.outerWidth(!1)],s=[parseInt(i[0].css("min-height")),Math.round(l[0]*i[0].parent().height()),parseInt(i[1].css("min-width")),Math.round(l[1]*i[1].parent().width())],c=r&&s[1]<s[0]?s[0]:s[1],d=r&&s[3]<s[2]?s[2]:s[3];i[0].css({height:c,"max-height":i[0].parent().height()-10}).find(".mCSB_dragger_bar").css({"line-height":s[0]+"px"}),i[1].css({width:d,"max-width":i[1].parent().width()-10})},S=function(){var e=$(this),o=e.data(t),a=$("#mCSB_"+o.idx),n=$("#mCSB_"+o.idx+"_container"),i=[$("#mCSB_"+o.idx+"_dragger_vertical"),$("#mCSB_"+o.idx+"_dragger_horizontal")],r=[n.outerHeight(!1)-a.height(),n.outerWidth(!1)-a.width()],l=[r[0]/(i[0].parent().height()-i[0].height()),r[1]/(i[1].parent().width()-i[1].width())];o.scrollRatio={y:l[0],x:l[1]}},b=function(e,t,o){var a=o?c[0]+"_expanded":"",n=e.closest(".mCSB_scrollTools");"active"===t?(e.toggleClass(c[0]+" "+a),n.toggleClass(c[1]),e[0]._draggable=e[0]._draggable?0:1):e[0]._draggable||("hide"===t?(e.removeClass(c[0]),n.removeClass(c[1])):(e.addClass(c[0]),n.addClass(c[1])))},C=function(){var e=$(this),o=e.data(t),a=$("#mCSB_"+o.idx),n=$("#mCSB_"+o.idx+"_container"),i=null==o.overflowed?n.height():n.outerHeight(!1),r=null==o.overflowed?n.width():n.outerWidth(!1),l=n[0].scrollHeight,s=n[0].scrollWidth;return l>i&&(i=l),s>r&&(r=s),[i>a.height(),r>a.width()]},y=function(){var e=$(this),o=e.data(t),a=o.opt,n=$("#mCSB_"+o.idx),i=$("#mCSB_"+o.idx+"_container"),r=[$("#mCSB_"+o.idx+"_dragger_vertical"),$("#mCSB_"+o.idx+"_dragger_horizontal")];if(j(e),("x"!==a.axis&&!o.overflowed[0]||"y"===a.axis&&o.overflowed[0])&&(r[0].add(i).css("top",0),N(e,"_resetY")),"y"!==a.axis&&!o.overflowed[1]||"x"===a.axis&&o.overflowed[1]){var l=dx=0;"rtl"===o.langDir&&(l=n.width()-i.outerWidth(!1),dx=Math.abs(l/o.scrollRatio.x)),i.css("left",l),r[1].css("left",dx),N(e,"_resetX")}},B=function(){function e(){i=setTimeout(function(){$.event.special.mousewheel?(clearTimeout(i),E.call(o[0])):e()},100)}var o=$(this),a=o.data(t),n=a.opt;if(!a.bindEvents){if(O.call(this),n.contentTouchScroll&&I.call(this),D.call(this),n.mouseWheel.enable){var i;e()}A.call(this),z.call(this),n.advanced.autoScrollOnFocus&&L.call(this),n.scrollButtons.enable&&P.call(this),n.keyboard.enable&&H.call(this),a.bindEvents=!0}},T=function(){var e=$(this),o=e.data(t),a=o.opt,n=t+"_"+o.idx,i=".mCSB_"+o.idx+"_scrollbar",r=$("#mCSB_"+o.idx+",#mCSB_"+o.idx+"_container,#mCSB_"+o.idx+"_container_wrapper,"+i+" ."+c[12]+",#mCSB_"+o.idx+"_dragger_vertical,#mCSB_"+o.idx+"_dragger_horizontal,"+i+">a"),l=$("#mCSB_"+o.idx+"_container");a.advanced.releaseDraggableSelectors&&r.add($(a.advanced.releaseDraggableSelectors)),a.advanced.extraDraggableSelectors&&r.add($(a.advanced.extraDraggableSelectors)),o.bindEvents&&($(document).add($(!R()||top.document)).unbind("."+n),r.each(function(){$(this).unbind("."+n)}),clearTimeout(e[0]._focusTimeout),J(e[0],"_focusTimeout"),clearTimeout(o.sequential.step),J(o.sequential,"step"),clearTimeout(l[0].onCompleteTimeout),J(l[0],"onCompleteTimeout"),o.bindEvents=!1)},k=function(e){var o=$(this),a=o.data(t),n=a.opt,i=$("#mCSB_"+a.idx+"_container_wrapper"),r=i.length?i:$("#mCSB_"+a.idx+"_container"),l=[$("#mCSB_"+a.idx+"_scrollbar_vertical"),$("#mCSB_"+a.idx+"_scrollbar_horizontal")],s=[l[0].find(".mCSB_dragger"),l[1].find(".mCSB_dragger")];"x"!==n.axis&&(a.overflowed[0]&&!e?(l[0].add(s[0]).add(l[0].children("a")).css("display","block"),r.removeClass(c[8]+" "+c[10])):(n.alwaysShowScrollbar?(2!==n.alwaysShowScrollbar&&s[0].css("display","none"),r.removeClass(c[10])):(l[0].css("display","none"),r.addClass(c[10])),r.addClass(c[8]))),"y"!==n.axis&&(a.overflowed[1]&&!e?(l[1].add(s[1]).add(l[1].children("a")).css("display","block"),r.removeClass(c[9]+" "+c[11])):(n.alwaysShowScrollbar?(2!==n.alwaysShowScrollbar&&s[1].css("display","none"),r.removeClass(c[11])):(l[1].css("display","none"),r.addClass(c[11])),r.addClass(c[9]))),a.overflowed[0]||a.overflowed[1]?o.removeClass(c[5]):o.addClass(c[5])},M=function(e){var t=e.type,o=e.target.ownerDocument!==document?[$(frameElement).offset().top,$(frameElement).offset().left]:null,a=R()&&e.target.ownerDocument!==top.document?[$(e.view.frameElement).offset().top,$(e.view.frameElement).offset().left]:[0,0];switch(t){case"pointerdown":case"MSPointerDown":case"pointermove":case"MSPointerMove":case"pointerup":case"MSPointerUp":return o?[e.originalEvent.pageY-o[0]+a[0],e.originalEvent.pageX-o[1]+a[1],!1]:[e.originalEvent.pageY,e.originalEvent.pageX,!1];break;case"touchstart":case"touchmove":case"touchend":var n=e.originalEvent.touches[0]||e.originalEvent.changedTouches[0],i=e.originalEvent.touches.length||e.originalEvent.changedTouches.length;return e.target.ownerDocument!==document?[n.screenY,n.screenX,i>1]:[n.pageY,n.pageX,i>1];break;default:return o?[e.pageY-o[0]+a[0],e.pageX-o[1]+a[1],!1]:[e.pageY,e.pageX,!1]}},O=function(){function e(e){var t=d.find("iframe");if(t.length){var o=e?"auto":"none";t.css("pointer-events",o)}}function o(e,t,o,r){if(d[0].idleTimer=i.scrollInertia<233?250:0,f.attr("id")===c[1])var l="x",s=(f[0].offsetLeft-t+r)*n.scrollRatio.x;else var l="y",s=(f[0].offsetTop-e+o)*n.scrollRatio.y;N(a,s.toString(),{dir:l,drag:!0})}var a=$(this),n=a.data(t),i=n.opt,s=t+"_"+n.idx,c=["mCSB_"+n.idx+"_dragger_vertical","mCSB_"+n.idx+"_dragger_horizontal"],d=$("#mCSB_"+n.idx+"_container"),u=$("#"+c[0]+",#"+c[1]),f,h,m,p=i.advanced.releaseDraggableSelectors?u.add($(i.advanced.releaseDraggableSelectors)):u,g=i.advanced.extraDraggableSelectors?$(!R()||top.document).add($(i.advanced.extraDraggableSelectors)):$(!R()||top.document);u.bind("mousedown."+s+" touchstart."+s+" pointerdown."+s+" MSPointerDown."+s,function(t){if(t.stopImmediatePropagation(),t.preventDefault(),K(t)){l=!0,r&&(document.onselectstart=function(){return!1}),e(!1),j(a),f=$(this);var o=f.offset(),n=M(t)[0]-o.top,s=M(t)[1]-o.left,c=f.height()+o.top,d=f.width()+o.left;c>n&&n>0&&d>s&&s>0&&(h=n,m=s),b(f,"active",i.autoExpandScrollbar)}}).bind("touchmove."+s,function(e){e.stopImmediatePropagation(),e.preventDefault();var t=f.offset(),a=M(e)[0]-t.top,n=M(e)[1]-t.left;o(h,m,a,n)}),$(document).add(g).bind("mousemove."+s+" pointermove."+s+" MSPointerMove."+s,function(e){if(f){var t=f.offset(),a=M(e)[0]-t.top,n=M(e)[1]-t.left;if(h===a&&m===n)return;o(h,m,a,n)}}).add(p).bind("mouseup."+s+" touchend."+s+" pointerup."+s+" MSPointerUp."+s,function(t){f&&(b(f,"active",i.autoExpandScrollbar),f=null),l=!1,r&&(document.onselectstart=null),e(!0)})},I=function(){function e(e){if(!Z(e)||l||M(e)[2])return void(s=0);s=1,A=0,L=0,g=1,c.removeClass("mCS_touch_action");var t=m.offset();v=M(e)[0]-t.top,x=M(e)[1]-t.left,W=[M(e)[0],M(e)[1]]}function o(e){if(Z(e)&&!l&&!M(e)[2]&&(u.documentTouchScroll||e.preventDefault(),e.stopImmediatePropagation(),(!L||A)&&g)){y=Q();var t=h.offset(),o=M(e)[0]-t.top,a=M(e)[1]-t.left,n="mcsLinearOut";if(S.push(o),b.push(a),W[2]=Math.abs(M(e)[0]-W[0]),W[3]=Math.abs(M(e)[1]-W[1]),d.overflowed[0])var i=p[0].parent().height()-p[0].height(),s=v-o>0&&o-v>-(i*d.scrollRatio.y)&&(2*W[3]<W[2]||"yx"===u.axis);if(d.overflowed[1])var f=p[1].parent().width()-p[1].width(),_=x-a>0&&a-x>-(f*d.scrollRatio.x)&&(2*W[2]<W[3]||"yx"===u.axis);s||_?(H||e.preventDefault(),A=1):(L=1,c.addClass("mCS_touch_action")),H&&e.preventDefault(),O="yx"===u.axis?[v-o,x-a]:"x"===u.axis?[null,x-a]:[v-o,null],m[0].idleTimer=250,d.overflowed[0]&&r(O[0],I,n,"y","all",!0),d.overflowed[1]&&r(O[1],I,n,"x",E,!0)}}function a(e){if(!Z(e)||l||M(e)[2])return void(s=0);s=1,e.stopImmediatePropagation(),j(c),C=Q();var t=h.offset();_=M(e)[0]-t.top,w=M(e)[1]-t.left,S=[],b=[]}function n(e){if(Z(e)&&!l&&!M(e)[2]){g=0,e.stopImmediatePropagation(),A=0,L=0,B=Q();var t=h.offset(),o=M(e)[0]-t.top,a=M(e)[1]-t.left;if(!(B-y>30)){k=1e3/(B-C);var n="mcsEaseOut",s=2.5>k,c=s?[S[S.length-2],b[b.length-2]]:[0,0];T=s?[o-c[0],a-c[1]]:[o-_,a-w];var f=[Math.abs(T[0]),Math.abs(T[1])];k=s?[Math.abs(T[0]/4),Math.abs(T[1]/4)]:[k,k];var p=[Math.abs(m[0].offsetTop)-T[0]*i(f[0]/k[0],k[0]),Math.abs(m[0].offsetLeft)-T[1]*i(f[1]/k[1],k[1])];O="yx"===u.axis?[p[0],p[1]]:"x"===u.axis?[null,p[1]]:[p[0],null],D=[4*f[0]+u.scrollInertia,4*f[1]+u.scrollInertia];var v=parseInt(u.contentTouchScroll)||0;O[0]=f[0]>v?O[0]:0,O[1]=f[1]>v?O[1]:0,d.overflowed[0]&&r(O[0],D[0],n,"y",E,!1),d.overflowed[1]&&r(O[1],D[1],n,"x",E,!1)}}}function i(e,t){var o=[1.5*t,2*t,t/1.5,t/2];return e>90?t>4?o[0]:o[3]:e>60?t>3?o[3]:o[2]:e>30?t>8?o[1]:t>6?o[0]:t>4?t:o[2]:t>8?t:o[3]}function r(e,t,o,a,n,i){e&&N(c,e.toString(),{dur:t,scrollEasing:o,dir:a,overwrite:n,drag:i})}var c=$(this),d=c.data(t),u=d.opt,f=t+"_"+d.idx,h=$("#mCSB_"+d.idx),m=$("#mCSB_"+d.idx+"_container"),p=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")],g,v,x,_,w,S=[],b=[],C,y,B,T,k,O,I=0,D,E="yx"===u.axis?"none":"all",W=[],A,L,z=m.find("iframe"),P=["touchstart."+f+" pointerdown."+f+" MSPointerDown."+f,"touchmove."+f+" pointermove."+f+" MSPointerMove."+f,"touchend."+f+" pointerup."+f+" MSPointerUp."+f],H=void 0!==document.body.style.touchAction;m.bind(P[0],function(t){e(t)}).bind(P[1],function(e){o(e)}),h.bind(P[0],function(e){a(e)}).bind(P[2],function(e){n(e)}),z.length&&z.each(function(){$(this).load(function(){R(this)&&$(this.contentDocument||this.contentWindow.document).bind(P[0],function(t){e(t),a(t)}).bind(P[1],function(e){o(e)}).bind(P[2],function(e){n(e)})})})},D=function(){function e(){return window.getSelection?window.getSelection().toString():document.selection&&"Control"!=document.selection.type?document.selection.createRange().text:0}function o(e,t,o){r.type=o&&f?"stepped":"stepless",r.scrollAmount=10,U(a,e,t,"mcsLinearOut",o?60:null)}var a=$(this),n=a.data(t),i=n.opt,r=n.sequential,c=t+"_"+n.idx,d=$("#mCSB_"+n.idx+"_container"),u=d.parent(),f;d.bind("mousedown."+c,function(e){s||f||(f=1,l=!0)}).add(document).bind("mousemove."+c,function(t){if(!s&&f&&e()){var a=d.offset(),l=M(t)[0]-a.top+d[0].offsetTop,c=M(t)[1]-a.left+d[0].offsetLeft;l>0&&l<u.height()&&c>0&&c<u.width()?r.step&&o("off",null,"stepped"):("x"!==i.axis&&n.overflowed[0]&&(0>l?o("on",38):l>u.height()&&o("on",40)),"y"!==i.axis&&n.overflowed[1]&&(0>c?o("on",37):c>u.width()&&o("on",39)))}}).bind("mouseup."+c+" dragend."+c,function(e){s||(f&&(f=0,o("off",null)),l=!1)})},E=function(){function e(e,t){if(j(o),!W(o,e.target)){var i="auto"!==n.mouseWheel.deltaFactor?parseInt(n.mouseWheel.deltaFactor):r&&e.deltaFactor<100?100:e.deltaFactor||100,c=n.scrollInertia;if("x"===n.axis||"x"===n.mouseWheel.axis)var d="x",u=[Math.round(i*a.scrollRatio.x),parseInt(n.mouseWheel.scrollAmount)],f="auto"!==n.mouseWheel.scrollAmount?u[1]:u[0]>=l.width()?.9*l.width():u[0],h=Math.abs($("#mCSB_"+a.idx+"_container")[0].offsetLeft),m=s[1][0].offsetLeft,p=s[1].parent().width()-s[1].width(),g=e.deltaX||e.deltaY||t;else var d="y",u=[Math.round(i*a.scrollRatio.y),parseInt(n.mouseWheel.scrollAmount)],f="auto"!==n.mouseWheel.scrollAmount?u[1]:u[0]>=l.height()?.9*l.height():u[0],h=Math.abs($("#mCSB_"+a.idx+"_container")[0].offsetTop),m=s[0][0].offsetTop,p=s[0].parent().height()-s[0].height(),g=e.deltaY||t;"y"===d&&!a.overflowed[0]||"x"===d&&!a.overflowed[1]||((n.mouseWheel.invert||e.webkitDirectionInvertedFromDevice)&&(g=-g),n.mouseWheel.normalizeDelta&&(g=0>g?-1:1),(g>0&&0!==m||0>g&&m!==p||n.mouseWheel.preventDefault)&&(e.stopImmediatePropagation(),e.preventDefault()),e.deltaFactor<2&&!n.mouseWheel.normalizeDelta&&(f=e.deltaFactor,c=17),N(o,(h-g*f).toString(),{dir:d,dur:c}))}}if($(this).data(t)){var o=$(this),a=o.data(t),n=a.opt,i=t+"_"+a.idx,l=$("#mCSB_"+a.idx),s=[$("#mCSB_"+a.idx+"_dragger_vertical"),$("#mCSB_"+a.idx+"_dragger_horizontal")],c=$("#mCSB_"+a.idx+"_container").find("iframe");c.length&&c.each(function(){$(this).load(function(){R(this)&&$(this.contentDocument||this.contentWindow.document).bind("mousewheel."+i,function(t,o){e(t,o)})})}),l.bind("mousewheel."+i,function(t,o){e(t,o)})}},R=function(e){var t=null;if(e){try{var o=e.contentDocument||e.contentWindow.document;t=o.body.innerHTML}catch(a){}return null!==t}try{var o=top.document;t=o.body.innerHTML}catch(a){}return null!==t},W=function(e,o){var a=o.nodeName.toLowerCase(),n=e.data(t).opt.mouseWheel.disableOver,i=["select","textarea"];return $.inArray(a,n)>-1&&!($.inArray(a,i)>-1&&!$(o).is(":focus"))},A=function(){var e=$(this),o=e.data(t),a=t+"_"+o.idx,n=$("#mCSB_"+o.idx+"_container"),i=n.parent(),r=$(".mCSB_"+o.idx+"_scrollbar ."+c[12]),s;r.bind("mousedown."+a+" touchstart."+a+" pointerdown."+a+" MSPointerDown."+a,function(e){l=!0,$(e.target).hasClass("mCSB_dragger")||(s=1)}).bind("touchend."+a+" pointerup."+a+" MSPointerUp."+a,function(e){l=!1}).bind("click."+a,function(t){if(s&&(s=0,$(t.target).hasClass(c[12])||$(t.target).hasClass("mCSB_draggerRail"))){j(e);var a=$(this),r=a.find(".mCSB_dragger");if(a.parent(".mCSB_scrollTools_horizontal").length>0){if(!o.overflowed[1])return;var l="x",d=t.pageX>r.offset().left?-1:1,u=Math.abs(n[0].offsetLeft)-d*(.9*i.width())}else{if(!o.overflowed[0])return;var l="y",d=t.pageY>r.offset().top?-1:1,u=Math.abs(n[0].offsetTop)-d*(.9*i.height())}N(e,u.toString(),{dir:l,scrollEasing:"mcsEaseInOut"})}})},L=function(){var e=$(this),o=e.data(t),a=o.opt,n=t+"_"+o.idx,i=$("#mCSB_"+o.idx+"_container"),r=i.parent();i.bind("focusin."+n,function(t){var o=$(document.activeElement),n=i.find(".mCustomScrollBox").length,l=0;o.is(a.advanced.autoScrollOnFocus)&&(j(e),clearTimeout(e[0]._focusTimeout),e[0]._focusTimer=n?(l+17)*n:0,e[0]._focusTimeout=setTimeout(function(){var t=[te(o)[0],te(o)[1]],n=[i[0].offsetTop,i[0].offsetLeft],s=[n[0]+t[0]>=0&&n[0]+t[0]<r.height()-o.outerHeight(!1),n[1]+t[1]>=0&&n[0]+t[1]<r.width()-o.outerWidth(!1)],c="yx"!==a.axis||s[0]||s[1]?"all":"none";"x"===a.axis||s[0]||N(e,t[0].toString(),{dir:"y",scrollEasing:"mcsEaseInOut",overwrite:c,dur:l}),"y"===a.axis||s[1]||N(e,t[1].toString(),{dir:"x",scrollEasing:"mcsEaseInOut",overwrite:c,dur:l})},e[0]._focusTimer))})},z=function(){var e=$(this),o=e.data(t),a=t+"_"+o.idx,n=$("#mCSB_"+o.idx+"_container").parent();n.bind("scroll."+a,function(e){(0!==n.scrollTop()||0!==n.scrollLeft())&&$(".mCSB_"+o.idx+"_scrollbar").css("visibility","hidden")})},P=function(){var e=$(this),o=e.data(t),a=o.opt,n=o.sequential,i=t+"_"+o.idx,r=".mCSB_"+o.idx+"_scrollbar",s=$(r+">a");s.bind("mousedown."+i+" touchstart."+i+" pointerdown."+i+" MSPointerDown."+i+" mouseup."+i+" touchend."+i+" pointerup."+i+" MSPointerUp."+i+" mouseout."+i+" pointerout."+i+" MSPointerOut."+i+" click."+i,function(t){function i(t,o){n.scrollAmount=a.scrollButtons.scrollAmount,U(e,t,o)}if(t.preventDefault(),K(t)){var r=$(this).attr("class");switch(n.type=a.scrollButtons.scrollType,t.type){case"mousedown":case"touchstart":case"pointerdown":case"MSPointerDown":if("stepped"===n.type)return;l=!0,o.tweenRunning=!1,i("on",r);break;case"mouseup":case"touchend":case"pointerup":case"MSPointerUp":case"mouseout":case"pointerout":case"MSPointerOut":if("stepped"===n.type)return;l=!1,n.dir&&i("off",r);break;case"click":if("stepped"!==n.type||o.tweenRunning)return;i("on",r)}}})},H=function(){function e(e){function t(e,t){i.type=n.keyboard.scrollType,i.scrollAmount=n.keyboard.scrollAmount,"stepped"===i.type&&a.tweenRunning||U(o,e,t)}switch(e.type){case"blur":a.tweenRunning&&i.dir&&t("off",null);break;case"keydown":case"keyup":var r=e.keyCode?e.keyCode:e.which,l="on";if("x"!==n.axis&&(38===r||40===r)||"y"!==n.axis&&(37===r||39===r)){if((38===r||40===r)&&!a.overflowed[0]||(37===r||39===r)&&!a.overflowed[1])return;"keyup"===e.type&&(l="off"),$(document.activeElement).is(d)||(e.preventDefault(),e.stopImmediatePropagation(),t(l,r))}else if(33===r||34===r){if((a.overflowed[0]||a.overflowed[1])&&(e.preventDefault(),e.stopImmediatePropagation()),"keyup"===e.type){j(o);var u=34===r?-1:1;if("x"===n.axis||"yx"===n.axis&&a.overflowed[1]&&!a.overflowed[0])var f="x",h=Math.abs(s[0].offsetLeft)-u*(.9*c.width());else var f="y",h=Math.abs(s[0].offsetTop)-u*(.9*c.height());N(o,h.toString(),{dir:f,scrollEasing:"mcsEaseInOut"})}}else if((35===r||36===r)&&!$(document.activeElement).is(d)&&((a.overflowed[0]||a.overflowed[1])&&(e.preventDefault(),e.stopImmediatePropagation()),"keyup"===e.type)){if("x"===n.axis||"yx"===n.axis&&a.overflowed[1]&&!a.overflowed[0])var f="x",h=35===r?Math.abs(c.width()-s.outerWidth(!1)):0;else var f="y",h=35===r?Math.abs(c.height()-s.outerHeight(!1)):0;N(o,h.toString(),{dir:f,scrollEasing:"mcsEaseInOut"})}}}var o=$(this),a=o.data(t),n=a.opt,i=a.sequential,r=t+"_"+a.idx,l=$("#mCSB_"+a.idx),s=$("#mCSB_"+a.idx+"_container"),c=s.parent(),d="input,textarea,select,datalist,keygen,[contenteditable='true']",u=s.find("iframe"),f=["blur."+r+" keydown."+r+" keyup."+r];u.length&&u.each(function(){$(this).load(function(){R(this)&&$(this.contentDocument||this.contentWindow.document).bind(f[0],function(t){e(t)})})}),l.attr("tabindex","0").bind(f[0],function(t){e(t)})},U=function(e,o,a,n,i){function r(t){d.snapAmount&&(u.scrollAmount=d.snapAmount instanceof Array?"x"===u.dir[0]?d.snapAmount[1]:d.snapAmount[0]:d.snapAmount);var o="stepped"!==u.type,a=i?i:t?o?m/1.5:p:1e3/60,l=t?o?7.5:40:2.5,c=[Math.abs(f[0].offsetTop),Math.abs(f[0].offsetLeft)],h=[s.scrollRatio.y>10?10:s.scrollRatio.y,s.scrollRatio.x>10?10:s.scrollRatio.x],g="x"===u.dir[0]?c[1]+u.dir[1]*(h[1]*l):c[0]+u.dir[1]*(h[0]*l),v="x"===u.dir[0]?c[1]+u.dir[1]*parseInt(u.scrollAmount):c[0]+u.dir[1]*parseInt(u.scrollAmount),x="auto"!==u.scrollAmount?v:g,_=n?n:t?o?"mcsLinearOut":"mcsEaseInOut":"mcsLinear",w=t?!0:!1;return t&&17>a&&(x="x"===u.dir[0]?c[1]:c[0]),N(e,x.toString(),{dir:u.dir[0],scrollEasing:_,dur:a,onComplete:w}),t?void(u.dir=!1):(clearTimeout(u.step),void(u.step=setTimeout(function(){r()},a)))}function l(){clearTimeout(u.step),J(u,"step"),j(e)}var s=e.data(t),d=s.opt,u=s.sequential,f=$("#mCSB_"+s.idx+"_container"),h="stepped"===u.type?!0:!1,m=d.scrollInertia<26?26:d.scrollInertia,p=d.scrollInertia<1?17:d.scrollInertia;switch(o){case"on":if(u.dir=[a===c[16]||a===c[15]||39===a||37===a?"x":"y",a===c[13]||a===c[15]||38===a||37===a?-1:1],j(e),ee(a)&&"stepped"===u.type)return;r(h);break;case"off":l(),(h||s.tweenRunning&&u.dir)&&r(!0)}},F=function(e){var o=$(this).data(t).opt,a=[];return"function"==typeof e&&(e=e()),e instanceof Array?a=e.length>1?[e[0],e[1]]:"x"===o.axis?[null,e[0]]:[e[0],null]:(a[0]=e.y?e.y:e.x||"x"===o.axis?null:e,a[1]=e.x?e.x:e.y||"y"===o.axis?null:e),"function"==typeof a[0]&&(a[0]=a[0]()),"function"==typeof a[1]&&(a[1]=a[1]()),a},q=function(e,o){if(null!=e&&"undefined"!=typeof e){var a=$(this),n=a.data(t),i=n.opt,r=$("#mCSB_"+n.idx+"_container"),l=r.parent(),s=typeof e;o||(o="x"===i.axis?"x":"y");var c="x"===o?r.outerWidth(!1):r.outerHeight(!1),u="x"===o?r[0].offsetLeft:r[0].offsetTop,f="x"===o?"left":"top";switch(s){case"function":return e();break;case"object":var h=e.jquery?e:$(e);if(!h.length)return;return"x"===o?te(h)[1]:te(h)[0];break;case"string":case"number":if(ee(e))return Math.abs(e);if(-1!==e.indexOf("%"))return Math.abs(c*parseInt(e)/100);if(-1!==e.indexOf("-="))return Math.abs(u-parseInt(e.split("-=")[1]));if(-1!==e.indexOf("+=")){var m=u+parseInt(e.split("+=")[1]);return m>=0?0:Math.abs(m)}if(-1!==e.indexOf("px")&&ee(e.split("px")[0]))return Math.abs(e.split("px")[0]);if("top"===e||"left"===e)return 0;if("bottom"===e)return Math.abs(l.height()-r.outerHeight(!1));if("right"===e)return Math.abs(l.width()-r.outerWidth(!1));if("first"===e||"last"===e){var h=r.find(":"+e);return"x"===o?te(h)[1]:te(h)[0]}return $(e).length?"x"===o?te($(e))[1]:te($(e))[0]:(r.css(f,e),void d.update.call(null,a[0]))}}},Y=function(e){function o(){return clearTimeout(u[0].autoUpdate),0===r.parents("html").length?void(r=null):void(u[0].autoUpdate=setTimeout(function(){return s.advanced.updateOnSelectorChange&&(l.poll.change.n=n(),l.poll.change.n!==l.poll.change.o)?(l.poll.change.o=l.poll.change.n,void i(3)):s.advanced.updateOnContentResize&&(l.poll.size.n=r[0].scrollHeight+r[0].scrollWidth+u[0].offsetHeight+r[0].offsetHeight+r[0].offsetWidth,l.poll.size.n!==l.poll.size.o)?(l.poll.size.o=l.poll.size.n,void i(1)):!s.advanced.updateOnImageLoad||"auto"===s.advanced.updateOnImageLoad&&"y"===s.axis||(l.poll.img.n=u.find("img").length,l.poll.img.n===l.poll.img.o)?void((s.advanced.updateOnSelectorChange||s.advanced.updateOnContentResize||s.advanced.updateOnImageLoad)&&o()):(l.poll.img.o=l.poll.img.n,void u.find("img").each(function(){a(this)}))},s.advanced.autoUpdateTimeout))}function a(e){function t(e,t){return function(){return t.apply(e,arguments)}}function o(){this.onload=null,$(e).addClass(c[2]),i(2)}if($(e).hasClass(c[2]))return void i();var a=new Image;a.onload=t(a,o),a.src=e.src}function n(){s.advanced.updateOnSelectorChange===!0&&(s.advanced.updateOnSelectorChange="*");var e=0,t=u.find(s.advanced.updateOnSelectorChange);
    return s.advanced.updateOnSelectorChange&&t.length>0&&t.each(function(){e+=this.offsetHeight+this.offsetWidth}),e}function i(e){clearTimeout(u[0].autoUpdate),d.update.call(null,r[0],e)}var r=$(this),l=r.data(t),s=l.opt,u=$("#mCSB_"+l.idx+"_container");return e?(clearTimeout(u[0].autoUpdate),void J(u[0],"autoUpdate")):void o()},X=function(e,t,o){return Math.round(e/t)*t-o},j=function(e){var o=e.data(t),a=$("#mCSB_"+o.idx+"_container,#mCSB_"+o.idx+"_container_wrapper,#mCSB_"+o.idx+"_dragger_vertical,#mCSB_"+o.idx+"_dragger_horizontal");a.each(function(){G.call(this)})},N=function(e,o,a){function n(e){return l&&s.callbacks[e]&&"function"==typeof s.callbacks[e]}function i(){return[s.callbacks.alwaysTriggerOffsets||_>=w[0]+C,s.callbacks.alwaysTriggerOffsets||-y>=_]}function r(){var t=[f[0].offsetTop,f[0].offsetLeft],o=[v[0].offsetTop,v[0].offsetLeft],n=[f.outerHeight(!1),f.outerWidth(!1)],i=[u.height(),u.width()];e[0].mcs={content:f,top:t[0],left:t[1],draggerTop:o[0],draggerLeft:o[1],topPct:Math.round(100*Math.abs(t[0])/(Math.abs(n[0])-i[0])),leftPct:Math.round(100*Math.abs(t[1])/(Math.abs(n[1])-i[1])),direction:a.dir}}var l=e.data(t),s=l.opt,c={trigger:"internal",dir:"y",scrollEasing:"mcsEaseOut",drag:!1,dur:s.scrollInertia,overwrite:"all",callbacks:!0,onStart:!0,onUpdate:!0,onComplete:!0},a=$.extend(c,a),d=[a.dur,a.drag?0:a.dur],u=$("#mCSB_"+l.idx),f=$("#mCSB_"+l.idx+"_container"),h=f.parent(),m=s.callbacks.onTotalScrollOffset?F.call(e,s.callbacks.onTotalScrollOffset):[0,0],p=s.callbacks.onTotalScrollBackOffset?F.call(e,s.callbacks.onTotalScrollBackOffset):[0,0];if(l.trigger=a.trigger,(0!==h.scrollTop()||0!==h.scrollLeft())&&($(".mCSB_"+l.idx+"_scrollbar").css("visibility","visible"),h.scrollTop(0).scrollLeft(0)),"_resetY"!==o||l.contentReset.y||(n("onOverflowYNone")&&s.callbacks.onOverflowYNone.call(e[0]),l.contentReset.y=1),"_resetX"!==o||l.contentReset.x||(n("onOverflowXNone")&&s.callbacks.onOverflowXNone.call(e[0]),l.contentReset.x=1),"_resetY"!==o&&"_resetX"!==o){if(!l.contentReset.y&&e[0].mcs||!l.overflowed[0]||(n("onOverflowY")&&s.callbacks.onOverflowY.call(e[0]),l.contentReset.x=null),!l.contentReset.x&&e[0].mcs||!l.overflowed[1]||(n("onOverflowX")&&s.callbacks.onOverflowX.call(e[0]),l.contentReset.x=null),s.snapAmount){var g=s.snapAmount instanceof Array?"x"===a.dir?s.snapAmount[1]:s.snapAmount[0]:s.snapAmount;o=X(o,g,s.snapOffset)}switch(a.dir){case"x":var v=$("#mCSB_"+l.idx+"_dragger_horizontal"),x="left",_=f[0].offsetLeft,w=[u.width()-f.outerWidth(!1),v.parent().width()-v.width()],S=[o,0===o?0:o/l.scrollRatio.x],C=m[1],y=p[1],B=C>0?C/l.scrollRatio.x:0,T=y>0?y/l.scrollRatio.x:0;break;case"y":var v=$("#mCSB_"+l.idx+"_dragger_vertical"),x="top",_=f[0].offsetTop,w=[u.height()-f.outerHeight(!1),v.parent().height()-v.height()],S=[o,0===o?0:o/l.scrollRatio.y],C=m[0],y=p[0],B=C>0?C/l.scrollRatio.y:0,T=y>0?y/l.scrollRatio.y:0}S[1]<0||0===S[0]&&0===S[1]?S=[0,0]:S[1]>=w[1]?S=[w[0],w[1]]:S[0]=-S[0],e[0].mcs||(r(),n("onInit")&&s.callbacks.onInit.call(e[0])),clearTimeout(f[0].onCompleteTimeout),V(v[0],x,Math.round(S[1]),d[1],a.scrollEasing),(l.tweenRunning||!(0===_&&S[0]>=0||_===w[0]&&S[0]<=w[0]))&&V(f[0],x,Math.round(S[0]),d[0],a.scrollEasing,a.overwrite,{onStart:function(){a.callbacks&&a.onStart&&!l.tweenRunning&&(n("onScrollStart")&&(r(),s.callbacks.onScrollStart.call(e[0])),l.tweenRunning=!0,b(v),l.cbOffsets=i())},onUpdate:function(){a.callbacks&&a.onUpdate&&n("whileScrolling")&&(r(),s.callbacks.whileScrolling.call(e[0]))},onComplete:function(){if(a.callbacks&&a.onComplete){"yx"===s.axis&&clearTimeout(f[0].onCompleteTimeout);var t=f[0].idleTimer||0;f[0].onCompleteTimeout=setTimeout(function(){n("onScroll")&&(r(),s.callbacks.onScroll.call(e[0])),n("onTotalScroll")&&S[1]>=w[1]-B&&l.cbOffsets[0]&&(r(),s.callbacks.onTotalScroll.call(e[0])),n("onTotalScrollBack")&&S[1]<=T&&l.cbOffsets[1]&&(r(),s.callbacks.onTotalScrollBack.call(e[0])),l.tweenRunning=!1,f[0].idleTimer=0,b(v,"hide")},t)}}})}},V=function(e,t,o,a,n,i,r){function l(){S.stop||(v||f.call(),v=Q()-p,s(),v>=S.time&&(S.time=v>S.time?v+g-(v-S.time):v+g-1,S.time<v+1&&(S.time=v+1)),S.time<a?S.id=w(l):m.call())}function s(){a>0?(S.currVal=u(S.time,x,b,a,n),_[t]=Math.round(S.currVal)+"px"):_[t]=o+"px",h.call()}function c(){g=1e3/60,S.time=v+g,w=window.requestAnimationFrame?window.requestAnimationFrame:function(e){return s(),setTimeout(e,.01)},S.id=w(l)}function d(){null!=S.id&&(window.requestAnimationFrame?window.cancelAnimationFrame(S.id):clearTimeout(S.id),S.id=null)}function u(e,t,o,a,n){switch(n){case"linear":case"mcsLinear":return o*e/a+t;break;case"mcsLinearOut":return e/=a,e--,o*Math.sqrt(1-e*e)+t;break;case"easeInOutSmooth":return e/=a/2,1>e?o/2*e*e+t:(e--,-o/2*(e*(e-2)-1)+t);break;case"easeInOutStrong":return e/=a/2,1>e?o/2*Math.pow(2,10*(e-1))+t:(e--,o/2*(-Math.pow(2,-10*e)+2)+t);break;case"easeInOut":case"mcsEaseInOut":return e/=a/2,1>e?o/2*e*e*e+t:(e-=2,o/2*(e*e*e+2)+t);break;case"easeOutSmooth":return e/=a,e--,-o*(e*e*e*e-1)+t;break;case"easeOutStrong":return o*(-Math.pow(2,-10*e/a)+1)+t;break;case"easeOut":case"mcsEaseOut":default:var i=(e/=a)*e,r=i*e;return t+o*(.499999999999997*r*i+-2.5*i*i+5.5*r+-6.5*i+4*e)}}e._mTween||(e._mTween={top:{},left:{}});var r=r||{},f=r.onStart||function(){},h=r.onUpdate||function(){},m=r.onComplete||function(){},p=Q(),g,v=0,x=e.offsetTop,_=e.style,w,S=e._mTween[t];"left"===t&&(x=e.offsetLeft);var b=o-x;S.stop=0,"none"!==i&&d(),c()},Q=function(){return window.performance&&window.performance.now?window.performance.now():window.performance&&window.performance.webkitNow?window.performance.webkitNow():Date.now?Date.now():(new Date).getTime()},G=function(){var e=this;e._mTween||(e._mTween={top:{},left:{}});for(var t=["top","left"],o=0;o<t.length;o++){var a=t[o];e._mTween[a].id&&(window.requestAnimationFrame?window.cancelAnimationFrame(e._mTween[a].id):clearTimeout(e._mTween[a].id),e._mTween[a].id=null,e._mTween[a].stop=1)}},J=function(e,t){try{delete e[t]}catch(o){e[t]=null}},K=function(e){return!(e.which&&1!==e.which)},Z=function(e){var t=e.originalEvent.pointerType;return!(t&&"touch"!==t&&2!==t)},ee=function(e){return!isNaN(parseFloat(e))&&isFinite(e)},te=function(e){var t=e.parents(".mCSB_container");return[e.offset().top-t.offset().top,e.offset().left-t.offset().left]},oe=function(){function e(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)if(e[t]+"Hidden"in document)return e[t]+"Hidden";return null}var t=e();return t?document[t]:!1};$.fn[e]=function(e){return d[e]?d[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?void $.error("Method "+e+" does not exist"):d.init.apply(this,arguments)},$[e]=function(e){return d[e]?d[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?void $.error("Method "+e+" does not exist"):d.init.apply(this,arguments)},$[e].defaults=a,window[e]=!0,$(window).load(function(){$(o)[e](),$.extend($.expr[":"],{mcsInView:$.expr[":"].mcsInView||function(e){var t=$(e),o=t.parents(".mCSB_container"),a,n;if(o.length)return a=o.parent(),n=[o[0].offsetTop,o[0].offsetLeft],n[0]+te(t)[0]>=0&&n[0]+te(t)[0]<a.height()-t.outerHeight(!1)&&n[1]+te(t)[1]>=0&&n[1]+te(t)[1]<a.width()-t.outerWidth(!1)},mcsOverflow:$.expr[":"].mcsOverflow||function(e){var o=$(e).data(t);if(o)return o.overflowed[0]||o.overflowed[1]}})})})});

/*!
 *  howler.js v2.0.0
 *  howlerjs.com
 *
 *  (c) 2013-2016, James Simpson of GoldFire Studios
 *  goldfirestudios.com
 *
 *  MIT License
 */
(function() {

    'use strict';

    /** Global Methods **/
    /***************************************************************************/

    /**
     * Create the global controller. All contained methods and properties apply
     * to all sounds that are currently playing or will be in the future.
     */
    var HowlerGlobal = function() {
        this.init();
    };
    HowlerGlobal.prototype = {
        /**
         * Initialize the global Howler object.
         * @return {Howler}
         */
        init: function() {
            var self = this || Howler;

            // Internal properties.
            self._codecs = {};
            self._howls = [];
            self._muted = false;
            self._volume = 1;
            self._canPlayEvent = 'canplaythrough';
            self._navigator = (typeof window !== 'undefined' && window.navigator) ? window.navigator : null;

            // Public properties.
            self.masterGain = null;
            self.noAudio = false;
            self.usingWebAudio = true;
            self.autoSuspend = true;
            self.ctx = null;

            // Set to false to disable the auto iOS enabler.
            self.mobileAutoEnable = true;

            // Setup the various state values for global tracking.
            self._setup();

            return self;
        },

        /**
         * Get/set the global volume for all sounds.
         * @param  {Float} vol Volume from 0.0 to 1.0.
         * @return {Howler/Float}     Returns self or current volume.
         */
        volume: function(vol) {
            var self = this || Howler;
            vol = parseFloat(vol);

            // If we don't have an AudioContext created yet, run the setup.
            if (!self.ctx) {
                setupAudioContext();
            }

            if (typeof vol !== 'undefined' && vol >= 0 && vol <= 1) {
                self._volume = vol;

                // Don't update any of the nodes if we are muted.
                if (self._muted) {
                    return self;
                }

                // When using Web Audio, we just need to adjust the master gain.
                if (self.usingWebAudio) {
                    self.masterGain.gain.value = vol;
                }

                // Loop through and change volume for all HTML5 audio nodes.
                for (var i=0; i<self._howls.length; i++) {
                    if (!self._howls[i]._webAudio) {
                        // Get all of the sounds in this Howl group.
                        var ids = self._howls[i]._getSoundIds();

                        // Loop through all sounds and change the volumes.
                        for (var j=0; j<ids.length; j++) {
                            var sound = self._howls[i]._soundById(ids[j]);

                            if (sound && sound._node) {
                                sound._node.volume = sound._volume * vol;
                            }
                        }
                    }
                }

                return self;
            }

            return self._volume;
        },

        /**
         * Handle muting and unmuting globally.
         * @param  {Boolean} muted Is muted or not.
         */
        mute: function(muted) {
            var self = this || Howler;

            // If we don't have an AudioContext created yet, run the setup.
            if (!self.ctx) {
                setupAudioContext();
            }

            self._muted = muted;

            // With Web Audio, we just need to mute the master gain.
            if (self.usingWebAudio) {
                self.masterGain.gain.value = muted ? 0 : self._volume;
            }

            // Loop through and mute all HTML5 Audio nodes.
            for (var i=0; i<self._howls.length; i++) {
                if (!self._howls[i]._webAudio) {
                    // Get all of the sounds in this Howl group.
                    var ids = self._howls[i]._getSoundIds();

                    // Loop through all sounds and mark the audio node as muted.
                    for (var j=0; j<ids.length; j++) {
                        var sound = self._howls[i]._soundById(ids[j]);

                        if (sound && sound._node) {
                            sound._node.muted = (muted) ? true : sound._muted;
                        }
                    }
                }
            }

            return self;
        },

        /**
         * Unload and destroy all currently loaded Howl objects.
         * @return {Howler}
         */
        unload: function() {
            var self = this || Howler;

            for (var i=self._howls.length-1; i>=0; i--) {
                self._howls[i].unload();
            }

            // Create a new AudioContext to make sure it is fully reset.
            if (self.usingWebAudio && typeof self.ctx.close !== 'undefined') {
                self.ctx.close();
                self.ctx = null;
                setupAudioContext();
            }

            return self;
        },

        /**
         * Check for codec support of specific extension.
         * @param  {String} ext Audio file extention.
         * @return {Boolean}
         */
        codecs: function(ext) {
            return (this || Howler)._codecs[ext];
        },

        /**
         * Setup various state values for global tracking.
         * @return {Howler}
         */
        _setup: function() {
            var self = this || Howler;

            // Keeps track of the suspend/resume state of the AudioContext.
            self.state = self.ctx ? self.ctx.state || 'running' : 'running';

            // Automatically begin the 30-second suspend process
            self._autoSuspend();

            // Check for supported codecs.
            if (!self.noAudio) {
                self._setupCodecs();
            }

            return self;
        },

        /**
         * Check for browser support for various codecs and cache the results.
         * @return {Howler}
         */
        _setupCodecs: function() {
            var self = this || Howler;
            var audioTest = (typeof Audio !== 'undefined') ? new Audio() : null;

            if (!audioTest || typeof audioTest.canPlayType !== 'function') {
                return self;
            }

            var mpegTest = audioTest.canPlayType('audio/mpeg;').replace(/^no$/, '');

            // Opera version <33 has mixed MP3 support, so we need to check for and block it.
            var checkOpera = self._navigator && self._navigator.userAgent.match(/OPR\/([0-6].)/g);
            var isOldOpera = (checkOpera && parseInt(checkOpera[0].split('/')[1], 10) < 33);

            self._codecs = {
                mp3: !!(!isOldOpera && (mpegTest || audioTest.canPlayType('audio/mp3;').replace(/^no$/, ''))),
                mpeg: !!mpegTest,
                opus: !!audioTest.canPlayType('audio/ogg; codecs="opus"').replace(/^no$/, ''),
                ogg: !!audioTest.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ''),
                oga: !!audioTest.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ''),
                wav: !!audioTest.canPlayType('audio/wav; codecs="1"').replace(/^no$/, ''),
                aac: !!audioTest.canPlayType('audio/aac;').replace(/^no$/, ''),
                caf: !!audioTest.canPlayType('audio/x-caf;').replace(/^no$/, ''),
                m4a: !!(audioTest.canPlayType('audio/x-m4a;') || audioTest.canPlayType('audio/m4a;') || audioTest.canPlayType('audio/aac;')).replace(/^no$/, ''),
                mp4: !!(audioTest.canPlayType('audio/x-mp4;') || audioTest.canPlayType('audio/mp4;') || audioTest.canPlayType('audio/aac;')).replace(/^no$/, ''),
                weba: !!audioTest.canPlayType('audio/webm; codecs="vorbis"').replace(/^no$/, ''),
                webm: !!audioTest.canPlayType('audio/webm; codecs="vorbis"').replace(/^no$/, ''),
                dolby: !!audioTest.canPlayType('audio/mp4; codecs="ec-3"').replace(/^no$/, '')
            };

            return self;
        },

        /**
         * Mobile browsers will only allow audio to be played after a user interaction.
         * Attempt to automatically unlock audio on the first user interaction.
         * Concept from: http://paulbakaus.com/tutorials/html5/web-audio-on-ios/
         * @return {Howler}
         */
        _enableMobileAudio: function() {
            var self = this || Howler;

            // Only run this on mobile devices if audio isn't already eanbled.
            var isMobile = /iPhone|iPad|iPod|Android|BlackBerry|BB10|Silk|Mobi/i.test(self._navigator && self._navigator.userAgent);
            var isTouch = !!(('ontouchend' in window) || (self._navigator && self._navigator.maxTouchPoints > 0) || (self._navigator && self._navigator.msMaxTouchPoints > 0));
            if (self._mobileEnabled || !self.ctx || (!isMobile && !isTouch)) {
                return;
            }

            self._mobileEnabled = false;

            // Some mobile devices/platforms have distortion issues when opening/closing tabs and/or web views.
            // Bugs in the browser (especially Mobile Safari) can cause the sampleRate to change from 44100 to 48000.
            // By calling Howler.unload(), we create a new AudioContext with the correct sampleRate.
            if (!self._mobileUnloaded && self.ctx.sampleRate !== 44100) {
                self._mobileUnloaded = true;
                self.unload();
            }

            // Scratch buffer for enabling iOS to dispose of web audio buffers correctly, as per:
            // http://stackoverflow.com/questions/24119684
            self._scratchBuffer = self.ctx.createBuffer(1, 1, 22050);

            // Call this method on touch start to create and play a buffer,
            // then check if the audio actually played to determine if
            // audio has now been unlocked on iOS, Android, etc.
            var unlock = function() {
                // Create an empty buffer.
                var source = self.ctx.createBufferSource();
                source.buffer = self._scratchBuffer;
                source.connect(self.ctx.destination);

                // Play the empty buffer.
                if (typeof source.start === 'undefined') {
                    source.noteOn(0);
                } else {
                    source.start(0);
                }

                // Setup a timeout to check that we are unlocked on the next event loop.
                source.onended = function() {
                    source.disconnect(0);

                    // Update the unlocked state and prevent this check from happening again.
                    self._mobileEnabled = true;
                    self.mobileAutoEnable = false;

                    // Remove the touch start listener.
                    document.removeEventListener('touchend', unlock, true);
                };
            };

            // Setup a touch start listener to attempt an unlock in.
            document.addEventListener('touchend', unlock, true);

            return self;
        },

        /**
         * Automatically suspend the Web Audio AudioContext after no sound has played for 30 seconds.
         * This saves processing/energy and fixes various browser-specific bugs with audio getting stuck.
         * @return {Howler}
         */
        _autoSuspend: function() {
            var self = this;

            if (!self.autoSuspend || !self.ctx || typeof self.ctx.suspend === 'undefined' || !Howler.usingWebAudio) {
                return;
            }

            // Check if any sounds are playing.
            for (var i=0; i<self._howls.length; i++) {
                if (self._howls[i]._webAudio) {
                    for (var j=0; j<self._howls[i]._sounds.length; j++) {
                        if (!self._howls[i]._sounds[j]._paused) {
                            return self;
                        }
                    }
                }
            }

            if (self._suspendTimer) {
                clearTimeout(self._suspendTimer);
            }

            // If no sound has played after 30 seconds, suspend the context.
            self._suspendTimer = setTimeout(function() {
                if (!self.autoSuspend) {
                    return;
                }

                self._suspendTimer = null;
                self.state = 'suspending';
                self.ctx.suspend().then(function() {
                    self.state = 'suspended';

                    if (self._resumeAfterSuspend) {
                        delete self._resumeAfterSuspend;
                        self._autoResume();
                    }
                });
            }, 30000);

            return self;
        },

        /**
         * Automatically resume the Web Audio AudioContext when a new sound is played.
         * @return {Howler}
         */
        _autoResume: function() {
            var self = this;

            if (!self.ctx || typeof self.ctx.resume === 'undefined' || !Howler.usingWebAudio) {
                return;
            }

            if (self.state === 'running' && self._suspendTimer) {
                clearTimeout(self._suspendTimer);
                self._suspendTimer = null;
            } else if (self.state === 'suspended') {
                self.state = 'resuming';
                self.ctx.resume().then(function() {
                    self.state = 'running';
                });

                if (self._suspendTimer) {
                    clearTimeout(self._suspendTimer);
                    self._suspendTimer = null;
                }
            } else if (self.state === 'suspending') {
                self._resumeAfterSuspend = true;
            }

            return self;
        }
    };

    // Setup the global audio controller.
    var Howler = new HowlerGlobal();

    /** Group Methods **/
    /***************************************************************************/

    /**
     * Create an audio group controller.
     * @param {Object} o Passed in properties for this group.
     */
    var Howl = function(o) {
        var self = this;

        // Throw an error if no source is provided.
        if (!o.src || o.src.length === 0) {
            console.error('An array of source files must be passed with any new Howl.');
            return;
        }

        self.init(o);
    };
    Howl.prototype = {
        /**
         * Initialize a new Howl group object.
         * @param  {Object} o Passed in properties for this group.
         * @return {Howl}
         */
        init: function(o) {
            var self = this;

            // If we don't have an AudioContext created yet, run the setup.
            if (!Howler.ctx) {
                setupAudioContext();
            }

            // Setup user-defined default properties.
            self._autoplay = o.autoplay || false;
            self._format = (typeof o.format !== 'string') ? o.format : [o.format];
            self._html5 = o.html5 || false;
            self._muted = o.mute || false;
            self._loop = o.loop || false;
            self._pool = o.pool || 5;
            self._preload = (typeof o.preload === 'boolean') ? o.preload : true;
            self._rate = o.rate || 1;
            self._sprite = o.sprite || {};
            self._src = (typeof o.src !== 'string') ? o.src : [o.src];
            self._volume = o.volume !== undefined ? o.volume : 1;

            // Setup all other default properties.
            self._duration = 0;
            self._state = 'unloaded';
            self._sounds = [];
            self._endTimers = {};
            self._queue = [];

            // Setup event listeners.
            self._onend = o.onend ? [{fn: o.onend}] : [];
            self._onfade = o.onfade ? [{fn: o.onfade}] : [];
            self._onload = o.onload ? [{fn: o.onload}] : [];
            self._onloaderror = o.onloaderror ? [{fn: o.onloaderror}] : [];
            self._onpause = o.onpause ? [{fn: o.onpause}] : [];
            self._onplay = o.onplay ? [{fn: o.onplay}] : [];
            self._onstop = o.onstop ? [{fn: o.onstop}] : [];
            self._onmute = o.onmute ? [{fn: o.onmute}] : [];
            self._onvolume = o.onvolume ? [{fn: o.onvolume}] : [];
            self._onrate = o.onrate ? [{fn: o.onrate}] : [];
            self._onseek = o.onseek ? [{fn: o.onseek}] : [];
            self._onxhrprogress = o.onxhrprogress ? [{fn: o.onxhrprogress}] : [];

            // Web Audio or HTML5 Audio?
            self._webAudio = Howler.usingWebAudio && !self._html5;

            // Automatically try to enable audio on iOS.
            if (typeof Howler.ctx !== 'undefined' && Howler.ctx && Howler.mobileAutoEnable) {
                Howler._enableMobileAudio();
            }

            // Keep track of this Howl group in the global controller.
            Howler._howls.push(self);

            // Load the source file unless otherwise specified.
            if (self._preload) {
                self.load();
            }

            return self;
        },

        /**
         * Load the audio file.
         * @return {Howler}
         */
        load: function() {
            var self = this;
            var url = null;

            // If no audio is available, quit immediately.
            if (Howler.noAudio) {
                self._emit('loaderror', null, 'No audio support.');
                return;
            }

            // Make sure our source is in an array.
            if (typeof self._src === 'string') {
                self._src = [self._src];
            }

            // Loop through the sources and pick the first one that is compatible.
            for (var i=0; i<self._src.length; i++) {
                var ext, str;

                if (self._format && self._format[i]) {
                    // If an extension was specified, use that instead.
                    ext = self._format[i];
                } else {
                    // Make sure the source is a string.
                    str = self._src[i];
                    if (typeof str !== 'string') {
                        self._emit('loaderror', null, 'Non-string found in selected audio sources - ignoring.');
                        continue;
                    }

                    // Extract the file extension from the URL or base64 data URI.
                    ext = /^data:audio\/([^;,]+);/i.exec(str);
                    if (!ext) {
                        ext = /\.([^.]+)$/.exec(str.split('?', 1)[0]);
                    }

                    if (ext) {
                        ext = ext[1].toLowerCase();
                    }
                }

                // Check if this extension is available.
                if (Howler.codecs(ext)) {
                    url = self._src[i];
                    break;
                }
            }

            if (!url) {
                self._emit('loaderror', null, 'No codec support for selected audio sources.');
                return;
            }

            self._src = url;
            self._state = 'loading';

            // If the hosting page is HTTPS and the source isn't,
            // drop down to HTML5 Audio to avoid Mixed Content errors.
            if (window.location.protocol === 'https:' && url.slice(0, 5) === 'http:') {
                self._html5 = true;
                self._webAudio = false;
            }

            // Create a new sound object and add it to the pool.
            new Sound(self);

            // Load and decode the audio data for playback.
            if (self._webAudio) {
                loadBuffer(self);
            }

            return self;
        },

        /**
         * Play a sound or resume previous playback.
         * @param  {String/Number} sprite   Sprite name for sprite playback or sound id to continue previous.
         * @param  {Boolean} internal Internal Use: true prevents event firing.
         * @return {Number}          Sound ID.
         */
        play: function(sprite, internal) {
            var self = this;
            var id = null;

            // Determine if a sprite, sound id or nothing was passed
            if (typeof sprite === 'number') {
                id = sprite;
                sprite = null;
            } else if (typeof sprite === 'string' && self._state === 'loaded' && !self._sprite[sprite]) {
                // If the passed sprite doesn't exist, do nothing.
                return null;
            } else if (typeof sprite === 'undefined') {
                // Use the default sound sprite (plays the full audio length).
                sprite = '__default';

                // Check if there is a single paused sound that isn't ended.
                // If there is, play that sound. If not, continue as usual.
                var num = 0;
                for (var i=0; i<self._sounds.length; i++) {
                    if (self._sounds[i]._paused && !self._sounds[i]._ended) {
                        num++;
                        id = self._sounds[i]._id;
                    }
                }

                if (num === 1) {
                    sprite = null;
                } else {
                    id = null;
                }
            }

            // Get the selected node, or get one from the pool.
            var sound = id ? self._soundById(id) : self._inactiveSound();

            // If the sound doesn't exist, do nothing.
            if (!sound) {
                return null;
            }

            // Select the sprite definition.
            if (id && !sprite) {
                sprite = sound._sprite || '__default';
            }

            // If we have no sprite and the sound hasn't loaded, we must wait
            // for the sound to load to get our audio's duration.
            if (self._state !== 'loaded' && !self._sprite[sprite]) {
                self._queue.push({
                    event: 'play',
                    action: function() {
                        self.play(self._soundById(sound._id) ? sound._id : undefined);
                    }
                });

                return sound._id;
            }

            // Don't play the sound if an id was passed and it is already playing.
            if (id && !sound._paused) {
                // Trigger the play event, in order to keep iterating through queue.
                if (!internal) {
                    setTimeout(function() {
                        self._emit('play', sound._id);
                    }, 0);
                }

                return sound._id;
            }

            // Make sure the AudioContext isn't suspended, and resume it if it is.
            if (self._webAudio) {
                Howler._autoResume();
            }

            // Determine how long to play for and where to start playing.
            var seek = sound._seek > 0 ? sound._seek : self._sprite[sprite][0] / 1000;
            var duration = ((self._sprite[sprite][0] + self._sprite[sprite][1]) / 1000) - seek;
            var timeout = (duration * 1000) / Math.abs(sound._rate);

            // Update the parameters of the sound
            sound._paused = false;
            sound._ended = false;
            sound._sprite = sprite;
            sound._seek = seek;
            sound._start = self._sprite[sprite][0] / 1000;
            sound._stop = (self._sprite[sprite][0] + self._sprite[sprite][1]) / 1000;
            sound._loop = !!(sound._loop || self._sprite[sprite][2]);

            // Begin the actual playback.
            var node = sound._node;
            if (self._webAudio) {
                // Fire this when the sound is ready to play to begin Web Audio playback.
                var playWebAudio = function() {
                    self._refreshBuffer(sound);

                    // Setup the playback params.
                    var vol = (sound._muted || self._muted) ? 0 : sound._volume;
                    node.gain.setValueAtTime(vol, Howler.ctx.currentTime);
                    sound._playStart = Howler.ctx.currentTime;

                    // Play the sound using the supported method.
                    if (typeof node.bufferSource.start === 'undefined') {
                        sound._loop ? node.bufferSource.noteGrainOn(0, seek, 86400) : node.bufferSource.noteGrainOn(0, seek, duration);
                    } else {
                        sound._loop ? node.bufferSource.start(0, seek, 86400) : node.bufferSource.start(0, seek, duration);
                    }

                    // Start a new timer if none is present.
                    if (timeout !== Infinity) {
                        self._endTimers[sound._id] = setTimeout(self._ended.bind(self, sound), timeout);
                    }

                    if (!internal) {
                        setTimeout(function() {
                            self._emit('play', sound._id);
                        }, 0);
                    }
                };

                if (self._state === 'loaded') {
                    playWebAudio();
                } else {
                    // Wait for the audio to load and then begin playback.
                    self.once('load', playWebAudio, sound._id);

                    // Cancel the end timer.
                    self._clearTimer(sound._id);
                }
            } else {
                // Fire this when the sound is ready to play to begin HTML5 Audio playback.
                var playHtml5 = function() {
                    node.currentTime = seek;
                    node.muted = sound._muted || self._muted || Howler._muted || node.muted;
                    node.volume = sound._volume * Howler.volume();
                    node.playbackRate = sound._rate;

                    setTimeout(function() {
                        node.play();

                        // Setup the new end timer.
                        if (timeout !== Infinity) {
                            self._endTimers[sound._id] = setTimeout(self._ended.bind(self, sound), timeout);
                        }

                        if (!internal) {
                            self._emit('play', sound._id);
                        }
                    }, 0);
                };

                // Play immediately if ready, or wait for the 'canplaythrough'e vent.
                var loadedNoReadyState = (self._state === 'loaded' && (window && window.ejecta || !node.readyState && Howler._navigator.isCocoonJS));
                if (node.readyState === 4 || loadedNoReadyState) {
                    playHtml5();
                } else {
                    var listener = function() {
                        // Begin playback.
                        playHtml5();

                        // Clear this listener.
                        node.removeEventListener(Howler._canPlayEvent, listener, false);
                    };
                    node.addEventListener(Howler._canPlayEvent, listener, false);

                    // Cancel the end timer.
                    self._clearTimer(sound._id);
                }
            }

            return sound._id;
        },

        /**
         * Pause playback and save current position.
         * @param  {Number} id The sound ID (empty to pause all in group).
         * @return {Howl}
         */
        pause: function(id) {
            var self = this;

            // If the sound hasn't loaded, add it to the load queue to pause when capable.
            if (self._state !== 'loaded') {
                self._queue.push({
                    event: 'pause',
                    action: function() {
                        self.pause(id);
                    }
                });

                return self;
            }

            // If no id is passed, get all ID's to be paused.
            var ids = self._getSoundIds(id);

            for (var i=0; i<ids.length; i++) {
                // Clear the end timer.
                self._clearTimer(ids[i]);

                // Get the sound.
                var sound = self._soundById(ids[i]);

                if (sound && !sound._paused) {
                    // Reset the seek position.
                    sound._seek = self.seek(ids[i]);
                    sound._rateSeek = 0;
                    sound._paused = true;

                    // Stop currently running fades.
                    self._stopFade(ids[i]);

                    if (sound._node) {
                        if (self._webAudio) {
                            // make sure the sound has been created
                            if (!sound._node.bufferSource) {
                                return self;
                            }

                            if (typeof sound._node.bufferSource.stop === 'undefined') {
                                sound._node.bufferSource.noteOff(0);
                            } else {
                                sound._node.bufferSource.stop(0);
                            }

                            // Clean up the buffer source.
                            self._cleanBuffer(sound._node);
                        } else if (!isNaN(sound._node.duration) || sound._node.duration === Infinity) {
                            sound._node.pause();
                        }
                    }

                    // Fire the pause event, unless `true` is passed as the 2nd argument.
                    if (!arguments[1]) {
                        self._emit('pause', sound._id);
                    }
                }
            }

            return self;
        },

        /**
         * Stop playback and reset to start.
         * @param  {Number} id The sound ID (empty to stop all in group).
         * @param  {Boolean} internal Internal Use: true prevents event firing.
         * @return {Howl}
         */
        stop: function(id, internal) {
            var self = this;

            // If the sound hasn't loaded, add it to the load queue to stop when capable.
            if (self._state !== 'loaded') {
                self._queue.push({
                    event: 'stop',
                    action: function() {
                        self.stop(id);
                    }
                });

                return self;
            }

            // If no id is passed, get all ID's to be stopped.
            var ids = self._getSoundIds(id);

            for (var i=0; i<ids.length; i++) {
                // Clear the end timer.
                self._clearTimer(ids[i]);

                // Get the sound.
                var sound = self._soundById(ids[i]);

                if (sound && !sound._paused) {
                    // Reset the seek position.
                    sound._seek = sound._start || 0;
                    sound._rateSeek = 0;
                    sound._paused = true;
                    sound._ended = true;

                    // Stop currently running fades.
                    self._stopFade(ids[i]);

                    if (sound._node) {
                        if (self._webAudio) {
                            // make sure the sound has been created
                            if (!sound._node.bufferSource) {
                                return self;
                            }

                            if (typeof sound._node.bufferSource.stop === 'undefined') {
                                sound._node.bufferSource.noteOff(0);
                            } else {
                                sound._node.bufferSource.stop(0);
                            }

                            // Clean up the buffer source.
                            self._cleanBuffer(sound._node);
                        } else if (!isNaN(sound._node.duration) || sound._node.duration === Infinity) {
                            sound._node.currentTime = sound._start || 0;
                            sound._node.pause();
                        }
                    }
                }

                if (sound && !internal) {
                    self._emit('stop', sound._id);
                }
            }

            return self;
        },

        /**
         * Mute/unmute a single sound or all sounds in this Howl group.
         * @param  {Boolean} muted Set to true to mute and false to unmute.
         * @param  {Number} id    The sound ID to update (omit to mute/unmute all).
         * @return {Howl}
         */
        mute: function(muted, id) {
            var self = this;

            // If the sound hasn't loaded, add it to the load queue to mute when capable.
            if (self._state !== 'loaded') {
                self._queue.push({
                    event: 'mute',
                    action: function() {
                        self.mute(muted, id);
                    }
                });

                return self;
            }

            // If applying mute/unmute to all sounds, update the group's value.
            if (typeof id === 'undefined') {
                if (typeof muted === 'boolean') {
                    self._muted = muted;
                } else {
                    return self._muted;
                }
            }

            // If no id is passed, get all ID's to be muted.
            var ids = self._getSoundIds(id);

            for (var i=0; i<ids.length; i++) {
                // Get the sound.
                var sound = self._soundById(ids[i]);

                if (sound) {
                    sound._muted = muted;

                    if (self._webAudio && sound._node) {
                        sound._node.gain.setValueAtTime(muted ? 0 : sound._volume, Howler.ctx.currentTime);
                    } else if (sound._node) {
                        sound._node.muted = Howler._muted ? true : muted;
                    }

                    self._emit('mute', sound._id);
                }
            }

            return self;
        },

        /**
         * Get/set the volume of this sound or of the Howl group. This method can optionally take 0, 1 or 2 arguments.
         *   volume() -> Returns the group's volume value.
         *   volume(id) -> Returns the sound id's current volume.
         *   volume(vol) -> Sets the volume of all sounds in this Howl group.
         *   volume(vol, id) -> Sets the volume of passed sound id.
         * @return {Howl/Number} Returns self or current volume.
         */
        volume: function() {
            var self = this;
            var args = arguments;
            var vol, id;

            // Determine the values based on arguments.
            if (args.length === 0) {
                // Return the value of the groups' volume.
                return self._volume;
            } else if (args.length === 1) {
                // First check if this is an ID, and if not, assume it is a new volume.
                var ids = self._getSoundIds();
                var index = ids.indexOf(args[0]);
                if (index >= 0) {
                    id = parseInt(args[0], 10);
                } else {
                    vol = parseFloat(args[0]);
                }
            } else if (args.length >= 2) {
                vol = parseFloat(args[0]);
                id = parseInt(args[1], 10);
            }

            // Update the volume or return the current volume.
            var sound;
            if (typeof vol !== 'undefined' && vol >= 0 && vol <= 1) {
                // If the sound hasn't loaded, add it to the load queue to change volume when capable.
                if (self._state !== 'loaded') {
                    self._queue.push({
                        event: 'volume',
                        action: function() {
                            self.volume.apply(self, args);
                        }
                    });

                    return self;
                }

                // Set the group volume.
                if (typeof id === 'undefined') {
                    self._volume = vol;
                }

                // Update one or all volumes.
                id = self._getSoundIds(id);
                for (var i=0; i<id.length; i++) {
                    // Get the sound.
                    sound = self._soundById(id[i]);

                    if (sound) {
                        sound._volume = vol;

                        // Stop currently running fades.
                        if (!args[2]) {
                            self._stopFade(id[i]);
                        }

                        if (self._webAudio && sound._node && !sound._muted) {
                            sound._node.gain.setValueAtTime(vol, Howler.ctx.currentTime);
                        } else if (sound._node && !sound._muted) {
                            sound._node.volume = vol * Howler.volume();
                        }

                        self._emit('volume', sound._id);
                    }
                }
            } else {
                sound = id ? self._soundById(id) : self._sounds[0];
                return sound ? sound._volume : 0;
            }

            return self;
        },

        /**
         * Fade a currently playing sound between two volumes (if no id is passsed, all sounds will fade).
         * @param  {Number} from The value to fade from (0.0 to 1.0).
         * @param  {Number} to   The volume to fade to (0.0 to 1.0).
         * @param  {Number} len  Time in milliseconds to fade.
         * @param  {Number} id   The sound id (omit to fade all sounds).
         * @return {Howl}
         */
        fade: function(from, to, len, id) {
            var self = this;
            var diff = Math.abs(from - to);
            var dir = from > to ? 'out' : 'in';
            var steps = diff / 0.01;
            var stepLen = len / steps;

            // If the sound hasn't loaded, add it to the load queue to fade when capable.
            if (self._state !== 'loaded') {
                self._queue.push({
                    event: 'fade',
                    action: function() {
                        self.fade(from, to, len, id);
                    }
                });

                return self;
            }

            // Set the volume to the start position.
            self.volume(from, id);

            // Fade the volume of one or all sounds.
            var ids = self._getSoundIds(id);
            for (var i=0; i<ids.length; i++) {
                // Get the sound.
                var sound = self._soundById(ids[i]);

                // Create a linear fade or fall back to timeouts with HTML5 Audio.
                if (sound) {
                    // Stop the previous fade if no sprite is being used (otherwise, volume handles this).
                    if (!id) {
                        self._stopFade(ids[i]);
                    }

                    // If we are using Web Audio, let the native methods do the actual fade.
                    if (self._webAudio && !sound._muted) {
                        var currentTime = Howler.ctx.currentTime;
                        var end = currentTime + (len / 1000);
                        sound._volume = from;
                        sound._node.gain.setValueAtTime(from, currentTime);
                        sound._node.gain.linearRampToValueAtTime(to, end);
                    }

                    var vol = from;
                    sound._interval = setInterval(function(soundId, sound) {
                        // Update the volume amount.
                        vol += (dir === 'in' ? 0.01 : -0.01);

                        // Make sure the volume is in the right bounds.
                        vol = Math.max(0, vol);
                        vol = Math.min(1, vol);

                        // Round to within 2 decimal points.
                        vol = Math.round(vol * 100) / 100;

                        // Change the volume.
                        if (self._webAudio) {
                            if (typeof id === 'undefined') {
                                self._volume = vol;
                            }

                            sound._volume = vol;
                        } else {
                            self.volume(vol, soundId, true);
                        }

                        // When the fade is complete, stop it and fire event.
                        if (vol === to) {
                            clearInterval(sound._interval);
                            sound._interval = null;
                            self.volume(vol, soundId);
                            self._emit('fade', soundId);
                        }
                    }.bind(self, ids[i], sound), stepLen);
                }
            }

            return self;
        },

        /**
         * Internal method that stops the currently playing fade when
         * a new fade starts, volume is changed or the sound is stopped.
         * @param  {Number} id The sound id.
         * @return {Howl}
         */
        _stopFade: function(id) {
            var self = this;
            var sound = self._soundById(id);

            if (sound && sound._interval) {
                if (self._webAudio) {
                    sound._node.gain.cancelScheduledValues(Howler.ctx.currentTime);
                }

                clearInterval(sound._interval);
                sound._interval = null;
                self._emit('fade', id);
            }

            return self;
        },

        /**
         * Get/set the loop parameter on a sound. This method can optionally take 0, 1 or 2 arguments.
         *   loop() -> Returns the group's loop value.
         *   loop(id) -> Returns the sound id's loop value.
         *   loop(loop) -> Sets the loop value for all sounds in this Howl group.
         *   loop(loop, id) -> Sets the loop value of passed sound id.
         * @return {Howl/Boolean} Returns self or current loop value.
         */
        loop: function() {
            var self = this;
            var args = arguments;
            var loop, id, sound;

            // Determine the values for loop and id.
            if (args.length === 0) {
                // Return the grou's loop value.
                return self._loop;
            } else if (args.length === 1) {
                if (typeof args[0] === 'boolean') {
                    loop = args[0];
                    self._loop = loop;
                } else {
                    // Return this sound's loop value.
                    sound = self._soundById(parseInt(args[0], 10));
                    return sound ? sound._loop : false;
                }
            } else if (args.length === 2) {
                loop = args[0];
                id = parseInt(args[1], 10);
            }

            // If no id is passed, get all ID's to be looped.
            var ids = self._getSoundIds(id);
            for (var i=0; i<ids.length; i++) {
                sound = self._soundById(ids[i]);

                if (sound) {
                    sound._loop = loop;
                    if (self._webAudio && sound._node && sound._node.bufferSource) {
                        sound._node.bufferSource.loop = loop;
                    }
                }
            }

            return self;
        },

        /**
         * Get/set the playback rate of a sound. This method can optionally take 0, 1 or 2 arguments.
         *   rate() -> Returns the first sound node's current playback rate.
         *   rate(id) -> Returns the sound id's current playback rate.
         *   rate(rate) -> Sets the playback rate of all sounds in this Howl group.
         *   rate(rate, id) -> Sets the playback rate of passed sound id.
         * @return {Howl/Number} Returns self or the current playback rate.
         */
        rate: function() {
            var self = this;
            var args = arguments;
            var rate, id;

            // Determine the values based on arguments.
            if (args.length === 0) {
                // We will simply return the current rate of the first node.
                id = self._sounds[0]._id;
            } else if (args.length === 1) {
                // First check if this is an ID, and if not, assume it is a new rate value.
                var ids = self._getSoundIds();
                var index = ids.indexOf(args[0]);
                if (index >= 0) {
                    id = parseInt(args[0], 10);
                } else {
                    rate = parseFloat(args[0]);
                }
            } else if (args.length === 2) {
                rate = parseFloat(args[0]);
                id = parseInt(args[1], 10);
            }

            // Update the playback rate or return the current value.
            var sound;
            if (typeof rate === 'number') {
                // If the sound hasn't loaded, add it to the load queue to change playback rate when capable.
                if (self._state !== 'loaded') {
                    self._queue.push({
                        event: 'rate',
                        action: function() {
                            self.rate.apply(self, args);
                        }
                    });

                    return self;
                }

                // Set the group rate.
                if (typeof id === 'undefined') {
                    self._rate = rate;
                }

                // Update one or all volumes.
                id = self._getSoundIds(id);
                for (var i=0; i<id.length; i++) {
                    // Get the sound.
                    sound = self._soundById(id[i]);

                    if (sound) {
                        // Keep track of our position when the rate changed and update the playback
                        // start position so we can properly adjust the seek position for time elapsed.
                        sound._rateSeek = self.seek(id[i]);
                        sound._playStart = self._webAudio ? Howler.ctx.currentTime : sound._playStart;
                        sound._rate = rate;

                        // Change the playback rate.
                        if (self._webAudio && sound._node && sound._node.bufferSource) {
                            sound._node.bufferSource.playbackRate.value = rate;
                        } else if (sound._node) {
                            sound._node.playbackRate = rate;
                        }

                        // Reset the timers.
                        var seek = self.seek(id[i]);
                        var duration = ((self._sprite[sound._sprite][0] + self._sprite[sound._sprite][1]) / 1000) - seek;
                        var timeout = (duration * 1000) / Math.abs(sound._rate);

                        // Start a new end timer if sound is already playing.
                        if (self._endTimers[id[i]] || !sound._paused) {
                            self._clearTimer(id[i]);
                            self._endTimers[id[i]] = setTimeout(self._ended.bind(self, sound), timeout);
                        }

                        self._emit('rate', sound._id);
                    }
                }
            } else {
                sound = self._soundById(id);
                return sound ? sound._rate : self._rate;
            }

            return self;
        },

        /**
         * Get/set the seek position of a sound. This method can optionally take 0, 1 or 2 arguments.
         *   seek() -> Returns the first sound node's current seek position.
         *   seek(id) -> Returns the sound id's current seek position.
         *   seek(seek) -> Sets the seek position of the first sound node.
         *   seek(seek, id) -> Sets the seek position of passed sound id.
         * @return {Howl/Number} Returns self or the current seek position.
         */
        seek: function() {
            var self = this;
            var args = arguments;
            var seek, id;

            // Determine the values based on arguments.
            if (args.length === 0) {
                // We will simply return the current position of the first node.
                id = self._sounds[0]._id;
            } else if (args.length === 1) {
                // First check if this is an ID, and if not, assume it is a new seek position.
                var ids = self._getSoundIds();
                var index = ids.indexOf(args[0]);
                if (index >= 0) {
                    id = parseInt(args[0], 10);
                } else {
                    id = self._sounds[0]._id;
                    seek = parseFloat(args[0]);
                }
            } else if (args.length === 2) {
                seek = parseFloat(args[0]);
                id = parseInt(args[1], 10);
            }

            // If there is no ID, bail out.
            if (typeof id === 'undefined') {
                return self;
            }

            // If the sound hasn't loaded, add it to the load queue to seek when capable.
            if (self._state !== 'loaded') {
                self._queue.push({
                    event: 'seek',
                    action: function() {
                        self.seek.apply(self, args);
                    }
                });

                return self;
            }

            // Get the sound.
            var sound = self._soundById(id);

            if (sound) {
                if (typeof seek === 'number' && seek >= 0) {
                    // Pause the sound and update position for restarting playback.
                    var playing = self.playing(id);
                    if (playing) {
                        self.pause(id, true);
                    }

                    // Move the position of the track and cancel timer.
                    sound._seek = seek;
                    sound._ended = false;
                    self._clearTimer(id);

                    // Restart the playback if the sound was playing.
                    if (playing) {
                        self.play(id, true);
                    }

                    // Update the seek position for HTML5 Audio.
                    if (!self._webAudio && sound._node) {
                        sound._node.currentTime = seek;
                    }

                    self._emit('seek', id);
                } else {
                    if (self._webAudio) {
                        var realTime = self.playing(id) ? Howler.ctx.currentTime - sound._playStart : 0;
                        var rateSeek = sound._rateSeek ? sound._rateSeek - sound._seek : 0;
                        return sound._seek + (rateSeek + realTime * Math.abs(sound._rate));
                    } else {
                        return sound._node.currentTime;
                    }
                }
            }

            return self;
        },

        /**
         * Check if a specific sound is currently playing or not (if id is provided), or check if at least one of the sounds in the group is playing or not.
         * @param  {Number}  id The sound id to check. If none is passed, the whole sound group is checked.
         * @return {Boolean} True if playing and false if not.
         */
        playing: function(id) {
            var self = this;

            // Check the passed sound ID (if any).
            if (typeof id === 'number') {
                var sound = self._soundById(id);
                return sound ? !sound._paused : false;
            }

            // Otherwise, loop through all sounds and check if any are playing.
            for (var i=0; i<self._sounds.length; i++) {
                if (!self._sounds[i]._paused) {
                    return true;
                }
            }

            return false;
        },

        /**
         * Get the duration of this sound. Passing a sound id will return the sprite duration.
         * @param  {Number} id The sound id to check. If none is passed, return full source duration.
         * @return {Number} Audio duration in seconds.
         */
        duration: function(id) {
            var self = this;
            var duration = self._duration;

            // If we pass an ID, get the sound and return the sprite length.
            var sound = self._soundById(id);
            if (sound) {
                duration = self._sprite[sound._sprite][1] / 1000;
            }

            return duration;
        },

        /**
         * Returns the current loaded state of this Howl.
         * @return {String} 'unloaded', 'loading', 'loaded'
         */
        state: function() {
            return this._state;
        },

        /**
         * Unload and destroy the current Howl object.
         * This will immediately stop all sound instances attached to this group.
         */
        unload: function() {
            var self = this;

            // Stop playing any active sounds.
            var sounds = self._sounds;
            for (var i=0; i<sounds.length; i++) {
                // Stop the sound if it is currently playing.
                if (!sounds[i]._paused) {
                    self.stop(sounds[i]._id);
                    self._emit('end', sounds[i]._id);
                }

                // Remove the source or disconnect.
                if (!self._webAudio) {
                    // Set the source to 0-second silence to stop any downloading.
                    sounds[i]._node.src = 'data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YQAAAAA=';

                    // Remove any event listeners.
                    sounds[i]._node.removeEventListener('error', sounds[i]._errorFn, false);
                    sounds[i]._node.removeEventListener(Howler._canPlayEvent, sounds[i]._loadFn, false);
                }

                // Empty out all of the nodes.
                delete sounds[i]._node;

                // Make sure all timers are cleared out.
                self._clearTimer(sounds[i]._id);

                // Remove the references in the global Howler object.
                var index = Howler._howls.indexOf(self);
                if (index >= 0) {
                    Howler._howls.splice(index, 1);
                }
            }

            // Delete this sound from the cache (if no other Howl is using it).
            var remCache = true;
            for (i=0; i<Howler._howls.length; i++) {
                if (Howler._howls[i]._src === self._src) {
                    remCache = false;
                    break;
                }
            }

            if (cache && remCache) {
                delete cache[self._src];
            }

            // Clear out `self`.
            self._state = 'unloaded';
            self._sounds = [];
            self = null;

            return null;
        },

        /**
         * Listen to a custom event.
         * @param  {String}   event Event name.
         * @param  {Function} fn    Listener to call.
         * @param  {Number}   id    (optional) Only listen to events for this sound.
         * @param  {Number}   once  (INTERNAL) Marks event to fire only once.
         * @return {Howl}
         */
        on: function(event, fn, id, once) {
            var self = this;
            var events = self['_on' + event];

            if (typeof fn === 'function') {
                events.push(once ? {id: id, fn: fn, once: once} : {id: id, fn: fn});
            }

            return self;
        },

        /**
         * Remove a custom event. Call without parameters to remove all events.
         * @param  {String}   event Event name.
         * @param  {Function} fn    Listener to remove. Leave empty to remove all.
         * @param  {Number}   id    (optional) Only remove events for this sound.
         * @return {Howl}
         */
        off: function(event, fn, id) {
            var self = this;
            var events = self['_on' + event];
            var i = 0;

            if (fn) {
                // Loop through event store and remove the passed function.
                for (i=0; i<events.length; i++) {
                    if (fn === events[i].fn && id === events[i].id) {
                        events.splice(i, 1);
                        break;
                    }
                }
            } else if (event) {
                // Clear out all events of this type.
                self['_on' + event] = [];
            } else {
                // Clear out all events of every type.
                var keys = Object.keys(self);
                for (i=0; i<keys.length; i++) {
                    if ((keys[i].indexOf('_on') === 0) && Array.isArray(self[keys[i]])) {
                        self[keys[i]] = [];
                    }
                }
            }

            return self;
        },

        /**
         * Listen to a custom event and remove it once fired.
         * @param  {String}   event Event name.
         * @param  {Function} fn    Listener to call.
         * @param  {Number}   id    (optional) Only listen to events for this sound.
         * @return {Howl}
         */
        once: function(event, fn, id) {
            var self = this;

            // Setup the event listener.
            self.on(event, fn, id, 1);

            return self;
        },

        /**
         * Emit all events of a specific type and pass the sound id.
         * @param  {String} event Event name.
         * @param  {Number} id    Sound ID.
         * @param  {Number} msg   Message to go with event.
         * @return {Howl}
         */
        _emit: function(event, id, msg) {
            var self = this;
            var events = self['_on' + event];

            // Loop through event store and fire all functions.
            for (var i=events.length-1; i>=0; i--) {
                if (!events[i].id || events[i].id === id || event === 'load') {
                    setTimeout(function(fn) {
                        fn.call(this, id, msg);
                    }.bind(self, events[i].fn), 0);

                    // If this event was setup with `once`, remove it.
                    if (events[i].once) {
                        self.off(event, events[i].fn, events[i].id);
                    }
                }
            }

            return self;
        },

        /**
         * Queue of actions initiated before the sound has loaded.
         * These will be called in sequence, with the next only firing
         * after the previous has finished executing (even if async like play).
         * @return {Howl}
         */
        _loadQueue: function() {
            var self = this;

            if (self._queue.length > 0) {
                var task = self._queue[0];

                // don't move onto the next task until this one is done
                self.once(task.event, function() {
                    self._queue.shift();
                    self._loadQueue();
                });

                task.action();
            }

            return self;
        },

        /**
         * Fired when playback ends at the end of the duration.
         * @param  {Sound} sound The sound object to work with.
         * @return {Howl}
         */
        _ended: function(sound) {
            var self = this;
            var sprite = sound._sprite;

            // Should this sound loop?
            var loop = !!(sound._loop || self._sprite[sprite][2]);

            // Fire the ended event.
            self._emit('end', sound._id);

            // Restart the playback for HTML5 Audio loop.
            if (!self._webAudio && loop) {
                self.stop(sound._id, true).play(sound._id);
            }

            // Restart this timer if on a Web Audio loop.
            if (self._webAudio && loop) {
                self._emit('play', sound._id);
                sound._seek = sound._start || 0;
                sound._rateSeek = 0;
                sound._playStart = Howler.ctx.currentTime;

                var timeout = ((sound._stop - sound._start) * 1000) / Math.abs(sound._rate);
                self._endTimers[sound._id] = setTimeout(self._ended.bind(self, sound), timeout);
            }

            // Mark the node as paused.
            if (self._webAudio && !loop) {
                sound._paused = true;
                sound._ended = true;
                sound._seek = sound._start || 0;
                sound._rateSeek = 0;
                self._clearTimer(sound._id);

                // Clean up the buffer source.
                self._cleanBuffer(sound._node);

                // Attempt to auto-suspend AudioContext if no sounds are still playing.
                Howler._autoSuspend();
            }

            // When using a sprite, end the track.
            if (!self._webAudio && !loop) {
                self.stop(sound._id);
            }

            return self;
        },

        /**
         * Clear the end timer for a sound playback.
         * @param  {Number} id The sound ID.
         * @return {Howl}
         */
        _clearTimer: function(id) {
            var self = this;

            if (self._endTimers[id]) {
                clearTimeout(self._endTimers[id]);
                delete self._endTimers[id];
            }

            return self;
        },

        /**
         * Return the sound identified by this ID, or return null.
         * @param  {Number} id Sound ID
         * @return {Object}    Sound object or null.
         */
        _soundById: function(id) {
            var self = this;

            // Loop through all sounds and find the one with this ID.
            for (var i=0; i<self._sounds.length; i++) {
                if (id === self._sounds[i]._id) {
                    return self._sounds[i];
                }
            }

            return null;
        },

        /**
         * Return an inactive sound from the pool or create a new one.
         * @return {Sound} Sound playback object.
         */
        _inactiveSound: function() {
            var self = this;

            self._drain();

            // Find the first inactive node to recycle.
            for (var i=0; i<self._sounds.length; i++) {
                if (self._sounds[i]._ended) {
                    return self._sounds[i].reset();
                }
            }

            // If no inactive node was found, create a new one.
            return new Sound(self);
        },

        /**
         * Drain excess inactive sounds from the pool.
         */
        _drain: function() {
            var self = this;
            var limit = self._pool;
            var cnt = 0;
            var i = 0;

            // If there are less sounds than the max pool size, we are done.
            if (self._sounds.length < limit) {
                return;
            }

            // Count the number of inactive sounds.
            for (i=0; i<self._sounds.length; i++) {
                if (self._sounds[i]._ended) {
                    cnt++;
                }
            }

            // Remove excess inactive sounds, going in reverse order.
            for (i=self._sounds.length - 1; i>=0; i--) {
                if (cnt <= limit) {
                    return;
                }

                if (self._sounds[i]._ended) {
                    // Disconnect the audio source when using Web Audio.
                    if (self._webAudio && self._sounds[i]._node) {
                        self._sounds[i]._node.disconnect(0);
                    }

                    // Remove sounds until we have the pool size.
                    self._sounds.splice(i, 1);
                    cnt--;
                }
            }
        },

        /**
         * Get all ID's from the sounds pool.
         * @param  {Number} id Only return one ID if one is passed.
         * @return {Array}    Array of IDs.
         */
        _getSoundIds: function(id) {
            var self = this;

            if (typeof id === 'undefined') {
                var ids = [];
                for (var i=0; i<self._sounds.length; i++) {
                    ids.push(self._sounds[i]._id);
                }

                return ids;
            } else {
                return [id];
            }
        },

        /**
         * Load the sound back into the buffer source.
         * @param  {Sound} sound The sound object to work with.
         * @return {Howl}
         */
        _refreshBuffer: function(sound) {
            var self = this;

            // Setup the buffer source for playback.
            sound._node.bufferSource = Howler.ctx.createBufferSource();
            sound._node.bufferSource.buffer = cache[self._src];

            // Connect to the correct node.
            if (sound._panner) {
                sound._node.bufferSource.connect(sound._panner);
            } else {
                sound._node.bufferSource.connect(sound._node);
            }

            // Setup looping and playback rate.
            sound._node.bufferSource.loop = sound._loop;
            if (sound._loop) {
                sound._node.bufferSource.loopStart = sound._start || 0;
                sound._node.bufferSource.loopEnd = sound._stop;
            }
            sound._node.bufferSource.playbackRate.value = sound._rate;

            return self;
        },

        /**
         * Prevent memory leaks by cleaning up the buffer source after playback.
         * @param  {Object} node Sound's audio node containing the buffer source.
         * @return {Howl}
         */
        _cleanBuffer: function(node) {
            var self = this;

            if (self._scratchBuffer) {
                node.bufferSource.onended = null;
                node.bufferSource.disconnect(0);
                try { node.bufferSource.buffer = self._scratchBuffer; } catch(e) {}
            }
            node.bufferSource = null;

            return self;
        }
    };

    /** Single Sound Methods **/
    /***************************************************************************/

    /**
     * Setup the sound object, which each node attached to a Howl group is contained in.
     * @param {Object} howl The Howl parent group.
     */
    var Sound = function(howl) {
        this._parent = howl;
        this.init();
    };
    Sound.prototype = {
        /**
         * Initialize a new Sound object.
         * @return {Sound}
         */
        init: function() {
            var self = this;
            var parent = self._parent;

            // Setup the default parameters.
            self._muted = parent._muted;
            self._loop = parent._loop;
            self._volume = parent._volume;
            self._muted = parent._muted;
            self._rate = parent._rate;
            self._seek = 0;
            self._paused = true;
            self._ended = true;
            self._sprite = '__default';

            // Generate a unique ID for this sound.
            self._id = Math.round(Date.now() * Math.random());

            // Add itself to the parent's pool.
            parent._sounds.push(self);

            // Create the new node.
            self.create();

            return self;
        },

        /**
         * Create and setup a new sound object, whether HTML5 Audio or Web Audio.
         * @return {Sound}
         */
        create: function() {
            var self = this;
            var parent = self._parent;
            var volume = (Howler._muted || self._muted || self._parent._muted) ? 0 : self._volume;

            if (parent._webAudio) {
                // Create the gain node for controlling volume (the source will connect to this).
                self._node = (typeof Howler.ctx.createGain === 'undefined') ? Howler.ctx.createGainNode() : Howler.ctx.createGain();
                self._node.gain.setValueAtTime(volume, Howler.ctx.currentTime);
                self._node.paused = true;
                self._node.connect(Howler.masterGain);
            } else {
                self._node = new Audio();

                // Listen for errors (http://dev.w3.org/html5/spec-author-view/spec.html#mediaerror).
                self._errorFn = self._errorListener.bind(self);
                self._node.addEventListener('error', self._errorFn, false);

                // Listen for 'canplaythrough' event to let us know the sound is ready.
                self._loadFn = self._loadListener.bind(self);
                self._node.addEventListener(Howler._canPlayEvent, self._loadFn, false);

                // Setup the new audio node.
                self._node.src = parent._src;
                self._node.preload = 'auto';
                self._node.volume = volume * Howler.volume();

                // Begin loading the source.
                self._node.load();
            }

            return self;
        },

        /**
         * Reset the parameters of this sound to the original state (for recycle).
         * @return {Sound}
         */
        reset: function() {
            var self = this;
            var parent = self._parent;

            // Reset all of the parameters of this sound.
            self._muted = parent._muted;
            self._loop = parent._loop;
            self._volume = parent._volume;
            self._muted = parent._muted;
            self._rate = parent._rate;
            self._seek = 0;
            self._rateSeek = 0;
            self._paused = true;
            self._ended = true;
            self._sprite = '__default';

            // Generate a new ID so that it isn't confused with the previous sound.
            self._id = Math.round(Date.now() * Math.random());

            return self;
        },

        /**
         * HTML5 Audio error listener callback.
         */
        _errorListener: function() {
            var self = this;

            if (self._node.error && self._node.error.code === 4) {
                Howler.noAudio = true;
            }

            // Fire an error event and pass back the code.
            self._parent._emit('loaderror', self._id, self._node.error ? self._node.error.code : 0);

            // Clear the event listener.
            self._node.removeEventListener('error', self._errorListener, false);
        },

        /**
         * HTML5 Audio canplaythrough listener callback.
         */
        _loadListener: function() {
            var self = this;
            var parent = self._parent;

            // Round up the duration to account for the lower precision in HTML5 Audio.
            parent._duration = Math.ceil(self._node.duration * 10) / 10;

            // Setup a sprite if none is defined.
            if (Object.keys(parent._sprite).length === 0) {
                parent._sprite = {__default: [0, parent._duration * 1000]};
            }

            if (parent._state !== 'loaded') {
                parent._state = 'loaded';
                parent._emit('load');
                parent._loadQueue();
            }

            if (parent._autoplay) {
                parent.play();
            }

            // Clear the event listener.
            self._node.removeEventListener(Howler._canPlayEvent, self._loadFn, false);
        }
    };

    /** Helper Methods **/
    /***************************************************************************/

    var cache = {};

    /**
     * Buffer a sound from URL, Data URI or cache and decode to audio source (Web Audio API).
     * @param  {Howl} self
     */
    var loadBuffer = function(self) {
        var url = self._src;

        // Check if the buffer has already been cached and use it instead.
        if (cache[url]) {
            // Set the duration from the cache.
            self._duration = cache[url].duration;

            // Load the sound into this Howl.
            loadSound(self);

            return;
        }

        if (/^data:[^;]+;base64,/.test(url)) {
            // Decode the base64 data URI without XHR, since some browsers don't support it.
            var data = atob(url.split(',')[1]);
            var dataView = new Uint8Array(data.length);
            for (var i=0; i<data.length; ++i) {
                dataView[i] = data.charCodeAt(i);
            }

            decodeAudioData(dataView.buffer, self);
        } else {
            // Load the buffer from the URL.
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.responseType = 'arraybuffer';
            xhr.onload = function() {
                // Make sure we get a successful response back.
                var code = (xhr.status + '')[0];
                if (code !== '0' && code !== '2' && code !== '3') {
                    self._emit('loaderror', null, 'Failed loading audio file with status: ' + xhr.status + '.');
                    return;
                }

                decodeAudioData(xhr.response, self);
            };
            xhr.onerror = function() {
                // If there is an error, switch to HTML5 Audio.
                if (self._webAudio) {
                    self._html5 = true;
                    self._webAudio = false;
                    self._sounds = [];
                    delete cache[url];
                    self.load();
                }
            };
            xhr.onprogress =  function(oEvent) {
                self._emit('xhrprogress', oEvent);
            };
            safeXhrSend(xhr);
        }
    };

    /**
     * Send the XHR request wrapped in a try/catch.
     * @param  {Object} xhr XHR to send.
     */
    var safeXhrSend = function(xhr) {
        try {
            xhr.send();
        } catch (e) {
            xhr.onerror();
        }
    };

    /**
     * Decode audio data from an array buffer.
     * @param  {ArrayBuffer} arraybuffer The audio data.
     * @param  {Howl}        self
     */
    var decodeAudioData = function(arraybuffer, self) {
        // Decode the buffer into an audio source.
        Howler.ctx.decodeAudioData(arraybuffer, function(buffer) {
            if (buffer && self._sounds.length > 0) {
                cache[self._src] = buffer;
                loadSound(self, buffer);
            }
        }, function() {
            self._emit('loaderror', null, 'Decoding audio data failed.');
        });
    };

    /**
     * Sound is now loaded, so finish setting everything up and fire the loaded event.
     * @param  {Howl} self
     * @param  {Object} buffer The decoded buffer sound source.
     */
    var loadSound = function(self, buffer) {
        // Set the duration.
        if (buffer && !self._duration) {
            self._duration = buffer.duration;
        }

        // Setup a sprite if none is defined.
        if (Object.keys(self._sprite).length === 0) {
            self._sprite = {__default: [0, self._duration * 1000]};
        }

        // Fire the loaded event.
        if (self._state !== 'loaded') {
            self._state = 'loaded';
            self._emit('load');
            self._loadQueue();
        }

        // Begin playback if specified.
        if (self._autoplay) {
            self.play();
        }
    };

    /**
     * Setup the audio context when available, or switch to HTML5 Audio mode.
     */
    var setupAudioContext = function() {
        Howler.noAudio = false;

        // Check if we are using Web Audio and setup the AudioContext if we are.
        try {
            if (typeof AudioContext !== 'undefined') {
                Howler.ctx = new AudioContext();
            } else if (typeof webkitAudioContext !== 'undefined') {
                Howler.ctx = new webkitAudioContext();
            } else {
                Howler.usingWebAudio = false;
            }
        } catch(e) {
            Howler.usingWebAudio = false;
        }

        if (!Howler.usingWebAudio) {
            // No audio is available on this system if noAudio is set to true.
            if (typeof Audio !== 'undefined') {
                try {
                    var test = new Audio();

                    // Check if the canplaythrough event is available.
                    if (typeof test.oncanplaythrough === 'undefined') {
                        Howler._canPlayEvent = 'canplay';
                    }
                } catch(e) {
                    Howler.noAudio = true;
                }
            } else {
                Howler.noAudio = true;
            }
        }

        // Test to make sure audio isn't disabled in Internet Explorer
        try {
            var test = new Audio();
            if (test.muted) {
                Howler.noAudio = true;
            }
        } catch (e) {}

        // Check if a webview is being used on iOS8 or earlier (rather than the browser).
        // If it is, disable Web Audio as it causes crashing.
        var iOS = (/iP(hone|od|ad)/.test(Howler._navigator && Howler._navigator.platform));
        var appVersion = Howler._navigator && Howler._navigator.appVersion.match(/OS (\d+)_(\d+)_?(\d+)?/);
        var version = appVersion ? parseInt(appVersion[1], 10) : null;
        if (iOS && version && version < 9) {
            var safari = /safari/.test(Howler._navigator && Howler._navigator.userAgent.toLowerCase());
            if (Howler._navigator && Howler._navigator.standalone && !safari || Howler._navigator && !Howler._navigator.standalone && !safari) {
                Howler.usingWebAudio = false;
            }
        }

        // Create and expose the master GainNode when using Web Audio (useful for plugins or advanced usage).
        if (Howler.usingWebAudio) {
            Howler.masterGain = (typeof Howler.ctx.createGain === 'undefined') ? Howler.ctx.createGainNode() : Howler.ctx.createGain();
            Howler.masterGain.gain.value = 1;
            Howler.masterGain.connect(Howler.ctx.destination);
        }

        // Re-run the setup on Howler.
        Howler._setup();
    };

    // Add support for AMD (Asynchronous Module Definition) libraries such as require.js.
    if (typeof define === 'function' && define.amd) {
        define([], function() {
            return {
                Howler: Howler,
                Howl: Howl
            };
        });
    }

    // Add support for CommonJS libraries such as browserify.
    if (typeof exports !== 'undefined') {
        exports.Howler = Howler;
        exports.Howl = Howl;
    }

    // Define globally in case AMD is not available or unused.
    if (typeof window !== 'undefined') {
        window.HowlerGlobal = HowlerGlobal;
        window.Howler = Howler;
        window.Howl = Howl;
        window.Sound = Sound;
    } else if (typeof global !== 'undefined') { // Add to global in Node.js (for testing, etc).
        global.HowlerGlobal = HowlerGlobal;
        global.Howler = Howler;
        global.Howl = Howl;
        global.Sound = Sound;
    }
})();


/*!
 *  Spatial Plugin - Adds support for stereo and 3D audio where Web Audio is supported.
 *
 *  howler.js v2.0.0
 *  howlerjs.com
 *
 *  (c) 2013-2016, James Simpson of GoldFire Studios
 *  goldfirestudios.com
 *
 *  MIT License
 */

(function() {

    'use strict';

    // Setup default properties.
    HowlerGlobal.prototype._pos = [0, 0, 0];
    HowlerGlobal.prototype._orientation = [0, 0, -1, 0, 1, 0];

    /** Global Methods **/
    /***************************************************************************/

    /**
     * Helper method to update the stereo panning position of all current Howls.
     * Future Howls will not use this value unless explicitly set.
     * @param  {Number} pan A value of -1.0 is all the way left and 1.0 is all the way right.
     * @return {Howler/Number}     Self or current stereo panning value.
     */
    HowlerGlobal.prototype.stereo = function(pan) {
        var self = this;

        // Stop right here if not using Web Audio.
        if (!self.ctx || !self.ctx.listener) {
            return self;
        }

        // Loop through all Howls and update their stereo panning.
        for (var i=self._howls.length-1; i>=0; i--) {
            self._howls[i].stereo(pan);
        }

        return self;
    };

    /**
     * Get/set the position of the listener in 3D cartesian space. Sounds using
     * 3D position will be relative to the listener's position.
     * @param  {Number} x The x-position of the listener.
     * @param  {Number} y The y-position of the listener.
     * @param  {Number} z The z-position of the listener.
     * @return {Howler/Array}   Self or current listener position.
     */
    HowlerGlobal.prototype.pos = function(x, y, z) {
        var self = this;

        // Stop right here if not using Web Audio.
        if (!self.ctx || !self.ctx.listener) {
            return self;
        }

        // Set the defaults for optional 'y' & 'z'.
        y = (typeof y !== 'number') ? self._pos[1] : y;
        z = (typeof z !== 'number') ? self._pos[2] : z;

        if (typeof x === 'number') {
            self._pos = [x, y, z];
            self.ctx.listener.setPosition(self._pos[0], self._pos[1], self._pos[2]);
        } else {
            return self._pos;
        }

        return self;
    };

    /**
     * Get/set the direction the listener is pointing in the 3D cartesian space.
     * A front and up vector must be provided. The front is the direction the
     * face of the listener is pointing, and up is the direction the top of the
     * listener is pointing. Thus, these values are expected to be at right angles
     * from each other.
     * @param  {Number} x   The x-orientation of the listener.
     * @param  {Number} y   The y-orientation of the listener.
     * @param  {Number} z   The z-orientation of the listener.
     * @param  {Number} xUp The x-orientation of the top of the listener.
     * @param  {Number} yUp The y-orientation of the top of the listener.
     * @param  {Number} zUp The z-orientation of the top of the listener.
     * @return {Howler/Array}     Returns self or the current orientation vectors.
     */
    HowlerGlobal.prototype.orientation = function(x, y, z, xUp, yUp, zUp) {
        var self = this;

        // Stop right here if not using Web Audio.
        if (!self.ctx || !self.ctx.listener) {
            return self;
        }

        // Set the defaults for optional 'y' & 'z'.
        var or = self._orientation;
        y = (typeof y !== 'number') ? or[1] : y;
        z = (typeof z !== 'number') ? or[2] : z;
        xUp = (typeof xUp !== 'number') ? or[3] : xUp;
        yUp = (typeof yUp !== 'number') ? or[4] : yUp;
        zUp = (typeof zUp !== 'number') ? or[5] : zUp;

        if (typeof x === 'number') {
            self._orientation = [x, y, z, xUp, yUp, zUp];
            self.ctx.listener.setOrientation(x, y, z, xUp, yUp, zUp);
        } else {
            return or;
        }

        return self;
    };

    /** Group Methods **/
    /***************************************************************************/

    /**
     * Add new properties to the core init.
     * @param  {Function} _super Core init method.
     * @return {Howl}
     */
    Howl.prototype.init = (function(_super) {
        return function(o) {
            var self = this;

            // Setup user-defined default properties.
            self._orientation = o.orientation || [1, 0, 0];
            self._stereo = o.stereo || null;
            self._pos = o.pos || null;
            self._pannerAttr = {
                coneInnerAngle: typeof o.coneInnerAngle !== 'undefined' ? o.coneInnerAngle : 360,
                coneOuterAngle: typeof o.coneOuterAngle !== 'undefined' ? o.coneOuterAngle : 360,
                coneOuterGain: typeof o.coneOuterGain !== 'undefined' ? o.coneOuterGain : 0,
                distanceModel: typeof o.distanceModel !== 'undefined' ? o.distanceModel : 'inverse',
                maxDistance: typeof o.maxDistance !== 'undefined' ? o.maxDistance : 10000,
                panningModel: typeof o.panningModel !== 'undefined' ? o.panningModel : 'HRTF',
                refDistance: typeof o.refDistance !== 'undefined' ? o.refDistance : 1,
                rolloffFactor: typeof o.rolloffFactor !== 'undefined' ? o.rolloffFactor : 1
            };

            // Setup event listeners.
            self._onstereo = o.onstereo ? [{fn: o.onstereo}] : [];
            self._onpos = o.onpos ? [{fn: o.onpos}] : [];
            self._onorientation = o.onorientation ? [{fn: o.onorientation}] : [];

            // Complete initilization with howler.js core's init function.
            return _super.call(this, o);
        };
    })(Howl.prototype.init);

    /**
     * Get/set the stereo panning of the audio source for this sound or all in the group.
     * @param  {Number} pan  A value of -1.0 is all the way left and 1.0 is all the way right.
     * @param  {Number} id (optional) The sound ID. If none is passed, all in group will be updated.
     * @return {Howl/Number}    Returns self or the current stereo panning value.
     */
    Howl.prototype.stereo = function(pan, id) {
        var self = this;

        // Stop right here if not using Web Audio.
        if (!self._webAudio) {
            return self;
        }

        // If the sound hasn't loaded, add it to the load queue to change stereo pan when capable.
        if (self._state !== 'loaded') {
            self._queue.push({
                event: 'stereo',
                action: function() {
                    self.stereo(pan, id);
                }
            });

            return self;
        }

        // Check for PannerStereoNode support and fallback to PannerNode if it doesn't exist.
        var pannerType = (typeof Howler.ctx.createStereoPanner === 'undefined') ? 'spatial' : 'stereo';

        // Setup the group's stereo panning if no ID is passed.
        if (typeof id === 'undefined') {
            // Return the group's stereo panning if no parameters are passed.
            if (typeof pan === 'number') {
                self._stereo = pan;
                self._pos = [pan, 0, 0];
            } else {
                return self._stereo;
            }
        }

        // Change the streo panning of one or all sounds in group.
        var ids = self._getSoundIds(id);
        for (var i=0; i<ids.length; i++) {
            // Get the sound.
            var sound = self._soundById(ids[i]);

            if (sound) {
                if (typeof pan === 'number') {
                    sound._stereo = pan;
                    sound._pos = [pan, 0, 0];

                    if (sound._node) {
                        // If we are falling back, make sure the panningModel is equalpower.
                        sound._pannerAttr.panningModel = 'equalpower';

                        // Check if there is a panner setup and create a new one if not.
                        if (!sound._panner || !sound._panner.pan) {
                            setupPanner(sound, pannerType);
                        }

                        if (pannerType === 'spatial') {
                            sound._panner.setPosition(pan, 0, 0);
                        } else {
                            sound._panner.pan.value = pan;
                        }
                    }

                    self._emit('stereo', sound._id);
                } else {
                    return sound._stereo;
                }
            }
        }

        return self;
    };

    /**
     * Get/set the 3D spatial position of the audio source for this sound or
     * all in the group. The most common usage is to set the 'x' position for
     * left/right panning. Setting any value higher than 1.0 will begin to
     * decrease the volume of the sound as it moves further away.
     * @param  {Number} x  The x-position of the audio from -1000.0 to 1000.0.
     * @param  {Number} y  The y-position of the audio from -1000.0 to 1000.0.
     * @param  {Number} z  The z-position of the audio from -1000.0 to 1000.0.
     * @param  {Number} id (optional) The sound ID. If none is passed, all in group will be updated.
     * @return {Howl/Array}    Returns self or the current 3D spatial position: [x, y, z].
     */
    Howl.prototype.pos = function(x, y, z, id) {
        var self = this;

        // Stop right here if not using Web Audio.
        if (!self._webAudio) {
            return self;
        }

        // If the sound hasn't loaded, add it to the load queue to change position when capable.
        if (self._state !== 'loaded') {
            self._queue.push({
                event: 'pos',
                action: function() {
                    self.pos(x, y, z, id);
                }
            });

            return self;
        }

        // Set the defaults for optional 'y' & 'z'.
        y = (typeof y !== 'number') ? 0 : y;
        z = (typeof z !== 'number') ? -0.5 : z;

        // Setup the group's spatial position if no ID is passed.
        if (typeof id === 'undefined') {
            // Return the group's spatial position if no parameters are passed.
            if (typeof x === 'number') {
                self._pos = [x, y, z];
            } else {
                return self._pos;
            }
        }

        // Change the spatial position of one or all sounds in group.
        var ids = self._getSoundIds(id);
        for (var i=0; i<ids.length; i++) {
            // Get the sound.
            var sound = self._soundById(ids[i]);

            if (sound) {
                if (typeof x === 'number') {
                    sound._pos = [x, y, z];

                    if (sound._node) {
                        // Check if there is a panner setup and create a new one if not.
                        if (!sound._panner || sound._panner.pan) {
                            setupPanner(sound, 'spatial');
                        }

                        sound._panner.setPosition(x, y, z);
                    }

                    self._emit('pos', sound._id);
                } else {
                    return sound._pos;
                }
            }
        }

        return self;
    };

    /**
     * Get/set the direction the audio source is pointing in the 3D cartesian coordinate
     * space. Depending on how direction the sound is, based on the `cone` attributes,
     * a sound pointing away from the listener can be quiet or silent.
     * @param  {Number} x  The x-orientation of the source.
     * @param  {Number} y  The y-orientation of the source.
     * @param  {Number} z  The z-orientation of the source.
     * @param  {Number} id (optional) The sound ID. If none is passed, all in group will be updated.
     * @return {Howl/Array}    Returns self or the current 3D spatial orientation: [x, y, z].
     */
    Howl.prototype.orientation = function(x, y, z, id) {
        var self = this;

        // Stop right here if not using Web Audio.
        if (!self._webAudio) {
            return self;
        }

        // If the sound hasn't loaded, add it to the load queue to change orientation when capable.
        if (self._state !== 'loaded') {
            self._queue.push({
                event: 'orientation',
                action: function() {
                    self.orientation(x, y, z, id);
                }
            });

            return self;
        }

        // Set the defaults for optional 'y' & 'z'.
        y = (typeof y !== 'number') ? self._orientation[1] : y;
        z = (typeof z !== 'number') ? self._orientation[2] : z;

        // Setup the group's spatial orientation if no ID is passed.
        if (typeof id === 'undefined') {
            // Return the group's spatial orientation if no parameters are passed.
            if (typeof x === 'number') {
                self._orientation = [x, y, z];
            } else {
                return self._orientation;
            }
        }

        // Change the spatial orientation of one or all sounds in group.
        var ids = self._getSoundIds(id);
        for (var i=0; i<ids.length; i++) {
            // Get the sound.
            var sound = self._soundById(ids[i]);

            if (sound) {
                if (typeof x === 'number') {
                    sound._orientation = [x, y, z];

                    if (sound._node) {
                        // Check if there is a panner setup and create a new one if not.
                        if (!sound._panner) {
                            // Make sure we have a position to setup the node with.
                            if (!sound._pos) {
                                sound._pos = self._pos || [0, 0, -0.5];
                            }

                            setupPanner(sound, 'spatial');
                        }

                        sound._panner.setOrientation(x, y, z);
                    }

                    self._emit('orientation', sound._id);
                } else {
                    return sound._orientation;
                }
            }
        }

        return self;
    };

    /**
     * Get/set the panner node's attributes for a sound or group of sounds.
     * This method can optionall take 0, 1 or 2 arguments.
     *   pannerAttr() -> Returns the group's values.
     *   pannerAttr(id) -> Returns the sound id's values.
     *   pannerAttr(o) -> Set's the values of all sounds in this Howl group.
     *   pannerAttr(o, id) -> Set's the values of passed sound id.
     *
     *   Attributes:
     *     coneInnerAngle - (360 by default) There will be no volume reduction inside this angle.
     *     coneOuterAngle - (360 by default) The volume will be reduced to a constant value of
     *                      `coneOuterGain` outside this angle.
     *     coneOuterGain - (0 by default) The amount of volume reduction outside of `coneOuterAngle`.
     *     distanceModel - ('inverse' by default) Determines algorithm to use to reduce volume as audio moves
     *                      away from listener. Can be `linear`, `inverse` or `exponential`.
     *     maxDistance - (10000 by default) Volume won't reduce between source/listener beyond this distance.
     *     panningModel - ('HRTF' by default) Determines which spatialization algorithm is used to position audio.
     *                     Can be `HRTF` or `equalpower`.
     *     refDistance - (1 by default) A reference distance for reducing volume as the source
     *                    moves away from the listener.
     *     rolloffFactor - (1 by default) How quickly the volume reduces as source moves from listener.
     *
     * @return {Howl/Object} Returns self or current panner attributes.
     */
    Howl.prototype.pannerAttr = function() {
        var self = this;
        var args = arguments;
        var o, id, sound;

        // Stop right here if not using Web Audio.
        if (!self._webAudio) {
            return self;
        }

        // Determine the values based on arguments.
        if (args.length === 0) {
            // Return the group's panner attribute values.
            return self._pannerAttr;
        } else if (args.length === 1) {
            if (typeof args[0] === 'object') {
                o = args[0];

                // Set the grou's panner attribute values.
                if (typeof id === 'undefined') {
                    self._pannerAttr = {
                        coneInnerAngle: typeof o.coneInnerAngle !== 'undefined' ? o.coneInnerAngle : self._coneInnerAngle,
                        coneOuterAngle: typeof o.coneOuterAngle !== 'undefined' ? o.coneOuterAngle : self._coneOuterAngle,
                        coneOuterGain: typeof o.coneOuterGain !== 'undefined' ? o.coneOuterGain : self._coneOuterGain,
                        distanceModel: typeof o.distanceModel !== 'undefined' ? o.distanceModel : self._distanceModel,
                        maxDistance: typeof o.maxDistance !== 'undefined' ? o.maxDistance : self._maxDistance,
                        panningModel: typeof o.panningModel !== 'undefined' ? o.panningModel : self._panningModel,
                        refDistance: typeof o.refDistance !== 'undefined' ? o.refDistance : self._refDistance,
                        rolloffFactor: typeof o.rolloffFactor !== 'undefined' ? o.rolloffFactor : self._rolloffFactor
                    };
                }
            } else {
                // Return this sound's panner attribute values.
                sound = self._soundById(parseInt(args[0], 10));
                return sound ? sound._pannerAttr : self._pannerAttr;
            }
        } else if (args.length === 2) {
            o = args[0];
            id = parseInt(args[1], 10);
        }

        // Update the values of the specified sounds.
        var ids = self._getSoundIds(id);
        for (var i=0; i<ids.length; i++) {
            sound = self._soundById(ids[i]);

            if (sound) {
                // Merge the new values into the sound.
                var pa = sound._pannerAttr;
                pa = {
                    coneInnerAngle: typeof o.coneInnerAngle !== 'undefined' ? o.coneInnerAngle : pa.coneInnerAngle,
                    coneOuterAngle: typeof o.coneOuterAngle !== 'undefined' ? o.coneOuterAngle : pa.coneOuterAngle,
                    coneOuterGain: typeof o.coneOuterGain !== 'undefined' ? o.coneOuterGain : pa.coneOuterGain,
                    distanceModel: typeof o.distanceModel !== 'undefined' ? o.distanceModel : pa.distanceModel,
                    maxDistance: typeof o.maxDistance !== 'undefined' ? o.maxDistance : pa.maxDistance,
                    panningModel: typeof o.panningModel !== 'undefined' ? o.panningModel : pa.panningModel,
                    refDistance: typeof o.refDistance !== 'undefined' ? o.refDistance : pa.refDistance,
                    rolloffFactor: typeof o.rolloffFactor !== 'undefined' ? o.rolloffFactor : pa.rolloffFactor
                };

                // Update the panner values or create a new panner if none exists.
                var panner = sound._panner;
                if (panner) {
                    panner.coneInnerAngle = pa.coneInnerAngle;
                    panner.coneOuterAngle = pa.coneOuterAngle;
                    panner.coneOuterGain = pa.coneOuterGain;
                    panner.distanceModel = pa.distanceModel;
                    panner.maxDistance = pa.maxDistance;
                    panner.panningModel = pa.panningModel;
                    panner.refDistance = pa.refDistance;
                    panner.rolloffFactor = pa.rolloffFactor;
                } else {
                    // Make sure we have a position to setup the node with.
                    if (!sound._pos) {
                        sound._pos = self._pos || [0, 0, -0.5];
                    }

                    // Create a new panner node.
                    setupPanner(sound, 'spatial');
                }
            }
        }

        return self;
    };

    /** Single Sound Methods **/
    /***************************************************************************/

    /**
     * Add new properties to the core Sound init.
     * @param  {Function} _super Core Sound init method.
     * @return {Sound}
     */
    Sound.prototype.init = (function(_super) {
        return function() {
            var self = this;
            var parent = self._parent;

            // Setup user-defined default properties.
            self._orientation = parent._orientation;
            self._stereo = parent._stereo;
            self._pos = parent._pos;
            self._pannerAttr = parent._pannerAttr;

            // Complete initilization with howler.js core Sound's init function.
            _super.call(this);

            // If a stereo or position was specified, set it up.
            if (self._stereo) {
                parent.stereo(self._stereo);
            } else if (self._pos) {
                parent.pos(self._pos[0], self._pos[1], self._pos[2], self._id);
            }
        };
    })(Sound.prototype.init);

    /**
     * Override the Sound.reset method to clean up properties from the spatial plugin.
     * @param  {Function} _super Sound reset method.
     * @return {Sound}
     */
    Sound.prototype.reset = (function(_super) {
        return function() {
            var self = this;
            var parent = self._parent;

            // Reset all spatial plugin properties on this sound.
            self._orientation = parent._orientation;
            self._pos = parent._pos;
            self._pannerAttr = parent._pannerAttr;

            // Complete resetting of the sound.
            return _super.call(this);
        };
    })(Sound.prototype.reset);

    /** Helper Methods **/
    /***************************************************************************/

    /**
     * Create a new panner node and save it on the sound.
     * @param  {Sound} sound Specific sound to setup panning on.
     * @param {String} type Type of panner to create: 'stereo' or 'spatial'.
     */
    var setupPanner = function(sound, type) {
        type = type || 'spatial';

        // Create the new panner node.
        if (type === 'spatial') {
            sound._panner = Howler.ctx.createPanner();
            sound._panner.coneInnerAngle = sound._pannerAttr.coneInnerAngle;
            sound._panner.coneOuterAngle = sound._pannerAttr.coneOuterAngle;
            sound._panner.coneOuterGain = sound._pannerAttr.coneOuterGain;
            sound._panner.distanceModel = sound._pannerAttr.distanceModel;
            sound._panner.maxDistance = sound._pannerAttr.maxDistance;
            sound._panner.panningModel = sound._pannerAttr.panningModel;
            sound._panner.refDistance = sound._pannerAttr.refDistance;
            sound._panner.rolloffFactor = sound._pannerAttr.rolloffFactor;
            sound._panner.setPosition(sound._pos[0], sound._pos[1], sound._pos[2]);
            sound._panner.setOrientation(sound._orientation[0], sound._orientation[1], sound._orientation[2]);
        } else {
            sound._panner = Howler.ctx.createStereoPanner();
            sound._panner.pan.value = sound._stereo;
        }

        sound._panner.connect(sound._node);

        // Update the connections.
        if (!sound._paused) {
            sound._parent.pause(sound._id, true).play(sound._id);
        }
    };
})();


var FAPSoundObject = function(trackObj, callback) {

    if (typeof callback !== "function") {
        return;
    }


    //get track(s) from soundcloud link
    function _init(trackObj) {

        var source = trackObj.stream_url;

        if(RegExp('http(s?)://soundcloud').test(source)) {

            //load soundcloud data from tracks
            SC.resolve(source).then(function(data){

                var loadIndex = -1, temp = -1;

                //favorites(likes)
                if($.isArray(data)) {

                    callback(data);

                }
                //sets
                else if(data.kind == "playlist") {

                    callback(data.tracks);

                }
                //user tracks
                else if(data.kind == "user") {

                    SC.get("/users/"+data.id+"/tracks").then(function(data){

                        callback(data);

                    }).catch(function(error) {
                        callback(false, error);
                    });

                }
                //single track
                else {
                    if(data.kind == "track") {

                        data.title = _isNotEmpty(trackObj.title) ? trackObj.title : data.title;
                        data.genre = _isNotEmpty(trackObj.meta) ? trackObj.meta : data.genre;
                        data.artwork_url = _isNotEmpty(trackObj.artwork_url) ? trackObj.artwork_url : data.artwork_url;

                        callback(data);

                    }
                }


            }).catch(function(error){
                callback(false, error);
            });

        }
        else if(RegExp('http(s?)://official.fm').test(source)) {

            var trackId = source.substr(source.lastIndexOf('/tracks')+8);
            $.getJSON('http://api.official.fm/tracks/'+trackId+'?fields=streaming,cover&api_version=2', function(data) {

                var track = data.track;
                var li = callback({stream_url: track.streaming.http, title: track.artist + ' - ' + track.title, meta: track.project.name, artwork_url: track.cover.urls.small, permalink_url:track.page});

            });

        }

    };

    function _isNotEmpty(value) {

        return value && value.length > 0;

    };

    _init(trackObj);

};

var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};
