<?php
defined('ABSPATH') or die();
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<?php require_once( get_template_directory().'/lib/page-options.php');?>
<head>
<?php wp_head(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
</head>

<?php
switch (get_cleanco_option('dt-header-type')) {
    case 'center':
    	$classmenu = 'menu-center';
        break;
    case 'right' :
        $classmenu = 'menu-left';
        break;
    case 'leftbar' :
        $classmenu = 'menu-leftbar';
        break;
    case 'middle' :
        $classmenu = 'menu-middle';
        break;
    case 'leftvc' :
        $classmenu = 'menu-leftvc';
        break;
    default:
        $classmenu = 'menu-right';
}

?>

<body <?php body_class(is_cleanco_home(get_post())?"home dt_custom_body " . esc_attr($classmenu):"dt_custom_body " . esc_attr($classmenu)); print get_cleanco_option('body_tag',''); ?>>
<?php if(get_cleanco_option('page_loader') && !is_404()):?>
<div class="modal_preloader"></div>
<?php endif;?>

<?php if(!is_404()): 
	/*** Boxed layout ***/
	$boxed_open_tag = "";
	$boxed_close_tag = "";
	$is_vertical_menu = false;
	$is_boxed = false;
	if(get_cleanco_option('boxed_layout_activate')){
		$is_boxed = true;

		if (get_cleanco_option('dt-header-type','')=='leftbar') {
			$is_vertical_menu = true;
			$boxed_open_tag = '<div class="vertical_menu_container"><div class="container dt-boxed-container">';
			$boxed_close_tag = '</div></div>';
		} else {
			$boxed_open_tag = '<div class="container dt-boxed-container">';
			$boxed_close_tag = '</div>';
		}
	}

	if ($is_boxed and !$is_vertical_menu) echo $boxed_open_tag; 
?>

<?php locate_template('pagetemplates/top-bar.php',true); ?>

<input type="checkbox" name="nav" id="main-nav-check">	
<div class="top-head<?php  print is_admin_bar_showing()?" adminbar-is-here":"";?><?php print get_cleanco_option('showtopbar')?" topbar-here":"";?><?php print get_cleanco_option('dt-sticky-menu','') ? " is-sticky-menu":" no-sticky-menu";?> 
	<?php print get_cleanco_option('dt-header-type','')=='leftbar'?" vertical_menu":"";?>">

<?php if($showheader=get_cleanco_option('dt-show-header')): 
	locate_template('pagetemplates/heading.php',true);?>
<?php endif;?>
</div>
<?php

	if ($is_boxed and $is_vertical_menu and !is_404()) echo $boxed_open_tag; 
 
endif; //if(!is_404())?>


<?php
if($showbanner=get_cleanco_option('show-banner-area','') && !is_404()){
	//if not homepage
	if (!is_cleanco_home(get_post())) {
		locate_template('pagetemplates/banner.php',true);
	} else { //if homepage
		if (get_cleanco_option('show-banner-home')) {
			locate_template('pagetemplates/banner.php',true);
		}
	}
	
}



?>

