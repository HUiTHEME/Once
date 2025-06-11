<!doctype html>
<script>
  const isDark= localStorage.getItem("isDarkMode");
  if(isDark==="1"){
    document.documentElement.classList.add('dark');
  }else{
    document.documentElement.classList.remove('dark');
  }
</script>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<meta name="format-detection" content="address=no">
<meta name="format-detection" content="date=no">
<?php include('inc/seo.php') ?>
<?php wp_head(); ?>
<?php echo get_theme_mod('ds_header'); ?>
</head>
<body <?php body_class(); ?> >
<?php if( get_theme_mod('ds_background') ): ?>
<style>:root{--ds_background:url(<?php echo get_theme_mod('ds_background'); ?>)}</style>
<?php endif; ?>
<header class="header <?php if ( get_theme_mod('ds_sticky_top') ) { echo 'sticky-top'; } ?>">
    <div class="container">
		<div class="top">
			<button class="mobile_an" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobile_right_nav"><i class="bi bi-list"></i></button>
			<div class="top_l">
            	<h1 class="logo">
					<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
						<?php if( get_theme_mod('ds_logo') ): ?>
						<img src="<?php echo get_theme_mod('ds_logo') ?>" alt="">
						<?php endif; ?>
						<?php if( get_theme_mod('ds_site_name') ): ?>
						<b><?php echo get_theme_mod('ds_site_name') ?></b>
						<?php endif; ?>
					</a>
	        	</h1>
        		<?php wp_nav_menu( array('theme_location'  => 'main', 'container' => 'nav', 'container_class' => 'header-menu', 'container_id'  => '', 'menu_class'  => 'header-menu-ul', 'menu_id'         => '', ) );?>
        	</div>
        	<div class="top_r">
        		<div class="top_r_an theme-switch me-4" onclick="switchDarkMode()"><i class="bi bi-lightbulb-fill"></i></div>
				<button class="top_r_an" type="button" data-bs-toggle="offcanvas" data-bs-target="#c_sousuo"><i class="bi bi-search"></i></button>
        	</div>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-top" id="c_sousuo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-lg-6 search_box">
                <form action="/" class="ss_a clearfix" method="get">
                    <input name="s" aria-label="Search" type="text" onblur="if(this.value=='')this.value='搜索'" onfocus="if(this.value=='搜索')this.value=''" value="搜索">
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" id="mobile_right_nav">
	<div class="mobile_head">
		<div class="mobile_head_logo">
			<img src="<?php echo get_theme_mod('ds_logo') ?>" alt="">
			<?php if( get_theme_mod('ds_site_name') ): ?>
			<b><?php echo get_theme_mod('ds_site_name') ?></b>
			<?php endif; ?>
		</div>
		<div class="theme-switch" onclick="switchDarkMode()"><i class="bi bi-lightbulb-fill"></i></div>
	</div>
	<?php
	wp_nav_menu( array( 'theme_location'=>'mob', 'fallback_cb'=>'', 'container_id'=>'sjcldnav', 'menu_class'=>'menu-zk' ) );
	?>
</div>