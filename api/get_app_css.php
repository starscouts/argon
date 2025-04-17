<?php

header("Content-Type: application/json");

$files = scandir($_SERVER['DOCUMENT_ROOT'] . "/css");
$js = [];

foreach ($files as $file) {
    if (!str_starts_with($file, ".")) {
        $js[] = "/css/" . $file;
    }
}

die(json_encode($js));