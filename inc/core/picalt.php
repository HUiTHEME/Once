<?php
#安全检测
if (!defined('DB_NAME')) {
    die('theme:http://www.huitheme.com');
}
//给文章图片自动添加alt和title信息
add_filter('the_content', 'imagesalt');
function imagesalt($content) {
       global $post;
       $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
       $replacement = '<a$1href=$2$3.$4$5 alt="'.$post->post_title.'" title="'.$post->post_title.'"$6>';
       $content = preg_replace($pattern, $replacement, $content);
       return $content;
}
