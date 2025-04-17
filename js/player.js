_argonLoadedHooks.push(function ArgonStartupPlayer() {
    ArgonPlayer = {
        _player: document.getElementById("argon-player"),
        _current: null,
        _seekbar: true,
        _shuffle: false,
        _repeat: false,
        _endTriggered: false,
        _preferredQualityRaw: "0",
        _preferredQualityPreference: ["0"],
        _currentQuality: null,
        _qualityChangeTime: 0,
        _qualityGoingDown: false,

        _end: () => {
            if (ArgonPlayer._endTriggered) return;

            if (!ArgonPlayer._player.paused) {
                ArgonPlayer._endTriggered = true;

                if (ArgonPlayer._repeat) {
                    ArgonPlayer._player.currentTime = 0;
                    ArgonPlayer._player.play().catch(e => {
                        console.error(e);
                        if (e.name !== "NotAllowedError") alert("An error occurred while trying to play this song. Please try again later.");
                    }).then(() => {
                        ArgonPlayer._endTriggered = false;
                    });
                } else {
                    ArgonPlayer.next();
                }
            }
        },

        _qualityDown: () => {
            if (ArgonPlayer._qualityGoingDown) return;
            ArgonPlayer._qualityGoingDown = true;

            if (ArgonPlayer._currentQuality === "high") {
                ArgonPlayer._setQualityTo("medium");
            } else if (ArgonPlayer._currentQuality === "medium") {
                ArgonPlayer._setQualityTo("low");
            } else if (ArgonPlayer._currentQuality === "low") {
                ArgonPlayer._setQualityTo("verylow");
            } else if (ArgonPlayer._currentQuality === "verylow") {
                ArgonPlayer._setQualityTo("ultralow");
            } else if (ArgonPlayer._currentQuality === "ultralow") {
                ArgonPlayer._setQualityTo("superlow");
            } else {
                log("Quality is already as low as possible");
            }
        },

        _setQualityTo: (quality) => {
            log("Resolving track " + ArgonPlayer._current + "...");
            ArgonPlayer._qualityChangeTime = ArgonPlayer._player.currentTime;
            ArgonPlayer._currentQuality = quality;
            // noinspection JSUnresolvedVariable,JSUnresolvedFunction
            ELAC.quickBlob("https://" + (AppName === "Argon" ? "mediacdn.argon.minteck.org" : "music-audio-media01.familine.minteck.org") + "/" + song + "/" + ArgonPlayer._currentQuality + ".elac", 0).then((blob) => {
                ArgonPlayer._player.src = blob;
                log("Playing " + ArgonPlayer._current);
                ArgonPlayer._player.play().catch(e => {
                    console.error(e);
                    if (e.name !== "NotAllowedError") alert("An error occurred while trying to play this song. Please try again later.");
                }).then(() => {
                    ArgonPlayer._player.currentTime = ArgonPlayer._qualityChangeTime;
                    ArgonPlayer._endTriggered = false;
                    ArgonPlayer._qualityGoingDown = false;
                });
            });
        },

        play: (song) => {
            document.body.classList.add("playing");
            ArgonPlayer._current = song;
            document.getElementById("player-artwork").src = "";

            document.getElementById("player-artwork").src = "/api/get_image.php?_=" + ArgonPlayer._current;
            document.getElementById("player-info-text-title").innerHTML = "<a id='frame-viewer-header-text-linkToOriginal' onclick='document.getElementById(&quot;frame-inner&quot;).contentDocument.location.href=&quot;/_frame/library/" + ArgonPlayer._current + "&quot;'>" + _argonSongsData.songs[ArgonPlayer._current].name.replaceAll(">", "&gt;") + "</a>";
            if (_argonSongsData.songs[ArgonPlayer._current].set !== null && _argonSongsData.songs[ArgonPlayer._current].set !== undefined) {
                document.getElementById("player-info-text-set").innerHTML = _argonSongsData.songs[ArgonPlayer._current].author.replaceAll("<", "&lt;").replaceAll(">", "&gt;") + " · <a id='frame-viewer-header-text-linkToSet' onclick='document.getElementById(&quot;frame-inner&quot;).contentDocument.location.href=&quot;/_frame/library/" + _argonSongsData.songs[ArgonPlayer._current].set._id + "&quot;'>" + _argonSongsData.songs[ArgonPlayer._current].set.name.replaceAll("<", "&lt;").replaceAll(">", "&gt;") + "</a> · " + _argonSongsData.songs[ArgonPlayer._current].release.substring(0, 4).replaceAll("<", "&lt;").replaceAll(">", "&gt;");
            } else {
                document.getElementById("player-info-text-set").innerText = _argonSongsData.songs[ArgonPlayer._current].author + " · " + _argonSongsData.songs[ArgonPlayer._current].release.substring(0, 4);
            }

            log("Resolving track " + song + "...");
            if (ArgonPlayer._preferredQualityPreference[0] === "2") {
                ArgonPlayer._currentQuality = "original";
            } else if (ArgonPlayer._preferredQualityPreference[0] === "0") {
                ArgonPlayer._currentQuality = "high";
            } else {
                ArgonPlayer._currentQuality = ArgonPlayer._preferredQualityPreference[1];
            }
            // noinspection JSUnresolvedVariable,JSUnresolvedFunction
            ELAC.quickBlob("https://" + (AppName === "Argon" ? "mediacdn.argon.minteck.org" : "music-audio-media01.familine.minteck.org") + "/" + song + "/" + ArgonPlayer._currentQuality + ".elac", 0).then((blob) => {
                ArgonPlayer._player.src = blob;
                log("Playing " + song);
                ArgonPlayer._player.play().catch(e => {
                    if (e.name !== "DOMException") {
                        console.error(e);
                        if (e.name !== "NotAllowedError") alert("An error occurred while trying to play this song. Please try again later.");
                    }
                }).then(() => {
                    ArgonPlayer._endTriggered = false;
                });
            })
        },

        shuffle: () => {
            ArgonPlayer._shuffle = !ArgonPlayer._shuffle;

            if (ArgonPlayer._shuffle) {
                document.getElementById("player-button-shuffle-icon").src = "/icons/shuffle-on.svg";
            } else {
                document.getElementById("player-button-shuffle-icon").src = "/icons/shuffle-off.svg";
            }
        },

        repeat: () => {
            ArgonPlayer._repeat = !ArgonPlayer._repeat;

            if (ArgonPlayer._repeat) {
                document.getElementById("player-button-repeat-icon").src = "/icons/repeat-on.svg";
            } else {
                document.getElementById("player-button-repeat-icon").src = "/icons/repeat-off.svg";
            }
        },

        _controls: () => {
            ArgonPlayer._preferredQualityRaw = localStorage.getItem("quality") ?? "0";
            ArgonPlayer._preferredQualityPreference = (localStorage.getItem("quality") ?? localStorage.getItem("quality") ?? "0").split(":");

            if (ArgonPlayer._current !== null) {
                document.getElementById("player-inner").style.display = "";

                if (!ArgonPlayer._player.paused) {
                    if (_argonSongsData.songs[ArgonPlayer._current].original !== null) {
                        document.title = _argonSongsData.songs[ArgonPlayer._current].author + " - " + _argonSongsData.songs[ArgonPlayer._current].name + " (" + _argonSongsData.songs[ArgonPlayer._current].original + " cover)";
                    } else {
                        document.title = _argonSongsData.songs[ArgonPlayer._current].author + " - " + _argonSongsData.songs[ArgonPlayer._current].name
                    }
                } else {
                    document.title = AppName;
                }

                if (ArgonPlayer._player.currentTime >= ArgonPlayer._player.duration) {
                    ArgonPlayer._end();
                }

                if (ArgonPlayer._player.readyState === 0) {
                    document.getElementById("player-button-load").style.display = "";
                    document.getElementById("player-button-pause").style.display = "none";
                    document.getElementById("player-button-play").style.display = "none";
                    document.getElementById("player-seekbar").disabled = true;

                    document.getElementById("player-seekbar-elapsed").innerText = "-:--";
                    document.getElementById("player-seekbar-total").innerText = "-:--";
                } else {
                    document.getElementById("player-seekbar").disabled = false;

                    if (ArgonPlayer._repeat) {
                        ArgonPlayer._player.loop = true;
                    }

                    if (ArgonPlayer._player.paused) {
                        document.getElementById("player-button-play").style.display = "";
                        document.getElementById("player-button-pause").style.display = "none";
                        document.getElementById("player-button-load").style.display = "none";
                    } else {
                        document.getElementById("player-button-pause").style.display = "";
                        document.getElementById("player-button-play").style.display = "none";
                        document.getElementById("player-button-load").style.display = "none";
                    }

                    if (!ArgonPlayer._shuffle) {
                        if (_argonSongsData.sorted[_argonSongsData.sorted.indexOf(ArgonPlayer._current) + 1]) {
                            document.getElementById("player-button-next").classList.remove("player-button-disabled");
                        } else {
                            document.getElementById("player-button-next").classList.add("player-button-disabled");
                        }

                        if (_argonSongsData.sorted[_argonSongsData.sorted.indexOf(ArgonPlayer._current) - 1]) {
                            document.getElementById("player-button-previous").classList.remove("player-button-disabled");
                        } else {
                            document.getElementById("player-button-previous").classList.add("player-button-disabled");
                        }
                    } else {
                        document.getElementById("player-button-previous").classList.remove("player-button-disabled");
                        document.getElementById("player-button-next").classList.remove("player-button-disabled");
                    }

                    let current;
                    let total;
                    if (ArgonPlayer._player.duration >= 600) {
                        current = new Date(ArgonPlayer._player.currentTime * 1000).toISOString().substr(14, 5);
                        total = new Date(ArgonPlayer._player.duration * 1000).toISOString().substr(14, 5);
                    } else {
                        current = new Date(ArgonPlayer._player.currentTime * 1000).toISOString().substr(15, 4);
                        total = new Date(ArgonPlayer._player.duration * 1000).toISOString().substr(15, 4);
                    }

                    document.getElementById("player-seekbar-elapsed").innerText = current;
                    document.getElementById("player-seekbar-total").innerText = total;
                }

                if (ArgonPlayer._seekbar) {
                    document.getElementById("player-seekbar").max = ArgonPlayer._player.duration * 1000;
                    document.getElementById("player-seekbar").value = ArgonPlayer._player.currentTime * 1000;
                }
            } else {
                document.title = AppName;
                document.getElementById("player-inner").style.display = "none";
            }
        },

        next: () => {
            if (!ArgonPlayer._shuffle) {
                if (_argonSongsData.sorted[_argonSongsData.sorted.indexOf(ArgonPlayer._current) + 1]) {
                    ArgonPlayer.play(_argonSongsData.sorted[_argonSongsData.sorted.indexOf(ArgonPlayer._current) + 1]);
                }
            } else {
                items = _argonSongsData.sorted.filter(i => i !== ArgonPlayer._current)
                ArgonPlayer.play(items[Math.floor(Math.random() * items.length)]);
            }
        },

        previous: () => {
            if (!ArgonPlayer._shuffle) {
                if (_argonSongsData.sorted[_argonSongsData.sorted.indexOf(ArgonPlayer._current) - 1]) {
                    ArgonPlayer.play(_argonSongsData.sorted[_argonSongsData.sorted.indexOf(ArgonPlayer._current) - 1]);
                }
            } else {
                items = _argonSongsData.sorted.filter(i => i !== ArgonPlayer._current)
                ArgonPlayer.play(items[Math.floor(Math.random() * items.length)]);
            }
        }
    }

    setInterval(ArgonPlayer._controls);
    setInterval(() => {
        if (ArgonPlayer._current !== null) {
            if (ArgonPlayer._player.readyState <= 2) {
                if (ArgonPlayer._preferredQualityPreference[0] === "0") {
                    log("Quality is too high for network, reducing quality...");
                    ArgonPlayer._qualityDown()
                } else {
                    log("Quality is too high for network, settings does not allow reducing quality.");
                }
            }
        }
    }, 10000)
})