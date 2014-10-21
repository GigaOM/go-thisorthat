<?php

class GO_ThisOrThat_Widget extends WP_Widget
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname'   => 'go-thisorthat-widget',
			'description' => 'Displays the contents of another widget. If that content is blank, displays a different widget.',
		);

		parent::__construct( 'go-thisorthat', 'GO This-or-That', $widget_ops );
	}//end __construct

	/**
	 * outputs the content of the widget
	 *
	 * @param array $args Widget arguments
	 * @param array $unused_instance Current instantiation settings
	 */
	public function widget( $args, $instance )
	{
		if ( empty( $instance['this'] ) || empty( $instance['that'] ) )
		{
			return;
		}//end if

		if ( ! trim( $widget_contents = $this->get_widget_contents( $instance['this'] ) ) )
		{
			$widget_contents = $this->get_widget_contents( $instance['that'] );
		}//end if

		echo $args['before_widget'];
		// widget_contents is escaped in the output of the widgets that are being fetched.
		echo $widget_contents;
		echo $args['after_widget'];
	}//end widget

	/**
	 * gets the output of a widget given an widget ID
	 */
	private function get_widget_contents( $widget_instance_id )
	{
		global $wp_registered_widgets;

		if ( empty( $wp_registered_widgets[ $widget_instance_id ] ) )
		{
			return;
		}//end if

		preg_match( '/(.*)-([0-9]+)$/', $widget_instance_id, $matches );

		$widget_contents = NULL;
		$widget_id = $matches[1];
		$widget_num = $matches[2];

		$registered_widget = $wp_registered_widgets[ $widget_instance_id ];
		$callback = $registered_widget['callback'][0];
		$widget_options = get_option( "widget_{$widget_id}" );

		if ( isset( $widget_options[ $widget_num ] ) )
		{
			ob_start();

			the_widget( get_class( $callback ), $widget_options[ $widget_num ] );

			$widget_contents = ob_get_clean();
		}//end if

		return $widget_contents;
	}//end get_widget_contents

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance )
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$widgets = go_thisorthat()->widgets();

		include __DIR__ . '/templates/form.php';
	}//end form

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = array();

		$instance['title'] = preg_replace( '/[^a-z0-9A-Z\-_ ]/', '', trim( $new_instance['title'] ) );
		$instance['this'] = preg_replace( '/[^a-z0-9A-Z\-_]/', '', $new_instance['this'] );
		$instance['that'] = preg_replace( '/[^a-z0-9A-Z\-_]/', '', $new_instance['that'] );

		return $instance;
	}//end update
}//end class
