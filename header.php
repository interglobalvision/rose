<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title('|',true,'right'); bloginfo('name'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

<?php
get_template_part('partials/globie');
get_template_part('partials/seo');
?>

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="icon" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.png">
  <link rel="shortcut" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.ico">
  <link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon-touch.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.png">

<?php if (is_singular() && pings_open(get_queried_object())) { ?>
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php } ?>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!--[if lt IE 9]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->

<?php get_template_part('partials/rose-cursor-anim.svg'); ?>

<section id="main-container">

  <header id="header" class="font-uppercase padding-top-small font-size-small">
    <nav class="container grid-row">
      <div class="grid-item item-s-12 item-m-4 margin-bottom-tiny">
        <h1 class="font-size-small text-align-center" id="site-title"><a class="nav-item" href="<?php echo home_url(); ?>">Rose Los Angeles</a></h1>
      </div>
      <div class="grid-item item-s-4 item-m-2 margin-bottom-tiny">
        <span class="nav-item js-nav-trigger" data-id="about">About</span>
      </div>
      <div class="grid-item item-s-4 item-m-4 item-l-5 margin-bottom-tiny">
        <span class="nav-item js-nav-trigger" data-id="stockists">Stockists</span>
      </div>
      <div class="grid-item item-s-4 item-m-2 item-l-1 margin-bottom-tiny">
        <span class="nav-item js-nav-trigger" data-id="contact">Contact</span>
      </div>
    </nav>
  </header>
