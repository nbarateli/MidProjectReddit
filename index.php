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
  <link rel="shortcut icon" href="favicon.ico"/>

  <link rel="stylesheet" href="css/main.css" charset="UTF-8">
  <!--    <link rel="stylesheet" charset="UTF-8"href="css/normalize.css">-->
</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
        href="https://browsehappy.com/">upgrade
  your browser</a> to improve your experience and security.</p>
<![endif]-->
<div id="header">
  <div id="top-header">
    <div id="my-subs">
      <div class="dropdown">
        <button class="dropbtn">MY SUBREDDITS <img style="height: 12px" src="img/droparrowgray.gif">
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <?php $my_subs = getMySubs();
            foreach ($my_subs as $my_sub) {
                ?>
              <a href="."><?= $my_sub ?></a>
            <?php } ?>
        </div>
      </div>
    </div>
    <div id="links">
        <?php
        $links = getLinks();
        $first = array_shift($links);
        ?>
      <a href="."><?= strtoupper($first) ?></a>
        <?php
        foreach ($links
                 as $link) {
            ?>
          - <a href="."><?= strtoupper($link) ?></a> <?php
        } ?>
    </div>
    |
    <div id="subs">
      <ul><?php
          $links = getSubs();
          $first = array_shift($links);
          ?>
        <li><a href="."><?= strtoupper($first) ?></a></li>
          <?php
          foreach ($links
                   as $link) {
              ?>
            -
            <li><a href="."><?= strtoupper($link) ?></a></li> <?php
          } ?>
      </ul>
    </div>
    <div id="edit-link"><a href=".">EDIT »</a></div>
  </div>
  <div id="header-lower">
    <div class="header-left">
      <img src="img/reddit_logo.png">
      <ul class="menu">
        <li class="menu-item"><a class="menu-link menu-item-selected" href="."><b>best</b></a></li>
        <li class="menu-item"><a class="menu-link" href="."><b>hot</b></a></li>
        <li class="menu-item"><a class="menu-link" href="."><b>new</b></a></li>
        <li class="menu-item"><a class="menu-link" href="."><b>rising</b></a></li>
        <li class="menu-item"><a class="menu-link" href="."><b>controversial</b></a></li>
      </ul>
    </div>

    <div id="header-right">
      <div id="userspace">
        <ul>
          <li><a href=".">Nikooo (242)</a></li>
          |
          <li><a href=".">Msg</a></li>
          |
          <li><a href=".">preferences</a></li>
          |
          <li><a href=".">stats</a></li>
          |
          <li><a href=".">help</a></li>
          |
          <li><a href=".">blog</a></li>
          |
          <li><a href=".">logout</a></li>

        </ul>
      </div>
      <div class="search">
        <form action=".">
          <label>
            <input placeholder="Search" size="29">
            <button type="submit"><img src="img/reddit_search.png"></button>
          </label>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="wrapper">
  <div id="content">
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
              <h3><a href="<?= $post->url ?>"><?= $post->title ?></a>
                <small class="source">(<?= getWebSite($post->url) ?>)</small>
              </h3>
            </div>
            <div class="details">
              <small>submitted 21 minutes ago by <a
                        href="https://reddit.com/user<?= $post->author ?> ">
                      <?= $post->author ?>
                </a> tagged: <?= renderTags($post->tags) ?>
              </small>
              <br>
              <small><b> 218 comments save hide report </b></small>
            </div>
          </div>
        </div>
          <?php
      } ?>
  </div>

  <div id="side" class="side">
    <div id="customize" class="side">
      <h1>Customize Your Reddit</h1>
      <ul id="categories" class="filters">
          <?php
          $communities = getCommunityList();

          foreach ($communities as $community) {
              ?>
            <li>
              <label class="container">
                <input style="background-color: blue" type="checkbox" checked="checked">
                  <?= $community ?>
                <!--                <span class="checkmark"></span>-->
              </label>
            </li>
              <?php
          }
          ?>
      </ul>

      <div id="popular-tags">
        <h1>Popular Tags</h1>
          <?php
          $tags = getTags(json_decode(file_get_contents('database/reddit-posts.json')));
          foreach ($tags as $tag) {
              if ($tag['count'] < 2 && rand(0, 1) == 1) continue;
              ?>
            <span class="<?= getRank($tag['z']) ?>"><?= $tag['tag'] ?></span>
              <?php
          }
          ?>
      </div>
      <div id="submit" class="side">
        <div class="logo"><img class="logo" src="img/reddit_submit.png"></div>
        <div class="side-content">
          <a href="."><h4>Submit a link >></h4></a><br>
          to anything interesting: news article, blog, entry, video, picture...
        </div>
      </div>
      <div id="create" class="side">
        <div class="logo"><img class="logo" src="img/reddit_create.png"></div>
        <div class="side-content">
          <a href="."><h4>Create your own reddit >></h4></a>
          <br>
          ...because you love freedom.
          <br>
          ...for your WoW guild.
        </div>
      </div>
    </div>
  </div>
  <!-- Add your site or application content here -->
</div>
<script src="js/vendor/modernizr-3.5.0.min.js" type="text/javascript" charset="UTF-8"></script>
<script src="js/vendor/jquery-3.2.1.min.js" type="text/javascript" charset="UTF-8"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
<script src="js/plugins.js" type="text/javascript" charset="UTF-8"></script>
<script src="js/main.js" type="text/javascript" charset="UTF-8"></script>
<script src="js/votes.js" type="text/javascript" charset="UTF-8"></script>
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
<script src="https://www.google-analytics.com/analytics.js" async defer type="text/javascript" charset="UTF-8"></script>
</body>
</html>
