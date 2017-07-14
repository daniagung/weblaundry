<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content post gallery
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */
?>

<?php 
	$colsm = '';
	global $more, $hasgallery;
	$more = 1;
	$sharepos = 'sharepos';
?>

<?php if (is_single()) :

	$content=get_the_content();
	//Find video shotcode in content
	$pattern = get_shortcode_regex();

	$hasgallery = false;

	$content=preg_replace_callback('/'. $pattern .'/s',
		function($matches){

			global $hasgallery;
			static $id = 0;
			$id++;

			if($matches[2]=='gallery') {

				if($id==1){
					$hasgallery=$matches[3];
				}

			}
			else{
				return $matches[0];
			}
			return " ";

		}
	,$content,-1,$matches_count);


	$content = apply_filters( 'the_content', do_shortcode($content));
	$content = str_replace( ']]>', ']]&gt;', $content );
?>

				<div class="row">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="col-xs-12">

						<?php	if ( $hasgallery ) { ?>
							<div class="postimage">
						<?php 						

							$gallery_shortcode_attr = shortcode_parse_atts($hasgallery);
							$attachment_image_ids = explode(',',$gallery_shortcode_attr['ids']);
						?>
								<div id="gallery-carousel-<?php echo intval(get_the_ID()); ?>" class="carousel slide post-gallery-carousel" data-ride="carousel" data-interval="3000">
							        <div class="carousel-inner">
						<?php
							$i = 0;
							foreach ($attachment_image_ids as $attachment_id) {
    							$attached_img = wp_get_attachment_image_src($attachment_id,'large');
    							$alt_image = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
						?>
										<div class="item <?php echo ($i==0) ? 'active' : ''; ?>"><img src="<?php echo esc_url($attached_img[0]); ?>" alt="<?php print esc_attr($alt_image);?>" /></div>
						<?php
								$i++;
							}
						?>
					        		</div><!--div class="carousel-inner"-->

									<div class="post-gallery-carousel-nav">
										<div class="post-gallery-carousel-buttons">
									        <a class="btn skin-light circle_border" href="#gallery-carousel-<?php echo intval(get_the_ID()); ?>" data-slide="prev">
									          <span><i class="icon-angle-left"></i></span>
									        </a>
									        <a class="btn skin-light circle_border" href="#gallery-carousel-<?php echo intval(get_the_ID()); ?>" data-slide="next">
									          <span><i class="icon-angle-right"></i></span>
									        </a>
								    	</div>
							    	</div>
							    </div>			
							</div>
						<?php		$sharepos = '';
								} //if ( has_shortcode( get_the_content(), 'gallery' ) )?> 

							<?php locate_template('pagetemplates/postinfo.php',true,false); ?>
							<h4 class="blog-post-title heading_text_color"><?php the_title();?></h4>

							<div class="postcontent">
		                		<?php print $content;?>
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


<?php else : //if (is_single()) :

	$more = 0;


	$content=get_the_content(' ');
	//Find video shotcode in content
	$pattern = get_shortcode_regex();

	$hasgallery = false;

	$content=preg_replace_callback('/'. $pattern .'/s',
		function($matches){

			global $hasgallery;
			static $id = 0;
			$id++;

			if($matches[2]=='gallery') {

				if($id==1){
					$hasgallery=$matches[3];
				}

			}
			else{
				return $matches[0];
			}
			return " ";

		}
	,$content,-1,$matches_count);

	

	$content = apply_filters( 'the_content', remove_shortcode_from_content($content));
	$content = str_replace( ']]>', ']]&gt;', $content );

?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	if ( $hasgallery ) { 
?>
				<div class="col-xs-12">
					<div class="postimage">
						<?php 						
							$gallery_shortcode_attr = shortcode_parse_atts($hasgallery);
							$attachment_image_ids = explode(',',$gallery_shortcode_attr['ids']);
?>

						<div id="gallery-carousel-<?php echo intval(get_the_ID()); ?>" class="carousel slide post-gallery-carousel" data-ride="carousel" data-interval="3000">
					        <div class="carousel-inner">
<?php
							$i = 0;
							foreach ($attachment_image_ids as $attachment_id) {
    							$attached_img = wp_get_attachment_image_src($attachment_id,'large');
    							$alt_image = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
?>
								<div class="item <?php echo ($i==0) ? 'active' : ''; ?>"><img src="<?php echo esc_url($attached_img[0]); ?>" alt="<?php print esc_attr($alt_image);?>" /></div>
<?php
								$i++;
							}
?>
					        </div>

							<div class="post-gallery-carousel-nav">
								<div class="post-gallery-carousel-buttons">
							        <a class="btn skin-light circle_border" href="#gallery-carousel-<?php echo intval(get_the_ID()); ?>" data-slide="prev">
							          <span><i class="icon-angle-left"></i></span>
							        </a>
							        <a class="btn skin-light circle_border" href="#gallery-carousel-<?php echo intval(get_the_ID()); ?>" data-slide="next">
							          <span><i class="icon-angle-right"></i></span>
							        </a>
						    	</div>
					    	</div>
					    </div>			
					</div>
				</div>
<?php
		$colsm = 'col-sm-push-2 col-md-push-0 margin_top_40_max_sm';
	} 
?> 
				<div class="col-xs-12 <?php echo esc_attr($colsm);?>">
					<div class="postcontent">

						<?php locate_template('pagetemplates/postinfo.php',true,false); ?>

						<h4 class="blog-post-title"><a href="<?php the_permalink(); ?>" class="heading_text_color"><?php the_title();?></a></h4>

						<?php
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