<?php

if (isset($_GET["_"])) {
    $f = $_GET["_"];
} else {
    die();
}

if (str_ends_with($_SERVER['HTTP_HOST'], ".familine.minteck.org")) {
    $_FAMILINE = true;
} else {
    $_FAMILINE = false;
}
function l($en, $fr)
{
    global $_FAMILINE;
    if ($_FAMILINE) {
        return $fr;
    } else {
        return $en;
    }
}

$root = $_SERVER['DOCUMENT_ROOT'];

if (str_contains($f, "/") || trim($f) === "." || trim($f) === "..") die();

header("Content-Type: application/json");

$out = [
    "original" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/original.flac",
    "originalpcm" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/originalpcm.wav",
    "ultrahigh" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/ultrahigh.flac",
    "ultrahighpcm" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/ultrahighpcm.wav",
    "veryhigh" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/veryhigh.mp3",
    "high" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/high.mp3",
    "medium" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/medium.mp3",
    "low" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/low.mp3",
    "verylow" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/verylow.mp3",
    "ultralow" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/ultralow.mp3",
    "superlow" => "https://" . ($_FAMILINE ? "music-audio-media01.familine.minteck.org" : "mediacdn.argon.minteck.org") . "/$f/superlow.mp3",
];

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $f)) {
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $f, ((int)file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $f)) + 1);
} else {
    file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $f, "1");
}

die(json_encode($out, JSON_PRETTY_PRINT));