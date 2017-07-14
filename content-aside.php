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
		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php 
	global $more;
?>											

				<div class="col-xs-12">
					<div class="postcontent">
						<?php locate_template('pagetemplates/postinfo.php',true,false); ?>
<?php if (is_single()) : ?>
						<h4 class="blog-post-title heading_text_color"><?php the_title();?></h4>
						<?php the_content();?>
<?php else : ?>
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
<?php endif; ?>
					</div>
<?php if (is_single()) : ?>
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
<?php else : //if (is_single())?>
					<?php locate_template('pagetemplates/postmetabottom.php',true,false); ?>
<?php endif; //if (is_single())?>
				</div> 
			</article>
		</div><!--div class="row"-->
