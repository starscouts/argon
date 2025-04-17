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
    <link rel="stylesheet" href="/css/frame-library.css">
    <link rel="stylesheet" href="/css/frame.css">
    <meta name="HandheldFriendly" content="true" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div id="argon-frame">
    <div id="frame-header">
        Library
    </div>
    <div id="frame-contents">
        <?php $data = json_decode(file_get_contents("https://argon.minteck.org/api/get_list.php"), true); ?>
        <div id="frame-library-listing">
            <?php foreach ($data["listing"] as $item): ?>
            <div onclick="if (!event.target.classList.contains('frame-library-item-part-song')) location.href='/_frame/library/<?= $item["_id"] ?>';" class="frame-library-item" id="frame-library-item--<?= $item["_type"] . "-" . $item["_id"] ?>">
                <div class="frame-library-item-inner">
                    <div class="frame-library-item-cover">
                        <img alt="Album art" class="frame-library-item-cover-inner" src="/api/get_image.php?_=<?= $item["_id"] ?>">
                    </div>
                    <div class="frame-library-item-text">
                        <div class="frame-library-item-text-inner">
                            <div class="frame-library-item-text-title"><?= $item["name"] ?></div>
                            <div class="frame-library-item-text-info"><?= $item["author"] ?> · <?= substr($item["release"], 0, 4); ?></div>
                            <?php if ($item["_type"] === "song"): ?>
                            <div class="frame-library-item-text-original"><?= $item["original"] === null ? "Original Content" : "original by " . $item["original"] ?></div>
                            <?php else: ?>
                            <div class="frame-library-item-text-original"><?= count($item["songs"]) ?> tracks</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if ($item["_type"] === "set"): ?>
                <div class="frame-library-item-set">
                    <?php foreach ($item["songs"] as $index => $song): ?>
                    <div onclick="location.href='/_frame/library/<?= $song["_id"] ?>';" class="frame-library-item-set-song frame-library-item-part-song" id="frame-library-item-set-song--<?= $item["_id"] ?>--<?= $song["_id"] ?>">
                        <div class="frame-library-item-set-song-cover frame-library-item-part-song">
                            <img alt="Album art" class="frame-library-item-set-song-cover-inner frame-library-item-part-song" src="/api/get_image.php?_=<?= $song["_id"] ?>"></div>
                        <div class="frame-library-item-set-song-title frame-library-item-part-song"><?= $song["name"] ?></div>
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