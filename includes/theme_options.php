<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.1.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: theme_options.php
 * 
 * This file will hold all code and functions for the theme options page
 * as well as pulling those options into the various pages.
 */

// Default options values
$xd_options = array(
 'featured_cat' => '',
 'xenforo_path' => '/community',
 'homepage_block' => true
);

function getThemeOption($themeOption) {
    global $xd_options;
    $settings = get_option( 'xd_options', $xd_options );
    return $settings[$themeOption];
}


if ( is_admin() ) : // Load only if we are viewing an admin page

function xd_register_settings() {
// Register settings and call sanitation functions
register_setting( 'xd_theme_options', 'xd_options', 'xd_validate_options' );
}

add_action( 'admin_init', 'xd_register_settings' );

// Store categories in array
$xd_categories[0] = array(
'value' => 0,
 'label' => ''
);
$xd_cats = get_categories();
$i = 1;
foreach( $xd_cats as $xd_cat ) :
$xd_categories[$xd_cat->cat_ID] = array(
'value' => $xd_cat->cat_ID,
 'label' => $xd_cat->cat_name
);
$i++;
endforeach;

function xd_theme_options() {
// Add theme options page to the addmin menu
add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'xd_theme_options_page' );
}

add_action( 'admin_menu', 'xd_theme_options' );

// Function to generate options page
function xd_theme_options_page() {
global $xd_options, $xd_categories;

if (!isset( $_REQUEST['updated'] ) )
$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. 
?>

<div class="wrap">

    <?php screen_icon();
    echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
    // This shows the page's name and an icon if one has been provided  ?>

<?php if ( false !== $_REQUEST['updated'] ) : ?>
    <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
        <?php endif; // If the form has just been submitted, this shows the notification  ?>

    <form method="post" action="options.php">

        <?php $settings = get_option( 'xd_options', $xd_options ); ?>

        <?php settings_fields( 'xd_theme_options' );
        /* This function outputs some hidden fields required by the form,
          including a nonce, a unique number used to ensure the form has been submitted from the admin page
          and not somewhere else, very important for security */ ?>

        <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->

            <tr valign="top"><th scope="row">Xenforo Path</th>
                <td>
                    <input id="xenforo_path" name="xd_options[xenforo_path]" type="text" value="<?php  esc_attr_e($settings['xenforo_path']); ?>" />
                    <label for="xenforo_path"><p>
                        <strong>No trailing slash</strong>
                        <p>
	                        <em>
    	                        e.g. if Wordpress is in /wordpress and XenForo is in /community you would enter '../community' here
        	                </em>
        	            </p>
                        <p>
	                        <em>
    	                        e.g. if Wordpress is in / and XenForo is in /community you would enter '/community' here
        	                </em>
        	            </p>
                    </p></label>
                </td>
            </tr>

            <tr valign="top"><th scope="row"><label for="featured_cat">Front Page Category</label></th>
                <td>
                    <select id="featured_cat" name="xd_options[featured_cat]">
                        <?php
                        foreach ( $xd_categories as $category ) :
                        $label = $category['label'];
                        $selected = '';
                        if ( $category['value'] == $settings['featured_cat'] )
                        $selected = 'selected="selected"';
                        echo '<option style="padding-right: 10px;" value="' . esc_attr( $category['value'] ) . '" ' . $selected . '>' . $label . '</option>';
                        endforeach;
                        ?>
                    </select>
                </td>
            </tr>

            <tr valign="top"><th scope="row">Home Page Block</th>
                <td>
                    <input type="checkbox" id="homepage_block" name="xd_options[homepage_block]" value="1" <?php checked( true, $settings['homepage_block'] ); ?> />
                    <label for="homepage_block">Show a content block from the description of the home page. 
                        <p>NOTE: <em>This will only work if a static home page is set under <a href="options-reading.php">Reading Settings</a></em></p></label>
                </td>
            </tr>

        </table>

        <p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

    </form>

</div>

<?php
}

function xd_validate_options( $input ) {
global $xd_options, $xd_categories;

$settings = get_option( 'xd_options', $xd_options );

// We strip all tags from the text field, to avoid vulnerablilties like XSS
$input['xenforo_path'] = wp_filter_post_kses( $input['xenforo_path'] );

// We select the previous value of the field, to restore it in case an invalid entry has been given
$prev = $settings['featured_cat'];
// We verify if the given value exists in the categories array
if (!array_key_exists( $input['featured_cat'], $xd_categories ) )
$input['featured_cat'] = $prev;

// If the checkbox has not been checked, we void it
if (!isset( $input['homepage_block'] ) )
$input['homepage_block'] = null;
// We verify if the input is a boolean value
$input['homepage_block'] = ( $input['homepage_block'] == 1 ? 1 : 0 );

return $input;
}

endif;  // EndIf is_admin()