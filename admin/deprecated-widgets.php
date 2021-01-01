<?php
/**
 * deprecated widgets that are still able to be used, but will no longer be
 * updated with new features. Please use the 'Dispensary Products' shortcode.
 *
 * @link       https://www.wpdispensary.com
 * @since      4.0
 *
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP Dispensary Flowers Widget
 *
 * @since       1.0.0
 */
class wpdispensary_flowers_widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	 */
	public function __construct() {

		parent::__construct(
			'wpdispensary_flowers_widget',
			__( 'WPD Flowers', 'wp-dispensary' ),
			array(
				'description' => __( 'Your most recent Flowers', 'wp-dispensary' ),
				'classname'   => 'wp-dispensary-widget',
			)
		);

	}

	/**
	 * Widget definition
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::widget
	 * @param       array $args Arguments to pass to the widget.
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['id'] ) ) {
			$args['id'] = 'wpdispensary_flowers_widget';
		}

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		do_action( 'wpd_flowers_widget_before' );

		if ( 'on' !== $instance['featuredimage'] ) {
			echo "<ul class='wpdispensary-list'>";
		}

		if ( 'on' === $instance['order'] ) {
			$rand_order = 'rand';
		} else {
			$rand_order = '';
		}

		global $post;

		$wpdispensary_flowers_widget = new WP_Query(
			array(
				'post_type' => 'flowers',
				'showposts' => $instance['limit'],
				'orderby'   => $rand_order,
			)
		);

		while ( $wpdispensary_flowers_widget->have_posts() ) :

			do_action( 'wpd_flowers_widget_inside_loop_before' );

			$wpdispensary_flowers_widget->the_post();

			$do_not_duplicate = $post->ID;

			if ( 'on' === $instance['featuredimage'] ) {

				echo "<div class='wpdispensary-widget'>";

				do_action( 'wpd_flowers_widget_inside_top' );

				wpd_product_image( $post->ID, $instance['imagesize'] );

				if ( 'on' === $instance['flowername'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . esc_url( get_permalink( $post->ID ) ) . "'>" . get_the_title( $post->ID ) . "</a></span>";
				}
				if ( 'on' === $instance['flowercategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>" . get_the_term_list( $post->ID, 'flowers_category' ) . "</a></span>";
				}

				do_action( 'wpd_flowers_widget_inside_bottom' );

				echo '</div>';

			} else {

				echo '<li>';
				if ( 'on' === $instance['flowername'] ) {
					echo "<a href='" . esc_url( get_permalink( $post->ID ) ) . "' class='wpdispensary-widget-link'>" . get_the_title( $post->ID ) . "</a>";
				}
				echo '</li>';

			}

		do_action( 'wpd_flowers_widget_inside_loop_after' );

		endwhile; // End loop.

		wp_reset_postdata();

		if ( 'on' !== $instance['featuredimage'] ) {
			echo '</ul>';
		}

		do_action( 'wpd_flowers_widget_after' );

		echo $args['after_widget'];
	}


	/**
	 * Update widget options
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::update
	 * @param       array $new_instance The updated options.
	 * @param       array $old_instance The old options.
	 * @return      array $instance The updated instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']          = strip_tags( $new_instance['title'] );
		$instance['limit']          = strip_tags( $new_instance['limit'] );
		$instance['order']          = $new_instance['order'];
		$instance['featuredimage']  = $new_instance['featuredimage'];
		$instance['imagesize']      = $new_instance['imagesize'];
		$instance['flowername']     = $new_instance['flowername'];
		$instance['flowercategory'] = $new_instance['flowercategory'];

		return $instance;
	}


	/**
	 * Display widget form on dashboard
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::form
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'          => 'Flowers',
			'limit'          => '5',
			'order'          => '',
			'featuredimage'  => '',
			'imagesize'      => 'wpdispensary-widget',
			'flowername'     => 'on',
			'flowercategory' => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'wp-dispensary' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Amount of flowers to show:', 'wp-dispensary' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo esc_html( $instance['limit'] ); ?>" />
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['order'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Randomize output?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['flowername'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'flowername' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flowername' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'flowername' ) ); ?>"><?php esc_html_e( 'Display flower name?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['flowercategory'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'flowercategory' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flowercategory' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'flowercategory' ) ); ?>"><?php esc_html_e( 'Display flower category?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['featuredimage'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featuredimage' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php esc_html_e( 'Display featured image?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'imagesize' ) ); ?>"><?php esc_html_e( 'Image size:', 'wp-dispensary' ); ?></label>
		<?php
			$terms = apply_filters( 'wpd_widgets_featured_image_sizes', array( 'wpdispensary-widget', 'dispensary-image', 'wpd-small', 'wpd-medium', 'wpd-large' ) );
			if ( $terms ) {
				printf( '<select name="%s" id="' . esc_html( $this->get_field_id( 'imagesize' ) ) . '" name="' . esc_html( $this->get_field_name( 'imagesize' ) ) . '" class="widefat">', esc_attr( $this->get_field_name( 'imagesize' ) ) );
				foreach ( $terms as $term ) {
					if ( esc_html( $term ) != $instance['imagesize'] ) {
						$imagesizeinfo = '';
					} else {
						$imagesizeinfo = 'selected="selected"';
					}
					printf( '<option value="%s" ' . esc_html( $imagesizeinfo ) . '>%s</option>', esc_html( $term ), esc_html( $term ) );
				}
				print( '</select>' );
			}
		?>
	</p>

	<?php
	}
}

/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_flowers_register_widget() {
	register_widget( 'wpdispensary_flowers_widget' );
}
add_action( 'widgets_init', 'wpdispensary_flowers_register_widget' );

/**
 * WP Dispensary Conentrates Widget
 *
 * @since       1.0.0
 */
class wpdispensary_concentrates_widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	 */
	public function __construct() {

		parent::__construct(
			'wpdispensary_concentrates_widget',
			__( 'WPD Concentrates', 'wp-dispensary' ),
			array(
				'description' => __( 'Your most recent Concentrates', 'wp-dispensary' ),
				'classname'   => 'wp-dispensary-widget',
			)
		);

	}

	/**
	 * Widget definition
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::widget
	 * @param       array $args Arguments to pass to the widget.
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['id'] ) ) {
			$args['id'] = 'wpdispensary_concentrates_widget';
		}

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		do_action( 'wpd_concentrates_widget_before' );

		if ( 'on' !== $instance['featuredimage'] ) {
			echo "<ul class='wpdispensary-list'>";
		}

		if ( 'on' === $instance['order'] ) {
			$rand_order = 'rand';
		} else {
			$rand_order = '';
		}

		global $post;

		$wpdispensary_concentrates_widget = new WP_Query(
			array(
				'post_type' => 'concentrates',
				'showposts' => $instance['limit'],
				'orderby'   => $rand_order,
			)
		);

		while ( $wpdispensary_concentrates_widget->have_posts() ) :

			do_action( 'wpd_concentrates_widget_inside_loop_before' );

			$wpdispensary_concentrates_widget->the_post();

			$do_not_duplicate = $post->ID;

			if ( 'on' === $instance['featuredimage'] ) {

				echo "<div class='wpdispensary-widget'>";

				do_action( 'wpd_concentrates_widget_inside_top' );

				wpd_product_image( $post->ID, $instance['imagesize'] );

				if ( 'on' === $instance['concentratename'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . esc_url( get_permalink( $post->ID ) ) . "'>" . get_the_title( $post->ID ) . "</a></span>";
				}
				if ( 'on' === $instance['concentratecategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>" . get_the_term_list( $post->ID, 'concentrates_category' ) . "</a></span>";
				}

				do_action( 'wpd_concentrates_widget_inside_bottom' );

				echo '</div>';

			} else {

				echo '<li>';
				if ( 'on' === $instance['concentratename'] ) {
					echo "<a href='" . esc_url( get_permalink( $post->ID ) ) . "' class='wpdispensary-widget-link'>" . get_the_title( $post->ID ) . "</a>";
				}
				echo '</li>';

			}

		do_action( 'wpd_concentrates_widget_inside_loop_after' );

		endwhile; // End loop.

		wp_reset_postdata();

		if ( 'on' !== $instance['featuredimage'] ) {
			echo '</ul>';
		}

		do_action( 'wpd_concentrates_widget_after' );

		echo $args['after_widget'];
	}

	/**
	 * Update widget options
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::update
	 * @param       array $new_instance The updated options.
	 * @param       array $old_instance The old options.
	 * @return      array $instance The updated instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']               = strip_tags( $new_instance['title'] );
		$instance['limit']               = strip_tags( $new_instance['limit'] );
		$instance['order']               = $new_instance['order'];
		$instance['featuredimage']       = $new_instance['featuredimage'];
		$instance['imagesize']           = $new_instance['imagesize'];
		$instance['concentratename']     = $new_instance['concentratename'];
		$instance['concentratecategory'] = $new_instance['concentratecategory'];

		return $instance;
	}


	/**
	 * Display widget form on dashboard
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::form
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'               => 'Concentrates',
			'limit'               => '5',
			'order'               => '',
			'featuredimage'       => '',
			'imagesize'           => 'wpdispensary-widget',
			'concentratename'     => 'on',
			'concentratecategory' => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Amount of concentrates to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo esc_html( $instance['limit'] ); ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['order'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Randomize output?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['concentratename'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'concentratename' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'concentratename' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'concentratename' ) ); ?>"><?php esc_html_e( 'Display concentrate name?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['concentratecategory'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'concentratecategory' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'concentratecategory' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'concentratecategory' ) ); ?>"><?php esc_html_e( 'Display concentrate category?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['featuredimage'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featuredimage' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php esc_html_e( 'Display featured image?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'imagesize' ) ); ?>"><?php esc_html( 'Image size:', 'wp-dispensary' ); ?></label>
			<?php
				$terms = apply_filters( 'wpd_widgets_featured_image_sizes', array( 'wpdispensary-widget', 'dispensary-image', 'wpd-small', 'wpd-medium', 'wpd-large' ) );
				if ( $terms ) {
					printf( '<select name="%s" id="' . esc_html( $this->get_field_id( 'imagesize' ) ) . '" name="' . esc_html( $this->get_field_name( 'imagesize' ) ) . '" class="widefat">', esc_attr( $this->get_field_name( 'imagesize' ) ) );
					foreach ( $terms as $term ) {
						if ( esc_html( $term ) != $instance['imagesize'] ) {
							$imagesizeinfo = '';
						} else {
							$imagesizeinfo = 'selected="selected"';
						}
						printf( '<option value="%s" ' . esc_html( $imagesizeinfo ) . '>%s</option>', esc_html( $term ), esc_html( $term ) );
					}
					print( '</select>' );
				}
			?>
		</p>

	<?php
	}
}

/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_concentrates_register_widget() {
	register_widget( 'wpdispensary_concentrates_widget' );
}
add_action( 'widgets_init', 'wpdispensary_concentrates_register_widget' );

/**
 * WP Dispensary Edibles Widget
 *
 * @since       1.0.0
 */
class wpdispensary_edibles_widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	 */
	public function __construct() {

		parent::__construct(
			'wpdispensary_edibles_widget',
			__( 'WPD Edibles', 'wp-dispensary' ),
			array(
				'description' => __( 'Your most recent Edibles', 'wp-dispensary' ),
				'classname'   => 'wp-dispensary-widget',
			)
		);

	}

	/**
	 * Widget definition
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::widget
	 * @param       array $args Arguments to pass to the widget.
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['id'] ) ) {
			$args['id'] = 'wpdispensary_edibles_widget';
		}

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		do_action( 'wpd_edibles_widget_before' );

		if ( 'on' !== $instance['featuredimage'] ) {
			echo "<ul class='wpdispensary-list'>";
		}

		if ( 'on' === $instance['order'] ) {
			$rand_order = 'rand';
		} else {
			$rand_order = '';
		}

		global $post;

		$wpdispensary_edibles_widget = new WP_Query(
			array(
				'post_type' => 'edibles',
				'showposts' => $instance['limit'],
				'orderby'   => $rand_order,
			)
		);

		while ( $wpdispensary_edibles_widget->have_posts() ) :

			do_action( 'wpd_edibles_widget_inside_loop_before' );

			$wpdispensary_edibles_widget->the_post();

			$do_not_duplicate = $post->ID;

			if ( 'on' === $instance['featuredimage'] ) {

				echo "<div class='wpdispensary-widget'>";

				do_action( 'wpd_edibles_widget_inside_top' );

				wpd_product_image( $post->ID, $instance['imagesize'] );

				if ( 'on' === $instance['ediblename'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . esc_url( get_permalink( $post->ID ) ) . "'>" . get_the_title( $post->ID ) . "</a></span>";
				}
				if ( 'on' === $instance['ediblecategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>" . get_the_term_list( $post->ID, 'edibles_category' ) . "</a></span>";
				}

				do_action( 'wpd_edibles_widget_inside_bottom' );

				echo '</div>';

			} else {

				echo '<li>';
				if ( 'on' === $instance['ediblename'] ) {
					echo "<a href='" . esc_url( get_permalink( $post->ID ) ) . "' class='wpdispensary-widget-link'>" . get_the_title( $post->ID ) . "</a>";
				}
				echo '</li>';

			}

		do_action( 'wpd_edibles_widget_inside_loop_after' );

		endwhile; // End loop.

		wp_reset_postdata();

		if ( 'on' !== $instance['featuredimage'] ) {
			echo '</ul>';
		}

		do_action( 'wpd_edibles_widget_after' );

		echo $args['after_widget'];
	}


	/**
	 * Update widget options
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::update
	 * @param       array $new_instance The updated options.
	 * @param       array $old_instance The old options.
	 * @return      array $instance The updated instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']          = strip_tags( $new_instance['title'] );
		$instance['limit']          = strip_tags( $new_instance['limit'] );
		$instance['order']          = $new_instance['order'];
		$instance['featuredimage']  = $new_instance['featuredimage'];
		$instance['imagesize']      = $new_instance['imagesize'];
		$instance['ediblename']     = $new_instance['ediblename'];
		$instance['ediblecategory'] = $new_instance['ediblecategory'];

		return $instance;
	}


	/**
	 * Display widget form on dashboard
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::form
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'          => 'Edibles',
			'limit'          => '5',
			'order'          => '',
			'featuredimage'  => '',
			'imagesize'      => 'wpdispensary-widget',
			'ediblename'     => 'on',
			'ediblecategory' => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Amount of edibles to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo esc_html( $instance['limit'] ); ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['order'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Randomize output?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['ediblename'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'ediblename' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ediblename' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'ediblename' ) ); ?>"><?php esc_html_e( 'Display edible name?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['ediblecategory'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'ediblecategory' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ediblecategory' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'ediblecategory' ) ); ?>"><?php esc_html_e( 'Display edible category?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['featuredimage'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featuredimage' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php esc_html_e( 'Display featured image?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'imagesize' ) ); ?>"><?php esc_html_e( 'Image size:', 'wp-dispensary' ); ?></label>
			<?php
				$terms = apply_filters( 'wpd_widgets_featured_image_sizes', array( 'wpdispensary-widget', 'dispensary-image', 'wpd-small', 'wpd-medium', 'wpd-large' ) );
				if ( $terms ) {
					printf( '<select name="%s" id="' . esc_html( $this->get_field_id( 'imagesize' ) ) . '" name="' . esc_html( $this->get_field_name( 'imagesize' ) ) . '" class="widefat">', esc_attr( $this->get_field_name( 'imagesize' ) ) );
					foreach ( $terms as $term ) {
						if ( esc_html( $term ) != $instance['imagesize'] ) {
							$imagesizeinfo = '';
						} else {
							$imagesizeinfo = 'selected="selected"';
						}
						printf( '<option value="%s" ' . esc_html( $imagesizeinfo ) . '>%s</option>', esc_html( $term ), esc_html( $term ) );
					}
					print( '</select>' );
				}
			?>
		</p>

	<?php
	}
}


/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_edibles_register_widget() {
	register_widget( 'wpdispensary_edibles_widget' );
}
add_action( 'widgets_init', 'wpdispensary_edibles_register_widget' );

/**
 * WP Dispensary Pre-rolls Widget
 *
 * @since       1.0.0
 */
class wpdispensary_prerolls_widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.0.0
	 * @return      void
	 */
	public function __construct() {

		parent::__construct(
			'wpdispensary_prerolls_widget',
			__( 'WPD Pre-rolls', 'wp-dispensary' ),
			array(
				'description' => __( 'Your most recent Pre-rolls', 'wp-dispensary' ),
				'classname'   => 'wp-dispensary-widget',
			)
		);

	}

	/**
	 * Widget definition
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::widget
	 * @param       array $args Arguments to pass to the widget.
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['id'] ) ) {
			$args['id'] = 'wpdispensary_prerolls_widget';
		}

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		do_action( 'wpd_prerolls_widget_before' );

		if ( 'on' !== $instance['featuredimage'] ) {
			echo "<ul class='wpdispensary-list'>";
		}

		if ( 'on' === $instance['order'] ) {
			$rand_order = 'rand';
		} else {
			$rand_order = '';
		}

		global $post;

		$wpdispensary_edibles_widget = new WP_Query(
			array(
				'post_type' => 'prerolls',
				'showposts' => $instance['limit'],
				'orderby'   => $rand_order,
			)
		);

		while ( $wpdispensary_edibles_widget->have_posts() ) :

			do_action( 'wpd_prerolls_widget_inside_loop_before' );

			$wpdispensary_edibles_widget->the_post();

			$do_not_duplicate = $post->ID;

			if ( 'on' === $instance['featuredimage'] ) {

				echo "<div class='wpdispensary-widget'>";

				do_action( 'wpd_prerolls_widget_inside_top' );

				wpd_product_image( $post->ID, $instance['imagesize'] );

				if ( 'on' === $instance['prerollname'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . esc_url( get_permalink( $post->ID ) ) . "'>" . get_the_title( $post->ID ) . "</a></span>";
				}
				if ( 'on' === $instance['prerollflower'] ) {
					$prerollflower = get_post_meta( get_the_id(), '_selected_flowers', true );
					echo "<span class='wpdispensary-widget-categories'>";
					echo "<a href='" . esc_url( get_permalink( $prerollflower ) ) . "'>" . get_the_title( $prerollflower ) . "</a>";
					echo '</span>';
				}

				do_action( 'wpd_prerolls_widget_inside_bottom' );

				echo '</div>';

			} else {

				echo '<li>';
				if ( 'on' === $instance['prerollname'] ) {
					echo "<a href='" . esc_url( get_permalink( $post->ID ) ) . "' class='wpdispensary-widget-link'>" . get_the_title( $post->ID ) . "</a>";
				}
				echo '</li>';

			}

			do_action( 'wpd_prerolls_widget_inside_loop_after' );

		endwhile; // End loop.

		wp_reset_postdata();

		if ( 'on' !== $instance['featuredimage'] ) {
			echo '</ul>';
		}

		do_action( 'wpd_prerolls_widget_after' );

		echo $args['after_widget'];
	}


	/**
	 * Update widget options
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::update
	 * @param       array $new_instance The updated options.
	 * @param       array $old_instance The old options.
	 * @return      array $instance The updated instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['limit']           = strip_tags( $new_instance['limit'] );
		$instance['order']           = $new_instance['order'];
		$instance['featuredimage']   = $new_instance['featuredimage'];
		$instance['imagesize']       = $new_instance['imagesize'];
		$instance['prerollname']     = $new_instance['prerollname'];
		$instance['prerollcategory'] = $new_instance['prerollcategory'];
		$instance['prerollflower']   = $new_instance['prerollflower'];

		return $instance;
	}


	/**
	 * Display widget form on dashboard
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::form
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'           => 'Pre-rolls',
			'limit'           => '5',
			'order'           => '',
			'featuredimage'   => '',
			'imagesize'       => 'wpdispensary-widget',
			'prerollname'     => 'on',
			'prerollcategory' => '',
			'prerollflower'   => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Amount of pre-rolls to show:', 'wp-dispensary' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo esc_html( $instance['limit'] ); ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['order'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Randomize output?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['prerollname'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'prerollname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prerollname' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'prerollname' ) ); ?>"><?php esc_html_e( 'Display pre-roll name?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['prerollflower'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'prerollflower' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'prerollflower' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'prerollflower' ) ); ?>"><?php esc_html_e( 'Display pre-roll flower?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['featuredimage'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featuredimage' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php esc_html_e( 'Display featured image?', 'wp-dispensary' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'imagesize' ) ); ?>"><?php esc_html( 'Image size:', 'wp-dispensary' ); ?></label>
			<?php
				$terms = apply_filters( 'wpd_widgets_featured_image_sizes', array( 'wpdispensary-widget', 'dispensary-image', 'wpd-small', 'wpd-medium', 'wpd-large' ) );
				if ( $terms ) {
					printf( '<select name="%s" id="' . esc_html( $this->get_field_id( 'imagesize' ) ) . '" name="' . esc_html( $this->get_field_name( 'imagesize' ) ) . '" class="widefat">', esc_attr( $this->get_field_name( 'imagesize' ) ) );
					foreach ( $terms as $term ) {
						if ( esc_html( $term ) != $instance['imagesize'] ) {
							$imagesizeinfo = '';
						} else {
							$imagesizeinfo = 'selected="selected"';
						}
						printf( '<option value="%s" ' . esc_html( $imagesizeinfo ) . '>%s</option>', esc_html( $term ), esc_html( $term ) );
					}
					print( '</select>' );
				}
			?>
		</p>

	<?php
	}
}


/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_prerolls_register_widget() {
	register_widget( 'wpdispensary_prerolls_widget' );
}
add_action( 'widgets_init', 'wpdispensary_prerolls_register_widget' );

/**
 * WP Dispensary Topicals Widget
 *
 * @since       1.0.0
 */
class wpdispensary_topicals_widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.4.0
	 * @return      void
	 */
	public function __construct() {

		parent::__construct(
			'wpdispensary_topicals_widget',
			__( 'WPD Topicals', 'wp-dispensary' ),
			array(
				'description' => __( 'Your most recent Topicals', 'wp-dispensary' ),
				'classname'   => 'wp-dispensary-widget',
			)
		);

	}

	/**
	 * Widget definition
	 *
	 * @access      public
	 * @since       1.4.0
	 * @see         WP_Widget::widget
	 * @param       array $args Arguments to pass to the widget.
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['id'] ) ) {
			$args['id'] = 'wpdispensary_topicals_widget';
		}

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		do_action( 'wpd_topicals_widget_before' );

		if ( 'on' !== $instance['featuredimage'] ) {
			echo "<ul class='wpdispensary-list'>";
		}

		if ( 'on' === $instance['order'] ) {
			$rand_order = 'rand';
		} else {
			$rand_order = '';
		}

		$wpdispensary_topicals_widget = new WP_Query(
			array(
				'post_type' => 'topicals',
				'showposts' => $instance['limit'],
				'orderby'   => $rand_order,
			)
		);

		global $post;

		while ( $wpdispensary_topicals_widget->have_posts() ) :

			do_action( 'wpd_topicals_widget_inside_loop_before' );

			$wpdispensary_topicals_widget->the_post();

			$do_not_duplicate = $post->ID;

			if ( 'on' === $instance['featuredimage'] ) {

				echo "<div class='wpdispensary-widget'>";

				do_action( 'wpd_topicals_widget_inside_top' );

				wpd_product_image( $post->ID, $instance['imagesize'] );

				if ( 'on' === $instance['topicalname'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . esc_url( get_permalink( $post->ID ) ) . "'>" . get_the_title( $post->ID ) . "</a></span>";
				}
				if ( 'on' === $instance['topicalcategory'] ) {
					echo "<span class='wpdispensary-widget-categories'>" . get_the_term_list( $post->ID, 'topicals_category' ) . "</a></span>";
				}

				do_action( 'wpd_topicals_widget_inside_bottom' );

				echo '</div>';

			} else {

				echo '<li>';
				if ( 'on' === $instance['topicalname'] ) {
					echo "<a href='" . esc_url( get_permalink( $post->ID ) ) . "' class='wpdispensary-widget-link'>" . get_the_title( $post->ID ) . "</a>";
				}
				echo '</li>';

			}

			do_action( 'wpd_topicals_widget_inside_loop_after' );

		endwhile; // End loop.

		wp_reset_postdata();

		if ( 'on' !== $instance['featuredimage'] ) {
			echo '</ul>';
		}

		do_action( 'wpd_topicals_widget_after' );

		echo $args['after_widget'];
	}


	/**
	 * Update widget options
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::update
	 * @param       array $new_instance The updated options.
	 * @param       array $old_instance The old options.
	 * @return      array $instance The updated instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']           = strip_tags( $new_instance['title'] );
		$instance['limit']           = strip_tags( $new_instance['limit'] );
		$instance['order']           = $new_instance['order'];
		$instance['featuredimage']   = $new_instance['featuredimage'];
		$instance['imagesize']       = $new_instance['imagesize'];
		$instance['topicalname']     = $new_instance['topicalname'];
		$instance['topicalcategory'] = $new_instance['topicalcategory'];

		return $instance;
	}


	/**
	 * Display widget form on dashboard
	 *
	 * @access      public
	 * @since       1.0.0
	 * @see         WP_Widget::form
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'           => 'Topicals',
			'limit'           => '5',
			'order'           => '',
			'featuredimage'   => '',
			'imagesize'       => 'wpdispensary-widget',
			'topicalname'     => 'on',
			'topicalcategory' => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'wp-dispensary' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Amount of topicals to show:', 'wp-dispensary' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo esc_html( $instance['limit'] ); ?>" />
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['order'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Randomize output?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['topicalname'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'topicalname' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'topicalname' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'topicalname' ) ); ?>"><?php esc_html_e( 'Display topical name?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['topicalcategory'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'topicalcategory' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'topicalcategory' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'topicalcategory' ) ); ?>"><?php esc_html_e( 'Display topical category?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['featuredimage'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featuredimage' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php esc_html_e( 'Display featured image?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'imagesize' ) ); ?>"><?php esc_html( 'Image size:', 'wp-dispensary' ); ?></label>
		<?php
			$terms = apply_filters( 'wpd_widgets_featured_image_sizes', array( 'wpdispensary-widget', 'dispensary-image', 'wpd-small', 'wpd-medium', 'wpd-large' ) );
			if ( $terms ) {
				printf( '<select name="%s" id="' . esc_html( $this->get_field_id( 'imagesize' ) ) . '" name="' . esc_html( $this->get_field_name( 'imagesize' ) ) . '" class="widefat">', esc_attr( $this->get_field_name( 'imagesize' ) ) );
				foreach ( $terms as $term ) {
					if ( esc_html( $term ) != $instance['imagesize'] ) {
						$imagesizeinfo = '';
					} else {
						$imagesizeinfo = 'selected="selected"';
					}
					printf( '<option value="%s" ' . esc_html( $imagesizeinfo ) . '>%s</option>', esc_html( $term ), esc_html( $term ) );
				}
				print( '</select>' );
			}
		?>
	</p>

	<?php
	}
}

/**
 * Register the new widget
 *
 * @since       1.0.0
 * @return      void
 */
function wpdispensary_topicals_register_widget() {
	register_widget( 'wpdispensary_topicals_widget' );
}
add_action( 'widgets_init', 'wpdispensary_topicals_register_widget' );

/**
 * WP Dispensary Growers Widget
 *
 * @since       1.7.0
 */
class wpdispensary_growers_widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @access      public
	 * @since       1.7.0
	 * @return      void
	 */
	public function __construct() {

		parent::__construct(
			'wpdispensary_growers_widget',
			__( 'WPD Growers', 'wp-dispensary' ),
			array(
				'description' => __( 'Your most recent Clones and Seeds', 'wp-dispensary' ),
				'classname'   => 'wp-dispensary-widget',
			)
		);

	}

	/**
	 * Widget definition
	 *
	 * @access      public
	 * @since       1.7.0
	 * @see         WP_Widget::widget
	 * @param       array $args Arguments to pass to the widget.
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['id'] ) ) {
			$args['id'] = 'wpdispensary_growers_widget';
		}

		$title = apply_filters( 'widget_title', $instance['title'], $instance, $args['id'] );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		do_action( 'wpd_growers_widget_before' );

		if ( 'on' !== $instance['featuredimage'] ) {
			echo "<ul class='wpdispensary-list'>";
		}

		if ( 'on' === $instance['order'] ) {
			$rand_order = 'rand';
		} else {
			$rand_order = '';
		}

		global $post;

		$wpdispensary_edibles_widget = new WP_Query(
			array(
				'post_type' => 'growers',
				'showposts' => $instance['limit'],
				'orderby'   => $rand_order,
			)
		);

		while ( $wpdispensary_edibles_widget->have_posts() ) :

			do_action( 'wpd_growers_widget_inside_loop_before' );

			$wpdispensary_edibles_widget->the_post();

			$do_not_duplicate = $post->ID;

			if ( 'on' === $instance['featuredimage'] ) {

				echo "<div class='wpdispensary-widget'>";

				do_action( 'wpd_growers_widget_inside_top' );

				wpd_product_image( $post->ID, $instance['imagesize'] );

				if ( 'on' === $instance['growername'] ) {
					echo "<span class='wpdispensary-widget-title'><a href='" . esc_url( get_permalink( $post->ID ) ) . "'>" . get_the_title( $post->ID ) . "</a></span>";
				}

				if ( 'on' === $instance['growerflower'] ) {
					$growerflower = get_post_meta( get_the_id(), '_selected_flowers', true );
					echo "<span class='wpdispensary-widget-categories'>";
					echo "<a href='" . esc_url( get_permalink( $growerflower ) ) . "'>" . get_the_title( $growerflower ) . "</a>";
					echo '</span>';
				}

				do_action( 'wpd_growers_widget_inside_bottom' );

				echo '</div>';

			} else {

				echo '<li>';
				if ( 'on' === $instance['growername'] ) {
					echo "<a href='" . esc_url( get_permalink( $post->ID ) ) . "' class='wpdispensary-widget-link'>" . get_the_title( $post->ID ) . "</a>";
				}
				echo '</li>';

			}

			do_action( 'wpd_growers_widget_inside_loop_after' );

		endwhile; // End loop.

		wp_reset_postdata();

		if ( 'on' !== $instance['featuredimage'] ) {
			echo '</ul>';
		}

		do_action( 'wpd_growers_widget_after' );

		echo $args['after_widget'];
	}


	/**
	 * Update widget options
	 *
	 * @access      public
	 * @since       1.7.0
	 * @see         WP_Widget::update
	 * @param       array $new_instance The updated options.
	 * @param       array $old_instance The old options.
	 * @return      array $instance The updated instance options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']          = strip_tags( $new_instance['title'] );
		$instance['limit']          = strip_tags( $new_instance['limit'] );
		$instance['order']          = $new_instance['order'];
		$instance['featuredimage']  = $new_instance['featuredimage'];
		$instance['imagesize']      = $new_instance['imagesize'];
		$instance['growername']     = $new_instance['growername'];
		$instance['growercategory'] = $new_instance['growercategory'];
		$instance['growerflower']   = $new_instance['growerflower'];

		return $instance;
	}


	/**
	 * Display widget form on dashboard
	 *
	 * @access      public
	 * @since       1.7.0
	 * @see         WP_Widget::form
	 * @param       array $instance A given widget instance.
	 * @return      void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'          => 'Growers',
			'limit'          => '5',
			'order'          => '',
			'featuredimage'  => '',
			'imagesize'      => 'wpdispensary-widget',
			'growername'     => 'on',
			'growercategory' => '',
			'growerflower'   => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title:', 'wp-dispensary' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Amount of growers to show:', 'wp-dispensary' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" type="number" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" min="1" max="999" value="<?php echo esc_html( $instance['limit'] ); ?>" />
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['order'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Randomize output?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['growername'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'growername' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'growername' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'growername' ) ); ?>"><?php esc_html_e( 'Display grower name?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['growerflower'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'growerflower' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'growerflower' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'growerflower' ) ); ?>"><?php esc_html_e( 'Display flower type?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $instance['featuredimage'], 'on' ); ?> id="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featuredimage' ) ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id( 'featuredimage' ) ); ?>"><?php esc_html_e( 'Display featured image?', 'wp-dispensary' ); ?></label>
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'imagesize' ) ); ?>"><?php esc_html( 'Image size:', 'wp-dispensary' ); ?></label>
		<?php
			$terms = array( 'wpdispensary-widget', 'dispensary-image', 'wpd-small', 'wpd-medium', 'wpd-large' );
			if ( $terms ) {
				printf( '<select name="%s" id="' . esc_html( $this->get_field_id( 'imagesize' ) ) . '" name="' . esc_html( $this->get_field_name( 'imagesize' ) ) . '" class="widefat">', esc_attr( $this->get_field_name( 'imagesize' ) ) );
				foreach ( $terms as $term ) {
					if ( esc_html( $term ) != $instance['imagesize'] ) {
						$imagesizeinfo = '';
					} else {
						$imagesizeinfo = 'selected="selected"';
					}
					printf( '<option value="%s" ' . esc_html( $imagesizeinfo ) . '>%s</option>', esc_html( $term ), esc_html( $term ) );
				}
				print( '</select>' );
			}
		?>
	</p>

	<?php
	}
}

/**
 * Register the new widget
 *
 * @since       1.7.0
 * @return      void
 */
function wpdispensary_growers_register_widget() {
	register_widget( 'wpdispensary_growers_widget' );
}
add_action( 'widgets_init', 'wpdispensary_growers_register_widget' );
