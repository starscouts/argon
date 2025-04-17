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
        Report a copyright infringement
    </div>
    <div id="frame-contents">
        <p>If you think a content hosted on Argon is infringing your copyright, you may want to send in a report to the Argon administrators, so they can remove the concerned content. Make sure you have a way to prove you own the copyrighted content before sending in a report.</p>
        <p>Before sending a report, make sure you have the following information:</p>
        <ul>
            <li>the ID of the song containing the copyrighted content, or a link to the page on Argon;</li>
            <li>a link pointing to the original content (if the link can't be publicly accessed by the time we view your report, it will be ignored);</li>
            <li>a way to prove you own the content (for example: if it is a YouTube video, you can add the Argon song ID at the bottom of the video description)</li>
        </ul>
        <p>We will try to process your request within at most 4 non-business days, but it may be delayed in some cases; please be patient. To start reporting a copyright infringement, send an email to <a class="frame-about-link" href="mailto:contact@minteck.org">contact@minteck.org</a>.</p>
    </div>
</div>
</body>
</html>