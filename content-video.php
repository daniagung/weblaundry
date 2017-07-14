<?php
defined('ABSPATH') or die();
/**
 * The default template for displaying content video post format
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */
?>

<?php 
	global $more, $cleanco_revealData, $hasyoutubelink,$hasvideoshortcode;
	$more = 1;

	$colsm = 'col-sm-11';
	//$nohead = 'nohead';
	$nohead = '';

	$imageurl = $alt_image = "";
	$sharepos = 'sharepos';

	/* Get Image from featured image */
	if (isset($post->ID)) {
		$thumb_id=get_post_thumbnail_id($post->ID);
		$featured_image = wp_get_attachment_image_src($thumb_id ,'full',false); 
		if (isset($featured_image[0])) {
			$imageurl = $featured_image[0];
		}

		$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
	}
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
		} //if ($imageurl!="")
?>						
							<?php locate_template('pagetemplates/postinfo.php',true,false); ?>
							<h4 class="blog-post-title heading_text_color"><?php the_title();?></h4>

							<div class="postcontent">
								<?php the_content(); ?>
							</div>

							<?php locate_template('pagetemplates/postmetabottom_detail.php',true,false); ?>
							<?php locate_template('pagetemplates/aboutauthor.php',true,false); ?>

<?php if(comments_open() && get_cleanco_option('dt-comment-open','')==1):?>
							
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


<?php else : //if (is_single()) 

	$hasvideoshortcode = false;
	$more = 0;

	$content=$originalcontent=get_the_content(' ');
	//Find video shotcode in content
	$pattern = get_shortcode_regex();

	$shortcodepos = -1;
	$content=preg_replace_callback('/'. $pattern .'/s',
		function($matches){

			global $hasvideoshortcode;
			static $id = 0;
			$id++;

			if($matches[2]=='video') {

				if($id==1){
					$hasvideoshortcode=$matches[0];
				}

			}
			else{
				return $matches[0];
			}
			return " ";

		}
	,$content,-1,$matches_count);

	if($hasvideoshortcode){
		$shortcodepos = strpos($originalcontent,$hasvideoshortcode);
	}

	//Find youtube/vimeo link in content
	$hasyoutubelink = false;
	$youtubepos = -1;

	$content=preg_replace_callback('@https?://(www.)?(youtube|vimeo)\.com/(watch\?v=)?([a-zA-Z0-9_-]+)@im',
		function($matches){

			global $hasyoutubelink;

			static $id = 0;
	        $id++;
			if($id==1){
				$hasyoutubelink=$matches[0];
			}
			return " ";

		}
	,$content,-1,$matches_count);

	if($hasyoutubelink){
		$youtubepos = strpos($originalcontent,$hasyoutubelink);
	}

	$content = apply_filters( 'the_content', remove_shortcode_from_content($content));
	$content = str_replace( ']]>', ']]&gt;', $content );

	?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php  if ($hasvideoshortcode or $hasyoutubelink) { ?>											
				<div class="col-xs-12">
					<div class="postimage">
                		<?php
                			//Display first video 
                			if ($hasvideoshortcode and $hasyoutubelink) {
                				if ($shortcodepos<$youtubepos) {
                					echo do_shortcode($hasvideoshortcode);
                				} else {
	                				echo '<div class="flex-video">';
	                				echo wp_oembed_get($hasyoutubelink);
	                				echo '</div>';
                				}
                			} elseif ($hasyoutubelink) {
                				echo '<div class="flex-video">';
                				echo wp_oembed_get($hasyoutubelink);
                				echo '</div>';
                			} else {
                				echo do_shortcode($hasvideoshortcode);
                			} 
                		?>
					</div>
				</div>
			<?php
					$colsm = 'col-sm-push-2 col-md-push-0 margin_top_40_max_sm';
					} elseif ($imageurl!="") { //if ($hasvideoshortcode or $hasyoutubelink)
?>
				<div class="col-xs-12">
					<div class="postimagecontent">
						<a href="<?php the_permalink(); ?>" title="<?php esc_attr(the_title("","",false));?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>" /></a>

						<?php locate_template('pagetemplates/postinfo.php',true,false); ?>

					</div>
				</div>
<?php
						$colsm = 'col-sm-10 col-sm-push-2 col-md-5 col-md-push-0 col-lg-6 margin_top_40_max_sm';
					} //if ($hasvideoshortcode or $hasyoutubelink) ?>						
				<div class="col-xs-12 <?php echo sanitize_html_class($colsm);?>">
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