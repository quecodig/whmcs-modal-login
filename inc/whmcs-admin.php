<?php
/**
 *
 * @link       https://www.quecodigo.com
 * @since      1.0.0
 *
 * @package    whmcs_Login
 */

namespace quecodig\WHMCS_Modal_Login;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'plugin_action_links_whmcs-modal-login/whmcs-modal-login.php', __NAMESPACE__ . '\whmcs_settings_link' );

function whmcs_settings_link( $links ) {
	$url = esc_url(
		add_query_arg(
			'page',
			WHMCS_SLUG,
			get_admin_url() . 'admin.php'
		)
	);

	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	array_push(
		$links,
		$settings_link
	);
	return $links;
};


if ( ! function_exists( __NAMESPACE__ . '\whmcs_ml_parent_page' ) ) {

	function whmcs_ml_parent_page() {
		//Page title
		$page_title = esc_html__( 'WHMCS Modal Login - Qué Código', 'whmcs-ml' );
		//Menu section title
		//$warning_count = get_option( 'quecodig_warnings' );
		$warning_count = 0;
		$menu_title =  esc_html__( 'WHMCS Modal Login', 'whmcs-ml' );
		//User compatibility
		$capability = 'edit_posts';
		//Menu section icon url
		$url  = WHMCS_SLUG;
		//Function to display the page
		$function   = __NAMESPACE__ . '\whmcs_ml_main_menu_settings';
		// Icon url
		$icon_url   = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAxOS45Ij48ZGVmcz48c3R5bGU+LmNscy0xe2lzb2xhdGlvbjppc29sYXRlO30uY2xzLTJ7ZmlsbDojZmZmO29wYWNpdHk6MC43O30uY2xzLTMsLmNscy00e2ZpbGw6I2VlZTt9LmNscy00e29wYWNpdHk6MC4xMTttaXgtYmxlbmQtbW9kZTpkaWZmZXJlbmNlO308L3N0eWxlPjwvZGVmcz48dGl0bGU+UmVjdXJzbyAxPC90aXRsZT48ZyBjbGFzcz0iY2xzLTEiPjxnIGlkPSJDYXBhXzIiIGRhdGEtbmFtZT0iQ2FwYSAyIj48ZyBpZD0iQ2FwYV8xLTIiIGRhdGEtbmFtZT0iQ2FwYSAxIj48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik0xMy41MSwxMS42OGE0LjkzLDQuOTMsMCwwLDEsNS4xNC00LjQ1YzEuNTYsMC0xLjcyLjE2LTIsMy4zN0MxNi4yNiwxNC4zLDEzLjM3LDEzLjI0LDEzLjUxLDExLjY4WiIvPjxwYXRoIGNsYXNzPSJjbHMtMyIgZD0iTTIxLjE4LDcuNTZjMCwuMSwwLC4yLDAsLjMsMCwzLjM5LTIuNjEsNS43NC00LjU5LDgtLjI3LjMtLjY1LjcxLTEuMDgsMS4xNSwxLjQsMS40MywzLDIuOTQsMywyLjk0czItMiwyLjc0LTIuOEMyMi40NCwxNS43OCwyNCwxNC4zOCwyNCwxMi4zNkE1LjQ5LDUuNDksMCwwLDAsMjEuMTgsNy41NloiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik02Ljg2LDE1LjQ3QzQuOCwxMy4zNiwyLjgxLDExLDIuODEsNy44NmMwLS4xLDAtLjIsMC0uM0E1LjQ5LDUuNDksMCwwLDAsMCwxMi4zNmMwLDEuODksMS4xOSwzLjI4LDIuNDIsNC41NCwxLjQxLDEuNDQsMy4wNiwzLDMuMDYsM3MyLTIsMi43NC0yLjhMOC4zNSwxN0M3Ljg1LDE2LjQ4LDcuMzUsMTYsNi44NiwxNS40N1oiLz48cGF0aCBjbGFzcz0iY2xzLTMiIGQ9Ik0xMiwxOC44OGMtLjg3LS44My0yLjcxLTIuNTktNC4zMi00LjI0QzUuODQsMTIuNzcsNC4wNSwxMC43MSw0LjA1LDhBOCw4LDAsMCwxLDIwLDhjMCwyLjUzLTEuNzQsNC40Mi0zLjQzLDYuMjRMMTUuOCwxNUMxNSwxNS45MiwxMi45MywxOCwxMiwxOC44OFoiLz48cGF0aCBjbGFzcz0iY2xzLTIiIGQ9Ik00LjQ5LDcuNDNjLjQxLTQuNSw0LjE2LTcsOC4xNS03LDIuNDcsMC0yLjczLjI2LTMuMjMsNS4zNUM4Ljg0LDExLjU4LDQuMjYsOS45MSw0LjQ5LDcuNDNaIi8+PHBhdGggY2xhc3M9ImNscy00IiBkPSJNMTIsMTguODhjLjk0LS45MywzLTMsMy44MS0zLjlsLjcyLS43OUMxOC4yMSwxMi4zNywyMCwxMC40OCwyMCw4QTcuODksNy44OSwwLDAsMCwxOC4yMSwzQzE2LjI5LDEzLjM5LDcuNjcsMTQuNjQsNy42NywxNC42NCw5LjI4LDE2LjI5LDExLjEyLDE4LjA1LDEyLDE4Ljg4WiIvPjwvZz48L2c+PC9nPjwvc3ZnPg==';
		// Position in the menu
		$position   = 2;
		// We add the options

		if ( ! whmcs_ml_menu_exists( 'quecodigo_soporte' ) ) {
			add_menu_page($page_title, $menu_title, $capability, $url, $function, $icon_url, $position);
		}else{
			add_submenu_page('quecodigo_soporte', $page_title, $menu_title, $capability, WHMCS_SLUG, $function);
		}

	}
	add_action( 'admin_menu', __NAMESPACE__ . '\whmcs_ml_parent_page' );
}


// Render settings form
function whmcs_ml_main_menu_settings() {

	$plugin_url = plugin_dir_url( __DIR__ );

	?>
	<div class="wrap">
	<h2>
	<?php esc_html_e( 'WHMCS Modal Login', 'whmcs-ml' ); ?>
	</h2>
	<a href="https://www.quecodigo.com" target="_blank"><img src="<?php echo plugins_url( 'assets/img/logo-azul.svg', WHMCS_PLUGIN_FILE); ?>" width="100" class="logo-whmcs"></a>
	<form action="options.php" method="post" class="whmcs-form">

	<?php
		settings_fields( 'whmcs_ml_settings_group' );
		do_settings_sections( WHMCS_SLUG);
		submit_button();
	?>
	</form>
	<div class="whmcs-info">
	<p>
	<?php echo nl2br( esc_html__( 'You can also use the login modal window anywhere on the website using the shortcode [whmcs-login] Custom text [/whmcs-login]', 'whmcs-ml' ) ); ?>
	</p>
	</div>
	</div>
	<?php
}

add_action( 'admin_init', __NAMESPACE__ . '\whmcs_ml_settings_init' );

function whmcs_ml_settings_init() {

	// Register the setting
	register_setting( 'whmcs_ml_settings_group', 'whmcs_ml_settings', 'whmcs_ml_sanitize_validate_settings' );

	add_settings_section( 'whmcs_ml_section', '', __NAMESPACE__ . '\whmcs_ml_section_callback', WHMCS_SLUG );

	$settings = get_option(
		'whmcs_ml_settings',
		array(
			'loginmenulabel'  => esc_html__( 'Login', 'whmcs-ml' ),
			'logoutmenulabel' => esc_html__( 'Logout', 'whmcs-ml' ),
			'position'        => '',
		)
	);

	add_settings_field(
		'whmcs_ml_field_showpass',
		esc_html__( 'Display Lost Password option', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'  => 'whmcs_ml_settings[lostpassword]',
			'value' => @$settings['lostpassword'],
			'type'  => 'checkbox',
		)
	);

	add_settings_field(
		'whmcs_ml_field_tit',
		esc_html__( 'Header title', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'        => 'whmcs_ml_settings[tit]',
			'value'       => @$settings['tit'],
			'type'        => 'textbox',
			'placeholder' => 'Login Form',
			'description' => esc_html__( 'Title text displayed before the login form (you can leave it empty)', 'whmcs-ml' ),
		)
	);

	add_settings_field(
		'whmcs_ml_login_label',
		esc_html__( 'Login menu label', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'        => 'whmcs_ml_settings[loginmenulabel]',
			'value'       => @$settings['loginmenulabel'],
			'type'        => 'textbox',
			'placeholder' => esc_html__( 'Login', 'whmcs-ml' ),
			'description' => esc_html__( 'Menu label for login option', 'whmcs-ml' ),
		)
	);

	$options = get_nav_menu_locations();

	add_settings_field(
		'whmcs_ml_field_position',
		esc_html__( 'Select a menu to add login item', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'        => 'whmcs_ml_settings[position][]',
			'value'       => @$settings['position'],
			'type'        => 'select',
			'options'     => $options,
			'description' => esc_html__( 'Hold Ctrl or Cmd key to select more than one menu', 'whmcs-ml' ),
		)
	);

	add_settings_field(
		'whmcs_ml_field_loginurl',
		esc_html__( 'WHMCS URL', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'        => 'whmcs_ml_settings[loginurl]',
			'value'       => @$settings['loginurl'],
			'type'        => 'textbox',
			'description' => esc_html__( 'WHMCS URL ejm: https://www.domain.com/whmcs', 'whmcs-ml' ),
			'placeholder' => 'Url to WHMCS',
		)
	);

	add_settings_field(
		'whmcs_ml_field_register',
		esc_html__( 'Display Register link', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'  => 'whmcs_ml_settings[register]',
			'value' => @$settings['register'],
			'type'  => 'checkbox',
			'placeholder' => 'Register',
		)
	);

	add_settings_field(
		'whmcs_ml_field_registerurl',
		esc_html__( 'Register link URL', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'        => 'whmcs_ml_settings[register_url]',
			'value'       => @$settings['register_url'],
			'type'        => 'textbox',
			'placeholder' => 'https://',
		)
	);

	add_settings_field(
		'whmcs_ml_field_registertext',
		esc_html__( 'Register link text', 'whmcs-ml' ),
		__NAMESPACE__ . '\whmcs_ml_fields_callback',
		WHMCS_SLUG,
		'whmcs_ml_section',
		array(
			'name'        => 'whmcs_ml_settings[register_text]',
			'value'       => @$settings['register_text'],
			'type'        => 'textbox',
			'placeholder' => 'Not registered? Sign up now',
		)
	);

}

// Sanitize and validate settings
function whmcs_ml_sanitize_validate_settings( $input ) {

	$output = get_option( 'whmcs_ml_settings' );

	$output['tit']             = sanitize_text_field( $input['tit'] );
	$output['position']        = (array) $output['position'];
	$output['loginurl']        = sanitize_text_field( $input['loginurl'] );
	$output['remember']        = absint( $input['remember'] );
	$output['lostpassword']    = absint( (empty($input['lostpassword']))? $input['lostpassword'] : 0 );
	$output['loginmenulabel']  = sanitize_text_field( $input['loginmenulabel'] );
	$output['register']        = absint( (empty($input['register']))? $input['register'] : 0 );
	$output['registerurl']     = sanitize_text_field( $input['registerurl'] );
	$output['registertext']    = sanitize_text_field( $input['registertext'] );

	return $output;
}

function whmcs_ml_section_callback() {
	echo nl2br( esc_html__( 'The plugin creates a Login item at the end of the selected menu.', 'whmcs-ml' ) );
	echo nl2br( esc_html__( 'On this page you can set the options for the modal login screen.', 'whmcs-ml' ) );
}

function whmcs_ml_fields_callback( $args ) {
	switch ( $args['type'] ) :
		case 'checkbox':
			?>
			<input type="checkbox" name="<?php echo esc_attr( $args['name'] ); ?>" <?php checked( $args['value'], 1 ); ?> value="1">
			<?php
			break;
		case 'select':
			?>
			<select multiple name="<?php echo esc_attr( $args['name'] ); ?>">
				<option value=''><?php echo esc_html__( 'None', 'whmcs-ml' ); ?></option>
				<?php
					$options       = $args['options'];
					$args['value'] = (array) $args['value'];
					foreach ( $options as $key => $value ) {
						echo '<option value="' . esc_attr( $key ) . '"';
						if ( in_array( $key, $args['value'], true ) ) {
							echo ' selected ';
						}
						echo '>' . esc_attr( $key ) . '</option>';
					}
				?>
			</select>
			<?php
			break;
		default:
			echo '<input type="text" name="' . esc_attr( $args['name'] ) . '" value="' . esc_attr( $args['value'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" size="60">';
			break;
	endswitch;

	if ( ! empty( $args['description'] ) ) :
		echo '<p class="description">' . esc_attr( $args['description'] ) . '</p>';
	endif;
}

if ( ! function_exists( 'whmcs_ml_menu_exists' ) ) {
	function whmcs_ml_menu_exists( $handle, $sub = false ) {
		if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			return false;
		}
		global $menu, $submenu;
		$check_menu = $sub ? $submenu : $menu;
		if ( empty( $check_menu ) ) {
			return false;
		}
		foreach ( $check_menu as $k => $item ) {
			if ( $sub ) {
				foreach ( $item as $sm ) {
					if ( $handle === $sm[2] ) {
						return true;
					}
				}
			} else {
				if ( $handle === $item[2] ) {
					return true;
				}
			}
		}
		return false;
	}
}
?>
