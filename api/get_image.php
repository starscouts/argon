<?php

if (isset($_GET["_"])) {
    $f = trim($_GET["_"]);
} else {
    die();
}

header("Content-Type: image/png");

if (str_contains($f, "/") || str_contains($f, ".") || trim($f) === "") die();
$f = str_replace(":", "-", $f);

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/images/" . $f . ".png")) {
    $url = $_SERVER['DOCUMENT_ROOT'] . "/data/images/" . $f . ".png";
} else {
    $url = "https://www.gravatar.com/avatar/" . md5($f) . "?f=y&d=identicon&s=256";
}

die(file_get_contents($url));