<?php 
defined('ABSPATH') or die();
add_filter('detheme_options_config','cleanco_theme_configuration');

function cleanco_theme_configuration($cleanco_config){

	if(is_admin())
		return $cleanco_config;



	if(is_404()){

			$page_background=$cleanco_config['dt-404-background'];
			if(isset($page_background['id']) && $style=getBackgroundStyle($page_background['id'])){
				$cleanco_config['body_background']="body.error404{".$style['css']."}";
				$cleanco_config['body_tag']="";
			}
	}
	else{

		$post_id=get_the_id();


		if(!in_array($post_type=get_post_type(),detheme_post_use_sidebar_layout()) && isset($cleanco_config['layout_'.$post_type])){
			$cleanco_config['layout']=$cleanco_config['layout_'.$post_type];
		}

		if(is_front_page() || is_page()){
			$cleanco_config['page-title']=is_front_page()?get_bloginfo('name'):the_title('','',false);

			if(is_front_page()) $post_id = get_option('page_on_front');

			if(get_post_meta( $post_id,'_hide_lightbox', true )){
				$cleanco_config['lightbox_1st_on']=false;
			}

			if(get_post_meta( $post_id,'_hide_loader', true )){
				$cleanco_config['page_loader']=false;
			}

			if(get_post_meta( $post_id,'_hide_popup', true )){
				$cleanco_config['exitpopup']="";
			}

			if(get_post_meta( $post_id,'_hide_banner', true ) && $cleanco_config['dt-show-banner-page']=='featured'){
				$cleanco_config['show-banner-area']=false;
			}

			$page_background=get_post_meta( $post_id,'_page_background', true );
			$background_style=get_post_meta( $post_id, '_background_style', true );

			if($page_background){

				$style=getBackgroundStyle($page_background,$background_style);

				$cleanco_config['body_background']="body{".$style['css']."}";
				$cleanco_config['body_tag']=$style['body'];

			}

		}
		elseif(is_category()){

			$cleanco_config['page-title']=sprintf(__('Category : %s','cleanco'), single_cat_title( ' ', false ));

		}
		elseif(is_archive()){

			$title="";

			if(is_tag()){
				$title=sprintf(__('Tag : %s','cleanco'), single_tag_title( ' ', false ));
			}
			elseif(is_tax()){
				$title=single_tag_title( ' ', false );
			}
			elseif(function_exists('is_shop') && is_shop()){

				if (!empty($detheme_config['dt-shop-title-page'])) {
					$title = $detheme_config['dt-shop-title-page'];
				} else {
					$title=woocommerce_page_title(false);	
				}

				$post_id=get_option( 'woocommerce_shop_page_id');

				if(get_post_meta( $post_id,'_hide_lightbox', true )){
					$cleanco_config['lightbox_1st_on']=false;
				}

				if(get_post_meta( $post_id,'_hide_loader', true )){
					$cleanco_config['page_loader']=false;
				}

				if(get_post_meta( $post_id,'_hide_popup', true )){
					$cleanco_config['exitpopup']="";
				}

				if(get_post_meta( $post_id,'_hide_banner', true ) && $cleanco_config['dt-show-banner-page']=='featured'){
					$cleanco_config['show-banner-area']=false;
				}

				$page_background=get_post_meta( $post_id,'_page_background', true );
				$background_style=get_post_meta( $post_id, '_background_style', true );

				if($page_background){

					$style=getBackgroundStyle($page_background,$background_style);
					$cleanco_config['body_background']="body{".$style['css']."}";
					$cleanco_config['body_tag']=$style['body'];
				}

			}	
			else{
				$title=sprintf(__('Archive : %s','cleanco'), single_month_title( ' ', false ));

			}

			$cleanco_config['page-title']=$title;

		}
		elseif(is_search()){
				$cleanco_config['page-title']=__('Search','cleanco');
		}
		elseif(is_home()){

			 $post_id=get_option( 'page_for_posts');
			 $title=get_the_title($post_id);
			 $cleanco_config['page-title']=$title;

			if(get_post_meta( $post_id,'_hide_lightbox', true )){
				$cleanco_config['lightbox_1st_on']=false;
			}

			if(get_post_meta( $post_id,'_hide_loader', true )){
				$cleanco_config['page_loader']=false;
			}

			if(get_post_meta( $post_id,'_hide_popup', true )){
				$cleanco_config['exitpopup']="";
			}

			if(get_post_meta( $post_id,'_hide_banner', true ) && $cleanco_config['dt-show-banner-page']=='featured'){
				$cleanco_config['show-banner-area']=false;
			}

			$page_background=get_post_meta( $post_id,'_page_background', true );
			$background_style=get_post_meta( $post_id, '_background_style', true );

			if($page_background){

				$style=getBackgroundStyle($page_background,$background_style);
				$cleanco_config['body_background']="body{".$style['css']."}";
				$cleanco_config['body_tag']=$style['body'];
			}
		}
		elseif(function_exists('is_product')  && (is_product() || is_product_category())){

			$cleanco_config['page-title']=isset($cleanco_config['dt-shop-title-page'])?$cleanco_config['dt-shop-title-page']:"";

		}
		else{

			$post_id=get_the_ID();
			$post_type=get_post_type();
			$cleanco_config['page-title']=the_title('','',false);

			if(get_post_meta( $post_id,'_hide_lightbox', true )){
				$cleanco_config['lightbox_1st_on']=false;
			}

			if(get_post_meta( $post_id,'_hide_loader', true )){
				$cleanco_config['page_loader']=false;
			}

			if(get_post_meta( $post_id,'_hide_popup', true )){
				$cleanco_config['exitpopup']="";
			}

			$cleanco_config['dt-show-title-page']=!get_post_meta( $post_id, '_hide_title', true ) && (isset($cleanco_config['dt-show-title-'.$post_type]) && (bool)$cleanco_config['dt-show-title-'.$post_type]);

		}


		if($meta_description = get_post_meta( $post_id, '_meta_description', true )){
			$cleanco_config['meta-description']=$meta_description;
		}

		if($meta_keyword = get_post_meta( $post_id, '_meta_keyword', true )){
			$cleanco_config['meta-keyword']=$meta_keyword;
		}

		if($meta_author = get_post_meta( $post_id, '_meta_author', true )){
			$cleanco_config['meta-author']=$meta_author;
		}


		if($cleanco_config['show-banner-area']){

			
			$cleanco_config['banner']="";
			$cleanco_config['bannercolor']="";
			add_filter('woocommerce_show_page_title',create_function('','return false;'));

			switch ($cleanco_config['dt-show-banner-page']) {
				case 'featured':
						if(function_exists('is_product')  && (is_product() || is_product_category())){

							$banner=$cleanco_config['dt-shop-banner-image'];
							$cleanco_config['page-title']=$cleanco_config['dt-shop-title-page'];

							if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

								$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );
								$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
								if(!empty($banner)) $cleanco_config['banner']=$banner;

							}
							elseif($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )){

								$cleanco_config['banner']=$image[0];
							}else{
								$cleanco_config['bannercolor']=(!empty($cleanco_config['banner-color']))?$cleanco_config['banner-color']:"";
							}
						}
						elseif(function_exists('is_shop') && is_shop()){

							$post_id=get_option( 'woocommerce_shop_page_id');
							$banner=$cleanco_config['dt-shop-banner-image'];


							if($hide_title=get_post_meta( $post_id, '_hide_title', true )){
								$cleanco_config['dt-show-title-page']=false;

							}

							if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

								$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );
								$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
								if(!empty($banner)) $cleanco_config['banner']=$banner;

							}
							elseif(isset($banner['id']) && $image=wp_get_attachment_image_src( $banner['id'], 'full' )){
								$cleanco_config['banner']=$image[0];
							}else{
								$cleanco_config['bannercolor']=(!empty($cleanco_config['banner-color']))?$cleanco_config['banner-color']:"";
							}

						}
						elseif(is_page() || is_single()){

							if($hide_title=get_post_meta( $post_id, '_hide_title', true )){
								$cleanco_config['dt-show-title-page']=false;
							}

							if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

								$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );

								$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
								if(!empty($banner)) $cleanco_config['banner']=$banner;
							} else {
								$banner=$cleanco_config['dt-banner-image']['url'];
								if(!empty($banner)) {
									$cleanco_config['banner']=$banner;
								} else {
									$cleanco_config['bannercolor']=(!empty($cleanco_config['banner-color']))?$cleanco_config['banner-color']:"";
								}
							}
						
						}
						elseif(is_home()){

							 $post_id=get_option( 'page_for_posts');
							 $hide_title=get_post_meta( $post_id, '_hide_title', true );

							 if($hide_title)
							 		$cleanco_config['dt-show-title-page']=false;

							if ($page_banner=get_post_meta( $post_id, '_page_banner', true )) {

								$featured_img_fullsize_url = wp_get_attachment_image_src( $page_banner, 'full' );
								$banner=(!empty($featured_img_fullsize_url['0']))?$featured_img_fullsize_url['0']:"";
								if(!empty($banner)) $cleanco_config['banner']=$banner;
							} else {
								$banner=$cleanco_config['dt-banner-image'];
								if($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )) {
									$cleanco_config['banner']=$image[0];
								} else {
									$cleanco_config['bannercolor']=(!empty($cleanco_config['banner-color']))?$cleanco_config['banner-color']:"";
								}
							}


						}
						elseif(is_category() || is_archive() || is_search() || is_front_page()){
							$banner=$cleanco_config['dt-banner-image'];
							if($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )) {
									$cleanco_config['banner']=$image[0];
							} else {
								$cleanco_config['bannercolor']=(!empty($cleanco_config['banner-color']))?$cleanco_config['banner-color']:"";
							}
						}
					break;
				case 'image':
						$banner=$cleanco_config['dt-banner-image'];

						if(function_exists('is_product')  && (is_product() || is_shop() || is_cart() || is_checkout() || is_account_page() || is_product_category())){
							$banner=$cleanco_config['dt-shop-banner-image'];
						}
						elseif(is_page() || is_single()){

							if($hide_title=get_post_meta( $post_id, '_hide_title', true )){

								$cleanco_config['dt-show-title-page']=false;
							}


						}
						elseif(is_home()){

							 $post_id=get_option( 'page_for_posts');
							 $hide_title=get_post_meta( $post_id, '_hide_title', true );

							 if($hide_title)
							 		$cleanco_config['dt-show-title-page']=false;
						}
						elseif(function_exists('is_shop') && is_shop()){

							$post_id=get_option( 'woocommerce_shop_page_id');
							$banner=$cleanco_config['dt-shop-banner-image'];
							$hide_title=get_post_meta( $post_id, '_hide_title', true );

							 if($hide_title){
							 		$cleanco_config['dt-show-title-page']=false;
							 }
						}

					if($banner && $image=wp_get_attachment_image_src( $banner['id'], 'full' )) { 
						$cleanco_config['banner']=$image[0];
					} else {
						$cleanco_config['bannercolor']=(!empty($cleanco_config['banner-color']))?$cleanco_config['banner-color']:"";
					}
					break;
				case 'color':
					$cleanco_config['bannercolor']=(!empty($cleanco_config['banner-color']))?$cleanco_config['banner-color']:"";
					break;
				case 'none':
				default:
						if(is_page()){

							if($hide_title=get_post_meta( $post->ID, '_hide_title', true )){
								$cleanco_config['dt-show-title-page']=false;
							}


						}
						elseif(is_home()){

							 $post_id=get_option( 'page_for_posts');
							 $hide_title=get_post_meta( $post_id, '_hide_title', true );

							 if($hide_title)
							 		$cleanco_config['dt-show-title-page']=false;
						}
						elseif(function_exists('is_shop') && is_shop()){

							$post_id=get_option( 'woocommerce_shop_page_id');
							 $hide_title=get_post_meta( $post_id, '_hide_title', true );

							 if($hide_title){
							 		$cleanco_config['dt-show-title-page']=false;
							 }
						}
					break;
			}


			if($cleanco_config['dt-show-title-page']){
				$cleanco_config['dt-show-banner-title']=true;
				$cleanco_config['dt-show-title-page']=false;
			}

		}
		else{

			if(is_page() && !is_front_page()){
					if($hide_title=get_post_meta( $post_id, '_hide_title', true )){
						$cleanco_config['dt-show-title-page']=false;
					}
			}
			elseif(is_front_page()){
				$cleanco_config['dt-show-title-page']=false;
				add_filter('woocommerce_show_page_title',create_function('','return false;'));
			}
			elseif(is_home()){
				 $post_id=get_option( 'page_for_posts');
				 $hide_title=get_post_meta( $post_id, '_hide_title', true );

				 if($hide_title)
				 		$cleanco_config['dt-show-title-page']=false;
			}

			elseif(is_category() || is_archive()){
				$cleanco_config['dt-show-title-page']=true;
				if(function_exists('is_shop') && is_shop()){

						 $post_id=get_option( 'woocommerce_shop_page_id');

						 $hide_title=get_post_meta( $post_id, '_hide_title', true );

						 if($hide_title){
						 		add_filter('woocommerce_show_page_title',create_function('','return false;'));
						 		$cleanco_config['dt-show-title-page']=false;
						 }
					}
			}
			$cleanco_config['dt-show-banner-title']=false;
			$cleanco_config['banner']="";
			$cleanco_config['bannercolor']="";
		}

		if($cleanco_config['dt-show-header']){

			if(is_front_page() || is_cleanco_home(get_post())){
				$cleanco_config['dt-logo-image']=$cleanco_config['homepage-dt-logo-image'];
				$cleanco_config['dt-logo-image-transparent']=$cleanco_config['homepage-dt-logo-image-transparent'];
			}

			$cleanco_config['logo-width']=(!empty($cleanco_config['dt-logo-image']['url']) && (int)$cleanco_config['dt-logo-width'] > 0 )?$cleanco_config['dt-logo-width']:"";
			$cleanco_config['logo-top']=(!empty($cleanco_config['dt-logo-margin']) && (int)$cleanco_config['dt-logo-margin'] !== '0' )?(int)$cleanco_config['dt-logo-margin']:"";
			$cleanco_config['logo-left']=(!empty($cleanco_config['dt-logo-leftmargin']) && (int)$cleanco_config['dt-logo-leftmargin'] !== '0' )?(int)$cleanco_config['dt-logo-leftmargin']:"";
		}
		else{
			$cleanco_config['logo-width']="";
			$cleanco_config['logo-top']="";
			$cleanco_config['logo-left']="";
		}


		if($cleanco_config['showtopbar']){
			$cleanco_config['showtopbar']=( 
				(
					(($cleanco_config['dt-left-top-bar']=='menu' || $cleanco_config['dt-left-top-bar']=='icon') && $cleanco_config['dt-left-top-bar-menu']!='') ||
					$cleanco_config['dt-left-top-bar']=='text' && $cleanco_config['dt-left-top-bar-text']!=''
				)
				|| 
				(
					(($cleanco_config['dt-right-top-bar']=='menu' || $cleanco_config['dt-right-top-bar']=='icon') && $cleanco_config['dt-right-top-bar-menu']!='') ||
					$cleanco_config['dt-right-top-bar']=='text' && $cleanco_config['dt-right-top-bar-text']!=''
				)

				)?true:false;
		}

	}

	return $cleanco_config;


}

function getBackgroundStyle($image_id,$background_style=""){

	$featured_img_fullsize_url = wp_get_attachment_image_src( $image_id, 'full' );
	$css_background="background-image:url('".esc_url($featured_img_fullsize_url[0])."');";

	switch($background_style){
	    case'parallax':
	        $parallax=" data-speed=\"3\" data-type=\"background\" ";
	        $backgroundattr="background-position: 0% 0%; background-repeat: no-repeat; background-size: cover";
	        break;
	    case'parallax_all':
	        $parallax=" data-speed=\"3\" data-type=\"background\" ";
	        $backgroundattr="background-position: 0% 0%; background-repeat: repeat; background-size: cover";
	        break;
	    case'cover':
	        $parallax="";
	        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
	        break;
	    case'cover_all':
	        $parallax="";
	        $backgroundattr="background-position: center !important; background-repeat: repeat !important; background-size: cover!important";
	        break;
	    case'no-repeat':
	        $parallax="";
	        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
	        break;
	    case'repeat':
	        $parallax="";
	        $backgroundattr="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
	        break;
	    case'contain':
	        $parallax="";
	        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
	        break;
	    case 'fixed':
	        $parallax="";
	        $backgroundattr="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
	        break;
	    default:
	        $parallax=$backgroundattr="";
	        break;
	}

	return array('css'=>$css_background.$backgroundattr,'body'=>$parallax);
}

?>