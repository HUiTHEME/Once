<?php

//自定义小工具 之 作者信息

class huitheme_widget_author extends WP_Widget {
    function __construct() {
        parent::__construct('author_show', 'HUiTHEME-作者信息', array('description' => '该工具只在文章页面侧栏有效'));
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']) ? strip_tags($instance['limit']) : 5;


        $author_id = get_the_author_meta( 'ID' );

        echo '
        <div class="author_show_box">
            <div class="author_show_head">
                '.get_avatar( $author_id, 80).'
                <h3>'.get_the_author_meta('display_name').'</h3>
                <p>'.get_the_author_meta('description').'</p>
            </div>
            <div class="author_show_info">
                <span><i class="bi bi-book"></i><b>文章</b>'.count_user_posts($author_id).'</span>
                <span><i class="bi bi-chat-square-dots"></i><b>评论</b>'.get_comments('count=true&user_id='.$author_id).'</span>
            </div>

        ';
        echo '<ul class="author_post">';

        query_posts('author__in='.$author_id.'&posts_per_page='.$limit.'&ignore_sticky_posts=1'); while (have_posts()) : the_post();  ?>


        <li>
            <?php
            if ( has_post_thumbnail() ) {
                the_post_thumbnail(array(400, 280, true));
            } else {
                echo wp_get_attachment_image(get_theme_mod('ds_nopic'), array(400, 280, true));
            }
            ?>
            <div class="author_title">
                <h4><a class="stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <p><?php echo get_comments_number() ?>条留言</p>
            </div>
        </li>

    <?php
        endwhile; wp_reset_query();

        echo '</ul></div>';
    }



    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
        return $instance;
    }



    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">文章数量：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
        <?php
    }
}



add_action('widgets_init', 'huitheme_widget_author_init');
function huitheme_widget_author_init() {
    register_widget('huitheme_widget_author');
}