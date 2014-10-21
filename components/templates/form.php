<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title:</label>
	<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
</p>
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'this' ) ); ?>">If no content provided from:</label>
	<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'this' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'this' ) ); ?>">
		<option>Select a widget</option>
		<?php $this->widget_option_list( $widgets, $instance['this'] ); ?>
	</select>
</p>
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'that' ) ); ?>">Then show content from:</label>
	<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'that' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'that' ) ); ?>">
		<option>Select a widget</option>
		<?php $this->widget_option_list( $widgets, $instance['that'] ); ?>
	</select>
</p>
