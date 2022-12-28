<?php

// 切换经典小工具
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

//禁用默认自带小工具
function huitheme_unregisterWidgets() {
    unregister_widget( 'WP_Widget_Archives' );          //年份文章归档
    unregister_widget( 'WP_Widget_Calendar' );          //日历
    unregister_widget( 'WP_Widget_Categories' );        //分类列表
    unregister_widget( 'WP_Widget_Links' );             //链接
    unregister_widget( 'WP_Widget_Media_Audio' );       //音乐
    unregister_widget( 'WP_Widget_Media_Video' );       //视频
    unregister_widget( 'WP_Widget_Media_Gallery' );     //相册
    //unregister_widget( 'WP_Widget_Custom_HTML' );     //html
    //unregister_widget( 'WP_Widget_Media_Image' );     //图片
    //unregister_widget( 'WP_Widget_Text' );            //文本
    unregister_widget( 'WP_Widget_Meta' );              //默认工具链接
    unregister_widget( 'WP_Widget_Pages' );             //页面
    unregister_widget( 'WP_Widget_Recent_Comments' );   //自带的丑丑的评论
    //unregister_widget( 'WP_Widget_Recent_Posts' );      //文章列表
    unregister_widget( 'WP_Widget_RSS' );               //RSS订阅
    //unregister_widget( 'WP_Widget_Search' );          //搜索
    unregister_widget( 'WP_Widget_Tag_Cloud' );         //自带的丑丑的标签云
    unregister_widget( 'WP_Nav_Menu_Widget' );          //菜单
}
add_action( 'widgets_init', 'huitheme_unregisterWidgets' );


//注册小工具
function huitheme_widgets_init() {
    register_sidebar( array(
        'name' => '分类侧栏',
        'id' => 'index_widgets',
        'description' => '分类右边侧栏',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => '文章侧栏',
        'id' => 'single_widgets',
        'description' => '文章右边侧栏',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => '页面侧栏',
        'id' => 'page_widgets',
        'description' => '页面右边侧栏',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    }
add_action( 'widgets_init', 'huitheme_widgets_init' );


require get_template_directory(). '/inc/widget/widget-tags.php';

require get_template_directory(). '/inc/widget/widget-hotpost.php';

require get_template_directory(). '/inc/widget/widget-comments.php';

require get_template_directory(). '/inc/widget/widget-author.php';
