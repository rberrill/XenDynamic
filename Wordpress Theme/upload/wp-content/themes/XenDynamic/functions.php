<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.1.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: functions.php
 * 
 * Holds all global functions for the theme and also sets up the options area
 * of the admin control panel.
 */

require_once("includes/theme_options.php");
require_once("includes/xf_integration.php");
require_once("includes/breadcrumb.php");

//******************************************************************************
// Function to insert a jQuery modification script, these are used to edit the
// already rendered template.
//******************************************************************************

function addScript($locator, $jqFunction, $args) {
    global $templateParts;
    $argsList = "";
    if (is_array($args)) {
        foreach ($args as $arg) {
            $argsList .= '"' . $arg . '",';
        }
        $argsList = substr($argsList, 0, -1);
    } else {
        $argsList = "\"" . $args . "\"";
    }
    if($args == "") {
        $templateParts['middle'] = str_replace("<!-- end of middle -->", '<script type="text/javascript">
            <!--
            $("' . $locator . '").' . $jqFunction . '();
            //-->
            </script>
                <!-- end of middle -->', $templateParts['middle']);
    }
    else {
        $templateParts['middle'] = str_replace("<!-- end of middle -->", '<script type="text/javascript">
            <!--
            $("' . $locator . '").' . $jqFunction . '(' . $argsList . ');
            //-->
            </script>
                <!-- end of middle -->', $templateParts['middle']);
    }
}

//******************************************************************************
// Takes input from the comments.php template and formats it for our themes.
// This along with the navbar and the breadbox is one of the few pieces of html
// that isn't dynamic.  Most styles don't change this code though so we can
// get away with it.
//******************************************************************************

function comment_walker($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li class="event primaryContent NewsFeedItem" data-author="<?php echo $comment->comment_author; ?>"> 
        <?php
        if (function_exists('xenforo_thread_url')) {
            ?>
                <div class="avatar Av<?php echo $comment->user_id; ?>s icon" data-avatarHtml="true"><a href="index.php?members/<?php echo $comment->comment_author; ?>.<?php echo $comment->user_id; ?>/" class="avatar Av4m"><?php echo get_avatar($comment->user_id, 20); ?></a></div> 
                <div class="content">
                    <h3 class="description"><a href="index.php?members/<?php echo $comment->comment_author; ?>.<?php echo $comment->user_id; ?>/" class="primaryText"><?php echo $comment->comment_author; ?></a></h3>
            <?php
        } else {
            ?>
                <div class="avatar Av<?php echo $comment->user_id; ?>s icon" data-avatarHtml="true"><?php echo get_avatar($comment->user_id, 20); ?></div> 
                <div class="content">
                    <h3 class="description"><span class="primaryText"><?php echo $comment->comment_author; ?></span></h3>
            <?php
        }
        ?>
            <p class="snippet post">
    <?php echo $comment->comment_content; ?>
            </p>
            <abbr class="DateTime">
    <?php
    comment_date();
    echo " - ";
    comment_time();
    ?>
            </abbr> 
        </div> 
    <?php
}

//******************************************************************************
// This copyright information can be removed only if you purchase a branding
// free option.  See http://rcbdesigns.net for details.
//******************************************************************************

function xd_footer() {
    echo "<div id='xd_footer' style='text-align: center; margin: 0px; font-size:small;'><a href='http://rcbdesigns.net'>XenDynamic Theme by RCBDesigns</a></div>";
}

add_action('wp_footer', 'xd_footer');

//******************************************************************************
// Register the sidebar so that it can be dynamically rendered.  
// RCBD TODO: Need to adjust this to handle widgets that have no title
//******************************************************************************


if (function_exists('register_sidebar'))
    register_sidebar(array(
        'name' => 'Right Sidebar',
        'before_widget' => '		<div id="%1$s" class="widget section %2$s"><div class="secondaryContent">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

if (function_exists("add_theme_support")) {
    add_theme_support('post-thumbnails');
    add_image_size('home-page-large', 300, 300, true);
    add_image_size('home-page-small', 100, 100, true);
}
