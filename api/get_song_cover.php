<?php

if (isset($_GET["_"])) {
    $f = $_GET["_"];
} else {
    die();
}

header("Content-Type: application/json");

$ua = str_replace("+", "_", str_replace("/", "-", base64_encode(substr($_SERVER["HTTP_USER_AGENT"], 0, 200))));
$ip = str_replace("+", "_", str_replace("/", "-", base64_encode(substr($_SERVER["REMOTE_ADDR"], 0, 48))));

$out = [
    "original" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/original/$ua/$ip"),
    "originalpcm" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/originalpcm/$ua/$ip"),
    "ultrahigh" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/ultrahigh/$ua/$ip"),
    "ultrahighpcm" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/ultrahighpcm/$ua/$ip"),
    "veryhigh" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/veryhigh/$ua/$ip"),
    "high" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/high/$ua/$ip"),
    "medium" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/medium/$ua/$ip"),
    "low" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/low/$ua/$ip"),
    "verylow" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/verylow/$ua/$ip"),
    "ultralow" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/ultralow/$ua/$ip"),
    "superlow" => "https://mediacdn.argon.minteck.org" . file_get_contents("http://192.168.1.51:8875/authorize/$f/superlow/$ua/$ip"),
];

die(json_encode($out, JSON_PRETTY_PRINT));