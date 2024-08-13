<?php ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title>BringMyWater</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#191919">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/critical.css">
    <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/sections/footer.css">
    <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/sections/header.css">
    <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/sections/checkout.css">
    <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/common.css">
    <?php if( is_account_page() ) : ?>
        <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/sections/personal.css">
    <?php endif; ?>

    <?php if ( is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ) : ?>
        <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/sections/success-order.css">
        <link rel="stylesheet" href="<?=TEMPLATE_PATH?>/css/sections/banner.css">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body class="page__body">
    <?php wp_body_open(); ?>
    <div class="site-container">
        <?php if( is_checkout() and !isset($_GET['key']) ) : ?>
        <?php else : ?>
            <?php dynamic_sidebar('header'); ?>
        <?php endif; ?>
