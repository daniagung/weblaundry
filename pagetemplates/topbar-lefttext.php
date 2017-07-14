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

$left_topbar_text=get_cleanco_option('dt-left-top-bar-text','');
$text=function_exists('icl_t') ? icl_t('cleanco', 'left-top-bar-text', $left_topbar_text):$left_topbar_text;
?>
<div class="left-menu"><div class="topbar-text"><?php print (!empty($text))?$text:"";?></div></div>
