<?php 
defined('ABSPATH') or die();

class dt_mainmenu_walker extends Walker_Nav_Menu {

  protected $megamenu_parent_ids = array();
  private $curItem;

  function start_lvl( &$output, $depth = 0, $args = array() ) {
      $tem_output = $output . 'akhir';

      $found = preg_match_all('/<li (.*)<span>(.*?)<\/span><\/a>akhir/s', $tem_output, $matches);

      $foundid = preg_match_all('/<li id="menu\-item\-(.*?)"/s', $tem_output, $ids);

      $found_full_megamenu = preg_match_all('/class="(.*)dt\-megamenu(.*?)"/s', $tem_output, $full_megamenu);

      if ($found) {
        $menu_title = $matches[count($matches)-1][0];

        if (count($ids[1])>0) {
          $menu_id = $ids[1][count($ids[1])-1];
        } else {
          $menu_id = rand (1000,9999);
        }
        $class_sub = "";

        $output .= '<label for="fof'.$menu_id.'" class="toggle-sub" onclick="">&rsaquo;</label>
        <input id="fof'.$menu_id.'" class="sub-nav-check" type="checkbox">
        <ul id="fof-sub-'.$menu_id.'" class="sub-nav '. $class_sub .'"><li class="sub-heading">'. $menu_title .' <label for="fof'.$menu_id.'" class="toggle" onclick="" title="'.__('Back','cleanco').'">&lsaquo; '.__('Back','cleanco').'</label></li>';

      }
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    if ( detheme_plugin_is_active('dt-megamenu/dt-megamenu.php') ) {
      if (isset($this->curItem)) {
        if ($this->curItem->megamenuType=='megamenu-column') {
          $output .= '</div></li><!--end of <li><div class="row">-->';// end of <li><div class="row">
          $output .= '<!--end_lvl1 '.$this->curItem->ID.' '. $this->curItem->megamenuType . ' -->';
          parent::end_lvl($output,$depth,$args);
        } elseif ($this->curItem->megamenuType=='megamenu-content') {
          //if (isset($this->curItem->megamenuContentPages)&&!empty($this->curItem->megamenuContentPages)) {
          //  $output .= $this->detheme_load_megamenu_vc_content($this->curItem->megamenuContentPages);
          //}
          
          $output .= '<!--end_lvl2 '.$this->curItem->ID.' '. $this->curItem->megamenuType . ' -->';
          parent::end_lvl($output,$depth,$args);
        } else {
          $output .= '<!--end_lvl2 '.$this->curItem->ID.' '. $this->curItem->megamenuType . ' -->';
          parent::end_lvl($output,$depth,$args);
        }
      } else {
        $output .= '<!--end_lvl3-->';
        parent::end_lvl($output,$depth,$args);
      }
    } else {
      $output .= '<!--end_lvl4-->';
      parent::end_lvl($output,$depth,$args);
    }
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    if(is_array($args) && $args['fallback_cb']=='wp_page_menu'){

      $item->title=$item->post_title;
      $item->url=get_permalink($item->ID);
    }

    if ( detheme_plugin_is_active('dt-megamenu/dt-megamenu.php') ) {

      switch($item->megamenuType) {
        case 'megamenu-column':

          $classes = implode(" ",$item->classes);

          $output .= '<div class="'.$classes.' dt-megamenu-grid">';
          $output .= '  <ul class="dt-megamenu-sub-nav">';
        break;
        case 'megamenu-heading':
          parent::start_el($output,$item,$depth,$args,$id);
        break;
        case 'megamenu-content':
          parent::start_el($output,$item,$depth,$args,$id);
        break;
        default :
          if ($item->megamenuLogo!="active") parent::start_el($output,$item,$depth,(object)$args,$id);
        break;
      } //switch($item->megamenuType)

      //Kalo Option "Logo Here" dicentang
      if (($item->megamenuLogo=="active")&& get_cleanco_option('dt-header-type','')=='middle') {
        $output .= '<li class="logo-desktop hidden-sm hidden-xs">'.detheme_get_logo_content();
      }

      if (is_array($item->classes) && in_array('dt-megamenu',$item->classes)) {
        $class_sub = "megamenu-sub";
        $style_sub = "";

        if ( detheme_plugin_is_active('dt-megamenu/dt-megamenu.php') ) {
          if (isset($item->megamenuWidthOptions)) {
            if ($item->megamenuWidthOptions=='dt-megamenu-width-set sticky-left') {
              if (!empty($item->megamenuWidth)) { $style_sub = ' style="width: '. sanitize_title($item->megamenuWidth) .';"'; }
            } else {
              $class_sub = "megamenu-sub ". sanitize_html_class($item->megamenuWidthOptions);
            }
          }
        }

        $background_style = '';
        if (isset($item->megamenuBackgroundURL)) {
          $background_style = 'style="background: url('.esc_url($item->megamenuBackgroundURL).') '. $item->megamenuBackgroundHorizontalPosition . ' ' . $item->megamenuBackgroundVerticalPosition . ' ' . $item->megamenuBackgroundRepeat . ';"';
        }

        $menu_id = $item->ID;
        $menu_id = $menu_id . rand (1000,9999);
        $this->megamenu_parent_ids[] = $menu_id;

        $menu_title = $item->post_title;

        $output .= '<label for="fof'.sanitize_title($menu_id).'" class="toggle-sub" onclick="">&rsaquo;</label>
        <input id="fof'.esc_attr(sanitize_title($menu_id)).'" class="sub-nav-check" type="checkbox">
        <ul id="fof-sub-'.esc_attr(sanitize_title($menu_id)).'" class="sub-nav '. $class_sub .'"'.$style_sub.'><li class="sub-heading">'. $menu_title .' <label for="fof'.esc_attr(sanitize_title($menu_id)).'" class="toggle" onclick="" title="'.sanitize_title(__('Back','cleanco')).'">&lsaquo; '.__('Back','cleanco').'</label></li>';

        $output .= '<li><div class="row" '.strip_tags($background_style).'>';
      }

    } else {
      parent::start_el($output,$item,$depth,(object)$args,$id);
    } 
    
  } 

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $this->curItem = $item;

    if ( detheme_plugin_is_active('dt-megamenu/dt-megamenu.php') ) {
      switch($item->megamenuType) {
        case 'megamenu-column':
          $output .= '</div><!--end_el megamenu-column-->';
        break;
        case 'megamenu-heading':
          parent::end_el($output,$item,$depth,$args);
        break;
        case 'megamenu-content':
          parent::end_el($output,$item,$depth,$args);
        break;
        default :
          parent::end_el($output,$item,$depth,$args);
        break;
      }
    } else {

      parent::end_el($output,$item,$depth,$args);
    }
  } //function end_el

  function detheme_load_megamenu_vc_content($page_id){
    if(!$page_id)
      return;

    $result = "";

    if(function_exists('vc_set_as_theme')){

      $assetPath=plugins_url( 'js_composer/assets/css','js_composer');

      $front_css_file = version_compare(WPB_VC_VERSION,"4.2.3",'>=')?$assetPath.'/js_composer.css':$assetPath.'/js_composer_front.css';

      $upload_dir = wp_upload_dir();

      if(function_exists('vc_settings')){

        if ( vc_settings()->get( 'use_custom' ) == '1' && is_file( $upload_dir['basedir'] . '/js_composer/js_composer_front_custom.css' ) ) {
          $front_css_file = $upload_dir['baseurl'] . '/js_composer/js_composer_front_custom.css';
        }
      }
      else{
        if ( WPBakeryVisualComposerSettings::get('use_custom') == '1' && is_file( $upload_dir['basedir'] . '/js_composer/js_composer_front_custom.css' ) ) {
          $front_css_file = $upload_dir['baseurl'] . '/js_composer/js_composer_front_custom.css';
        }

      }

      wp_register_style( 'js_composer_front', $front_css_file, false, WPB_VC_VERSION, 'all' );
      
      if ( is_file( $upload_dir['basedir'] . '/js_composer/custom.css' ) ) {
        wp_register_style( 'js_composer_custom_css', $upload_dir['baseurl'] . '/js_composer/custom.css', array(), WPB_VC_VERSION, 'screen' );
      }

      wp_enqueue_style('js_composer_front');
      wp_enqueue_style('js_composer_custom_css');

    }

  $post = _get_wpml_post($page_id);
  $old_sidebar=get_query_var('sidebar');
  set_query_var('sidebar','nosidebar');
  if (isset($post->post_content)) $result = do_shortcode($post->post_content);
  set_query_var('sidebar',$old_sidebar);

  return $result;
}


}
?>