<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: style.css
 * 
 * This renders the sidebar and if widgets are loaded brings them in to the theme.
 */

?>
<div class="sidebar XenDynamicSB" style="diplay:none;">
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
                    <div class="section">		
                        <div class="secondaryContent"> 
                            <h3>Temporary Widget</h3> 
                            <div class="footnote"> 
                                Replace this widget with any Wordpress Widget
                            </div> 
                        </div> 
                    </div> 
<?php endif; ?>
		</div> 
