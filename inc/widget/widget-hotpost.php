<?php

//自定义小工具 之 热门文章

class huitheme_hot_posts extends WP_Widget {
    function __construct() {
        parent::__construct( 'hot_posts', 'HUiTHEME-热门文章' , array('description' => '热门文章的展示'));
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']) ? strip_tags($instance['limit']) : 5;

        echo $before_widget;

        if( $title ) echo $before_title.$title.$after_title;

        echo '<ul class="widget_hot_post">';

        query_posts('posts_per_page='.$limit.'&orderby=comment_count&ignore_sticky_posts=1'); while (have_posts()) : the_post();  ?>

        <li class="widget_hot_li">
            <?php
            if ( has_post_thumbnail() ) {
                the_post_thumbnail(array(400, 280, true));
            } else {
                echo wp_get_attachment_image( get_theme_mod('ds_nopic') , array(400, 280, true));
            }
            ?>
            <div class="hot_post_info">
                <h4><a class="stretched-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <p><?php echo get_comments_number() ?>条留言</p>
            </div>
        </li>

        <?php
            endwhile; wp_reset_query();

        echo '</ul>';
        echo $after_widget;
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
            <label for="<?php echo $this->get_field_id('limit'); ?>">显示数量：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
        <?php
    }
}



add_action('widgets_init', 'huitheme_hot_posts_init');
function huitheme_hot_posts_init() {
    register_widget('huitheme_hot_posts');
}