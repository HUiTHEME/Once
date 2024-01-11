<?php
#安全检测
if (!defined('DB_NAME')) {
    die('theme:http://www.huitheme.com');
}
//移除顶部多余信息
remove_action( 'wp_head', 'feed_links_extra', 3 );          //移除meta feed
remove_action( 'wp_head', 'rsd_link' );                     //移除meta rsd+xml开放接口
remove_action( 'wp_head', 'wlwmanifest_link' );             //移除meta wlwmanifest+xml开放接口
remove_action( 'wp_head', 'wp_generator' );                 //移除meta WordPress版本
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );  //移除meta 默认固定链接
remove_action('wp_head', 'wp_oembed_add_discovery_links');  //移除meta json+oembed
remove_action('wp_head', 'wp_oembed_add_host_js');          //移除meta xml+oembed

//去除后台标题中的“—— WordPress”
add_filter('admin_title', 'wpdx_custom_admin_title', 10, 2);
function wpdx_custom_admin_title($admin_title, $title){
return $title.' &lsaquo; '.get_bloginfo('name');
}

//禁用emoji's
remove_action('admin_print_scripts',    'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head',        'print_emoji_detection_script', 7);
remove_action('wp_print_styles',    'print_emoji_styles');
remove_action('embed_head',     'print_emoji_detection_script');
remove_filter('the_content_feed',   'wp_staticize_emoji');
remove_filter('comment_text_rss',   'wp_staticize_emoji');
remove_filter('wp_mail',        'wp_staticize_emoji_for_email');
add_filter( 'emoji_svg_url',        '__return_false' );

//禁止头部加载 link s.w.org
function remove_dns_prefetch( $hints, $relation_type ) {
if ( 'dns-prefetch' === $relation_type ) {
return array_diff( wp_dependencies_unique_hosts(), $hints );
}
return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
function getdata(){
    global $name_files,$author_urls;
    $foot_file_data = file_get_contents( get_template_directory() . $name_files );
    if (strstr($foot_file_data, $author_urls) == false) { die(''); }
}
//移除调用JS和CSS链接中的版本号
function wpdaxue_remove_cssjs_ver( $src ){
if( strpos( $src, 'ver=' ) )
$src = remove_query_arg( 'ver', $src );
return $src;
}
add_filter( 'style_loader_src', 'wpdaxue_remove_cssjs_ver', 999 );
add_filter( 'script_loader_src', 'wpdaxue_remove_cssjs_ver', 999 );

// 移除头部 wp-json 标签和 HTTP header 中的 link
remove_action('wp_head', 'rest_output_link_wp_head', 10 );
remove_action('template_redirect', 'rest_output_link_header', 11 );

//WordPress 移除头部 global-styles-inline-css
add_action('wp_enqueue_scripts', 'fanly_remove_global_styles_inline');
function fanly_remove_global_styles_inline(){
	wp_deregister_style( 'global-styles' );
	wp_dequeue_style( 'global-styles' );
}