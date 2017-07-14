<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 2.0
 */
?>

<div class="row">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="col-xs-12">
			<div class="postcontent">
				<?php
				 if(get_cleanco_option('dt-show-title-page','')):?>
				<h1 class="blog-post-title"><?php print esc_attr(get_cleanco_option('page-title',''));?></h1>
				<?php endif;?>
        		<?php
					the_content();
				?>
			</div>
<?php 
if(comments_open() && get_cleanco_option('dtpost-comment-open','')==1):?>
							<div class="comment-count">
								<h3 class="heading_text_color"><?php comments_number(__('No Comments','cleanco'),__('1 Comment','cleanco'),__('% Comments','cleanco')); ?></h3>
							</div>

							<div class="section-comment">
								<?php comments_template('/comments.php', true); ?>
							</div><!-- Section Comment -->
<?php endif;?>
		</div>

	</article>
</div>
