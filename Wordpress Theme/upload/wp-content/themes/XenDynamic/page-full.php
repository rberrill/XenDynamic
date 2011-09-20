<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.1.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * Template Name: No Sidebar
 * File: page-full.php
 * 
 * This is a page template that loads the standard template minus the sidebar.
 */

get_header();
?>
<div id="contentMover" style="display: none;">
    <?php
    get_template_part('content', 'page');
    ?>
</div>
<?php
addScript("aside", "remove", "");
addScript("div.mainContent", "css", array("margin-right", "0px"));
displayXFTemplate();
get_footer();
?>
