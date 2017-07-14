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

global $wp_query,$paged,$posts_per_page;


get_header();?>
<?php 
$sidebars=wp_get_sidebars_widgets();
$sidebar=false;
if(isset($sidebars['detheme-sidebar']) && count($sidebars['detheme-sidebar'])){
	$sidebar='detheme-sidebar';
}

if(is_home() && $post_id=get_option( 'page_for_posts')){

}
else{
	$post_id=get_the_ID();
}

$sidebar_position = get_post_meta( $post_id, '_sidebar_position', true );
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
$class_sidebar = " ".$sidebar_position;
$vertical_menu_container_class = get_cleanco_option('dt-header-type','')=='leftbar' ? " vertical_menu_container":"";
?>

<div <?php post_class('content '.sanitize_html_class($class_sidebar).$vertical_menu_container_class);?>>
	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-xs-12">
<?php	} else { ?>
			<div class="col-xs-12 col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>
<?php
				if ( have_posts() ) :

					// Start the Loop.
					$i = 0;
					$reveal_area_class = '';
					while ( have_posts() ) : the_post();
						$i++;
						$reveal_area_class = ($i==1) ? 'blank-reveal-area' : '';
						
						if ($i==1) :
						?>

						<div class="<?php echo esc_attr($reveal_area_class); ?>"></div>

						<?php endif; //if ($i==1)?>
						<?php 



						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */

						get_template_part( 'content', get_post_format() );

						?>

						<div class="clearfix">
							<div class="col-xs-12 postseparator"></div>
						</div>

						<?php 



					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;

?>
<?php locate_template('pagetemplates/pagination.php',true,false); ?>
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
		</div>			
	</div>
</div>

<?php

get_footer();

?>