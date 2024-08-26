<?php
/*
Plugin Name: Under Construction Mode
Plugin URI: https://lab.mbonisi.com/
Description: A simple plugin that displays an "Under Construction" page to non-logged-in users.
Version: 1.0
Author: Mbonisi M
Author URI: https://mbonisi.com/
License: GPLv2 or later
*/

// Hook into the 'template_redirect' action to conditionally show the "Under Construction" page


function ucm_under_construction_mode() {
    // Check if the Under Construction mode is enabled
    if (!is_user_logged_in() && get_option('ucm_enable')) {
        // Load the custom "Under Construction" template
        include(plugin_dir_path(__FILE__) . 'under-construction-template.php');
        exit();
    }
}


add_action('template_redirect', 'ucm_under_construction_mode');

// Enqueue styles for the Under Construction page
function ucm_enqueue_styles() {
    if (!is_user_logged_in()) {
        wp_enqueue_style('ucm-styles', plugin_dir_url(__FILE__) . 'style.css');
    }
}
add_action('wp_enqueue_scripts', 'ucm_enqueue_styles');


// Hook to add a new item to the admin menu
function ucm_add_admin_menu() {
    add_options_page(
        'Under Construction Settings', // Page title
        'Under Construction',           // Menu title
        'manage_options',               // Capability
        'under-construction',           // Menu slug
        'ucm_settings_page'             // Callback function
    );
}
add_action('admin_menu', 'ucm_add_admin_menu');

// Callback function to display the settings page
function ucm_settings_page() {
    ?>
    <div class="wrap">
        <h1>Under Construction Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ucm_settings_group');
            do_settings_sections('under-construction');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function ucm_register_settings() {
    register_setting('ucm_settings_group', 'ucm_enable');
    register_setting('ucm_settings_group', 'ucm_message');
    register_setting('ucm_settings_group', 'ucm_background_color');
    register_setting('ucm_settings_group', 'ucm_background_image');
    register_setting('ucm_settings_group', 'ucm_overlay_opacity');

    add_settings_section(
        'ucm_settings_section',
        'Under Construction Settings',
        'ucm_settings_section_callback',
        'under-construction'
    );

    add_settings_field(
        'ucm_enable',
        'Enable Under Construction Mode',
        'ucm_enable_field_callback',
        'under-construction',
        'ucm_settings_section'
    );

    add_settings_field(
        'ucm_message',
        'Custom Message',
        'ucm_message_field_callback',
        'under-construction',
        'ucm_settings_section'
    );

    add_settings_field(
        'ucm_background_color',
        'Background Color',
        'ucm_background_color_field_callback',
        'under-construction',
        'ucm_settings_section'
    );

    add_settings_field(
        'ucm_background_image',
        'Background Image URL',
        'ucm_background_image_field_callback',
        'under-construction',
        'ucm_settings_section'
    );

    add_settings_field(
        'ucm_overlay_opacity',
        'Overlay Opacity (%)',
        'ucm_overlay_opacity_field_callback',
        'under-construction',
        'ucm_settings_section'
    );
}
add_action('admin_init', 'ucm_register_settings');

// Field callback for background color
function ucm_background_color_field_callback() {
    $ucm_background_color = get_option('ucm_background_color', '#000000');
    ?>
    <input type="text" name="ucm_background_color" value="<?php echo esc_attr($ucm_background_color); ?>" class="color-picker" />
    <?php
}

// Field callback for background image
function ucm_background_image_field_callback() {
    $ucm_background_image = get_option('ucm_background_image', '');
    ?>
    <input type="text" name="ucm_background_image" value="<?php echo esc_attr($ucm_background_image); ?>" />
    <button class="upload-button button">Upload Image</button>
    <?php
}

// Field callback for overlay opacity
function ucm_overlay_opacity_field_callback() {
    $ucm_overlay_opacity = get_option('ucm_overlay_opacity', 70);
    ?>
    <input type="number" name="ucm_overlay_opacity" value="<?php echo esc_attr($ucm_overlay_opacity); ?>" min="0" max="100" />
    <p class="description">Enter a value between 0 and 100.</p>
    <?php
}


// Section callback
function ucm_settings_section_callback() {
    echo 'Configure the Under Construction mode settings below:';
}

// Field callback for enabling/disabling the mode
function ucm_enable_field_callback() {
    $ucm_enable = get_option('ucm_enable');
    ?>
    <input type="checkbox" name="ucm_enable" value="1" <?php checked(1, $ucm_enable, true); ?> />
    <label for="ucm_enable">Enable Under Construction Mode</label>
    <?php
}

// Field callback for the custom message
function ucm_message_field_callback() {
    $ucm_message = get_option('ucm_message', 'Our website is currently undergoing maintenance. Please check back later.');
    ?>
    <textarea name="ucm_message" rows="5" cols="50"><?php echo esc_textarea($ucm_message); ?></textarea>
    <?php
}



