<?php if (str_ends_with($_SERVER['HTTP_HOST'], ".familine.minteck.org")) { $_FAMILINE = true; } else { $_FAMILINE = false; } function l($en, $fr) { global $_FAMILINE; if ($_FAMILINE) { return $fr; } else { return $en; } } $root = $_SERVER['DOCUMENT_ROOT']; $root = $_SERVER['DOCUMENT_ROOT']; if ($_FAMILINE) { require_once "/mnt/familine/app/session.php"; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Argon</title>
    <link rel="shortcut icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/general.css">
    <link rel="stylesheet" href="/css/loader.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/frame-lyrics.css">
    <link rel="stylesheet" href="/css/frame.css">
    <link rel="stylesheet" href="/dark.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div id="argon-frame">
    <div id="frame-header">
        <?= l("Lyrics", "Paroles") ?>
    </div>
    <div id="frame-contents">
        <div id="frame-lyrics-loader">
            <div style="width:48px;height:48px;text-align: center;margin-left: auto;margin-right: auto;">
                <svg class="circular-loader" viewBox="25 25 50 50">
                    <circle class="loader-path" cx="50" cy="50" r="20" fill="none"></circle>
                </svg>
            </div>
        </div>
        <div id="frame-lyrics-none" style="display:none;">
            <div id="frame-lyrics-none-inner">
                <img src="/icons/no-lyrics.svg" id="frame-lyrics-none-icon">
                <div id="frame-lyrics-none-message"><?= l("No lyrics available for this song", "Pas de paroles disponibles pour ce morceau") ?></div>
            </div>
        </div>
        <div id="frame-lyrics-play" style="display:none;">
            <div id="frame-lyrics-play-inner">
                <img src="/icons/lyrics-not-playing.svg" id="frame-lyrics-play-icon">
                <div id="frame-lyrics-play-message"><?= l("No music is currently playing", "Aucun contenu n'est en cours de lecture") ?></div>
            </div>
        </div>
        <div id="frame-lyrics-show" style="display:none;">
            <div id="frame-lyrics-show-header">
                <b id="frame-lyrics-show-header-author">Author</b> · <b id="frame-lyrics-show-header-title">Song Name</b><br>
                <b id="frame-lyrics-show-header-original"><?= l("original creation", "création originalle") ?></b>
            </div>
            <br>
            <div id="frame-lyrics-show-inner"></div>
            <br>
            <div id="frame-lyrics-show-copyright"></div>
        </div>
    </div>

    <script>
        _shouldRefresh = true;

        document.onmousedown = () => {
            _shouldRefresh = false;
        }
        document.onmouseup = () => {
            _shouldRefresh = true;
        }

        setInterval(() => {
            if (!_shouldRefresh) return;

            document.getElementById("frame-lyrics-none").style.display = "none";
            document.getElementById("frame-lyrics-show").style.display = "none";
            document.getElementById("frame-lyrics-play").style.display = "none";
            document.getElementById("frame-lyrics-loader").style.display = "none";

            if (typeof window.parent.ArgonPlayer._current === "string") {
                if (typeof window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].lyrics === "string") {
                    document.getElementById("frame-lyrics-show-header-title").innerHTML = window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].name;
                    document.getElementById("frame-lyrics-show-header-author").innerHTML = window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].author;
                    if (window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].original) {
                        document.getElementById("frame-lyrics-show-header-original").innerHTML = "<?= l("original by ", "original par ") ?>" + window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].original;
                        document.getElementById("frame-lyrics-show-copyright").innerText = "© " + window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].original;
                    } else {
                        document.getElementById("frame-lyrics-show-header-original").innerHTML = "<?= l("original creation", "creation originale") ?>";
                        document.getElementById("frame-lyrics-show-copyright").innerText = "© " + window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].author;
                    }
                    document.getElementById("frame-lyrics-show-inner").innerHTML = window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].lyrics.split("\n").join("<br>");
                    document.getElementById("frame-lyrics-show").style.display = "";
                    document.getElementById("frame-lyrics-loader").style.display = "none";
                } else {
                    document.getElementById("frame-lyrics-none").style.display = "";
                    document.getElementById("frame-lyrics-loader").style.display = "none";
                }
            } else {
                document.getElementById("frame-lyrics-play").style.display = "";
                document.getElementById("frame-lyrics-loader").style.display = "none";
            }
        }, 1000)
    </script>
</div>
</body>
</html>