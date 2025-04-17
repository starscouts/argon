<?php if (str_ends_with($_SERVER['HTTP_HOST'], ".familine.minteck.org")) { $_FAMILINE = true; setlocale(LC_TIME, array('fr_FR.UTF-8','fr_FR@euro','fr_FR','french')); } else { $_FAMILINE = false; } function l($en, $fr) { global $_FAMILINE; if ($_FAMILINE) { return $fr; } else { return $en; } } $root = $_SERVER['DOCUMENT_ROOT']; $root = $_SERVER['DOCUMENT_ROOT'];

$data = json_decode(file_get_contents("https://forced.argon.minteck.org/api/get_list.php"), true);
$views = json_decode(file_get_contents("/mnt/argon-cdn/3pad/data.json"), true);

if (str_starts_with($_GET['_'], ":")) {
    header("Location: /_frame/library");
    die();
}

$set = null;
$selected = null;
foreach ($data["listing"] as $item) {
    if ($item["_id"] === $_GET['_']) {
        $selected = $item;
        if ($item["_type"] === "set") {
            $set = true;

            foreach ($item["songs"] as $song) {
                if ($song["_id"] === $_GET['_']) {
                    $selected = $song;
                    $set = false;
                }
            }
        } else {
            $set = false;
        }
    } else {
        if ($item["_type"] === "set") {
            foreach ($item["songs"] as $song) {
                if ($song["_id"] === $_GET['_']) {
                    $selected = $song;
                    $set = false;
                }
            }
        }
    }
}

if ($selected === null) {
    header("Location: /_frame/library");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Argon</title>
    <link rel="shortcut icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/general.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/frame-library.css?_=a">
    <link rel="stylesheet" href="/css/frame.css">
    <link rel="stylesheet" href="/dark.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div id="argon-frame">
    <div id="frame-header">
        <?= l("Library", "Bibliothèque") ?>
    </div>
    <div id="frame-contents">
        <div id="frame-viewer-header-outer" style="background-image: url('/api/get_image.php?_=<?= $selected["_id"] ?>');">
            <div id="frame-viewer-header" <?= str_contains($_SERVER['HTTP_USER_AGENT'], "WebKit") || str_contains($_SERVER['HTTP_USER_AGENT'], "Chrome") ? 'style=    "background: rgba(200, 200, 200, .5);"' : '' ?>>
                <div id="frame-viewer-header-inner">
                    <div id="frame-viewer-header-cover">
                        <img id="frame-viewer-header-cover-inner" alt="<?= l("Album art", "Couv. album") ?>" src="/api/get_image.php?_=<?= $selected["_id"] ?>">
                    </div>
                    <div id="frame-viewer-header-text">
                        <div id="frame-viewer-header-text-inner">
                            <div id="frame-viewer-header-text-title"><?= $selected["name"] ?><?php if ($selected["wip"]): ?> <span class="frame-library-wipBadge"><?= l("WIP", "En travail") ?></span><?php endif; ?></div>
                            <div id="frame-viewer-header-text-info"><?= l("by", "par") ?> <?= $selected["author"] ?> · <?= l("released", "sorti le") ?> <?php
                                $fmt = new \IntlDateFormatter($_FAMILINE ? "fr_FR" : "en_US", NULL, NULL);
                                $fmt->setPattern('d MMMM yyyy');
                                echo $fmt->format(new DateTime($selected["release"]));
                                ?>
                                <?php

                                $playable = false;
                                $firstPlayableIndex = -1;
                                $notPlayableCount = 0;

                                if ($selected["_type"] === "set") {
                                    foreach ($selected["songs"] as $index => $song) {
                                        if ($song["_released"]) {
                                            if ($firstPlayableIndex === -1) $firstPlayableIndex = $index;
                                            $playable = true;
                                        } else {
                                            $notPlayableCount++;
                                        }
                                    }
                                } else if (!str_starts_with($selected["_id"], "_")) {
                                    $playable = true;
                                }

                                ?>
                                <?php if ($playable): ?>
                                    <?php if ((isset($selected["set"]) || $selected["_type"] === "song") && $selected["_released"]): ?>· <?= $views[$selected["_id"]]["_total"] ?> <?= l("listen", "écoute") ?><?= $views[$selected["_id"]] > 1 || $views[$selected["_id"]] === 0 ? "s" : "" ?><?php elseif ($selected["_type"] === "set"): ?>· <?php

                                        $listens = 0;
                                        foreach ($selected["songs"] as $song) {
                                            $listens = $listens + $views[$song["_id"]]["_total"];
                                        }
                                        echo $listens;

                                        ?> <?= l("listen", "écoute") ?><?= $listens > 1 || $listens === 0 ? "s" : "" ?>
                                    <?php endif; ?>
                                <?php endif; ?></div>
                            <?php if ($selected["_type"] === "song" || isset($selected["set"])): ?>
                            <div class="frame-viewer-header-text-original"><?php if ($selected["set"] !== null): ?><?= l("in", "dans") ?> <a id="frame-viewer-header-text-linkToSet" onclick="location.href='/_frame/library/<?= $selected["set"]["_id"] ?>';"><?= $selected["set"]["name"] ?></a> · <?php endif; ?><?= $selected["original"] === null ? l("Original Content", "Contenu original") : l("original by", "original par") . " <a id='frame-viewer-header-text-linkToOriginal' onclick='window.open(&quot;" . $selected['link'] . "&quot)'>" . $selected["original"] . "</a>" ?></div>
                            <?php else: ?>
                            <div class="frame-viewer-header-text-original"><?= count($selected["songs"]) ?> tracks</div>
                            <?php endif; ?>
                            <?php if ($playable): ?>
                            <button onclick="window.parent.ArgonPlayer.play('<?= $selected["_type"] === "set" ? $selected["songs"][$firstPlayableIndex]["_id"] : $selected["_id"] ?>');" id="frame-viewer-header-play"><?= l("Play", "Lire") ?></button>
                            <?php if ($notPlayableCount > 0 && $playable): ?>
                            <span id="frame-viewer-header-notAvailableCount"><?= $notPlayableCount ?> <?= l("track", "morceau") ?><?= $notPlayableCount > 1 ? "s" : "" ?> <?= l("are not playable at the moment.", $notPlayableCount > 1 ? "ne sont pas accessibles en ce moment." : "n'est pas accessible en ce moment") ?></span>
                            <?php endif; ?>
                            <?php else: ?>
                            <div id="frame-viewer-header-notPlayable"><?= $selected["_type"] === "set" ? l("This playlist", "Cette liste de lecture") : l("This song", "Ce morceau") ?> <?= l("is not playable at the moment.", "n'est pas accessible en ce moment.") ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="frame-viewer-description">
            <?php if (trim($selected["description"]) !== ""): ?>
                <?= strip_tags($selected["description"]) ?>
            <?php else: ?>
                <span style="opacity:.5;"><?= l("No description provided.", "Aucune description donnée.") ?></span>
            <?php endif; ?>
        </div>
        <?php if ((isset($selected["_type"]) && $selected["_type"] === "set") || isset($selected["set"])): ?>
        <?php
            if (isset($selected["_type"]) && $selected["_type"] === "set") $set = $selected;
            if (isset($selected["set"])) {
                $set = $selected["set"];
                foreach ($set["songs"] as $index => $sid) {
                    if (isset($data["songs"][$sid])) $set["songs"][$index] = $data["songs"][$sid];
                }
            }
        ?>
        <div class="frame-library-item-set" id="frame-viewer-set">
            <?php foreach ($set["songs"] as $index => $song): ?>
                <div <?php if ($song["_released"]): ?>onclick="location.href='/_frame/library/<?= $song["_id"] ?>';"<?php endif; ?> class="frame-library-item-set-song frame-library-item-part-song <?php if (!$song["_released"]): ?>frame-library-item-set-song-wip<?php endif; ?>" id="frame-library-item-set-song--<?= $set["_id"] ?>--<?= $song["_id"] ?>">
                    <div class="frame-library-item-set-song-cover frame-library-item-part-song">
                        <img alt="<?= l("Album art", "Couv. album") ?>" class="frame-library-item-set-song-cover-inner frame-library-item-part-song" src="/api/get_image.php?_=<?= $song["_id"] ?>"></div>
                    <div class="frame-library-item-set-song-title frame-library-item-part-song"><?= isset($selected["set"]) && $song["_id"] === $selected["_id"] ? "<b>" . $song["name"] . "</b>" : $song["name"] ?><?php if ($song["wip"]): ?> <span class="frame-library-wipBadge"><?= l("WIP", "En travail") ?></span><?php endif; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>