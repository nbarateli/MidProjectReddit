<?php
/**
 * Created by PhpStorm.
 * User: Niko
 * Date: 16.04.2018
 * Time: 21:54
 */
function getSub($path) {

    $tokens = strtok($path, '/');
    return strtok('/');

}

function getWebsite($url) {
    if (strlen($url) < 1) return "";
    $parsed = parse_url($url);
    if (!strcasecmp($parsed['host'], "www.reddit.com"))
        return "self." . getSub($parsed['path']);
    return $parsed['host'];
}

function getPicture($post) {
    if ($post->image != null) return $post->image;
    switch (strtoupper($post->type)) {
        case 'LINK':
            return 'img/reddit_post_link.png';
        case 'MEDIA':
            return 'img/reddit_post_media.png';
        case 'NSFW':
            return 'img/reddit_post_nsfw.png';
        case 'R':
            return 'img/reddit_post_r.png';
        default:
            return 'img/reddit_post_text.png';
    }
}

function getCommunityList() {

    return json_decode(file_get_contents('database/reddit-communities.json'));
}

function renderTags($tags) {
    $result = "";
    for ($i = 0; $i < count($tags); $i++) {
        $result .= (" <a href='/'>" . $tags[$i] . "</a>") . ($i < count($tags) - 1 ? ',' : '');
    }
    return $result;
}

function countVote($up) {
    if (strlen(strval($up)) <= 4) return $up;
    return number_format($up / 1000.0, 1) . "k";
}

function addTag(&$tags, $tag) {
    if (!array_key_exists($tag, $tags)) {
        $tags[$tag] = 0;
    }
    $tags[$tag]++;
}

function addTags($post, &$tags) {
    foreach ($post->tags as $tag) {
        addTag($tags, $tag);
    }
}

function getMean($a, $col = null) {
    $sum = 0;
    $count = count($a);
    if ($count == 0) return 0;
    foreach ($a as $item) {
        $sum += ($col == null ? $item : $item[$col]);
    }
    return $sum / $count;
}

function standardDeviation($a, $mean, $col = null) {
    $sum = 0;
    $N = count($a);
    if ($N == 0) return 0;
    foreach ($a as $item) {
        $x = ($col == null ? $item : $item[$col]);
        $sum += pow(($x - $mean), 2);
    }
    return sqrt($sum / $N);
}

function build_array($tags, &$result) {
    foreach ($tags as $tagname => $frequency) {
        $tag = ['tag' => $tagname, 'count' => $frequency];
        array_push($result, $tag);
    }
    $mean = getMean($result, 'count');
    $standard_dev = standardDeviation($result, $mean, 'count');
    assignScores($result, $mean, $standard_dev, 'count');

    shuffle($result);
    return 0;
}

function getRank($z) {
    if ($z >= 2.0) return 'very-popular';
    if ($z >= 1.0) return 'popular';
    if ($z >= 0.5) return 'somewhat-popular';
    return 'not-popular';

}

function assignScores(&$result, $mean, $standart_dev, $col) {
    foreach ($result as &$item) {
        $x = $col == null ? $item : $item[$col];
        $item['z'] = ($x - $mean) / $standart_dev;
    }
}

function getTags($reddit) {
    $tags = [];
    foreach ($reddit as $post) {
        addTags($post, $tags);
    }
    $result = [];
    build_array($tags, $result);
    return $result;
}