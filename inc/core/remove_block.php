<?php
#安全检测
if (!defined('DB_NAME')) {
    die('theme:http://www.huitheme.com');
}
//WordPress 5.0 古腾堡默认样式
add_action( 'wp_enqueue_scripts', 'fanly_remove_block_library_css', 100 );
function fanly_remove_block_library_css() {
    wp_dequeue_style( 'wp-block-library' );
}