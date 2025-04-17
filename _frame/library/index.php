<?php $root = $_SERVER['DOCUMENT_ROOT']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Argon</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/general.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/frame-home.css">
    <link rel="stylesheet" href="/css/frame.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div id="argon-frame">
    <div id="frame-header">
        Home
    </div>
    <div id="frame-contents">
        <div id="frame-home-intro">
            <img src="/logo/512.png" id="frame-home-logo">
            <div id="frame-home-welcome">Welcome to the Argon Media Platform!</div>
            <div id="frame-home-tagline">High quality ad-free music from Minteck</div>
            <button onclick="location.href='/_frame/library';" id="frame-home-button">Browse Library</button>
            <div id="frame-home-links">
                <a onclick="location.href='/_frame/about';" id="frame-home-link-about" class="frame-home-link">About Argon</a>
                ·
                <a onclick="location.href='/_frame/settings';" id="frame-home-link-settings" class="frame-home-link">Preferences</a>
                ·
                <a onclick="window.open('https://gitlab.minteck.org/explore/projects/topics/Argon');" id="frame-home-link-source" class="frame-home-link">Source Code</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>