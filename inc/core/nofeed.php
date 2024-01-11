<?php
#安全检测
if (!defined('DB_NAME')) {
    die('theme:http://www.huitheme.com');
}
//禁止FEED
function digwp_disable_feed() {
wp_die(__('<h1>Feed已经关闭, 请访问网站<a href="'.get_bloginfo('url').'">首页</a>!</h1>'));
}
add_action('do_feed', 'digwp_disable_feed', 1);
add_action('do_feed_rdf', 'digwp_disable_feed', 1);
add_action('do_feed_rss', 'digwp_disable_feed', 1);
add_action('do_feed_rss2', 'digwp_disable_feed', 1);
add_action('do_feed_atom', 'digwp_disable_feed', 1);