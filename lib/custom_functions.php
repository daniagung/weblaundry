<?php
defined('ABSPATH') or die();

function get_detheme_sidebar_position(){

  if(function_exists('is_shop') && is_shop()){

   $post_id=get_option( 'woocommerce_shop_page_id');
  }
  elseif(is_home()){
    $post_id=get_option( 'page_for_posts');
  }
  elseif (is_page()){
    $post_id= get_the_ID();
  }

  $sidebar_position = isset($post_id) ?get_post_meta( $post_id, '_sidebar_position', true ):'default';


  if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){

    switch (get_cleanco_option('layout')) {
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


  }

  return $sidebar_position;
}

add_filter('nav_menu_link_attributes','formatMenuAttibute',2,2);
function mainNavFilter($items) {
  foreach ($items as $item) {
      if (hasSub($item->ID, $items)) {
        $item->classes[] = 'dropdown'; 
      }
  }
    return $items;        
}

function formatMenuAttibute($atts, $item){
  global $dropdownmenu;
  if(is_array($item->classes) && in_array('dropdown', $item->classes)){
    $atts['class']="dropdown-toggle";
    $atts['data-toggle']="dropdown";
    $dropdownmenu=$item;
  }
  return $atts;

}

function hasSub($menu_item_id, $items) {

      foreach ($items as $item) {

        if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {

          return true;

        }

      }

      return false;

}


function createFontelloIconMenu($css,$item,$args=array()){

  $args=is_array($args)?(object)$args:$args;


  $css=@implode(" ",$css);
  $args->link_before="";
  $args->link_after="";


  if(preg_match('/([-_a-z-0-9]{0,})icon([-_a-z-0-9]{0,})/', $css, $matches)){
    $css=preg_replace('/'.$matches[0].'/', "", $css);
    $item->title="<i class=\"".$matches[0]."\"></i>";
  }

  return @explode(" ",$css);
}


function createFontelloMenu($css,$item,$args=array()){

  $args=is_array($args)?(object)$args:$args;


  $css=@implode(" ",$css);
  $args->link_before="";
  $args->link_after="";
  
  if(preg_match('/([-_a-z-0-9]{0,})icon([-_a-z-0-9]{0,})/', $css, $matches)){
  
    $css=preg_replace('/'.$matches[0].'/', "", $css);
    $args->link_before.="<i class=\"".$matches[0]."\"></i>";
  }

  $args->link_before.="<span>";
  $args->link_after="</span>";

  return @explode(" ",$css);
}

add_filter( 'nav_menu_css_class', 'createFontelloMenu', 10, 3 );
add_filter( 'nav_menu_icon_css_class', 'createFontelloIconMenu', 10, 3 );

add_filter( 'wp_nav_menu_items','add_search_box_to_menu', 10, 2 );
function add_search_box_to_menu( $items, $args ) {
  global $itemid;

  if (!isset($itemid)) { $itemid = 999900; }

    if (get_cleanco_option('dt-header-type','')!='middle' && get_cleanco_option('dt-header-type','')!='leftvc'):
      $items = '<li class="logo-desktop hidden-sm hidden-xs">'.detheme_get_logo_content().'</li>' . $items;
    endif;

    $item_search = ''; 
    if(get_cleanco_option('show-header-searchmenu')):
      if( $args->theme_location == 'primary' ) :
        $item_search = '<li class="menu-item menu-item-type-search"><form class="searchform" id="menusearchform" method="get" action="' . esc_url(home_url( '/' )) . '" role="search">
                <a class="search_btn"><i class="flaticon-zoom22"></i></a>
                <div class="popup_form"><input type="text" class="form-control" id="sm" name="s" placeholder="'.__('Search','cleanco').'"></div>
              </form></li>';
      endif;
    endif;

    $item_cart = '';
    if(get_cleanco_option('show-header-shoppingcart')):
      if( $args->theme_location == 'primary' ) :
        if ( detheme_plugin_is_active('woocommerce/woocommerce.php') ) :

          if ( function_exists('WC') && sizeof( WC()->cart->get_cart() ) > 0 ) :
            $item_cart = '<li id="menu-item-'.$itemid.'" class="hidden-mobile bag menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-'.$itemid.'">
                      <a href="#">
                        <span><i class="icon-cart"></i><span class="item_count">'. WC()->cart->get_cart_contents_count() . '</span></span>
                      </a>
                        
                      <label for="fof'.$itemid.'" class="toggle-sub" onclick="">&rsaquo;</label>
                      <input id="fof'.$itemid.'" class="sub-nav-check" type="checkbox">
                      <ul id="fof-sub-'.$itemid.'" class="sub-nav">
                        <li class="sub-heading">'.__('Shopping Cart','cleanco').' <label for="fof'.$itemid.'" class="toggle" onclick="" title="'.sanitize_title(__('Back','cleanco')).'">&lsaquo; '.__('Back','cleanco').'</label></li>
                        <li>
                          <!-- popup -->
                          <div class="cart-popup"><div class="widget_shopping_cart_content"></div></div>  
                          <!-- end popup -->
                        </li>
                      </ul>

                    </li>';
            $itemid++;
          else:
              $item_cart = '<li id="menu-item-'.$itemid.'" class="hidden-mobile bag menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-'.$itemid.'">
                        <a href="#">
                          <span><i class="icon-cart"></i> <span class="item_count">0</span></span>
                        </a>
    
                        <label for="fof'.$itemid.'" class="toggle-sub" onclick="">&rsaquo;</label>
                        <input id="fof'.$itemid.'" class="sub-nav-check" type="checkbox">
                        <ul id="fof-sub-'.$itemid.'" class="sub-nav">
                          <li class="sub-heading">'.__('Shopping Cart','cleanco').' <label for="fof'.$itemid.'" class="toggle" onclick="" title="'.sanitize_title(__('Back','cleanco')).'">&lsaquo; '.__('Back','cleanco').'</label></li>
                          <li>
                            <!-- popup -->
                            <div class="cart-popup"><div class="widget_shopping_cart_content"></div></div>  
                            <!-- end popup -->
                          </li>
                        </ul>

                      </li>';
              $itemid++;
          endif;
         endif;
      endif;
    endif; 

    if (get_cleanco_option('dt-header-type','')=='leftvc') {
      $items .= $item_cart . $item_search;
    } else {
      $items .= $item_search . $item_cart;  
    }

    return $items;
}

add_filter( 'wp_nav_menu','add_custom_elemen_to_menu', 10, 2 );
function add_custom_elemen_to_menu( $nav_menu, $args ) {
  $found = preg_match_all('/<div id=\"dt\-menu\" class=\"([a-zA-Z0-9_-]+)\">(.*?)<\/ul><\/div>/s',$nav_menu,$menucontent);

  if ($found) {
    $nav_menu = '<div id="dt-menu" class="'.sanitize_html_class($menucontent[1][0]).'"><label for="main-nav-check" class="toggle" onclick="" title="'.sanitize_title(__('Close','cleanco')).'"><i class="icon-cancel"></i></label>'.$menucontent[2][0].'</ul><label class="toggle close-all" onclick="uncheckboxes(&#39;nav&#39;)"><i class="icon-cancel"></i></label>
      </div>';
  }

  return $nav_menu;
}

add_filter( 'wp_nav_menu','add_custom_elemen_to_menu_mobile', 14, 2 );
function add_custom_elemen_to_menu_mobile( $nav_menu, $args ) {
  
  $found = preg_match_all('/<div id=\"dt\-menu\-mobile\" class=\"(.*?)\">(.*?)<\/ul><\/div>/s',$nav_menu,$menucontent);

  if ($found) {
    $nav_menu = '<div id="dt-menu-mobile" class="'.sanitize_html_class($menucontent[1][0]).'"><label for="main-nav-check" class="toggle" onclick="" title="'.sanitize_title(__('Close','cleanco')).'"><i class="icon-cancel"></i></label>'.$menucontent[2][0].'</ul><label class="toggle close-all" onclick="uncheckboxes(&#39;nav&#39;)"><i class="icon-cancel"></i></label>
      </div>';
  }

  return $nav_menu;
}

add_filter( 'wp_nav_menu','add_custom_elemen_to_topbarmenuright', 11, 2 );
function add_custom_elemen_to_topbarmenuright( $nav_menu, $args ) {
  $found = preg_match_all('/<div id=\"dt\-topbar\-menu\-right\" class=\"([a-zA-Z0-9_-]+)\">(.*?)<\/ul><\/div>/s',$nav_menu,$menucontent);
  if ($found) {
    $nav_menu = '<div id="dt-topbar-menu-right" class="'.sanitize_html_class($menucontent[1][0]).'"><label for="main-nav-check" class="toggle" onclick="" title="'.sanitize_title(__('Close','cleanco')).'"><i class="icon-cancel"></i></label>'.$menucontent[2][0].'</ul><label class="toggle close-all" onclick="uncheckboxes(&#39;nav-top-right&#39;)"><i class="icon-cancel"></i></label></div>';
  }

  return $nav_menu;
}

add_filter( 'wp_nav_menu','add_custom_elemen_to_topbarmenuleft', 12, 2 );
function add_custom_elemen_to_topbarmenuleft( $nav_menu, $args ) {
  $found = preg_match_all('/<div id=\"dt\-topbar\-menu\-left\" class=\"([a-zA-Z0-9_-]+)\">(.*?)<\/ul><\/div>/s',$nav_menu,$menucontent);
  if ($found) {
    $nav_menu = '<div id="dt-topbar-menu-left" class="'.sanitize_html_class($menucontent[1][0]).'"><label for="main-nav-check" class="toggle" onclick="" title="'.sanitize_title(__('Close','cleanco')).'"><i class="icon-cancel"></i></label>'.$menucontent[2][0].'</ul><label class="toggle close-all" onclick="uncheckboxes(&#39;nav-top-left&#39;)"><i class="icon-cancel"></i></label></div>';
  }

  return $nav_menu;
}

function add_class_to_first_submenu($items) {
  $menuhaschild = array();

  foreach($items as $key => $item) {

    if (in_array('menu-item-has-children',$item->classes)) {
      $menuhaschild[] = $item->ID;
    }

  }

  foreach($menuhaschild as $key => $parent_id) {
    foreach($items as $key => $item) {
      if ($item->menu_item_parent==$parent_id) {
        $item->classes[] = 'menu-item-first-child';
        break;
      }
    }
  }


  return $items;
}
add_filter('wp_nav_menu_objects', 'add_class_to_first_submenu');


function dt_page_menu( $args = array() ) {

  $defaults = array('sort_column' => 'menu_order, post_title', 'menu_class' => 'menu','container_class'=>'','container'=>'div', 'echo' => true, 'link_before' => '', 'link_after' => '');

  $args = wp_parse_args( $args, $defaults );

  $args = apply_filters( 'wp_page_menu_args', $args );



  $menu = '';



  $list_args = $args;



  // Show Home in the menu

  if ( ! empty($args['show_home']) ) {

    if ( true === $args['show_home'] || '1' === $args['show_home'] || 1 === $args['show_home'] )

      $text = __('Home','cleanco');

    else

      $text = $args['show_home'];

    $class = '';

    if ( is_front_page() && !is_paged() )

      $class = 'class="current_page_item"';

    $menu .= '<li ' . sanitize_html_class($class) . '><a href="' . esc_url(home_url( '/' )) . '">' . $args['link_before'] . $text . $args['link_after'] . '</a></li>';

    // If the front page is a page, add it to the exclude list

    if (get_option('show_on_front') == 'page') {

      if ( !empty( $list_args['exclude'] ) ) {

        $list_args['exclude'] .= ',';

      } else {

        $list_args['exclude'] = '';

      }

      $list_args['exclude'] .= get_option('page_on_front');

    }

  }



  $list_args['echo'] = false;

  $list_args['title_li'] = '';

  $menu .= str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages($list_args) );



  if ( $menu )

    $menu = '<ul class="' . esc_attr($args['menu_class']) . '">' . $menu . '</ul>';



  $menu = '<'.esc_attr($args['container']).' class="' . esc_attr($args['container_class']) . '">' . $menu . "</".esc_attr($args['container']).">\n";

  $menu = apply_filters( 'wp_page_menu', $menu, $args );

  if ( $args['echo'] )

    echo $menu;

  else

    return $menu;

}





function dt_tag_cloud_args($args=array()){



  $args['filter']=1;

  return $args;

}



function dt_tag_cloud($return="",$tags, $args = '' ){

  if(!count($tags))
    return $return;
  $return='<ul class="list-unstyled">';
  foreach ($tags as $tag) {
    $return.='<li class="tag"><a href="'.esc_url($tag->link).'">'.ucwords($tag->name).'</a></li>';
  }
  $return.='</ul>';
  return $return;
}

function dt_widget_title($title="",$instance=array(),$id=null){
  if(empty($instance['title']))
      return "";
  return $title;
}

add_filter('widget_tag_cloud_args','dt_tag_cloud_args');
add_filter('wp_generate_tag_cloud','dt_tag_cloud',1,3);
add_filter('widget_title','dt_widget_title',1,3);

if(!function_exists('get_avatar_url')){
  function get_avatar_url($author_id,$args=array()){

        $get_avatar=get_avatar( $author_id, $args);

        preg_match("/src='(.*?)'/i", $get_avatar, $matches);
        if (isset($matches[1])) {
          return $matches[1];
        } else {
          return;
        }
  }

}

// Comment Functions

function dt_comment_form( $args = array(), $post_id = null ) {
  if ( null === $post_id )
    $post_id = get_the_ID();
  else
    $id = $post_id;

  $commenter = wp_get_current_commenter();
  $user = wp_get_current_user();
  $user_identity = $user->exists() ? $user->display_name : '';

  $args = wp_parse_args( $args );
  if ( ! isset( $args['format'] ) )
    $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

  $req      = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );
  $html5    = 'html5' === $args['format'];
  
  $fields   =  array(
    'author' => '<div class="row">
                    <div class="form-group col-xs-12 col-sm-4">
                      <i class="icon-user-1"></i>
                      <input type="text" class="form-control" name="author" id="author" placeholder="'.sanitize_title(__('full name','cleanco')).'" required>
                  </div>',
    'email' => '<div class="form-group col-xs-12 col-sm-4">
                      <i class="icon-mail-7"></i>
                      <input type="email" class="form-control"  name="email" id="email" placeholder="'.sanitize_title(__('email address','cleanco')).'" required>
                  </div>',
    'url' => '<div class="form-group col-xs-12 col-sm-4">
                  <i class="icon-globe-6"></i>
                  <input type="text" class="form-control icon-user-1" name="url" id="url" placeholder="website">
                </div>
              </div>',
  );

  $required_text = sprintf( ' ' . __('Required fields are marked %s','cleanco'), '<span class="required">*</span>' );
  $defaults = array(
    'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
    'comment_field'        => '<div class="row">
                                  <div class="form-group col-xs-12">
                                    <textarea class="form-control" rows="3" name="comment" id="comment" placeholder="'.sanitize_title(__('your message','cleanco')).'" required></textarea>

                                  </div>
                              </div>',
    'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.','cleanco' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','cleanco' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
    'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.','cleanco' ) . ( $req ? $required_text : '' ) . '</p>',
    'comment_notes_after'  => '',
    'id_form'              => 'commentform',
    'id_submit'            => 'submit',
    'title_reply'          => '<div class="comment-leave-title heading_text_color">'.__('Leave a Comment','cleanco').'</div>',
    'title_reply_to'       => __( 'Leave a Comment to %s','cleanco' ),
    'cancel_reply_link'    => __( 'Cancel reply','cleanco' ),
    'label_submit'         => __( 'Submit','cleanco' ),
    'format'               => 'html5',
  );

  $args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

  ?>
    <?php if ( comments_open( $post_id ) ) : ?>

      <?php do_action( 'comment_form_before' ); ?>
      <section id="respond" class="comment-respond">
        <div id="reply-title" class="comment-reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></div>
        <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
          <?php echo $args['must_log_in']; ?>
          <?php do_action( 'comment_form_must_log_in_after' ); ?>
        <?php else : ?>
          <form action="<?php echo esc_url(site_url( '/wp-comments-post.php' )); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>" class="comment-form"<?php echo ($html5) ? ' novalidate' : ''; ?> data-abide>
            <?php do_action( 'comment_form_top' ); ?>
            <?php 
              if ( is_user_logged_in() ) :
                echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );
                do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
                echo $args['comment_notes_before'];
              else : 
                do_action( 'comment_form_before_fields' );
                foreach ( (array) $args['fields'] as $name => $field ) {
                  echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                }
                do_action( 'comment_form_after_fields' );
              endif; 
            ?>
            <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
            <?php echo $args['comment_notes_after']; ?>
            <p class="form-submit">
              <input name="submit" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo sanitize_text_field( $args['label_submit'] ); ?>" class="btn btn-ghost skin-dark float-right" />
              <?php comment_id_fields( $post_id ); ?>
            </p>
            <?php do_action( 'comment_form', $post_id ); ?>
          </form>
        <?php endif; ?>
        <h6>&nbsp;</h6>
      </section><!-- #respond -->
      <?php do_action( 'comment_form_after' ); ?>
    <?php else : ?>
      <?php do_action( 'comment_form_comments_closed' ); ?>
    <?php endif; ?>
  <?php
}


function dt_get_comment_reply_link($args = array(), $comment = null, $post = null) {
  global $user_ID;

  $defaults = array('add_below' => 'comment', 'respond_id' => 'respond', 'reply_text' => __('Reply','cleanco'),
    'login_text' => __('Log in to Reply','cleanco'), 'depth' => 0, 'before' => '', 'after' => '');

  $args = wp_parse_args($args, $defaults);

  if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] )
    return;

  extract($args, EXTR_SKIP);

  $comment = get_comment($comment);
  if ( empty($post) )
    $post = $comment->comment_post_ID;
  $post = get_post($post);

  if ( !comments_open($post->ID) )
    return false;

  $link = '';

  if ( get_option('comment_registration') && !$user_ID )
    $link = '<a rel="nofollow" class="comment-reply-login" href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . $login_text . '</a>';
  else 
    $link = "<a class='reply comment-reply-link btn-ghost btn skin-dark' href='#' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\")'>$reply_text</a>";
  
  return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
}

function dt_comment_reply_link($args = array(), $comment = null, $post = null) {
  echo dt_get_comment_reply_link($args, $comment, $post);
}

if ( ! function_exists( 'dt_edit_comment_link' ) ) :
  function dt_edit_comment_link( $link = null, $before = '', $after = '' ) {
    global $comment;

    if ( !current_user_can( 'edit_comment', $comment->comment_ID ) )
      return;

    if ( null === $link )
      $link = __('Edit This','cleanco');

    $link = '<a class="comment-edit-link btn btn-ghost skin-dark" href="' . esc_url(get_edit_comment_link( $comment->comment_ID )) . '">' . $link . '</a>';
    echo $before . apply_filters( 'edit_comment_link', $link, $comment->comment_ID ) . $after;
  }
endif; 

if ( ! function_exists( 'dt_comment' ) ) :

function dt_comment( $comment, $args, $depth ) {

  $GLOBALS['comment'] = $comment;
  switch ( $comment->comment_type ) :
    case 'pingback' :
    case 'trackback' :
      // Display trackbacks differently than normal comments.
      ?>
      <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
      <p><?php _e( 'Pingback:', 'cleanco' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'cleanco' ), '<span class="edit-link">', '</span>' ); ?></p></li>
      <?php
    break;
  
    default :
      // Proceed with normal comments.

      ?>
              <div class="dt-reply-line"></div>
              <li class="comment_item media depth_<?php echo sanitize_html_class($depth); ?>" id="comment-<?php print sanitize_html_class($comment->comment_ID); ?>">

                <?php if ($args['has_children']) : ?>
                  <!--div class="dt-reply-vertical-line"></div-->
                <?php endif; ?>

                <div class="pull-left text-center">
                  <?php $avatar_url = get_avatar_url($comment,array('size'=>100 )); ?>
                  <a href="<?php comment_author_url(); ?>"><img src="<?php echo esc_url($avatar_url); ?>" class="author-avatar img-responsive img-circle" alt="<?php esc_attr(comment_author()); ?>"></a>
                </div>

                <div class="media-body">
                  <div class="col-xs-12 col-sm-5 dt-comment-author heading_text_color"><?php comment_author(); ?></div>
                  <div class="col-xs-12 col-sm-7 dt-comment-date text-right"><?php comment_date('d.m.Y') ?></div>
                  <div class="col-xs-12 dt-comment-comment"><?php comment_text(); ?></div>
                  <div class="col-xs-12 text-right">
                    <?php dt_comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'cleanco' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    <?php dt_edit_comment_link( __( 'Edit', 'cleanco' ), '', '' ); ?>
                  </div>
                </div>
              </li>

      <?php
    break;
  endswitch; // end comment_type check
}
endif; 


function detheme_gallery($out,$attr=array()) {
  global $cleanco_revealData;
  $post = get_post();

  if( 'port'==$post->post_type)
      return '<!-- gallery -->';

  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
      $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
  }

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post ? $post->ID : 0,
    'itemtag'    => 'dl',
    'icontag'    => 'dt',
    'captiontag' => 'dd',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => '',
    'link'       => '',
    'type' =>'', 
    'modal_type' =>'' 
  ), $attr, 'gallery'));

  if($type!='')
    return $out;

  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';

  if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }

  if ( empty($attachments) )
    return '';

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $itemtag = tag_escape($itemtag);
  $captiontag = tag_escape($captiontag);
  $icontag = tag_escape($icontag);
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'dl';
  if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'dd';
  if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'dt';

  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "<style type='text/css'>#{$selector} {margin: auto;}#{$selector} .gallery-item { float: {$float}; margin-top: 10px; text-align: center; width: {$itemwidth}%; } #{$selector} img { border: 2px none #cfcfcf; } #{$selector} .gallery-caption { margin-left: 0; } /* see gallery_shortcode() in wp-includes/media.php */</style>";
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
    if ( ! empty( $link ) && 'file' === $link ) {
      $url = wp_get_attachment_url($id);

      $image_output = '<a href="'.esc_url($url).'" data-modal="modal_post_'.$instance."_".$id.'" onClick="return false;" class="md-trigger">'.wp_get_attachment_image( $id, $size, false).'</a>';


      //$image_output = wp_get_attachment_link( $id, $size, false, false );
    } elseif ( ! empty( $link ) && 'none' === $link )
      $image_output = wp_get_attachment_image( $id, $size, false );
    else
      $image_output = wp_get_attachment_link( $id, $size, true, false );

    $image_meta  = wp_get_attachment_metadata( $id );

    $output .= "<{$itemtag} class='gallery-item'><{$icontag} class='gallery-icon'>$image_output</{$icontag}>";

    $output_popup = "";

    if('file'==$link){

      if($modal_type==''){

        if(!$modal_type=get_cleanco_option('dt-select-modal-effects')) { 
            $modal_type = 'md-effect-15';
        }         
      } 

      $output_popup = '<div id="modal_post_'.$instance."_".$id.'" class="popup-gallery md-modal '.sanitize_html_class($modal_type).'">
        <div class="md-content secondary_color_bg">
          <img src="#" rel="'. wp_get_attachment_url($id) .'" class="img-responsive" alt="'.esc_attr(sanitize_title($attachment->post_title)).'"/>';
      if(!empty($attachment->post_excerpt)):
      
      $output_popup.='<div class="md-description secondary_color_bg">'."
        " . wptexturize($attachment->post_excerpt) . '
          </div>';
      endif;

      $output_popup.='<button class="button md-close right btn-cross secondary_color_button"><i class="icon-cancel"></i></button>
        </div>
      </div>'."\n";

      array_push($cleanco_revealData, $output_popup);
    }
    else{

      if ( $captiontag && trim($attachment->post_excerpt)) {

        $output .= "
          <{$captiontag} class='wp-caption-text gallery-caption'>
          " . wptexturize($attachment->post_excerpt) . "
          </{$captiontag}>";
      }

    }



    $output .= "</{$itemtag}>";
    if ( $columns > 0 && ++$i % $columns == 0 )
      $output .= '<br style="clear: both" />';
  }

  $output .= "
      <br style='clear: both;' />
    </div>\n";

  $output = nl2space($output);
  return $output;
}


function load_modal_media_effect(){

  $modal_options=
  array('md-effect-1'=>__('Fade in and scale up','cleanco'),
        'md-effect-2'=>__('Slide from the right','cleanco'),
         'md-effect-3'=>__('Slide from the bottom','cleanco'),
         'md-effect-4'=>__('Newspaper','cleanco'),
         'md-effect-5'=>__('Fall','cleanco'),
         'md-effect-6'=>__('Side fall','cleanco'),
         'md-effect-7'=>__('Slide and stick to top','cleanco'),
         'md-effect-8'=>__('3D flip horizontal','cleanco'),
         'md-effect-9'=>__('3D flip vertical','cleanco'),
         'md-effect-10'=>__('3D sign','cleanco'),
         'md-effect-11'=>__('Super scaled','cleanco'),
         'md-effect-12'=>__('Just me','cleanco'),
         'md-effect-13'=>__('3D slit','cleanco'),
         'md-effect-14'=>__('3D Rotate from bottom','cleanco'),
         'md-effect-15'=>__('3D Rotate in from left (Default)','cleanco'),
         'md-effect-16'=>__('Blur','cleanco'),
         'md-effect-17'=>__('Slide in from bottom with perspective on container','cleanco'),
         'md-effect-18'=>__('Slide from right with perspective on container','cleanco'),
         'md-effect-19'=>__('Slip in from the top with perspective on container','cleanco')
   );

  if (!$default_md_effect=get_cleanco_option('dt-select-modal-effects')) { 
     $default_md_effect = 'md-effect-15';
  }
?>
<script type="text/html" id="tmpl-detheme-gallery-settings">
      <label class="setting">
        <span><?php _e( 'Modal Effects Option', 'cleanco' ); ?></span>
        <select class="modal_type" name="modal_type" data-setting="modal_type">
          <?php foreach ( $modal_options as $value => $caption ) : ?>
            <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $default_md_effect ); ?>><?php echo $caption; ?></option>
          <?php endforeach; ?>
        </select>
      </label>
</script>

<script type="text/javascript">
jQuery(document).ready(function($){

  var media = wp.media;
  media.view.Settings.Gallery = media.view.Settings.Gallery.extend({
    render: function() {
      var $el = this.$el;

      media.view.Settings.prototype.render.apply( this, arguments );

      // Append the type template and update the settings.
      $el.append( media.template( 'detheme-gallery-settings' ) );

      // Hide the Columns setting for all types except Default
      $el.find( 'select.link-to' ).on( 'change', function () {
        
        var modal_type = $el.find( 'select[name=modal_type]' ).closest( 'label.setting' );

        if ( 'file' === $( this ).val() ) {
          modal_type.show();
        } else {
          modal_type.hide();
        }
      } ).change();

      return this;
    }
  });
});
</script>
<?php

}


if(!defined('JETPACK__VERSION')){
   add_filter( 'post_gallery','detheme_gallery', 99999, 2 );
   add_action( 'print_media_templates', 'load_modal_media_effect');
}

add_filter('post_gallery','getPortfolioGallery',1,2);

function getPortfolioGallery($out,$attr=array()){

  global $post,$carouselGallery;


  if( 'port'!==$post->post_type || isset($attr['is_widget']) || ($carouselGallery!=='' && $carouselGallery))
      return '';


 if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

    extract(shortcode_atts(array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'id'         => $post ? $post->ID : 0,
      'itemtag'    => 'dl',
      'icontag'    => 'dt',
      'captiontag' => 'dd',
      'columns'    => 3,
      'size'       => 'thumbnail',
      'include'    => '',
      'exclude'    => '',
      'link'       => '',
      'type'       =>'',
    ), $attr, 'gallery'));


    if($type!='')
      return $out;

    $id = intval($id);

    if ( 'RAND' == $order )
      $orderby = 'none';

    if ( !empty($include) ) {
      $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

      $attachments = array();
      foreach ( $_attachments as $key => $val ) {
        $attachments[$val->ID] = $_attachments[$key];
      }
    } elseif ( !empty($exclude) ) {
      $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
      $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) ){
      return '';
    }

    $carouselGallery='<div id="portfolio-carousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">';
  $i=0;

  foreach ( $attachments as $id => $attachment ) {
  
      $url = wp_get_attachment_url($id);

      $carouselGallery.='<div class="item'.((0==$i)?" active":"").'">
                      <img src="'.esc_url($url).'" alt="'.esc_attr(sanitize_title($attachment->post_title)).'">
                    </div>';
      $i++;

    }

    $carouselGallery.='</div>
                  <div class="post-gallery-carousel-nav">
                  <div class="post-gallery-carousel-buttons">                  
                  <a class="secondary_color_button btn skin-light" href="#portfolio-carousel" data-slide="prev">
                    <span><i class="flaticon-arrow427"></i></span>
                  </a>
                  <a class="secondary_color_button btn skin-light" href="#portfolio-carousel" data-slide="next">
                    <span><i class="flaticon-arrow413"></i></span>
                  </a>
                  </div>
                  </div>
                </div>';


    return "<!-- gallery -->";

}

if(!function_exists('nl2space')){
    function nl2space($str) {
        $arr=explode("\n",$str);
        $out='';

        for($i=0;$i<count($arr);$i++) {
            if(strlen(trim($arr[$i]))>0)
                $out.= trim($arr[$i]).' ';
        }
        return $out;
    }
}

function dt_gallery_shortcode($attr) {
  global $cleanco_revealData;
  $post = get_post();

  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
      $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
  }

  // Allow plugins/themes to override the default gallery template.
  $output = apply_filters('post_gallery', '', $attr);


  if ( $output != '' )
    return $output;

  // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
  if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
      unset( $attr['orderby'] );
  }

  extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post ? $post->ID : 0,
    'itemtag'    => 'dl',
    'icontag'    => 'dt',
    'captiontag' => 'dd',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => '',
    'link'       => ''
  ), $attr, 'gallery'));

  $id = intval($id);
  if ( 'RAND' == $order )
    $orderby = 'none';

  if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }

  if ( empty($attachments) )
    return '';

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
      $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
  }

  $itemtag = tag_escape($itemtag);
  $captiontag = tag_escape($captiontag);
  $icontag = tag_escape($icontag);
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'dl';
  if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'dd';
  if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'dt';

  $columns = intval($columns);
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = $gallery_div = '';
  if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "<style type='text/css'>#{$selector} {margin: auto;}#{$selector} .gallery-item { float: {$float}; margin-top: 10px; text-align: center; width: {$itemwidth}%; } #{$selector} img { border: 2px none #cfcfcf; } #{$selector} .gallery-caption { margin-left: 0; } /* see gallery_shortcode() in wp-includes/media.php */</style>";
  $size_class = sanitize_html_class( $size );
  $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {
    if ( ! empty( $link ) && 'file' === $link ) {
      $url = wp_get_attachment_url($id);

      $image_output = '<a href="'.esc_url($url).'" data-modal="modal_post_'.$id.'" onClick="return false;" class="md-trigger">'.wp_get_attachment_image( $id, $size, false).'</a>';

    } elseif ( ! empty( $link ) && 'none' === $link )
      $image_output = wp_get_attachment_image( $id, $size, false );
    else
      $image_output = wp_get_attachment_link( $id, $size, true, false );

    $image_meta  = wp_get_attachment_metadata( $id );

    $output .= "<{$itemtag} class='gallery-item'><{$icontag} class='gallery-icon'>$image_output</{$icontag}>";

    $output_popup = "";

    if('file'==$link){

      if (!$md_effect=get_cleanco_option('dt-select-modal-effects')) { 
        $md_effect = 'md-effect-15';
      } 

      $output_popup = '<div id="modal_post_'.$id.'" class="popup-gallery md-modal '.$md_effect.'">
        <div class="md-content secondary_color_bg">
          <img src="#" rel="'. wp_get_attachment_url($id) .'" class="img-responsive" alt="'.sanitize_title($attachment->post_title).'"/>';
      if(!empty($attachment->post_excerpt)):
      
      $output_popup.='<div class="md-description secondary_color_bg">'."
        " . wptexturize($attachment->post_excerpt) . '
          </div>';
      endif;

      $output_popup.='<button class="button md-close right btn-cross secondary_color_button"><i class="icon-cancel"></i></button>
        </div>
      </div>'."\n";

      array_push($cleanco_revealData, $output_popup);
    }
    else{

      if ( $captiontag && trim($attachment->post_excerpt)) {

        $output .= "
          <{$captiontag} class='wp-caption-text gallery-caption'>
          " . wptexturize($attachment->post_excerpt) . "
          </{$captiontag}>";
      }

    }



    $output .= "</{$itemtag}>";
    if ( $columns > 0 && ++$i % $columns == 0 )
      $output .= '<br style="clear: both" />';
  }

  $output .= "
      <br style='clear: both;' />
    </div>\n";

  $output = nl2space($output);
  return $output;
}

// function to display number of posts.
function dt_get_post_views($postID){

    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return sprintf(__("%d View",'cleanco'),0);
    } elseif ($count<=1) {
        return sprintf(__("%d View",'cleanco'),$count);  
    }


    $output = str_replace('%', number_format_i18n($count),__('% Views'));
    return $output;
}

function dt_get_post_view_number($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    return (int)$count;
}

// function to display number of posts without "Views" Text.
function dt_get_post_views_number($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

// function to count views.
function dt_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'dt_posts_column_views');
add_action('manage_posts_custom_column', 'dt_posts_custom_column_views',5,2);

function dt_posts_column_views($defaults){
    $defaults['post_views'] = __('Views','cleanco');
    return $defaults;
}

function dt_posts_custom_column_views($column_name, $id){
  if($column_name === 'post_views'){
        echo dt_get_post_views(get_the_ID());
    }
}

function detheme_plugin_is_active( $plugin ) {
  return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || detheme_plugin_is_active_for_network( $plugin );
}

function detheme_plugin_is_active_for_network( $plugin ) {
  if ( !is_multisite() )
    return false;

  $plugins = get_site_option( 'active_sitewide_plugins');
  if ( isset($plugins[$plugin]) )
    return true;

  return false;
}


/** Breadcrumbs **/
/** http://dimox.net/wordpress-breadcrumbs-without-a-plugin/ **/

function detheme_dimox_breadcrumb($args=array()){

  $args=wp_parse_args($args,array(
    'wrap_before' => '<div class="breadcrumbs">',
    'wrap_after' => '</div>',
    'format' => '<span%s>%s</span>',
    'delimiter'=>'/',
    'current_class' => 'current',
    'home_text' => esc_html__('Home','cleanco'), 
    'home_link' => home_url('/')
   ));

   $breadcrumbs=detheme_get_breadcrumbs($args);

    if (detheme_plugin_is_active('woocommerce/woocommerce.php') && (is_product()||is_cart()||is_checkout()||is_shop()||is_product_category())) {
      // do nothing
      // woocomerce has different breadcrumb method
    } else {
       $out=$args['wrap_before'];
       $out.=join($args['delimiter']."\n",is_rtl()?array_reverse($breadcrumbs):$breadcrumbs);
       $out.=$args['wrap_after'];
       print $out;
    }
}

if ( ! function_exists( 'detheme_woocommerce_breadcrumb' ) ) {

  /**
   * Output the WooCommerce Breadcrumb
   */
  function detheme_woocommerce_breadcrumb(&$breadcrumbs, $args = array() ) {
    $wc_breadcrumb_args = array(
      'delimiter' => $args['delimiter'],
      'wrap_before' => '<div class="breadcrumbs">',
      'wrap_after' => '</div>',
      'before' => '<span>',
      'beforecurrent' => '<span class="current">',
      'after' => '</span>',
      'home' => $args['home_text'],
    );

    woocommerce_breadcrumb($wc_breadcrumb_args);

  }
}



function detheme_get_breadcrumbs($breadcrumb_args) {
  global $post;

   $breadcrumbs[]=sprintf($breadcrumb_args['format'],is_front_page()?' class="current"':'','<a href="'.esc_url($breadcrumb_args['home_link']).'" title="'.$breadcrumb_args['home_text'].'">'.$breadcrumb_args['home_text'].'</a>');

  if (is_front_page()) { // home page
  } elseif (is_home()) { // blog page
      detheme_get_breadcrumbs_from_menu(get_option('page_for_posts'),$breadcrumbs,$breadcrumb_args);

  } elseif (is_singular('dtpost')||is_singular('dtreportpost')||is_singular('essential_grid')) {


      $post_type_data = get_post_type_object($post->post_type);
      $post_type_slug = $post_type_data->rewrite['slug'];
      $page = get_page_by_path($post_type_slug);

      if ($page) {
        detheme_get_breadcrumbs_from_menu($page->ID,$breadcrumbs,$breadcrumb_args,false);
      }

      array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));

  } elseif (is_singular()) {
        if (detheme_plugin_is_active('woocommerce/woocommerce.php') && (is_product()||is_cart()||is_checkout())) {

            detheme_woocommerce_breadcrumb($breadcrumbs,$breadcrumb_args);
        } else if (is_single()) {
            detheme_get_breadcrumbs_from_menu(get_option('page_for_posts'),$breadcrumbs,$breadcrumb_args,false);
            array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
        } else {
            detheme_get_breadcrumbs_from_menu($post->ID,$breadcrumbs,$breadcrumb_args);
            if (count($breadcrumbs) < 2 ) {
              array_push($breadcrumbs, sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",$post->post_title));
            }
        }
  } else {
      $post_id = -1;
      if (detheme_plugin_is_active('woocommerce/woocommerce.php') && (is_shop()||is_product_category())) {

        detheme_woocommerce_breadcrumb($breadcrumbs,$breadcrumb_args);

      } else {

        if(is_category()){
          $breadcrumbs[]=sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",single_cat_title(' ',false));
        }
        elseif(is_archive()){
          $breadcrumbs[]=sprintf($breadcrumb_args['format']," class=\"".$breadcrumb_args['current_class']."\"",is_tag()||is_tax()?single_tag_title(' ',false):single_month_title( ' ', false ));
        }
        else{
          if (isset($post->ID)) {
            $post_id = $post->ID;
            detheme_get_breadcrumbs_from_menu($post_id,$breadcrumbs,$breadcrumb_args);
          }
        }
      }
  }

  return apply_filters('detheme_dimox_breadcrumbs',$breadcrumbs,$breadcrumb_args);
}


function detheme_get_breadcrumbs_from_menu($post_id,&$breadcrumbs,$args,$iscurrent=true) {
  $primary = get_nav_menu_locations();

  if (isset($primary['primary'])) {
    $navs = wp_get_nav_menu_items($primary['primary']);

    if (!empty($navs)) :
      foreach ($navs as $nav) {
        if (($nav->object_id)==$post_id) {

          if ($nav->menu_item_parent!=0) {
            //start recursive by menu parent
            detheme_get_breadcrumbs_from_menu_by_menuid($nav->menu_item_parent,$breadcrumbs,$args);
          }

          if ($iscurrent) {
            array_push($breadcrumbs, sprintf($args['format']," class=\"".$args['current_class']."\"",$nav->title));
          } else {
            array_push($breadcrumbs, sprintf($args['format'],"", '<a href="'.esc_url($nav->url).'" title="'.esc_attr($nav->title).'">'.$nav->title .'</a>' ));
          }

          break;
        }
      }
    endif; 
  }  
}

function detheme_get_breadcrumbs_from_menu_by_menuid($menu_id,&$breadcrumbs,$args) {
  $primary = get_nav_menu_locations();

  if (isset($primary['primary'])) {
    $navs = wp_get_nav_menu_items($primary['primary']);

    foreach ($navs as $nav) {
      if (($nav->ID)==$menu_id) {

        if ($nav->menu_item_parent!=0) {
          //recursive by menu parent
          detheme_get_breadcrumbs_from_menu_by_menuid($nav->menu_item_parent,$breadcrumbs,$args);
        }

        array_push($breadcrumbs, sprintf($args['format'],"",'<a href="'.esc_url($nav->url).'" title="'.esc_attr($nav->title).'">'.$nav->title .'</a>'));

        break;
      }
    } 
  } 
}



if(!function_exists('detheme_is_ssl_mode')){
function detheme_is_ssl_mode(){
  $ssl=strpos("a".site_url(),'https://');

  return (bool)$ssl;
}}

function detheme_maybe_ssl_url($url=""){
  return detheme_is_ssl_mode()?str_replace('http://', 'https://', $url):$url;
}


if (!function_exists('aq_resize')) {
  function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {

    if(!$url OR !($width || $height)) return false;

    //define upload path & dir
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];
    
    //check if $img_url is local
    /* Gray this out because WPML doesn't like it.
    if(strpos( $url, home_url() ) === false) return false;
    */
    
    //define path of image
    $rel_path = str_replace( str_replace( array( 'http://', 'https://' ),"",$upload_url), '', str_replace( array( 'http://', 'https://' ),"",$url));
    $img_path = $upload_dir . $rel_path;
    
    //check if img path exists, and is an image indeed
    if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;
    
    //get image info
    $info = pathinfo($img_path);
    $ext = $info['extension'];
    list($orig_w,$orig_h) = getimagesize($img_path);
    
    $dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
    if(!$dims){
      return $single?$url:array('0'=>$url,'1'=>$orig_w,'2'=>$orig_h);
    }

    $dst_w = $dims[4];
    $dst_h = $dims[5];

    //use this to check if cropped image already exists, so we can return that instead
    $suffix = "{$dst_w}x{$dst_h}";
    $dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

    //if orig size is smaller
    if($width >= $orig_w) {

      if(!$dst_h) :
        //can't resize, so return original url
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
        
      else :
        //else check if cache exists
        if(file_exists($destfilename) && getimagesize($destfilename)) {
          $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
        } 
        else {

          $imageEditor=wp_get_image_editor( $img_path );

          if(!is_wp_error($imageEditor)){

              $imageEditor->resize($width, $height, $crop );
              $imageEditor->save($destfilename);

              $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
              $img_url = $upload_url . $resized_rel_path;


          }
          else{
              $img_url = $url;
              $dst_w = $orig_w;
              $dst_h = $orig_h;
          }

        }
        
      endif;
      
    }
    //else check if cache exists
    elseif(file_exists($destfilename) && getimagesize($destfilename)) {
      $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
    } 
    else {

      $imageEditor=wp_get_image_editor( $img_path );

      if(!is_wp_error($imageEditor)){
          $imageEditor->resize($width, $height, $crop );
          $imageEditor->save($destfilename);

          $resized_rel_path = str_replace( $upload_dir, '', $destfilename);
          $img_url = $upload_url . $resized_rel_path;
      }
      else{
          $img_url = $url;
          $dst_w = $orig_w;
          $dst_h = $orig_h;
      }


    }
    
    if(!$single) {
      $image = array (
        '0' => $img_url,
        '1' => $dst_w,
        '2' => $dst_h
      );
      
    } else {
      $image = $img_url;
    }
    
    return $image;
  }
}


if (!function_exists('mb_strlen'))
{
  function mb_strlen($str="")
  {
    return strlen($str);
  }
}

function wp_trim_chars($text, $num_char = 55, $more = null){

  if ( null === $more )
    $more = '';
  $original_text = $text;
  $text = wp_strip_all_tags( $text );

  $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_char + 1, PREG_SPLIT_NO_EMPTY );
  $text = @implode( ' ', $words_array );
  
  
  if ( strlen( $text ) > $num_char ) {
  
    $text = substr($text,0, $num_char );
    $text = $text . $more;
  }

  return apply_filters( 'wp_trim_chars', $text, $num_char, $more, $original_text );
}

if(!function_exists('hex2rgb')){
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb; // returns an array with the rgb values
}
}

function responsiveVideo($html, $data, $url) {

  $html=add_video_wmode_transparent($html);

  if (!is_admin() && !preg_match("/flex\-video/mi", $html) ) {
    $html="<div class=\"flex-video widescreen\">".$html."</div>";
  }
  return $html;
}

add_filter('embed_handler_html', 'responsiveVideo', 92, 3 ); 
add_filter('oembed_dataparse', 'responsiveVideo', 90, 3 );
add_filter('embed_oembed_html', 'responsiveVideo', 91, 3 );

function add_video_wmode_transparent($html) {
   if (strpos($html, "<iframe " ) !== false) {
      $search = array('?feature=oembed');
      $replace = array('?feature=oembed&wmode=transparent&rel=0&autohide=1&showinfo=0');
      $html = str_replace($search, $replace, $html);

      return $html;
   } else {
      return $html;
   }
}

function makeBottomWidgetColumn($params){

  if('detheme-bottom'==$params[0]['id']){

    $class="col-sm-4";

    $col=(int)get_cleanco_option('dt-footer-widget-column',1);

    switch($col){

        case 2:
              $class='col-md-6 col-sm-6 col-xs-6';
          break;
        case 3:
              $class='col-md-4 col-sm-6 col-xs-6';
          break;
        case 4:
              $class='col-lg-3 col-md-4 col-sm-6 col-xs-6';
          break;
        case 1:
        default:
              $class='col-sm-12';
          break;
    }


    $makerow="";


    $params[0]['before_widget']='<div class="border-left '.$class.' col-'.$col.'">'.$params[0]['before_widget'];
    $params[0]['after_widget']=$params[0]['after_widget'].'</div>'.$makerow;

 }

  return $params;

}

function detheme_protected_meta($protected, $meta_key, $meta_type){

 $protected=(in_array($meta_key,
    array('vc_teaser','slide_template','pagebuilder','masonrycolumn','portfoliocolumn','portfoliotype','post_views_count','show_comment','show_social','sidebar_position','subtitle')
  ))?true:$protected;

  return $protected;
}

add_filter('is_protected_meta','detheme_protected_meta',1,3);


add_filter( 'dynamic_sidebar_params', 'makeBottomWidgetColumn' );

function fill_width_dummy_widget (){

   $col=(int)get_cleanco_option('dt-footer-widget-column',1);

   $sidebar = wp_get_sidebars_widgets();


   $itemCount=(isset($sidebar['detheme-bottom']))?count($sidebar['detheme-bottom']):0;

   switch($col){

          case 2:
                $class='col-md-6 col-sm-6 col-xs-6';
            break;
          case 3:
                $class='col-md-4 col-sm-6 col-xs-6';
            break;
          case 4:
                $class='col-lg-3 col-md-4 col-sm-6 col-xs-6';
            break;
          case 1:
          default:
                $class='col-sm-12';
            break;
  }


  if($itemCount % $col){
   print str_repeat("<div class=\"border-left dummy ".$class."\"></div>",$col - ($itemCount % $col));
 }



}

add_action('dynamic_sidebar_detheme-bottom','fill_width_dummy_widget');

function remove_shortcode_from_content($content) {
    $content = strip_shortcodes( $content );
    $content = preg_replace('/<img[^>]+./','', $content);
  return $content;
}

// Remove video from content              
function removeVideo($html, $data, $url) {
  return '';
}

function remove_first_audio_shortcode_from_content($content) {
  //Find audio shotcode in content
  $pattern = get_shortcode_regex();
  preg_match_all( '/'. $pattern .'/s', $content, $matches );

  /* find first audio shortcode */
  $i = 0;
  $hasaudioshortcode = false;

  foreach ($matches[2] as $shortcodetype) {
    if ($shortcodetype=='audio') {
      $hasaudioshortcode = true;
      break;
    }
      $i++;
  }

  if ($hasaudioshortcode) {
    $content = str_replace($matches[0][$i],'',$content);
  }

  return $content;
}

function remove_first_gallery_shortcode_from_content($content) {
  //Find audio shotcode in content
  $pattern = get_shortcode_regex();
  preg_match_all( '/'. $pattern .'/s', $content, $matches );

  /* find first audio shortcode */
  $i = 0;
  $hasgalleryshortcode = false;

  foreach ($matches[2] as $shortcodetype) {
    if ($shortcodetype=='gallery') {
      $hasgalleryshortcode = true;
      break;
    }
      $i++;
  }

  if ($hasgalleryshortcode) {
    $content = str_replace($matches[0][$i],'',$content);
  }

  return $content;
}

function remove_first_image_from_content($content) {
    global $post;

    /* Get Image from featured image */
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full',false); 
    if (isset($featured_image[0])) {
      //if image is featured image, it's not necessary to remove image from content
      return $content;
    } else {
      $imageurl1 = "";
      $imageurl2 = "";

      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
      if ($output>0) {
        $imageurl1 = $matches[1][0];
      }

      /* Get Image from content image that has caption shortcode */
      $pattern = get_shortcode_regex();
      preg_match_all( '/'. $pattern .'/s', $content, $matches );
      /* find first caption shortcode */
      $i = 0;
      $hascaption = false;
      foreach ($matches[2] as $shortcodetype) {
        if ($shortcodetype=='caption') {
          $hascaption = true;
          break;
        }
          $i++;
      }

      if ($hascaption) {
        preg_match('/^<a.*?href=(["\'])(.*?)\1.*$/', $matches[5][$i], $m);
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $m[0], $m2);
        $imageurl2 = $m2[1][0];
      }

      if ($imageurl1==$imageurl2) {
        //if image in caption tag
        $content = str_replace($matches[0][$i],'',$content);
      } else {
        //if image not in caption tag
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        if ($output>0) {
          $content = str_replace($matches[0][0],'',$content);
        }
      }

      return $content;

    }
}

function remove_first_video_shortcode_from_content($content) {
  $hasvideoshortcode = false;
  //Find video shotcode in content
  $pattern = get_shortcode_regex();
  $found = preg_match_all( '/'. $pattern .'/s', $content, $matches );

  // find first video shortcode
  $i = 0;
  if ($found>0) {
    foreach ($matches[2] as $shortcodetype) {
      if ($shortcodetype=='video') {
        $hasvideoshortcode = true;
        break;
      }
        $i++;
    }
  }

  if ($hasvideoshortcode) {
    $content = str_replace($matches[0][0],'',$content);
  }

  return $content;
}

function removeFirstURLVideo($html, $data, $url, $post_id) {
  global $post;

  $found = preg_match('@https?://(www.)?(youtube|vimeo)\.com/(watch\?v=)?([a-zA-Z0-9_-]+)@im', $post->post_content, $urls);
  $youtubelink = '';
  if ($found>0) {
    if (isset($urls[0])) {
      $youtubelink = $urls[0];
    } //if isset($urls[0])
  }
  
  if ($data==$youtubelink) {
    return '';
  } else {
    return $html;
  }
}

function get_first_image_url_from_content() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  if (isset($post->post_content)) {
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if (isset($matches[1][0])) {
      $first_img = $matches[1][0];
    }
  }

  return $first_img;
}
if(function_exists('vc_set_as_theme'))
{

  add_action('init','detheme_vc_cta_2');   

  function detheme_vc_cta_2(){

       vc_remove_param('vc_cta_button2','color');
        vc_add_param( 'vc_cta_button2', array( 
                "type" => "dropdown",
                "heading" => __("Button style", 'cleanco'),
                "param_name" => "btn_style",
                "value" => array(
                  __('Primary','cleanco')=>'color-primary',
                  __('Secondary','cleanco')=>'color-secondary',
                  __('Success','cleanco')=>'success',
                  __('Info','cleanco')=>'info',
                  __('Warning','cleanco')=>'warning',
                  __('Danger','cleanco')=>'danger',
                  __('Ghost Button','cleanco')=>'ghost',
                  __('Link','cleanco')=>'link',
                  ),
                "std" => 'default',
                "description" => __("Button style", 'cleanco')."."
                )
        );
     vc_add_param( 'vc_cta_button2',
        array(
          "type" => "dropdown",
          "heading" => __("Size", 'cleanco'),
          "param_name" => "size",
              "value" => array(
                __('Large','cleanco')=>'btn-lg',
                __('Default','cleanco')=>'btn-default',
                __('Small','cleanco')=>'btn-sm',
                __('Extra small','cleanco')=>'btn-xs'
                ),
          "std" => 'btn-default',
          "description" => __("Button size.", 'cleanco')
        ));
  }


  function remove_meta_box_vc(){
    remove_meta_box( 'vc_teaser','page','side');
  }

  add_action('admin_init','remove_meta_box_vc');   
  add_action('init','detheme_vc_posts_grid');   
  
  function detheme_vc_posts_grid(){

      vc_remove_param('vc_posts_grid','grid_layout');
      vc_remove_param('vc_posts_grid','grid_columns_count');

      vc_add_param( 'vc_posts_grid', array( 
              "type" => "dropdown",
              "heading" => __("Columns count", "js_composer"),
              "param_name" => "grid_columns_count",
              "value" => array(4, 3),
              "std" => 3,
              "admin_label" => true,
              "description" => __("Select columns count.", "js_composer")
              ));

  }

  add_action('init','detheme_vc_row');   

  if(version_compare(WPB_VC_VERSION,'4.7.0','>=')){
    vc_add_shortcode_param( 'attach_video', 'get_attach_video',get_template_directory_uri()."/lib/js/vc_editor.js");
  }
  else{
    add_shortcode_param( 'attach_video', 'get_attach_video',get_template_directory_uri()."/lib/js/vc_editor.js");
  }


 function get_attach_video($settings,$value){

    $dependency =version_compare(WPB_VC_VERSION,'4.7.0','>=') ? "":vc_generate_dependencies_attributes( $settings );

    $value=intval($value);

    $video='';

    if($value){

     
      $media_url=wp_get_attachment_url($value);
      $mediadata=wp_get_attachment_metadata($value);


      $videoformat="video/mp4";

      if(is_array($mediadata) && $mediadata['mime_type']=='video/webm'){
           $videoformat="video/webm";
      }

      $video='<video class="attached_video" data-id="'.$value.'" autoplay width="266">
      <source src="'.$media_url.'" type="'.$videoformat.'" /></video>';
    }

    $param_line = '<div class="attach_video_field" '.$dependency.'>';
    $param_line .= '<input type="hidden" class="wpb_vc_param_value '.$settings['param_name'].' '.$settings['type'].'" name="'.$settings['param_name'].'" value="'.($value?$value:'').'"/>';
    $param_line .= '<div class="gallery_widget_attached_videos">';
    $param_line .= '<ul class="gallery_widget_attached_videos_list">';
    $param_line .= '<li><a class="gallery_widget_add_video" href="#" title="'.esc_attr(__('Add Video', "cleanco")).'">'.($video!=''?$video:__('Add Video', "cleanco")).'</a>';
    $param_line .= '<a href="#" style="display:'.($video!=''?"block":"none").'" class="remove_attach_video">'.__('Remove Video','cleanco').'</a></li>';
    $param_line .= '</ul>';
    $param_line .= '</div>';
    $param_line .= '</div>';

    return $param_line;

  }

  function detheme_vc_row(){


     vc_add_param( 'vc_row', array( 
          'heading' => __( 'Expand section width', 'cleanco' ),
          'param_name' => 'expanded',
          'class' => '',
          'value' => array(__('Expand Column','cleanco')=>'1',__('Expand Background','cleanco')=>'2'),
          'description' => __( 'Make section "out of the box".', 'cleanco' ),
          'type' => 'checkbox',
          'group'=>__('Extended options', 'cleanco')
      ) );

       vc_add_param( 'vc_row',   array( 
              'heading' => __( 'Background Type', 'cleanco' ),
              'param_name' => 'background_type',
              'value' => array('image'=>__( 'Image', 'cleanco' ),'video'=>__( 'Video', 'cleanco' )),
              'type' => 'radio',
              'group'=>__('Extended options', 'cleanco'),
              'std'=>'image'
       ));

      if(version_compare(WPB_VC_VERSION,'4.7.0','>=')){

          vc_remove_param('vc_row','full_width');
          vc_remove_param('vc_row','video_bg');
          vc_remove_param('vc_row','video_bg_url');
          vc_remove_param('vc_row','video_bg_parallax');
          vc_remove_param('vc_row','parallax');
          vc_remove_param('vc_row','parallax_image');

          if(version_compare(WPB_VC_VERSION,'4.11.0','>=') || version_compare(WPB_VC_VERSION,'4.11','>=')){
              vc_remove_param('vc_row','parallax_speed_video');
              vc_remove_param('vc_row','parallax_speed_bg');
          }

          vc_add_param( 'vc_row',   array( 
                  'heading' => __( 'Video Source', 'cleanco' ),
                  'param_name' => 'video_source',
                  'value' => array('local'=>__( 'Local Server', 'cleanco' ),'youtube'=>__( 'Youtube/Vimeo', 'cleanco' )),
                  'type' => 'radio',
                  'group'=>__('Extended options', 'cleanco'),
                  'std'=>'local',
                  'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
           ));


         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Video (mp4)', 'cleanco' ),
              'param_name' => 'background_video',
              'type' => 'attach_video',
              'group'=>__('Extended options', 'cleanco'),
              'dependency' => array( 'element' => 'video_source', 'value' => array('local') )   
          ) );

         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Video (webm)', 'cleanco' ),
              'param_name' => 'background_video_webm',
              'type' => 'attach_video',
              'group'=>__('Extended options', 'cleanco'),
              'dependency' => array( 'element' => 'video_source', 'value' => array('local') )   
          ) );

         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Image', 'cleanco' ),
              'param_name' => 'background_image',
              'type' => 'attach_image',
              'group'=>__('Extended options', 'cleanco'),
              'dependency' => array( 'element' => 'background_type', 'value' => array('image') )   
          ) );

          vc_add_param( 'vc_row',
              array(
                'type' => 'textfield',
                'heading' => __( 'Video link', 'cleanco' ),
                'param_name' => 'video_bg_url',
                'group'=>__('Extended options', 'cleanco'),
                'description' => __( 'Add YouTube/Vimeo link', 'cleanco' ),
                'dependency' => array(
                  'element' => 'video_source',
                  'value' => array('youtube'),
                ),
           ));
      }
      else{

         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Video (mp4)', 'cleanco' ),
              'param_name' => 'background_video',
              'type' => 'attach_video',
              'group'=>__('Extended options', 'cleanco'),
              'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
          ) );

         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Video (webm)', 'cleanco' ),
              'param_name' => 'background_video_webm',
              'type' => 'attach_video',
              'group'=>__('Extended options', 'cleanco'),
              'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
          ) );

         vc_add_param( 'vc_row', array( 
              'heading' => __( 'Background Image', 'cleanco' ),
              'param_name' => 'background_image',
              'type' => 'attach_image',
              'group'=>__('Extended options', 'cleanco'),
              'dependency' => array( 'element' => 'background_type', 'value' => array('image') )   
          ) );


      }

     vc_add_param( 'vc_row', array( 
          'heading' => __( 'Extra id', 'cleanco' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => __("If you wish to add anchor id to this row. Anchor id may used as link like href=\"#yourid\"", "cleanco"),
      ) );


     vc_add_param( 'vc_row_inner', array( 
          'heading' => __( 'Extra id', 'cleanco' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => __("If you wish to add anchor id to this row. Anchor id may used as link like href=\"#yourid\"", "cleanco"),
      ) );

      vc_add_param( 'vc_row', array( 
          'heading' => __( 'Background Style', 'cleanco' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                __('No Repeat', 'wpb') => 'no-repeat',
                __("Cover", 'wpb') => 'cover',
                __('Contain', 'wpb') => 'contain',
                __('Repeat', 'wpb') => 'repeat',
                __("Parallax", 'cleanco') => 'parallax',
               __("Fixed", 'cleanco') => 'fixed',
              ),
          'group'=>__('Extended options', 'cleanco'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('image') )      
      ) );
  }

  add_action('init','detheme_vc_single_image');   

  function detheme_vc_single_image(){

      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Image Hover Option', 'cleanco' ),
          'param_name' => 'image_hover',
          'type' => 'radio',
          'value'=>array(
                'none'=>__("None", 'cleanco'),
                'image'=>__("Image", 'cleanco'),
                'text'=>__("Text", 'cleanco'),
              ),
          'group'=>__('Extended options', 'cleanco'),
          'std' => 'none'       
      ) );

      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Image', 'cleanco' ),
          'param_name' => 'image_hover_src',
          'type' => 'attach_image',
          'value'=>"",
          'holder'=>'div',
          'param_holder_class'=>'image-hover',
          'group'=>__('Extended options', 'cleanco'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('image'))       
      ) );

      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Animation Style', 'cleanco' ),
          'param_name' => 'image_hover_type',
          'type' => 'dropdown',
          'value'=>array(
              __('Default','cleanco')=>'default',
              __('From Left','cleanco')=>'fromleft',
              __('From Right','cleanco')=>'fromright',
              __('From Top','cleanco')=>'fromtop',
              __('From Bottom','cleanco')=>'frombottom',
            ),
          'group'=>__('Extended options', 'cleanco'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('image'))       
      ) );


      if(version_compare(WPB_VC_VERSION,'4.4.0','<')){
            vc_add_param( 'vc_single_image', array( 
                'heading' => __("Image style", "js_composer"),
                'param_name' => 'style',
                'type' => 'dropdown',
                'value'=>array(
                            "Default" => "",
                            "Rounded" => "vc_box_rounded",
                            "Border" => "vc_box_border",
                            "Outline" => "vc_box_outline",
                            "Shadow" => "vc_box_shadow",
                            "3D Shadow" => "vc_box_shadow_3d",
                            "Circle" => "vc_box_circle",
                            "Circle Border" => "vc_box_border_circle",
                            "Circle Outline" => "vc_box_outline_circle",
                            "Circle Shadow" => "vc_box_shadow_circle",
                            __("Diamond",'cleanco') => "dt_vc_box_diamond" //new from detheme
                        ),
            ) );

      }
      elseif(version_compare(WPB_VC_VERSION,'4.4.0','<=') && version_compare(WPB_VC_VERSION,'4.5.0','<')){
            vc_add_param( 'vc_single_image', array( 
                'heading' => __("Image style", "js_composer"),
                'param_name' => 'style',
                'type' => 'dropdown',
                'value'=>array(
                            "Default" => "",
                            'Rounded' => 'vc_box_rounded',
                            'Border' => 'vc_box_border',
                            'Outline' => 'vc_box_outline',
                            'Shadow' => 'vc_box_shadow',
                            'Bordered shadow' => 'vc_box_shadow_border',
                            '3D Shadow' => 'vc_box_shadow_3d',
                            'Circle' => 'vc_box_circle', //new
                            'Circle Border' => 'vc_box_border_circle', //new
                            'Circle Outline' => 'vc_box_outline_circle', //new
                            'Circle Shadow' => 'vc_box_shadow_circle', //new
                            'Circle Border Shadow' => 'vc_box_shadow_border_circle', //new
                            __("Diamond",'cleanco') => "dt_vc_box_diamond" //new from detheme
                        ),
            ) );
      }
      else{
            vc_add_param( 'vc_single_image', array( 
                'heading' => __("Image style", "js_composer"),
                'param_name' => 'style',
                'type' => 'dropdown',
                'value'=>array(
                            "Default" => "",
                            'Rounded' => 'vc_box_rounded',
                            'Border' => 'vc_box_border',
                            'Outline' => 'vc_box_outline',
                            'Shadow' => 'vc_box_shadow',
                            'Bordered shadow' => 'vc_box_shadow_border',
                            '3D Shadow' => 'vc_box_shadow_3d',
                            'Round' => 'vc_box_circle', //new
                            'Round Border' => 'vc_box_border_circle', //new
                            'Round Outline' => 'vc_box_outline_circle', //new
                            'Round Shadow' => 'vc_box_shadow_circle', //new
                            'Round Border Shadow' => 'vc_box_shadow_border_circle', //new
                            'Circle' => 'vc_box_circle_2', //new
                            'Circle Border' => 'vc_box_border_circle_2', //new
                            'Circle Outline' => 'vc_box_outline_circle_2', //new
                            'Circle Shadow' => 'vc_box_shadow_circle_2', //new
                            'Circle Border Shadow' => 'vc_box_shadow_border_circle_2', //new
                            __("Diamond",'cleanco') => "dt_vc_box_diamond" //new from detheme
                        ),
              'dependency' => array(
                'element' => 'source',
                'value' => array( 'media_library', 'featured_image' )
              ),

            ) );


      }


      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Pre Title', 'cleanco' ),
          'param_name' => 'image_hover_pre_text',
          'type' => 'textfield',
          'value'=>"",
          'group'=>__('Extended options', 'cleanco'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('text'))       
      ) );
      vc_add_param( 'vc_single_image', array( 
          'heading' => __( 'Title', 'cleanco' ),
          'param_name' => 'image_hover_text',
          'type' => 'textfield',
          'value'=>"",
          'group'=>__('Extended options', 'cleanco'),
          'dependency' => array( 'element' => 'image_hover','value'=>array('text'))       
      ) );

  }


if (detheme_plugin_is_active('cleanco_vc_addon/cleanco_vc_addon.php')) {


    function cleanco_vc_tabs(){

          vc_add_param( 'vc_tab', array( 
          'heading' => __( 'Icon', 'cleanco' ),
          'param_name' => 'tab_icon',
          'class' => '',
          'type' => 'iconlists',
           ));
    }

     add_action('init','cleanco_vc_tabs');   

    if (detheme_plugin_is_active('detheme-portfolio/detheme_port.php')) {

      function detheme_vc_cleanco_portfolio(){
          if(shortcode_exists('dt_portfolio')) {
            remove_shortcode('dt_portfolio');
          }

          vc_add_param( 'dt_portfolio', array( 
              'heading' => __( 'Select Layout Type', 'cleanco' ),
              'param_name' => 'layout',
              'type' => 'dropdown',
              'std'=>'carousel',
              'value'=>array(
                 __('Slide Carousel','cleanco')=>'carousel',
                 __('Slide Carousel with Description','cleanco')=>'carousel-text',
                 __('Isotope','cleanco')=>'isotope',
                 __('Lazy Load Isotope','cleanco')=>'lazy-isotope'
                ),
          ) );


         vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Column', 'cleanco' ),
            'param_name' => 'full_column',
            'description' => __( 'Number of columns on screen larger than 1200px screen resolution', 'cleanco' ),
            'class' => '',
            'value'=>array(
                __('One Column','cleanco') => '1',
                __('Two Columns','cleanco') => '2',
                __('Three Columns','cleanco') => '3',
                __('Four Columns','cleanco') => '4',
                __('Five Columns','cleanco') => '5',
                __('Six Columns','cleanco') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'4',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));   


         vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Desktop Column', 'cleanco' ),
            'param_name' => 'desktop_column',
            'description' => __( 'items between 1200px and 1023px', 'cleanco' ),
            'class' => '',
            'value'=>array(
                __('One Column','cleanco') => '1',
                __('Two Columns','cleanco') => '2',
                __('Three Columns','cleanco') => '3',
                __('Four Columns','cleanco') => '4',
                __('Five Columns','cleanco') => '5',
                __('Six Columns','cleanco') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'4',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));   

         vc_add_param( 'dt_portfolio',   array( 
            'heading' => __( 'Desktop Small Column', 'cleanco' ),
            'param_name' => 'small_column',
            'description' => __( 'items between 1024px and 768px', 'cleanco' ),
            'class' => '',
            'value'=>array(
                __('One Column','cleanco') => '1',
                __('Two Columns','cleanco') => '2',
                __('Three Columns','cleanco') => '3',
                __('Four Columns','cleanco') => '4',
                __('Five Columns','cleanco') => '5',
                __('Six Columns','cleanco') => '6'
                ),
            'std'=>'3',
            'type' => 'dropdown',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));  

        vc_add_param( 'dt_portfolio',  array( 
            'heading' => __( 'Tablet Column', 'cleanco' ),
            'param_name' => 'tablet_column',
            'description' => __( 'items between 768px and 600px', 'cleanco' ),
            'class' => '',
            'value'=>array(
                __('One Column','cleanco') => '1',
                __('Two Columns','cleanco') => '2',
                __('Three Columns','cleanco') => '3',
                __('Four Columns','cleanco') => '4',
                __('Five Columns','cleanco') => '5',
                __('Six Columns','cleanco') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'2',
              'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));
        vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Mobile Column', 'cleanco' ),
            'param_name' => 'mobile_column',
            'description' => __( 'items below 600px', 'cleanco' ),
            'class' => '',
            'value'=>array(
                __('One Column','cleanco') => '1',
                __('Two Columns','cleanco') => '2',
                __('Three Columns','cleanco') => '3',
                __('Four Columns','cleanco') => '4',
                __('Five Columns','cleanco') => '5',
                __('Six Columns','cleanco') => '6'
                ),
            'type' => 'dropdown',
            'std'=>'1',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             )); 
        
          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Posts per page', 'cleanco' ),
            'param_name' => 'posts_per_page',
            'value' => '3',
            'type' => 'textfield',
            'dependency' => array( 'element' => 'layout','value'=>array('lazy-isotope'))       
          ) );

           vc_add_param( 'dt_portfolio',  array( 
            'heading' => __( 'Detail Link', 'cleanco' ),
            'param_name' => 'show_link',
            'value' => array('yes'=>__('Show','cleanco'),'no'=>__('Hidden','cleanco')),
            'type' => 'radio',
            'std'=>'no',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))  
             ));


          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Show Filter', 'cleanco' ),
            'param_name' => 'show_filter',
            'value' => array('yes'=>__('Yes','cleanco'),'no'=>__('No','cleanco')),
            'type' => 'radio',
            'std'=>'no',
            'dependency' => array( 'element' => 'layout','value'=>array('lazy-isotope','isotope'))       
             ));


          vc_add_param( 'dt_portfolio', array( 
              'heading' => __( 'Number of Columns', 'cleanco' ),
              'param_name' => 'column',
              'description' => __( 'Number of columns on screen larger than 1200px screen resolution', 'cleanco' ),
              'class' => '',
              'value'=>array(
                  __('Two Columns','cleanco') => '2',
                  __('Three Columns','cleanco') => '3',
                  __('Four Columns','cleanco') => '4',
                  __('Six Columns','cleanco') => '6'
                  ),
              'type' => 'dropdown',
              'std'=>'4',
              'dependency' => array( 'element' => 'layout','value'=>array('isotope','lazy-isotope'))       
          ) );


          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Number of Posts to be displayed', 'cleanco' ),
            'param_name' => 'portfolio_num',
            'value' => '10',
            'type' => 'textfield',
          ) );

          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Slide Speed', 'cleanco' ),
            'param_name' => 'speed',
            'class' => '',
            'value' => '800',
            'description' => __( 'Slide speed (in millisecond). The lower value the faster slides', 'cleanco' ),
            'type' => 'textfield',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));

          vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Autoplay', 'cleanco' ),
            'param_name' => 'autoplay',
            'description' => __( 'Set Autoplay', 'cleanco' ),
            'class' => '',
            'std'=>'0',
            'value'=>array(
                __('Yes','cleanco') => '1',
                __('No','cleanco') => '0'
                ),
            'type' => 'dropdown',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));

            vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Animation Type', 'cleanco' ),
            'param_name' => 'spy',
            'class' => '',
            'value' => 
             array(
                __('Scroll Spy not activated','cleanco') =>'none',
                __('The element fades in','cleanco') => 'uk-animation-fade',
                __('The element scales up','cleanco') => 'uk-animation-scale-up',
                __('The element scales down','cleanco') => 'uk-animation-scale-down',
                __('The element slides in from the top','cleanco') => 'uk-animation-slide-top',
                __('The element slides in from the bottom','cleanco') => 'uk-animation-slide-bottom',
                __('The element slides in from the left','cleanco') => 'uk-animation-slide-left',
                __('The element slides in from the right.','cleanco') =>'uk-animation-slide-right',
             ),        
            'description' => __( 'Scroll spy effects', 'cleanco' ),
            'type' => 'dropdown',
            'dependency' => array( 'element' => 'layout','value'=>array('carousel','carousel-text'))       
             ));

            vc_add_param( 'dt_portfolio', array( 
            'heading' => __( 'Animation Delay', 'cleanco' ),
            'param_name' => 'scroll_delay',
            'class' => '',
            'value' => '300',
            'description' => __( 'The number of delay the animation effect of the icon. in milisecond', 'cleanco' ),
            'type' => 'textfield',
            'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
             ));

          add_shortcode('dt_portfolio', 'dt_cleanco_portfolio_shortcode');

            add_filter('dt_portfolio_modal_effect','get_cleanco_modal_effect');
      }


      add_action('init','detheme_vc_cleanco_portfolio');
  }   

  }
}  


function get_cleanco_modal_effect($effect){
   return get_cleanco_option('dt-select-modal-effects',$effect);
}

/* portfolio handle */

if ( detheme_plugin_is_active('detheme-portfolio/detheme_port.php') ){

  function loadPortfolioTemplate(){

    global $post,$wp_query,$GLOBALS;

    if(!isset($post) || isset($_GET['type']))
        return true;

    $standard_type=$post->post_type;

    if(is_archive() && $standard_type == 'port') {
        $post_type_data = get_post_type_object( 'port');
        $post_type_slug = $post_type_data->rewrite['slug'];

        if(!$page = get_page_by_path($post_type_slug))
        return true;

        $query_vars=array(
        'post_type' => 'page',
        'page_id'=>$page->ID,
        'posts_per_page'=>1
        );

        $original_query_vars=$wp_query->query_vars;

       $wp_query->query($query_vars);
       if(!$wp_query->have_posts()){
           $wp_query->query($original_query_vars);
           return true;
       }

      $GLOBALS['post']=$page;
    }
    else{
      return true;
    }



  }

  add_action('template_redirect', 'loadPortfolioTemplate');
}

function load_portfolio_script(){

    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    
    wp_enqueue_script( 'isotope.pkgd' , get_template_directory_uri() . '/js/isotope.pkgd'.$suffix.'.js', array( ), '2.0.0', false );
    wp_enqueue_script( 'dt-portfolio' , get_template_directory_uri() . '/js/portfolio.js', array('jquery'), '2.0.0', false );
}

add_action('dt_portfolio_loaded','load_portfolio_script');

function load_portfolio_imagefixheightfull_script($slug,$nam4=null){

    $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_script( 'isotope.pkgd' , get_template_directory_uri() . '/js/isotope.pkgd'.$suffix.'.js', array( ), '2.0.0', false );
    wp_enqueue_script( 'isotope-masonry-horizontal' , get_template_directory_uri() . '/js/masonry.horizontal.js', array('isotope.pkgd'), '', false );
    wp_enqueue_script( 'dt-portfolio' , get_template_directory_uri() . '/js/portfolio'.$suffix.'.js', array('jquery'), '2.0.0', false );

}

add_action( "get_template_part_content-portfolio-imagefixheightfull",'load_portfolio_imagefixheightfull_script' );

add_filter( 'get_search_form','dt_get_search_form', 10, 1 );
function dt_get_search_form( $form ) {
    $format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';
    $format = apply_filters( 'search_form_format', $format );

    if ( 'html5' == $format ) {
      $form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
        <label>
          <span class="screen-reader-text">' . _x( 'Search for:', 'label','cleanco' ) . '</span>
          <i class="flaticon-zoom22"></i>
          <input type="search" class="search-field" placeholder="'.__('To search type and hit enter','cleanco').'" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label','cleanco' ) . '" />
        </label>
        <input type="submit" class="search-submit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
      </form>';
    } else {
      $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url( home_url( '/' ) ) . '">
        <div>
          <label class="screen-reader-text" for="s">' . _x( 'Search for:', 'label','cleanco' ) . '</label>
          <i class="flaticon-zoom22"></i>
          <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.__('To search type and hit enter','cleanco').'" />
          <input type="submit" id="searchsubmit" value="'. esc_attr_x( 'Search', 'submit button' ) .'" />
        </div>
      </form>';
    }

  return $form;
}

add_filter( 'get_product_search_form','dt_get_product_search_form', 10, 1 );
function dt_get_product_search_form( $form ) {
  $form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
      <div>
        <label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
        <i class="flaticon-zoom22"></i>
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search for products', 'woocommerce' ) . '" />
        <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search', 'woocommerce' ) .'" />
        <input type="hidden" name="post_type" value="product" />
      </div>
    </form>';

  return $form;
}

function is_cleanco_home_filter($value=false,$post=null){

  if($post && in_array($post->post_name,array('home-1','home-2','home-3','home-4')))
      {
        return $value || true;
      }
  return $value || false;
}

function is_cleanco_home($post=null){

  if(!isset($post)) $post=get_post();

  return apply_filters('is_cleanco_home',is_front_page(),$post);
}

add_filter('is_cleanco_home','is_cleanco_home_filter',1,2);

function cleanco_wp_login_header($login_header_url=""){

  $login_header_url=esc_url( home_url( '/' ) );

  return $login_header_url;
}

add_filter('login_headerurl','cleanco_wp_login_header');


function remove_excerpt_more($excerpt_more=""){

  return '&hellip;';
}

add_filter('excerpt_more','remove_excerpt_more');


function cleanco_get_lightbox_1st() {
  global $cleanco_revealData, $cleanco_Scripts;

 if (!get_cleanco_option('lightbox_1st_on')) { return; }

  $modalcontent = '<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="lightbox-1st-visit">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <span class="triangle1"></span>
            <span class="triangle2"></span>
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <div class="modal-header-text"><h3 id="myModalLabel">'.get_cleanco_option('lightbox_1st_title','').'</h3></div>
          </div>
          <div class="modal-body">'.get_cleanco_option('lightbox_1st_content','').'</div>
    </div>
  </div>
</div>';

    array_push($cleanco_revealData,$modalcontent);

    $delay = intval(get_cleanco_option('lightbox_1st_delay',10)); 
    $cookie = intval(get_cleanco_option('lightbox_1st_cookie',1)); 

    $script = 'jQuery(document).ready(function($) {
      if (document.cookie.indexOf(\'visited=true\') == -1) {
        var cookie_length =  1000*60*60*'.$cookie.';
            var expires = new Date((new Date()).valueOf() + cookie_length);
            document.cookie = "visited=true;expires=" + expires.toUTCString();
        setTimeout(function() {
            $(\'#lightbox-1st-visit\').modal({ show: true });
        }, '.$delay.' * 1000);
      }
    });';

    array_push($cleanco_Scripts,$script);
}

function get_cleanco_pre_footer_page(){

  $post_ID=get_the_ID();
  $footerpage=get_cleanco_option('footerpage');

  if(! get_cleanco_option('showfooterpage',true) || !$footerpage || $post_ID==$footerpage)
    return;

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

  if(!($post = _get_wpml_post($footerpage))) return;
  $old_sidebar=get_query_var('sidebar');
  set_query_var('sidebar','nosidebar');

  print do_shortcode($post->post_content);
  set_query_var('sidebar',$old_sidebar);
}

add_action('before_footer_section','get_cleanco_pre_footer_page'); 

/*wpml translation */

function _get_wpml_post($post_id){

  if(!defined('ICL_LANGUAGE_CODE'))
        return get_post($post_id);

    global $wpdb;

   $postid = $wpdb->get_var(
      $wpdb->prepare("SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid=(SELECT trid FROM {$wpdb->prefix}icl_translations WHERE element_id='%d' LIMIT 1) AND element_id!='%d' AND language_code='%s'", $post_id,$post_id,ICL_LANGUAGE_CODE)
   );

  if($postid)
      return get_post($postid);
  
  return get_post($post_id);
}


function clenco_page_attibutes_metabox($posttypes){

  if(!get_cleanco_option('dt-show-banner-page','')=='featured' || !get_cleanco_option('show-banner-area')){

      if(isset($posttypes['post'])){
        unset($posttypes['post']);
      }

      if(isset($posttypes['product'])){
        unset($posttypes['product']);
      }

  }
  return $posttypes;
}

add_filter('dt_page_metaboxes','clenco_page_attibutes_metabox');

function woocommerce_set_product_column(){
  if(is_product_category() || is_product_tag() || is_shop()){
      print "<!-- start loop -->\n<div class=\"woocommerce columns-5\">";

      add_action('woocommerce_after_shop_loop',create_function('','print "</div>\n<!-- end loop -->";'));

  }
}
add_action('woocommerce_before_shop_loop','woocommerce_set_product_column');


/* auto update handle */
function detheme_automatic_updater_disabled($disabled){
  global $detheme_config;


  if(isset($detheme_config['disable_automatic_update'])){
      if(isset($detheme_config['core_automatic_update'])){

        if("minor"==$detheme_config['core_automatic_update']){
          add_filter('allow_dev_auto_core_updates','__return_false');
          add_filter('allow_minor_auto_core_updates','__return_true');
          add_filter('allow_major_auto_core_updates','__return_false');
        }
        elseif('true'==$detheme_config['core_automatic_update']){
          add_filter('allow_dev_auto_core_updates','__return_true');
          add_filter('allow_minor_auto_core_updates','__return_true');
          add_filter('allow_major_auto_core_updates','__return_true');
        }
        else{
          add_filter('allow_dev_auto_core_updates','__return_false');
          add_filter('allow_minor_auto_core_updates','__return_false');
          add_filter('allow_major_auto_core_updates','__return_false');
        }

      }

    return !(bool)$detheme_config['disable_automatic_update'];
  }

  return $disabled;
}

add_filter('automatic_updater_disabled','detheme_automatic_updater_disabled');

function detheme_get_logo_content() {
  $logo             = get_cleanco_option('dt-logo-image');
  $logo_url         = isset($logo['url']) ? $logo['url'] : "";

  $logo_transparent = get_cleanco_option('dt-logo-image-transparent');
  $logo_transparent_url= isset($logo_transparent['url']) ? $logo_transparent['url'] : "";

  $logoContent = "";
  $logotext = get_cleanco_option('dt-logo-text','');

  if(!empty($logo_url)){

    $altimage = esc_attr(sanitize_title($logotext));
    $altwidth = ( $logowidth=get_cleanco_option('logo-width')) ? " width=\"".intval($logowidth)."\"" : "";


    $logoContent = sprintf('<a href="%s" style=""><img id="logomenu" src="%s" alt="%s" class="img-responsive halfsize" %s></a>',
      esc_url(home_url()),
      esc_url(detheme_maybe_ssl_url($logo_url)),
      $altimage,
      $altwidth      
    );

    $logoContent .= sprintf('<a href="%s" style=""><img id="logomenureveal" src="%s" alt="%s" class="img-responsive halfsize" %s></a>',
      esc_url(home_url()),
      esc_url(detheme_maybe_ssl_url($logo_transparent_url)),
      $altimage,
      $altwidth
    );
  } else{ 
    if (!empty($logotext)) {
      $logoContent = sprintf('<div class="header-logo><a class="navbar-brand-desktop" href="%s">%s</a></div>',
        esc_url(home_url()),
        $logotext
      );
    } 
  } 
  
  return $logoContent;
}

function cleanco_load_vc_nav_buttons(){


  $fields=get_cleanco_option('menu_icon_fields');

  if(!$fields || !is_array($fields)) return;

  print '<div class="navigation_button">';

  $i=0;

  foreach($fields as $field){

    print '<div class="navigation_button_item'.($i=='0' ? " navigation_active":"").'">';
    print (isset($field['icon']) && ($icon=$field['icon'])) ? "<i class=\"{$icon}\"></i>" : ""; 

    if((isset($field['label']) && $field['label']!='') || (isset($field['text']) && $field['text']!='')){

      print "<div class=\"text-box\">";
      print isset($field['label']) && $field['label']!='' ? "<div class=\"navigation-label\">".$field['label']."</div>": "";
      print isset($field['text']) && $field['text']!='' ? "<div class=\"navigation-text\">".$field['text']."</div>": "";
      print "</div>";


    }
    print '</div>';

    $i++;

  }
  print '</div>';
}

add_action('detheme_load_vc_nav_buttons','cleanco_load_vc_nav_buttons');
?>