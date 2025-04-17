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
    <link rel="stylesheet" href="/css/frame-settings.css">
    <link rel="stylesheet" href="/css/frame.css">
    <link rel="stylesheet" href="/dark.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div id="argon-frame">
    <div id="frame-header">
        <?= l("Preferences", "Préférences") ?>
    </div>
    <div id="frame-contents">
        <?php

        $supportsELACpl = true;
        if (str_contains($_SERVER['HTTP_USER_AGENT'], "Safari/") && !str_contains($_SERVER['HTTP_USER_AGENT'], "Chrome/")) {
            $supportsELACpl = false;
        }

        ?>
        <?= l("Audio Quality", "Qualité audio") ?><br>
        <select onchange="localStorage.setItem('quality', document.getElementById('frame-settings-quality').value); document.getElementById('frame-settings-quality-warning').style.display = document.getElementById('frame-settings-quality').value !== '0' ? '' : 'none'" id="frame-settings-quality">
            <optgroup label="<?= l("Recommended Settings", "Paramètres recommandés") ?>">
                <option value="0"><?= l("Automatically depending on network (recommended)", "Automatiquement selon le réseau (recommandé)") ?></option>
                <option value="2"<?= $supportsELACpl ? "" : " disabled" ?>><?= l("Original audio quality", "Qualité audio originale") ?> (ELAC Physical Lossless)</option>
            </optgroup>
            <optgroup label="<?= l("Advanced", "Avancé") ?>">
                <option value="1:ultrahigh"<?= $supportsELACpl ? "" : " disabled" ?>><?= l("Highest quality", "Qualité la plus haute") ?> (ELAC-PL 460<?= l("kbps", " ko/s") ?>, 32<?= l("bit", " bits") ?>)</option>
                <option value="1:veryhigh"><?= l("Higher quality", "Qualité plus haute") ?> (ELAC-EL 320<?= l("kbps", " ko/s") ?>, 32<?= l("bit", " bits") ?>)</option>
                <option value="1:high"><?= l("High quality", "Haute qualité") ?> (ELAC-EL 245<?= l("kbps", " ko/s") ?>, 32<?= l("bit", " bits") ?>)</option>
                <option value="1:medium"><?= l("Medium quality", "Qualité moyenne") ?> (ELAC-EL 175<?= l("kbps", " ko/s") ?>, 16<?= l("bit", " bits") ?>)</option>
                <option value="1:low"><?= l("Low quality", "Basse qualité") ?> (ELAC-EL 130<?= l("kbps", " ko/s") ?>, 16<?= l("bit", " bits") ?>)</option>
                <option value="1:verylow"><?= l("Slightly lower quality", "Qualité légèrement plus basse") ?> (ELAC-EL 100<?= l("kbps", " ko/s") ?>, 16<?= l("bit", " bits") ?>)</option>
                <option value="1:ultralow"><?= l("Lower quality", "Qualité plus basse") ?> (ELAC-EL 85<?= l("kbps", " ko/s") ?>, 16<?= l("bit", " bits") ?>)</option>
                <option value="1:superlow"><?= l("Lowest quality", "Qualité la plus basse") ?> (ELAC-EL 65<?= l("kbps", " ko/s") ?>, 16<?= l("bit", " bits") ?>)</option>
            </optgroup>
        </select>
        <div id="frame-settings-quality-warning" style="display:none;"><?= l("Using another audio quality setting than the default one may lead to audio not playing continuously due to low Internet connection or poor performance.", "Utiliser une autre option de qualité audio que celle par défaut peut empêcher l'audio d'être lu en continu en raison d'une mauvaise performance réseau ou système.") ?></div>
        <?php if (!$supportsELACpl): ?>
            <div id="frame-settings-unsupported-warning"><?= l("This browser does not support playing ELAC Physical Lossless audio.", "Ce navigateur ne supporte pas les lectures de flux ELAC Physical Lossless.") ?></div>
        <?php endif; ?>
    </div>

    <script>
        if (localStorage.getItem("quality") === null) localStorage.setItem('quality', '0');
        document.getElementById('frame-settings-quality').value = localStorage.getItem("quality");
        document.getElementById('frame-settings-quality-warning').style.display = document.getElementById('frame-settings-quality').value !== '0' ? '' : 'none';
    </script>
</div>
</body>
</html>