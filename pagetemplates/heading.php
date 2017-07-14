<?php
defined('ABSPATH') or die();
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */

$headerType=get_cleanco_option('dt-header-type','');


switch ($headerType) {
    case 'center':
    	$classmenu = 'dt-menu-center';
        $walker = new dt_mainmenu_walker();
        break;
    case 'right' :
        $classmenu = 'dt-menu-left';
        $walker = new dt_mainmenu_walker();
        break;
    case 'leftbar' :
        $classmenu = 'dt-menu-leftbar';
        $walker = new dt_mainmenu_walker();
        break;
    case 'middle' :
        $classmenu = 'dt-menu-middle';
        $walker = new dt_mainmenu_walker();
        break;
    case 'leftvc' :
        $classmenu = 'dt-menu-leftvc';
        $walker = new dt_mainmenu_walker();
        break;
    default:
        $classmenu = 'dt-menu-right';
        $walker = new dt_mainmenu_walker();
}


$menuParams=array(
    'theme_location' => 'primary',
    'echo' => false,
    'container_class'=>$classmenu,
    'container_id'=>'dt-menu',
    'menu_class'=>'',
    'container'=>'div',
    'before' => '',
    'after' => '',
    'fallback_cb'=>false,
    'walker'  => $walker
);


if(($mainmenu = get_cleanco_option('dt-main-menu',''))!=''){
    $menuParams['menu'] =$mainmenu;
}

$menu=wp_nav_menu($menuParams);

if(!$menu){
    $menuParams['fallback_cb']='wp_page_menu';
    $menuParams['theme_location']='';
    $menu=wp_nav_menu($menuParams);
}

$logo = get_cleanco_option('dt-logo-image');
$logo_url=isset($logo['url']) ? $logo['url'] : "";

$logo_transparent = get_cleanco_option('dt-logo-image-transparent');
$logo_transparent_url=isset($logo_transparent['url']) ? $logo_transparent['url'] : "";



$logoContent="";
$logoContentMobile="";
$logoText=get_cleanco_option('dt-logo-text','');
$logowidth=($width=get_cleanco_option('logo-width')) ? " width=\"".intVal($width)."\"":"";

if(!empty($logo_url)){
  $logoContent='<a href="'.esc_url(home_url()).'" style=""><img id="logomenu" src="'.esc_url(detheme_maybe_ssl_url($logo_url)).'" rel="'.esc_url(detheme_maybe_ssl_url($logo_transparent_url)).'" alt="'.esc_attr($logoText).'" class="img-responsive halfsize" '.esc_attr($logowidth).'></a>';
  $logoContent.='<a href="'.esc_url(home_url()).'" style=""><img id="logomenureveal" src="'.esc_url(detheme_maybe_ssl_url($logo_transparent_url)).'" alt="'.esc_attr($logoText).'" class="img-responsive halfsize" '.esc_attr($logowidth).'></a>';

  $logoContentMobile='<a href="'.esc_url(home_url()).'" style=""><img id="logomenumobile" src="'.esc_url(detheme_maybe_ssl_url($logo_url)).'" rel="'.esc_url(detheme_maybe_ssl_url($logo_transparent_url)).'" alt="'.esc_attr($logoText).'" class="img-responsive halfsize" '.esc_attr($logowidth).'></a>';
  $logoContentMobile.='<a href="'.esc_url(home_url()).'" style=""><img id="logomenurevealmobile" src="'.esc_url(detheme_maybe_ssl_url($logo_transparent_url)).'" alt="'.esc_attr($logoText).'" class="img-responsive halfsize" '.esc_attr($logowidth).'></a>';
} else{
  $logoContent=(!empty($logoText))?'<a class="navbar-brand-desktop" href="'.esc_url(home_url()).'">'.$logoText.'</a>':"";
  $logoContentMobile = $logoContent; 
}


$sticky_menu = "";
if (get_cleanco_option('dt-sticky-menu')) {
    $sticky_menu = "alt reveal";
}

$hasTopBar = "notopbar";
if (get_cleanco_option('showtopbar')) {
    $hasTopBar = "hastopbar";
}

if(is_front_page() || is_cleanco_home(get_post())){
    $backgroundType = get_cleanco_option("homepage-background-type","transparent");
} else {
    $backgroundType = get_cleanco_option("header-background-type","transparent");
}

$menu_separator_type = get_cleanco_option("layout-menu-separator","menu_separator_type_1");


?>
<div id="head-page" class="head-page<?php  print is_admin_bar_showing()?" adminbar-is-here":" adminbar-not-here";?> <?php print esc_attr($sticky_menu); ?> <?php print sanitize_html_class($hasTopBar); ?> <?php print sanitize_html_class($backgroundType); ?>">

    <div class="menu_separator <?php print($menu_separator_type); ?>">
        <div class="menu_separator_space menu_background_color"></div>
<?php
        switch ($menu_separator_type) {
            case 'menu_separator_type_1':
?>
                <svg class="separator_type_5_path" preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 30 L50 100 L100 30 L100 100 L0 100 Z" fill="rgba(255,255,255,0)" class="menu_separator_background_color" />
                    <path d="M0 0 L0 30 L50 100 L100 30 L100 0 Z" fill="#ffffff" class="menu_background_color" />
                    <path d="M0 30 L50 100 L100 30" fill="none" stroke="#b5cbd9" stroke-width="0.5" class="menu_separator_border_color" />
                </svg>
<?php
            break;
          case 'menu_separator_type_2':
?>
            <svg class="separator_type_2_path" preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 50 L46 50 L50 100 L54 50 L100 50 L100 101 L0 101 Z" fill="rgba(255,255,255,0)" />
                <path d="M0 50 L46 50 M54 50 L100 50" fill="none" stroke="#0000ff" stroke-width="0.5" class="menu_separator_border_color" />
                <path d="M46 50 L50 100 L54 50" fill="none" stroke="#0000ff" stroke-width="0.1" class="menu_separator_border_color" />
                <path d="M0 0 L0 50 L46 50 L50 100 L54 50 L100 50 L100 0 Z" fill="#ffffff" class="menu_background_color" />
            </svg>
<?php
            break;
          default:
        } 
?>

    </div>

<?php
    if ($headerType=='leftvc') :
?>


    <div class="container flex-container nopadding">
        <div class="flex-item col-sm-12 col-md-3 nopadding logo-container logo_bgcolor"><?php print detheme_get_logo_content(); ?></div>
        <div class="flex-item col-sm-12 col-md-9 nopadding">
            <div class="col-xs-12 nav_buttons nav_buttons_bgcolor"><?php do_action('detheme_load_vc_nav_buttons'); ?></div>
            <div class="col-xs-12 nav_bgcolor nopadding">
<?php 
        if ($menu):
            //$menuParams['container_class'] = $classmenu . ' visible-sm-max';
            $menu=wp_nav_menu($menuParams);
            print $menu;
        else:
            wp_nav_menu();
        endif;  
?>
                </div>
        </div>
    </div>

    <div class="nav_bgcolor hidden-sm-max">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="mobile-header">
                        <label for="main-nav-check" class="toggle" onclick="" title="<?php _e('Menu','cleanco');?>"><i class="icon-menu"></i></label>
                    </div><!-- closing "#header" -->
                </div>
            </div>
        </div>
    </div>
<?php
    else: //if ($headerType=='leftvc')
?>
    <div class="container">
<?php 
        if ($menu):
            print $menu;
        else:
            wp_nav_menu();
        endif;  
?>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="mobile-header" class="hidden-sm-max">
                    <label for="main-nav-check" class="toggle" onclick="" title="<?php _e('Menu','cleanco');?>"><i class="icon-menu"></i></label>
                    <?php echo $logoContentMobile ?>
                </div><!-- closing "#header" -->
            </div>
        </div>
    </div>

<?php
    endif; 
?>
</div>

<?php
    if ($headerType=='leftvc') :
        if ($menu):
            $menuParams['container_class'] = $classmenu . ' dt-menu-mobile';
            $menuParams['container_id'] = 'dt-menu-mobile';
            
            $menu=wp_nav_menu($menuParams);
            print $menu;
        else:
            wp_nav_menu();
        endif;  
    endif; 
?>
