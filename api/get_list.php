<?php

header("Content-Type: application/json");

$origList = [];

foreach (scandir("/mnt/argon-cdn/files") as $s) {
    if (!str_starts_with($s, ".")) {
        $origList[] = $s;
    }
}

foreach(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/metadata") as $s) {
    if (str_starts_with($s, "_")) {
        $origList[] = substr($s, 0, -5);
    }
}

$listSongs = [];
$songs = [];
foreach ($origList as $song) {
    $listSongs[] = $song;
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/data/metadata/" . $song . ".json")) {
        $songs[$song] = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/metadata/" . $song . ".json"), true);
        $songs[$song]["_id"] = $song;
        $songs[$song]["_localViews"] = file_exists($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $song) ? (int)file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $song) : 0;
    } else {
        $songs[$song] = [
            'name' => $song,
            'original' => null,
            'link' => '',
            'author' => 'Minteck',
            'description' => '',
            'release' => '1970-01-01',
            'lyrics' => null,
            'wip' => false,
            'set' => null,
            'external' => [
                'youtube' => null,
                'soundcloud' => null
            ]
        ];
    }
}

$sets = [];
foreach (scandir($_SERVER["DOCUMENT_ROOT"] . "/data/sets") as $set) {
    if (!str_starts_with($set, ".")) {
        $set_data = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/sets/" . $set), true);
        $set_songs = [];

        foreach ($set_data["songs"] as $song) {
            if (in_array($song, $listSongs)) {
                $set_songs[] = $song;
                if (isset($songs[$song])) {
                    $songs[$song]["set"] = $set_data;
                    $songs[$song]["_id"] = $song;
                    $songs[$song]["_localViews"] = file_exists($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $song) ? (int)file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $song) : 0;
                    if (!isset($songs[$song]["_released"])) $songs[$song]["_released"] = true;
                }
            } else if (str_starts_with($song, ":")) {
                $listSongs[] = $song;
                $songs[$song] = [
                    'name' => substr($song, 1),
                    'original' => null,
                    'link' => null,
                    'author' => null,
                    'description' => null,
                    'release' => null,
                    'lyrics' => null,
                    'set' => null,
                    'wip' => true,
                    '_released' => false
                ];

                $set_songs[] = $song;
                $songs[$song]["set"] = $set_data;
                $songs[$song]["_id"] = $song;
                $songs[$song]["_localViews"] = file_exists($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $song) ? (int)file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/data/local/" . $song) : 0;
                if (!isset($songs[$song]["_released"])) $songs[$song]["_released"] = true;
            }
        }
        $set_data["songs"] = $set_songs;
        $sets[explode(".", $set)[0]] = $set_data;
    }
}

$knownSongs = [];
$list = [];
foreach ($sets as $id => $set) {
    $set["_type"] = "set";
    $set["_id"] = $id;

    foreach ($set["songs"] as $index => $song) {
        $knownSongs[] = $song;
        $songs[$song]["set"]["_id"] = $id;
        $set["songs"][$index] = $songs[$song];
    }

    $list[] = $set;
}
foreach ($songs as $id => $song) {
    $song["_type"] = "song";
    $song["_id"] = $id;
    if (!isset($song["_released"])) $song["_released"] = true;
    if (!in_array($id, $knownSongs)) {
        $knownSongs[] = $id;
        $list[] = $song;
    }
}

usort($list, function ($a, $b) {
    return strtotime($a["release"]) - strtotime($b["release"]);
});
$list = array_reverse($list);

$sorted = [];
foreach ($list as $item) {
    if ($item["_type"] === "song") {
        if (!str_starts_with($item["_id"], ":") && !str_starts_with($item["_id"], "_")) {
            $sorted[] = $item["_id"];
        }
    } else if ($item["_type"] === "set") {
        $set_songs_sorted = array_reverse($item["songs"]);
        foreach ($set_songs_sorted as $song) {
            if (!str_starts_with($song["_id"], ":") && !str_starts_with($song["_id"], "_")) {
                $sorted[] = $song["_id"];
            }
        }
    }
}
$sorted = array_reverse($sorted);

$out = [
    "songs" => $songs,
    "sets" => $sets,
    "listing" => $list,
    "sorted" => $sorted
];

die(json_encode($out, JSON_PRETTY_PRINT));