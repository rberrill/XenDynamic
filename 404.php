<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.1.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: 404.php
 * 
 * This is the default page template, it is loaded for any page that doesn't 
 * either specify a template or have one that matches it's slug.
 */

get_header();
?>
<div id="contentMover" style="display: none;">
            <div id="post-0" class="post error404 not-found">
                <?php addScript("div.titleBar", "html", "<h1>404 Not Found</h1>"); ?>
                <div class="entry-content">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/404.png" style="width: 100%" />
                    <p><?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'your-theme' ); ?></p>
<br /><?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </div><!-- #post-0 --></div>
<?php get_sidebar(); ?>

<?php
displayXFTemplate();
get_footer();
?>
