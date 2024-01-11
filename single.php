<?php get_header();?>
<section class="index_area">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-9">
        		<div class="post_container_title">
		    		<h1><?php the_title(); ?></h1>
		    		<p>
		    			<span><i class="bi bi-clock"></i><?php the_time('Y-m-d'); ?></span>
		    			<span><i class="bi bi-eye"></i><?php post_views('',''); ?></span>
		    			<span><i class="bi bi-chat-square-text"></i><?php echo get_post($post->ID)->comment_count; ?></span>
		    		</p>
		    	</div>
            	<div class="post_container">
					<?php while( have_posts() ): the_post(); $p_id = get_the_ID(); ?>
					<article class="wznrys">
					<?php the_content(); ?>
					</article>
					<?php endwhile; ?>
				</div>
				<div class="post_author">
					<div class="post_author_l">
						<?php echo get_avatar(get_the_author_meta('email'), 30); ?>
						<span><?php the_author_meta('nickname'); ?></span>
					</div>
					<div class="post_author_r">
						<div class="post_author_tag">
							<?php the_tags( '<em><i class="bi bi-hash"></i>', '</em><em><i class="bi bi-hash"></i>', '</em>' ); ?>
							<em><i class="bi bi-list"></i><?php the_category(', ') ?></em>
						</div>

						<div class="post_author_icon">
							<a href="#post_comment_anchor"><i class="bi bi-chat-square-dots-fill"></i><?php echo number_format_i18n( get_comments_number() );?></a>
							<a href="javascript:;" data-action="ding" data-id="<?php the_ID(); ?>" class="specsZan <?php if(isset($_COOKIE['specs_zan_'.$post->ID])) echo 'done';?>"><i class="bi bi-hand-thumbs-up-fill"></i><small class="count"><?php if( get_post_meta($post->ID,'specs_zan',true) ){echo get_post_meta($post->ID,'specs_zan',true);} else {echo '0';}?></small>
							</a>
						</div>
					</div>
				</div>

				<div class="next_prev_posts">
				    <?php
				        $prev_post = get_previous_post();
				        $next_post = get_next_post();
				        if(!empty($prev_post)):?>
				        <div class="prev_next_box nav_previous"  style="<?php if ($next_post) {} else { echo 'width:100%'; }?>" >
				            <a href="<?php echo get_permalink($prev_post->ID);?>" title="<?php echo $prev_post->post_title;?>" rel="prev" style="background-image: url(<?php
                                if ( has_post_thumbnail($prev_post->ID) ) {
                                	$data = wp_get_attachment_image_src(get_post_thumbnail_id($prev_post->ID), array(800,200,true)); echo $data[0];
                                } else {
                                	$data = wp_get_attachment_image_src(get_theme_mod('ds_nopic'), array(800,200,true)); echo $data[0];
                                } ?>);">
				            <div class="prev_next_info">
				                <small>上一篇</small>
				                <p><?php echo $prev_post->post_title;?></p>
				            </div>
				            </a>
				        </div>
				    <?php endif;?>
				    <?php
				        $prev_post = get_previous_post();
				        $next_post = get_next_post();
				        if(!empty($next_post)):?>
				        <div class="prev_next_box nav_next" style="<?php if ($prev_post) {} else { echo 'width:100%'; }?>">
				            <a href="<?php echo get_permalink($next_post->ID);?>" title="<?php echo $next_post->post_title;?>" rel="next" style="background-image: url(<?php
                                if ( has_post_thumbnail($next_post->ID) ) {
                                    $data = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), array(800,200,true)); echo $data[0];
                                } else {
                                	$nopic = wp_get_attachment_image_src(get_theme_mod('ds_nopic'), array(800,300,true)); echo $nopic[0];
                                } ?>);">
				            <div class="prev_next_info">
				                <small>下一篇</small>
				                <p><?php echo $next_post->post_title;?></p>
				            </div>
				            </a>
				        </div>
				    <?php endif;?>
				</div>

				<div class="post_related mb-3">
					<h3 class="widget-title">相关文章</h3>
					<?php
					global $post;
					$cats = wp_get_post_categories($post->ID);
					if ($cats) {
					$args = array(
					'category__in' => array( $cats[0] ),
					'post__not_in' => array( $post->ID ),
					'showposts' => 6,
					'ignore_sticky_posts' => 1
					);
					query_posts($args);
					if (have_posts()) {
					while (have_posts()) {
					the_post(); update_post_caches($posts); ?>

						<div class="post_related_list">
							<a class="" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</div>

					<?php } } else { echo ''; } wp_reset_query(); } else { echo ''; } ?>
				</div>
				<div class="post_comment" id="post_comment_anchor">
					<?php
					if ( comments_open() || get_comments_number() ) :
					    comments_template();
					endif;
					?>
				</div>
            </div>
            <?php if (wp_is_mobile()) { } else { ?>
            <div class="col-lg-3">
                <div class="sidebar_sticky">
                    <?php if ( is_active_sidebar( 'single_widgets' ) ) : ?>
                        <?php dynamic_sidebar( 'single_widgets' ); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php if (get_theme_mod('ds_highlight')) { ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/highlight/atom-one-light.css">
<script src="<?php bloginfo('template_directory'); ?>/assets/highlight/highlight.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/assets/highlight/highlightjs-line-numbers.min.js"></script>
<script>
hljs.initHighlightingOnLoad();
$(document).ready(function() {
    $('.wznrys pre code').each(function(i, block) {
        hljs.lineNumbersBlock(block);
    });
});
</script>
<?php } ?>

<?php get_footer(); ?>