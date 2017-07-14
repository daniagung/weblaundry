<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */
?>

<?php 
	global $more, $cleanco_revealData;
	$more = 1;

	$imageurl = $alt_image = "";

	/* Get Image from featured image */
	if (isset($post->ID)) {
		$thumb_id=get_post_thumbnail_id($post->ID);
		$featured_image = wp_get_attachment_image_src($thumb_id ,'full',false); 
		if (isset($featured_image[0])) {
			$imageurl = $featured_image[0];
		} 

		$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
	}
	
	$colsm = '';
	//$nohead = 'nohead';
	$nohead = '';
	$sharepos = 'sharepos';
?>

<?php if (is_single()) : ?>

				<div class="row">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="col-xs-12">

<?php	if ($imageurl!="") { ?>											
							<div class="postimagecontent">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(the_title("","",false));?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>" /></a>
							</div>
<?php
			$nohead = '';
			$sharepos = '';
		} 
?>											
							<?php locate_template('pagetemplates/postinfo.php',true,false); ?>
							<h4 class="blog-post-title heading_text_color"><?php the_title();?></h4>
							<div class="postcontent">
		                		<?php
									the_content();
								?>
							</div>

							<?php locate_template('pagetemplates/postmetabottom_detail.php',true,false); ?>
							<?php locate_template('pagetemplates/aboutauthor.php',true,false); ?>

<?php 
if(comments_open() && get_cleanco_option('dt-comment-open','')==1):?>
							<div class="comment-count">
								<h3 class="heading_text_color"><?php comments_number(__('No Comments','cleanco'),__('1 Comment','cleanco'),__('% Comments','cleanco')); ?></h3>
							</div>

							<div class="section-comment">
								<?php comments_template('/comments.php', true); ?>
							</div><!-- Section Comment -->
<?php endif;?>

						</div>

					</article>
				</div><!--div class="row"-->

<?php else : //if (is_single()) :?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	if ($imageurl!="") {
?>											
				<div class="col-xs-12">
					<div class="postimagecontent">

						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(the_title("","",false));?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>" /></a>

					</div>
				</div>
<?php
		$colsm = 'col-sm-push-2 col-md-push-0 margin_top_40_max_sm';
	} //if ($imageurl!="")
?>											

				<div class="col-xs-12 <?php echo sanitize_html_class($colsm);?>">
					<div class="postcontent">

						<?php locate_template('pagetemplates/postinfo.php',true,false); ?>

						<h4 class="blog-post-title"><a href="<?php the_permalink(); ?>" class="heading_text_color"><?php the_title();?></a></h4>
						<?php 
							$more = 0;

							$content=get_the_content(' ');

							$content = apply_filters( 'the_content', remove_shortcode_from_content($content));
							$content = str_replace( ']]>', ']]&gt;', $content );

							if (has_excerpt()) {
								$excerpt = apply_filters('the_excerpt', get_the_excerpt());
								print $excerpt . '<a class="more-link"></a>';	
							} else {
								print $content;
							}

						?>
					</div>

					<?php locate_template('pagetemplates/postmetabottom.php',true,false); ?>

				</div> 
			</article>
		</div><!--div class="row"-->

<?php endif; //if (is_single()) :?>
