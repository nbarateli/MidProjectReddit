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
    $content = file_get_contents('database/reddit-communities.json');
    $communities = json_decode($content);
    $result = [[], []];
    $c = count($communities);
    for ($i = 0; $i < $c / 2; $i++)
        array_push($result[0], $communities[$i]);
    for ($i = $c / 2; $i < $c; $i++)
        array_push($result[1], $communities[$i]);
    return $result;
}

function getTags($tags) {
    $result = "";
    for ($i = 0; $i < count($tags); $i++) {
        $result .= (" <a href='/'>" . $tags[$i] . "</a>") . ($i < count($tags) - 1 ? ',' : '');
    }
    return $result;
}