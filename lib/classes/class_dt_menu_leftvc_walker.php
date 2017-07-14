<?php 
defined('ABSPATH') or die();

class dt_menu_leftvc_walker extends Walker_Nav_Menu {

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
  }

}
?>