<?php get_header(); ?>
<section class="index_area">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-9">
                <div class="cat_info_top">
                    <h2 class="mb-0">搜索"<?php echo get_query_var( 's' ); ?>"的结果！</h2>
                </div>
                <div class="post_box">
                    <?php while( have_posts() ): the_post(); ?>
                        <?php include('excerpt.php') ?>
                    <?php endwhile; ?>
                </div>
                <?php get_ds_posts_nav(); ?>
            </div>
            <?php get_sidebar() ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>