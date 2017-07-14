<?php
defined('ABSPATH') or die();

add_action( 'save_post', 'save_detheme_metaboxes' );
add_action( 'save_post', 'save_seo_metaboxes' );

function save_seo_metaboxes($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    if(!wp_verify_nonce( isset($_POST['detheme_seo_metaboxes'])?sanitize_text_field($_POST['detheme_seo_metaboxes']):"", 'detheme_seo_metaboxes'))
    return;

     $old = get_post_meta( $post_id, '_meta_description', true );
     $new = (isset($_POST['meta_description']))?sanitize_text_field($_POST['meta_description']):'';
     
     update_post_meta( $post_id, '_meta_description', $new,$old );

     $old = get_post_meta( $post_id, '_meta_keyword', true );
     $new = (isset($_POST['meta_keyword']))?sanitize_text_field($_POST['meta_keyword']):'';
     
     update_post_meta( $post_id, '_meta_keyword', $new,$old );

     $old = get_post_meta( $post_id, '_meta_author', true );
     $new = (isset($_POST['meta_author']))?sanitize_text_field($_POST['meta_author']):'';
     
     update_post_meta( $post_id, '_meta_author', $new,$old );
}

function save_detheme_metaboxes($post_id){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    if(!wp_verify_nonce( isset($_POST['detheme_page_metaboxes'])?sanitize_text_field($_POST['detheme_page_metaboxes']):"", 'detheme_page_metaboxes'))
    return;

     $old = get_post_meta( $post_id, '_sidebar_position', true );
     $new = (isset($_POST['_sidebar_position']))?sanitize_text_field($_POST['_sidebar_position']):'';
     
     update_post_meta( $post_id, '_sidebar_position', $new,$old );

     $old = get_post_meta( $post_id, '_portfoliocolumn', true );
     $new = (isset($_POST['portfoliocolumn']))?sanitize_text_field($_POST['portfoliocolumn']):'';
     
     update_post_meta( $post_id, '_portfoliocolumn', $new,$old );

     $old = get_post_meta( $post_id, '_portfoliotype', true );
     $new = (isset($_POST['portfoliotype']))?sanitize_text_field($_POST['portfoliotype']):'';
     
     update_post_meta( $post_id, '_portfoliotype', $new,$old );

     $old = get_post_meta( $post_id, '_hide_lightbox', true );
     $new = (isset($_POST['hide_lightbox']))?sanitize_text_field($_POST['hide_lightbox']):'';
     
     update_post_meta( $post_id, '_hide_lightbox', $new,$old );

     $old = get_post_meta( $post_id, '_hide_title', true );
     $new = (isset($_POST['hide_title']))?sanitize_text_field($_POST['hide_title']):'';

     update_post_meta( $post_id, '_hide_title', $new,$old );

     $old = get_post_meta( $post_id, '_hide_loader', true );
     $new = (isset($_POST['hide_loader']))?sanitize_text_field($_POST['hide_loader']):'';

     update_post_meta( $post_id, '_hide_loader', $new,$old );

     $old = get_post_meta( $post_id, '_hide_popup', true );
     $new = (isset($_POST['hide_popup']))?sanitize_text_field($_POST['hide_popup']):'';

     update_post_meta( $post_id, '_hide_popup', $new,$old );

     $old = get_post_meta( $post_id, '_hide_banner', true );
     $new = (isset($_POST['hide_banner']))?sanitize_text_field($_POST['hide_banner']):'';

     update_post_meta( $post_id, '_hide_banner', $new,$old );

     if('page'==get_post_type()){

       $old = get_post_meta( $post_id, '_background_style', true );
       $new = (isset($_POST['background_style']))?sanitize_text_field($_POST['background_style']):'';

       update_post_meta( $post_id, '_background_style', $new,$old );

       $old = get_post_meta( $post_id, '_page_background', true );
       $new = (isset($_POST['page_background']))?sanitize_text_field($_POST['page_background']):'';

       update_post_meta( $post_id, '_page_background', $new,$old );
    }


     if(isset($_POST['page_banner'])){

       $old = get_post_meta( $post_id, '_page_banner', true );
       $new = sanitize_text_field($_POST['page_banner']);
       update_post_meta( $post_id, '_page_banner', $new,$old );
     }    
}


function dt_page_metaboxes() {

  $defaultpost=array(
    'page'=>__('Page Attributes','cleanco'),
    'post'=>__('Page Attributes','cleanco'),
    'port'=>__('Page Attributes','cleanco'),
    'product'=>__('Page Attributes','cleanco')
  );

  $posttypes=apply_filters('dt_page_metaboxes',$defaultpost);

  if(count($posttypes)){
    foreach ($posttypes as $posttype => $title) {
      remove_meta_box('pageparentdiv', $posttype,'side');
      add_meta_box('dtpageparentdiv',  ($title==""?__('Page Attributes','cleanco'):$title), 'dt_page_attributes_meta_box', $posttype, 'side', 'core');
    }

  }
}

function dt_seo_metaboxes(){

  if(!get_cleanco_option('cleancoseo'))
    return;

  $defaultpost=array(
    'page'=>__('Page SEO','cleanco'),
    'post'=>__('Post SEO','cleanco'),
    'port'=>__('Portfolio SEO','cleanco'),
    'product'=>__('Product SEO','cleanco')
  );

  $posttypes=apply_filters('dt_seo_metaboxes',$defaultpost);

  if(count($posttypes)){
    foreach ($posttypes as $posttype => $title) {
      add_meta_box('dtseometa',  ($title==""?__('SEO','cleanco'):$title), 'dt_page_seo_meta_box', $posttype, 'side', 'core');
    }

  }
}

add_action( 'admin_menu' , 'dt_page_metaboxes');
add_action( 'admin_menu' , 'dt_seo_metaboxes');

function dt_page_seo_meta_box($post){
  wp_nonce_field( 'detheme_seo_metaboxes','detheme_seo_metaboxes');
  $meta_description=get_post_meta( $post->ID, '_meta_description', true );
  $meta_keyword=get_post_meta( $post->ID, '_meta_keyword', true );
  $meta_author=get_post_meta( $post->ID, '_meta_author', true );
  ?>
<p><strong><?php _e('Meta Author', 'cleanco');?> :</strong></p>
<p><input type="text" name="meta_author" id="meta-author" class="widefat" value="<?php print $meta_author;?>" /></p>
<p><strong><?php _e('Meta Keyword', 'cleanco');?> :</strong></p>
<p><textarea name="meta_keyword" id="meta-keyword" class="widefat"><?php print $meta_keyword;?></textarea></p>
<p><?php _e('Type your meta keyword separed by comma. Googlebot loves it if it\'s not exceeding 160 characters or 20 words.', 'cleanco');?></p>
<p><strong><?php _e('Meta Description', 'cleanco');?> :</strong></p>
<p><textarea name="meta_description" id="meta-description" class="widefat"><?php print $meta_description;?></textarea></p>
<p><?php _e('Type your meta description. Googlebot loves it if it\'s not exceeding 160 characters or 20 words.', 'cleanco');?></p>
<?php 

}

function dt_page_attributes_meta_box($post) {


   
  wp_register_script('detheme-media',get_template_directory_uri() . '/lib/js/media.min.js', array('jquery','media-views','media-editor'),'',false);
  wp_enqueue_script('detheme-media');

  wp_localize_script( 'detheme-media', 'dtb_i18nLocale', array(
      'select_image'=>__('Select Image','cleanco'),
      'insert_image'=>__('Insert Image','cleanco'),
  ));

  wp_nonce_field( 'detheme_page_metaboxes','detheme_page_metaboxes');

  do_action('dt_page_attribute_metaboxes',$post);
  do_action('after_dt_page_attribute');
}


function dt_page_attribute_post_parent($post){

  $post_type_object = get_post_type_object($post->post_type);
  if ( $post_type_object->hierarchical ) {

    $dropdown_args = array(
      'post_type'        => $post->post_type,
      'exclude_tree'     => $post->ID,
      'selected'         => $post->post_parent,
      'name'             => 'parent_id',
      'show_option_none' => __('(no parent)','cleanco'),
      'sort_column'      => 'menu_order, post_title',
      'echo'             => 0,
    );

    $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
    $pages = wp_dropdown_pages( $dropdown_args );

  if ( ! empty($pages) ) {?>
<p><strong><?php _e('Parent','cleanco') ?></strong></p>
<label class="screen-reader-text" for="parent_id"><?php _e('Parent','cleanco') ?></label>
<?php echo $pages; 
    } // end empty pages check
  } // end hierarchical check.

}

function dt_page_attribute_checkbox($post){
?>
<?php if ( 'product' != $post->post_type):?>
<p><input type="checkbox" name="hide_title" id="hide_title" value="1" <?php echo ($post->_hide_title)?'checked="checked"':""?>/> <?php _e('Hide title','cleanco') ?></strong></p>
<?php endif;?>
<p><input type="checkbox" name="hide_lightbox" id="hide_lightbox" value="1" <?php echo ($post->_hide_lightbox)?'checked="checked"':""?>/> <?php _e('Disable Lightbox 1st Visit','cleanco') ?></strong></p>
<p><input type="checkbox" name="hide_loader" id="hide_loader" value="1" <?php echo ($post->_hide_loader)?'checked="checked"':""?>/> <?php _e('Disable Page Loader','cleanco') ?></strong></p>
<p><input type="checkbox" name="hide_popup" id="hide_popup" value="1" <?php echo ($post->_hide_popup)?'checked="checked"':""?>/> <?php _e('Disable Exit Popup','cleanco') ?></strong></p>
<?php if ( 'page' == $post->post_type && get_cleanco_option('dt-show-banner-page')=='featured' && get_cleanco_option('show-banner-area') ):?>
<p><input type="checkbox" name="hide_banner" id="hide_banner" value="1" <?php echo ($post->_hide_banner)?'checked="checked"':""?>/> <?php _e('Hide banner','cleanco') ?></strong></p>

<script type="text/javascript">
jQuery(document).ready(function($) {
  'use strict'; 

  var hide_banner=$('#hide_banner');
    
  if(hide_banner.length){
    hide_banner.on('change',function(){
      if(hide_banner.prop('checked')){
        $('.page-banner').hide();
      }
      else{
        $('.page-banner').show();
      }

    })
    .trigger('change');
  }
});

</script>
<?php endif;
}

function dt_page_attribute_page_template($post){

  if ( 'page' != $post->post_type )
      return true;

  $template = !empty($post->page_template) ? $post->page_template : false;
  $templates = get_page_templates();
  $sidebar_position=array('sidebar-left'=>__('Left','cleanco'),'sidebar-right'=>__('Right','cleanco'),'nosidebar'=>__('No Sidebar','cleanco'));


  if (!detheme_plugin_is_active('detheme-portfolio/detheme_port.php')) {
    unset($templates['Portfolio Template']);
  }
  ksort( $templates );
   ?>
<p><strong><?php _e('Template','cleanco') ?></strong></p>
<label class="screen-reader-text" for="page_template"><?php _e('Page Template','cleanco'); ?></label><select name="page_template" id="page_template">
<option value='default'><?php _e('Default Template','cleanco'); ?></option>
<?php 

if(count($templates)):

foreach (array_keys( $templates ) as $tmpl )
    : if ( $template == $templates[$tmpl] )
      $selected = " selected='selected'";
    else
      $selected = '';
  echo "\n\t<option value='".$templates[$tmpl]."' $selected>".__($tmpl,'cleanco')."</option>";
  endforeach;
  endif;?>
 ?>
</select>
<div id="custommeta">
<div style="margin: 13px 0 11px 4px; display: none;" class="dt_portfolio">
      <p><strong><?php esc_html_e( 'Select Layout Type', 'cleanco' ); ?></strong><br/>
      <select name="portfoliotype" id="portfoliotype">
        <option value="image"<?php print ("image"==$post->_portfoliotype || empty($post->_portfoliotype) || !isset($post->_portfoliotype))?" selected":"";?>><?php _e('Squared Image (boxed)','cleanco');?></option>;
        <option value="text"<?php print ("text"==$post->_portfoliotype)?" selected":"";?>><?php _e('Image and Text (boxed)','cleanco');?></option>;
        <option value="imagefull"<?php print ("imagefull"==$post->_portfoliotype)?" selected":"";?>><?php _e('Squared Image(full)','cleanco');?></option>;
        <option value="imagefixheightfull"<?php print ("imagefixheightfull"==$post->_portfoliotype)?" selected":"";?>><?php _e('Fix Height Image(full)','cleanco');?></option>;
      </select>
</p>
</div>
<div style="margin: 13px 0 11px 4px; display: none;" class="dt_portcolumn">
      <p><strong><?php esc_html_e( 'Select Column', 'cleanco' ); ?></strong>&nbsp;
      <select name="portfoliocolumn" id="portfoliocolumn">
<?php 
for($col=3;$col<7;$col++) {
  print "<option value='".$col."'".(($post->_portfoliocolumn==$col)?" selected":"").">".sprintf(__('%d Column','cleanco'),$col)."</option>";
}
?>
</select>
</p>
</div>
<p id="sidebar_option">
  <strong><?php _e('Sidebar Position','cleanco') ?></strong>&nbsp;
<select name="_sidebar_position" id="sidebar_position">
<option value='default'><?php _e('Default','cleanco'); ?></option>
<?php foreach ($sidebar_position as $position=>$label) {
  print "<option value='".$position."'".(($post->_sidebar_position==$position)?" selected":"").">".ucwords($label)."</option>";

}?>
</select>
</p>
</div>
<p><strong><?php _e('Order','cleanco') ?></strong></p>
<p><label class="screen-reader-text" for="menu_order"><?php _e('Order','cleanco') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
<p><?php _e( 'Need help? Use the Help tab in the upper right of your screen.','cleanco' ); ?></p>
<script type="text/javascript">
jQuery(document).ready(function($) {
  'use strict'; 

  var $select = $('select#page_template'),$custommeta = $('#custommeta'),$portfoliotype = $('select#portfoliotype'),$background_style=$('#background_style');
    
  $select.live('change',function(){
    var this_value = $(this).val();
    switch ( this_value ) {
      case 'squeeze.php':
      case 'squeezeboxed.php':
            $custommeta.find('#sidebar_option').fadeOut('slow');
            $custommeta.find('.dt_portfolio').fadeOut('slow');
            $custommeta.find('.dt_portcolumn').fadeOut('slow');
        break;
      case 'fullwidth.php':
            $custommeta.find('#sidebar_option').fadeOut('slow');
            $custommeta.find('.dt_portfolio').fadeOut('slow');
            $custommeta.find('.dt_portcolumn').fadeOut('slow');
        break;
      case 'portfolio.php':
        $custommeta.find('#sidebar_option').fadeIn('slow');
        $custommeta.find('.dt_portfolio').fadeIn('slow');
        $custommeta.find('.dt_portcolumn').fadeIn('slow');
        $portfoliotype.trigger('change');
        break;
      default:
         $custommeta.find('.dt_portfolio').fadeOut('slow');
         $custommeta.find('.dt_portcolumn').fadeOut('slow');
         $custommeta.find('#sidebar_option').fadeIn('slow');
    }

  });
  
  $portfoliotype.live('change',function(){
    var this_value = $(this).val();

    switch ( this_value ) {
      case 'imagefull':
           $custommeta.find('.dt_portcolumn option[value="5"]').show();
           $custommeta.find('.dt_portcolumn option[value="6"]').show();
           $custommeta.find('.dt_portcolumn').fadeIn('slow');
           $custommeta.find('#sidebar_option').fadeOut('slow');
          break;
      case 'imagefixheightfull':
          $custommeta.find('.dt_portcolumn').fadeOut('slow');
          $custommeta.find('#sidebar_option').fadeOut('slow');
        break;
      default:
         $custommeta.find('.dt_portcolumn option[value="5"]').removeProp('selected').hide();
         $custommeta.find('.dt_portcolumn option[value="6"]').removeProp('selected').hide();
         $custommeta.find('.dt_portcolumn').fadeIn('slow');
         $custommeta.find('#sidebar_option').fadeIn('slow');
        break;
    }

  });

  $select.trigger('change');
});
</script>
<?php  
}

function dt_page_attribute_page_background($post){

if ( 'page' != $post->post_type )
  return true;

  $background_image=get_post_meta($post->ID, '_page_background', true);
  $background_style=get_post_meta( $post->ID, '_background_style', true );
  $image="";
  $styles = array(
      __("Cover", 'wpb') => 'cover',
      __("Cover All", 'wpb') => 'cover_all',
      __('Contain', 'wpb') => 'contain',
      __('No Repeat', 'wpb') => 'no-repeat',
      __('Repeat', 'wpb') => 'repeat',
      __("Parallax", 'cleanco') => 'parallax',
      __("Parallax All", 'cleanco') => 'parallax_all',
      __("Fixed", 'cleanco') => 'fixed',
    );

  if($background_image){

    $image = wp_get_attachment_image( $background_image, array( 266,266 ));
  }

  ?>
<div class="detheme-field-image page-background">
  <p><strong><?php _e('Background Image','cleanco');?></strong>
  <input type="hidden" name="page_background" value="<?php print $background_image;?>" />
  <p class="preview-image">
  <a title="<?php _e('Set background image','cleanco');?>" href="#" id="set-page-background" class="add_detheme_image"><?php echo (""!==$image)?$image:__('Set background image','cleanco');?></a>
  </p>
  <a title="<?php _e('Remove background image','cleanco');?>" style="display:<?php echo (""==$image)?"none":"block";?>" href="#" id="clear-page-background" class="remove_detheme_image"><?php _e('Remove background image','cleanco');?></a>
</div>
 <div  id="background_style"><strong><?php _e('Background Style','cleanco');?></strong>&nbsp;
  <select name="background_style">
  <option value="default"><?php _e('Default','cleanco');?></option>
  <?php 
  foreach ($styles as $name=>$style) {
    print "<option value='".$style."'".(($background_style==$style)?" selected":"").">".ucwords($name)."</option>";

  }
  ?>
  </select>
</div>
<?php   
}

function dt_page_attribute_page_banner($post){

  if( get_cleanco_option('dt-show-banner-page','')!='featured' || !get_cleanco_option('show-banner-area'))
    return true;

  $banner_image=get_post_meta($post->ID, '_page_banner', true);
  $banner_image_url="";

  if($banner_image){

    $banner_image_url = wp_get_attachment_image( $banner_image, array( 266,266 ));
  }
?>
<div class="detheme-field-image page-banner">
  <p><strong><?php _e('Banner Image','cleanco');?></strong>
  <input type="hidden" name="page_banner" value="<?php print $banner_image;?>" />
  <p class="preview-image">
  <a title="<?php _e('Set Page Banner','cleanco');?>" href="#" id="set-page-banner" class="add_detheme_image"><?php echo (""!==$banner_image_url)?$banner_image_url:__('Set Page Banner','cleanco','cleanco');?></a>
  </p>
  <a title="<?php _e('Remove Page Banner','cleanco');?>" style="display:<?php echo (""==$banner_image_url)?"none":"block";?>" href="#" id="clear-page-banner" class="remove_detheme_image"><?php _e('Remove Page Banner','cleanco');?></a>
</div>
<?php
}

add_action ('dt_page_attribute_metaboxes','dt_page_attribute_checkbox');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_post_parent');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_page_template');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_page_banner');
add_action ('dt_page_attribute_metaboxes','dt_page_attribute_page_background');
?>