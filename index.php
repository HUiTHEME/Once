<?php get_header(); ?>

<section class="index_banner">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-7">
                <div id="banner" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                    <?php
                    $i = 0;
                    $sticky = get_option( 'sticky_posts' );
                    rsort( $sticky );
                    $sticky = array_slice( $sticky, 0, 5 );
                    query_posts( array( 'post__in' => $sticky, 'ignore_sticky_posts' => 1 ) );
                    while ( have_posts() ) : the_post(); ?>
                        <button type="button" data-bs-target="#banner" data-bs-slide-to="<?php echo $i ?>" class="<?php if ( $i == '0') { echo 'active'; } ?>"></button>
                    <?php $i++; endwhile; wp_reset_query();?>
                    </div>
                    <div class="carousel-inner">
                    <?php
                    $i = 0;
                    $sticky = get_option( 'sticky_posts' );
                    rsort( $sticky );
                    $sticky = array_slice( $sticky, 0, 5 );
                    query_posts( array( 'post__in' => $sticky, 'ignore_sticky_posts' => 1 ) );
                    while ( have_posts() ) : the_post(); ?>
                        <div class="carousel-item <?php if ( $i == '0') { echo 'active'; } ?>">
                            <a class="banlist" href="<?php the_permalink(); ?>">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail(array(700, 400, true));
                                } else {
                                    echo wp_get_attachment_image(get_theme_mod('ds_nopic'), array(700, 400, true));
                                }
                                ?>
                                <h2><?php the_title(); ?></h2>
                                <i>置顶精彩</i>
                            </a>
                        </div>
                    <?php $i++; endwhile; wp_reset_query();?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#banner" data-bs-slide="prev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#banner" data-bs-slide="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="col-lg-2 none_992">
                <div class="index_banner_center">
                    <?php
                    $cat_id = get_theme_mod('ds_ban_c');
                    query_posts( array( 'cat'=>$cat_id, 'posts_per_page'=>2, 'ignore_sticky_posts'=>true ) );
                    while( have_posts() ): the_post();
                    ?>
                    <a class="zt_list" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail(array(300, 300, true));
                        } else {
                            echo wp_get_attachment_image(get_theme_mod('ds_nopic'), array(300, 300, true));
                        }
                        ?>
                        <h3><?php the_title(); ?></h3>
                        <b><?php echo get_cat_name($cat_id); ?></b>
                    </a>
                    <?php endwhile; wp_reset_query(); ?>
                </div>
            </div>
            <div class="col-lg-3 none_992">
                <?php
                    $cat_id = get_theme_mod('ds_ban_r');
                    query_posts( array( 'cat'=>$cat_id, 'posts_per_page'=>1, 'ignore_sticky_posts'=>true ) );
                    while( have_posts() ): the_post();
                    ?>
                <a class="gglb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail(array(300, 400, true));
                    } else {
                        echo wp_get_attachment_image(get_theme_mod('ds_nopic'), array(300, 400, true));
                    }
                    ?>
                    <div class="gg_txt">
                        <h3><?php the_title(); ?></h3>
                        <p><i class="bi bi-clock"></i><?php the_time('Y-m-d'); ?></p>
                    </div>
                    <b><?php echo get_cat_name($cat_id); ?></b>
                </a>
                <?php endwhile; wp_reset_query(); ?>
            </div>
        </div>
    </div>
</section>

<section class="index_area">
    <div class="container">
        <div class="row g-3">
            <div class="col-lg-9">
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

<section class="links mobile_none">
    <div class="container">
        <span>友情链接：</span>
        <?php wp_list_bookmarks( 'title_li=&categorize=0&before=&after=' ); ?>
    </div>
</section>

<?php get_footer(); ?>