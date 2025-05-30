<?php

header("Content-Type: application/json");

$files = scandir($_SERVER['DOCUMENT_ROOT'] . "/js");
$js = [];

foreach ($files as $file) {
    if (!str_starts_with($file, ".")) {
        $js[] = "/js/" . $file;
    }
}

die(json_encode($js));