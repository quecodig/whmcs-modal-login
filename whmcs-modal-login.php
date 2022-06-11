<?php
/**
 * WHMCS Modal Login
 *
 * Plugin Name:       WHMCS Modal Login
 * Donate link:       https://www.paypal.me/quecodig
 * Description:       WHMCS Login Modal allows you to easily create a modal box that displays for WHMCS login form. It automatically adds a menu item to the end of the selected menu that will open the login modal box.
 * Version:           1.0.0
 * Author:            Qué Código 
 * Author URI:        https://www.quecodigo.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       WHMCS-ml
 * Domain Path:       /languages
 */

namespace quecodig\WHMCS_Modal_Login;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//  Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define "FILE" del plugin
if ( ! defined( 'WHMCS_PLUGIN_FILE' ) ) {
	define( 'WHMCS_PLUGIN_FILE', __FILE__ );
}

// Define "SLUG" del plugin
if ( ! defined( 'WHMCS_SLUG' ) ) {
	define( 'WHMCS_SLUG', 'whmcs_ml_main_menu' );
}

define( 'WHMCS_ML_VERSION', '1.0.0' );

/**
 * Load required files.
 */
function whmcs_ml_init() {
	require dirname( __FILE__ ) . '/inc/whmcs-admin.php';
}

add_action( 'init', __NAMESPACE__ . '\whmcs_ml_init' );

function whmcs_ml_load_textdomain() {
	load_plugin_textdomain( 'whmcs-ml', false, basename( __DIR__ ) . '/languages' );
}

add_action( 'init', __NAMESPACE__ . '\whmcs_ml_load_textdomain' );

function whmcs_ml_styles() {
	wp_enqueue_style( 'whmcs-ml-style', plugins_url('/assets/css/whmcs-modal-login.css', WHMCS_PLUGIN_FILE), WHMCS_ML_VERSION, true );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\whmcs_ml_styles' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\whmcs_ml_styles' );

function whmcs_ml_scripts() {
	wp_enqueue_script( 'whmcs-ml-script', plugins_url('/assets/js/whmcs-modal-login.js', WHMCS_PLUGIN_FILE), '', WHMCS_ML_VERSION, true );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\whmcs_ml_scripts' );

// Redirect to plugin settings after activation
register_activation_hook( __FILE__, __NAMESPACE__ . '\whmcs_ml_activate' );
add_action( 'admin_init', __NAMESPACE__ . '\whmcs_ml_redirect' );

function whmcs_ml_activate() {
	add_option( 'whmcs_ml_do_activation_redirect', true );
}

function whmcs_ml_redirect() {
	if ( get_option( 'whmcs_ml_do_activation_redirect', false ) ) {
		delete_option( 'whmcs_ml_do_activation_redirect' );
		if ( ! isset( $_GET['activate-multi'] ) ) {
			$output = get_option( 'whmcs_ml_settings' );
			$output['lostpassword']    = absint( 0 );
			$output['register']        = absint( 0 );
			wp_redirect( home_url() . '/wp-admin/admin.php?page='+WHMCS_SLUG );
		}
	}
}

// Create the login modal box
add_action( 'wp_footer', __NAMESPACE__ . '\whmcs_modal_login' );

function whmcs_modal_login() {
	$settings      = get_option( 'whmcs_ml_settings' );
	$title         = $settings['tit'];
	@$register      = $settings['register'];
	$register_url  = $settings['register_url'];
	$register_text = $settings['register_text'];
	$login_url     = $settings['loginurl'];
	@$lostpassword  = $settings['lostpassword'];

	$form = "";

	if ( $lostpassword ) {
		$form .= '<p class="login-forgot"><a href="'.$login_url.'/index.php?rp=/password/reset">' . esc_html__( 'Lost your password?' ) . '</a></p>';
	}

	if ( $register ) {
		$form .= '<a href="' . esc_url( $register_url ) . '">';
		$form .= esc_html( $register_text );
		$form .= '</a>';
	}
	?>
	<div class="login-modal-box" id="WMLlogin">
		<div class="modal-content">
			<span class="login-modal-close"></span>
			<h4><?php echo esc_html( $title ); ?></h4>
			<form action="<?php echo esc_html($login_url); ?>dologin.php">
				 <p class="login-username">
				 	<label for="user_login">Nombre de usuario o dirección de correo</label>
				 	<input type="text" name="username" id="user_login" class="input form-control" size="20">
				 </p>
				 <p class="login-password">
				 	<label for="user_pass">Contraseña</label>
				 	<input type="password" name="password" id="user_pass" class="input form-control" size="20">
				 </p>
				 <p class="login-submit">
				 	<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary-color black-hover submitwpcf7-form-control" value="Acceder">
				 	<input type="hidden" name="redirect_to" value="<?php echo esc_html( $login_url ); ?>">
				 </p> 
			</form>
			<?php echo esc_html($form); ?>
		</div>
	</div>
	<?php
}

/**
 * Add shortcode
 *
 * @param [type] $atts
 * @param string $content text within link.
 * @return login link
 */
function whmcs_ml_shortcode( $atts, $content = null ) {
	return '<span class="alogin"><a href="#login" title="login" >' . esc_html($content) . '</a></span>';
}

add_shortcode( 'whmcs-login', __NAMESPACE__ . '\whmcs_ml_shortcode' );

add_filter( 'wp_nav_menu_items', __NAMESPACE__ . '\whmcs_add_login', 10, 2 );

/**
 * Add login logout button.
 *
 * @param [type] $menu
 * @param [type] $args
 * @return void
 */
function whmcs_add_login( $menu, $args ) {
	$settings          = get_option( 'whmcs_ml_settings' );
	$login_location    = $settings['position'];
	$login_menu_label  = $settings['loginmenulabel'];
	$args           = (array) $args;
	$login_location = (array) $login_location;
	if ( ! in_array( $args['theme_location'], $login_location, true ) ) {
		return $menu;
	}

	if ( is_home() ) {
		$login = '<li class="menu-item whmcsmlogin"><a class="nav-link" href="#login" title="Login">' . esc_attr( $login_menu_label ) . '</a></li>';
	} else {
		$login = '<li class="menu-item whmcsmlogin"><a class="nav-link" href="' . get_the_permalink() . '#login" title="Login">' . esc_attr( $login_menu_label ) . '</a></li>';
	}

	if ( has_filter( 'whmcs_add_login_filter' ) ){
		$login = apply_filters( 'whmcs_add_login_filter', $login );
	}
	return $menu . $login;
}

// Uninstall plugin
register_uninstall_hook( __FILE__, 'whmcs_ml_uninstall_plugin' );

function whmcs_ml_uninstall_plugin() {
	$settings = get_option( 'whmcs_ml_settings' );
	delete_option( 'whmcs_ml_settings' );
}