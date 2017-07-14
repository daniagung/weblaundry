<?php
defined('ABSPATH') or die();
/**
 * Template Name: Woocommerce Page
 *
 * Used for single page.
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */

get_header();?>
<?php 

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['shop-sidebar']) && count($sidebars['shop-sidebar'])){
	$sidebar='shop-sidebar';

}


$sidebar_position = get_post_meta( get_the_ID(), '_sidebar_position', true );

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
$vertical_menu_container_class = get_cleanco_option('dt-header-type','')=='leftbar' ? " vertical_menu_container":"";
?>

<div <?php post_class('content '.sanitize_html_class($vertical_menu_container_class)); ?>>
<div class="<?php echo sanitize_html_class($class_sidebar);?>">
	<div class="container">
<?php 
		do_action( 'woocommerce_before_main_content' );
?>
		<div class="row">
		<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
		<?php	} else { ?>
			<div class="col-xs-12 col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
		<?php	} ?>
<?php if(get_cleanco_option('dt-show-title-page')):?>
						<h2 class="post-title"><?php the_title();?></h2>
<?php endif;?>

<?php 
while ( have_posts() ) : 
the_post();
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<div class="postcontent">
							<?php the_content(); ?>
						</div>
					</div>
				</div>

			</article>
<?php endwhile;?>
			</div>

		<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-xs-12 col-sm-4 col-md-3 sidebar">
				<?php get_sidebar(); ?>
			</div>
		<?php }
		elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-xs-12 col-sm-4 col-md-3 sidebar col-sm-pull-8 col-md-pull-9">
				<?php get_sidebar(); ?>
			</div>
		<?php }?>
<?php
		do_action( 'woocommerce_after_main_content' );
?>
	</div><!-- .container -->
	</div>
</div><!-- .woocommerce -->
</div>
<?php
get_footer();
?>

