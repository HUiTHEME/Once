<footer class="footer">
	<section class="footbox">
	    <div class="container">
	    	<div class="foot">
		    	<div class="copyright">
		    		<p><?php
		    		//该部分文字不会出现在网站里;
		    		//吃水不忘挖井人，如果想免费使用，禁止删除下方的版权;
		    		//留有版权链接，让更多人了解并使用上，作者才有动力更新下去;
					//删除版权可能会导致网站运行bug，视为放弃一切技术支持;
					//以上文字可以自由删除。
		    		echo get_theme_mod('ds_banquan') ?> Powered by <a href="https://www.huitheme.com/" target="_blank">WordPress</a></p>
		    	</div>
		    	<div class="foot_nav">
					<?php wp_nav_menu(
					    array(
					    'theme_location'  => 'footnav',
					    'container'       => 'nav',
					    'container_class' => 'dbdh',
					    'depth'           => 1,
					    )
					);
					?>
					<?php if( get_theme_mod('ds_beian') ): ?>
					<a class="beian" href="https://beian.miit.gov.cn/" rel="external nofollow" target="_blank" title="备案号"><i class="bi bi-shield-check me-1"></i><?php echo get_theme_mod('ds_beian') ?></a>
					<?php endif; ?>
		    	</div>
		    </div>
	    </div>
	</section>
	<button class="scrollToTopBtn" title="返回顶部"><i class="bi bi-chevron-up"></i></button>
</footer>

<?php ds_nopic_des(); ?>

<?php echo get_theme_mod('ds_footer'); ?>
<?php wp_footer();?>
</body>
</html>