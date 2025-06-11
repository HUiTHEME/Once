<?php

//自定义小工具 之 最近评论

class huitheme_comments extends WP_Widget {
    function __construct() {
        parent::__construct('comments', 'HUiTHEME-最近评论', array('description' => '最近评论'));
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']) ? strip_tags($instance['limit']) : 5;

        echo $before_widget;

        if( $title ) echo $before_title.$title.$after_title;

        echo '<ul class="widget_comment_ul">';

        $args = array(
            'number' => $limit,
            'status' => 'approve',
            'author__not_in' => 1
        );
        $comments = get_comments($args);
        global $comment;
        foreach ($comments as $key => $comment) {
        echo '<li>' . get_avatar($comment,40) . '
            <div class="widget_comment_info">
                <a rel="nofollow" href="' .get_comment_link( $comment->comment_ID) . '">
                ' . $comment->comment_content . '
                </a>
                <span>
                    <em>' . $comment->comment_author . '</em>
                    <em>发布于' . human_time_diff(get_comment_date('U'),current_time('timestamp')) . '前</em>
                </span>
            </div>
            </li>';
        }

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



add_action('widgets_init', 'huitheme_comments_init');
function huitheme_comments_init() {
    register_widget('huitheme_comments');
}