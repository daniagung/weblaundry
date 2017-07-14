<?php
defined('ABSPATH') or die();
global $cleanco_Scripts;
wp_enqueue_script( 'social-share-button', get_template_directory_uri() . '/js/share.js', array( 'jquery' ), '', false );
?>
<div class='share-button' id="share_button_left_<?php echo get_the_ID(); ?>"></div>
<?php
    $script = 'var share_button_left = new Share("#share_button_left_'.get_the_ID().'", {
      title: "Share Button Multiple Instantiation Test",
      ui: {
        button_font: false,
        button_text: "'.__('Share','cleanco').'",
        button_background: "none"
      },
      networks: {
        facebook: {
          app_id: "602752456409826",
	      enabled:  true,
	      url: "'.esc_url(get_permalink()).'" 
        },
	    google_plus: {
	      enabled: true,
	      url: "'.esc_url(get_permalink()).'"
	    },
	    twitter: {
	      enabled:  true,
	      url: "'.esc_url(get_permalink()).'" 
	    }
      }
    });';

	array_push($cleanco_Scripts,$script);
?>