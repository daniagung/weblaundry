 <?php
 defined('ABSPATH') or die();
/**
 * Template Name: Portfolio Template
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

get_header();

do_action('dt_portfolio_loaded');

$portfolioCol = get_post_meta( get_the_ID(), '_portfoliocolumn', true );
if(!$portfolioCol) $portfolioCol=3;

$portfoliotype= get_post_meta( get_the_ID(), '_portfoliotype', true );
$sidebar_position= get_post_meta( get_the_ID(), '_sidebar_position', true );

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['detheme-sidebar']) && count($sidebars['detheme-sidebar'])){
	$sidebar='detheme-sidebar';
}

if($portfoliotype=='imagefull'||$portfoliotype=='imagefixheightfull'){
	$sidebar_position="nosidebar";
}

if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){

	switch (get_cleanco_option('layout','')) {
		case 1:
			$sidebar_position = "nosidebar";
			break;
		case 2:
			$sidebar_position = "sidebar-left";
			break;
		case 3:
			$sidebar_position = "sidebar-right";
			break;
		default:
			$sidebar_position = "sidebar-left";
	}


}


if(!$sidebar){
	$sidebar_position = "nosidebar";
}

set_query_var('sidebar',$sidebar);
$class_sidebar = $sidebar_position;
set_query_var('column',$portfolioCol);
?>

<div <?php post_class('content portfolio portfolio-type-'.sanitize_html_class($portfoliotype)); ?>>
<div class="<?php echo sanitize_html_class($class_sidebar);?>">

<?php print ($portfoliotype=='imagefull'||$portfoliotype=='imagefixheightfull')?'':'<div class="container"><div class="row">';?>

<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>
<?php 

if ( have_posts() ) : 
	the_post();

$porttemplates=array();

$porttemplates[]='pagetemplates/portfolio-type-'.$portfoliotype.'.php';
$porttemplates[]='pagetemplates/portfolio-type-image.php';

locate_template(  $porttemplates,true);
endif; ?>
</div>

<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-sm-4 col-md-3 sidebar">
				<?php get_sidebar(); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-sm-4 col-md-3 sidebar col-sm-pull-8 col-md-pull-9">
				<?php get_sidebar(); ?>
			</div>

<?php }?>

<?php print ($portfoliotype=='imagefull'||$portfoliotype=='imagefixheightfull')?'':'</div></div>';?>

	</div><!-- .portfolio -->
</div>

<?php
get_footer();
?>