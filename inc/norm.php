<?php

//加载css及js
function dsjs_add_scripts(){
wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );
wp_enqueue_style( 'bootstrap' );
wp_register_style( 'bifont', get_template_directory_uri() . '/assets/bifont/bootstrap-icons.css' );
wp_enqueue_style( 'bifont' );
wp_register_style( 'stylecss', get_template_directory_uri() . '/style.css' );
wp_enqueue_style( 'stylecss' );
wp_register_script( 'jquery-min', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '', false ); //false就在页头显示
wp_enqueue_script( 'jquery-min' );
wp_register_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '', true );
wp_enqueue_script( 'bootstrap' );
wp_register_script( 'dsjs', get_template_directory_uri() . '/assets/js/js.js', array(), '', true );
wp_enqueue_script( 'dsjs' );
}
add_action('wp_enqueue_scripts', 'dsjs_add_scripts');


//自定义后台版权
function remove_footer_admin () {
    echo '感谢选择 <a href="https://www.huitheme.com" target="_blank" style="text-decoration:none">绘主题-HUiTHEME</a> 为您设计！';
    }
add_filter('admin_footer_text', 'remove_footer_admin');


//自定义wp-login.php登录页面
function custom_login() { ?>
<style type="text/css">
body.login{background:url(https://api.kdcc.cn/img/rand.php);background-size:cover;background-repeat:no-repeat;background-position:center center;display:flex;align-items:center;justify-content:center;}
#login{background:rgb(255 255 255 / 74%);padding:10px 10px 20px 10px;}
#login h1{display:none!important;}
#login form{border:none;box-shadow:none;background:none;padding-bottom:0px;}
#login form p{margin-bottom:5px;}
#login form p .input{margin-top:5px;}
#login form .forgetmenot{width:100%;}
#login form p.submit{width:100%;margin-top:20px;}
#login form p #wp-submit{width:100%;height:42px;background:#58b3e8;border:none;box-shadow:none;text-shadow:none;}
#login form p.forgetmenot{display:block;padding-bottom:20px;}
#login form .clear{display:none!important;}
#login #nav{}
#login #nav a{margin:0px 10px;}
#login .message{display:none}
#login #login_error,
#login .success{border:none;box-shadow:none;color:#fd1616;font-weight:300;margin-bottom:0px;background:none;padding:30px 30px 0px 30px;}
#reg_passmail{display:none}
.language-switcher{display:none!important;}
@media (max-width:768px){
    body.login{background:#fff;}
    #login{width:100%;padding:30px;margin:0px;}
}
</style>
<?php } add_action('login_head', 'custom_login');


//后端CSS控制
function my_admin_theme_style() { ?>
<style type="text/css">
#wp-admin-bar-wp-logo,
#wp-admin-bar-my-account .avatar,
#wp-admin-bar-user-actions,
.user-comment-shortcuts-wrap,
.user-rich-editing-wrap,
.user-admin-bar-front-wrap,
.user-first-name-wrap,
.user-last-name-wrap,
#wp-admin-bar-new-content,
#wp-admin-bar-comments{display:none!important;}

/*zidingyi*/
#customize-theme-controls .accordion-section .attachment-thumb{height:80px;}
#customize-theme-controls .accordion-section .customize-control{padding:20px;width:calc(100% - 40px)!important;background:#fff;border-radius:8px;position:relative;}
#customize-theme-controls .accordion-section .description{color:#acacac!important;font-size:12px;margin-bottom:10px;}
#customize-theme-controls .accordion-section .customize-control#customize-control-custom_css{margin-bottom:0px;margin-left:0px;}
#customize-theme-controls #accordion-panel-nav_menus,
#customize-theme-controls #accordion-panel-widgets{display:none!important;}
#customize-theme-controls .chosen-container.chosen-with-drop .chosen-drop{position:absolute;}

/*post_meta*/
.edit-post-meta-boxes-area .csf-metabox .csf-field{padding:20px 0px!important;}
.edit-post-meta-boxes-area .csf-metabox .csf-section-title{padding:20px 0px!important;background:none;}
.edit-post-meta-boxes-area .csf-metabox .csf-section-title h3{font-size:16px;}
.edit-post-meta-boxes-area .csf-metabox .csf-field.csf-field-repeater .csf-fieldset .csf-field{padding: 20px !important;}
.edit-post-meta-boxes-area .postbox{background:#ffffff;margin:30px!important;border-radius:15px;padding:20px;border:1px solid #dfe0df!important;box-shadow:none;}
.edit-post-meta-boxes-area .postbox-header{border-top:none!important;}
.edit-post-meta-boxes-area #poststuff h2.hndle{padding:20px 10px!important;font-size:16px!important}
.edit-post-meta-boxes-area .inside .csf-nav-inline{border-bottom:3px solid #e6e6e6;background:none;margin:20px 0px;}
.edit-post-meta-boxes-area .inside .csf-nav-inline ul{margin-bottom:-3px;}
.edit-post-meta-boxes-area .inside .csf-nav-inline ul li{}
.edit-post-meta-boxes-area .inside .csf-nav-inline ul li a{color:#888;font-size:16px;padding:12px 0px;margin-right:25px;border-bottom:3px solid #e6e6e6;border-right:none;border-radius:0;background:none;}
.edit-post-meta-boxes-area .inside .csf-nav-inline ul li a.csf-active{border-bottom:3px solid #2271b1;color:#333;}
</style>
<?php }
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');



//禁止谷歌字体
function remove_open_sans() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );


//禁止代码标点转换
remove_filter('the_content', 'wptexturize');


// 经典编辑器的增强  ===============可删除===========================
// 增强按钮增强
function enable_more_buttons($buttons) {
$buttons[] = 'del';
$buttons[] = 'sub';
$buttons[] = 'sup';
$buttons[] = 'fontselect';
$buttons[] = 'fontsizeselect';
$buttons[] = 'cleanup';
$buttons[] = 'styleselect';
$buttons[] = 'wp_page';
$buttons[] = 'anchor';
$buttons[] = 'backcolor';
$buttons[] = 'copy';
$buttons[] = 'cut';
$buttons[] = 'charmap';
return $buttons;
}
add_filter("mce_buttons_3", "enable_more_buttons");
//字体增加
function custum_fontfamily($initArray){
$initArray['font_formats'] = "微软雅黑='微软雅黑';宋体='宋体';黑体='黑体';仿宋='仿宋';楷体='楷体';隶书='隶书';幼圆='幼圆';";
return $initArray;
}
add_filter('tiny_mce_before_init', 'custum_fontfamily');
// 经典编辑器的增强  ================可删除==========================


//激活友情链接后台
add_filter( 'pre_option_link_manager_enabled', '__return_true' );
function detect_head(){
global $author_url;
if(!function_exists("detect")){
    die($author_url);
}}

//去掉描述P标签
function deletehtml($description) {
$description = trim($description);
$description = strip_tags($description,"");
return ($description);
}
add_filter('category_description', 'deletehtml');


/* 评论作者链接新窗口打开 */
function specs_comment_author_link() {
$url    = get_comment_author_url();
$author = get_comment_author();
if ( empty( $url ) || 'http://' == $url )
return $author;
else
return "<a target='_blank' href='$url' rel='external nofollow' class='url'>$author</a>";
}
add_filter('get_comment_author_link', 'specs_comment_author_link');




/**
* Sitemap xml 禁止 wp-sitemap-users-1.xml
* https://www.huitheme.com/wp-sitemap-users.html
*/
add_filter( 'wp_sitemaps_add_provider', function ($provider, $name) { return ( $name == 'users' ) ? false : $provider; }, 10, 2);


/**
* 禁用wordpress默认的favicon.ico图标
*/
add_action( 'do_faviconico', function() {
//Check for icon with no default value
if ( $icon = get_site_icon_url( 32 ) ) {
//Show the icon
wp_redirect( $icon );
} else {
//Show nothing
header( 'Content-Type: image/vnd.microsoft.icon' );
}
exit;
} );


//修改url重写后的作者存档页的链接变量
add_filter( 'author_link', 'yundanran_author_link', 10, 2 );
function yundanran_author_link( $link, $author_id) {
    global $wp_rewrite;
    $author_id = (int) $author_id;
    $link = $wp_rewrite->get_author_permastruct();
    if ( empty($link) ) {
        $file = home_url( '/' );
        $link = $file . '?author=' . $author_id;
    } else {
        $link = str_replace('%author%', $author_id, $link);
        $link = home_url( user_trailingslashit( $link ) );
    }
    return $link;
}
//此处做的是，在url重写之后，把author_name替换为author
add_filter( 'request', 'yundanran_author_link_request' );
function yundanran_author_link_request( $query_vars ) {
    if ( array_key_exists( 'author_name', $query_vars ) ) {
        global $wpdb;
        $author_id=$query_vars['author_name'];
        if ( $author_id ) {
            $query_vars['author'] = $author_id;
            unset( $query_vars['author_name'] );
        }
    }
    return $query_vars;
}


//后台文章列表显示缩略图 以辨识文章
if (function_exists( 'add_theme_support' )){
    add_filter('manage_posts_columns', 'my_add_posts_columns', 5);
    add_action('manage_posts_custom_column', 'my_custom_posts_columns', 5, 2);
}
function my_add_posts_columns($defaults){
   $defaults['my_post_thumbs'] = '特色图像';
    return $defaults;
}
function my_custom_posts_columns($column_name, $id){
    if($column_name === 'my_post_thumbs'){
        echo the_post_thumbnail( array(80,50) );
    }
}


/* 访问计数 */
function record_visitors()
{if (is_singular()) { global $post;$post_ID = $post->ID;if($post_ID) { $post_views = (int)get_post_meta($post_ID, 'views', true);if(!update_post_meta($post_ID, 'views', ($post_views+1))) { add_post_meta($post_ID, 'views', 1, true);}}}}
add_action('wp_head', 'record_visitors');
/// 函数名称：post_views
/// 函数作用：取得文章的阅读次数
getdata();
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
global $post;
$post_ID = $post->ID;
$views = (int)get_post_meta($post_ID, 'views', true);
if ($echo) echo $before, number_format($views), $after;
else return $views;
}


//自定义文章形式 增加 图片 和 图库
add_theme_support('post-formats', array('gallery','image'));


//gravatar国内加速
function replace_gravatar($avatar) {
$avatar = str_replace(array("//gravatar.com/", "//secure.gravatar.com/", "//www.gravatar.com/", "//0.gravatar.com/",
"//1.gravatar.com/", "//2.gravatar.com/", "//cn.gravatar.com/"), "//gravatar.loli.net/", $avatar);
return $avatar;}
add_filter( 'get_avatar', 'replace_gravatar' );


//赞
add_action('wp_ajax_nopriv_specs_zan', 'specs_zan');
add_action('wp_ajax_specs_zan', 'specs_zan');
function specs_zan(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
        $specs_raters = get_post_meta($id,'specs_zan',true);
        $expire = time() + 99999999;
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
        setcookie('specs_zan_'.$id,$id,$expire,'/',$domain,false);
        if (!$specs_raters || !is_numeric($specs_raters)) {
            update_post_meta($id, 'specs_zan', 1);
        }
        else {
            update_post_meta($id, 'specs_zan', ($specs_raters + 1));
        }
        echo get_post_meta($id,'specs_zan',true);
    }
    die;
}



//首页循环里不出现置顶
function exclude_sticky_posts($query){
    if ( is_admin() || ! $query->is_main_query() )
        return;
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'ignore_sticky_posts', 1 );
    }
}
add_action('pre_get_posts','exclude_sticky_posts');


//启动主题自动去到【自定义】
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
wp_redirect( admin_url( 'customize.php?return=%2Fwp-admin%2Fthemes.php' ) );
exit;
}

//提醒上传默认缩略图
function ds_nopic_des()
{
if (get_theme_mod('ds_nopic')) { } else {
echo '<div class="nopic_des"><p>请前往 【WP后台】-【外观】-【自定义】-【HUiTHEME综合设置】<br>对默认缩略图进行设置，此为必设选项。</p><a class="" href="'.get_option('home').'/wp-admin/customize.php">立即前往</a></div>';
}
}


// 翻页类型
function get_ds_posts_nav() {
$args = array(
    'prev_next' => 1,
    'before_page_number' => '',
    'mid_size' => 1,
    'prev_text' => __('上页'),
    'next_text' => __('下页'),
);
if ( get_theme_mod( 'ds_cat_ajax' ) ) {
    echo '<div class="post-read-more">'.get_next_posts_link('加载更多','').'</div>';
} else {
    echo '<div class="posts-nav">'.paginate_links($args).'</div>';
}
}

require get_template_directory(). '/inc/setting.php';