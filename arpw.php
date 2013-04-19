<?php
/*
Plugin Name: Advanced Random Posts Widget
Plugin URI: http://wordpress.org/extend/plugins/advanced-random-posts-widget/
Description: Enables advanced random posts widget.
Version: 1.4
Author: Satrya
Author URI: http://satrya.me/
Author Email: satrya@satrya.me
License: GPLv2
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ARP_Widget' ) ) :

class ARP_Widget {

	/**
	 * PHP5 constructor method.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );

		add_action( 'init', array( &$this, 'init' ) );

	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 1.0
	 */
	public function constants() {

		define( 'ARPW_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		define( 'ARPW_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		define( 'ARPW_INCLUDES', ARPW_DIR . trailingslashit( 'includes' ) );

	}

	/**
	 * Loads the translation files.
	 *
	 * @since 1.0
	 */
	public function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'arpw', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 1.0
	 */
	public function includes() {

		require_once( ARPW_INCLUDES . 'widget-advanced-random-posts.php' );
	}

	/**
	 * Register custom style for the widget.
	 *
	 * @since 1.0
	 */
	function init() {
		
		if( ! is_admin() ) {

			wp_enqueue_style( 'arpw-style', ARPW_URI . 'arpw.css' );

		}

	}

}

new ARP_Widget;
endif;
?>