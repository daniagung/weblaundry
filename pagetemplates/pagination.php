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
<!-- Pagination -->
<div class="row">
	<div class="paging-nav col-xs-12">
<?php
		global $wp_query;

		$big = 999999999; // need an unlikely integer


		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages,
			'prev_text'    => __('<i class="icon-angle-left"></i>'),
			'next_text'    => __('<i class="icon-angle-right"></i>'),

		));

		wp_link_pages();
?>

	</div>
</div>
