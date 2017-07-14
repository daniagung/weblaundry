<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content quote
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */
?>

<?php 
	$bgstyle = '';
	$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full',false); 
	if (isset($featured_image[0])) {
		$bgstyle = ' style="background: url(\''.esc_url($featured_image[0]).'\') no-repeat; background-size: cover;"';
	} //if (isset($featured_image[0]))
?>		


		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="col-xs-12">

					<div class="postinfo">
						<ul class="list-inline">
							<li><?php locate_template('pagetemplates/social-share.php',true,false); ?></li>
						</ul>
					</div>

					<div class="postcontent postcontent-quote primary_color_bg" <?php echo strip_tags($bgstyle); ?>>
						<?php the_content(); ?>
					</div>

					<div class="postmetabottom"><div class="postborder"></div></div>
				</div>


			</article>
		</div><!--div class="row"-->

