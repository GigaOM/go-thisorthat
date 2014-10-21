<?php

class GO_ThisOrThat
{
	private $sidebars;
	private $widgets;

	/**
	 * constructor!
	 */
	public function __construct()
	{
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
	}//end __construct

	/**
	 * Hooked to the widgets_init action to register widgets
	 */
	public function widgets_init()
	{
		require_once __DIR__ . '/class-go-thisorthat-widget.php';
		register_widget( 'GO_ThisOrThat_Widget' );
	}//end widgets_init

	/**
	 * returns the list of registered sidebars
	 */
	public function sidebars()
	{
		global $wp_registered_sidebars;

		if ( empty( $this->sidebars ) )
		{
			$this->sidebars = $wp_registered_sidebars;

			// sort the widget areas
			uasort( $this->sidebars, array( $this, 'sidebar_sort' ) );
		}//end if

		return $this->sidebars;
	}//end sidebars

	/**
	 * Returns registered widgets
	 */
	public function widgets()
	{
		global $wp_registered_widgets;

		if ( empty( $this->widgets ) )
		{
			$sidebars = $this->sidebars();

			$this->widgets = get_option( 'sidebars_widgets' );

			unset( $this->widgets['wp_inactive_widgets'] );

			foreach ( $this->widgets as $sidebar => $widgets )
			{
				if ( is_array( $widgets ) )
				{
					foreach ( $widgets as $key => $widget_id )
					{
						$widget = $wp_registered_widgets[ $widget_id ];

						if ( is_object( $widget['callback'][0] ) )
						{
							$settings = $widget['callback'][0]->get_settings();
							$widget['settings'] = isset( $settings[ $widget['params'][0]['number'] ] ) ? $settings[ $widget['params'][0]['number'] ] : array();
							$widget['instance'] = isset( $widget['params'][0]['number'] ) ? $widget['params'][0]['number'] : null;
							$widget['sidebar']  = isset( $sidebars[ $sidebar ]['name'] ) ? $sidebars[ $sidebar ]['name'] : null;
							unset( $widget['callback'] );
							unset( $widget['params'] );

							$widget['settings']['title'] = isset( $widget['settings']['title'] ) ? $widget['settings']['title'] : null;

							$widget['name'] = $widget['name'] . ( $widget['settings']['title'] ? ': ' . trim( $widget['settings']['title'] ) : '' );

							$this->widgets[ $sidebar ][ $widget_id ] = $widget;
							unset( $this->widgets[ $sidebar ][ $key ] );
						}// end if
					}//end foreach
				}// end if
			}//end foreach
		}//end if

		return $this->widgets;
	}//end widgets

	/**
	 * sorting logic for sidebars
	 */
	private function sidebar_sort( $a, $b )
	{
		if ( $a['name'] == $b['name'] )
		{
			return 0;
		}//end if

		return ( $a['name'] < $b['name'] ) ? -1 : 1;
	}//end sidebar_sort
}//end class

function go_thisorthat()
{
	global $go_thisorthat;

	if ( ! $go_thisorthat )
	{
		$go_thisorthat = new GO_ThisOrThat;
	}//end if

	return $go_thisorthat;
}//end go_thisorthat
