<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WS_Redirect_WP_admin {
    
    public function __construct(){
		add_action( 'admin_menu', array( $this, 'ws_redirect_wp_settings_create_menu' ) );
		add_action( 'admin_init', array( $this, 'ws_redirect_wp_settings_register' ) );
		add_filter( 'plugin_action_links_ws-redirect-wp/ws-redirect-wp.php', array( $this, 'ws_redirect_wp_action_links' ) );
    }
    
    public function ws_redirect_wp_settings_create_menu() {
        add_options_page( __( 'WS Redirect WP Settings', 'ws-redirect-wp-page' ), 'WS Redirect WP', 'manage_options', 'ws-redirect-wp-settings', array( $this, 'ws_redirect_wp_settings_page' ) );
    }

    public function ws_redirect_wp_settings_register() {
        register_setting( 'ws-redirect-wp-settings-group', 'wsredirect-wp-url-option' );
		register_setting( 'ws-redirect-wp-settings-group', 'wsredirect-wp-active-option' );
    }

    public function ws_redirect_wp_settings_page() {
        ?>
        <div class="wrap">
            <h2><?php _e( 'WS Redirect WP Settings', 'ws-redirect-wp-page' ); ?></h2>
        </div>

        <form method="post" action="options.php">
            <?php settings_fields( 'ws-redirect-wp-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php echo _e( 'Active', 'ws-redirect-wp-page' ); ?></th>
                    <td>
                        <select id="active_options" name="wsredirect-wp-active-option">
							<option value="0"<?php if (get_option('wsredirect-wp-active-option') == '0') { echo ' selected'; } ?>><?php _e('Deactivated') ?></option>
							<option value="1"<?php if (get_option('wsredirect-wp-active-option') == '1') { echo ' selected'; } ?>><?php _e('Activated') ?></option>
						</select>
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><?php echo _e( 'Url', 'ws-redirect-wp-page' ); ?></th>
                    <td>
                        <input class="regular-text" type="text" name="wsredirect-wp-url-option" value="<?php echo get_option('wsredirect-wp-url-option'); ?>" placeholder="<?php echo esc_html_e( 'Url where to redirect site', 'ws-redirect-wp-page' ); ?>" />
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>

        </form>
        <?php
    }

    public function ws_redirect_wp_action_links( $links ) {
        $mylinks = array(
            '<a href="' . admin_url( 'options-general.php?page=ws-redirect-wp-settings' ) . '">Settings</a>',
        );
        return array_merge( $links, $mylinks );
    }
}

$wpse_ws_redirect_wp_plugin_admin = new WS_Redirect_WP_admin();
?>