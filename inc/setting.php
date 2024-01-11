<?php

//Wordpress界最屌的大叔 - 疯狂的大叔 自定义 customize
//相关参数：
//https://codex.wordpress.org/Theme_Customization_API
//https://codex.wordpress.org/Plugin_API/Action_Reference/customize_register
//https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
//https://developer.wordpress.org/reference/classes/wp_customize_control/
//echo get_theme_mod()

add_action('customize_register', 'ds_theme_customizer');
function ds_theme_customizer( WP_Customize_Manager $wp_customize){


////////////////////////////////////////////////////////Category select function
function get_categories_select()
{
  $teh_cats = get_categories();
  $results = [];
  $count = count($teh_cats);
  for ($i = 0; $i < $count; $i++) {
    if (isset($teh_cats[$i]))
      $results[$teh_cats[$i]->cat_ID] = $teh_cats[$i]->name;
    else
      $count++;
  }
  return $results;
}


////////////////////////////////////////////////////////adding section in wordpress customizer   
$wp_customize->add_section('ds_setting_index', array(
	'title'			=> 'HUiTHEME 综合设置',
	'description'	=> '感谢您选择Once，有任何疑问请前往<a href="https://www.huitheme.com/" target="_blank">HUiTHEME</a>寻求帮助。',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_logo', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ds_logo',array(
	'label'      	=> '站点logo',
	'section'    	=> 'ds_setting_index',//设置组
	'settings'   	=> 'ds_logo',
	'description'	=> '为站点上传一枚logo',
))
);


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_site_name', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control('ds_site_name', array(
	'label'   		=> '网站名称',
	'section' 		=> 'ds_setting_index', //设置组
	'type'    		=> 'text',
	'description'	=> '显示在logo右侧的网站名称，纯图片logo可不填写。',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_background', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ds_background',array(
	'label'      	=> '站点背景',
	'section'    	=> 'ds_setting_index',//设置组
	'settings'   	=> 'ds_background',
	'description'	=> '来为站点上传一张背景图吧',
))
);


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_banquan', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control('ds_banquan', array(
	'label'			=> '底部版权信息',
	'section'		=> 'ds_setting_index',//设置组
	'type'			=> 'textarea',
	'description'	=> '网站底部的版权信息',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_beian', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control('ds_beian', array(
	'label'   		=> '站点备案号',
	'section' 		=> 'ds_setting_index', //设置组
	'type'    		=> 'text',
	'description'	=> '在网站底部的右边展现备案号',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_nopic', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'ds_nopic',array(
	'label'      	=> '默认缩略图',
	'section'    	=> 'ds_setting_index',//设置组
	'settings'   	=> 'ds_nopic',
	'description'	=> '文章无图情况下的默认缩略图【必须设置】',
))
);


////////////////////////////////////////////////////////one setting
 $wp_customize->add_setting('ds_sticky_top', array(
    'default'		=> '',
    'transport'		=> 'refresh', //默认值refresh

));
$wp_customize->add_control( 'ds_sticky_top', array(
    'label'			=> '顶部导航固定悬浮',
    'section'		=> 'ds_setting_index',
    'type'			=> 'checkbox',
));

////////////////////////////////////////////////////////one setting
 $wp_customize->add_setting('ds_cat_ajax', array(
    'default'		=> '',
    'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( 'ds_cat_ajax', array(
    'label'			=> '翻页ajax',
    'section'		=> 'ds_setting_index',
    'type'			=> 'checkbox',
    'description'	=> '勾选后，翻页将采用ajax效果呈现',
));


////////////////////////////////////////////////////////one setting
 $wp_customize->add_setting('ds_highlight', array(
    'default'		=> '',
    'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( 'ds_highlight', array(
    'label'			=> '代码高亮',
    'section'		=> 'ds_setting_index',
    'type'			=> 'checkbox',
    'description'	=> '勾选后，将启动代码高亮特性',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_ban_c', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control(  'ds_ban_c', array (
	'label'   		=> 'banner中间区域',
	'section' 		=> 'ds_setting_index', //设置组
	'type' 			=> 'select',
	'choices' 		=> get_categories_select(),
	'description'	=> 'banner的中间区域有2篇文章展示，选择分类，那么该位置将自动出现该分类里最新的2篇文章',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_ban_r', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( 'ds_ban_r', array (
	'label'   		=> 'banner右边区域',
	'section' 		=> 'ds_setting_index', //设置组
	'type' 			=> 'select',
	'choices' 		=> get_categories_select(),
	'description'	=> 'banner的右边区域有1篇文章展示，选择分类，那么该位置将自动出现该分类里最新的1篇文章',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_header', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'ds_header',array(
	'label'      	=> '页头代码',
	'section'    	=> 'ds_setting_index',//设置组
	'settings'   	=> 'ds_header',
	'description'	=> '在页头插入代码',
))
);


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_footer', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'ds_footer',array(
	'label'      	=> '页脚代码',
	'section'    	=> 'ds_setting_index',//设置组
	'settings'   	=> 'ds_footer',
	'description'	=> '在页脚插入代码',
))
);




////////////////////////////////////////////////////////adding section in wordpress customizer     
$wp_customize->add_section('ds_setting_seo', array(
	'title'			=> 'HUiTHEME SEO设置',
	'description'	=> '感谢您选择Once，有任何疑问请前往<a href="https://www.huitheme.com/" target="_blank">HUiTHEME</a>寻求帮助。',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_seo_t', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control('ds_seo_t', array(
	'label'   		=> '首页标题',
	'section' 		=> 'ds_setting_seo', //设置组
	'type'    		=> 'text',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_seo_d', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control('ds_seo_d', array(
	'label'   		=> '首页描述',
	'section' 		=> 'ds_setting_seo', //设置组
	'type'    		=> 'textarea',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_seo_k', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control('ds_seo_k', array(
	'label'   		=> '首页关键词',
	'section' 		=> 'ds_setting_seo', //设置组
	'type'    		=> 'text',
));


////////////////////////////////////////////////////////one setting
$wp_customize->add_setting('ds_seo_fgf', array(
	'default'		=> '',
	'transport'		=> 'refresh', //默认值refresh
));
$wp_customize->add_control('ds_seo_fgf', array(
	'label'   		=> '分隔符',
	'section' 		=> 'ds_setting_seo', //设置组
	'type'    		=> 'text',
	'description'	=> '标题和站点名之间的分隔符号',
));


}