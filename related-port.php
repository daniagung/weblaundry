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
 * @since Cleanco 1.0
 */
global $cleanco_revealData;

$imageId=get_post_thumbnail_id(get_the_ID());
$featured_image = wp_get_attachment_image_src( $imageId,'full',false);
$alt_image = get_post_meta($imageId, '_wp_attachment_image_alt', true);
$term_lists=array();
$terms = get_the_terms( get_the_ID(), 'post_tag' );

if ( !empty( $terms ) ) {
      
      foreach ( $terms as $term ) {
        $cssitem[] =sanitize_html_class($term->slug, $term->term_id);
        $term_lists[]="<span class=\"portfolio-term\">".$term->name."</span>";
      }

}

if ($featured_image) {
			$imgurl = aq_resize($featured_image[0], 400, 400,true);
}

?>
<div class="col-xs-3 related-port portfolio-item">
	<figure>
		<?php if($featured_image):?>
		<div class="top-image">
			<img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php print ($imgurl)?esc_url($imgurl):esc_url($featured_image[0]);?>" title=""/>
		</div>
	<?php endif;?>
		<figcaption class="tertier_color_bg_transparent">
<?php if(count($term_lists)):?>
			<div class="related-tag"><?php print (count($term_lists))?@implode(', ',$term_lists):"";?></div>
<?php endif;?>
			<h2 class="related-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
		</figcaption>
		
	</figure>
</div>
