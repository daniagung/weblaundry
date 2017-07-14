<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content link
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
	} 
?>		

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="col-xs-12">
					<div class="postinfo">
						<ul class="list-inline">
							<li><?php locate_template('pagetemplates/social-share.php',true,false); ?></li>
						</ul>
					</div>

					<div class="postcontent postcontent-link primary_color_bg" <?php echo strip_tags($bgstyle); ?>>
						<h4 class="blog-post-title"><a href="<?php echo esc_url(get_the_content()); ?>" target="_blank" class="heading_text_color"><?php the_title();?></a></h4>
						<?php the_content(); ?>
					</div>

					<div class="postmetabottom"><div class="postborder"></div></div>
				</div>
			</article>
		</div><!--div class="row"-->