<?php 
/*
 * Plugin Name:  uikar facebook comments
 * Plugin URI: http://uikar.com
 * Description: Wordpress User Registration and login form
 * Version: 1.0
 * Author: Saman Tohidian
 * Author URI: http://uikar.com
 * Text Domain: uikar-fbcomments
 * Domain Path: /languages/
 *
 */
define('UIKAR_FBCOMMENTS_BUILDER_DIR', plugin_dir_path(__FILE__));
define('UIKAR_FBCOMMENTS_BUILDER_URL', plugin_dir_url(__FILE__));

require_once(UIKAR_FBCOMMENTS_BUILDER_DIR.'includes/functions.php');

register_activation_hook(__FILE__, 'uikar_fbcomment_builder_activation');
//register_deactivation_hook(__FILE__, 'uikar_form_builder_deactivation');
 
function uikar_fbBuilder_load() {

    if (is_admin()) { //load admin files only in admin
        require_once(UIKAR_FBCOMMENTS_BUILDER_DIR . 'includes/admin.php');
    }
}

uikar_fbBuilder_load();

add_action('plugins_loaded', 'uikar_fbcomment_load_textdomain');
function uikar_fbcomment_load_textdomain() {
	load_plugin_textdomain( 'uikar-registration', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

// Register a new shortcode: [uikar_fbcomments]
add_shortcode( 'uikar_fbcomments', 'uikar_fbcomments_shortcode' );

// The callback function that will replace [book]
function uikar_fbcomments_shortcode() {
    ob_start();
    uikar_fbcomments_main();
    return ob_get_clean();
}

function uikar_fbcomment_builder_activation() {
//    uirg_addRegisterPage();
}



?>