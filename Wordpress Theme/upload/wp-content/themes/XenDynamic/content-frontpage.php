<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: content-frontpage.php
 * 
 * Loads the specific loop for the front page of the site.
 */
if (getThemeOption("homepage_block") == 1) {
    get_template_part('content', 'page');
} else {
    the_post();
    addScript("div.titleBar", "html", "<h1>" . get_the_title() . "</h1>");
}
$tmp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$args = array(
    'posts_per_page' => 4,
    'cat' => getThemeOption("featured_cat"),
    'paged' => $paged,
);
$wp_query->query($args);
while ($wp_query->have_posts()) {
    $wp_query->the_post();
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
                        </div>
                        <a href="<?php echo get_permalink(); ?>"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a>
                    </li>
                </ol>
                <span class="tlc"></span>
                <span class="trc"></span>
                <span class="blc"></span>
                <span class="brc"></span>
            </li>
        </ol>
    </fieldset><?php
                    }
                        ?>
<span class="older"><?php next_posts_link('&laquo; Older Entries'); ?></span>
<span class="newer"><?php previous_posts_link('Newer Entries &raquo;'); ?></span>
<br clear="all"/>
<?php
$wp_query = $tmp;