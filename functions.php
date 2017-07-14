<?php
defined('ABSPATH') or die();

require_once( get_template_directory().'/lib/tgm/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'cleanco_register_required_plugins' );

function cleanco_register_required_plugins() {


	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Detheme Portfolio', // The plugin name
			'slug'     				=> 'detheme-portfolio', // The plugin slug (typically the folder name)
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/detheme-portfolio_1.0.6.zip', // The plugin source
			'core'					=> true,
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.0', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/detheme-portfolio_1.0.6.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'WPBakery Visual Composer', // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'core'					=> false,
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/js_composer_4.11.2.1.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.3.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '4.11.2.1', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/js_composer_4.11.2.1.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Cleanco Visual Composer Add On', // The plugin name
			'slug'     				=> 'cleanco_vc_addon', // The plugin slug (typically the folder name)
			'core'					=> true,
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/cleanco_vc_addon_1.0.5.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.5', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/cleanco_vc_addon_1.0.5.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Detheme Megamenu Plugin', // The plugin name
			'slug'     				=> 'dt-megamenu', // The plugin slug (typically the folder name)
			'core'					=> true,
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/dt-megamenu_1.0.7.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.7', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/dt-megamenu_1.0.7.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'core'					=> false,
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.8.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '3.8.1', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'core'					=> false,
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/revslider-v5.1.5.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.8.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '5.1.5', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/revslider-v5.1.5.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Detheme Custom Post',
			'slug'     				=> 'detheme-post',
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/detheme-post.zip',
			'core'					=> false,
			'required' 				=> false,
			'version' 				=> '1.0.4',
			'package_version' 		=> '1.0.4',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/detheme-post.zip',
		),
		array(
			'name'     				=> 'Bookly Lite',
			'slug'     				=> 'bookly-responsive-appointment-booking-tool',
			'core'					=> false,
			'required' 				=> false,
			'version' 				=> '7.6.1',
			'package_version' 		=> '7.6.1',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
		),
		array(
			'name'     				=> 'Cleanco Demo Installer', // The plugin name
			'slug'     				=> 'detheme_demo', // The plugin slug (typically the folder name)
			'core'					=> false,
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/detheme_demo_1.0.5.PLUGIN.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.5', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/detheme_demo_1.0.5.PLUGINN.zip', // If set, overrides default API URL and points to an external URL
		)
		);


	$config = array(
		'id'       		    => 'cleanco-tgmpa',         	
		'domain'       		=> 'tgmpa',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_slug' 		=> 'themes.php', 				// Default parent menu slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
	);

	tgmpa( $plugins, $config );

}

function cleanco_startup() {

	global $cleanco_revealData, $cleanco_Scripts,$cleanco_Style;
	$cleanco_revealData=array();
	$cleanco_Scripts=array();
	$cleanco_Style=array();
	
	$locale = get_locale();

	if((is_child_theme() && !load_textdomain( 'cleanco', untrailingslashit(get_stylesheet_directory()) . "/{$locale}.mo")) || (!is_child_theme() && !load_theme_textdomain('cleanco',get_template_directory() )  ) ){
		load_theme_textdomain('cleanco',untrailingslashit(get_template_directory())."/languages");
	}
	if($locale!=''){
		load_textdomain('tgmpa', get_template_directory() . '/languages/tgmpa-'.$locale.".mo");
	}	

	// Add post thumbnail supports. http://codex.wordpress.org/Post_Thumbnails
	add_theme_support('post-thumbnails');
	add_theme_support( 'title-tag' );

	add_theme_support('menus');
	add_theme_support( 'post-formats', array( 'quote', 'video', 'audio', 'gallery', 'link' , 'image' , 'aside' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'woocommerce' );


	register_nav_menus(array(
		'primary' => __('Top Navigation', 'cleanco')
	));

	// sidebar widget

	register_sidebar(
		array('name'=> __('Sidebar Widget Area', 'cleanco'),
			'id'=>'detheme-sidebar',
			'description'=> __('Sidebar Widget Area', 'cleanco'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget_title">',
			'after_title' => '</h3>'
		));

	register_sidebar(
		array('name'=> __('Bottom Widget Area', 'cleanco'),
			'id'=>'detheme-bottom',
			'description'=> __('Bottom Widget Area', 'cleanco'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="row"><div class="col col-sm-12 centered"><h3 class="widget-title">',
			'after_title' => '</h3></div></div>'

		));

	register_sidebar(
		array('name'=> __('Sticky Widget Area', 'cleanco'),
			'id'=>'detheme-scrolling-sidebar',
			'description'=> __('Sticky Widget Area', 'cleanco'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="row"><div class="col col-sm-12 centered"><h3>',
			'after_title' => '</h3></div></div>'

		));

	if (detheme_plugin_is_active('woocommerce/woocommerce.php')) {

		register_sidebar(
			array('name'=> __('Shop Sidebar Widget Area', 'cleanco'),
				'id'=>'shop-sidebar',
				'description'=> __('Sidebar will display on woocommerce page only', 'cleanco'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget_title">',
				'after_title' => '</h3>'
			));

		// Display 12 products per page.
		add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );
	}


	add_action('wp_enqueue_scripts', 'cleanco_front_scripts', 999);
	add_action('wp_enqueue_scripts', 'cleanco_css_style',999);
	add_action('wp_footer', 'cleanco_load_preloader', 10000);
  	add_action('wp_head',create_function('','print "<script type=\"text/javascript\">var themeColor=\'".get_cleanco_option(\'primary-color\',\'\')."\';</script>\n";'));
  	add_action('wp_head','cleanco_seo_generator',1);
	add_action('wp_print_scripts', 'cleanco_print_inline_style' );
	add_action('wp_footer','cleanco_get_lightbox_1st');
	add_action('wp_footer','cleanco_get_exitpopup');
  	add_action('wp_footer',create_function('','global $cleanco_Scripts;if(count($cleanco_Scripts)) print "<script type=\"text/javascript\">\n".@implode("\n",$cleanco_Scripts)."\n</script>\n";'),99998);
  	add_action('wp_footer','cleanco_get_custom_code',9999999);
	add_action('admin_head','load_cleanco_admin_stylesheet');
	add_filter( 'woocommerce_cross_sells_total', 'woocommerce_output_cross_sells' );

} 

add_action('after_setup_theme','cleanco_startup');

if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function cleanco_slug_render_title() {
echo '<title>'.wp_title( '|', false, 'left' )."</title>\n";
	}

	add_action( 'wp_head', 'cleanco_slug_render_title',1);

	function cleanco_page_title($title, $sep, $seplocation){

	  $blogname=get_bloginfo('name','raw'); 

	  if($sep!=''){

	      if($seplocation=='left'){
	        $title=$blogname." ".$title;
	      }
	      else{

	        $title=$title." ".$blogname;
	      }


	  }

	  return $title;
	}

	add_filter('wp_title','cleanco_page_title',1,3);

endif;

function cleanco_css_style(){

	if(is_admin())
		return;
	wp_enqueue_style( 'styleable-select-style', get_template_directory_uri() . '/css/select-theme-default.css', array(), '0.4.0', 'all' );
	
	wp_enqueue_style( 'detheme-style-ie', get_template_directory_uri() . '/css/ie9.css', array());
	wp_style_add_data( 'detheme-style-ie', 'conditional', 'IE 9' );

	add_filter( "get_post_metadata",'cleanco_check_vc_custom_row',1,3);

	add_action('wp_footer',create_function('','global $cleanco_revealData,$cleanco_Style; 
		if(count($cleanco_revealData)) { print @implode("\n",$cleanco_revealData);'
		.'print "<div class=\"md-overlay\"></div>\n";'
		.'print "<script type=\'text/javascript\' src=\''.get_template_directory_uri().'/js/classie.js\'></script>";'
		.'print "<script type=\'text/javascript\' src=\''.get_template_directory_uri().'/js/modal_effects.js\'></script>";}'
		.'if(count($cleanco_Style)){print "<style type=\"text/css\">".@implode("\n",$cleanco_Style)."</style>";}'
		.' print "<div class=\"jquery-media-detect\"></div>";'),99999);

}

function cleanco_check_vc_custom_row($post=null,$object_id, $meta_key=''){

  if('_wpb_shortcodes_custom_css'==$meta_key){

    $meta_cache = wp_cache_get($object_id, 'post_meta');
    return '';
   }
}

function cleanco_seo_generator(){

	if(is_admin())
		return;

	if(get_cleanco_option('cleancoseo',false))
		return;

	$keyword=esc_attr(get_cleanco_option('meta-keyword',''));
	$description=esc_attr(get_cleanco_option('meta-description',''));
	$author=esc_attr(get_cleanco_option('meta-author',''));

	if(''!=$keyword){
	print "<meta name=\"keywords\" content=\"".esc_js($keyword)."\">\n";
	}
	if(''!=$description){
	print "<meta name=\"description\" content=\"".esc_js($description)."\">\n";
	}
	if(''!=$author){
	print "<meta name=\"author\" content=\"".esc_js($author)."\">\n";
	}
}

function cleanco_get_custom_code(){
	if(is_admin())
		return;

	$footercode=get_cleanco_option('footer-code','');

	if(''!=$footercode){
		print $footercode;
	}

}

function cleanco_print_inline_style(){

	if(is_admin() || in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')))
		return;

	$css_banner=array();

	if(($banner_url=get_cleanco_option('banner'))){
		$css_banner[]= 'background: url('.detheme_maybe_ssl_url($banner_url).') no-repeat 50% 50%; max-height: 100%; background-size: cover;'; 
	}
	
	if(($bannercolor=get_cleanco_option('bannercolor'))){
		$css_banner[]='background-color: '.$bannercolor.';'; 
	}

	if(($bannerheaight=get_cleanco_option('dt-banner-height'))){
		$bannerheaight=(strpos($bannerheaight, "px") || strpos($bannerheaight, "%")) ? $bannerheaight:$bannerheaight."px";
		$css_banner[]='min-height:'.$bannerheaight.";";
	}

	$css_highlight_bg = '';
	if(($slider_bg_immage=get_cleanco_option('dt-slider-bg-image'))  && isset($slider_bg_immage['url'])){
		$css_highlight_bg .= '@media (max-width: 767px) { .section-banner .slide-carousel { background: url("'.esc_url($slider_bg_immage['url']).'") !important; }} ';
		$css_highlight_bg .= '.section-banner .fullbg-img { background: url("'.esc_url($slider_bg_immage['url']).'")  no-repeat scroll 50% 50% / cover  rgba(0, 0, 0, 0) !important; } ';
	}

	if(($slider_blur_bg_immage=get_cleanco_option('dt-slider-blur-bg-image'))  && isset($slider_bg_immage['url'])){
		$css_highlight_bg .= '@media (min-width: 768px) { .section-banner:before { background: url("'.esc_url($slider_blur_bg_immage['url']).'") no-repeat scroll 50% 50% / cover  rgba(0, 0, 0, 0) !important; }} ';
	}


	print "<style type=\"text/css\">\n";

	print "@import url('". get_template_directory_uri() . "/style.css');\n";
	print "@import url('". get_template_directory_uri() . "/css/bootstrap.css');\n";	


	if ( (($primaryfont=get_cleanco_option('primary-font')) && ($primaryfontfamily=$primaryfont['font-family']))) {

		if (isset($primaryfont['google']) && $primaryfont['google']=='true') {
			$fontfamily = str_replace(" ", "+",$primaryfontfamily);
			$subsets = '';

			if (!empty($primaryfont['subsets'])) {
				$subsets = '&subset='.$primaryfont['subsets'];
			}
			
			$fonturl = '//fonts.googleapis.com/css?family='.$fontfamily.':100,100italic,300,300italic,400,400italic,600,600italic,700,700italic'.$subsets;

			print "@import url('". esc_url($fonturl) ."');\n";
		}	
	} else {
		print "@import url(//fonts.googleapis.com/css?family=Istok+Web:100,100italic,300,300italic,400,400italic,600,600italic,700,700italic);\n";
	}

	if ( (($secondaryfont=get_cleanco_option('secondary-font')) && ($secondaryfontfamily=$secondaryfont['font-family']))) {
		if (isset($secondaryfont['google']) && $secondaryfont['google']=='true') {
			$fontfamily = str_replace(" ", "+",$secondaryfontfamily);
			$subsets = '';

			$fonturl = '//fonts.googleapis.com/css?family='.$fontfamily;

			if (!empty($secondaryfont['font-weight'])) {
				$fonturl.=":".$secondaryfont['font-weight'].','.$secondaryfont['font-weight'].'italic';

			}
			

			if (!empty($secondaryfont['subsets'])) {
				$fonturl.='&subset='.$secondaryfont['subsets'];
			}

			print "@import url('". esc_url($fonturl) . "');\n";
		}	
	} else {
		print "@import url(//fonts.googleapis.com/css?family=Raleway:,600);\n";
	}

	if ( (($sectionfont=get_cleanco_option('section-font')) && ($sectionfontfamily=$sectionfont['font-family']))) {
		if (isset($sectionfont['google']) && $sectionfont['google']=='true') {
			$fontfamily = str_replace(" ", "+",$sectionfontfamily);
			$fonturl = '//fonts.googleapis.com/css?family='.$fontfamily;

			if (!empty($sectionfont['font-weight'])) {
				$fonturl.=":".$sectionfont['font-weight'].','.$sectionfont['font-weight'].'italic';

			}
			

			if (!empty($sectionfont['subsets'])) {
				$fonturl.='&subset='.$sectionfont['subsets'];
			}
			print "@import url('". esc_url($fonturl) ."');\n";

		}	
	}

	if ( (($tertiaryfont=get_cleanco_option('tertiary-font')) && ($tertiaryfontfamily=$tertiaryfont['font-family']))) {

		if (isset($tertiaryfont['google']) && $tertiaryfont['google']=='true') {
			$fontfamily = str_replace(" ", "+",$tertiaryfontfamily);
			$fonturl = '//fonts.googleapis.com/css?family='.$fontfamily;

			if (!empty($tertiaryfont['font-weight'])) {
				$fonturl.=":".$tertiaryfont['font-weight'].','.$tertiaryfont['font-weight'].'italic';

			}
			

			if (!empty($tertiaryfont['subsets'])) {
				$fonturl.='&subset='.$tertiaryfont['subsets'];
			}

			print "@import url('". esc_url($fonturl) ."');\n";
		}	
	} else {
			print "@import url(//fonts.googleapis.com/css?family=Lora:300,700);\n";
	}

	print "@import url(". get_template_directory_uri() . '/css/owl.carousel.css);'."\n";

	if(!defined('IFRAME_REQUEST')){
		print "@import url(". get_template_directory_uri() . '/css/detheme.css);'."\n";

		if(is_rtl()){
			print "@import url(". get_template_directory_uri() . '/css/detheme-rtl.css);'."\n";
		}
	}

	if(is_child_theme()){
		print "@import url(". get_stylesheet_directory_uri() . '/css/mystyle.css);'."\n";
	}

	$blog_id="";

	if ( is_multisite()){
		$blog_id="-site".get_current_blog_id();
	}

	print "@import url(". get_template_directory_uri() . '/css/customstyle'.$blog_id.'.css);'."\n";


	if(get_cleanco_option('sandbox-mode')){
  		$customstyle=detheme_style_compile(get_cleanco_options(),"",false);

  		print $customstyle."\n";
  	}

	if(count($css_banner)){
		print (count($css_banner))?"section#banner-section {".@implode("\n",$css_banner)."}\n".(!empty($bannerheaight)?"section#banner-section .container{height:".$bannerheaight."}\n":""):"";

		print ($titleColor=get_cleanco_option('title-color')) ?"section#banner-section .page-title,section#banner-section .breadcrumbs,section#banner-section .breadcrumbs a{color:".$titleColor.";}\n":"";

		if (($logo_top_margin=get_cleanco_option('logo-top'))) {

			print "div#head-page #dt-menu.dt-menu-center ul li.logo-desktop a {margin-top:".$logo_top_margin."px;}\n"; 
			print "div#head-page #dt-menu.dt-menu-left ul li.logo-desktop a {margin-top:".$logo_top_margin."px;}\n"; 
			print "div#head-page #dt-menu.dt-menu-leftbar ul li.logo-desktop a {margin-top:".$logo_top_margin."px;}\n"; 
			print "div#head-page #dt-menu.dt-menu-right ul li.logo-desktop a {margin-top:".$logo_top_margin."px;}\n"; 
			print "div#head-page #dt-menu.dt-menu-middle ul li.logo-desktop {top:".$logo_top_margin."px;}\n"; 
		}

		print ($logo_left_margin=get_cleanco_option('logo-left'))?"div#head-page #dt-menu ul li.logo-desktop a {margin-left:".$logo_left_margin."px;}\n":"";
		print ($body_background=get_cleanco_option('body_background')) ? $body_background:"";
	}
	print $css_highlight_bg;

	if(($titleTopMargin=get_cleanco_option('dt-page-title-position'))){
		$titleTopMargin=(strpos($titleTopMargin, "px") || strpos($titleTopMargin, "%")) ? $titleTopMargin:$titleTopMargin."px";
		print "#banner-section .row{top:".$titleTopMargin.";}";



	}
	print "</style>\n";

	if(!function_exists('wp_site_icon') && ($favicon=get_cleanco_option('dt-favicon-image')) && ''!==$favicon['url']){

		$favicon_url=$favicon['url'];
		print "<link rel=\"shortcut icon\" type=\"image/png\" href=\"".esc_url(detheme_maybe_ssl_url($favicon_url))."\">\n";
	}

}

function cleanco_front_scripts(){
    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

  	if( ($js_code=get_cleanco_option('js-code'))){
  		add_action('wp_footer',create_function('','if(($js_code=get_cleanco_option(\'js-code\'))) print "<script type=\"text/javascript\">".$js_code."</script>\n";'),99998);
	}

    wp_enqueue_script( 'waypoints' , get_template_directory_uri() . '/js/waypoints'.$suffix.'.js', array( ), '', false );
    wp_enqueue_script( 'modernizr' , get_template_directory_uri() . '/js/modernizr.js', array( ), '2.6.2', false );
    wp_enqueue_script( 'bootstrap' , get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '3.0', false );
    wp_enqueue_script( 'dt-script' , get_template_directory_uri() . '/js/myscript'.$suffix.'.js', array( 'jquery','bootstrap'), '1.0', false );
    wp_enqueue_script( 'styleable-select', get_template_directory_uri() . '/js/select'.$suffix.'.js', array(), '0.4.0', true );
    wp_enqueue_script( 'styleable-select-exec' , get_template_directory_uri() . '/js/select.init.js', array('styleable-select'), '1.0.0', true );
    wp_enqueue_script( 'jquery.appear' , get_template_directory_uri() . '/js/jquery.appear'.$suffix.'.js', array(), '', true );
    wp_enqueue_script( 'jquery.counto' , get_template_directory_uri() . '/js/jquery.counto'.$suffix.'.js', array(), '', true );

	if ( is_singular() ) { 
		 wp_enqueue_script( 'cleanco-comment-reply' , get_template_directory_uri() . '/js/comment-reply.min.js', array( 'jquery' ), '3.0', false );
	} 

}

function cleanco_load_preloader(){


	if(!get_cleanco_option('page_loader') || defined('IFRAME_REQUEST') || is_404() || (defined('DOING_AJAX') && DOING_AJAX))
		return '';

?>
<script type="text/javascript">
jQuery(document).ready(function ($) {
	'use strict';
    $("body").queryLoader2({
        barColor: "#fff",
        backgroundColor: "#bebebe",
        percentage: true,
        barHeight: 1,
        completeAnimation: "grow",
        minimumTime: 500,
        onLoadComplete: function() {$('.modal_preloader').remove();}
        });
});
</script>

	<?php 
}

function cleanco_get_exitpopup(){

	if(is_admin())
		return;

	if( ($exitpopup=get_cleanco_option('exitpopup'))){

         print '<div class="exitpopup" id="exitpopup">'.do_shortcode(esc_attr($exitpopup)).'</div>'."\n";
         print '<div class="exitpopup_bg" id="exitpopup_bg"></div>';

	}
}

function load_cleanco_admin_stylesheet(){
	wp_enqueue_style( 'detheme-admin',get_template_directory_uri() . '/lib/css/admin.css', array(), '', 'all' );
}

require_once( get_template_directory().'/lib/webicon.php'); // load detheme icon
require_once( get_template_directory().'/lib/options.php'); // load bootstrap stylesheet and scripts
require_once( get_template_directory().'/lib/metaboxes.php'); // load custom metaboxes
require_once( get_template_directory().'/lib/custom_functions.php'); // load specific functions
require_once( get_template_directory().'/lib/classes/class_dt_iconmenu_walker.php'); // load specific functions
require_once( get_template_directory().'/lib/classes/class_dt_mainmenu_walker.php'); // load specific functions
require_once( get_template_directory().'/lib/classes/class_dt_topbarmenuright_walker.php'); // load specific functions
require_once( get_template_directory().'/lib/classes/class_dt_topbarmenuleft_walker.php'); // load specific functions
require_once( get_template_directory().'/lib/classes/class_dt_menu_leftvc_walker.php'); // load specific functions
require_once( get_template_directory().'/lib/widgets.php'); // load custom widgets
require_once( get_template_directory().'/lib/shortcodes.php'); // load custom shortcodes
require_once( get_template_directory().'/lib/updater.php'); // load easy update
require_once( get_template_directory().'/lib/fonts.php'); // load detheme font family

if(function_exists('vc_set_as_theme')){
	vc_set_as_theme(true);
}

// Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {
	$args = array(
		'posts_per_page' => 4,
		'columns' => 1,
		'orderby' => 'rand'
	);

	woocommerce_related_products($args); // Display 4 products in rows of 1
}

// Redefine woocommerce_output_related_products()
function woocommerce_output_cross_sells($posts_per_page) {
	return 2;
}

function cleanco_load_icon_font_css_style(){
	wp_enqueue_style('fontello-font');
	wp_enqueue_style( 'icon-font', get_template_directory_uri() . '/iconfonts/iconfont.css');
}

add_action('cleanco_load_admin_css_style','cleanco_load_icon_font_css_style');
?>