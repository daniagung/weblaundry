<?php 
defined('ABSPATH') or die();

class dt_topbarmenuleft_walker extends Walker_Nav_Menu {
  function start_lvl( &$output, $depth = 0, $args = array() ) {
      $tem_output = $output . 'akhir';

      $found = preg_match_all('/<li (.*)<span>(.*?)<\/span><\/a>akhir/s', $tem_output, $matches);

      $foundid = preg_match_all('/<li id="menu\-item\-(.*?)"/s', $tem_output, $ids);

      if ($found) {
        $menu_title = $matches[count($matches)-1][0];

        if (count($ids[1])>0) {
          $menu_id = $ids[1][count($ids[1])-1];
        } else {
          $menu_id = rand (1000,9999);
        }

        $output .= '<label for="topleft'.sanitize_title($menu_id).'" class="toggle-sub" onclick="">&rsaquo;</label>
        <input id="topleft'.sanitize_title($menu_id).'" class="sub-nav-check" type="checkbox">
        <ul id="topleft-sub-'.sanitize_title($menu_id).'" class="sub-nav"><li class="sub-heading">'. $menu_title .' <label for="topleft'.sanitize_title($menu_id).'" class="toggle" onclick="" title="'.sanitize_title(__('Back','cleanco')).'">&lsaquo; '.__('Back','cleanco').'</label></li>';
      }
  }

}
?>