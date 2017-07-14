<?php
defined('ABSPATH') or die();

global $post;
?>
<?php 
if(!empty($post->thumbnail)):;?>
<div class="post-image">
	<?php print $post->thumbnail;?>	
</div>
<?php endif;?>
<div class="post-info<?php print (empty($post->thumbnail))?" no_image":"";?>">
	<span class="author"><?php print $post->author;?></span><span> / <?php print $post->comment_count;?> Comments</span>
	<h4><a href="<?php echo esc_url($post->link); ?>" class="vc_read_more" title="<?php echo sanitize_title(sprintf(__( 'Detail to %s', 'cleanco' ), $post->title_attribute)); ?>"<?php echo " target=\"".$post->link_target."\""; ?>><?php print $post->title;?></a></h4>
	<div class="post-content"><?php print $post->excerpt;?>
		<a href="<?php echo esc_url($post->link); ?>" class="vc_read_more" title="<?php echo sanitize_title(sprintf(__( 'Detail to %s', 'cleanco' ), $post->title_attribute)); ?>"<?php echo " target=\"".$post->link_target."\""; ?>><?php print ucfirst(__('read more', 'cleanco')); ?> <i class="icon-right-dir"></i></a>
</div>
</div>
<div class="postmetabottom">
	<div class="col-xs-7">
		<?php if (!empty($post->post_tags)) : ?>
		<i class="icon-tags-2"></i><?php echo $post->post_tags; ?>
		<?php endif; //if ($tags!='') : ?>
	</div>
	<div class="col-xs-5">
		<i class="icon-clock-circled"></i><?php print $post->post_date;?>
	</div>
</div>
