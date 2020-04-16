<?php
/**
 * Shortcodes
 *
 * @package LPC_Shortcodes/Classes
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * LPC_Shortcodes Shortcodes class.
 */
class LPC_Shortcodes {
	/**
	 * Init shortcodes.
	 */
	public static function init() {
		$shortcodes = array(
			'lpcs' => __CLASS__ . '::lpcs',
			'lpc'  => __CLASS__ . '::lpc',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
	}

	/**
	 * Pros and Cons shortcode.
	 *
	 * @param array $atts Attributes.
	 * @param array $content //.
	 * @return string
	 */
	public static function lpcs( $atts, $content ) {
		// @codingStandardsIgnoreStart
		$atts = shortcode_atts( array(
			'columns' => '2',
		), $atts, 'lpcs' );
		// @codingStandardsIgnoreEnd

		ob_start();
		?>

		<?php // @codingStandardsIgnoreStart ?>
		<div class="lpc-wrapper lpc-columns-<?php echo $atts['columns'] ? $atts['columns'] : '2'; ?>">
			<?php echo do_shortcode( wp_kses( $content, array( 'div' => array(), 'ul' => array(), 'li' => array() ) ) ); ?>
		</div>
		<?php // @codingStandardsIgnoreEnd ?>

		<?php
		return ob_get_clean();
	}

	/**
	 * Pros and Cons shortcode.
	 *
	 * @param array $atts Attributes.
	 * @param array $content //.
	 * @return string
	 */
	public static function lpc( $atts, $content ) {
		// @codingStandardsIgnoreStart
		$atts = shortcode_atts( array(
			'title' => '',
			'type'  => 'pros',
		), $atts, 'lpc' );
		// @codingStandardsIgnoreEnd

		ob_start();
		?>

		<?php // @codingStandardsIgnoreStart ?>
		<div class="lpc-column<?php echo ( 'cons' === $atts['type'] ) ? ' lpc-cons' : ' lpc-pros'; ?>">
			<div class="lpc-title"><?php echo esc_html( $atts['title'] ); ?></div>
			<?php if ( $content ) : ?>
				<?php echo wp_kses( $content, array( 'ul' => array(), 'li' => array() ) ); ?>
			<?php endif; ?>
		</div>
		<?php // @codingStandardsIgnoreEnd ?>

		<?php
		return ob_get_clean();
	}
}
