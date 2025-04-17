<?php

if (trim($_GET['_']) === "") {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/_frame/library.internal/main.php";
} else {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/_frame/library.internal/view.php";
}