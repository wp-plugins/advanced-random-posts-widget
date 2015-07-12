<?php
/**
 * Custom random posts widget.
 *
 * @package    Advanced_Random_Posts_Widget
 * @since      0.0.1
 * @author     Satrya
 * @copyright  Copyright (c) 2014, Satrya
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */
class Advanced_Random_Posts_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 0.0.1
	 */
	function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'arpw-widget-random',
			'description' => __( 'An advanced widget that gives you total control over the output of the random posts.', 'arpw' )
		);

		$control_ops = array(
			'width'  => 700,
			'height' => 350,
		);

		// Create the widget.
		parent::__construct(
			'arpw-widget',                // $this->id_base
			__( 'Random Posts', 'arpw' ), // $this->name
			$widget_options,              // $this->widget_options
			$control_ops                  // $this->control_options
		);

	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since  0.0.1
	 */
	function widget( $args, $instance ) {
		extract( $args );

		// Output the theme's $before_widget wrapper.
		echo $before_widget;

		// If both title and title url is not empty, display it.
		if ( ! empty( $instance['title_url'] ) && ! empty( $instance['title'] ) ) {
			echo $before_title . '<a href="' . esc_url( $instance['title_url'] ) . '" title="' . esc_attr( $instance['title'] ) . '">' . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . '</a>' . $after_title;

		// If the title not empty, display it.
		} elseif ( ! empty( $instance['title'] ) ) {
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
		}

		// Get the random posts query.
		echo arpw_get_random_posts( $instance );

		// Close the theme's widget wrapper.
		echo $after_widget;

	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since  0.0.1
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']             = strip_tags( $new_instance['title'] );
		$instance['title_url']         = esc_url( $new_instance['title_url'] );

		$instance['offset']            = (int) $new_instance['offset'];
		$instance['limit']             = (int) $new_instance['limit'];
		$instance['ignore_sticky']     = isset( $new_instance['ignore_sticky'] ) ? (bool) $new_instance['ignore_sticky'] : 0;
		$instance['post_type']         = esc_attr( $new_instance['post_type'] );
		$instance['post_status']       = esc_attr( $new_instance['post_status'] );
		$instance['taxonomy']          = esc_attr( $new_instance['taxonomy'] );
		$instance['cat']               = $new_instance['cat'];
		$instance['tag']               = $new_instance['tag']; 

		$instance['thumbnail']         = isset( $new_instance['thumbnail'] ) ? (bool) $new_instance['thumbnail'] : false;
		$instance['thumbnail_size']    = esc_attr( $new_instance['thumbnail_size'] );
		$instance['thumbnail_align']   = esc_attr( $new_instance['thumbnail_align'] );
		$instance['thumbnail_custom']  = isset( $new_instance['thumbnail_custom'] ) ? (bool) $new_instance['thumbnail_custom'] : false;
		$instance['thumbnail_width']   = (int) $new_instance['thumbnail_width'];
		$instance['thumbnail_height']  = (int) $new_instance['thumbnail_height'];

		$instance['excerpt']           = isset( $new_instance['excerpt'] ) ? (bool) $new_instance['excerpt'] : false;
		$instance['excerpt_length']    = (int) $new_instance['excerpt_length'];
		$instance['date']              = isset( $new_instance['date'] ) ? (bool) $new_instance['date'] : false;
		$instance['date_relative']     = isset( $new_instance['date_relative'] ) ? (bool) $new_instance['date_relative'] : false;

		$instance['css']               = $new_instance['css'];
		$instance['css_class']         = sanitize_html_class( $new_instance['css_class'] );
		$instance['before']            = stripslashes( $new_instance['before'] );
		$instance['after']             = stripslashes( $new_instance['after'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since  0.0.1
	 */
	function form( $instance ) {

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, arpw_get_default_args() );

		// Extract the array to allow easy use of variables.
		extract( $instance );

		// Loads the widget form.
		include( ARPW_INC . 'form.php' );

	}

}