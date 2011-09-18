<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: index.php
 * 
 * This is the most basic template, if no other template file matches a request
 * this template is loaded.  This template also handles loading the special loop
 * for the front page that restricts what categories it pulls from.  This value
 * is set from within the admin control panel of wordpress
 */

get_header();
?>
<div id="contentMover" style="display: none;">

    <?php
        get_template_part('content', 'loop');
    ?>
    <span class="older"><?php next_posts_link('&laquo; Older Entries'); ?></span>
    <span class="newer"><?php previous_posts_link('Newer Entries &raquo;'); ?></span>
    <br clear="all"/>
</div>
<?php get_sidebar(); ?>

<?php
displayXFTemplate();
get_footer();
?>
