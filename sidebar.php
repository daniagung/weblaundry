<?php
defined('ABSPATH') or die();
 
$sidebar=get_query_var('sidebar');
dynamic_sidebar($sidebar);

locate_template('pagetemplates/scrollingsidebar.php',true);
?>