<?php
/**
* Plugin Name: WS Redirect WP
* Plugin URI: https://www.silvermuru.ee/en/wordpress/plugins/ws-redirect-wp/
* Description: Redirecting web page visitor to external page
* Version: 1.0.7
* Author: UusWeb.ee
* Author URI: https://www.wordpressi-kodulehe-tegemine.ee/
* Text Domain: ws-redirect-wp
**/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WS_Redirect_WP {
	public function __construct(){
		add_action( 'plugins_loaded', array( $this, 'ws_redirect_wp_load_textdomain' ) );
        add_action( 'init', array( $this, 'ws_redirect_wp_to' ) );
    }

	public function ws_redirect_wp_load_textdomain() {
	  load_plugin_textdomain( 'ws-redirect-wp', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}

    public function ws_redirect_wp_to(){
		global $pagenow;
		if ( 'index.php' == $pagenow && get_option('wsredirect-wp-active-option') == '1' && !is_user_logged_in() && !is_admin() ) {
			wp_redirect( get_option('wsredirect-wp-url-option') );
			exit;
		}
	}

	static function ws_redirect_wp_plugin_activated(){
		update_option( 'wsredirect-wp-active-option', '0' );
	}

	public function ws_redirect_wp_plugin_deactivated(){
		delete_option( 'wsredirect-wp-active-option' );
	}
}

if ( is_admin() ) {
	require plugin_dir_path( __FILE__ ) . '/admin/ws-redirect-wp-admin.php';
}

register_activation_hook( __FILE__, array( 'WS_Redirect_WP', 'ws_redirect_wp_plugin_activated' ) );
register_deactivation_hook( __FILE__, array( 'WS_Redirect_WP', 'ws_redirect_wp_plugin_deactivated' ) );

$wpse_ws_redirect_wp_plugin = new WS_Redirect_WP();
?>
