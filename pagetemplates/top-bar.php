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

?>
<div id="top-bar" class="menu_background_color">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php get_template_part( 'pagetemplates/topbar', "left".get_cleanco_option('dt-left-top-bar',''));?>
				<?php get_template_part( 'pagetemplates/topbar', "right".get_cleanco_option('dt-right-top-bar',''));?>
			</div>
		</div>
	</div>
</div>
