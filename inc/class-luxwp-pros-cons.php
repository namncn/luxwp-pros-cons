<?php
/**
 * Luxwp_Pros_Cons setup
 *
 * @package Luxwp_Pros_Cons
 * @since   3.2.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Luxwp_Pros_Cons Class.
 *
 * @class Luxwp_Pros_Cons
 */
final class Luxwp_Pros_Cons {
	/**
	 * The single instance of the class.
	 *
	 * @var Luxwp_Pros_Cons
	 * @since 1.0.0
	 */
	protected static $instance = null;

	/**
	 * Main Luxwp_Pros_Cons Instance.
	 *
	 * Ensures only one instance of Luxwp_Pros_Cons is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see LPC()
	 * @return Luxwp_Pros_Cons - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Luxwp_Pros_Cons Constructor.
	 */
	public function __construct() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * When WP has loaded all plugins, trigger the `lpc_loaded` hook.
	 *
	 * This ensures `lpc_loaded` is called only after all other plugins
	 * are loaded, to avoid issues caused by plugin directory naming changing
	 * the load order. See #21524 for details.
	 *
	 * @since 1.0.0
	 */
	public function on_plugins_loaded() {
		do_action( 'lpc_loaded' );
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 1.0.0
	 */
	private function init_hooks() {
		add_action( 'plugins_loaded', array( $this, 'on_plugins_loaded' ), -1 );
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 999 );
		add_action( 'init', array( 'LPC_Shortcodes', 'init' ) );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		/**
		 * Class shortcode.
		 */
		include_once LPC_PATH . 'inc/class-lpc-shortcodes.php';
	}

	/**
	 * Init LPC when WordPress Initialises.
	 */
	public function init() {
		// Before init action.
		do_action( 'before_lpc_init' );

		// Set up localisation.
		$this->load_plugin_textdomain();

		// Init action.
		do_action( 'lpc_init' );
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/luxwp-pros-cons/luxwp-pros-cons-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/luxwp-pros-cons-LOCALE.mo
	 */
	public function load_plugin_textdomain() {
		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else {
			// @todo Remove when start supporting WP 5.0 or later.
			$locale = is_admin() ? get_user_locale() : get_locale();
		}

		$locale = apply_filters( 'plugin_locale', $locale, 'luxwp-pros-cons' );

		unload_textdomain( 'luxwp-pros-cons' );
		load_textdomain( 'luxwp-pros-cons', WP_LANG_DIR . '/luxwp-pros-cons/luxwp-pros-cons-' . $locale . '.mo' );
		load_plugin_textdomain( 'luxwp-pros-cons', false, LPC_PATH . 'languages' );
	}

	/**
	 * Enqueue style & scripts.
	 */
	public function enqueue() {
		wp_enqueue_style( 'fontawesome', LPC_URL . 'assets/css/fontawesome.min.css', array(), '5.13.0' );
		wp_enqueue_style( 'fontawesome-solid', LPC_URL . 'assets/css/solid.min.css', array(), '5.13.0' );
		wp_enqueue_style( 'lpc-frontend', LPC_URL . 'assets/css/frontend.css', array(), LPC_VERSION );
	}
}
