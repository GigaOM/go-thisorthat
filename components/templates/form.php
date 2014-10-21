<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
</p>
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'this' ) ); ?>">If no content provided from:</label>
	<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'this' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'this' ) ); ?>">
		<option>Select a widget</option>
		<?php
			$current_sidebar = NULL;
			$has_opt_group   = FALSE;
			foreach ( $widgets as $sidebar )
			{
				if ( ! is_array( $sidebar ) )
				{
					continue;
				}//end if

				foreach ( $sidebar as $widget )
				{
					if ( $current_sidebar != $widget['sidebar'] )
					{
						$has_opt_group = TRUE;
						?>
						<optgroup label="<?php echo $widget['sidebar']; ?>">
						<?php
						$current_sidebar = $widget['sidebar'];
					}//end if

					$widget_id = $$id;
					?>
					<option value="<?php echo $widget['id']; ?>" <?php selected( $widget['id'], $instance['this'] ); ?>><?php echo $widget['name']; ?></option>
					<?php
				}//end foreach
			}//end foreach

			if ( $has_opt_group )
			{
				?></optgroup><?php
			}//end if
		?>
	</select>
</p>
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'that' ) ); ?>">Then show content from:</label>
	<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'that' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'that' ) ); ?>">
		<option>Select a widget</option>
		<?php
			$current_sidebar = NULL;
			$has_opt_group   = FALSE;
			foreach ( $widgets as $sidebar )
			{
				if ( ! is_array( $sidebar ) )
				{
					continue;
				}//end if

				foreach ( $sidebar as $widget )
				{
					if ( $current_sidebar != $widget['sidebar'] )
					{
						$has_opt_group = TRUE;
						?>
						<optgroup label="<?php echo $widget['sidebar']; ?>">
						<?php
						$current_sidebar = $widget['sidebar'];
					}//end if
					?>
					<option value="<?php echo $widget['id']; ?>" <?php selected( $widget['id'], $instance['that'] ); ?>><?php echo $widget['name']; ?></option>
					<?php
				}//end foreach
			}//end foreach

			if ( $has_opt_group )
			{
				?></optgroup><?php
			}//end if
		?>
	</select>
</p>
