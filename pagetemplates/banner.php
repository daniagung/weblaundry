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
 * @subpackage Buffer
 * @since Buffer 1.0
 */

$vertical_menu_container_class = get_cleanco_option('dt-header-type','')=='leftbar' ? " vertical_menu_container":"";
$homepage_title = (get_option('page_on_front') > 0) ? get_the_title(get_option('page_on_front')) : esc_html__('Home','cleanco');
?>

<section id="banner-section" class="<?php echo sanitize_html_class($vertical_menu_container_class); ?>">
<div class="container subtitle">
	<div class="row">
		<div class="col-xs-12">
<?php 	if(get_cleanco_option('dt-show-banner-title')) {?>
		<div class="banner-title">
		<h1 class="page-title"><?php print get_cleanco_option('page-title',''); ?></h1>
		</div>
<?php 
		}
?>
<?php 
if(get_cleanco_option('dt-show-breadcrumb')):
	detheme_dimox_breadcrumb(array(
		'delimiter' => is_rtl()?'&nbsp;\&nbsp;':'&nbsp;/&nbsp;',
		'home_text' => $homepage_title 
	));
endif;
?>
		</div>
	</div>
</div>
</section>