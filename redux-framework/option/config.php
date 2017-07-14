<?php
function detheme_post_use_sidebar_layout(){

  return apply_filters('post_type_sidebar_layout_filter',array('revision','nav_menu_item','post','page','product_variation','shop_order','shop_webhook','shop_coupon','shop_order_refund','attachment'));
}

function detheme_post_use_title(){

  return apply_filters('post_type_title_filter',array('revision','nav_menu_item','post','product','product_variation','shop_order','shop_webhook','shop_coupon','shop_order_refund','attachment'));
}


if (!function_exists('redux_init')) :
	function redux_init() {


	global $wp_filesystem;

	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
		WP_Filesystem();
	}  		

	/* internationalise */

    $domain = 'redux-framework';
    $locale = get_locale();
    load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
    load_textdomain( $domain, dirname(dirname( __FILE__ )) . '/ReduxCore/languages/' . $domain . '-' . $locale . '.mo' );


	/**
		ReduxFramework Sample Config File
		For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
	**/


	/**
	 
		Most of your editing will be done in this section.

		Here you can override default values, uncomment args and change their values.
		No $args are required, but they can be overridden if needed.
		
	**/
	$args = array();


	// For use with a tab example below
	$tabs = array();

	ob_start();

	$ct = wp_get_theme();
	$theme_data = $ct;
	$item_name = $theme_data->get('Name'); 
	$tags = $ct->Tags;
	$screenshot = $ct->get_screenshot();
	$class = $screenshot ? 'has-screenshot' : '';

	$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','redux-framework' ), $ct->display('Name') );



	?>
	<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
		<h4>
			<?php echo $ct->display('Name'); ?>
		</h4>

		<div>
			<ul class="theme-info">
				<li><?php printf( __('By %s','redux-framework'), $ct->display('Author') ); ?></li>
				<li><?php printf( __('Version %s','redux-framework'), $ct->display('Version') ); ?></li>
			</ul>
			<p class="theme-description"><?php echo __($ct->display('Description'),'redux-framework'); ?></p>
			<?php if ( $ct->parent() ) {
				printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
					__( 'http://codex.wordpress.org/Child_Themes','redux-framework' ),
					$ct->parent()->display( 'Name' ) );
			} ?>
			
		</div>

	</div>

	<?php
	$item_info = ob_get_contents();
	    
	ob_end_clean();

	$sampleHTML = '';
	if( file_exists( dirname(__FILE__).'/info-html.html' )) {
		/** @global WP_Filesystem_Direct $wp_filesystem  */

		global $wp_filesystem;
		if (!empty($wp_filesystem)) {
			$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
		}  		
	}



	$icon_info='';

	$args['dev_mode'] = false;

	$args['opt_name'] = 'cleanco_config';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');

	// If you want to use Google Webfonts, you MUST define the api key.
	$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

	$args['share_icons']['twitter'] = array(
	    'link' => 'http://twitter.com/detheme',
	    'title' => 'Follow me on Twitter', 
	    'img' => DethemeReduxFramework::$_url . 'assets/img/social/Twitter.png'
	);
	$args['share_icons']['facebook'] = array(
	    'link' => 'https://www.facebook.com/detheme',
	    'title' => 'Find me on Facebook', 
	    'img' => DethemeReduxFramework::$_url . 'assets/img/social/Facebook.png'
	);

	$args['show_import_export'] = true;

	$args['menu_title'] = __('Theme Options', 'redux-framework');

	$args['page_title'] = __('Options', 'redux-framework');

	$args['page_slug'] = 'redux_options';

	$args['default_show'] = false;
	$args['default_mark'] = '';


	$args['intro_text'] = $args['menu_title'];

	$sections = array();              

	$dt_theme_images  = substr_replace(DethemeReduxFramework::$_url,'images',strpos(DethemeReduxFramework::$_url,'redux-framework'));

	$sections[] = array(
		'title' => __('Top Bar Settings', 'redux-framework'),
		'icon' => 'el-icon-tasks',
		'fields' => array(	
			array(
				'id'=>'showtopbar',
				'type' => 'switch', 
				'title' => __('Show Top Bar', 'redux-framework'),
				'subtitle'=> __('Allow show/hide top bar', 'redux-framework'),
				'default' => 0,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
            array(
                'id'=>'topbar-background-color',
                'type'=>'color_rgba',
                'title' => esc_html__('Top Bar Background Color', 'redux-framework'),
                'subtitle'=>esc_html__('Select Top Bar Background Color','redux-framework'),
                'default'=>array('color'=>'#ffffff','alpha'=>1),
                'mode' => 'background'
                ),
			array(
				'id'=>'topbar-font-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Font Color', 'redux-framework'), 
				'subtitle' => __('Select font color for the top bar', 'redux-framework'),
				'default' => '#222222',
				),	
			array(
				'id'=>'topbar-height',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Top Bar Height', 'redux-framework'),
				'subtitle' => sprintf(__('is used to adjust Top Bar Height in pixel (Default: %dpx)', 'redux-framework'),0),
				'default'=> 0,
				),
			array(
				'id'=>'devider-1',
				'type' => 'divider', 
				'title' => __('Left Section', 'redux-framework'),
				'subtitle'=> __('Select element to be displayed on left top bar', 'redux-framework')
				),	
			array(
				'id'=>'dt-left-top-bar',
				'type' => 'select',
				'title' => __('Type of Element', 'redux-framework'), 
				'options'=>array(
					'text'=>__('Custom Text','redux-framework'),
					'menu'=>__('Menu','redux-framework'),
					'icon'=>__('Icon from Menu','redux-framework')
					)
				),

			array(
				'id'=>'dt-left-top-bar-menu',
				'type' => 'menu',
				'title' => __('Select Menu Source', 'redux-framework'), 
				),
			array(
				'id'=>'dt-left-top-bar-text',
				'type' => 'text',
				'title' => __('Custom Text', 'redux-framework'),
				'default' => __('Left topbar custom text','redux-framework')
				),				
			array(
				'id'=>'devider-2',
				'type' => 'divider', 
				'title' => __('Right Section', 'redux-framework'),
				'subtitle'=> __('Select element to be displayed on right top bar', 'redux-framework')
				),	
			array(
				'id'=>'dt-right-top-bar',
				'type' => 'select',
				'title' => __('Type of Element', 'redux-framework'), 
				'options'=>array(
					'text'=>__('Custom Text','redux-framework'),
					'menu'=>__('Menu','redux-framework'),
					'icon'=>__('Icon from Menu','redux-framework')
					)
				),

			array(
				'id'=>'dt-right-top-bar-menu',
				'type' => 'menu',
				'title' => __('Select Menu Source', 'redux-framework'), 
				),
			array(
				'id'=>'dt-right-top-bar-text',
				'type' => 'text',
				'title' => __('Custom Text', 'redux-framework'),
				'default' => __('Right topbar custom text','redux-framework')
				),					)
	);

	$sections[] = array(
		'title' => __('Main Navigation Settings', 'redux-framework'),
		'icon' => 'el-icon-lines',
		'fields' => array(
			array(
				'id'=>'dt-show-header',
				'type' => 'switch', 
				'title' => __('Navigation Bar', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),
			array(
				'id'=>'dt-main-menu',
				'type' => 'menu',
				'title' => __('Select Menu Source', 'redux-framework'),
				'placeholder'=>__('Select Main Menu','redux-framework') 
				),
			array(
				'id'=>'dt-header-type',
				'type' => 'image_select', 
				'title' => __('Layout Type', 'redux-framework'),
				'options' => array(
						'left' => array('title' => __('Logo on Left', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-1.png'),
						'center' => array('title' => __('Logo on Center', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-2.png'),
						'right' => array('title' => __('Logo on Right', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-3.png'),
						'middle' => array('title' => __('Logo in the middle of menu', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-5.jpg'),
						'leftvc' => array('title' => __('Logo on Left Navigation Icons', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-6.png')
						//'leftbar' => array('title' => __('Vertical Menu on Left', 'redux-framework'), 'img' => DethemeReduxFramework::$_url.'assets/img/header-layout-4.png')
					),
				"default"=> 'left'
				),
			array(
				'id'=>'menu_icon_fields',
				'type' => 'icon_multi_text',
				'title' => __('Navigation Icons', 'redux-framework'),
				'subtitle'=>__('Manage the navigation icon as menu','redux-framework'),
				'sortable' => true,
				'fields'=> array(
					'label' => __('Label', 'redux-framework'),
					'text' => __('Text', 'redux-framework'),
					)
				),
            array(
                'id'=>'leftvc-buttons-color',
                'type'=>'color_nocheck',
                'title' => esc_html__('Navigation Icons Color', 'redux-framework'),
                'subtitle'=>esc_html__('Select Navigation Icons Color','redux-framework'),
                'default'=>'#95a5a6',
                'validate' => 'color'
                ),
            array(
                'id'=>'leftvc-buttons-text-color',
                'type'=>'color_nocheck',
                'title' => esc_html__('Navigation Icons Text Color', 'redux-framework'),
                'subtitle'=>esc_html__('Select Navigation Icons Text Color','redux-framework'),
                'default'=>'#95a5a6',
                'validate' => 'color'
                ),
            array(
                'id'=>'leftvc-buttons-background-color',
                'type'=>'color_rgba',
                'title' => esc_html__('Navigation Icons Background Color', 'redux-framework'),
                'subtitle'=>esc_html__('Select Navigation Icons Background Color','redux-framework'),
                'default'=>array('color'=>'#005152','alpha'=>1),
                'mode' => 'background'
                ),
            array(
                'id'=>'leftvc-buttons-separator-color',
                'type'=>'color_rgba',
                'title' => esc_html__('Navigation Icons Separator Color', 'redux-framework'),
                'subtitle'=>esc_html__('Select Navigation Icons Separator Color','redux-framework'),
                'default'=>array('color'=>'#005152','alpha'=>1),
                'mode' => 'background'
                ),
            array(
                'id'=>'leftvc-logo-background-color',
                'type'=>'color_rgba',
                'title' => esc_html__('Logo Background Color', 'redux-framework'),
                'subtitle'=>esc_html__('Select Logo Background Color','redux-framework'),
                'default'=>array('color'=>'#1a6263','alpha'=>1),
                'mode' => 'background'
                ),
            array(
                'id'=>'leftvc-navigation-background-color',
                'type'=>'color_rgba',
                'title' => esc_html__('Navigation Background Color', 'redux-framework'),
                'subtitle'=>esc_html__('Select Navigation Background Color','redux-framework'),
                'default'=>array('color'=>'#005152','alpha'=>1),
                'mode' => 'background'
                ),
			array(
				'id'=>'dt-menu-image-size',
				'type' => 'radio',
				'title' => __('Background Size', 'redux-framework'), 
				'options'=>array('cover'=>__('Cover', 'redux-framework'),
					'contain'=>__('Contain', 'redux-framework'),
					'default'=>__('Default', 'redux-framework'),
					),
				'default'=>'default'
				),
			array(
				'id'=>'dt-menu-image',
				'compiler' => true,
				'type' => 'media', 
				'title' => __('Background Image', 'redux-framework'),
				"default"=> ''
				),
			array(
				'id'=>'dt-menu-image-horizontal',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Horizontal Position(%)', 'redux-framework'),
				'default'=> '50',
				),
			array(
				'id'=>'dt-menu-image-vertical',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Vertical Position(%)', 'redux-framework'),
				'default'=> '100',
				),
			array(
				'id'=>'dt-logo-top-padding',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Menu Top Margin (Logo on center/Logo in the middle of menu)', 'redux-framework'),
				'subtitle' => sprintf(__('Using to adjust menu top margin in pixel when layout type is "Logo on center" or "Logo in the middle of menu" (Default: %dpx)', 'redux-framework'),0),
				'default'=> 0,
				),
			array(
				'id'=>'dt-logo-top-margin-reveal',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Top Margin (Reveal)', 'redux-framework'),
				'subtitle' => sprintf(__('is used to adjust logo top margin in pixel when layout type is center when menu is revealed (Default: %dpx)', 'redux-framework'),0),
				'default'=> 0,
				),
			array(
				'id'=>'show-header-searchmenu',
				'type' => 'switch', 
				'title' => __('Search Bar', 'redux-framework'),
				'subtitle' => sprintf(__('is used to show/hide Search Bar on Main Menu (Default: %s)', 'redux-framework'),__('Show', 'redux-framework')),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'show-header-shoppingcart',
				'type' => 'switch', 
				'title' => __('Show Shopping Cart on Menu ?', 'redux-framework'),
				'subtitle' => sprintf(__('is used to show/hide Shopping Cart on Main Menu (Default: %s)', 'redux-framework'),__('Show', 'redux-framework')),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'dt-menu-height',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Menu Height', 'redux-framework'),
				'subtitle' => sprintf(__('Using to adjust menu height in em (Default: %dem)', 'redux-framework'),5),
				'default'=> 5,
				),
			array(
				'id'=>'dt-logo-width',
				'type' => 'text', 
				'title' => __('Logo Width', 'redux-framework'),
				'subtitle' => __('Maximum logo width in pixel', 'redux-framework'),
				'class'=>'width_100',
				'desc'=>__('leave blank to display original size', 'redux-framework'),
				'default'=>'',
				),
			array(
				'id'=>'dt-logo-text',
				'type' => 'text', 
				'title' => __('Text Logo', 'redux-framework'),
				'subtitle' => __('Will be displayed as image alt', 'redux-framework'),
				'default'=>'Cleanco',
				),
			array(
				'id'=>'dt-logo-margin',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Top Margin', 'redux-framework'),
				'subtitle' => __('Using to adjust logo position from top in pixel', 'redux-framework'),
				'default'=>'0',
				),
			array(
				'id'=>'dt-logo-margin-mobile',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Top Margin for Mobile', 'redux-framework'),
				'subtitle' => __('Using to adjust logo position from top for mobile in pixel', 'redux-framework'),
				'default'=>'0',
				),
			array(
				'id'=>'dt-logo-leftmargin',
				'type' => 'text', 
				'class'=>'width_100',
				'title' => __('Logo Left Margin', 'redux-framework'),
				'subtitle' => __('Using to adjust logo position from left in pixel', 'redux-framework'),
				'default'=>'0',
				),
			array(
				'id'=>'dt-sticky-menu',
				'type' => 'switch', 
				'title' => __('Sticky Menu', 'redux-framework'),
				'subtitle'=> sprintf(__('If "%s", menu will sticky on top when the browser is scrolled down. Default is "%s"', 'redux-framework'),__('On', 'redux-framework'),__('On', 'redux-framework')),
				"default" => 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'devider-3',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Homepage', 'redux-framework').'</h2>',
				),	
			array(
				'id'=>'homepage-background-type',
				'type' => 'select',
				'title' => __('Background Type', 'redux-framework'), 
				'options'=>array(
					'solid'=>__('Solid','redux-framework'),
					'transparent'=>__('Transparent','redux-framework')
					),
				'default'=>'solid'
				),
			array(
				'id'=>'homepage-header-color',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-header-font-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#95a5a6',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-dt-logo-image',
				'type' => 'media', 
				'title' => __('Desktop Logo', 'redux-framework'),
				'compiler' => true,
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),

			array(
				'id'=>'homepage-header-color-transparent',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-header-font-color-transparent',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#95a5a6',
				'validate' => 'color',
				),	
			array(
				'id'=>'homepage-dt-logo-image-transparent',
				'type' => 'media', 
				'title' => __('Desktop Logo (reveal)', 'redux-framework'),
				'compiler' => true,
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('N-U-L-L.2-4.N.E.T Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),


			array(
				'id'=>'devider-4',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Subpage','redux-framework').'</h2>',
				),	
			array(
				'id'=>'header-background-type',
				'type' => 'select',
				'title' => __('Background Type', 'redux-framework'), 
				'options'=>array(
					'solid'=>__('Solid','redux-framework'),
					'transparent'=>__('Transparent','redux-framework')
					),
				'default'=>'solid'
				),
			array(
				'id'=>'header-color',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'header-font-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#95a5a6',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-logo-image',
				'type' => 'media', 
				'title' => __('Desktop Logo', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),

			array(
				'id'=>'header-color-transparent',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Background Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the header section.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'header-font-color-transparent',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Menu Font Color (reveal)', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#95a5a6',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-logo-image-transparent',
				'type' => 'media', 
				'title' => __('Desktop Logo (reveal)', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/logo.png'),
				),

			array(
				'id'=>'devider-menu-separator',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Navigation Separator','redux-framework').'</h2>',
				),	
			array(
				'id'=>'layout-menu-separator',
				'type' => 'image_select',
				'compiler'=>true,
				'title' => __('Choose Navigation Separator', 'redux-framework'), 
				'options' => array(
						'menu_separator_type_0' => array('alt' => 'No Separator', 'img' => DethemeReduxFramework::$_url.'assets/img/separator_icons/00.jpg'),
						'menu_separator_type_1' => array('alt' => 'Layout Type 1', 'img' => DethemeReduxFramework::$_url.'assets/img/separator_icons/05.jpg'),
						'menu_separator_type_2' => array('alt' => 'Layout Type 2', 'img' => DethemeReduxFramework::$_url.'assets/img/separator_icons/02.jpg'),
					),
				'default' => 'menu_separator_type_1'
				),
			array(
				'id'=>'menu-separator-border-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Border Color', 'redux-framework'), 
				'subtitle' => __('Pick a font color.', 'redux-framework'),
				'default' => '#b5cbd9',
				'validate' => 'color',
				),	
			)
	);

	$sections['page-banner'] = array(
		'icon' => 'el-icon-picture',
		'title' => __('Banner Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'show-banner-area',
				'type' => 'switch', 
				'title' => __('Banner Section', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'show-banner-home',
				'type' => 'switch', 
				'title' => __('Show Banner on Homepage', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'dt-show-breadcrumb',
				'type' => 'switch', 
				'title' => __('Breadcrumb', 'redux-framework'),
				"default" => 0,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				)));

	$post_types = get_post_types( array());
      foreach ( $post_types as $post_type ) {

          if (!in_array($post_type, detheme_post_use_title())) {

	        $post_type_object=get_post_type_object($post_type);
	        $label = $post_type_object->labels->name;

	        if($post_type_object->public){

	          	array_push($sections['page-banner']['fields'],
				array(
					'id'=>'dt-show-title-'.$post_type,
					'type' => 'switch', 
					'title' => sprintf(esc_html__('%s Title', 'redux-framework'),ucfirst($label)),
					'subtitle'=> sprintf(esc_html__('Enable or Disable title on the %s', 'redux-framework'),$label),
					"default" => 1,
					'on' => esc_html__('Show', 'redux-framework'),
					'off' => esc_html__('Hide', 'redux-framework')
					));
	        }
          }
      }


	$sections['page-banner']['fields']=array_merge($sections['page-banner']['fields'],array(					
			array(
				'id'=>'dt-post-title-page',
				'type' => 'text',
				'title' => __('Post Tittle', 'redux-framework'),
				'default' => __('Blog', 'redux-framework'),
				),
			array(
				'id'=>'title-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Page Title & Breadcrumbs Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for banner section.', 'redux-framework'),
				'default' => '#000000',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-page-title-position',
				'type' => 'text',
				'title' => __('Page Title Position (From Top)', 'redux-framework'),
				'class'=>'width_100',
				'default' => '70%'
				),				
			array(
				'id'=>'dt-show-banner-page',
				'type' => 'select', 
				'title' => __('Background Banner', 'redux-framework'),
				"default" =>'none',
				'options' => array(
					'featured' => __('Page Banner Image','redux-framework'),
					'image' => __('Image','redux-framework'),
					'color' => __('Color','redux-framework'),
					'none' => __('None','redux-framework'),
					),
				),	
			array(
				'id'=>'dt-banner-image',
				'type' => 'media', 
				'title' => __('Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set default banner image.', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/header_subpage_bg.jpg'),
				),
			array(
				'id'=>'banner-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the theme.', 'redux-framework'),
				'default' => '',
				'validate' => 'color',
				),	
			array(
				'id'=>'dt-banner-height',
				'type' => 'text',
				'title' => __('Banner Height', 'redux-framework'),
				'class'=>'width_100',
				'default' => '300px'
				)				
			)
	);

	if ( detheme_plugin_is_active('detheme-portfolio/detheme_port.php') ){

			array_push($sections['page-banner']['fields'], 
					array(
					'id'=>'dt-port-title-page',
					'type' => 'text',
					'title' => __('Portfolio Page Tittle', 'redux-framework'),
					'default' => __('Portfolio', 'redux-framework'),
					)
				);

	}

	if (detheme_plugin_is_active('woocommerce/woocommerce.php')) {

		array_push($sections['page-banner']['fields'],
			array(
				'id'=>'dt-shop-title-page',
				'type' => 'text',
				'title' => __('Shop Page Tittle', 'redux-framework'),
				'default' => __('Shop', 'redux-framework'),
				)
		);				

		array_push($sections['page-banner']['fields'], 
				array(
					'id'=>'dt-shop-banner-image',
					'type' => 'media', 
					'title' => __('Shop Banner Image', 'redux-framework'),
					'compiler' => true,
					'default'=>array('url'=>$dt_theme_images.'/header_subpage_bg.jpg'),
					)
			);
	}


	$sections['general'] = array(
		'icon' => 'el-icon-cogs',
		'title' => __('General Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'devider-5',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Main Layout', 'redux-framework').'</h2>',
				),	
			array(
				'id'=>'layout',
				'type' => 'image_select',
				'compiler'=>true,
				'title' => __('Choose Layout', 'redux-framework'), 
				'subtitle' => __('Select main content and sidebar alignment.', 'redux-framework'),
				'options' => array(
						'1' => array('alt' => '1 Column', 'img' => DethemeReduxFramework::$_url.'assets/img/1col.png'),
						'2' => array('alt' => '2 Column Left', 'img' => DethemeReduxFramework::$_url.'assets/img/2cl.png'),
						'3' => array('alt' => '2 Column Right', 'img' => DethemeReduxFramework::$_url.'assets/img/2cr.png')
					),
				'default' => '2'
				)));

  	$post_types = get_post_types( array());
      foreach ( $post_types as $post_type ) {
          if (!in_array($post_type, detheme_post_use_sidebar_layout())) {
              

	        $post_type_object=get_post_type_object($post_type);

	        if($post_type_object->name=='product'){
	        	$post_type_object->labels->name=$post_type_object->labels->singular_name="Woocommerce Product";
	        }

	        $label = $post_type_object->labels->singular_name;

	        if($post_type_object->public){

	          	array_push($sections['general']['fields'],
				array(
					'id'=>'layout_'.$post_type,
					'type' => 'image_select',
					'compiler'=>true,
					'title' => sprintf(esc_html__('%s Layout', 'redux-framework'),ucfirst($post_type_object->labels->name)), 
					'subtitle' => sprintf(esc_html__('Select layout for the %s page', 'redux-framework'),strtolower($label)),
					'options' => array(
						'1' => array('alt' => '1 Column', 'img' => DethemeReduxFramework::$_url.'assets/img/1col.png'),
						'2' => array('alt' => '2 Column Left', 'img' => DethemeReduxFramework::$_url.'assets/img/2cl.png'),
						'3' => array('alt' => '2 Column Right', 'img' => DethemeReduxFramework::$_url.'assets/img/2cr.png')
						),
					'default' => '2'
					));
	         }
          }
      }

	$sections['general']['fields']=array_merge($sections['general']['fields'],array(
			array(
				'id'=>'devider-42',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Boxed Layout', 'redux-framework').'</h2>',
			),	
			array(
				'id'		=> 'boxed_layout_activate',
				'title' 	=> __('Enable Boxed Layout ?', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
			),
			array(
				'id'=>'boxed_layout_body_background_image',
				'type' => 'media', 
				'title' => __('Body Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your image (.png,.ico, .jpg) to set Body Background Image.', 'redux-framework'),
				'default'=>array('url'=>''),
				),
			array(
				'id'=>'boxed_layout_body_background_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Body Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Body Background Color.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	

			array(
				'id'=>'boxed_layout_boxed_background_image',
				'type' => 'media', 
				'title' => __('Boxed Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your image (.png,.ico, .jpg) to set Boxed Background Image.', 'redux-framework'),
				'default'=>array('url'=>''),
				),
			array(
				'id'=>'boxed_layout_boxed_background_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Boxed Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Boxed Background Color.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				)	
				)
			);

	if(!function_exists('wp_site_icon')){
		array_push(
			$sections['general']['fields'],
			array(
				'id'=>'devider-6',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Favicon', 'redux-framework')."</h2>",
				),	
			array(
				'id'=>'dt-favicon-image',
				'type' => 'media', 
				'title' => __('Favicon Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set favicon image. Upload your image (.png,.ico, .jpg) with size 16x16 pixel', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/favicon.png'),
				)
			);
	}


			$sections['general']['fields']=array_merge($sections['general']['fields'],array(
			array(
				'id'=>'devider-7',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Lightbox Popup', 'redux-framework')."</h2>",
				),	
			array(
				'id'		=> 'lightbox_1st_on',
				'title' 	=> __('Enable Lightbox 1st Visit ?', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
				),
			array(
				'id'		=> 'lightbox_1st_title',
				'type' 		=> 'text',
				'title' 	=> __('The Title of the Lightbox', 'redux-framework'), 
				'default' 	=> __('Connect with us on Facebook','redux-framework')
				),
			array(
				'id'		=> 'lightbox_1st_content',
				'type' 		=> 'textarea',
				'title' 	=> __('The Content of the Lightbox ( HTML Allowed )', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Content of Lightbox 1st Visit here. You can paste Facebook like box, optinform or anything.', 'redux-framework'),
				'default' 	=> '',
				'validate' 	=> 'html'
				),
			array(
				'id'		=> 'lightbox_1st_delay',
				'type' 		=> 'text',
				'compiler'	=> true,
				'title' 	=> __('Lightbox Delay', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Delay (only number) in Seconds. e.g. 10, 15, 20.', 'redux-framework'),
				'validate' 	=> 'numeric',
				'msg'		=> __('Please enter number.','redux-framework'),
				'default' 	=> 10
				),
			array(
				'id'		=> 'lightbox_1st_cookie',
				'type' 		=> 'text',
				'compiler'	=> true,
				'title' 	=> __('Cookie Expiry', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Cookie expiry (only number) in Hours. e.g. 2, 4, 24. For example you enter 24, it means the Lightbox will show again in next 24 hours.', 'redux-framework'),
				'validate' 	=> 'numeric',
				'msg'		=> __('Please enter number.','redux-framework'),
				'default' 	=> 1
				),
			array(
				'id'=>'devider-8',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Page Loader', 'redux-framework').'</h2>',
				),	
			array(
				'id'		=> 'page_loader',
				'title' 	=> __('Enable Page Loader', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
				),
			array(
				'id'=>'devider-9',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Sticky Sidebar', 'redux-framework').'</h2>',
				),	
			array(
				'id'		=> 'dt_scrollingsidebar_on',
				'title' 	=> __('Enable Sticky Sidebar ?', 'redux-framework'), 
				'desc'		=> sprintf(__('Switch to "%s" to enable.','redux-framework'),__('On', 'redux-framework')),
				'type'		=> 'switch',
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				'default' 	=> 0
				),
			array(
				'id'		=> 'dt_scrollingsidebar_position',
				'type' 		=> 'select', 
				'title' 	=> __('Sticky Sidebar Position', 'redux-framework'),
				'default' 	=> 'right',
				'options' 	=> array(
					'right' => __('Right','redux-framework'),
					'left' => __('Left','redux-framework'),
					),
				),	
			array(
				'id'		=> 'dt_scrollingsidebar_margin',
				'type' 		=> 'text',
				'compiler'	=> true,
				'title' 	=> __('Sticky Sidebar Margin', 'redux-framework'), 
				'subtitle' 	=> __('Enter the Sticky Sidebar Margin (only number) in pixel. For example: 20.', 'redux-framework'),
				'validate' 	=> 'numeric',
				'msg'		=> __('Please enter number.','redux-framework'),
				'default' 	=> 20
				),
			array(
				'id'=>'devider-10',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Exit Popup', 'redux-framework').'</h2>',
				),	
			array(
				'id'		=> 'exitpopup',
				'type' 		=> 'textarea',
				'title' 	=> __( 'Content ( HTML Allowed )', 'redux-framework' ), 
				'subtitle' 	=> __('Enter the Content of exit popup.', 'redux-framework'),
				'default' 	=> '',
				'validate' 	=> 'html'
				),
			array(
				'id'=>'devider-10',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Comments', 'redux-framework').'</h2>',
				),
			array(
				'id'=>'page-comment-open',
				'type' => 'switch', 
				'title' => __('Page Comment', 'redux-framework'),
				'subtitle'=> sprintf(__('If "%s", comment disable for all page as default', 'redux-framework'),__('Off', 'redux-framework')),
				"default" => 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'dt-comment-open',
				'type' => 'switch', 
				'title' => __('Post Comment', 'redux-framework'),
				'subtitle'=> sprintf(__('If "%s", comment disable for all post as default', 'redux-framework'),__('Off', 'redux-framework')),
				"default" => 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')

				),	
			array(
				'id'=>'port-comment-open',
				'type' => 'switch', 
				'title' => __('Portfolio Comment', 'redux-framework'),
				'subtitle'=> sprintf(__('If "%s", comment disable for all portfolio as default', 'redux-framework'),__('Off', 'redux-framework')),
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				"default" => 1,
				)));

if ( detheme_plugin_is_active('detheme-post/detheme_post.php') ) :

	array_push($sections['general']['fields'],
			array(
				'id'=>'dtpost-comment-open',
				'type' => 'switch', 
				'title' => __('DT Post Comment', 'redux-framework'),
				'subtitle'=> sprintf(__('If "%s", comment disable for all dt post as default', 'redux-framework'),__('Off', 'redux-framework')),
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework'),
				"default" => 1,
				)
			);
endif;		

	$sections['general']['fields']=array_merge($sections['general']['fields'],array(
			array(
				'id'=>'devider-11',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('404 Page', 'redux-framework').'</h2>',
				),	
			array(
				'id'=>'dt-404-text',
				'type' => 'textarea',
				'title' => __('404 Error Text', 'redux-framework'), 
				'default' => __('It\'s looking like you may have taken a wrong turn. Don\'t worry...it happens to the most of us.','redux-framework'),
				'validate' => 'html'
				),
			array(
				'id'=>'dt-404-image',
				'type' => 'media', 
				'title' => __('404 Error Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set 404 Error Image.', 'redux-framework'),
				),
			array(
				'id'=>'dt-404-background',
				'type' => 'media', 
				'title' => __('404 Error Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set 404 Error Background Image.', 'redux-framework'),
				),
			array(
				'id'=>'devider-12',
				'type' => 'divider', 
				'title' => '<h2 class="redux-title">'.__('Gallery', 'redux-framework').'</h2>',
				),	
			array(
				'id'=>'dt-select-modal-effects',
				'type' => 'select',
				'title' => __('Modal Effects Option', 'redux-framework'), 
				'options'=>array('md-effect-1'=>__('Effect 1: Fade in and scale up','redux-framework'),
					'md-effect-2'=>__('Effect 2: Slide from the right','redux-framework'),
					'md-effect-3'=>__('Effect 3: Slide from the bottom','redux-framework'),
					'md-effect-4'=>__('Effect 4: Newspaper','redux-framework'),
					'md-effect-5'=>__('Effect 5: Fall','redux-framework'),
					'md-effect-6'=>__('Effect 6: Side fall','redux-framework'),
					'md-effect-7'=>__('Effect 7: Slide and stick to top','redux-framework'),
					'md-effect-8'=>__('Effect 8: 3D flip horizontal','redux-framework'),
					'md-effect-9'=>__('Effect 9: 3D flip vertical','redux-framework'),
					'md-effect-10'=>__('Effect 10: 3D sign','redux-framework'),
					'md-effect-11'=>__('Effect 11: Super scaled','redux-framework'),
					'md-effect-12'=>__('Effect 12: Just me','redux-framework'),
					'md-effect-13'=>__('Effect 13: 3D slit','redux-framework'),
					'md-effect-14'=>__('Effect 14: 3D Rotate from bottom','redux-framework'),
					'md-effect-15'=>__('Effect 15: 3D Rotate in from left (Default)','redux-framework'),
					'md-effect-16'=>__('Effect 16: Blur','redux-framework'),
					'md-effect-17'=>__('Effect 17: Slide in from bottom with perspective on container','redux-framework'),
					'md-effect-18'=>__('Effect 18: Slide from right with perspective on container','redux-framework'),
					'md-effect-19'=>__('Effect 19: Slip in from the top with perspective on container','redux-framework')
					)
			),

		)
	);


	$sections[] = array(
		'title' => __('Footer Settings', 'redux-framework'),
		'icon' => 'el-icon-fork',
		'fields' => array(
			array(
				'id'=>'showfooterpage',
				'type' => 'switch', 
				'title' => __('Show Footer Page', 'redux-framework'),
				'subtitle'=> __('Allow show/hide footer page', 'redux-framework'),
				"default"=> 1,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
			array(
				'id'=>'footerpage',
				'type' => 'select',
				'title' => __('Select Footer Page', 'redux-framework'), 
				'data' => 'pages',
				'description'=>'<a class="btn button" href="'.admin_url( 'post-new.php?post_type=page', 'relative' ).'" target="_blank">'.__('Create New Page','redux-framework').'</a>',
			),
			array(
				'id'=>'showfooterarea',
				'type' => 'switch', 
				'title' => __('Show Footer Area', 'redux-framework'),
				'subtitle'=> __('Allow show/hide footer area', 'redux-framework'),
				"default"=> 1,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
			array(
				'id'=>'footer-text',
				'type' => 'editor',
				'title' => __('Footer Text', 'redux-framework'), 
				'subtitle' => __('You can use the following shortcodes in your footer text','redux-framework').': [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]',
				'default' => '© [current-year] '.sprintf(__('%s, The Awesome Theme. All right reserved.','redux-framework'),get_template()),
				'editor_options'=>array( 'media_buttons' => true, 'tinymce' => true,'wpautop' => false)
				),
			array(
				'id'=>'dt-footer-widget-column',
				'type' => 'radio',
				'title' => __('Number of Footer Widget Columns', 'redux-framework'), 
				'options'=>array(1=>__('One Column', 'redux-framework'),
					2=>__('Two Columns', 'redux-framework'),
					3=>__('Three Columns', 'redux-framework'),
					4=>__('Four Columns', 'redux-framework')
					),
				'default'=>3
				),
			array(
				'id'=>'footer-color',
				'type' => 'color_nocheck',
				'output' => array('.description'),
				'title' => __('Footer Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for footer section', 'redux-framework'),
				'default' => '#95a5a6',
				'validate' => 'color',
				),	
			array(
				'id'=>'footer-background-image',
				'type' => 'media', 
				'title' => __('Footer Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your image (.png,.ico, .jpg) to set Footer Background Image.', 'redux-framework'),
				'default'=>array('url'=>''),
				),
			array(
				'id'=>'footer-font-color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Footer Font Color', 'redux-framework'), 
				'subtitle' => __('Pick a font color for Footer Text', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			)
		);

	$sections[] = array(
		'icon' => 'el-icon-website',
		'title' => __('Styling Options', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'primary-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Primary Color', 'redux-framework'), 
				'subtitle' => sprintf(__('Pick a primary color for the theme (default: %s)', 'redux-framework'),'#f58e03'),
				'default' => '#f58e03',
				'validate' => 'color',
				),		

			array(
				'id'=>'secondary-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Secondary Color', 'redux-framework'), 
				'subtitle' => sprintf(__('Pick a secondary color for the theme (default: %s)', 'redux-framework'),'#f58e03'),
				'default' => '#f58e03',
				'validate' => 'color',
				),		
			array(
				'id'=>'body_background_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Body Background Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Body Background Color.', 'redux-framework'),
				'default' => '#ffffff',
				'validate' => 'color',
				),	
			array(
				'id'=>'body_text_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Body Text Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Body Text Color.', 'redux-framework'),
				'default' => '#95a5a6',
				'validate' => 'color',
				),	
			array(
				'id'=>'primary-font',
				'type' => 'typography',
				'title' => __('Body Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the body text font properties. Default : "%s"', 'redux-framework'),'Open Sans'),
				'font-style'=>false,
				'font-weight'=>false,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'letter-spacing'=>true,
				'default' => array(
					'font-family'=>'Open Sans',
					'google'=>true
					),
				),
			array(
				'id'=>'heading_text_color',
				'type' => 'color_nocheck',
				'output' => '',
				'title' => __('Heading Text Color', 'redux-framework'), 
				'subtitle' => __('Pick a color for Heading Text Color.', 'redux-framework'),
				'default' => '#304152',
				'validate' => 'color',
				),	
			array(
				'id'=>'secondary-font',
				'type' => 'typography',
				'title' => __('Heading Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the heading text font properties. Default : "%s"', 'redux-framework'),'Raleway'),
				'font-style'=>false,
				'font-weight'=>true,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'letter-spacing'=>true,
				'default' => array(
					'font-family'=>'Raleway',
					'google'=>true,
					),
				),
			array(
				'id'=>'section-font',
				'type' => 'typography',
				'title' => __('Section Heading Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the heading text font properties. Default : "%s"', 'redux-framework'),'Raleway'),
				'font-style'=>false,
				'font-weight'=>true,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'letter-spacing'=>true,
				'default' => array(
					'font-family'=>'Raleway',
					'google'=>true
					),
				),
			array(
				'id'=>'tertiary-font',
				'type' => 'typography',
				'title' => __('Quote Text Font', 'redux-framework'),
				'subtitle' => sprintf(__('Specify the quote text font properties. Default : "%s"', 'redux-framework'),'Lora'),
				'font-style'=>true,
				'font-weight'=>true,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'default' => array(
					'font-family'=>'Lora',
					'google'=>true
					),
				),
			array(
				'id'=>'heading-style',
				'type' => 'select',
				'title' => __('Heading Text Style', 'redux-framework'),
				'options'=>array(
					'uppercase'=>__('Uppercase', 'redux-framework'),
					'capitalize'=>__('Capitalize', 'redux-framework'),
					'none'=>__('None', 'redux-framework')
					),
				'default'=>'none'
				)
		)
	);

	$sections['advance'] = array(
		'icon' => 'el-icon-wrench',
		'title' => __('Advanced Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'sandbox-mode',
				'type' => 'switch', 
				'title' => __('Development Mode', 'redux-framework'),
				'subtitle'=> __('Please activate this option during development stage', 'redux-framework'),
				'description'=>__('Few webhosts cached CSS file that causes Theme Option unresponsive','redux-framework'),
				"default"=> 0,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'disable_automatic_update',
				'type' => 'switch', 
				'title' => __('Automatic Update', 'redux-framework'),
				"default"=> 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'core_automatic_update',
				'type' => 'radio', 
				'title' => __('WP Core Automatic Update', 'redux-framework'),
				"default"=> 'false',
				'options'=>array(
					'true' => __('Enable', 'redux-framework'),
					'minor' => __('Minor Update Only', 'redux-framework'),
					'false' => __('Disable', 'redux-framework')
				)	
				),	
	        array(
				'id'=>'css-code',
				'type' => 'ace_editor',
				'title' => __('CSS Code', 'redux-framework'), 
				'subtitle' => __('Paste your CSS code here', 'redux-framework'),
				'mode' => 'css',
	            'theme' => 'monokai',
				'desc' => sprintf(__('Your css code will saving at %s','redux-framework'),'/css/customstyle.css'),
	            'default' => "body{height: 100%;}"
				),
	        array(
				'id'=>'js-code',
				'type' => 'ace_editor',
				'title' => __('JS Code', 'redux-framework'), 
				'subtitle' => __('Paste your JS code here. JS Code loaded on end of page', 'redux-framework'),
				'mode' => 'javascript',
	            'theme' => 'chrome',
				'desc' => __('Be careful!','redux-framework'),
	            'default' => "jQuery(document).ready(function(){});"
				)
	        )
	);

	$sections['seo'] = array(
		'icon' => 'el-icon-laptop',
		'title' => __('SEO', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'cleancoseo',
				'type' => 'switch', 
				'title' => __('Meta SEO ', 'redux-framework'),
				'subtitle'=> __('Allow on/off Meta SEO', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
	        array(
				'id'=>'meta-author',
				'type' => 'text',
				'title' => __('Meta Author', 'redux-framework'), 
				'subtitle' => __('Type your meta author', 'redux-framework'),
	            'validate' => 'no_html',
	            'default' => "Detheme Team"
				),
	        array(
				'id'=>'meta-description',
				'type' => 'textarea',
				'title' => __('Meta Description', 'redux-framework'), 
				'subtitle' => __('Type your meta description. Googlebot loves it if it\'s not exceeding 160 characters or 20 words', 'redux-framework'),
	            'validate' => 'no_html',
	            'default' => sprintf(__("%s is Perfect Wordpress Template For Any Website",'redux-framework'),ucwords(get_template()))
				),
	        array(
				'id'=>'meta-keyword',
				'type' => 'textarea',
				'title' => __('Meta Keyword', 'redux-framework'), 
				'subtitle' => __('Type your meta keyword separed by comma. Googlebot loves it if it\'s not exceeding 160 characters or 20 words', 'redux-framework'),
	            'validate' => 'no_html',
	            'default' => sprintf(__("%s , wordpress template, template, wordpress",'redux-framework'),get_template())
				),
	        array(
				'id'=>'footer-code',
				'type' => 'textarea',
				'title' => __('Custom Code', 'redux-framework'), 
				'subtitle' => __('Paste your html code here. It will be added before the closing &lt;/body&gt; tag', 'redux-framework'),
	            'validate' => 'html',
	            'default' => ""
				)
	        )
	);

	global $wp_filesystem;

	$sections['info'] = array(
		'icon' => 'el-icon-info-sign',
		'title' => __('Theme Information & Update', 'redux-framework'),
		'desc' => '<p class="description">'.__('The Awesome Wordpress Theme by detheme', 'redux-framework').'</p>',
		'fields' => array(
			array(
				'title' => __('Item Purchase Number', 'redux-framework'),
				'id'=>'cleanco_license',
				'type' => 'text',
				'default'=>get_option("cleanco_license_".get_template()),
				'desc' => sprintf(__('purchase number from %s', 'redux-framework'),"themeforest.net")
				),
			array(
				'id'=>'raw_new_info',
				'type' => 'raw',
				'content' => $item_info,
				)
			),   
		);

	if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
	    $tabs['docs'] = array(
			'icon' => 'el-icon-book',
			    'title' => __('Documentation', 'redux-framework'),
	        'content' => nl2br($wp_filesystem->get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
	    );
	}

	global $DethemeReduxFramework;
	$DethemeReduxFramework = new DethemeReduxFramework ();
	$DethemeReduxFramework->__render($sections, $args, $tabs);

	// END Sample Config
	}
	add_filter('theme_option_name','cleanco_redux_option_name');
	add_action('init', 'redux_init');
endif;

function cleanco_redux_option_name($option_name){
	return "cleanco_config";
}


function get_cleanco_default_setting($default){

	$defaultsettings=array(
		'showtopbar'=>0,
		'dt-show-header'=>1,
		'dt-main-menu'=>'',
		'show-banner-area'=>true,
		'show-banner-home'=>true,
		'dt-logo-image'=>array('url'=>get_template_directory_uri().'/images/logo.png'),
		'homepage-dt-logo-image'=>array('url'=>get_template_directory_uri().'/images/logo.png'),
		'dt-logo-image-transparent'=>array('url'=>get_template_directory_uri().'/images/logo.png'),
		'homepage-dt-logo-image-transparent'=>array('url'=>get_template_directory_uri().'/images/logo.png'),
		'dt-show-banner-page'=>'image',
		'dt-banner-image'=>"",
		'dt-show-title-page'=>'',
		'dt-show-breadcrumb'=>0,
		'meta-keyword'=>'',
		'meta-description'=>'',
		'meta-author'=>'',
		'primary-color'=>'#f58e03',
		'page_loader'=>true,
		'boxed_layout_activate'=>false,
		'dt-header-type'=>'middle',
		'show-header-searchmenu'=>false,
		'show-header-shoppingcart'=>false,
		'footer-code'=>'',
		'dt_scrollingsidebar'=>'',
		'showfooterarea'=>true,
		'lightbox_1st_on'=>false,
		'layout'=>'2',
		'dt-sticky-menu'=>true,
		'dt-comment-open'=>true,
		'dt_scrollingsidebar_on'=>false,
		'dt-logo-width'=>'',
		'dt-logo-margin'=>'',
		'dt-logo-leftmargin'=>'',
		'page-comment-open'=>null,
		'dtpost-comment-open'=>null,
		'body_background'=>'',
		'dt-sticky-menu'=>true,
		'dt-post-title-page'=>__('Blog', 'cleanco'),
		'dt-port-title-page'=>__('Portfolio', 'cleanco'),
		'body_tag'=>'',
		'layout-menu-separator'=>'menu_separator_type_1',
		'dt-select-modal-effects'=>'',
		'cleancoseo'=>1,
		'footer-text'=>'© '.date('Y').' '.sprintf(__('%s, The Awesome Theme. All right reserved.','cleanco'),get_template())
	);

	return wp_parse_args($default,$defaultsettings);

}

add_filter( 'redux/options/cleanco_config/global_variable','get_cleanco_default_setting');


if(!function_exists('darken')){
	function darken($colourstr, $procent=0) {
	  $colourstr = str_replace('#','',$colourstr);
	  $rhex = substr($colourstr,0,2);
	  $ghex = substr($colourstr,2,2);
	  $bhex = substr($colourstr,4,2);

	  $r = hexdec($rhex);
	  $g = hexdec($ghex);
	  $b = hexdec($bhex);

	  $r = max(0,min(255,$r - ($r*$procent/100)));
	  $g = max(0,min(255,$g - ($g*$procent/100)));  
	  $b = max(0,min(255,$b - ($b*$procent/100)));

	  return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
	}
}

if(!function_exists('lighten')){

    function lighten($colourstr, $procent=0){

      $colourstr = str_replace('#','',$colourstr);
      $rhex = substr($colourstr,0,2);
      $ghex = substr($colourstr,2,2);
      $bhex = substr($colourstr,4,2);

      $r = hexdec($rhex);
      $g = hexdec($ghex);
      $b = hexdec($bhex);

      $r = max(0,min(255,$r + ($r*$procent/100)));
      $g = max(0,min(255,$g + ($g*$procent/100)));  
      $b = max(0,min(255,$b + ($b*$procent/100)));

      return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
    }

}

if(!function_exists('get_redux_custom_primary_font')){

function get_redux_custom_primary_font($font_family='') {

	if(empty($font_family) && ''!==$font_family)
		return '';
ob_start();

$primary_font_family = $font_family['font-family'];
if(!empty($primary_font_family) && ''!==$primary_font_family) :

$letter_spacing = isset($font_family['letter-spacing']) ? $font_family['letter-spacing'] : "";

?>
body.dt_custom_body,
.woocommerce.widget_product_tag_cloud li,
.postdate .year,
.postmetatop ul li,
.singlepostmetatop ul li,
.dt-comment-date,
.dt-comment-comment,
.footer-right,
footer#footer .widget_tag_cloud .tagcloud .tag,
footer#footer .widget_categories,
footer#footer .widget_archive,
.sidebar .widget_tag_cloud .tagcloud .tag,
.sidebar .widget_categories,
.sidebar .widget_archive,
section#banner-section .breadcrumbs,
.dt-contact-form input[type="text"], 
.dt-contact-form input[type="email"], 
.dt-contact-form input[type="password"], 
.dt-contact-form input[type="number"], 
.dt-contact-form input[type="tel"],
.dt-contact-form input[type="submit"], 
.dt-contact-form textarea,
#dt-menu li a,
#mobile-header label,
#dt-menu a, #dt-menu .sub-nav a,
.postmetabottom { 
	font-family: <?php print $primary_font_family;?>; 
<?php
if(''!==$letter_spacing) :
	print "letter-spacing: ".$letter_spacing.";";
endif;
?>
}
.postinfo .share-button.sharer-0 label span { 
	font-family: <?php print $primary_font_family;?> !important; 
<?php
if(''!==$letter_spacing) :
	print "letter-spacing: ".$letter_spacing.";";
endif;
?>
}
#dt-menu label { <?php print $primary_font_family;?>; }
#dt-menu .sub-nav label { <?php print $primary_font_family;?>; }
<?php
endif;

	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

}

if(!function_exists('get_redux_custom_section_font')){

	function get_redux_custom_section_font($font_family=''){

	if(empty($font_family) && ''!==$font_family)
		return '';

ob_start();

$section_font_family = $font_family['font-family'];
$letter_spacing = isset($font_family['letter-spacing']) ? $font_family['letter-spacing'] : "";

if(isset($section_font_family) && ''!==$section_font_family) :
?>
.dt-section-head h1,
.dt-section-head h2,
.dt-section-head h3,
.dt-section-head h4,
.dt-section-head h5,
.dt-section-head h6 {
  font-family: <?php print $section_font_family;?>;
<?php if( isset($font_family['font-weight']) && ''!=$font_family['font-weight']):?>
  font-weight: <?php print $font_family['font-weight'];?>;
<?php endif;?>
<?php if(isset($font_family['font-style']) && ''!=$font_family['font-style']):?>
  font-style: <?php print $font_family['font-style'];?>;
<?php endif;?>
<?php if(!empty($letter_spacing) && ''!==$letter_spacing) :?>
	letter-spacing: <?php print $letter_spacing;?>;
<?php endif;?>
}
<?php
endif;

	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}
}

if(!function_exists('get_redux_custom_heading_text')){
	function get_redux_custom_heading_text($args) {
		$cssline = "";
		ob_start();

if (isset($args['secondary-font']['font-family'])&&!empty($args['secondary-font']['font-family'])) {
			$secondary_font_family 	= $args['secondary-font']['font-family'];
			$font_weight			= $args['secondary-font']['font-weight'];
			$font_style				= $args['secondary-font']['font-style'];
?>
h1,
h2,
h3,
h4,
h5,
h6, 
.btn{
  font-family: <?php print $secondary_font_family;?>;
<?php if(''!=$font_weight):?>
  font-weight: <?php print $font_weight;?>;
<?php endif;?>
<?php if(''!=$font_style):?>
  font-style: <?php print $font_style;?>;
<?php endif;

$letter_spacing = isset($args['secondary-font']['letter-spacing']) ? $args['secondary-font']['letter-spacing'] : "";
if(!empty($letter_spacing) && ''!==$letter_spacing) :
?>
	letter-spacing: <?php print $letter_spacing;?>;
<?php endif;?>
}

.dt_testimonial .people-text > p,
input.secondary_color_button,
.btn,
.social-share-link,
.postdate .day,
.postcontent-quote,
.dt-comment-author,
#mobile-header label,
.dt-contact-form input[type="submit"],
#dt-topbar-menu-left,
#dt-topbar-menu-left .sub-nav, 
#dt-topbar-menu-left .toggle-sub,
#mobile-header-top-right label,
#mobile-header-top-left label,
#dt-topbar-menu-right,
#dt-topbar-menu-right .sub-nav,
#dt-topbar-menu-right .toggle-sub, 
#top-bar,
#footer-right .widget .widget-title,
.carousel-content .carousel-inner a.inline-block,
.box-main-color .iconbox-detail h3,
.box-secondary-color .iconbox-detail h3,
.woocommerce #content input.button,
.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce-page #content input.button,
.woocommerce-page #respond input#submit,
.woocommerce-page a.button,
.woocommerce-page button.button,
.woocommerce-page input.button,
h4.blog-post-title a,
.dt-comment-author,
.dt-popup-iconbox .popup-heading,
.navigation_button .navigation_button_item .text-box .navigation-text{
  font-family: <?php print $secondary_font_family;?>;
}


#dt-menu label {
  font: 3.125em/1.375em <?php print $secondary_font_family;?>;
}

#dt-topbar-menu-left label {
  font: 3.125em/1.375em <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-left .sub-nav label {
  font: 2em/2em <?php print $secondary_font_family;?>;
}

#dt-topbar-menu-left ul li a:after {
    font: 1.5em <?php print $secondary_font_family;?>;
}

#dt-topbar-menu-right label {
  font: 3.125em/1.375em <?php print $secondary_font_family;?>;
}
#dt-topbar-menu-right .sub-nav label {
  font: 2em/2em <?php print $secondary_font_family;?>;
}

#dt-topbar-menu-right ul li a:after {
    font: 1.5em <?php print $secondary_font_family;?>;
}
.postinfo .share-button.float-right.sharer-0 label span {
  font-family: <?php print $secondary_font_family;?>!important;
}

<?php
}

if (isset($args['heading_text_color'])&&!empty($args['heading_text_color'])&&$args['heading_text_color']!='#304152') {
			$heading_text_color = $args['heading_text_color'];
?>
h1, h2, h3, h4, h5, h6,
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
blockquote:before,
.dt_testimonial .people-text > p { color: <?php print $heading_text_color ?> }

.btn.btn-ghost, #sequence ul li .btn-cta {
  border-color: <?php print $heading_text_color ?>;
  color: <?php print $heading_text_color ?>;
}
.btn.btn-ghost:hover {
  background-color: <?php print $heading_text_color ?>;
  border-color: <?php print $heading_text_color ?>;
}
.btn.btn-ghost:active, .btn.btn-ghost:focus {
  background-color: <?php print $heading_text_color ?>;
  border-color: <?php print $heading_text_color ?>;
}

.heading_text_color,.sidebar h3,
.sidebar .dt_widget_accordion .panel-heading:not(.openedup),
.dt-shop-category .owl-carousel-navigation .btn-owl:hover { color: <?php print $heading_text_color;?>; }

.section-heading-thin-border:after,
.section-heading-thick-border:after,
.section-heading-double-border-bottom:after,
.section-heading-thin-border-top-bottom:after {background-color: <?php print $heading_text_color ?>;}

h1.section-heading-border{border-color: <?php print $heading_text_color ?>;}
.section-heading-border-top-bottom {border-top-color: <?php print $heading_text_color ?>; border-bottom-color: <?php print $heading_text_color ?>;}
.section-heading-point-bottom {border-bottom-color: <?php print $heading_text_color ?>;}
<?php
}
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;

	} //function get_redux_custom_heading_text
}


if(!function_exists('get_redux_custom_secondary_font')){

function get_redux_custom_secondary_font($font_family='') {

	if(empty($font_family) && ''!==$font_family)
		return '';

$secondary_font_family=isset($font_family['font-family']) ? $font_family['font-family'] : "";
$font_weight=isset($font_family['font-weight']) ? $font_family['font-weight'] : "";
$font_style=isset($font_family['font-style']) ? $font_family['font-style'] : "";
$letter_spacing = isset($font_family['letter-spacing']) ? $font_family['letter-spacing'] : "";

ob_start();

if(!empty($secondary_font_family)):
?>
h1,h2,h3,h4,h5,h6, 
.btn{
  font-family: <?php print $secondary_font_family;?>;
<?php if(''!=$font_weight):?>
  font-weight: <?php print $font_weight;?>;
<?php endif;?>
<?php if(''!=$font_style):?>
  font-style: <?php print $font_style;?>;
<?php endif;?>
}

input.secondary_color_button,
.btn,
.social-share-link,
.postdate .day,
.postcontent-quote,
.dt-comment-author,
#mobile-header label,
.dt-contact-form input[type="submit"],
#top-bar,
#footer-right .widget .widget-title,
.carousel-content .carousel-inner a.inline-block,
.box-main-color .iconbox-detail h3,
.box-secondary-color .iconbox-detail h3,
.woocommerce #content input.button,
.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce-page #content input.button,
.woocommerce-page #respond input#submit,
.woocommerce-page a.button,
.woocommerce-page button.button,
.woocommerce-page input.button,
h4.blog-post-title a,
#dt-menu label,
#mobile-header-top-left label,
#dt-topbar-menu-left label,
#dt-topbar-menu-left .sub-nav label,
#dt-topbar-menu-left,
#dt-topbar-menu-left .sub-nav,
#dt-topbar-menu-left .toggle-sub,
#dt-topbar-menu-left ul li a:after,
#mobile-header-top-right label,
#dt-topbar-menu-right label,
#dt-topbar-menu-right .sub-nav label,
#dt-topbar-menu-right,
#dt-topbar-menu-right .sub-nav,
#dt-topbar-menu-right .toggle-sub,
#dt-topbar-menu-right ul li a:after {
    font-family: <?php print $secondary_font_family;?>;
<?php if(!empty($letter_spacing) && ''!==$letter_spacing) :?>
	letter-spacing: <?php print $letter_spacing;?>;
<?php endif;?>    
}
.postinfo .share-button.float-right.sharer-0 label span {
  font-family: <?php print $secondary_font_family;?>!important;
<?php if(!empty($letter_spacing) && ''!==$letter_spacing) :?>
	letter-spacing: <?php print $letter_spacing;?>;
<?php endif;?>    
}
<?php
	endif;
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

}

if(!function_exists('get_redux_custom_tertiary_font')){

function get_redux_custom_tertiary_font($tertiary_font_family='') {

	if(empty($tertiary_font_family) && ''!==$tertiary_font_family)
		return '';

	ob_start();
?>
blockquote { font-family: <?php print $tertiary_font_family;?> !important; }
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

}


if(!function_exists('get_redux_custom_primary_color')){
function get_redux_custom_primary_color($color='') {

	if(empty($color) && ''!==$color)
		return '';

	ob_start();

	$mainColor=$color;

    @list($r, $g, $b) = sscanf($mainColor, "#%02x%02x%02x");
    $rgbcolor=$r.','.$g.','.$b;

    @list($r50d, $g50d, $b50d) = sscanf(darken($mainColor,50), "#%02x%02x%02x");
    $rgb50dcolor=$r50d.','.$g50d.','.$b50d;
?>
.primary_color_text, .paging-nav a:hover,
 footer#footer .widget_calendar thead th,
 footer#footer .dt_widget_accordion .opened,
 .sidebar .widget_calendar a,
 .dt_team_custom_item .profile-position,
.dt-iconboxes-4:hover .dt-section-icon i:hover,
.dt-iconboxes.layout-6 i,
.no-touch .dt-iconboxes-4:hover .hi-icon-effect-5 .hi-icon,
.hovered > a span,
.dt-popup-iconbox .popup-icon,
.dt-popup-iconbox .popup-button
{ color: <?php print $mainColor;?>; }

.primary_color_border,
.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon { border-color: <?php print $mainColor;?>; }

.dt-popup-iconbox .popup-button,
.primary_color_bg, .paging-nav span.current,
.primary_color_button,footer#footer .widget_calendar #today,
footer#footer .widget_tag_cloud .tagcloud .tag:hover,
footer#footer .dt_widget_tabs .nav-tabs li a:hover,
footer#footer .dt_widget_tabs .nav-tabs li:hover,
footer#footer .dt_widget_tabs .nav-tabs li.active a,
footer#footer .dt_widget_tabs .nav-tabs li.active a:hover,
footer#footer .dt_widget_tabs .nav-tabs li.active a:focus,
footer#footer .dt_widget_accordion .btn-accordion,
footer#footer .dt_widget_accordion .openedup,
.sidebar .owl-theme .owl-controls .owl-page span,
.woocommerce.widget_product_tag_cloud li,
.sidebar .widget_calendar #today,
.sidebar .widget_tag_cloud .tagcloud .tag:hover,
.sidebar .dt_widget_tabs li.active a,
.sidebar .dt_widget_accordion .panel-heading.openedup,
.dt-timeline .time-item:hover .center-line i,
.dt-iconboxes span:hover,
.dt-iconboxes-2:hover .dt-section-icon i.hi-icon,
.dt-iconboxes-2:hover i,
.dt-iconboxes.layout-9 i,
.dt-iconboxes.layout-10 i,
.dt-iconboxes.layout-3 span:hover,
.dt-iconboxes-4:hover .dt-section-icon,
.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon,
.dt-iconboxes.layout-6:hover {
  background-color: <?php print $mainColor;?>;
}

.btn-color-primary,
.portfolio-navigation a.more-post, 
.dt-contact-form.on-dark input[type="submit"], 
.shipping-calculator-button,
.woocommerce #content input.button,
.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce-page #content input.button,
.woocommerce-page #respond input#submit,
.woocommerce-page a.button,
.woocommerce-page button.button,
.woocommerce-page input.button,
.woocommerce.widget_product_search #searchsubmit,
.woocommerce #content input.button.alt,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.woocommerce-page #content input.button.alt,
.woocommerce-page #respond input#submit.alt,
.woocommerce-page a.button.alt,
.woocommerce-page button.button.alt,
.woocommerce-page input.button.alt {
	background: <?php print $mainColor;?>;
}

footer#footer .widget_text ul.list-inline-icon li:hover { border: 1px solid <?php print $mainColor;?>; background: <?php print $mainColor;?>; }
footer#footer .owl-theme .owl-controls .owl-page span { background-color: <?php print $mainColor;?>; border: 2px solid <?php print $mainColor;?>; }
footer#footer .owl-theme .owl-controls .owl-page.active span { border: 2px solid <?php print $mainColor;?>; }

footer#footer .dt_widget_tabs .nav-tabs li a:hover {
  color: #ffffff;
}


footer#footer .dt_widget_accordion .opened {
  background: #ffffff; 
}
.sidebar .owl-theme .owl-controls .owl-page.active span {
  border: 2px solid <?php print $mainColor;?>;
}

.sidebar .widget_text ul.list-inline-icon li:hover {
   border: 1px solid <?php print $mainColor;?>; background: <?php print $mainColor;?>; 
}

h3.widget-title:after {
  border-top: solid 2px <?php print $mainColor;?>;
}
#related-port .related-port figure figcaption .related-tag a {
  color: <?php print $mainColor;?>;
}

.dt-timeline .time-item:hover .content-line,
.dt-timeline .time-item:hover .content-line:before {
  border-color: <?php print $mainColor;?>;
}

@media handheld, only screen and (max-width: 479px) {
  .dt-timeline .time-item .center-line {
    display: none !important;
  }
  .dt-timeline .time-item .content-line {
    margin: 0!important;
    left: 0!important;
    margin-right: 0!important;
    margin-left: 0!important;
  }
  .dt-timeline .time-item:hover .content-line:before,
  .dt-timeline .time-item .content-line:before {
    background: none!important;
    border: none !important;
  }
}

.dt_team_custom_item hr:after {
  width: 50px !important;
}
.dt-iconboxes span:hover:after,
.dt-iconboxes span:hover:before,
.dt-iconboxes.layout-3 span:hover:after,
.dt-iconboxes.layout-3 span:hover:before,
.dt-iconboxes-4:hover .dt-section-icon:after,
.dt-iconboxes-4:hover .dt-section-icon:before {
  border-top-color: <?php print $mainColor;?> !important;
}

.dt_team_custom_item .profile-scocial a:hover,
.dt_team_custom_item .profile-scocial i:hover {
  color: <?php print $mainColor;?>;
}
.dt-pricing-table .featured ul li.plan-action,
.dt-pricing-table .featured ul li.plan-action,
.dt-pricing-table .featured ul li.plan-head,
.dt-pricing-table .featured ul li.plan-head {
  background: <?php print $mainColor;?> !important;
}
.mejs-container .mejs-controls .mejs-horizontal-volume-current,
.mejs-container .mejs-controls .mejs-time-loaded {
  background-color: <?php print $mainColor;?> !important;
}

#dt-menu a:hover, #dt-menu li a:hover{
	color: <?php print $mainColor;?>;
}

@media (max-width: 991px) {
	#head-page #dt-menu > ul > li > a:hover {color:<?php print $mainColor;?>!important;}
}
@media (min-width: 991px) {
	#dt-menu ul li:hover > a {
		color: <?php print $mainColor;?>;
	}
}
#dt-menu ul.sub-nav li:hover > a {
    color: <?php print $mainColor;?>;
  }
#dt-menu a.search_btn:hover {
    color: <?php print $mainColor;?> !important;
}
#dt-topbar-menu-left ul li:hover > a {
    color: <?php print $mainColor;?>;
}
#dt-topbar-menu-left li a:hover {
  background: <?php print $mainColor;?>;
}
#dt-topbar-menu-left .toggle-sub {
  background: <?php print $mainColor;?>;
}
#dt-topbar-menu-left li:hover > .toggle-sub {
  color: <?php print $mainColor;?>;
}
#dt-topbar-menu-left ul li:first-child {
    border-top: 3px solid <?php print $mainColor;?> !important;
  }
#dt-topbar-menu-left ul.sub-nav li:hover > a {
    background: <?php print $mainColor;?>;
  }

#dt-topbar-menu-right ul li:hover > a {
    color: <?php print $mainColor;?>;
}
#dt-topbar-menu-right li a:hover {
  background: <?php print $mainColor;?>;
}
#dt-topbar-menu-right .toggle-sub {
  background: <?php print $mainColor;?>;
}
#dt-topbar-menu-right li:hover > .toggle-sub {
  color: <?php print $mainColor;?>;
}
#dt-topbar-menu-right ul.sub-nav li:hover > a {
    background: <?php print $mainColor;?>;
  }

.select.select-theme-default .select-options .select-option:hover, .select.select-theme-default .select-options .select-option.select-option-highlight {background: <?php print $mainColor;?>;}

footer#footer .dt_widget_portfolio_posts .post-item figure figcaption {
  background: rgba(<?php print $rgb50dcolor;?>, 0.6);
}
.sidebar .dt_widget_portfolio_posts .portfolio_wrapper .post-item figure figcaption {
  background: rgba(<?php print $rgb50dcolor;?>, 0.6);
}
.dt_widget_featured_posts .post-item figure figcaption {
  background: rgba(<?php print $rgb50dcolor;?>, 0.6);
}
.sidebar .widget_calendar a:hover {
  color: <?php print darken($mainColor,30);?>;
}

.tertier_color_bg_transparent{
	background: rgba(<?php print $rgbcolor;?>, 0.65);
}

.dt-iconboxes.layout-7:hover i,.dt-iconboxes.layout-8:hover i{
  border-color: <?php print darken($mainColor,35);?> !important;	
}
.dt-iconboxes.layout-7 i,.dt-iconboxes.layout-8 i{
  color: <?php print $mainColor;?>;	
}

@media (max-width: 768px) {
  #footer-left {
    border-bottom: solid 1px <?php print darken($mainColor,60);?>;
  }
}
.dt-iconboxes-4:hover { 
	background-color: <?php print darken($mainColor,20);?>; 
}

.sidebar .woocommerce.widget_product_tag_cloud .tagcloud .tag:hover,
footer#footer .woocommerce.widget_product_tag_cloud .tagcloud .tag:hover {
  background-color: <?php print $mainColor;?>;
}

.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
  background-color: <?php print $mainColor;?>;
}

.border-color-primary, 
.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a, 
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, 
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a, 
.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a {
  border-color: <?php print $mainColor;?>;
}
.box-main-color .img-blank {
  background-color: <?php print $mainColor;?>;
}
.link-color-primary, 
#dt-menu #menu-main-menu .current-menu-parent > a,
#dt-menu #menu-main-menu .current-menu-item > a,
#dt-menu #menu-main-menu .sub-nav .current-menu-item > a,  
.woocommerce nav.woocommerce-pagination ul li a.prev:hover, 
.woocommerce-page nav.woocommerce-pagination ul li a.prev:hover, 
.woocommerce nav.woocommerce-pagination ul li a.next:hover, 
.woocommerce-page nav.woocommerce-pagination ul li a.next:hover {
  color: <?php print $mainColor;?>;
}
.background-color-primary, 
.dt-icon-circle.primary-color, 
.dt-icon-ghost.primary-color, 
.sidebar .widget_text .social-circled li:hover, 
#footer .container .widget_text .social-circled li:hover, 
#featured-work-navbar #featured-filter.dt-featured-filter li.active a, 
.owl-custom-pagination .owl-page.active i, 
.wpb_wrapper .wpb_content_element .wpb_accordion_wrapper .ui-state-default .ui-icon:after, 
.wpb_wrapper .wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-accordion-header-active,  
.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, 
.woocommerce div.product .woocommerce-tabs ul.tabs li.active, 
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, 
.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, 
.woocommerce nav.woocommerce-pagination ul li span.current, 
.woocommerce-page nav.woocommerce-pagination ul li span.current, 
.woocommerce #content nav.woocommerce-pagination ul li span.current, 
.woocommerce-page #content nav.woocommerce-pagination ul li span.current, 
.woocommerce nav.woocommerce-pagination ul li a:hover, 
.woocommerce-page nav.woocommerce-pagination ul li a:hover, 
.woocommerce #content nav.woocommerce-pagination ul li a:hover, 
.woocommerce-page #content nav.woocommerce-pagination ul li a:hover, 
.woocommerce nav.woocommerce-pagination ul li a:focus, 
.woocommerce-page nav.woocommerce-pagination ul li a:focus, 
.woocommerce #content nav.woocommerce-pagination ul li a:focus, 
.woocommerce-page #content nav.woocommerce-pagination ul li a:focus, 
#sequence ul li .btn-cta:after, .dt-iconboxes-4, .dt-iconboxes span:hover, 
.dt-iconboxes-2:hover .dt-section-icon i.hi-icon, .dt-iconboxes-2:hover i, 
.dt-iconboxes.layout-3 span:hover, .dt-iconboxes-4:hover .dt-section-icon, 
.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon, 
.dt-iconboxes.layout-6:hover,.bulat2, 
.dt-iconboxes.layout-3 span:hover {
  background: none repeat scroll 0 0 <?php print $mainColor;?>;
}

.dt-iconboxes.layout-3 span:hover:after, .dt-iconboxes.layout-3 span:hover:before {border-top-color: <?php print $mainColor;?> !important;}

#featured-work-navbar #featured-filter.dt-featured-filter li.active {
  border: 1px solid <?php print $mainColor;?> !important;
}
.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon {
  background-color: <?php print $mainColor;?>;
  border-color: <?php print $mainColor;?>;
}
.container .owl-theme .owl-controls .owl-page span {
  background-color: <?php print $mainColor;?>;
  border-color: <?php print $mainColor;?>; 
}
.owl-theme .owl-controls .owl-page.active span,
.dt_counto_box .counto-number {
  border-color: <?php print $mainColor;?>; 
}
.container .carousel-content .carousel-indicators li {
  	background-color: <?php print $mainColor;?>;
  	border-color: <?php print $mainColor;?>; 
}
.container .carousel-content .carousel-indicators .active {
  	border-color: <?php print $mainColor;?>; 
}
.dt-iconboxes span:hover, .dt-iconboxes.layout-3 span:hover {
  	border-color: <?php print $mainColor;?>;
}
.dt_vertical_tab .vertical-nav-tab > li > div i { color: <?php print $mainColor;?>; }
.wpb_wrapper .wpb_content_element .wpb_accordion_wrapper .ui-state-active .ui-icon:after,
.wpb_wrapper .vc_tta-accordion .vc_tta-panel.vc_active .vc_tta-panel-heading  .vc_tta-controls-icon:after {
	color: <?php print $mainColor;?>;
}
.wpb_wrapper .wpb_content_element .wpb_tabs_nav li.ui-tabs-active {
	background: none repeat scroll 0 0 <?php print $mainColor;?>;
}

.wpb_wrapper .vc_tta-tabs li.vc_active > a, .wpb_wrapper .vc_tta-tabs li.vc_tta-tab.vc_active > a,
.wpb_wrapper .vc_tta-accordion .vc_tta-panel .vc_tta-panel-heading .vc_tta-controls-icon:after{
	background: <?php print $mainColor;?>;
}

.wpb_wrapper .vc_tta-tabs li.vc_active,
.wpb_wrapper .vc_tta-tabs li.vc_tta-tab.vc_active,
.wpb_wrapper .vc_tta-tabs li.vc_tta-tab:hover,
.wpb_wrapper .vc_tta-tabs li:hover,
.wpb_wrapper .vc_tta-tabs .vc_tta-panel.vc_active .vc_tta-panel-heading,
.wpb_wrapper .vc_tta-tabs .vc_tta-panel:hover .vc_tta-panel-heading,
.wpb_wrapper .vc_tta-tabs .vc_tta-panel:hover .vc_tta-panel-heading{
	box-shadow: inset 0 -5px 0 <?php print $mainColor;?>;
}

.wpb_wrapper .vc_tta-tabs li.vc_tta-tab.vc_active > a,
.wpb_wrapper .vc_tta-tabs .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title > a,
.wpb_wrapper .vc_tta-tabs li.vc_active > a{
	color:<?php print $mainColor;?>;
}

.btn.btn-link { color: <?php print $mainColor;?>; }
.btn.btn-link:hover { color: <?php print $mainColor;?>; }
#footer h3.widget-title:after { border-top: 2px solid <?php print $mainColor;?>; }
.text-hover-pre-title {background-color:<?php print $mainColor;?>}
form.wpcf7-form .wpcf7-form-control-wrap .select-target.select-theme-default { background-color: <?php print $mainColor;?>; }

.home #head-page #dt-menu > ul > li > a:hover {color:<?php print $mainColor;?>;}
#head-page #dt-menu > ul > li > a:hover {color:<?php print $mainColor;?>;}
.owl-buttons i {color:<?php print $mainColor;?>;}

.wpb_content_element .wpb_tabs_nav li.ui-tabs-active, .wpb_content_element .wpb_tabs_nav li:hover {
	box-shadow: inset 0 -5px 0 <?php print $mainColor;?>;
}
.wpb_wrapper .wpb_content_element .wpb_tabs_nav li.ui-tabs-active {
	box-shadow: inset 0 -5px 0 <?php print $mainColor;?>;
}
.wpb_wrapper .wpb_content_element .wpb_tabs_nav li.ui-tabs-active a {
	color: <?php print $mainColor;?>;
}

.menu-leftvc #head-page.alt #dt-menu > ul > li.current-menu-item > a { color: <?php print $mainColor;?>; }
.menu-leftvc #head-page.alt #dt-menu > ul > li > a:hover,
.menu-leftvc #head-page.alt #dt-menu > ul > li > a:active,
.menu-leftvc #head-page.alt #dt-menu > ul > li > a:focus { color: <?php print $mainColor;?>; }
.menu-leftvc #head-page #dt-menu > ul > li > a:hover,
.menu-leftvc #head-page #dt-menu > ul > li.hovered > a { border-top-color: <?php print $mainColor;?>; }

.btn-primary-secondary { background-color: <?php print $mainColor;?>; }
.btn-secondary-primary:hover { background-color: <?php print $mainColor;?>; }

<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}
}
if(!function_exists('get_redux_custom_secondary_color')){
	function get_redux_custom_secondary_color($color='') {

		if(empty($color) && ''!==$color)
			return '';

		ob_start();

		$mainColor=$color;

	    @list($r, $g, $b) = sscanf($mainColor, "#%02x%02x%02x");
	    $rgbcolor=$r.','.$g.','.$b;
	?>
.secondary_color_bg { background-color: <?php print $mainColor;?>; }
.secondary_color_text { color: <?php print $mainColor;?>; }
.secondary_color_border { border-color: <?php print $mainColor;?>; }

.secondary_color_button, .btn-color-secondary {
  background-color: <?php print $mainColor;?>;
}
.background-color-secondary, .dt-icon-circle.secondary-color, .dt-icon-ghost.secondary-color, .dt-icon-square.secondary-color, #sequence ul.sequence-canvas li .slide-title:after {
	 background: <?php print $mainColor;?>;
}
:selection {
  background: <?php print $mainColor;?>;
}
::selection {
  background: <?php print $mainColor;?>;
}
::-moz-selection {
  background: <?php print $mainColor;?>;
}
.woocommerce.widget_product_tag_cloud li:hover {
  background-color: <?php print $mainColor;?>;
}
.woocommerce ul.products li.product .onsale:after,
.woocommerce-page ul.products li.product .onsale:after,
.woocommerce span.onsale:after,
.woocommerce-page span.onsale:after {
  border-bottom: 40px solid <?php print $mainColor;?>;
}
a {
  color: <?php print $mainColor;?>;
}
a:hover, a:focus { border-color : <?php print $mainColor;?>; }
a:hover, a:focus { color : <?php print darken($mainColor,20);?>; }
h1 a:hover,
h2 a:hover,
h3 a:hover,
h4 a:hover,
h5 a:hover,
h6 a:hover,
h1 a:focus,
h2 a:focus,
h3 a:focus,
h4 a:focus,
h5 a:focus,
h6 a:focus,
.portfolio-type-text .portfolio-item .portfolio-termlist a
 {
  color: <?php print $mainColor;?>;
}
#dt-topbar-menu-left li .toggle-sub:hover {
  color: <?php print $mainColor;?>;
}
#dt-topbar-menu-left a.search_btn:hover {
    color: <?php print $mainColor;?>;
  }
#dt-topbar-menu-right li .toggle-sub:hover {
  color: <?php print $mainColor;?>;
}
#dt-topbar-menu-right a.search_btn:hover {
    color: <?php print $mainColor;?>;
  }
footer#footer .widget_calendar a {
  color: <?php print $mainColor;?>;
}
footer#footer .widget_recent_comments a:hover {
  color: <?php print $mainColor;?>;
}
.sidebar a:hover {
  color: <?php print $mainColor;?>;
}
.sidebar .dt-widget-twitter .sequence-twitter a {
  color: <?php print $mainColor;?>;
}
.sidebar .widget_recent_comments a:hover {
  color: <?php print $mainColor;?>;
}
#top-bar a:hover {
  color: <?php print $mainColor;?>;
}
.dt-section-head header i {
  background: <?php print $mainColor;?>;
}
.progress_bars i {
  background-color: <?php print $mainColor;?>;
}
.post-masonry li.isotope-item .isotope-inner .comment-count i:before {
  color: <?php print $mainColor;?>;
}
.post-masonry li.isotope-item .post-info .author a {
  color: <?php print $mainColor;?>;
}

.dt-pricing-table .price-4-col .btn-active,
.dt-pricing-table .price-3-col .btn-active {
  background-color: <?php print $mainColor;?>;
}
.dt-pricing-table .price-4-col .btn-active:hover,
.dt-pricing-table .price-3-col .btn-active:hover {
  background-color: <?php print darken($mainColor,20);?>;
}
.box-secondary-color .img-blank {
  background-color: <?php print $mainColor;?>;
}
.bulat1 {
  background: none repeat scroll 0 0 <?php print $mainColor;?>;
}
.woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price {
	color: <?php print $mainColor;?>;
}
.postinfo a:hover { color: <?php print $mainColor;?>; };
.postinfo .share-button.sharer-0 label span:hover { color: <?php print $mainColor;?> !important; };
.postinfo .share-button.sharer-0 label span:active { color: <?php print $mainColor;?> !important; };

h4.blog-post-title a:hover, h4.blog-post-title a:active {color: <?php print $mainColor; ?> !important;}

.wpb_wrapper .vc_tta-accordion .vc_tta-panel:not(.vc_active):hover .vc_tta-panel-heading .vc_tta-panel-title > a,
.wpb_wrapper .vc_tta-tabs li > a, .wpb_wrapper .vc_tta-tabs li.vc_tta-tab > a{
	color: <?php print $mainColor;?>;
}

.btn-primary-secondary:hover { background-color: <?php print $mainColor;?>; }
.btn-secondary-primary { background-color: <?php print $mainColor;?>; }

	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(!function_exists('get_redux_custom_menu_height')){
	function get_redux_custom_menu_height($line_height='') {

		if (empty($line_height) && ''!==$line_height) return '';
			
		if (!is_numeric($line_height)) return '';

		ob_start();
		//767/768 991/992
	?>
		@media(min-width: 992px) {
			#dt-menu > ul > li { line-height: <?php print $line_height;?>em;}
			.menu_separator_space { height: <?php print $line_height;?>em;}
		}
	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(!function_exists('get_redux_custom_footer')){
	function get_redux_custom_footer($args){
		$footer_bg_color = $args['footer-color'];
		$footer_font_color = $args['footer-font-color'];
	
	    @list($r, $g, $b) = sscanf($footer_font_color, "#%02x%02x%02x");
	    $rgbcolor=$r.','.$g.','.$b;
		

		ob_start();

		if(!empty($footer_bg_color) && ''!==$footer_bg_color) {	?>
		.tertier_color_bg {background-color: <?php print $footer_bg_color;?>; }

		#footer { background-image: url("<?php print $args['footer-background-image']['url'];?>"); }
		#footer { background-repeat: no-repeat; }
		#footer { background-size: cover; }

<?php	} ?>
.footer-left { color: <?php print $footer_font_color;?>; }
.footer-right { color: <?php print $footer_font_color;?>; }
footer#footer a { color: <?php print $footer_font_color;?>; }
#footer-right .widget .widget-title { color: <?php print $footer_font_color;?>; }

#footer .container .widget_text .social-circled li,
#footer .container .widget_text .social-circled li:last-child,
#footer .woocommerce ul.cart_list li,
#footer .woocommerce ul.product_list_widget li,
#footer .woocommerce-page ul.cart_list li,
#footer .woocommerce-page ul.product_list_widget li,
#footer .woocommerce.widget_product_categories li,
footer#footer .widget_tag_cloud .tagcloud .tag,
footer#footer .dt_widget_tabs .nav-tabs li a,
footer#footer .dt_widget_tabs .tab-pane .rowlist,
footer#footer .dt_widget_accordion .panel-heading,
footer#footer .dt_widget_accordion .panel-body,
#footer .widget_categories ul li,
#footer .widget_recent_entries ul li,
#footer .widget_recent_comments ul li,
#footer .widget_rss ul li,
#footer .widget_meta ul li,
#footer .widget_nav_menu ul li,
#footer .widget_archive ul li,
#footer .widget_text ul li,
footer#footer .woocommerce.widget_product_tag_cloud .tagcloud .tag {
  border-color: rgba(<?php print $rgbcolor;?>, 0.05);
}

footer#footer .widget_text ul.list-inline-icon li {
  border: 1px solid rgba(<?php print $rgbcolor;?>, 0.05);
}

footer#footer .widget_search {
  color: <?php print $footer_font_color;?>;
}

footer#footer .widget_search #s {
  border: 1px solid rgba(<?php print $rgbcolor;?>, 0.4);
  color: <?php print $footer_font_color;?>;
}

footer#footer .select-target.select-theme-default {
		border: 1px solid rgba(<?php print $rgbcolor;?>, 0.4);
}

footer#footer .dt_widget_accordion .panel-heading {
  color: <?php print $footer_font_color;?>;
}

footer#footer .widget_recent_comments a {
  color: rgba(<?php print $rgbcolor;?>, 0.4);
}

footer#footer .woocommerce.widget_product_search #s {
  border: 1px solid rgba(<?php print $rgbcolor;?>, 0.4);
}
<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

function get_redux_custom_header($args){

	$cssline="";

	if('transparent'==$args['homepage-background-type']){
		$cssline.=".home .menu_background_color { background: transparent; }";
		$cssline.=".home #head-page.reveal .menu_background_color { background: ".$args['homepage-header-color-transparent']."; }";
		$cssline.=".home #head-page.reveal.alt .menu_background_color { background: transparent; }";

		$cssline.=".home .menu_separator svg path.menu_background_color { fill: transparent; }";
		$cssline.=".home #head-page.reveal .menu_separator svg path.menu_background_color { fill: ".$args['homepage-header-color-transparent']."; }";
		$cssline.=".home #head-page.reveal.alt .menu_separator svg path.menu_background_color { fill: transparent; }";
		
		$cssline.=".home .transparent.reveal .menu_separator svg path.menu_separator_border_color { stroke: ".$args['menu-separator-border-color']."; }";
		$cssline.=".home .transparent.reveal.alt .menu_separator svg path.menu_separator_border_color { stroke: transparent; }";

		$cssline.=".home .menu_separator.menu_separator_type_0 { background: transparent; }";
		$cssline.=".home .reveal .menu_separator_type_0 { background: ".$args['homepage-header-color-transparent']."; }";
		$cssline.=".home .reveal.alt .menu_separator_type_0 { background: transparent; }";

		$cssline.=".home #head-page.reveal #dt-menu > ul > li > a{ color:".$args['homepage-header-font-color-transparent'].";}";
		$cssline.=".home #head-page.reveal #dt-menu a.search_btn { color:".$args['homepage-header-font-color-transparent'].";}";
		$cssline.="#mobile-header { color:".$args['homepage-header-font-color-transparent'].";}";

		$cssline.=".home #head-page.alt #dt-menu > ul > li > a{ color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page.alt #dt-menu a.search_btn { color:".$args['homepage-header-font-color'].";}";

		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, .home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, .home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color-transparent'].";}";

		if ($args['homepage-header-color']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { .home #head-page { background: ".$args['homepage-header-color']."; }}";
		}
		
		$cssline.="@media (max-width: 991px) { .home #head-page.reveal.alt { background: transparent; }}";

		if ($args['homepage-header-color-transparent']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { .home #head-page.reveal { background: ".$args['homepage-header-color-transparent']."; }}";
		}

	}
	else{
		if ($args['homepage-header-color']!=='#ffffff') {
			$cssline.=".home .menu_background_color { background: ".$args['homepage-header-color']."; }";
			$cssline.=".home #head-page.reveal .menu_background_color { background: ".$args['homepage-header-color-transparent']."; }";
			$cssline.=".home #head-page.reveal.alt .menu_background_color { background: ".$args['homepage-header-color']."; }";

			$cssline.=".home .menu_separator svg path.menu_background_color { fill: ".$args['homepage-header-color']."; }";
			$cssline.=".home #head-page.reveal .menu_separator svg path.menu_background_color { fill: ".$args['homepage-header-color-transparent']."; }";
			$cssline.=".home #head-page.reveal.alt .menu_separator svg path.menu_background_color { fill: ".$args['homepage-header-color']."; }";
		}

		if ($args['menu-separator-border-color']!=='#b5cbd9') {
			$cssline.=".home .solid.reveal .menu_separator svg path.menu_separator_border_color { stroke: ".$args['menu-separator-border-color']."; }";
			$cssline.=".home .solid.reveal.alt .menu_separator svg path.menu_separator_border_color { stroke: ".$args['menu-separator-border-color']."; }";
		}

		$cssline.=".home .menu_separator.menu_separator_type_0 { background: ".$args['homepage-header-color']."; }";
		$cssline.=".home .reveal .menu_separator_type_0 { background: ".$args['homepage-header-color-transparent']."; }";
		$cssline.=".home .reveal.alt .menu_separator_type_0 { background: ".$args['homepage-header-color']."; }";

		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, .home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, .home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color-transparent'].";}";

		if ($args['homepage-header-color']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { .home #head-page { background: ".$args['homepage-header-color']."; }}";
			$cssline.="@media (max-width: 991px) { .home #head-page.reveal.alt { background: ".$args['homepage-header-color']."; }}";
		}

		if ($args['homepage-header-color-transparent']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { .home #head-page.reveal { background: ".$args['homepage-header-color-transparent']."; }}";
		}

	}

	if('transparent'==$args['header-background-type']){
		$cssline.=".menu_background_color { background: transparent; }";
		$cssline.="#head-page.reveal .menu_background_color { background: ".$args['header-color-transparent']."; }";
		$cssline.="#head-page.reveal.alt .menu_background_color { background: transparent; }";


		$cssline.=".menu_separator svg path.menu_background_color { fill: transparent; }";
		

		$cssline.="#head-page.reveal .menu_separator svg path.menu_background_color { fill: ".$args['header-color-transparent']."; }";
		$cssline.="#head-page.reveal.alt .menu_separator svg path.menu_background_color { fill: transparent; }";

		$cssline.=".transparent.reveal .menu_separator svg path.menu_separator_border_color { stroke: ".$args['menu-separator-border-color']."; }";
		$cssline.=".transparent.reveal.alt .menu_separator svg path.menu_separator_border_color { stroke: transparent; }";

		$cssline.=".menu_separator.menu_separator_type_0 { background: transparent; }";
		$cssline.=".reveal .menu_separator_type_0 { background: ".$args['header-color-transparent']."; }";
		$cssline.=".reveal.alt .menu_separator_type_0 { background: transparent; }";

		$cssline.="#head-page.reveal #dt-menu > ul > li > a{ color:".$args['header-font-color-transparent'].";}";
		$cssline.="#head-page.reveal #dt-menu a.search_btn { color:".$args['header-font-color-transparent'].";}";

		$cssline.=".menu-leftvc #head-page.reveal #dt-menu > ul > li > a{ color:".$args['header-font-color-transparent'].";}";
		$cssline.=".menu-leftvc #head-page.reveal #dt-menu a.search_btn { color:".$args['header-font-color-transparent'].";}";


		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, 
			.home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, 
			.home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['homepage-header-font-color-transparent'].";}";

		$cssline.="#head-page.alt #dt-menu > ul > li > a{ color:".$args['header-font-color'].";}";
		$cssline.="#head-page.alt #dt-menu a.search_btn { color:".$args['header-font-color'].";}";
		$cssline.=".menu-leftvc #head-page.alt #dt-menu > ul > li > a { color:".$args['header-font-color'].";}";
		$cssline.=".menu-leftvc #head-page.alt #dt-menu a.search_btn { color:".$args['header-font-color'].";}";

		if ($args['header-color']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { #head-page { background: ".$args['header-color']."; }}";
		}
		
		$cssline.="@media (max-width: 991px) { #head-page.reveal.alt { background: transparent; }}";

		if ($args['header-color-transparent']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { #head-page.reveal { background: ".$args['header-color-transparent']."; }}";
		}
	}
	else{
		if ($args['header-color']!=='#ffffff') {
			$cssline.=".menu_background_color { background: ".$args['header-color']."; }";
			$cssline.="#head-page.reveal .menu_background_color { background: ".$args['header-color-transparent']."; }";
			$cssline.="#head-page.reveal.alt .menu_background_color { background: ".$args['header-color']."; }";

			$cssline.=".menu_separator svg path.menu_background_color { fill: ".$args['header-color']."; }";
			$cssline.="#head-page.reveal.alt .menu_separator svg path.menu_background_color { fill: ".$args['header-color']."; }";
		}

		if ($args['header-color-transparent']!=='#ffffff') {
			$cssline.="#head-page.reveal .menu_separator svg path.menu_background_color { fill: ".$args['header-color-transparent']."; }";
		}


		if ($args['menu-separator-border-color']!=='#b5cbd9') {
			$cssline.=".solid.reveal .menu_separator svg path.menu_separator_border_color { stroke: ".$args['menu-separator-border-color']."; }";
			$cssline.=".solid.reveal.alt .menu_separator svg path.menu_separator_border_color { stroke: ".$args['menu-separator-border-color']."; }";
		}

		$cssline.=".menu_separator.menu_separator_type_0 { background: ".$args['header-color']."; }";
		$cssline.=".reveal .menu_separator_type_0 { background: ".$args['header-color-transparent']."; }";
		$cssline.=".reveal.alt .menu_separator_type_0 { background: ".$args['header-color']."; }";

		$cssline.=".home #head-page.alt.reveal #mobile-header label.toggle, .home #head-page.alt.reveal #mobile-header label.toggle:hover { color:".$args['header-font-color'].";}";
		$cssline.=".home #head-page.reveal #mobile-header label.toggle, .home #head-page.reveal #mobile-header label.toggle:hover { color:".$args['header-font-color-transparent'].";}";


		if ($args['header-color']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { #head-page { background: ".$args['header-color']."; }}";
			$cssline.="@media (max-width: 991px) { #head-page.reveal.alt { background: ".$args['header-color']."; }}";
		}
		
		if ($args['header-color-transparent']!=='#ffffff') {
			$cssline.="@media (max-width: 991px) { #head-page.reveal { background: ".$args['header-color-transparent']."; }}";
		}

	}

	if ('#95a5a6'!==$args['homepage-header-font-color']) {
		$cssline.=".home #head-page,.home #head-page #dt-menu > ul > li > a{color:".$args['homepage-header-font-color'].";}";
		$cssline.=".home #head-page #dt-menu a.search_btn {color:".$args['homepage-header-font-color'].";}";
	}

	if ('#95a5a6'!==$args['header-font-color']) {
		$cssline.="#head-page,#head-page #dt-menu > ul > li > a {color:".$args['header-font-color'].";}";
		$cssline.="#head-page,#head-page #dt-menu a.search_btn {color:".$args['header-font-color'].";}";

		$cssline.=".menu-leftvc #head-page,#head-page #dt-menu > ul > li > a {color:".$args['header-font-color'].";}";
		$cssline.=".menu-leftvc #head-page,#head-page #dt-menu a.search_btn {color:".$args['header-font-color'].";}";
	}

	//set top margin logo for mobile
	if (isset($args['dt-logo-margin-mobile'])&&!empty($args['dt-logo-margin-mobile'])) {
		$cssline.="#head-page #logomenumobile { padding-top: ".$args['dt-logo-margin-mobile']."px; }";
		$cssline.="#head-page #logomenurevealmobile { padding-top: ".$args['dt-logo-margin-mobile']."px; }";
	}

	if (isset($args['leftvc-logo-background-color'])) {
		$cssline.=".logo_bgcolor, .menu-leftvc #head-page.reveal.alt .logo_bgcolor { background-color: ".get_redux_colorrgba_css($args['leftvc-logo-background-color'])."; }";
	}

	if (isset($args['leftvc-buttons-background-color'])) {
		$cssline.=".nav_buttons_bgcolor { background-color: ".get_redux_colorrgba_css($args['leftvc-buttons-background-color'])."; }";
		$cssline.=".nav_bgcolor, .menu-leftvc #head-page.reveal.alt .nav_bgcolor { background-color: ".get_redux_colorrgba_css($args['leftvc-navigation-background-color'])."; }";
	}

	if (isset($args['leftvc-navigation-background-color'])) {
		$cssline.=".nav_bgcolor, .menu-leftvc #head-page.reveal.alt .nav_bgcolor { background-color: ".get_redux_colorrgba_css($args['leftvc-navigation-background-color'])."; }";
		//$cssline.=".menu-leftvc #head-page #dt-menu > ul > li > a:hover, .menu-leftvc #head-page #dt-menu > ul > li.hovered > a { color: ".get_redux_colorrgba_css($args['leftvc-navigation-background-color'])."; }";
	}

	if(isset($args['leftvc-buttons-color'])){
		$cssline.=".navigation_button i:before,.navigation_button i:after{ color: ".$args['leftvc-buttons-color']."; }";
	}


	if (isset($args['leftvc-buttons-separator-color'])) {
		$cssline.=".navigation_button_item,.navigation_button { border-color: ".get_redux_colorrgba_css($args['leftvc-buttons-separator-color'])."; }";
	}



	if(isset($args['leftvc-buttons-text-color'])){
		$cssline.=".navigation_button { color: ".$args['leftvc-buttons-text-color']."; }";
	}

	return $cssline;
}

function get_redux_boxed_layout($args){
	$cssline = "";

	if ($args['boxed_layout_activate']) {
		$cssline.="body.dt_custom_body { background-image: url(".$args['boxed_layout_body_background_image']['url']."); }";
		$cssline.="body.dt_custom_body { background-color: ".$args['boxed_layout_body_background_color']."; }";
		$cssline.="body.dt_custom_body { background-attachment: fixed; }";
		$cssline.="body.dt_custom_body { background-repeat: no-repeat; }";
		$cssline.="body.dt_custom_body { background-size: cover; }";
		
		$cssline.=".dt-boxed-container { background-image: url(".$args['boxed_layout_boxed_background_image']['url']."); }";
		$cssline.=".dt-boxed-container { background-color: ".$args['boxed_layout_boxed_background_color']."; }";
	}

	return $cssline;
}

if(!function_exists('get_redux_colorrgba_css')){
	function get_redux_colorrgba_css($colorrgba_array,$default='#ffffff') {
		$colorrgba_css = $default;

		if (is_array($colorrgba_array)) {
			if (empty($colorrgba_array['color'])) {
				//transparent color
				$colorrgba_css = "rgba(255,255,255,0)";
			} else {
				$colourstr = $colorrgba_array['color'];
				$colourstr = str_replace('#','',$colourstr);
		      	$rhex = substr($colourstr,0,2);
		      	$ghex = substr($colourstr,2,2);
		      	$bhex = substr($colourstr,4,2);

		      	$r = hexdec($rhex);
		      	$g = hexdec($ghex);
		      	$b = hexdec($bhex);

		      	$a = $colorrgba_array['alpha'];

		      	$colorrgba_css = "rgba(".$r.",".$g.",".$b.",".$a.")";
		      	//$colorrgba_css .= $colorrgba_array['color'];
			}
		}

		return $colorrgba_css;
	} //function get_redux_colorrgba_css
} //if(!function_exists('get_redux_colorrgba_css'))

if(!function_exists('get_redux_topbar')){
	function get_redux_topbar($args){
		$cssline = "";

		if ($args['showtopbar']) {
			$cssline.=".menu-center #top-bar,
				.menu-left #top-bar,
				.menu-leftbar #top-bar,
				.menu-middle #top-bar,
				.menu-right #top-bar { display: block; }";

			$cssline.=".menu-leftvc #top-bar .container { display: block; }";
		}

		$cssline.="#top-bar, .menu-leftvc #top-bar { background-color: ".get_redux_colorrgba_css($args['topbar-background-color'])."; }";

		if (isset($args['topbar-height'])) {
			$cssline.="#top-bar { min-height: ".$args['topbar-height']."px; }";
		}

		return $cssline;
	}
}

if(!function_exists('get_redux_body_style')){
	function get_redux_body_style($args){
		$cssline = "";

		if (isset($args['primary-font']['font-family'])&&!empty($args['primary-font']['font-family'])) {
			$cssline.="body.dt_custom_body { font-family: ".$args['primary-font']['font-family']."; }";
		}

		if (isset($args['body_background_color'])&&!empty($args['body_background_color'])) {
			$cssline.="body.dt_custom_body { background-color: ".$args['body_background_color']."; }";	
		}

		if (isset($args['body_background_color'])&&!empty($args['body_background_color'])) {
			$cssline.="body.dt_custom_body { background-color: ".$args['body_background_color']."; }";	
		}

		if (isset($args['body_text_color'])&&!empty($args['body_text_color'])) {
			$cssline.="body.dt_custom_body { color: ".$args['body_text_color']."; }";
			$cssline.=".postinfo a { color: ".$args['body_text_color']."; }";
			$cssline.=".postmetabottom { color: ".$args['body_text_color']."; }";
			$cssline.=".postinfo .share-button.sharer-0 label span { color: ".$args['body_text_color']."; }";
			
		}

		return $cssline;
	}
}

if(!function_exists('get_redux_custom_menu_margin_top')){
	function get_redux_custom_menu_margin_top($margin_top='') {

		if (empty($margin_top) && ''!==$margin_top) return '';
			
		if (!is_numeric($margin_top)) return '';

		ob_start();
	?>
		#dt-menu.dt-menu-center > ul { margin-top: <?php print $margin_top;?>px; }
		.reveal.alt #dt-menu.dt-menu-center > ul { margin-top: <?php print $margin_top;?>px; }

		#dt-menu.dt-menu-middle > ul { top: <?php print $margin_top;?>px; }
		.reveal.alt #dt-menu.dt-menu-middle > ul { top: <?php print $margin_top;?>px; }
	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(!function_exists('get_redux_custom_logo_margin_top_reveal')){
	function get_redux_custom_logo_margin_top_reveal($margin_top='') {

		if (empty($margin_top) && ''!==$margin_top) return '';
			
		if (!is_numeric($margin_top)) return '';

		ob_start();
	?>
		#head-page.reveal .dt-menu-center #logomenureveal { margin-top: <?php print $margin_top;?>px;	}
		#head-page.reveal .dt-menu-center #logomenu { margin-top: <?php print $margin_top;?>px;	}
		#head-page.reveal.alt .dt-menu-center #logomenureveal { margin-top: auto;	}
		#head-page.reveal.alt .dt-menu-center #logomenu { margin-top: auto;	}
	<?php
		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(!function_exists('get_redux_leftbar_menu')){
	function get_redux_leftbar_menu($image='',$horizontal="50",$vertical="100",$size="") {
		$backgroundImage=(isset($image['url']) && ''!=$image['url'])?$image['url']:"";
		$leftPosition=preg_replace('/%/',"",$horizontal)."%";
		$topPosition=preg_replace('/%/',"",$vertical)."%";

		if(!$backgroundImage)
			return "";

		ob_start();

		?>
		.vertical_menu #head-page.reveal{background-image:url(<?php print $backgroundImage;?>);background-repeat:no-repeat;background-position:<?php print $leftPosition." ".$topPosition;?>;<?php if($size!='' && $size!='default'):?>background-size:<?php print $size; endif;?>}
		<?php 

		$cssline=ob_get_contents();
		ob_end_clean();

		return $cssline;
	}
}

if(! function_exists('get_redux_custom_topbar')){

	function get_redux_custom_topbar($args){

		$cssline = "";

		if (is_array($args['topbar-background-color'])) {
			if ($args['topbar-background-color']['color']=='transparent') {
				$cssline .= "#top-bar {background-color: rgba(255,255,255,0);}";
			} else {
				$colourstr = $args['topbar-background-color']['color'];
				$colourstr = str_replace('#','',$colourstr);
		      	$rhex = substr($colourstr,0,2);
		      	$ghex = substr($colourstr,2,2);
		      	$bhex = substr($colourstr,4,2);

		      	$r = hexdec($rhex);
		      	$g = hexdec($ghex);
		      	$b = hexdec($bhex);

		      	$a = $args['topbar-background-color']['alpha'];

		      	$cssline .= "#top-bar {background-color: rgba(".$r.",".$g.",".$b.",".$a.");}";
			}
		} 

		$cssline.="#top-bar {color:".$args['topbar-font-color'].";}";
		$cssline.="#top-bar a {color:".$args['topbar-font-color'].";}";

		return $cssline;
	}
}

if(!function_exists('detheme_style_compile')){

function detheme_style_compile($cleanco_config=array(),$css=""){

	global $wp_filesystem;

	if(function_exists('icl_register_string')){
		icl_register_string('cleanco', 'left-top-bar-text', $detheme_config['dt-left-top-bar-text']);
		icl_register_string('cleanco', 'right-top-bar-text', $detheme_config['dt-right-top-bar-text']);
		icl_register_string('cleanco', 'footer-text', $detheme_config['footer-text']);
	}


	$cssline=(isset($cleanco_config['primary-color']) && '#f58e03'!=$cleanco_config['primary-color'])?get_redux_custom_primary_color($cleanco_config['primary-color']):"";
	$cssline.=(isset($cleanco_config['primary-font'])  && ''!=$cleanco_config['primary-font'])?get_redux_custom_primary_font($cleanco_config['primary-font']):"";
	$cssline.=get_redux_custom_heading_text($cleanco_config);
	$cssline.=(isset($cleanco_config['secondary-color']) && '#f58e03'!=$cleanco_config['secondary-color'])?get_redux_custom_secondary_color($cleanco_config['secondary-color']):"";


	$cssline.=(isset($cleanco_config['section-font']) && ''!=$cleanco_config['section-font']['font-family'])?get_redux_custom_section_font($cleanco_config['section-font']):"";

	$cssline.=(isset($cleanco_config['tertiary-font']) && ''!=$cleanco_config['tertiary-font']['font-family'])?get_redux_custom_tertiary_font($cleanco_config['tertiary-font']['font-family']):"";
	$cssline.=get_redux_custom_footer($cleanco_config);
	$cssline.=get_redux_custom_header($cleanco_config);
	$cssline.=get_redux_body_style($cleanco_config);
	$cssline.=get_redux_boxed_layout($cleanco_config);
	$cssline.=get_redux_topbar($cleanco_config);


	$cssline.=(isset($cleanco_config['dt-header-type']) && 'leftbar'==$cleanco_config['dt-header-type'])?get_redux_leftbar_menu($cleanco_config['dt-menu-image'],$cleanco_config['dt-menu-image-horizontal'],$cleanco_config['dt-menu-image-vertical'],$cleanco_config['dt-menu-image-size']):"";
	$cssline.=(isset($cleanco_config['dt-menu-height']))?get_redux_custom_menu_height($cleanco_config['dt-menu-height']):"";
	$cssline.=(isset($cleanco_config['dt-logo-top-padding']))?get_redux_custom_menu_margin_top($cleanco_config['dt-logo-top-padding']):"";
	$cssline.=(isset($cleanco_config['dt-logo-top-margin-reveal']))?get_redux_custom_logo_margin_top_reveal($cleanco_config['dt-logo-top-margin-reveal']):"";

	if(isset($cleanco_config['heading-style']) && $cleanco_config['heading-style']!=='none'){
		$cssline.="h1,h2,h3,h4,h5,h6{text-transform:".$cleanco_config['heading-style']."}";
	}

	$cssline.=(isset($cleanco_config['css-code']) && !empty($cleanco_config['css-code']))?'
	/* custom css generate from your custom css code*/
	'.$cleanco_config['css-code']:"";	

	$cssline.=(isset($cleanco_config['topbar-background-color']))?get_redux_custom_topbar($cleanco_config):"";

	$blog_id="";
	if ( is_multisite()){
		$blog_id="-site".get_current_blog_id();
	}

	$filename = get_template_directory() . '/css/customstyle'.$blog_id.'.css';
	
	ob_start();
	?>
/* ================================================ */
/* don't touch this style auto generating by system */
/* ================================================ */
<?php
	$notes=ob_get_contents();
	ob_end_clean();

	if ( !$wp_filesystem->put_contents( $filename, $notes.$cssline) ) {
		$error = $wp_filesystem->errors;

		if('empty_hostname'==$error->get_error_code()){

			$wp_filesystem=new WP_Filesystem_Direct(array());

			if($wp_filesystem){

				if(!$wp_filesystem->put_contents( $filename, $notes.$cssline)){
					return $css;
				}

			}else{
				return $css;
			}


		}else{

			return $css;
		}
	}
	return $css.$cssline;

}
}

if(!function_exists('cleanco_save_license')){


function cleanco_save_license($config=array()){

	$template=get_template();
	update_option("cleanco_license_$template",$config['cleanco_license']);
}

}

add_action( 'redux-saved-cleanco_config' ,'cleanco_save_license' ); 
add_action('redux-compiler-cleanco_config','detheme_style_compile',2);

if(!function_exists('load_cleanco_admin_script')){

function load_cleanco_admin_script(){
	wp_enqueue_script('detheme-admin-script', DethemeReduxFramework::$_url. 'assets/js/dashboard.js',array('jquery'));
}
}
add_action( 'redux/page/cleanco_config/enqueue','load_cleanco_admin_script' );
add_action('theme_option_name_update','detheme_style_compile');

function cleanco_update_complete($theme,$hook_extra){

	if('theme'==$hook_extra['type'] && 'update'==$hook_extra['action'] && $theme->skin->theme == get_template()){
		$option_name=apply_filters('theme_option_name','cleanco_config');
		$theme_config=get_option($option_name);
		do_action('theme_option_name_update',$theme_config);
	}
}

add_action('upgrader_process_complete','cleanco_update_complete',1,2);

function get_cleanco_options(){

	global $DethemeReduxFramework;

	if(!is_object($DethemeReduxFramework)){

      $DethemeReduxFramework= new DethemeReduxFramework();
	
	    $args['opt_name']           = 'cleanco_config'; 
	    $args['database']           = ''; 
	    $args['global_variable']    = '';

	    $DethemeReduxFramework->args= $args;
	}

	$theme_config=$DethemeReduxFramework->get_options();

	$new_theme_config=apply_filters('detheme_options_config',$theme_config);

	return $new_theme_config;

}


function get_cleanco_option($key="",$default=false){
	$options=get_cleanco_options();
	if(isset($options[$key]))
		return $options[$key];
	return $default? $default : false;
}
?>