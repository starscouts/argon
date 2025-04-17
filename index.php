<?php if (str_ends_with($_SERVER['HTTP_HOST'], ".familine.minteck.org")) { $_FAMILINE = true; } else { $_FAMILINE = false; } function l($en, $fr) { global $_FAMILINE; if ($_FAMILINE) { return $fr; } else { return $en; } } $root = $_SERVER['DOCUMENT_ROOT']; $root = $_SERVER['DOCUMENT_ROOT']; if ($_FAMILINE) { require_once "/mnt/familine/app/session.php"; }; if (!str_contains($_SERVER['HTTP_USER_AGENT'], "Chrome/")) header("Location: /unsupported") and die(); ?>
<!DOCTYPE html>
<html lang="en" style="overflow:hidden;">
<head>
    <meta charset="UTF-8">
    <title><?= $_FAMILINE ? "Familine Musique" : "Argon" ?></title>
    <link rel="shortcut icon" href="<?= l("/favicon.svg", "https://familine.minteck.org/icns/familine-music.svg") ?>" type="image/svg+xml">
    <link rel="stylesheet" href="/css/loader.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/general.css">
    <link rel="stylesheet" href="/dark.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script>
        const AppName = "<?= $_FAMILINE ? "Familine Musique" : "Argon" ?>";
        function l(en, fr) {
            if (<?= $_FAMILINE ? "true" : "false" ?>) {
                return fr;
            } else {
                return en;
            }
        }
    </script>
    <script src="https://git.equestria.dev/equestria.dev/elac/raw/branch/mane/browser/elac.js"></script>

    <style>
        #argon-loader {
            position: fixed;
            z-index: 9999;
            inset: 0;
            background-color: white;
        }

        #argon-loader-logo {
            display: flex;
            position: fixed;
            align-items: center;
            justify-content: center;
            inset: 0;
        }
    </style>
    <script>
        const loadScript = src => {
            return new Promise((resolve, reject) => {
                const script = document.createElement('script')
                script.type = 'text/javascript'
                script.onload = resolve
                script.onerror = reject
                script.src = src
                document.head.append(script)
            })
        }
        const loadStyle = src => {
            return new Promise((resolve, reject) => {
                const link = document.createElement('link')
                link.rel = 'stylesheet'
                link.onload = resolve
                link.onerror = reject
                link.href = src
                document.head.append(link)
            })
        }
        const sleep = (delay) => new Promise((resolve) => setTimeout(resolve, delay))

        _argonLoadedHooks = [];

        window.onload = () => {
            setTimeout(() => {
                document.getElementById("argon-loader-message").innerText = l("Importing JavaScript files...", "Importation des fichiers JavaScript...");
                if (window.electronAPI && window.electronAPI.affectMessage) window.electronAPI.affectMessage(document.getElementById("argon-loader-message").innerText);
                window.fetch("/api/get_app_js.php").then(async (a) => {
                    a.text().then(async (b) => {
                        files = JSON.parse(b);
                        for (file of files) {
                            await sleep(100);
                            document.getElementById("argon-loader-message").innerText = l("Importing JavaScript files... ", "Importation des fichiers JavaScript... ") + file;
                            if (window.electronAPI && window.electronAPI.affectMessage) window.electronAPI.affectMessage(document.getElementById("argon-loader-message").innerText);
                            await loadScript(file + "?" + Math.random());
                        }
                        await sleep(100);
                        document.getElementById("argon-loader-message").innerText = l("Running JavaScript startup hooks...", "Exécution des modules JavaScript de démarrage...");
                        for (hook of _argonLoadedHooks) {
                            await sleep(100);
                            if (hook.name.trim() !== "") {
                                document.getElementById("argon-loader-message").innerText = l("Running JavaScript startup hooks... ", "Exécution des modules JavaScript de démarrage... ") + hook.name;
                            } else {
                                document.getElementById("argon-loader-message").innerText = l("Running JavaScript startup hooks... <!>", "Exécution des modules JavaScript de démarrage... <!>");
                            }
                            hook();
                        }
                        document.getElementById("argon-loader-message").innerText = l("Importing style definitions...", "Importation des définitions de style...");
                        window.fetch("/api/get_app_css.php").then(async (a) => {
                            a.text().then(async (b) => {
                                files = JSON.parse(b);
                                for (file of files) {
                                    await sleep(100);
                                    document.getElementById("argon-loader-message").innerText = l("Importing style definitions... ", "Importation des définitions de style... ") + file;
                                    await loadStyle(file + "?" + Math.random());
                                }
                                await sleep(100);
                                document.getElementById("argon-loader-message").innerText = l("Resolving songs...", "Résolution des morceaux...");
                                window.fetch("/api/get_list.php").then(async (a) => {
                                    a.text().then(async (b) => {
                                        _argonSongsData = JSON.parse(b);
                                        document.getElementById("argon-loader-message").innerText = l("Loading interface...", "Chargement de l'interface...");
                                        document.getElementById("argon-loader").style.display = "none";
                                    })
                                })
                            })
                        })
                    })
                })
            }, 1000)
        }
    </script>
</head>
<body>
    <div id="outofsupport">
        Argon is not maintained anymore and will stop working soon<span id="oos-desktop">, we are currently working on an alternative.</span>
    </div>
    <?php if ($_FAMILINE): ?>
        <iframe style="position:fixed;left:0;right:0;top:0;border: none;width: 100%;height:32px;" src="https://cdn.familine.minteck.org/statusbar.php"></iframe>
    <style>
        #argon-loader, #argon-app, #navigation-outer, #frame {
            top: 32px;
        }
    </style>
    <?php endif; ?>
    <audio id="argon-player"></audio>
    <div id="argon-loader">
        <div id="argon-loader-logo">
            <div style="text-align: center;">
                <img src="<?= str_contains($_SERVER['HTTP_USER_AGENT'], "+AutomateCloud/") && !$_FAMILINE ? ("/native.svg") : ($_FAMILINE ? "https://familine.minteck.org/icns/familine-music.svg" : "/favicon.svg") ?>" style="width:128px;">
                <br><br>
                <div style="width:48px;height:48px;text-align: center;margin-left: auto;margin-right: auto;">
                    <svg class="circular-loader" viewBox="25 25 50 50">
                        <circle class="loader-path" cx="50" cy="50" r="20" fill="none"></circle>
                    </svg>
                </div>
            </div>
        </div>
        <div style="position: fixed;bottom: 10px;left: 10px;font-size:12px;">
            <span id="argon-loader-message" style="font-family:-apple-system, 'Segoe UI', 'Ubuntu', sans-serif;"><?= l("Waiting for network...", "En attente de connexion réseau...") ?></span>
        </div>
    </div>
    <div id="argon-app">
        <aside id="navigation-outer">
            <div id="navigation">
                <a onclick="ArgonNavigation.about();" id="navigation-about" title="<?= $_FAMILINE ? "Familine Musique" : "Argon" ?> v<?= file_get_contents($root . "/version"); ?>">
                    <img id="navigation-about-icon" src="<?= str_contains($_SERVER['HTTP_USER_AGENT'], "+AutomateCloud/") && !$_FAMILINE ? ("/native.svg") : ($_FAMILINE ? "https://familine.minteck.org/icns/familine-music.svg" : "/favicon.svg") ?>" alt="<?= $_FAMILINE ? "Familine Musique" : "Argon" ?>" id="navigation-logo">
                </a>
                <a onclick="ArgonNavigation.home();" title="<?= l("Home", "Accueil") ?>" class="navigation-item" id="navigation-home">
                    <img src="/icons/home-off.svg" alt="<?= l("Home", "Accueil") ?>" class="navigation-item-icon"
                         id="navigation-home-icon">
                </a>
                <a onclick="ArgonNavigation.library();" title="<?= l("Library", "Bibliothèque") ?>" class="navigation-item" id="navigation-library">
                    <img src="/icons/library-off.svg" alt="<?= l("Library", "Bibliothèque") ?>" class="navigation-item-icon"
                         id="navigation-library-icon">
                </a>
                <a onclick="ArgonNavigation.lyrics();" title="<?= l("Lyrics", "Paroles") ?>" class="navigation-item" id="navigation-lyrics">
                    <img src="/icons/lyrics-off.svg" alt="<?= l("Lyrics", "Paroles") ?>" class="navigation-item-icon"
                         id="navigation-lyrics-icon">
                </a>
                <a onclick="ArgonNavigation.settings();" title="<?= l("Settings", "Préférences") ?>" class="navigation-item" id="navigation-settings">
                    <img src="/icons/settings-off.svg" alt="<?= l("Settings", "Préférences") ?>" class="navigation-item-icon"
                         id="navigation-settings-icon">
                </a>
            </div>
        </aside>
        <footer id="player">
            <div id="player-inner">
                <div id="player-buttons">
                    <div id="player-buttons-inner">
                        <a onclick="ArgonPlayer.previous();" class="player-button player-button-disabled" title="<?= l("Previous", "Précédent") ?>" id="player-button-previous">
                            <img src="/icons/previous.svg" alt="<?= l("Previous", "Précédent") ?>" class="player-button-icon" id="player-button-previous-icon">
                        </a><a onclick="ArgonPlayer._player.play();" class="player-button" title="<?= l("Play", "Lecture") ?>" id="player-button-play">
                            <img src="/icons/play.svg" alt="<?= l("Play", "Lecture") ?>" class="player-button-icon" id="player-button-play-icon">
                        </a><a onclick="ArgonPlayer._player.pause();" class="player-button" title="Pause" id="player-button-pause">
                            <img src="/icons/pause.svg" alt="Pause" class="player-button-icon" id="player-button-pause-icon">
                        </a><a class="player-button" title="<?= l("Loading", "Chargement") ?>..." id="player-button-load">
                            <div class="player-button-icon" id="player-button-load-icon">
                                <svg class="circular-loader" viewBox="25 25 50 50">
                                    <circle class="loader-path" cx="50" cy="50" r="20" fill="none"></circle>
                                </svg>
                            </div>
                        </a><a onclick="ArgonPlayer.next();" class="player-button player-button-disabled" title="<?= l("Next", "Suivant") ?>" id="player-button-next">
                            <img src="/icons/next.svg" alt="<?= l("Next", "Suivant") ?>" class="player-button-icon" id="player-button-next-icon">
                        </a><a onclick="ArgonPlayer.shuffle();" class="player-button" title="<?= l("Shuffle", "Lecture aléatoire") ?>" id="player-button-shuffle">
                            <img src="/icons/shuffle-off.svg" alt="<?= l("Shuffle", "Lecture aléatoire") ?>" class="player-button-icon" id="player-button-shuffle-icon">
                        </a><a onclick="ArgonPlayer.repeat();" class="player-button" title="<?= l("Repeat", "Lecture en boucle") ?>" id="player-button-repeat">
                            <img src="/icons/repeat-off.svg" alt="<?= l("Repeat", "Lecture en boucle") ?>" class="player-button-icon" id="player-button-repeat-icon">
                        </a>
                    </div>
                </div>
                <div id="player-seekbar-area">
                    <span id="player-seekbar-elapsed">00:00</span>
                    <input type="range" min="0" max="0" value="0" id="player-seekbar">
                    <span id="player-seekbar-total">00:00</span>
                </div>
                <div id="player-info">
                    <img id="player-artwork" alt="" src="">
                    <div id="player-info-text">
                        <div id="player-info-text-title">Promises</div>
                        <div id="player-info-text-set">Scootaloo EP</div>
                    </div>
                </div>
            </div>
        </footer>
        <main id="frame">
            <iframe id="frame-inner"></iframe>
        </main>
    </div>
</body>
</html>