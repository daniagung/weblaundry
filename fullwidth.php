<?php
defined('ABSPATH') or die();
/**
 * Template Name: Fullwidth
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

global $post;

get_header();
set_query_var('sidebar','nosidebar');
$vertical_menu_container_class = get_cleanco_option('dt-header-type','')=='leftbar' ? " vertical_menu_container":"";
?>
<!-- start content -->
<div <?php post_class('content'.$vertical_menu_container_class); ?>>
<div class="nosidebar">
<?php 
while ( have_posts() ) : 
the_post();
?>
<div class="post-article">
<?php if(get_cleanco_option('dt-show-title-page')):?>
						<h2 class="post-title"><?php the_title();?></h2>
<?php endif;?>
<?php 
	the_content();
 ?>
						</div>
<?php endwhile; ?>
			</div>
	</div>
<!-- end content -->
<?php
get_footer();
?>