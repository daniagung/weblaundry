
jQuery.noConflict();
jQuery(document).ready(function($){
	'use strict';

  var $select = $('select#dt-left-top-bar-select'),
  $menusource = $('#cleanco_config-dt-left-top-bar-menu').parents('.form-table tr'),
  $textsource = $('#cleanco_config-dt-left-top-bar-text').parents('.form-table tr'),
  $showtopbar=$('#cleanco_config-showtopbar .cb-enable,#cleanco_config-showtopbar .cb-disable'),
  $devider1 = $('#cleanco_config-devider-1').closest('.form-table tr'),
  $devider2 = $('#cleanco_config-devider-2').closest('.form-table tr'),
  $rselect = $('select#dt-right-top-bar-select'),
  $rmenusource = $('#cleanco_config-dt-right-top-bar-menu').parents('.form-table tr'),
  $rtextsource = $('#cleanco_config-dt-right-top-bar-text').parents('.form-table tr'),
  $backgroundImage = $('#cleanco_config-dt-banner-image').parents('.form-table tr'),
  $backgroundColor = $('#cleanco_config-banner-color').parents('.form-table tr'),
  $background=$('select#dt-show-banner-page-select'),
  $sequenceslide=$('#cleanco_config-homeslide').parents('.form-table tr'),
  $homebackground=$('select#homepage-background-type-select'),
  $homebackgroundColor = $('#cleanco_config-homepage-header-color').parents('.form-table tr'),
  $pagebackground=$('select#header-background-type-select'),
  $pagebackgroundColor = $('#cleanco_config-header-color').parents('.form-table tr'),
  $usefeaturedimage = $('#cleanco_config-use-featured-image').parents('.form-table tr'),
  $shopbackgroundColor = $('#cleanco_config-dt-shop-banner-image').parents('.form-table tr'),
  $showfooterarea=$('#cleanco_config-showfooterarea .cb-enable,#cleanco_config-showfooterarea .cb-disable'),
  $footertext=$('#cleanco_config-footer-text').closest('.form-table tr'),
  $footercolor=$('#cleanco_config-footer-color').closest('.form-table tr'),
  $footerfontcolor=$('#cleanco_config-footer-font-color').closest('.form-table tr'),
  $footerbackgroundimage=$('#cleanco_config-footer-background-image').closest('.form-table tr'),
  $showfooterpage=$('#cleanco_config-showfooterpage .cb-enable,#cleanco_config-showfooterpage .cb-disable'),
  $footerpage=$('#cleanco_config-footerpage').closest('.form-table tr'),
  $footerwidget=$('#cleanco_config-dt-footer-widget-column').parents('.form-table tr');

  var $headerlayout=$('input[name="cleanco_config[dt-header-type]"]'),
  $bgmenuimage=$('#cleanco_config-dt-menu-image').parents('.form-table tr'),
  $bgmenuimagehorizontal=$('#cleanco_config-dt-menu-image-horizontal').parents('.form-table tr'),
  $bgmenuimagesize=$('#cleanco_config-dt-menu-image-size').parents('.form-table tr'),
  $bgmenuimagevertical=$('#cleanco_config-dt-menu-image-vertical').parents('.form-table tr'),
  $navigationicons=$('#cleanco_config-menu_icon_fields').parents('.form-table tr'),
  $navigationicons_color=$('#cleanco_config-leftvc-buttons-color').parents('.form-table tr'),
  $navigationicons_text_color=$('#cleanco_config-leftvc-buttons-text-color').parents('.form-table tr'),
  $navigationicons_background_color=$('#cleanco_config-leftvc-buttons-background-color').parents('.form-table tr'),
  $navigation_background_color=$('#cleanco_config-leftvc-navigation-background-color').parents('.form-table tr'),
  $navigation_logo_background_color=$('#cleanco_config-leftvc-logo-background-color').parents('.form-table tr');

  var $dtshowheader =$('#cleanco_config-dt-show-header .cb-enable,#cleanco_config-dt-show-header .cb-disable'),
  $dtshowheader_child=$('#cleanco_config-dt-show-header').closest('.form-table tr');

  var $showbannerarea =$('#cleanco_config-show-banner-area .cb-enable,#cleanco_config-show-banner-area .cb-disable'),
  $showbannerarea_child=$('#cleanco_config-show-banner-area').closest('.form-table tr');

  var $boxed_layout =$('#cleanco_config-boxed_layout_activate .cb-enable,#cleanco_config-boxed_layout_activate .cb-disable'),
  $boxed_layout_boxed_background_image=$('#cleanco_config-boxed_layout_boxed_background_image').closest('.form-table tr'),
  $boxed_layout_boxed_background_color=$('#cleanco_config-boxed_layout_boxed_background_color').closest('.form-table tr'),
  $boxed_layout_body_background_image=$('#cleanco_config-boxed_layout_body_background_image').closest('.form-table tr'),
  $boxed_layout_body_background_color=$('#cleanco_config-boxed_layout_body_background_color').closest('.form-table tr');


  var $scrollingsidebar =$('#cleanco_config-dt_scrollingsidebar_on .cb-enable,#cleanco_config-dt_scrollingsidebar_on .cb-disable'),
  $scrollingsidebar_position=$('#cleanco_config-dt_scrollingsidebar_position').closest('.form-table tr'),
  $scrollingsidebar_margin=$('#cleanco_config-dt_scrollingsidebar_margin').closest('.form-table tr');


  var $lightbox_1st_on =$('#cleanco_config-lightbox_1st_on .cb-enable,#cleanco_config-lightbox_1st_on .cb-disable'),
  $lightbox_1st_title=$('#cleanco_config-lightbox_1st_title').closest('.form-table tr'),
  $lightbox_1st_delay=$('#cleanco_config-lightbox_1st_delay').closest('.form-table tr'),
  $lightbox_1st_cookie=$('#cleanco_config-lightbox_1st_cookie').closest('.form-table tr'),
  $lightbox_1st_content=$('#cleanco_config-lightbox_1st_content').closest('.form-table tr');

  var $cleancoseo=$('#cleanco_config-cleancoseo .cb-enable,#cleanco_config-cleancoseo .cb-disable'),
  $metaauthor=$('#cleanco_config-meta-author').closest('.form-table tr'),
  $metadescription=$('#cleanco_config-meta-description').closest('.form-table tr'),
  $metakeyword=$('#cleanco_config-meta-keyword').closest('.form-table tr'),
  $footercode=$('#cleanco_config-footer-code').closest('.form-table tr');


  var $disable_automatic_update =$('#cleanco_config-disable_automatic_update .cb-enable,#cleanco_config-disable_automatic_update .cb-disable'),
  $core_automatic_update=$('#cleanco_config-core_automatic_update').closest('.form-table tr');

    $disable_automatic_update.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $core_automatic_update.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
        $core_automatic_update.fadeOut('fast');

      }
    }

  }).live('change',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
       $core_automatic_update.fadeIn('fast');
      }
    }else{

      if($(this).hasClass('selected')){
        $core_automatic_update.fadeOut('fast');
      }
    }

  });

  var headerType=$('input[name="cleanco_config[dt-header-type]"]:checked').val();

  if (headerType=="leftbar") {

      $bgmenuimage.fadeIn('slow');
      $bgmenuimagehorizontal.fadeIn('slow');
      $bgmenuimagevertical.fadeIn('slow');
      $bgmenuimagesize.fadeIn('slow');

      $navigationicons.fadeOut('slow');
      $navigationicons_color.fadeOut('slow');
      $navigationicons_text_color.fadeOut('slow');
      $navigationicons_background_color.fadeOut('slow');
      $navigation_background_color.fadeOut('slow');
      $navigation_logo_background_color.fadeOut('slow');
  }
  else if(headerType=='leftvc'){
      $bgmenuimage.fadeIn('slow');
      $bgmenuimagehorizontal.fadeIn('slow');
      $bgmenuimagevertical.fadeIn('slow');
      $bgmenuimagesize.fadeIn('slow');

      $navigationicons.fadeIn('slow');
      $navigationicons_color.fadeIn('slow');
      $navigationicons_text_color.fadeIn('slow');
      $navigationicons_background_color.fadeIn('slow');
      $navigation_background_color.fadeIn('slow');
      $navigation_logo_background_color.fadeIn('slow');

  } else {


      $bgmenuimagesize.fadeOut('slow');
      $bgmenuimage.fadeOut('slow');
      $bgmenuimagehorizontal.fadeOut('slow');
      $bgmenuimagevertical.fadeOut('slow');
      $navigationicons.fadeOut('slow');
      $navigationicons_color.fadeOut('slow');
      $navigationicons_text_color.fadeOut('slow');
      $navigationicons_background_color.fadeOut('slow');
      $navigation_background_color.fadeOut('slow');
      $navigation_logo_background_color.fadeOut('slow');
  }


  $headerlayout.live('change',function(){

    if ($(this).val()=='leftbar') {
      $bgmenuimage.fadeIn('slow');
      $bgmenuimagehorizontal.fadeIn('slow');
      $bgmenuimagevertical.fadeIn('slow');
      $bgmenuimagesize.fadeIn('slow');

      $navigationicons.fadeOut('slow');
      $navigationicons_color.fadeOut('slow');
      $navigationicons_text_color.fadeOut('slow');
      $navigationicons_background_color.fadeOut('slow');
      $navigation_background_color.fadeOut('slow');
      $navigation_logo_background_color.fadeOut('slow');

    }
    else if($(this).val()=='leftvc'){

      $bgmenuimage.fadeIn('slow');
      $bgmenuimagehorizontal.fadeIn('slow');
      $bgmenuimagevertical.fadeIn('slow');
      $bgmenuimagesize.fadeIn('slow');

      $navigationicons.fadeIn('slow');
      $navigationicons_color.fadeIn('slow');
      $navigationicons_text_color.fadeIn('slow');
      $navigationicons_background_color.fadeIn('slow');
      $navigation_background_color.fadeIn('slow');
      $navigation_logo_background_color.fadeIn('slow');
    } else {

      $bgmenuimagesize.fadeOut('slow');
      $bgmenuimage.fadeOut('slow');
      $bgmenuimagehorizontal.fadeOut('slow');
      $bgmenuimagevertical.fadeOut('slow');

      $navigationicons.fadeOut('slow');
      $navigationicons_color.fadeOut('slow');
      $navigationicons_text_color.fadeOut('slow');
      $navigationicons_background_color.fadeOut('slow');
      $navigation_background_color.fadeOut('slow');
      $navigation_logo_background_color.fadeOut('slow');

    }

  });

  $background.live('change',function(){

    var background = $(this).val();
    switch ( background ) {
      case 'image':
        $backgroundColor.fadeOut('fast');
        $backgroundImage.fadeIn('slow');
        $usefeaturedimage.fadeOut('fast');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeIn('slow');
        }
        break;
      case 'featured':
        $backgroundColor.fadeOut('fast');
        $backgroundImage.fadeIn('slow');
        $usefeaturedimage.fadeIn('slow');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeIn('slow');
        }
        break;
      case 'color':
        $backgroundColor.fadeIn('fast');
        $backgroundImage.fadeOut('slow');
        $usefeaturedimage.fadeOut('fast');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeOut('fast');
        }

        break;
      default:
        $backgroundColor.fadeOut('fast');
        $backgroundImage.fadeOut('slow');
        $usefeaturedimage.fadeOut('fast');
        if($shopbackgroundColor.length){
          $shopbackgroundColor.fadeOut('fast');
        }

      }

  });


 $select.live('change',function(){

    var this_value = $(this).val();

    switch ( this_value ) {
      case 'text':
        $menusource.fadeOut('fast');
        $textsource.fadeIn('slow');
        break;
      case 'menu':
      case 'icon':
        $textsource.fadeOut('fast');
        $menusource.fadeIn('slow');
        break;
      default:
        $textsource.fadeOut('fast');
        $menusource.fadeOut('slow');
    }
   });


  $homebackground.live('change',function(){

     var this_value = $(this).val();

     var $homepageHeaderColorTransparent = $('#cleanco_config-homepage-header-color-transparent').parents('.form-table tr'),
     $homepageHeaderFontColorTransparent = $('#cleanco_config-homepage-header-font-color-transparent').parents('.form-table tr'),
     $homepageDTLogoImageTransparent = $('#cleanco_config-homepage-dt-logo-image-transparent').parents('.form-table tr');
     
    switch ( this_value ) {
      case 'transparent':
        $homebackgroundColor.fadeOut('fast');
        $homepageHeaderColorTransparent.fadeIn('slow');
        $homepageHeaderFontColorTransparent.fadeIn('slow');
        $homepageDTLogoImageTransparent.fadeIn('slow');
        break;
      case 'solid':
      default:
        $homebackgroundColor.fadeIn('slow');
        $homepageHeaderColorTransparent.fadeOut('fast');
        $homepageHeaderFontColorTransparent.fadeOut('fast');
        $homepageDTLogoImageTransparent.fadeOut('fast');
    }

  });

  $pagebackground.live('change',function(){

     var this_value = $(this).val();

     var $headerColorTransparent = $('#cleanco_config-header-color-transparent').parents('.form-table tr'),
     $headerFontColorTransparent = $('#cleanco_config-header-font-color-transparent').parents('.form-table tr'),
     $dtLogoImageTransparent = $('#cleanco_config-dt-logo-image-transparent').parents('.form-table tr');

    switch ( this_value ) {
      case 'transparent':
        $pagebackgroundColor.fadeOut('fast');
        $headerColorTransparent.fadeIn('slow');
        $headerFontColorTransparent.fadeIn('slow');
        $dtLogoImageTransparent.fadeIn('slow');
        break;
      case 'solid':
      default:
        $pagebackgroundColor.fadeIn('slow');
        $headerColorTransparent.fadeOut('fast');
        $headerFontColorTransparent.fadeOut('fast');
        $dtLogoImageTransparent.fadeOut('fast');
    }

  });

  $rselect.live('change',function(){

    var this_value = $(this).val();

    switch ( this_value ) {
      case 'text':
        $rmenusource.fadeOut('fast');
        $rtextsource.fadeIn('slow');
        break;
      case 'menu':
      case 'icon':
        $rtextsource.fadeOut('fast');
        $rmenusource.fadeIn('slow');
        break;
      default:
        $rtextsource.fadeOut('fast');
        $rmenusource.fadeOut('slow');
    }


   });


  $showfooterpage.live('click',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $footerpage.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
          $footerpage.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $footerpage.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){

          $footerpage.fadeOut('fast');
      }
    }

  });

  $showtopbar.live('click',function(e){

    var $showtopbar_child=$('#cleanco_config-showtopbar').closest('.form-table tr');

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){

        $showtopbar_child.siblings().fadeIn('fast');
        $select.trigger('change');
        $rselect.trigger('change');

      }

    }else{
      if($(this).hasClass('selected')){

        $showtopbar_child.siblings().fadeOut('fast');
        $devider1.fadeOut('fast');
        $devider2.fadeOut('fast');
      }
    }

  }).live('change',function(e){

    e.preventDefault();

    var $showtopbar_child=$('#cleanco_config-showtopbar').closest('.form-table tr');
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){

        $showtopbar_child.siblings().fadeIn('fast');
        $select.trigger('change');
        $rselect.trigger('change');

      }
    }else{
      if($(this).hasClass('selected')){

        $showtopbar_child.siblings().fadeOut('fast');
        $devider1.fadeOut('fast');
        $devider2.fadeOut('fast');
      }
    }

  });

  $dtshowheader.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
         $dtshowheader_child.siblings().fadeIn('fast');
         $homebackground.trigger('change');
         $pagebackground.trigger('change');
         $('input[name="cleanco_config[dt-header-type]"]:checked').trigger('change');
      }

    }else{
      if($(this).hasClass('selected')){
        $dtshowheader_child.siblings().fadeOut('fast');
      }
    }

  }).live('change',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $dtshowheader_child.siblings().fadeIn('fast');
         $homebackground.trigger('change');
         $pagebackground.trigger('change');
         $('input[name="cleanco_config[dt-header-type]"]:checked').trigger('change');
      }
    }else{
      if($(this).hasClass('selected')){
        $dtshowheader_child.siblings().fadeOut('fast');
      }
    }

  });

  $showbannerarea.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeIn('fast');
        $background.trigger('change');
      }

    }else{
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeOut('fast');
      }
    }

  }).live('change',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeIn('fast');
        $background.trigger('change');
      }
    }else{
      if($(this).hasClass('selected')){
        $showbannerarea_child.siblings().fadeOut('fast');
      }
    }

  });

 $showfooterarea.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $footertext.fadeIn('fast');
        $footerwidget.fadeIn('fast');
        $footerbackgroundimage.fadeIn('fast');
        $footercolor.fadeIn('fast');
        $footerfontcolor.fadeIn('fast');  
      }

    }else{
      if($(this).hasClass('selected')){
        $footertext.fadeOut('fast');
        $footerwidget.fadeOut('fast');
        $footerbackgroundimage.fadeOut('fast');
        $footercolor.fadeOut('fast');
        $footerfontcolor.fadeOut('fast');  
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $footertext.fadeIn('fast');
        $footerwidget.fadeIn('fast');
        $footerbackgroundimage.fadeIn('fast');
        $footercolor.fadeIn('fast');
        $footerfontcolor.fadeIn('fast');  
      }
    }else{
      if($(this).hasClass('selected')){
        $footertext.fadeOut('fast');
        $footerwidget.fadeOut('fast');
        $footerbackgroundimage.fadeOut('fast');
        $footercolor.fadeOut('fast');
        $footerfontcolor.fadeOut('fast');  
      }
    }

  });

   $boxed_layout.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeIn('fast');
        $boxed_layout_boxed_background_color.fadeIn('fast');
        $boxed_layout_body_background_image.fadeIn('fast');
        $boxed_layout_body_background_color.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeOut('fast');
        $boxed_layout_boxed_background_color.fadeOut('fast');
        $boxed_layout_body_background_image.fadeOut('fast');
        $boxed_layout_body_background_color.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeIn('fast');
        $boxed_layout_boxed_background_color.fadeIn('fast');
        $boxed_layout_body_background_image.fadeIn('fast');
        $boxed_layout_body_background_color.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
        $boxed_layout_boxed_background_image.fadeOut('fast');
        $boxed_layout_boxed_background_color.fadeOut('fast');
        $boxed_layout_body_background_image.fadeOut('fast');
        $boxed_layout_body_background_color.fadeOut('fast');
      }
    }

  });

  $scrollingsidebar.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeIn('fast');
        $scrollingsidebar_margin.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeOut('fast');
        $scrollingsidebar_margin.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeIn('fast');
        $scrollingsidebar_margin.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
        $scrollingsidebar_position.fadeOut('fast');
        $scrollingsidebar_margin.fadeOut('fast');
      }
    }

  });

  $lightbox_1st_on.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeIn('fast');
          $lightbox_1st_delay.fadeIn('fast');
          $lightbox_1st_cookie.fadeIn('fast');
          $lightbox_1st_content.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeOut('fast');
          $lightbox_1st_delay.fadeOut('fast');
          $lightbox_1st_cookie.fadeOut('fast');
          $lightbox_1st_content.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeIn('fast');
          $lightbox_1st_delay.fadeIn('fast');
          $lightbox_1st_cookie.fadeIn('fast');
          $lightbox_1st_content.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
          $lightbox_1st_title.fadeOut('fast');
          $lightbox_1st_delay.fadeOut('fast');
          $lightbox_1st_cookie.fadeOut('fast');
          $lightbox_1st_content.fadeOut('fast');
      }
    }

  });

  $cleancoseo.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $metaauthor.fadeIn('fast');
          $metadescription.fadeIn('fast');
          $metakeyword.fadeIn('fast');
          $footercode.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
          $metaauthor.fadeOut('fast');
          $metadescription.fadeOut('fast');
          $metakeyword.fadeOut('fast');
          $footercode.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $metaauthor.fadeIn('fast');
          $metadescription.fadeIn('fast');
          $metakeyword.fadeIn('fast');
          $footercode.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
          $metaauthor.fadeOut('fast');
          $metadescription.fadeOut('fast');
          $metakeyword.fadeOut('fast');
          $footercode.fadeOut('fast');
      }
    }

  });

   $disable_automatic_update.trigger('change');
   $showtopbar.trigger('change');
   $showbannerarea.trigger('change');
   $dtshowheader.trigger('change');
   $showfooterarea.trigger('change');
   $showfooterpage.trigger('change');
   $scrollingsidebar.trigger('change');
   $lightbox_1st_on.trigger('change');
   $cleancoseo.trigger('change');
   $boxed_layout.trigger('change');
 });
