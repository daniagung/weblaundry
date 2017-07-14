<?php
defined('ABSPATH') or die();
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */

get_header();

$logo=get_cleanco_option('dt-404-image');
?>

 	<div class="centered">
<?php 
	$logo_url = $logo && isset($logo['url']) ? $logo['url'] : "";
	if(!empty($logo_url)) :
?>
	  	<p><a href="<?php echo esc_url(home_url()); ?>" title=""><img src="<?php echo esc_url($logo_url); ?>" alt="" /></a></p>
<?php
	endif;
?>
 		<p class="biggest"><?php _e('404','cleanco');?></p>
 		<p class="big"><?php _e('Page not found','cleanco');?></p>
 		<p class="message"><?php echo get_cleanco_option('dt-404-text',''); ?></p>
 		<div class="button">
 			<a href="<?php echo esc_url(home_url()); ?>" class="btn-back secondary_color_button btn skin-light"><?php _e('Go back to Our Homepage','cleanco');?></a>
 		</div>
 	</div>
<?php wp_footer(); ?>
</body>
</html>