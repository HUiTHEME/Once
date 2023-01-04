<?php
#安全检测
if (!defined('DB_NAME')) {
    die('theme:http://www.huitheme.com');
}

//中文附件上传
function uazoh_wp_upload_filter($file){  
$time=date("YmdHis");  
$file['name'] = $time."".mt_rand(1,100).".".pathinfo($file['name'] , PATHINFO_EXTENSION);  
return $file;  
}  
add_filter('wp_handle_upload_prefilter', 'uazoh_wp_upload_filter');  