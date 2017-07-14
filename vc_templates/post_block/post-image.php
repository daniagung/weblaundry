<?php
defined('ABSPATH') or die();

global $post,$cleanco_revealData;

$thumb_size=$post->grid_thumb_size;
$attachment_id=get_post_thumbnail_id($post->id);

if ( is_string($thumb_size) ) {
            preg_match_all('/\d+/', $thumb_size, $thumb_matches);
            if(isset($thumb_matches[0])) {
                $thumb_size = array();
                if(count($thumb_matches[0]) > 1) {
                    $thumb_size[] = $thumb_matches[0][0]; // width
                    $thumb_size[] = $thumb_matches[0][1]; // height
                } elseif(count($thumb_matches[0]) > 0 && count($thumb_matches[0]) < 2) {
                    $thumb_size[] = $thumb_matches[0][0]; // width
                    $thumb_size[] = $thumb_matches[0][0]; // height
                } else {
                    $thumb_size = false;
                }
            }
 }

if($thumb_size){

    $p_img = wpb_resize($attachment_id, null, $thumb_size[0], $thumb_size[0], true);

   $post->thumbnail = '<img src="'.esc_url($p_img['url']).'" class="img-responsive" alt="" />';
}
else{
   $post->thumbnail = wp_get_attachment_image( $attachment_id, 'large', false, array('class' => 'img-responsive') );
}

$modal_effect = get_cleanco_option('dt-select-modal-effects','md-effect-15');
$modalcontent = '<div id="modal_post_'.$post->id.'" class="md-modal '.$modal_effect.'">
	<div class="md-content"><img src="#" rel="'.esc_url($post->thumbnail_data['p_img_large'][0]).'" class="img-responsive" alt=""/>		
		<div class="md-description secondary_color_bg">'.$post->title.'</div>
		<button class="md-close secondary_color_button"><i class="icon-cancel"></i></button>
	</div>
</div>';

array_push($cleanco_revealData,$modalcontent);


?>
<div class="post-image-container">
<?php 
if(!empty($post->thumbnail)):;?>
<div class="post-image">
	<?php print $post->thumbnail;?>	
</div>
<?php endif;?>
<div class="imgcontrol tertier_color_bg_transparent">
	<div class="imgbuttons">
		<a class="md-trigger btn icon-zoom-in secondary_color_button skin-light" data-modal="modal_post_<?php echo $post->id; ?>" onclick="return false;" href="<?php print esc_url($post->link); ?>"></a>
		<a class="btn icon-link secondary_color_button skin-light" target="<?php echo esc_attr($post->link_target);?>" href="<?php print esc_url($post->link); ?>"></a>
	</div>
</div>
</div>