<?php
defined('ABSPATH') or die();

global $post;

	$thumbnail_data=$post->thumbnail_data;

	$bgstyle = '';
	if ($thumbnail_data['p_img_large']) {
		$bgstyle = ' style="background: url(\''.esc_url($thumbnail_data['p_img_large'][0]).'\') no-repeat; background-size: cover;"';
	} 

?>
<a href="<?php print esc_url($post->excerpt);?>" target="<?php echo esc_attr($post->link_target);?>">
<div class="post-link primary_color_bg"<?php print $bgstyle;?>>
<div class="post-info">
	<h4><?php print $post->title;?></h4>
	<div class="post-content"><?php print $post->excerpt;?>
		<div class="iconlink"><a href="<?php print esc_url($post->excerpt);?>" target="<?php echo esc_attr($post->link_target);?>" title="<?php print sanitize_title($post->title_attribute);?>"><i class="icon-link"></i></a></div>
	</div>
</div>
</div>
</a>