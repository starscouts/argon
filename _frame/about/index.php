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
    <link rel="stylesheet" href="/css/frame-about.css">
    <link rel="stylesheet" href="/css/frame.css">
    <link rel="stylesheet" href="/dark.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div id="argon-frame">
    <div id="frame-header">
        <?= l("About Argon", "À propos de Familine Musique") ?>
    </div>
    <div id="frame-contents">
        <div id="frame-about-general">
            <div id="frame-about-general-icon">
                <img alt="<?= $_FAMILINE ? "Familine Musique" : "Argon" ?>" src="<?= $_FAMILINE ? "https://familine.minteck.org/icns/familine-music.svg" : "/favicon.svg" ?>" id="frame-about-general-icon">
            </div>
            <div id="frame-about-general-text">
                <div id="frame-about-general-text-inner">
                    <b><?= $_FAMILINE ? "Familine Musique" : "Argon Media Platform" ?></b><br>
                    <?= $_FAMILINE ? "Argon v" : "Version " ?><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/version"); ?>
                </div>
            </div>
        </div>

        <p><?= l("Powered by the Equestria Lossless Audio Codec", "Propulsé par le codec audio sans perte d'Equestria (ELAC)") ?></p>

        <div id="frame-about-debug">
            <b><?= l("Player Info", "Infos lecteur ") ?>:</b><br>

            <div id="frame-about-debug--player" class="frame-about-section">
                <span><?= l("Song ID", "ID morceau ") ?>:</span>
                <span id="frame-about-debug--songId"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Song Metadata", "Infos morc. ") ?>:</span>
                <span id="frame-about-debug--songMetadata"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Song Release Date", "Date sortie morc. ") ?>:</span>
                <span id="frame-about-debug--songRelease"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Previous Song", "Morc. précédent ") ?>:</span>
                <span id="frame-about-debug--previousSong"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Next Song", "Morc. suivant ") ?>:</span>
                <span id="frame-about-debug--nextSong"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Position", "Position ") ?>:</span>
                <code id="frame-about-debug--position" style="font-family: monospace;"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></code>

                <span><?= l("Playback Quality", "Qualité lecture ") ?>:</span>
                <span id="frame-about-debug--quality"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Stream URL", "URL flux ") ?>:</span>
                <span id="frame-about-debug--stream" class="frame-about-link" onclick="window.open(window.parent.ArgonPlayer._player.src);"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Player State", "État lecteur ") ?>:</span>
                <span id="frame-about-debug--state"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Seeking", "Navigation ") ?>:</span>
                <span id="frame-about-debug--seeking"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Shuffle Mode", "Lect. aléatoire ") ?>:</span>
                <span id="frame-about-debug--shuffle"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>

                <span><?= l("Repeat Mode", "Lect. en boucle ") ?>:</span>
                <span id="frame-about-debug--repeat"><?= l("&lt;not playing&gt;", "&lt;pas de lecture&gt;") ?></span>
            </div>

            <b><?= l("Server Info", "Infos serveur ") ?>:</b><br>

            <div id="frame-about-debug--server" class="frame-about-section">
                <span><?= l("PHP Version", "Version PHP ") ?>:</span>
                <span id="frame-about-debug--php"><?= PHP_VERSION ?></span>

                <span><?= l("Zend Version", "Version Zend ") ?>:</span>
                <span id="frame-about-debug--php"><?= zend_version() ?></span>

                <span><?= l("Web Server", "Serveur Web ") ?>:</span>
                <span id="frame-about-debug--php"><?= $_SERVER['SERVER_SOFTWARE'] ?></span>

                <span><?= l("Server Gateway", "Passerelle serveur ") ?>:</span>
                <span id="frame-about-debug--gateway"><?= php_sapi_name() ?> (<?= $_SERVER['GATEWAY_INTERFACE'] ?>)</span>

                <span><?= l("System Version", "Version système ") ?>:</span>
                <span id="frame-about-debug--system"><?= php_uname("s") . " " . php_uname("r") ?></span>

                <span><?= l("Server User", "Util. serveur ") ?>:</span>
                <span id="frame-about-debug--system"><?= get_current_user() ?></span>
            </div>

            <b><?= l("Client Info", "Infos client ") ?>:</b><br>

            <div id="frame-about-debug--client" class="frame-about-section">
                <span><?= l("Logical Cores", "Cœurs logiques ") ?>:</span>
                <span id="frame-about-debug--cores">...</span>

                <span><?= l("Language", "Langue ") ?>:</span>
                <span id="frame-about-debug--language">...</span>

                <span><?= l("Touch Points", "Points de contact ") ?>:</span>
                <span id="frame-about-debug--touch">...</span>

                <span><?= l("Working Online", "En ligne ") ?>:</span>
                <span id="frame-about-debug--online">...</span>

                <span><?= l("Mobile Device", "Appareil mobile ") ?>:</span>
                <span id="frame-about-debug--mobile">...</span>

                <span><?= l("Navigator Brand", "Marque navigateur ") ?>:</span>
                <span id="frame-about-debug--brands">...</span>
            </div>
        </div>

        <script>
            setInterval(() => {
                document.getElementById("frame-about-debug--cores").innerText = navigator.hardwareConcurrency;
                document.getElementById("frame-about-debug--language").innerText = navigator.language;
                document.getElementById("frame-about-debug--touch").innerText = navigator.maxTouchPoints;
                document.getElementById("frame-about-debug--online").innerText = navigator.onLine;
                try {
                    document.getElementById("frame-about-debug--mobile").innerText = navigator.userAgentData.mobile;
                } catch (e) {
                    document.getElementById("frame-about-debug--mobile").innerText = "null";
                }
                try {
                    document.getElementById("frame-about-debug--brands").innerText = navigator.userAgentData.brands.map(i => { return i.brand.trim() + "/" + i.version }).join(", ");
                } catch (e) {
                    document.getElementById("frame-about-debug--brands").innerText = navigator.userAgent.replace(/(\([._;:\/\\A-Za-z 0-9,]*\))/gm, "").split(" ").filter(i => i.trim() !== "").filter(i => !i.startsWith("Mozilla")).join(", ");
                }

                if (window.parent.ArgonPlayer._current !== null) {
                    if (!window.parent.ArgonPlayer._shuffle) {
                        if (window.parent._argonSongsData.sorted[window.parent._argonSongsData.sorted.indexOf(window.parent.ArgonPlayer._current) + 1]) {
                            document.getElementById("frame-about-debug--nextSong").innerText = window.parent._argonSongsData.sorted[window.parent._argonSongsData.sorted.indexOf(window.parent.ArgonPlayer._current) + 1];
                        } else {
                            document.getElementById("frame-about-debug--nextSong").innerText = "<not applicable>";
                        }
                    } else {
                        document.getElementById("frame-about-debug--nextSong").innerText = "<shuffle on>";
                    }

                    if (!window.parent.ArgonPlayer._shuffle) {
                        if (window.parent._argonSongsData.sorted[window.parent._argonSongsData.sorted.indexOf(window.parent.ArgonPlayer._current) - 1]) {
                            document.getElementById("frame-about-debug--previousSong").innerText = window.parent._argonSongsData.sorted[window.parent._argonSongsData.sorted.indexOf(window.parent.ArgonPlayer._current) - 1];
                        } else {
                            document.getElementById("frame-about-debug--previousSong").innerText = "<?= l("<not applicable>", "<pas applicable>") ?>";
                        }
                    } else {
                        document.getElementById("frame-about-debug--previousSong").innerText = "<?= l("<shuffle on>", "<lect. aléa. activée>") ?>";
                    }

                    document.getElementById("frame-about-debug--songId").innerText = window.parent.ArgonPlayer._current;
                    document.getElementById("frame-about-debug--songMetadata").innerText = window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].name + " (" + window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].author + ", original<?= l("", " ") ?>: " + window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].original + ")";
                    document.getElementById("frame-about-debug--songRelease").innerText = window.parent._argonSongsData.songs[window.parent.ArgonPlayer._current].release;
                    document.getElementById("frame-about-debug--seeking").innerText = !window.parent.ArgonPlayer._seekbar;
                    document.getElementById("frame-about-debug--shuffle").innerText = window.parent.ArgonPlayer._shuffle;
                    document.getElementById("frame-about-debug--repeat").innerText = window.parent.ArgonPlayer._repeat;
                    switch (window.parent.ArgonPlayer._preferredQualityPreference[0] - 1 + 1) {
                        case 0:
                            document.getElementById("frame-about-debug--quality").innerText = window.parent.ArgonPlayer._currentQuality + " (<?= l("dynamic", "dynamique") ?>)";
                            break;
                        case 1:
                            document.getElementById("frame-about-debug--quality").innerText = window.parent.ArgonPlayer._currentQuality + " (<?= l("fixed", "fixe") ?>)";
                            break;
                        case 2:
                            document.getElementById("frame-about-debug--quality").innerText = window.parent.ArgonPlayer._currentQuality + " (original)";
                            break;
                        default:
                            document.getElementById("frame-about-debug--quality").innerText = window.parent.ArgonPlayer._currentQuality + " (<?= l("unknown", "inconnu") ?>)";
                            break;
                    }
                    document.getElementById("frame-about-debug--position").innerText = "(" + (window.parent.document.getElementById("player-seekbar").value / 1000).toFixed(3) + ") " + window.parent.ArgonPlayer._player.currentTime.toFixed(3) + "/" + window.parent.ArgonPlayer._player.duration.toFixed(3);
                    document.getElementById("frame-about-debug--stream").innerText = window.parent.ArgonPlayer._player.src;
                    switch (window.parent.ArgonPlayer._player.readyState) {
                        case 0:
                            document.getElementById("frame-about-debug--state").innerText = window.parent.ArgonPlayer._player.readyState + " (HAVE_NOTHING, <?= l("not playable", "ne peut pas lire") ?>)";
                            break;
                        case 1:
                            document.getElementById("frame-about-debug--state").innerText = window.parent.ArgonPlayer._player.readyState + " (HAVE_METADATA, <?= l("seekable", "navigable") ?>)";
                            break;
                        case 2:
                            document.getElementById("frame-about-debug--state").innerText = window.parent.ArgonPlayer._player.readyState + " (HAVE_CURRENT_DATA, <?= l("real-time download", "téléch. en temps réel") ?>)";
                            break;
                        case 3:
                            document.getElementById("frame-about-debug--state").innerText = window.parent.ArgonPlayer._player.readyState + " (HAVE_FUTURE_DATA, <?= l("ready", "prêt") ?>)";
                            break;
                        case 4:
                            document.getElementById("frame-about-debug--state").innerText = window.parent.ArgonPlayer._player.readyState + " (HAVE_ENOUGH_DATA, <?= l("uninterrupted", "ininterrompu") ?>)";
                            break;
                        default:
                            document.getElementById("frame-about-debug--state").innerText = window.parent.ArgonPlayer._player.readyState + " (<?= l("unknown", "inconnu") ?>)";
                            break;
                    }
                } else {
                    document.getElementById("frame-about-debug--songId").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--songMetadata").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--songRelease").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--quality").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--position").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--stream").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--state").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--nextSong").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                    document.getElementById("frame-about-debug--previousSong").innerText = "<?= l("<not playing>", "<pas de lecture>") ?>";
                }
            })

            width = Math.max(...Array.from(document.getElementsByClassName('frame-about-section')).map(i => { return Array.from(i.children).filter(i => i.id === "").map(i => { return i.clientWidth; }); }).map(i => { return Math.max(...i); }));

            for (let item of [].concat(...Array.from(document.getElementsByClassName('frame-about-section')).map(i => Array.from(i.children).filter(i => i.id === "")))) {
                item.style.width = width + "px";
            }
        </script>
    </div>
</div>
</body>
</html>