<?php
defined('ABSPATH') or die();
 if ( have_comments() ) : ?> 
     	<div class="row section-comment">
          <div class="col-sm-12">
            <ul class="media-list">
<?php wp_list_comments( array( 'callback' => 'dt_comment', 'max_depth' => 3, 'reverse_children' => true ) ); ?>
			</ul>
		  </div>
		</div>

		<!-- Pagination -->
		<div class="row">
			<div class="paging-nav col-xs-12">
<?php
				echo paginate_comments_links(array(
					'prev_text'    => __('<i class="icon-angle-left"></i>'),
					'next_text'    => __('<i class="icon-angle-right"></i>'),
				));
?>
			</div>
		</div>
		<!-- /Pagination -->

<?php endif;  ?>

<?php if ( !comments_open()) : ?>
<?php 	do_action( 'comment_form_comments_closed' ); ?>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-10">
				<div class="comment-count"><?php _e( 'Comments are closed.' , 'cleanco' ); ?></div>
				<hr>
			</div>	
		</div>
<?php else : ?>
	<?php dt_comment_form(); ?>

<?php endif; ?>