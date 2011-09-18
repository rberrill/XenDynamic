<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: single.php
 * 
 * This is the file that renders a single post.
 */

get_header();
?>
<div id="contentMover" style="display: none;">
    <?php
    addScript("div.titleBar", "html", "<h1>" . get_bloginfo('name') . "</h1>");
    get_template_part('content', 'loop');
    ?>
</div>
<?php get_sidebar(); ?>

<?php
displayXFTemplate();
get_footer();
?>
