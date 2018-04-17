<?php

include_once "utils.php"
?>
<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>reddit: the front page of the internet</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>reddit: the front page of the internet</title>
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
    <li class="menu-item"><a class="menu-link menu-item-selected" href="#"><b>Niko</b></a></li>
    <li class="menu-item"><a class="menu-link" href="#"><b>Nikora</b></a></li>
    <li class="menu-item"><a class="menu-link" href="#"><b>Statusebi</b></a></li>
    <li class="menu-item"><a class="menu-link" href="#"><b>Mee</b></a></li>
  </ul>
  <div id="header-right">
    <div id="userspace">
      <ul>
        <li><a href="#">Nikooo (242)</a></li>
        |
        <li><a href="#">Msg</a></li>
        |
        <li><a href="#">preferences</a></li>
        |
        <li><a href="#">stats</a></li>
        |
        <li><a href="#">help</a></li>
        |
        <li><a href="#">blog</a></li>
        |
        <li><a href="#">logout</a></li>

      </ul>
    </div>
    <div class="search">
      <form action="#">
        <label><input placeholder="Search" size="29">
          <button type="submit"><img src="img/reddit_search.png"></button>
        </label>
      </form>
    </div>
  </div>
</div>

<div id="side" class="side">
  <div id="customize" class="side">
    <h1>Customize Your Reddit</h1>
    <ul id="checklist-1" class="filters">
        <?php
        $communities = getCommunityList();

        foreach ($communities[0] as $community) {

            ?>
          <li><label><input type="checkbox"> <?= $community ?></label></li>
            <?php
        }
        ?>
    </ul>
    <ul id="checklist-2" class="filters">
        <?php foreach ($communities[1] as $community) {
            ?>
          <li><label><input type="checkbox"> <?= $community ?></label></li>
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
    $content = file_get_contents("database/reddit-posts.json");
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
        <div class="vote">
          <div class="vote-arrow vote-up"></div>
          <div class="vote-value"><b><?= countVote($post->up) ?> </b></div>
          <div class="vote-arrow vote-down"></div>
        </div>
        <div class="post-image">
          <img src="<?= getPicture($post) ?>">
        </div>
        <div class="post-content">
          <div class="title">
            <h3><a href="/"><?= $post->title ?></a>
              <small class="source">(<?= getWebSite($post->url) ?>)</small>
            </h3>
          </div>
          <div class="details">
            <small>submitted 21 minutes ago by <a
                      href="https://reddit.com/user<?= $post->author ?> ">
                    <?= $post->author ?>
              </a> tagged: <?= getTags($post->tags) ?></small>
            <br>
            <small><b> 218 comments save hide report </b></small>
          </div>
        </div>
      </div>
        <?php
    } ?>
</div>
<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/vendor/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
<script src="js/votes.js"></script>
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
