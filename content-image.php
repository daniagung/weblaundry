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

	$imageurl = "";

	/* Get Image from featured image */
	$thumb_id=get_post_thumbnail_id($post->ID);
	$featured_image = wp_get_attachment_image_src($thumb_id,'full',false); 
	$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
	if (isset($featured_image[0])) {
		$imageurl = $featured_image[0];
	} else {
		$imageurl = get_first_image_url_from_content();
	}
	
	/* Get Image from content image */
	$pattern = get_shortcode_regex();
	preg_match_all( '/'. $pattern .'/s', get_the_content(), $matches );
	/* find first caption shortcode */


	$i = 0;
	$hascaption = false;
	foreach ($matches[2] as $shortcodetype) {
		if ($shortcodetype=='caption') {
			$hascaption = true;
			break;
		}
	    $i++;
	}

	if ($hascaption and empty($imageurl)) {
		preg_match('/^<a.*?href=(["\'])(.*?)\1.*$/', $matches[5][$i], $m);
		$imageurl = $m[2];
	}
?>

		<div class="row">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
	if ($imageurl!="") {
?>											
				<div class="col-xs-12">
					<div class="postimagecontent">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(the_title('','',false));?>"><img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>" /></a>

					</div>

					<?php locate_template('pagetemplates/postinfo.php',true,false); ?>
					<h4 class="blog-post-title"><a href="<?php the_permalink(); ?>" class="heading_text_color"><?php the_title();?></a></h4>

				</div>
<?php
	} 
?>
				<div class="col-xs-12">
<?php 

	if (is_single()) : 

 		locate_template('pagetemplates/postmetabottom_detail.php',true,false); 
 		locate_template('pagetemplates/aboutauthor.php',true,false);
 		if(comments_open() && get_cleanco_option('dt-comment-open','')==1):?>
					<div class="comment-count">
						<h3 class="heading_text_color"><?php comments_number(__('No Comments','cleanco'),__('1 Comment','cleanco'),__('% Comments','cleanco')); ?></h3>
					</div>
					<div class="section-comment">
						<?php comments_template('/comments.php', true); ?>
					</div><!-- Section Comment -->
<?php 	endif;  ?>
<?php 
	else : 
		locate_template('pagetemplates/postmetabottom.php',true,false);
	endif; ?>

				</div> <!--div class="col-xs-12"--> 
			</article>
		</div><!--div class="row"-->