<?php
defined('ABSPATH') or die();

function add_dt_shortcode_plugin($plugin_array) { 

	if ( floatval(get_bloginfo('version')) >= 3.9){
	   $plugin_array['dtshortcode']=get_template_directory_uri().'/lib/customcodes.js.php';
	}else{
	   $plugin_array['dtshortcode']=get_template_directory_uri().'/lib/customcodes.js.old.php';
	}

	add_filter( 'mce_external_languages', 'cleanco_shortcode_lang', 10, 1 );

   return $plugin_array;  
}


function cleanco_shortcode_lang( $arr )
{
    $arr[] = dirname(__FILE__). '/customcodes.string.php';
    return $arr;
}

function register_dt_shortcode_button($buttons) {  
   array_push($buttons, "dtshortcode");  
   return $buttons;  
}  



function add_dt_shortcode_button() {  

       if ( !current_user_can('edit_posts') &&  !current_user_can('edit_pages') )  {
       	return;
       }

		if ( 'true' == get_user_option( 'rich_editing' ) ) {
         add_filter('mce_external_plugins', 'add_dt_shortcode_plugin');  
         add_filter('mce_buttons', 'register_dt_shortcode_button');  
       }  
} 

add_action('admin_head', 'add_dt_shortcode_button'); 
add_action('wp_ajax_detheme_get_shortcode','render_dt_shortcode_panel');


function render_dt_shortcode_panel(){

	locate_template('lib/shortcode_panel.php',true);
	die();
}


function year_shortcode() {
	$year = date('Y');
	return $year;
}

add_shortcode('current-year', 'year_shortcode');

function site_title_shortcode() {
	$result = get_bloginfo('name');
	return $result;
}

add_shortcode('site-title', 'site_title_shortcode');

function site_tagline_shortcode() {
	$result = get_bloginfo('description');
	return $result;
}

add_shortcode('site-tagline', 'site_tagline_shortcode');

function site_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => home_url(),
		'target' => '',
		'class' => '',
	), $atts, 'site-url' ) );

	$result = '<a href="'.esc_url(home_url()).'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('site-url', 'site_url_shortcode');

function wp_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => site_url(),
		'target' => '',
		'class' => '',
	), $atts, 'wp-url' ) );

	$result = '<a href="'.esc_url(site_url()).'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('wp-url', 'wp_url_shortcode');

function theme_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => get_template_directory_uri(),
		'target' => '',
		'class' => '',
	), $atts, 'theme-url' ) );

	$result = '<a href="'.esc_url(get_template_directory_uri()).'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('theme-url', 'theme_url_shortcode');

function login_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => wp_login_url(),
		'target' => '',
		'class' => '',
	), $atts, 'login-url' ) );

	$result = '<a href="'.esc_url(wp_login_url()).'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('login-url', 'login_url_shortcode');

function logout_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => wp_logout_url(),
		'target' => '',
		'class' => '',
	), $atts, 'logout-url' ) );

	$result = '<a href="'.esc_url(wp_logout_url()).'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}
add_shortcode('logout-url', 'logout_url_shortcode');

/* woocommerce handle                                 		*/
/* this feature available when woocommerce plugin activated */
/*															*/

if (detheme_plugin_is_active('woocommerce/woocommerce.php')) {

function detheme_featured_products($atts, $content = null){

		global $woocommerce_loop,$dt_featured,$cleanco_Scripts;

        if(!isset($dt_featured)){

            $dt_featured=1;

        }

        else{

            $dt_featured++;

        }


		extract( shortcode_atts( array(
			'per_page' 	=> '12',
			'columns' 	=> '4',
			'orderby' 	=> 'date',
			'order' 	=> 'desc'
		), $atts ) );

		$args = array(
			'post_type'				=> 'product',
			'post_status' 			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $per_page,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'meta_query'			=> array(
				array(
					'key' 		=> '_visibility',
					'value' 	=> array('catalog', 'visible'),
					'compare'	=> 'IN'
				),
				array(
					'key' 		=> '_featured',
					'value' 	=> 'yes'
				)
			)
		);

		if(!in_array($columns,array(1,2,3,4,6))){
			$columns=3;
		}

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$widgetID="featured".$dt_featured;
		$woocommerce_loop['columns'] = 1;

		if ( $products->have_posts() ) :

            wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '', false );
            wp_enqueue_script( 'owl.carousel');


	          $compile='<div class="dt-featured-product">
               <div class="row"><div id="'.$widgetID.'" class="products">';

			while ( $products->have_posts() ) : $products->the_post(); 

					ob_start();
					wc_get_template_part( 'content', 'product-carousel' );
					$wooitem=ob_get_contents();
					ob_end_clean();
					$compile.=$wooitem;

				endwhile; // end of the loop.



			wp_reset_postdata();

            $compile.='</div></div></div>';

            $script='jQuery(document).ready(function($) {
            \'use strict\';
            var '.$widgetID.' = $("#'.$widgetID.'.products");
		    var navigation=$(\'<div></div>\').addClass(\'owl-carousel-navigation\'),
	        prevBtn=$(\'<a></a>\').addClass(\'btn btn-owl\'),
	        nextBtn=prevBtn.clone();
	        navigation.append(prevBtn.addClass(\'button prev\'),nextBtn.addClass(\'button next\'));
	        '.$widgetID.'.parent().append(navigation);

            try{
           '.$widgetID.'.owlCarousel({
                items       : '.$columns.', itemsDesktop    : [1200,'.max(min('3',$columns-1),1).'], itemsDesktopSmall : [1023,'.max(min('2',$columns-1),1).'], itemsTablet : [768,'.max(min('2',$columns-1),1).'], itemsMobile : [600,1], pagination  : false, slideSpeed  : 400});
            nextBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.next\');
              });
            prevBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.prev\');
              });
            '.$widgetID.'.owlCarousel(\'reload\');
            }
            catch(err){}

            });';

        array_push($cleanco_Scripts,$script);

		return '<div class="container woocommerce">' . $compile . '</div>';
		endif;
		wp_reset_postdata();

		return "";
}

function detheme_product_categories($atts, $content = null){

		global $woocommerce_loop,$dt_featured,$cleanco_Scripts;

        if(!isset($dt_featured)){

            $dt_featured=1;

        }

        else{

            $dt_featured++;

        }

		extract( shortcode_atts( array(
			'number'     => null,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'columns' 	 => '4',
			'hide_empty' => 1,
			'parent'     => ''
		), $atts ) );

		if ( isset( $atts[ 'ids' ] ) ) {
			$ids = explode( ',', $atts[ 'ids' ] );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts
		$args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent
		);

		$product_categories = get_terms( 'product_cat', $args );

		if ( $parent !== "" ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}

		$widgetID="featured".$dt_featured;
		$woocommerce_loop['columns'] = 1;
		$compile='';


		$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';

		if ( $product_categories ) {


            wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '', false );
            wp_enqueue_script( 'owl.carousel');

            wp_register_style('owl.carousel',get_template_directory_uri() . '/css/owl.carousel.css', array(), '', 'all');
	        wp_enqueue_style('owl.carousel');


	        $compile='<div class="dt-shop-category">
               <div class="row"><div id="'.esc_attr($widgetID).'" class="category-items">';


			foreach ( $product_categories as $category ) {

					ob_start();
					wc_get_template( 'content-product_cat_carousel.php', array(
					'category' => $category
				) );

					$wooitem=ob_get_contents();
					ob_end_clean();
					$compile.=$wooitem;


			}

			woocommerce_reset_loop();

	        $compile.='</div></div></div>';

            $script='jQuery(document).ready(function($) {
            \'use strict\';
            var '.$widgetID.' = $("#'.$widgetID.'.category-items");
		    var navigation=$(\'<div></div>\').addClass(\'owl-carousel-navigation\'),
	        prevBtn=$(\'<a></a>\').addClass(\'btn btn-owl\'),
	        nextBtn=prevBtn.clone().append(\'<i class="flaticon-arrow413"></i>\');
	        prevBtn.append(\'<i class="flaticon-arrow427"></i>\');

	        navigation.append(prevBtn.addClass(\'button prev\'),nextBtn.addClass(\'button next\'));
	        '.$widgetID.'.parent().append(navigation);

            try{
           '.$widgetID.'.owlCarousel({
                items       : '.$columns.', itemsDesktop    : [1200,'.max(min('3',$columns-1),1).'], itemsDesktopSmall : [1023,'.max(min('2',$columns-1),1).'], itemsTablet : [768,'.max(min('2',$columns-1),1).'], itemsMobile : [600,1], pagination  : false, slideSpeed  : 400});
            nextBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.next\');
              });
            prevBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.prev\');
              });
            '.$widgetID.'.owlCarousel(\'reload\');
            }
            catch(err){}

            });';

        array_push($cleanco_Scripts,$script);

		return '<div class="woocommerce">' . $compile . '</div>';

		}

		woocommerce_reset_loop();

		return '';

}

	function woocommerce_shortcode(){

		add_shortcode('featured_products', 'detheme_featured_products');
		add_shortcode('product_categories', 'detheme_product_categories');
	}


	add_action('init', 'woocommerce_shortcode', 999999);


}// end if

function dticon_shortcode($atts) {
	extract( shortcode_atts( array(
		'ico' => '',
		'color' => '',
		'size' => '',
		'style' => 'square',
	), $atts));

	$result="";
	$class=array();
	if(!empty($ico)) $class[]=$ico;
	if(!empty($size)) $class[]=$size;
	if(!empty($style)) $class[]="dt-icon-".$style;
	if(!empty($color) && $style!=='ghost') $class[]=$color."-color";

	if(count($class)){

		$result = '<i class="'.@implode(" ",$class).'"></i>';
	}

	return $result;
}

add_shortcode('dticon', 'dticon_shortcode');


function dt_button_shortcode($atts,$content=null) {
	extract( shortcode_atts( array(
		'url' => '',
		'target' => '',
		'size' => '',
		'style' => 'ghost',
		'skin' => '',
	), $atts));

	$result="";

	$class=array('btn');

	if(!empty($ico)) $class[]=$ico;
	if(!empty($size)) $class[]=$size;
	if(!empty($style)) $class[]="btn-".$style;
	if(!empty($skin)) $class[]="skin-".$skin;

	if(count($class)){

		$result = '<a '.(!empty($url)?"href=\"".esc_url($url)."\"":"").' class="'.@implode(" ",$class).'" target="'.esc_attr($target).'">'.do_shortcode($content).'</a>';
	}

	return $result;
}

add_shortcode('dt_button', 'dt_button_shortcode');

function dt_cleanco_portfolio_shortcode($atts, $content = null){


    global $dt_portfolio,$cleanco_revealData;

        extract(shortcode_atts(array(

        'portfolio_cat' => '',
        'portfolio_num' => 10,
        'speed'=>800,
        'autoplay'=>'0',
        'spy'=>'none',
        'scroll_delay'=>300,
        'layout'=>'carousel',
        'posts_per_page'=>'3',
        'column'=>'4',
        'full_column'=>4,
        'desktop_column'=>3,
        'small_column'=>2,
        'tablet_column'=>2,
        'mobile_column'=>1,
        'show_link'=>'no',
        'show_filter'=>'no'

    ), $atts));



    if(!isset($dt_portfolio))
                $dt_portfolio=0;

    $dt_portfolio++;

    if(vc_is_inline()){

        $dt_portfolio.="_".time().rand(0,100);
    }

    if(preg_match('/^,/i', $portfolio_cat)){
    	$portfolio_cat="";
    }



    $widgetID="dt_portfolio".$dt_portfolio;

   if($layout=='lazy-isotope'){

        	set_query_var('column',$column);
        	set_query_var('category',$portfolio_cat);
        	set_query_var('posts_per_page',$posts_per_page);
        	set_query_var('show_portfolio_filter',$show_filter);
        	set_query_var('portfolio_num',$portfolio_num);
        	$compile="<div class=\"portfolio-module\" id=\"".$widgetID."\"><div class=\"portfolio portfolio-type-imagefull\">";

        	ob_start();
        	locate_template('pagetemplates/portfolio-vc-module-image.php',true,false);
			$content=ob_get_contents(); 

        	ob_end_clean();
        	$compile.=$content."</div></div>";
        	do_action('dt_portfolio_loaded');

        	return $compile;

   }
   elseif($layout=='isotope'){

        	set_query_var('column',$column);
        	set_query_var('category',$portfolio_cat);

        	set_query_var('posts_per_page',$posts_per_page);
        	set_query_var('show_portfolio_filter',$show_filter);
        	set_query_var('portfolio_num',$portfolio_num);

        	$compile="<div class=\"portfolio-module\" id=\"".$widgetID."\"><div class=\"portfolio portfolio-type-imagefull\">";

        	ob_start();
        	locate_template('pagetemplates/portfolio-vc-module-isotope.php',true,false);
			$content=ob_get_contents(); 

        	ob_end_clean();
        	$compile.=$content."</div></div>";
        	do_action('dt_portfolio_loaded');

        	return $compile;

   }



    $queryargs = array(
            'post_type' => 'port',
            'no_found_rows' => false,
            'meta_key' => '_thumbnail_id',
            'posts_per_page'=>$portfolio_num,
            'compile'=>'',
            'script'=>''
        );

    if(!empty($portfolio_cat)){

            $queryargs['tax_query']=array(
                            array(
                                'taxonomy' => 'portcat',
                                'field' => 'id',
                                'terms' =>@explode(',',$portfolio_cat)
                            )
                        );

    }


    $query = new WP_Query( $queryargs );    
    $compile="";

    if ( $query->have_posts() ) :

        if('none'!==$spy && !empty($spy)){


            wp_enqueue_style('scroll-spy');
            wp_enqueue_script('ScrollSpy');
        }

        $spydly=0;
        $portspty=0;


        if(is_admin()){

            }else{

                wp_register_style('owl.carousel',get_template_directory_uri()."/css/owl_carousel.css",array());
                wp_enqueue_style('owl.carousel');


                wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '', false );
                wp_enqueue_script('owl.carousel');

        }

 		$modal_effect = apply_filters('dt_portfolio_modal_effect','md-effect-15');

        $compile='<div class="dt-portfolio-container portfolio-type-'.(($layout=='carousel')?"image":"text").'">
        <div class="owl-carousel-navigation prev-button">
           <a class="btn btn-owl prev btn-color-secondary skin-dark">'.__('<i class="flaticon-arrow427"></i>','cleanco').'</a>
        </div>
        <div class="owl-carousel" id="'.$widgetID.'">';

                while ( $query->have_posts() ) : 
                
                    $query->the_post();
                    
                    $terms = get_the_terms(get_the_ID(), 'portcat' );
                    $term_lists=array();

                    if ( !empty( $terms ) ) {
      
                          foreach ( $terms as $term ) {
                            $cssitem[] =sanitize_html_class($term->slug, $term->term_id);
                            $term_lists[]="<a href=\"".get_term_link( $term)."\">".$term->name."</a>";
                          }

                    }



                    $imageId=get_post_thumbnail_id(get_the_ID());
                    $featured_image  = get_post( $imageId );
                    $alt_image = get_post_meta($imageId, '_wp_attachment_image_alt', true);



                    if (isset($featured_image->guid)) {
                        $imgurl = aq_resize($featured_image->guid, 0, 300,true);

                        $spydly=$spydly+(int)$scroll_delay;

                        $scollspy="";


                       if('none'!==$spy && !empty($spy) && $portspty < 5){

                            $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
                        }



                            $compile.='<div class="portfolio-item" '.$scollspy.'>';


                        if('carousel'==$layout){

                           $compile.='<div class="post-image-container">'.((isset($imgurl) && !empty($imgurl))?'<div class="post-image">
                                    <img src="'.esc_url($imgurl).'" alt="'.esc_attr($alt_image).'" /></div>':'').'
                                <div class="imgcontrol tertier_color_bg_transparent">
                                    <div class="portfolio-termlist">'.(count($term_lists)?@implode(', ',$term_lists):"").'</div>
                                    <div class="portfolio-title">'.get_the_title().'</div>
                                    <div class="imgbuttons">
                                        <a class="md-trigger btn icon-search secondary_color_button" data-modal="modal_portfolio_'.get_the_ID().'" onclick="return false;" '.
                                        'href="'.get_the_permalink().'"></a>'.($show_link=='yes'? '<a class="btn icon-link secondary_color_button " href="'.get_the_permalink().'"></a>':'').'
                                    </div>
                                </div>
                            </div>';
                        

                        }
                        else{

                           $compile.='<div class="post-image-container">'.((isset($imgurl) && !empty($imgurl))?'<div class="post-image">
                                    <img src="'.esc_url($imgurl).'" alt="'.esc_attr($alt_image).'" /></div>':'').'
                                <div class="imgcontrol tertier_color_bg_transparent">
                                    <div class="imgbuttons">
                                        <a class="md-trigger btn icon-search secondary_color_button" data-modal="modal_portfolio_'.get_the_ID().'" onclick="return false;" '.
                                        'href="'.esc_url(get_the_permalink()).'"></a>'.($show_link=='yes'?'<a class="btn icon-link secondary_color_button " href="'.esc_url(get_the_permalink()).'"></a>':'').'
                                    </div>
                                </div>
                            </div>';

                            $compile.='<div class="portfolio-description">';
                            $compile.='<div class="portfolio-termlist">'.(count($term_lists)?@implode(', ',$term_lists):"").'</div>';
                            $compile.='<div class="portfolio-title">'.get_the_title().'</div>';
                            $compile.='<div class="portfolio-excerpt"><p>'.get_the_excerpt().'</p>';
                            $compile.='<a href="'.esc_url(get_the_permalink()).'" class="read_more" title="'.esc_attr(sprintf(__( 'Detail to %s', 'cleanco' ), get_the_title())).'">'.ucfirst(__('read more', 'cleanco')).'<i class="icon-right-dir"></i></a>';
                            $compile.='</div></div>';

                        }

                            $compile.='</div>';

                        $modalcontent='<div id="modal_portfolio_'.get_the_ID().'" class="popup-gallery md-modal '.$modal_effect.'">
                                <div class="md-content">'.($featured_image?'<img src="#" rel="'.esc_attr($featured_image->guid).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>':"").'     
                                    <div class="md-description secondary_color_bg">'.get_the_excerpt().'</div>
                                    <button class="secondary_color_button md-close"><i class="icon-cancel"></i></button>
                                </div>
                            </div>';

                            array_push($cleanco_revealData,$modalcontent);


                        $portspty++;




                      }
                endwhile;

         $compile.="</div>
                     <div class=\"owl-carousel-navigation next-button\">
                       <a class=\"btn btn-owl next btn-color-secondary skin-dark\">".__('<i class="flaticon-arrow413"></i>','cleanco')."</a>
        </div></div>";
        $script='<script type="text/javascript">'."\n".'jQuery(document).ready(function($) {
            \'use strict\';'."\n".'
            var '.$widgetID.' = jQuery("#'.$widgetID.'");
            try{
           '.$widgetID.'.owlCarousel({
                items       : '.$full_column.', 
                itemsDesktop    : [1200,'.$desktop_column.'], 
                itemsDesktopSmall : [1023,'.$small_column.'], // 3 items betweem 900px and 601px
                itemsTablet : [768,'.$tablet_column.'], //2 items between 600 and 0;
                itemsMobile : [600,'.$mobile_column.'], // itemsMobile disabled - inherit from itemsTablet option
                pagination  : false,'.($autoplay?'autoPlay:'.($speed+1000).',':'')."
                slideSpeed  : ".$speed.",";
          $script.='});'."\n".'
    '.$widgetID.'.parents(\'.dt-portfolio-container\').find(".next").click(function(){
        '.$widgetID.'.trigger(\'owl.next\');
      });
    '.$widgetID.'.parents(\'.dt-portfolio-container\').find(".prev").click(function(){
        '.$widgetID.'.trigger(\'owl.prev\');
      });';

         $script.='}
            catch(err){}
        });</script>';

     $compile.=$script;   
    endif;
    
    wp_reset_query();
    return $compile;
}

function dt_carousel_shortcode($atts, $content = null){

        extract( shortcode_atts( array(
            'spy'=>'none',
            'scroll_delay'=>300,
            'pagination' => 1,
            'navigation'=>1,
            'speed'=>800,
            'column'=>1,
            'desktop_column'=>1,
            'small_column'=>1,
            'tablet_column'=>1,
            'mobile_column'=>1,
            'pagination_type'=>'bullet',
            'pagination_image'=>null,
            'pagination_icon'=>null,
            'pagination_color'=>'',
            'pagination_size'=>'',
            'autoplay'=>0,
            'interval'=>1000,
        ), $atts ) );

        global $dt_carousel;

        if(!isset($dt_carousel))
                $dt_carousel=0;

        $dt_carousel++;

        $pattern = get_shortcode_regex();

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
            return "";

        wp_register_style('owl.carousel',get_template_directory_uri()."/css/owl_carousel.css",array());
        wp_enqueue_style('owl.carousel');


        wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '', false );
        wp_enqueue_script('owl.carousel');



        $widgetID="dt_carousel".$dt_carousel;
        $spydly=0;
        $i=0;
        $paginationthumb=array();

        if('none'!==$spy && !empty($spy)){

            wp_enqueue_style('scroll-spy');
            wp_enqueue_script('ScrollSpy');
        }


        $compile='<div class="owl-carousel-container"><div class="owl-carousel" id="'.$widgetID.'">';

        if($pagination_image){
            $pagination_thumb=@explode(',',$pagination_image);
        }
        if($pagination_icon){
            $pagination_icons=@explode(',',$pagination_icon);
        }

        foreach ($matches as $key => $matche) {


             $scollspy="";

            if('none'!==$spy && !empty($spy) && $i < $column){

                $spydly=$spydly+(int)$scroll_delay;
                $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
            }

            $compile.='<div class="owl-slide"'.strip_tags($scollspy).'>'.do_shortcode($matche[0]).'</div>';
            $i++;

            if($pagination_type!=='bullet' && $pagination){

                 $thumb="";
                if($pagination_type=='image' && !empty($pagination_thumb[$key])){

                    if(!empty($pagination_thumb[$key])){

                        $image = wp_get_attachment_image_src($pagination_thumb[$key]); 
                        $alt_image = get_post_meta($pagination_thumb[$key], '_wp_attachment_image_alt', true);

                        $thumb="<img src=\"".esc_url($image[0])."\" alt=\"".esc_attr($alt_image)."\">";

                    }
                }
                elseif($pagination_type=='icon' && !empty($pagination_icons[$key])){
                    $thumb="<i class=\"".sanitize_html_class($pagination_icons[$key])."\" ></i>";
                }
                else{

                    $thumb="<span class=\"default-owl-page\">".($key+1)."</span>";

                }

                $paginationthumb[$key]="<span class=\"owl-page\">".$thumb."</span>";
            }
        }

        $compile.='</div>';

        if($pagination && $pagination_type=='bullet' && ($pagination_color!=='' || $pagination_size!=='')){

            $compile.="<style type=\"text/css\">#$widgetID .owl-page span{".($pagination_color!==''?"background-color:$pagination_color;border-color:$pagination_color;":"").($pagination_size!==''?"width:".$pagination_size."px;height:".$pagination_size."px;border-radius:50%":"")."}</style>";
        }

        if(count($paginationthumb)){

            $compile.='<div class="owl-custom-pagination">'.@implode(' ',$paginationthumb).'</div>';
        }

        if($navigation){
            $compile.='<div class="owl-controls clickable"><div class="owl-buttons"><div class="owl-prev"><i class="flaticon-arrow427"></i></div><div class="owl-next"><i class="flaticon-arrow413"></i></div></div></div>';
        }

        $compile.='</div>';

	    $script='<script type="text/javascript">'."\n".'jQuery(document).ready(function($) {
            \'use strict\';'."\n".'
            var '.$widgetID.' = jQuery("#'.$widgetID.'");
            try{
           '.$widgetID.'.owlCarousel({
                items       : '.$column.', 
                itemsDesktop    : [1200,'.$desktop_column.'], 
                itemsDesktopSmall : [1023,'.$small_column.'],
                itemsTablet : [768,'.$tablet_column.'], 
                itemsMobile : [600,'.$mobile_column.'], 
                pagination  : '.(($pagination && $pagination_type=='bullet')?"true":"false").",".($autoplay?'autoPlay:'.($speed+$interval).',':'')."
                slideSpeed  : ".$speed.",paginationSpeed  : ".$speed.",rewindSpeed  : ".$speed.",".($navigation?"navigation:false,":"");

if(count($paginationthumb) && $pagination_type!=='bullet'){
                $script.='afterInit:function(el){
                  var $base=el,perpage=this.options.items,btn,currentBtn=1;
                  btn=Math.ceil(this.itemsAmount/perpage);
                  currentBtn=$(this.$owlItems[this.currentItem]).data("owl-roundPages");

                  $(\'.owl-custom-pagination .owl-page\',$base.parent()).each(function(i,el){

                          if(i >= btn ){$(el).hide();}  else{ $(el).show();}

                          if(i === currentBtn - 1 ){
                            $(this).closest(\'.owl-custom-pagination\').find(\'.owl-page\').removeClass(\'active\');
                            $(this).addClass(\'active\');
                          }
                          $(el).click(function(){
                              $(\'.owl-custom-pagination .owl-page\',$base.parent()).removeClass(\'active\');
                              $(this).addClass(\'active\');
                              $base.trigger(\'owl.goTo\',(i*perpage));
                          });
                     });
                },
                afterUpdate:function(el){
                  var $base=el,perpage=this.options.items,btn,currentBtn=1;
                  btn=Math.ceil(this.itemsAmount/perpage);

                  currentBtn=$(this.$owlItems[this.currentItem]).data("owl-roundPages");

                  $(\'.owl-custom-pagination .owl-page\',$base.parent()).each(function(i,el){

                          if(i >= btn ){$(el).hide();}  else{ $(el).show();}

                          if(i === currentBtn - 1 ){
                            $(this).closest(\'.owl-custom-pagination\').find(\'.owl-page\').removeClass(\'active\');
                            $(this).addClass(\'active\');
                          }

                          $(el).click(function(){
                              $(\'.owl-custom-pagination .owl-page\',$base.parent()).removeClass(\'active\');
                              $(this).addClass(\'active\');
                              $base.trigger(\'owl.goTo\',(i*perpage));
                          });
                     });
                }';

}

$script.='});';

if($navigation){

  $script.=$widgetID.'.closest(\'.owl-carousel-container\').find(".owl-next").click(function(){
  	'.$widgetID.'.trigger(\'owl.next\');
    		});
    '.$widgetID.'.closest(\'.owl-carousel-container\').find(".owl-prev").click(function(){
        '.$widgetID.'.trigger(\'owl.prev\');
      });';

}                

         $script.='}
            catch(err){}
        });</script>';

        return $compile.$script;
}

add_shortcode('dt_carousel', 'dt_carousel_shortcode');

function dt_counto_shortcode($atts) {
	extract( shortcode_atts( array(
		'to' => '100',
		'from' => 0,
	), $atts, 'dt_counto' ) );

	$result = '<div class="dt-counto" data-to="'.$to.'"></div>';
	return $result;
}

add_shortcode('dt_counto', 'dt_counto_shortcode');

/* render shortcode on widget text */
add_filter('widget_text',create_function('$s', 'return do_shortcode($s);'));

?>