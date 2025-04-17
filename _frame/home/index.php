<?php if (str_ends_with($_SERVER['HTTP_HOST'], ".familine.minteck.org")) { $_FAMILINE = true; } else { $_FAMILINE = false; } function l($en, $fr) { global $_FAMILINE; if ($_FAMILINE) { return $fr; } else { return $en; } } $root = $_SERVER['DOCUMENT_ROOT']; $root = $_SERVER['DOCUMENT_ROOT']; if ($_FAMILINE) { require_once "/mnt/familine/app/session.php"; } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Argon</title>
    <link rel="shortcut icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/general.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/frame-home.css">
    <link rel="stylesheet" href="/css/frame.css">
    <link rel="stylesheet" href="/dark.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div id="argon-frame">
    <div id="frame-header">
        <?= l("Home", "Accueil") ?>
    </div>
    <div id="frame-contents">
        <div id="frame-home-intro" <?= $_FAMILINE ? "style=\"filter: hue-rotate(150deg);\"" : "" ?>>
            <img src="<?= str_contains($_SERVER['HTTP_USER_AGENT'], "+AutomateCloud/") ? ("/native.svg") : ($_FAMILINE ? "https://familine.minteck.org/icns/familine-music.svg" : "/favicon.svg") ?>" id="frame-home-logo" <?= $_FAMILINE ? "style=\"filter: hue-rotate(-150deg);\"" : "" ?>>
            <div id="frame-home-welcome"><?= l("Welcome to the Argon Media Platform!", "Bienvenue sur Familine Musique !") ?></div>
            <div id="frame-home-tagline"><?= l("High quality ad-free music from Minteck, powered by ELAC", "Musique de haute qualité et sans publicités de la famille, propulsé par ELAC") ?></div>
            <button onclick="location.href='/_frame/library';" id="frame-home-button"><?= l("Browse Library", "Explorer la bibliothèque") ?></button>
            <div id="frame-home-links">
                <a onclick="location.href='/_frame/about';" id="frame-home-link-about" class="frame-home-link"><?= l("About Argon", "À propos") ?></a>
                ·
                <a onclick="window.open('https://git.equestria.dev/equestria.dev/elac');" id="frame-home-link-source" class="frame-home-link"><?= l("About ELAC", "À propos de ELAC") ?></a>
                ·
                <?php if (!$_FAMILINE): ?>
                <a onclick="location.href='/_frame/copyright';" id="frame-home-link-about" class="frame-home-link"><?= l("Copyright", "Droits d'auteurs") ?></a>
                ·
                <?php endif; ?>
                <a onclick="location.href='/_frame/settings';" id="frame-home-link-settings" class="frame-home-link"><?= l("Preferences", "Préférences") ?></a>
                ·
                <a onclick="window.open('https://gitlab.minteck.org/explore/projects/topics/Argon');" id="frame-home-link-source" class="frame-home-link"><?= l("Source Code", "Code source") ?></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>