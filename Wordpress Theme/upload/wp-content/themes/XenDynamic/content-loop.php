<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: content-loop.php
 * 
 * Loads the basic loop for pages and single posts.
 */

if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <fieldset>
            <ol class="nodeList sectionMain" id="forums">
                <li class="node category level_1" id="main-category.1">
                    <div class="nodeInfo categoryNodeInfo categoryStrip">
                        <div class="categoryText">
                            <h3 class="nodeTitle">
                                <a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                <span style="float:right">
                                    <?php
                                    if (function_exists('xenforo_thread_url')) {
                                        ?>
                                        <a href="members/<?php echo strtolower(get_the_author()); ?>.<?php echo the_author_meta('ID'); ?>/" class="avatar Av4m"><?php the_author(); ?></a> - <?php echo get_the_date(); ?>
                                        <?php
                                    } else {
                                        ?>
                                        <?php the_author(); ?> - <?php echo get_the_date(); ?>
                                        <?php
                                    }
                                    ?>
                                </span>
                                <br clear="all">
                            </h3>
                        </div>
                    </div>
                    <ol class="nodeList">
                        <li class="node forum level_2 XenDynamicNode">
                            <div class="news_item nodeInfo forumNodeInfo" style="border-bottom: none !important;">
                                <?php
                                if (has_post_thumbnail()) {
                                    $image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                                    ?>
                                    <a href="<? echo $image_data[0]; ?>" class="featuredImage"> <?php the_post_thumbnail('home-page-small'); ?></a>
                                    <?php
                                }
                                ?>
                                <?php // echo get_avatar(get_the_author_meta("ID"), 20); ?>
                                <?php echo the_content(); ?>
                                <p>Posted in: <?php the_category(', '); ?></p>
                                <?php wp_link_pages(array('before' => '' . __('Pages:', 'twentyten'), 'after' => '')); ?>
                                <?php
                                comments_template('', true);
                                ?>
                            </div>
                            <?php if (!is_single()) {
                                ?>
                                <a href="<?php echo get_permalink(); ?>"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a>
                                <?php
                            }
                            ?>
                        </li>
                    </ol>
                    <span class="tlc"></span>
                    <span class="trc"></span>
                    <span class="blc"></span>
                    <span class="brc"></span>
                </li>
            </ol>
        </fieldset>
        <?php
    }
}
?>
