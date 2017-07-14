<?php
defined('ABSPATH') or die();

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Cleanco
 * @since Cleanco 1.0.0
 */

$top_right_text=get_cleanco_option('dt-right-top-bar-text','');
$text=function_exists('icl_t') ? icl_t('cleanco', 'right-top-bar-text', $top_right_text):$top_right_text;
?>
<div class="right-menu"><div class="topbar-text"><?php print (!empty($text))?$text:"";?></div></div>