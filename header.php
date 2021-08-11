<!doctype html>
<html>
<head>

    <title> <?php echo GET('sitename'); ?> </title>

    <meta name="description" content="<?php echo bloginfo('description');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php GET('sitename'); ?>" />
    <meta property="og:description" content="<?php get_bloginfo('description');?>" />
    <meta property="og:url" content="<?php GET('siteurl');?>" />
    <meta property="og:image" content="<?php GET('themeurl')?>/assets/bg.jpg" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="<?php echo GET('googlefont')?>" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php GET('themeurl')?>/assets/logo.png">
    <link href="<?php bloginfo('template_url') ?>/style.css?ver=<?php echo rand(111,999) ?>" rel="stylesheet">
    <?php wp_head(); ?>


</head>
<body <?php body_class();?>>
    <nav class="site-nav">
        <a href="<?php echo site_url(); ?>" class="site-logo">
            <img src="<?php bloginfo('template_url') ?>/assets/logo-long.png" alt="TheSpaceShip.tv">
        </a>
        <?php echo do_shortcode( '[xoo_el_action type="login" display="button" text="Login" change_to="myaccount" redirect_to="same"]' ); ?>
    </nav>
    
    <main class="site-main"> 