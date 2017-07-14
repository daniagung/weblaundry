<?php
defined('ABSPATH') or die();
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */

get_header();
?>
<?php 
$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['detheme-sidebar']) && count($sidebars['detheme-sidebar'])){
	$sidebar='detheme-sidebar';
}
switch (get_cleanco_option('layout','')) {
	case 1:
		$sidebar_position = "nosidebar";
		break;
	case 2:
		$sidebar_position = "sidebar-left";
		break;
	case 3:
		$sidebar_position = "sidebar-right";
		break;
	default:
		$sidebar_position = "sidebar-left";
}

if(!$sidebar){
	$sidebar_position = "nosidebar";
}

set_query_var('sidebar',$sidebar);
$class_sidebar = $sidebar_position;
$vertical_menu_container_class = get_cleanco_option('dt-header-type','')=='leftbar' ? " vertical_menu_container":"";
?>

<div <?php post_class('content '.sanitize_html_class($vertical_menu_container_class)); ?> id="search-result">
<div class="<?php echo sanitize_html_class($class_sidebar);?>">
	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8 <?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?> col-md-9 <?php print ($sidebar_position=='sidebar-left')?" col-md-push-3":"";?>">
<?php	} ?>
				<header class="archive-header">

				<h2 class="archive-title"><?php printf( __( 'Search Results for: %s', 'cleanco' ), get_search_query() ); ?></h2>
				</header>
<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();
						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>
					<div class="clearfix">
						<div class="col-xs-12 postseparator"></div>
					</div>
					<?php
					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
?>
<?php locate_template('pagetemplates/pagination.php',true,false); ?>
				
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
		
		</div>			
	</div>
</div>
<?php
get_footer();
?>