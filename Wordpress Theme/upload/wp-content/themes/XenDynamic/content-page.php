<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: content-page.php
 * 
 * Loads the loop for a static page in wordpress.
 */

if (have_posts()) {
    while (have_posts()) {
        the_post();
        addScript("div.titleBar", "html", "<h1>" . get_the_title() . "</h1>");
        ?>
        <fieldset>
            <?php
            if (is_front_page()) {
                ?>
                <ol class="nodeList sectionMain frontPageMain" id="forums">
                    <?php
                } else {
                    ?>
                    <ol class="nodeList sectionMain" id="forums">
                        <?php
                    }
                    ?>
                    <li class="node category level_1" id="main-category.1">
                        <ol class="nodeList">
                            <li class="node forum level_2 XenDynamicNode">
                                <div class="news_item nodeInfo forumNodeInfo" style="border-bottom: none !important;">
                                    <?php the_content(); ?>
									<?php
										if(is_single()) {
									?>
                                    		<p>Posted in: <?php the_category(', '); ?></p>
                                	<?php
                                		}
                                	?>
                                </div>
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
