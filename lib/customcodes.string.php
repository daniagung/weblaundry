<?php
defined('ABSPATH') or die();

function my_custom_tinymce_plugin_translation() {
    $strings = array(
        'insert_dt_shortcode' => __('Insert Cleanco Shortcode', 'cleanco'),
        'dt_shortcode' => __('Cleanco Shortcode', 'cleanco'),
        'icon_title' => __('Icon', 'cleanco'),
        'button_title'=>__('Buttons','cleanco'),
        'counto_title'=>__('Count To','cleanco'),
    );
    $locale = _WP_Editors::$mce_locale;

    $translated = 'tinyMCE.addI18n("' . $locale . '.dtshortcode", ' . json_encode( $strings ) . ");\n";

     return $translated;
}

$strings = my_custom_tinymce_plugin_translation();

?>