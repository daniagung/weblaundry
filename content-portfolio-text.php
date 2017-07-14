<?php
defined('ABSPATH') or die();
/**
 *
 * this part from portfolio layout
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */
global $cleanco_revealData;
$terms = get_the_terms(get_the_ID(), 'portcat' );
$cssitem=array();
$term_lists=array();

$thumb_id=get_post_thumbnail_id(get_the_ID());
$featured_image = wp_get_attachment_image_src($thumb_id,'full',false); 
$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

if($featured_image){
	if(!$image=aq_resize($featured_image[0], 400, 200, true, true, true)){
		$image=$featured_image[0];
	}
}

if ( !empty( $terms ) ) {
      
      foreach ( $terms as $term ) {
        $cssitem[] =sanitize_html_class($term->slug, $term->term_id);
        $term_lists[]="<span class=\"portfolio-term\">".$term->name."</span>";
      }

}


?>
<div id="port-<?php print get_the_ID();?>" <?php post_class('portfolio-item '.@implode(' ',$cssitem),get_the_ID()); ?>>
<div class="post-image-container">
	<?php if (isset($image) && !empty($image)) : ?>
	<div class="post-image">
		<img class="img-responsive" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt_image);?>" />
	</div>
	<?php endif;?>
	<div class="imgcontrol tertier_color_bg_transparent"></div>
</div>
	<div class="portfolio-description">
		<div class="portfolio-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></div>
		<div class="portfolio-termlist"><?php print (count($term_lists))?@implode(', ',$term_lists):"";?></div>
		<div class="portfolio-excerpt"><?php the_excerpt();?>
		<a href="<?php echo the_permalink(); ?>" class="read_more" title="<?php echo sanitize_title(sprintf(__( 'Detail to %s', 'cleanco' ), $post->title_attribute)); ?>"><?php print ucfirst(__('read more', 'cleanco')); ?> <i class="icon-right-dir"></i></a>
	</div>
	</div>

</div>