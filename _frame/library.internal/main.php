<?php if (str_ends_with($_SERVER['HTTP_HOST'], ".familine.minteck.org")) { $_FAMILINE = true; } else { $_FAMILINE = false; } function l($en, $fr) { global $_FAMILINE; if ($_FAMILINE) { return $fr; } else { return $en; } } $root = $_SERVER['DOCUMENT_ROOT']; $root = $_SERVER['DOCUMENT_ROOT']; if ($_FAMILINE) { require_once "/mnt/familine/app/session.php"; } ?>
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
        <?php $data = json_decode(file_get_contents("https://forced.argon.minteck.org/api/get_list.php"), true); ?>
        <div id="frame-library-listing">
            <?php foreach ($data["listing"] as $item): ?>
            <div onclick="if (!event.target.classList.contains('frame-library-item-part-song')) location.href='/_frame/library/<?= $item["_id"] ?>';" class="frame-library-item" id="frame-library-item--<?= $item["_type"] . "-" . $item["_id"] ?>">
                <div class="frame-library-item-inner">
                    <div class="frame-library-item-cover">
                        <img alt="<?= l("Album art", "Couv. album") ?>" class="frame-library-item-cover-inner" src="/api/get_image.php?_=<?= $item["_id"] ?>">
                    </div>
                    <div class="frame-library-item-text">
                        <div class="frame-library-item-text-inner">
                            <div class="frame-library-item-text-title"><?= $item["name"] ?><?php if ($item["wip"]): ?> <span class="frame-library-wipBadge"><?= l("WIP", "En travail") ?></span><?php endif; ?></div>
                            <div class="frame-library-item-text-info"><?= $item["author"] ?> · <?= substr($item["release"], 0, 4); ?></div>
                            <?php if ($item["_type"] === "song"): ?>
                            <div class="frame-library-item-text-original"><?= $item["original"] === null ? l("Original Content", "Contenu original") : l("original by ", "original par ") . $item["original"] ?></div>
                            <?php else: ?>
                            <div class="frame-library-item-text-original"><?= count($item["songs"]) ?> <?= l("tracks", "morceaux") ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if ($item["_type"] === "set"): ?>
                <div class="frame-library-item-set">
                    <?php foreach ($item["songs"] as $index => $song): ?>
                    <div <?php if ($song["_released"]): ?>onclick="location.href='/_frame/library/<?= $song["_id"] ?>';"<?php endif; ?> class="frame-library-item-set-song frame-library-item-part-song <?php if (!$song["_released"]): ?>frame-library-item-set-song-wip<?php endif; ?>" id="frame-library-item-set-song--<?= $item["_id"] ?>--<?= $song["_id"] ?>">
                        <div class="frame-library-item-set-song-cover frame-library-item-part-song">
                            <img alt="<?= l("Album art", "Couv. album") ?>" class="frame-library-item-set-song-cover-inner frame-library-item-part-song" src="/api/get_image.php?_=<?= $song["_id"] ?>"></div>
                        <div class="frame-library-item-set-song-title frame-library-item-part-song"><?= $song["name"] ?><?php if ($song["wip"]): ?> <span class="frame-library-wipBadge"><?= l("WIP", "En travail") ?></span><?php endif; ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>