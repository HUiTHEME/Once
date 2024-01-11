<?php
if ( post_password_required() )
    return;
?>
<div id="comments" class="comments-area">
    <div class="layoutSingleColumn">
        <?php if ( have_comments() ) : ?>
            <h3 class="comments-title"><i class="bi bi-filter me-2"></i>评论<small>(<?php echo number_format_i18n( get_comments_number() );?>)</small></h3>
            <ol class="comment-list">
                <?php
                wp_list_comments( array(
                    'style'         => 'ol',
                    'short_ping'    => true,
                    'reply_text'    => '回复',
                    'avatar_size'   => 40,
                    'format'        => 'html5'
                ) );
                ?>
            </ol>
            <?php the_comments_pagination( array(
                'prev_text' => '上一页',
                'next_text' => '下一页',
                'prev_next' => false,
            ) );?>
        <?php endif; ?>
        <?php
        $comments_args = array(
        'label_submit'=>'发布评论',
        'title_reply'=>'<i class="bi bi-pen me-2"></i>发布评论',
        'comment_form_top' => 'ds',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
        'fields' => apply_filters( 'comment_form_default_fields', array(
        'author' =>
        '<p class="comment-form-author">'  .
        '<input id="author" class="blog-form-input" placeholder="昵称" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30" /></p>',
        'email' =>
        '<p class="comment-form-email">'.
        '<input id="email" class="blog-form-input" placeholder="Email " name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30" /></p>',
        'url' =>
        '<p class="comment-form-url">'.
        '<input id="url" class="blog-form-input" placeholder="网站地址" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
        '" size="30" /></p>'
        )
        ),
        );
        comment_form($comments_args);?>
    </div>
</div>