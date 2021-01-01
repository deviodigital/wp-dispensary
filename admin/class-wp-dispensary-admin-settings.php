<?php
/**
 * Main Class file for `WPD_ADMIN_SETTINGS`
 *
 * Main class that deals with all other classes.
 *
 * @since      2.0
 * @package    WP_Dispensary
 * @subpackage WP_Dispensary/admin
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPD_ADMIN_SETTINGS.
 *
 * WP Settings API Class.
 *
 * @since 2.0
 */
if ( ! class_exists( 'WPD_ADMIN_SETTINGS' ) ) :
	class WPD_ADMIN_SETTINGS {
		/**
		 * Sections array.
		 *
		 * @var   array
		 * @since 2.0
		 */
		private $sections_array = array();
		/**
		 * Fields array.
		 *
		 * @var   array
		 * @since 2.0
		 */
		private $fields_array = array();
		/**
		 * Constructor.
		 *
		 * @since  2.0
		 */
		public function __construct() {
			// Enqueue the admin scripts.
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			// Hook it up.
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			// Menu.
			add_action( 'admin_menu', array( $this, 'wpd_admin_menu' ) );
		}
		/**
		 * Admin Scripts.
		 *
		 * @since 2.0
		 */
		public function admin_scripts() {

			// jQuery is needed.
			wp_enqueue_script( 'jquery' );

			// Color Picker.
			wp_enqueue_script(
				'iris',
				admin_url( 'js/iris.min.js' ),
				array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
				false,
				1
			);

			// Media Uploader.
			wp_enqueue_media();

		}
		/**
		 * Set Sections.
		 *
		 * @param array $sections
		 * @since 2.0
		 */
		public function set_sections( $sections ) {
			// Bail if not array.
			if ( ! is_array( $sections ) ) {
				return false;
			}
			// Assign to the sections array.
			$this->sections_array = $sections;
			return $this;
		}
		/**
		 * Add a single section.
		 *
		 * @param array $section
		 * @since 2.0
		 */
		public function add_section( $section ) {
			// Bail if not array.
			if ( ! is_array( $section ) ) {
				return false;
			}
			// Assign the section to sections array.
			$this->sections_array[] = $section;
			return $this;
		}
		/**
		 * Set Fields.
		 *
		 * @since 2.0
		 */
		public function set_fields( $fields ) {
			// Bail if not array.
			if ( ! is_array( $fields ) ) {
				return false;
			}
			// Assign the fields.
			$this->fields_array = $fields;
			return $this;
		}
		/**
		 * Add submenu page to the Settings main menu.
		 *
		 * @param string   $page_title
		 * @param string   $menu_title
		 * @param string   $capability
		 * @param string   $menu_slug
		 * @param callable $function = ''.
		 * @author WP Dispensary
		 * @since  2.0
		 */
		public function wpd_admin_menu() {
			// Add menu page.
			add_menu_page(
				'WP Dispensary', /** Paramater: page_title */
				'WP Dispensary', /** Paramater: menu_title */
				'manage_options', /** Paramater: capability */
				'wpd-settings', /** Paramater: menu_slug */
				array( $this, 'wp_dispensary_create_admin_page' ), /** Paramater: function */
				'none', /** Paramater: icon_url */
				3 /** Paramater: position */
			);
			add_submenu_page( 'wpd-settings', 'WP Dispensary Settings', 'Settings', 'manage_options', 'wpd-settings' );
		}
		public function wp_dispensary_create_admin_page() {
			$url = plugins_url();
			echo '<div class="wrap wpd-settings-wrap">';
			echo '<h1 class="wpd-settings-logo"><img src="' . esc_url( $url ) . '/wp-dispensary/admin/images/wpd-logo.png" /> <span class="wpd-settings-version">v' . WPD_ADMIN_SETTINGS_VERSION . '</span></h1>';
			$this->show_navigation();
			$this->show_forms();
			echo '</div>';
		}
		/**
		 * Show navigations as tab
		 *
		 * Shows all the settings section labels as tab
		 */
		function show_navigation() {
			$html = '<h2 class="nav-tab-wrapper">';
			foreach ( $this->sections_array as $tab ) {
				$html .= sprintf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
			}
			$html .= '</h2>';
			echo $html;
		}
		/**
		 * Show the section settings forms
		 *
		 * This function displays every sections in a different form
		 */
		function show_forms() {
			?>
				<div class="metabox-holder">
					<?php foreach ( $this->sections_array as $form ) { ?>
					<div id="<?php echo $form['id']; ?>" class="group" >
						<form method="post" action="options.php">
						<?php
						do_action( 'wpd_settings_form_top_' . $form['id'], $form );
						settings_fields( $form['id'] );
						do_settings_sections( $form['id'] );
						do_action( 'wpd_settings_form_bottom_' . $form['id'], $form );
						?>
						<div style="padding-left: 10px">
						<?php submit_button(); ?>
						</div>
						</form>
					</div>
					<?php } ?>
				</div>
			<?php
			$this->script();
		}

		/**
		 * Tabbable JavaScript codes & Initiate Color Picker
		 *
		 * This code uses localstorage for displaying active tabs
		 */
		function script() {
			?>
			<script>
				jQuery(document).ready(function($) {
					//Initiate Color Picker
					$('.color-picker').iris({
						width: 240,
						target: false,
						palettes: ['#125', '#459', '#78b', '#ab0', '#de3', '#f0f'],
						change: function(event, ui) {
							// change the headline color
							$(".wpds-color-picker-display").css( 'background-color', ui.color.toString());
						}
					});

					// Switches option sections
					$('.group').hide();
					var activetab = '';

					// Tab activetab.
					if (typeof(localStorage) != 'undefined' ) {
						activetab = localStorage.getItem("activetab");
					}

					// Tab fadeIn.
					if (activetab != '' && $(activetab).length ) {
						$(activetab).fadeIn();
					} else {
						$('.group:first').fadeIn();
					}

					$('.group .collapsed').each(function(){
						$(this).find('input:checked').parent().parent().parent().nextAll().each(
						function(){
							if ($(this).hasClass('last')) {
								$(this).removeClass('hidden');
								return false;
							}
							$(this).filter('.hidden').removeClass('hidden');
						});
					});

					// Nav tabs.
					if (activetab != '' && $(activetab + '-tab').length ) {
						$(activetab + '-tab').addClass('nav-tab-active');
					}
					else {
						$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
					}

					$('.nav-tab-wrapper a').click(function(evt) {
					$('.nav-tab-wrapper a').removeClass('nav-tab-active');
					$(this).addClass('nav-tab-active').blur();
					var clicked_group = $(this).attr('href');
					if (typeof(localStorage) != 'undefined' ) {
						localStorage.setItem("activetab", $(this).attr('href'));
					}
					$('.group').hide();
					$(clicked_group).fadeIn();
					evt.preventDefault();
					});

					$('.wpds-browse').on('click', function (event) {
					event.preventDefault();
					var self = $(this);
					// Create the media frame.
					var file_frame = wp.media.frames.file_frame = wp.media({
						title: self.data('uploader_title'),
						button: {
							text: self.data('uploader_button_text'),
						},
						multiple: false
					});
					file_frame.on('select', function () {
						attachment = file_frame.state().get('selection').first().toJSON();
						self.prev('.wpds-url').val(attachment.url).change();
					});
					// Finally, open the modal
					file_frame.open();
					});
					$('input.wpds-url').on( 'change keyup paste input', (function() {
					var self = $(this);
					self.next().parent().children( '.wpds-image-preview' ).children( 'img' ).attr( 'src', self.val() );
					})).change();

					$(".color-picker").after("<div class='wpds-color-picker-display'></div>");
				});
			</script>

			<style type="text/css">
			/** WordPress 3.8 Fix **/
			.form-table th { padding: 20px 10px; }
			#wpbody-content .metabox-holder { padding-top: 5px; }
			.wpds-image-preview img { height: auto; max-width: 70px; }
			@media screen and (max-width: 782px) {
				.form-table td input[type=text].color-picker {
					width: 100px;
					display: inline-block;
				}
			}
			</style>
				<?php
		}
		/**
		 * Add a single field.
		 *
		 * @since 2.0
		 */
		public function add_field( $section, $field_array ) {
			// Set the defaults.
			$defaults = array(
				'id'          => '',
				'name'        => '',
				'desc'        => '',
				'type'        => 'text',
				'placeholder' => '',
			);
			// Combine the defaults with user's arguements.
			$arg = wp_parse_args( $field_array, $defaults );
			// Each field is an array named against its section.
			$this->fields_array[ $section ][] = $arg;
			return $this;
		}
		/**
		 * Initialize API.
		 *
		 * Initializes and registers the settings sections and fields.
		 * Usually this should be called at `admin_init` hook.
		 *
		 * @since  2.0
		 */
		function admin_init() {
			/**
			* Register the sections.
			*
			* @since 2.0
			*/
			foreach ( $this->sections_array as $section ) {
				if ( false == get_option( $section['id'] ) ) {
					// Add a new field as section ID.
					add_option( $section['id'] );
				}
				// Deals with sections description.
				if ( isset( $section['desc'] ) && ! empty( $section['desc'] ) ) {
					// Build HTML.
					$section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
					// Create the callback for description.
					$callback = function() use ( $section ) {
						echo str_replace( '"', '\"', $section['desc'] );
					};
				} elseif ( isset( $section['callback'] ) ) {
					$callback = $section['callback'];
				} else {
					$callback = null;
				}
				/**
				 * Add a new section to a settings page.
				 *
				 * @param string   $id
				 * @param string   $title
				 * @param callable $callback
				 * @param string   $page     | Page is same as section ID.
				 * @since 2.0
				 */
				add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
			} // foreach ended.

			/**
			 * Register settings fields.
			 *
			 * @since 2.0
			 */
			foreach ( $this->fields_array as $section => $field_array ) {
				foreach ( $field_array as $field ) {
						$id                = isset( $field['id'] ) ? $field['id'] : false;
						$type              = isset( $field['type'] ) ? $field['type'] : 'text';
						$name              = isset( $field['name'] ) ? $field['name'] : 'No Name Added';
						$label_for         = "{$section}[{$field['id']}]";
						$description       = isset( $field['desc'] ) ? $field['desc'] : '';
						$size              = isset( $field['size'] ) ? $field['size'] : null;
						$options           = isset( $field['options'] ) ? $field['options'] : '';
						$default           = isset( $field['default'] ) ? $field['default'] : '';
						$placeholder       = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
						$sanitize_callback = isset( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : '';
						$args = array(
							'id'                => $id,
							'type'              => $type,
							'name'              => $name,
							'label_for'         => $label_for,
							'desc'              => $description,
							'section'           => $section,
							'size'              => $size,
							'options'           => $options,
							'std'               => $default,
							'placeholder'       => $placeholder,
							'sanitize_callback' => $sanitize_callback
						);
						/**
						 * Add a new field to a section of a settings page.
						 *
						 * @param string 	$id
						 * @param string 	$title
						 * @param callable 	$callback
						 * @param string 	$page
						 * @param string 	$section = 'default'
						 * @param array 	$args = array()
						 * @since 2.0
						 */
						// @param string 	$id
						$field_id = $section . '[' . $field['id'] . ']';
						add_settings_field(
							$field_id,
							$name,
							array( $this, 'callback_' . $type ),
							$section,
							$section,
							$args
						);
				} // foreach ended.
			} // foreach ended.

			// Creates our settings in the fields table.
			foreach ( $this->sections_array as $section ) {
				/**
				* Registers a setting and its sanitization callback.
				*
				* @param string 	$field_group 	| A settings group name.
				* @param string 	$field_name 	| The name of an option to sanitize and save.
				* @param callable $sanitize_callback = ''.
				* @since 2.0
				*/
				register_setting( $section['id'], $section['id'], array( $this, 'sanitize_fields' ) );
			} // foreach ended.
		} // admin_init() ended.

		/**
		 * Sanitize callback for Settings API fields.
		 *
		 * @since 2.0
		 */
		public function sanitize_fields( $fields ) {
			foreach( $fields as $field_slug => $field_value ) {
				$sanitize_callback = $this->get_sanitize_callback( $field_slug );
				// If callback is set, call it.
				if ( $sanitize_callback ) {
					$fields[ $field_slug ] = call_user_func( $sanitize_callback, $field_value );
					continue;
				}
			}
			return $fields;
		}

		/**
		 * Get sanitization callback for given option slug
		 *
		 * @param string $slug option slug
		 * @return mixed string | bool 	false
		 * @since  2.0
		 */
		function get_sanitize_callback( $slug = '' ) {
			if ( empty( $slug ) ) {
				return false;
			}
			// Iterate over registered fields and see if we can find proper callback.
			foreach( $this->fields_array as $section => $field_array ) {
				foreach ( $field_array as $field ) {
					if ( $field['name'] != $slug ) {
						continue;
					}
					// Return the callback name.
					return isset( $field['sanitize_callback'] ) && is_callable( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : false;
				}
			}
			return false;
		}

		/**
		 * Get field description for display
		 *
		 * @param array $args settings field args.
		 */
		public function get_field_description( $args ) {
			if ( ! empty( $args['desc'] ) ) {
				$desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
			} else {
				$desc = '';
			}
			return $desc;
		}

		/**
		 * Displays a separator field for a settings field
		 *
		 * Can use <hr /> for the name, and it displays a clean line to separate sections on each page.
		 *
		 * @param array $args settings field args.
		 */
		function callback_separator( $args ) {
			$type  = isset( $args['type'] ) ? $args['type'] : 'separator';
			$html  = '';
			$html .= '<div class="wpd-settings-separator"></div>';
			echo $html;
		}

		/**
		 * Displays a title field for a settings field
		 *
		 * @param array $args settings field args.
		 */
		function callback_title( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			if ( '' !== $args['name'] ) {
				$name = $args['name'];
			} else {

			};
			$type = isset( $args['type'] ) ? $args['type'] : 'title';
		}

		/**
		 * Displays a text field for a settings field
		 *
		 * @param array $args settings field args
		 */
		function callback_text( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['placeholder'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$type  = isset( $args['type'] ) ? $args['type'] : 'text';
			$html  = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s" placeholder="%6$s"/>', $type, $size, $args['section'], $args['id'], $value, $args['placeholder'] );
			$html .= $this->get_field_description( $args );
			echo $html;
		}
		/**
		 * Displays a url field for a settings field
		 *
		 * @param array   $args settings field args
		 */
		function callback_url( $args ) {
			$this->callback_text( $args );
		}
		/**
		 * Displays a number field for a settings field
		 *
		 * @param array $args settings field args.
		 */
		function callback_number( $args ) {
			$this->callback_text( $args );
		}
		/**
		 * Displays a checkbox for a settings field
		 *
		 * @param array   $args settings field args
		 */
		function callback_checkbox( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$html  = '<fieldset>';
			$html .= sprintf( '<label for="wpd-settings-%1$s[%2$s]">', $args['section'], $args['id'] );
			$html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
			$html .= sprintf( '<input type="checkbox" class="checkbox" id="wpd-settings-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
			$html .= sprintf( '%1$s</label>', $args['desc'] );
			$html .= '</fieldset>';
			echo $html;
		}
		/**
		 * Displays a multicheckbox a settings field
		 *
		 * @param array   $args settings field args
		 */
		function callback_multicheck( $args ) {
			$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
			$html  = '<fieldset>';
			foreach ( $args['options'] as $key => $label ) {
				$checked = isset( $value[$key] ) ? $value[$key] : '0';
				$html   .= sprintf( '<label for="wpd-settings-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
				$html   .= sprintf( '<input type="checkbox" class="checkbox" id="wpd-settings-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
				$html   .= sprintf( '%1$s</label><br>', $label );
			}
			$html .= $this->get_field_description( $args );
			$html .= '</fieldset>';
			echo $html;
		}
		/**
		 * Displays a multicheckbox a settings field
		 *
		 * @param array   $args settings field args
		 */
		function callback_radio( $args ) {
			$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
			$html  = '<fieldset>';
			foreach ( $args['options'] as $key => $label ) {
				$html .= sprintf( '<label for="wpd-settings-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
				$html .= sprintf( '<input type="radio" class="radio" id="wpd-settings-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
				$html .= sprintf( '%1$s</label><br>', $label );
			}
			$html .= $this->get_field_description( $args );
			$html .= '</fieldset>';
			echo $html;
		}
		/**
		 * Displays a selectbox for a settings field
		 *
		 * @param array   $args settings field args
		 */
		function callback_select( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$html  = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );
			foreach ( $args['options'] as $key => $label ) {
				$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
			}
			$html .= sprintf( '</select>' );
			$html .= $this->get_field_description( $args );
			echo $html;
		}
		/**
		 * Displays a textarea for a settings field
		 *
		 * @param array $args settings field args.
		 */
		function callback_textarea( $args ) {
			$value = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$html  = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]">%4$s</textarea>', $size, $args['section'], $args['id'], $value );
			$html .= $this->get_field_description( $args );
			echo $html;
		}
		/**
		 * Displays a textarea for a settings field
		 *
		 * @param array $args settings field args.
		 * @return string
		 */
		function callback_html( $args ) {
			echo $this->get_field_description( $args );
		}
		/**
		 * Displays a rich text textarea for a settings field
		 *
		 * @param array $args settings field args.
		 */
		function callback_wysiwyg( $args ) {
			$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : '500px';
			echo '<div style="max-width: ' . $size . ';">';
			$editor_settings = array(
				'teeny'         => true,
				'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
				'textarea_rows' => 10,
			);
			if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
				$editor_settings = array_merge( $editor_settings, $args['options'] );
			}
			wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );
			echo '</div>';
			echo $this->get_field_description( $args );
		}
		/**
		 * Displays a file upload field for a settings field
		 *
		 * @param array $args settings field args.
		 */
		function callback_file( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$id    = $args['section'] . '[' . $args['id'] . ']';
			$label = isset( $args['options']['button_label'] ) ?
			$args['options']['button_label'] :
			__( 'Choose File' );
			$html  = sprintf( '<input type="text" class="%1$s-text wpds-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
			$html .= '<input type="button" class="button wpds-browse" value="' . $label . '" />';
			$html .= $this->get_field_description( $args );
			echo $html;
		}
		/**
		 * Displays an image upload field with a preview
		 *
		 * @param array $args settings field args.
		 */
		function callback_image( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$id    = $args['section'] . '[' . $args['id'] . ']';
			$label = isset( $args['options']['button_label'] ) ?
			$args['options']['button_label'] :
			__( 'Choose Image' );
			$html  = sprintf( '<input type="text" class="%1$s-text wpds-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
			$html .= '<input type="button" class="button wpds-browse" value="' . $label . '" />';
			$html .= $this->get_field_description( $args );
			$html .= '<p class="wpds-image-preview"><img src=""/></p>';
			echo $html;
		}
		/**
		 * Displays a password field for a settings field
		 *
		 * @param array $args settings field args.
		 */
		function callback_password( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$html  = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
			$html .= $this->get_field_description( $args );
			echo $html;
		}
		/**
		 * Displays a color picker field for a settings field
		 *
		 * @param array $args settings field args.
		 */
		function callback_color( $args ) {
			$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['placeholder'] ) );
			$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
			$html  = sprintf( '<input type="text" class="%1$s-text color-picker" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" placeholder="%6$s" />', $size, $args['section'], $args['id'], $value, $args['std'], $args['placeholder'] );
			$html .= $this->get_field_description( $args );
			echo $html;
		}
		/**
		 * Get the value of a settings field
		 *
		 * @param string $option  settings field name.
		 * @param string $section the section name this field belongs to.
		 * @param string $default default text if it's not found.
		 * @return string
		 */
		function get_option( $option, $section, $default = '' ) {
			$options = get_option( $section );
			if ( isset( $options[$option] ) ) {
				return $options[$option];
			}
			return $default;
		}

	} // WPD_ADMIN_SETTINGS ended.
endif;

// Adds Products admin submenu link.
function wpd_admin_menu_products(  ) {
	// Get permalink base for Products.
	$wpd_products_slug = get_option( 'wpd_products_slug' );

	// If custom base is empty, set default.
	if ( '' == $wpd_products_slug ) {
		$wpd_products_slug = 'products';
	}

	// Capitalize first letter of new slug.
	$wpd_products_slug_cap = ucfirst( $wpd_products_slug );

	add_submenu_page( 'wpd-settings', $wpd_products_slug_cap, $wpd_products_slug_cap, 'manage_options', 'edit.php?post_type=products', null );
}
add_action( 'admin_menu', 'wpd_admin_menu_products', 1 );

// Adds Categories admin submenu link.
function wpd_admin_menu_categories() {
	add_submenu_page( 'wpd-settings', 'Categories', 'Categories', 'manage_options', 'edit-tags.php?taxonomy=wpd_categories', null );
}
add_action( 'admin_menu', 'wpd_admin_menu_categories', 2 );

// Adds Vendors admin submenu link.
function wpd_admin_menu_vendors() {
	add_submenu_page( 'wpd-settings', 'Vendors', 'Vendors', 'manage_options', 'edit-tags.php?taxonomy=vendor', null );
}
add_action( 'admin_menu', 'wpd_admin_menu_vendors', 6 );

// Keeps the WP Dispensary link list open when taxonomy submenu items are open.
function wpd_keep_taxonomy_menu_open( $parent_file ) {
	global $current_screen;
	// Get current screen taxonomy.
	$taxonomy = $current_screen->taxonomy;
	// Check taxonomies.
	if ( 'vendor' == $taxonomy || 'wpd_categories' == $taxonomy || 'shelf_type' == $taxonomy || 'strain_type' == $taxonomy ) {
		$parent_file = 'wpd-settings';
	}

	return $parent_file;
}
add_action( 'parent_file', 'wpd_keep_taxonomy_menu_open' );
