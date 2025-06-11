<?php

//支持中文图片上传
require get_template_directory(). '/inc/core/cnpic.php';

//链接去除category
require get_template_directory(). '/inc/core/no_category.php';

//禁用nofeed
require get_template_directory(). '/inc/core/nofeed.php';

//文章内外链加nofollow
require get_template_directory(). '/inc/core/nofollow.php';

//文章内图片自动添加alt属性
require get_template_directory(). '/inc/core/picalt.php';

//禁用pingback
require get_template_directory(). '/inc/core/pingback.php';

//移除古腾堡样式
require get_template_directory(). '/inc/core/remove_block.php';

//去除wp的标识信息
require get_template_directory(). '/inc/core/wpbs.php';

//清理仪表盘无用功能
require get_template_directory(). '/inc/core/ybpql.php';

