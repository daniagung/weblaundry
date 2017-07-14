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
 * @since Cleanco 1.0.0
 */

global $post;



get_header();

do_action('dt_portfolio_loaded');

$sidebar_position = get_detheme_sidebar_position();	
$sidebar= $sidebar_position=='fullwidth' ? "fullwidth": is_active_sidebar( 'detheme-sidebar' )?'detheme-sidebar':false;

if(!$sidebar){
	$sidebar_position = "nosidebar";
}

set_query_var('sidebar',$sidebar);

$class_sidebar = $sidebar_position;
$vertical_menu_container_class = get_cleanco_option('dt-header-type','')=='leftbar' ? " vertical_menu_container":"";

?>
<div <?php post_class('content '.sanitize_html_class($vertical_menu_container_class)); ?>>
<div class="<?php echo sanitize_html_class($class_sidebar);?>">
	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>
<?php 

while ( have_posts() ) : 


the_post();

$content = apply_filters( 'the_content', do_shortcode(get_the_content()));



global $carouselGallery;

?>				<div class="row">
					<div class="col-sm-12">
<?php if(get_cleanco_option('dt-show-title-page')):?>
						<h2 class="page-title"><?php the_title();?></h2>
<?php endif;?>
					<div class="port-article">
						<?php 
							if(isset($carouselGallery) && !empty($carouselGallery)){
								print $carouselGallery;
							} else {
								/* Get Image from featured image */
								$alt_image="";
								if (isset($post->ID)) {
									$thumb_id=get_post_thumbnail_id($post->ID);
									$featured_image = wp_get_attachment_image_src($thumb_id ,'full',false); 
									if (isset($featured_image[0])) {
										$imageurl = $featured_image[0];
									}

									$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
								}

								if ($imageurl!="") {
?>
									<div class="postimagecontent">
										<img class="img-responsive" alt="<?php print esc_attr($alt_image);?>" src="<?php echo esc_url($imageurl); ?>" />
									</div>
<?php
								} //if ($imageurl!="")

							}
						?>
<?php
$linklabel = get_post_meta( get_the_ID(), 'project button label', true );
$linkproject = get_post_meta( get_the_ID(), 'project link', true );

$custom_field_keys = get_post_custom_keys();

$rightContent=array();

foreach ( $custom_field_keys as $key => $value ) {

	if(is_protected_meta($value,'port') || in_array($value,array('project button label','project link')))
        continue;
    $rightContent[]='<li><div class="col-xs-5"><label>'.$value.'</label></div><div class="col-xs-7">'.get_post_meta( get_the_ID(),$value,true).'</div></li>'."\n";

}

?>
<?php if(get_the_tags()):
	$rightContent[]='<li><div class="col-xs-5"><label>'.__('Tags','cleanco').'</label></div><div class="col-xs-7">'.get_the_tag_list('',', ').'</div></li>';
endif;

?>

						<div class="row">
						<?php if(count($rightContent) || !empty($linklabel) || !empty($linkproject)): ?>
							<div class="col-md-8 col-sm-7">
								<h2 class="port-heading"><?php the_title();?></h2>
								<div class="port-decription">
							<?php 
							print $content;
							 ?>
								 </div>
							</div>
							<div class="col-md-4 col-sm-5">
								<h2 class="port-heading"><?php _e('Project Detail','cleanco');?></h2>
								<?php if(count($rightContent)): ?>
								<ul class="port-meta">
									<?php print @implode("\n",$rightContent);?>
									<li class="bottom-line clearfix"></li>
								</ul>
								<?php endif;?>

							<div class="row bottom-meta">
								<div class="col-xs-8">
	<?php
	        if(!empty($linklabel) || !empty($linkproject)):
	?>
	<a class="btn btn-primary link-project primary_color_button" href="<?php print ($linkproject)?esc_url($linkproject):"#";?>" target="_blank"><?php print ($linklabel)?$linklabel:__('launch project','cleanco');?></a>
	<?php endif;?>
								</div>
								<div class="col-xs-4">
									<?php locate_template('pagetemplates/social-share.php',true,false); ?>
								</div>
							</div>


							</div>
								


						<?php else:?>
							<div class="col-md-12 col-sm-12">
								<h2 class="port-heading"><?php _e('Project Description','cleanco');?></h2>
								<div class="port-decription">
							<?php 
							print $content;
							 ?>
								 </div>
								 <?php locate_template('pagetemplates/social-share.php',true,false); ?>
							</div>

						<?php endif;?>
						</div>

						<div class="row">
							<div class="col-xs-12">
<?php 

if(comments_open() && get_cleanco_option('port-comment-open','')==1):?>
							<div class="comment-count">
								<h3><?php comments_number(__('No Comments','cleanco'),__('1 Comment','cleanco'),__('% Comments','cleanco')); ?></h3>
							</div>

							<div class="section-comment">
								<?php //comments_template('/comments.php', true); ?>
							</div><!-- Section Comment -->
<?php endif;?>
							</div>
						</div>
<?php

	$related_args=array(
		'posts_per_page' => 4,
		'post_type' => 'port',
		'no_found_rows' => false,
		'meta_key' => '_thumbnail_id',
		'post_status' => 'publish',
		'orderby' => 'rand',
		'post__not_in'=>array(get_the_ID())
	);


	$related = new WP_Query($related_args);

	if ($related->have_posts()) :?>
<div id="related-port" class="portfolio">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="port-heading"><?php _e('Related Project','cleanco');?></h2>
					<div class="portfolio-container"  data-col="4" data-type="image">
					<?php 
					while ( $related->have_posts() ) : 
						$related->the_post();
						locate_template('related-port.php',true,false);
					?>
					<?php endwhile;
					?>
					</div>
				</div>
			</div>
</div>
	<?php  endif;	?>


					</div>

					</div>
				</div>
<?php endwhile; 
	wp_reset_postdata();
?>
</div>

<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-sm-4 col-md-3 sidebar">
				<?php get_sidebar(); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-sm-4 col-md-3 sidebar col-sm-pull-8 col-md-pull-9">
				<?php get_sidebar(); ?>
			</div>
<?php }?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .blog-single-post -->
</div>
<?php
get_footer();
?>