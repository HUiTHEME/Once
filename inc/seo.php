<?php
$sitename = get_bloginfo('name');
$fgf = get_theme_mod('ds_seo_fgf');
$index_t = get_theme_mod('ds_seo_t');
$index_d = get_theme_mod('ds_seo_d');
$index_k = get_theme_mod('ds_seo_k');
$single_t = get_the_title();
$single_d = wp_trim_words( get_the_content(), 150, '...' );
if ( is_home() || is_front_page() ) { ?>
<title><?php echo $index_t ?><?php if ( $paged > 1 ) echo $fgf.'第'.$paged.'页' ?></title>
<meta name="keywords" content="<?php echo $index_k ?>" />
<meta name="description" content="<?php echo $index_d ?>" />
<?php } ?>
<?php if ( is_single() || is_page() ) { ?>
<title><?php echo $single_t.$fgf.$sitename ?></title>
<meta name="keywords" content="<?php  $posttags = get_the_tags(); if ($posttags) { foreach ( $posttags as $tag ) { echo $tag->name . ','; } }  ?>" />
<meta name="description" content="<?php echo $single_d ?>"/>
<?php } ?>
<?php if ( is_category() || is_tag() ) { ?>
<title><?php echo single_cat_title().$fgf.$sitename; ?><?php if ( $paged > 1 ) echo $fgf.'第'.$paged.'页' ?></title>
<meta name="keywords" content="<?php echo single_cat_title(); ?>" />
<meta name="description" content="<?php echo category_description(); ?>" />
<?php } ?>
<?php if ( is_search() ) { ?>
<title><?php echo get_query_var( 's' ); echo $fgf.$sitename; ?><?php if ( $paged > 1 ) echo $fgf.'第'.$paged.'页' ?></title>
<meta name="keywords" content="<?php echo get_query_var( 's' ); ?>" />
<meta name="description" content="<?php echo get_query_var( 's' ); ?>" />
<?php } ?>
<?php if ( is_404() ) { ?>
<title>404 NOT FOUND<?php echo $fgf.$sitename ?></title>
<?php } ?>