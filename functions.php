<?php

//ajax评论
require get_template_directory(). '/inc/comment/main.php';

//缩略图裁剪
require get_template_directory(). '/inc/thumbnails.php';

//wp优化
require get_template_directory(). '/inc/index.php';

//基础
require get_template_directory(). '/inc/norm.php';

//注册导航
register_nav_menus(
	array(
	'main'     => __( '主菜单导航' ),
	'mob'      => __( '手机导航' ),
	'footnav'  => __( '底部导航' )
	)
);

//小工具
require get_template_directory(). '/inc/widget.php';