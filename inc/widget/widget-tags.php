<?php

//自定义小工具 之 标签

class huitheme_hot_tags extends WP_Widget {
    function __construct() {
        parent::__construct( 'hot_tags', 'HUiTHEME-标签', array('description' => '标签云的使用') );
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']) ? strip_tags($instance['limit']) : 5;

        echo $before_widget;

        if( $title ) echo $before_title.$title.$after_title;

        echo '<div class="tagcloud">';

        $tags = get_tags(array(
            "number" => $limit,
            "order" => "DESC"
        ));
        foreach($tags as $tag){
            $count = intval( $tag->count );
            $name = apply_filters( 'the_title', $tag->name );
            $class = ( $count > 5 ) ? 'tag-item hot' : 'tag-item';
            echo '<a href="'. esc_attr( get_tag_link( $tag->term_id ) ) .'" class="'. $class .'" title="浏览和' . $name . '有关的文章"><span>' . $name . '</span></a>';
        }

        echo '</div>';
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



add_action('widgets_init', 'huitheme_hot_tags_init');
function huitheme_hot_tags_init() {
    register_widget('huitheme_hot_tags');
}