<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.1.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: page.php
 * 
 * This is the default page template, it is loaded for any page that doesn't 
 * either specify a template or have one that matches it's slug.
 */

get_header();
?>
<div id="contentMover" style="display: none;">
    <?php
    if (is_front_page()) {
        get_template_part('content', 'frontpage');
    } else {
        get_template_part('content', 'page');
    }
    ?>
</div>
<?php get_sidebar(); ?>

<?php
displayXFTemplate();
get_footer();
?>
