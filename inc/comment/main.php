<?php define('AC_VERSION','2.0.0');

if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	wp_die('请升级到4.4以上版本');
}

if(!function_exists('fa_ajax_comment_scripts')) :

    function fa_ajax_comment_scripts(){
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        if ( is_single() || is_page() ){ 
        wp_enqueue_style( 'ajax-comment', get_template_directory_uri() . '/inc/comment/app.css', array(), AC_VERSION );
        wp_enqueue_script( 'ajax-comment', get_template_directory_uri() . '/inc/comment/app.js', array( 'jquery' ), AC_VERSION , true );
        }

        wp_localize_script( 'ajax-comment', 'ajaxcomment', array(
            'ajax_url'   => admin_url('admin-ajax.php'),
            'order' => get_option('comment_order'),
            'formpostion' => 'bottom', //默认为bottom，如果你的表单在顶部则设置为top。
        ) );
    }

endif;

if(!function_exists('fa_ajax_comment_err')) :

    function fa_ajax_comment_err($a) {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/plain;charset=UTF-8');
        echo $a;
        exit;
    }

endif;

if(!function_exists('fa_ajax_comment_callback')) :

    function fa_ajax_comment_callback(){
        $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
        if ( is_wp_error( $comment ) ) {
            $data = $comment->get_error_data();
            if ( ! empty( $data ) ) {
            	fa_ajax_comment_err($comment->get_error_message());
            } else {
                exit;
            }
        }
        $user = wp_get_current_user();
        do_action('set_comment_cookies', $comment, $user);
        $GLOBALS['comment'] = $comment; //根据你的评论结构自行修改，如使用默认主题则无需修改
        ?>
        <li <?php comment_class(); ?>>
            <article class="comment-body">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php echo get_avatar( $comment, $size = '40')?>
                        <b class="fn">
                            <?php echo get_comment_author_link();?>
                        </b>
                    </div>
                    <div class="comment-metadata">
                        <?php echo get_comment_date(); ?>
                    </div>
                </footer>
                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>
            </article>
        </li>
        <?php die();
    }

endif;

add_action( 'wp_enqueue_scripts', 'fa_ajax_comment_scripts' );
add_action('wp_ajax_nopriv_ajax_comment', 'fa_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'fa_ajax_comment_callback');



// 评论添加@
function ds_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
  }

  return $comment_text;
}
add_filter( 'comment_text' , 'ds_comment_add_at', 20, 2);


//屏蔽纯英文评论和纯日文
function refused_english_comments($incoming_comment) {
    $pattern = '/[一-龥]/u';
    // 禁止全英文评论
    if(!preg_match($pattern, $incoming_comment['comment_content'])) {
        fa_ajax_comment_err( "您的评论中必须包含汉字!" );
    }
    $pattern = '/[あ-んア-ン]/u';
    // 禁止日文评论
    if(preg_match($pattern, $incoming_comment['comment_content'])) {
        fa_ajax_comment_err( "评论禁止包含日文!" );
    }
    return( $incoming_comment );
}
add_filter('preprocess_comment', 'refused_english_comments');



//WordPress 评论回复邮件通知
function fanly_comment_mail_notify($comment_id) {
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = trim(get_comment($parent_id)->comment_author) . '，您在【' . $blogname . '】中的留言有新的回复啦！';
        $message = '
        <p>您好, ' . trim(get_comment($parent_id)->comment_author) . '，您在《' . get_the_title($comment->comment_post_ID) . '》发表的评论有了回应。</p>
        <p style="margin:20px 0;color:#757575;">' . nl2br(strip_tags(get_comment($parent_id)->comment_content)) . '</p>
        <p>' . trim($comment->comment_author) . ' 给您的回复如下:</p>
        <p style="margin:20px 0;color:#757575;">' . nl2br(strip_tags($comment->comment_content)) . '</p>
        <p>您可以查看<a style="color:#5692BC" href="' . htmlspecialchars(get_comment_link($parent_id)) . '">完整的回复內容</a>，也欢迎再次光临【<a style="color:#5692BC" href="' . home_url() . '">' . $blogname . '</a>】。</p>
        <p style="padding-bottom:15px;">(此邮件由系统自动发出,请勿直接回复!)</p>';
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $to, $subject, $message, $headers );
    }
}
add_action('comment_post', 'fanly_comment_mail_notify');