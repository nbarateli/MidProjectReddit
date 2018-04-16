<?php

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

?>
<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
  your browser</a> to improve your experience and security.</p>
<![endif]-->
<div id="header">
  <img src="img/reddit_logo.png">
  <ul class="menu">
    <li class="menu-item"><a class="menu-link" href="#">Niko</a></li>
    <li class="menu-item"><a class="menu-link" href="#">Niko</a></li>
    <li class="menu-item"><a class="menu-link" href="#">Niko</a></li>
    <li class="menu-item"><a class="menu-link" href="#">Niko</a></li>
  </ul>
</div>

<div id="side" class="side">
  <div id="customize" class="side">
    <h1>Customize Your Reddit</h1>
    <ul id="checklist-1">
        <?php

        for ($i = 0; $i < 5; $i++) {

            ?>
          <li><input type="checkbox"> nikora</li>
            <?php
        }
        ?>
    </ul>
    <ul id="checklist-2">
        <?php for ($i = 0; $i < 5; $i++) {
            ?>
          <li><input type="checkbox"> nikora <?= rand(20, 200000000) ?></li>
            <?php
        }
        ?>
    </ul>

    <div id="popular">
      <h1>Popular Tags</h1>
    </div>
    <div id="submit" class="side">
      <div class="logo"><img class="logo" src="img/reddit_submit.png"></div>
      <div class="side-content">
        <a href="#"><h4>Submit a link >></h4></a><br>
        to anything interesting: news article, blog, entry, video, picture...
      </div>
    </div>
    <div id="create" class="side">
      <div class="logo"><img class="logo" src="img/reddit_create.png"></div>
      <div class="side-content">
        <a href="#"><h4>Create your own reddit >></h4></a>
        <br>
        ...because you love freedom.
        <br>
        ...for your WoW guild.
      </div>
    </div>
  </div>
</div>
<!-- Add your site or application content here -->
<div id="content">
  <p>Hello world! This is HTML5 Boilerplate.</p>
    <?php
    $content = file_get_contents("database/reddit.json");
    $reddit = json_decode($content);
    usort($reddit, function ($a, $b) {
        return $b->up - $a->up;
    });
    $i = 0;
    foreach ($reddit as $post) {
//        $post = new Entry();
        ?>
      <div class="post">
        <div class="rank"><?= ++$i ?></div>
        <div class="vote"><?= $post->up ?><br>down</div>
        <div class="post-image">
          <img src="<?= getPicture($post) ?>">
        </div>
        <div class="post-content">
          <div class="title">
            <h3><a href="/"><?= $post->title ?></a>
              <small class="source">(<?= getWebSite($post->url) ?>)</small>
            </h3>
          </div>
          <div class="details" style="clear: both">
            <small>submitted 21 minutes ago by <a href="#">jimbecile</a> tagged <a href="">tag1</a></small>
            <br>
            <small><b> 218 comments save hide report </b></small>
          </div>
        </div>
      </div>
        <?php
    } ?>
</div>
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
    window.ga = function () {
        ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>
</html>
