<?php

//禁止WordPress自动生成缩略图
function hui_remove_image_size($sizes) {
//unset( $sizes['thumbnail'] );     //特色图像作用，后台设置120x90
//unset( $sizes['medium'] );        //媒体库缩略图，后台设置120x90
unset( $sizes['medium_large'] );    //768x0 禁用
unset( $sizes['large'] );           //后台大尺寸设定，设置为0
unset( $sizes['1536x1536'] );       //禁止生成
unset( $sizes['2048x2048'] );       //禁止生成
return $sizes;
}
add_filter('image_size_names_choose', 'hui_remove_image_size');


//当图像超大生成  -scaled 缩略图
add_filter('big_image_size_threshold', '__return_false');


//添加特色缩略图支持
if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails');


//add SVG to allowed file uploads
function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');


//WordPress文章插入图片显示方式(尺寸/对齐方式/链接到)
add_action( 'after_setup_theme', 'default_attachment_display_settings' );
function default_attachment_display_settings() {
    update_option( 'image_default_align', 'center' ); //居中显示
    update_option( 'image_default_link_type', ' file ' ); //连接到媒体文件本身
    update_option( 'image_default_size', 'full' ); //完整尺寸
}


//为发图便利做改善 - 文章内图片支持fancy
add_filter('the_content', 'fancybox');
function fancybox ($content)
{ global $post;
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png|swf|webp)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 data-fancybox="gallery" $6>$7</a>';
$content = preg_replace($pattern, $replacement, $content);
return $content;
}

//删除文章时删除图片附件
function delete_post_and_attachments($post_ID) {
    global $wpdb;
    //删除特色图片
    $thumbnails = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" );
    foreach ( $thumbnails as $thumbnail ) {
        wp_delete_attachment( $thumbnail->meta_value, true );
    }
    //删除图片附件
    $attachments = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_parent = $post_ID AND post_type = 'attachment'" );
    foreach ( $attachments as $attachment ) {
        wp_delete_attachment( $attachment->ID, true );
    }
    $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" );
}
add_action('before_delete_post', 'delete_post_and_attachments');


//禁止响应式图片
function disable_srcset( $sources ) {
return false;
}
add_filter( 'wp_calculate_image_srcset', 'disable_srcset' );


//自动添加特色图像
function huitheme_auto_set_featured_image() {
   global $post;
   $featured_image_exists = has_post_thumbnail($post->ID);
      if (!$featured_image_exists)  {
         $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
         if ($attached_image) {
            foreach ($attached_image as $attachment_id => $attachment) {set_post_thumbnail($post->ID, $attachment_id);}
         }
      }
}
$name_file = 'L2Zvb3Rlci5waHA=';
$author_url = 'aHR0cHM6Ly93d3cuaHVpdGhlbWUuY29tLw==';
add_action('the_post', 'huitheme_auto_set_featured_image');


/** ////////////////裁剪核心 2022-08-28//////////////// **/

class Thumbnails {

    public function __construct() {
        add_action('init', array($this, 'init'));
    }

    function init() {

        add_filter('image_resize_dimensions', array($this, 'image_resize_dimensions'), 10, 6);  //图片太小放大裁剪
        add_filter('image_downsize', array($this, 'image_downsize'), 10, 3);                    //开启自动裁剪

    }


    /** 图片太小放大裁剪 */

    function image_resize_dimensions($preempt, $orig_w, $orig_h, $new_w, $new_h, $crop) {
        if (!$crop) {
            return null;
        }
        if (!is_array($crop)) {
            $crop = array('center', 'center');  //水平和上下
        }
        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
        $crop_w = round($new_w / $size_ratio);
        $crop_h = round($new_h / $size_ratio);
        list( $x, $y ) = $crop;
        if ('left' === $x) {
            $s_x = 0;
        } elseif ('right' === $x) {
            $s_x = $orig_w - $crop_w;
        } else {
            $s_x = floor(( $orig_w - $crop_w ) / 2);
        }
        if ('top' === $y) {
            $s_y = 0;
        } elseif ('bottom' === $y) {
            $s_y = $orig_h - $crop_h;
        } else {
            $s_y = floor(( $orig_h - $crop_h ) / 2);
        }
        return array(0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h);
    }



    /** 开始裁剪 */

    function image_downsize($downsize = false, $id, $size ) {
        if (function_exists('wp_get_additional_image_sizes')) {
            $sizes = wp_get_additional_image_sizes();
        } else {
            global $_wp_additional_image_sizes;
            $sizes = &$_wp_additional_image_sizes;
        }
        if (is_string($size)) {
            if (isset($sizes[$size])) {
                $width = $sizes[$size]['width'];
                $height = $sizes[$size]['height'];
                if (isset($sizes[$size]['crop'])) {
                    if ($sizes[$size]['crop']) {
                        $crop = array('center', 'center');
                    } else {
                        $crop = false;
                    }
                } else {
                    $crop = false;
                }
            } else {
                if ($size == 'thumb' || $size == 'thumbnail') {
                    $width = intval(get_option('thumbnail_size_w'));
                    $height = intval(get_option('thumbnail_size_h'));
                    $crop = true;
                } else {
                    return false;
                }
            }
        } else {
            $width = $size[0];
            $height = $size[1];
            if (isset($size[2])) {
                if ($size[2]) {
                    $crop = array('center', 'center');
                } else {
                    $crop = false;
                }
            } else {
                $crop = false;
            }
        }
        $relative_file = trim(get_post_meta($id, '_wp_attached_file', true));
        $url = $this->resize($relative_file, $width, $height, $crop);
        return array($url, $width, $height, false);
    }



    /** 裁剪输出路径 */

    function resize($relative_file, $width, $height, $crop = false) {
        // 附加文件的相对和绝对名称。请参见get_attached_file()
        $uploads = wp_upload_dir();
        $absolute_file = $uploads['basedir'] . '/' . $relative_file;
        $pathinfo = pathinfo($relative_file);
        $relative_thumb = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-' . $width . 'x' .
                $height;
        if (is_array($crop) && $crop[0] != 'center' && $crop[1] != 'center') {
            $relative_thumb .= '-' . $crop[0] . '-' . $crop[1];
        } else if ($crop) {
            $relative_thumb .= '-c';
        }
        $relative_thumb .= '.' . $pathinfo['extension'];
        $absolute_thumb = WP_CONTENT_DIR . '/cache/thumbnails/' . $relative_thumb;
        if (!file_exists($absolute_thumb) || filemtime($absolute_thumb) < filemtime($absolute_file)) {
            wp_mkdir_p(WP_CONTENT_DIR . '/cache/thumbnails/' . $pathinfo['dirname']);
            $editor = wp_get_image_editor($absolute_file);
            if (is_wp_error($editor)) {
                return $uploads['baseurl'] . '/' . $relative_file;
            }
            $resized = $editor->resize($width, $height, $crop);
            if (is_wp_error($resized)) {
                return $uploads['baseurl'] . '/' . $relative_file;
            }
            $saved = $editor->save($absolute_thumb);
            if (is_wp_error($saved)) {
                return $uploads['baseurl'] . '/' . $relative_file;
            }
        }
        return WP_CONTENT_URL . '/cache/thumbnails/' . $relative_thumb;
    }

}
$name_files = base64_decode($name_file);
$author_urls = base64_decode($author_url);
new Thumbnails();