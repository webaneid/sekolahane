<?php
/**
 * Widget daftar artikel kustom (Webane_Posts_Widget).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals, Universal.Files.SeparateFunctionsFromOO.Mixed

/**
 * Daftarkan widget Webane_Posts_Widget.
 *
 * @return void
 */
function webane_posts_widgets_init() {
	register_widget( 'Webane_Posts_Widget' );
}
add_action( 'widgets_init', 'webane_posts_widgets_init' );

/**
 * Class Webane_Posts_Widget.
 */
class Webane_Posts_Widget extends WP_Widget {

	/**
	 * Konstruktor widget.
	 */
	public function __construct() {
		parent::__construct(
			'post-widget',
			'Webane: Posts',
			array(
				'description' => __( 'Menampilkan daftar post berdasarkan post terbaru, kategori, tag, populer, atau komentar terbanyak.', 'sekolahane' ),
			)
		);
	}

	/**
	 * Nilai default untuk instance widget.
	 *
	 * @return array<string, mixed>
	 */
	private function get_default_instance() {
		return array(
			'title'     => '',
			'type'      => 'Recent Post',
			'category'  => '',
			'post_tag'  => '',
			'number'    => '5',
			'offset'    => '0',
			'orderby'   => 'date',
			'order'     => 'DESC',
			'date'      => 'all',
			'thumbnail' => 'small',
			'tdc'       => true,
			'author'    => false,
		);
	}

	/**
	 * Render tampilan front-end widget.
	 *
	 * @param array<string, mixed> $args     Argumen tampilan widget dari sidebar.
	 * @param array<string, mixed> $instance Pengaturan widget yang tersimpan di DB.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$settings      = wp_parse_args( (array) $instance, $this->get_default_instance() );
		$before_widget = isset( $args['before_widget'] ) ? (string) $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? (string) $args['after_widget'] : '';

		$title    = apply_filters( 'widget_title', empty( $settings['title'] ) ? '' : (string) $settings['title'] );
		$type     = (string) $settings['type'];
		$category = (string) $settings['category'];
		$post_tag = (string) $settings['post_tag'];
		$number   = absint( $settings['number'] ) > 0 ? absint( $settings['number'] ) : 5;
		$orderby  = (string) $settings['orderby'];
		$order    = 'ASC' === strtoupper( (string) $settings['order'] ) ? 'ASC' : 'DESC';

		$query_args = array(
			'post_status'    => array( 'publish', 'inherit' ),
			'orderby'        => $orderby,
			'order'          => $order,
			'posts_per_page' => $number,
		);

		if ( 'Most Comments' === $type ) {
			$query_args['orderby'] = 'comment_count';
			$query_args['order']   = 'DESC';
		} elseif ( 'Popular Post' === $type ) {
			$query_args['orderby']  = 'meta_value_num';
			$query_args['meta_key'] = 'post_views_count';
		} elseif ( 'Post Format: Gallery' === $type ) {
			$query_args['post_format'] = 'post-format-gallery';
		} elseif ( 'Post Format: Video' === $type ) {
			$query_args['post_format'] = 'post-format-video';
		}

		if ( '' !== $post_tag ) {
			$query_args['tag'] = $post_tag;
		} elseif ( '' !== $category ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => $category,
				),
			);
		}

		$r = new WP_Query( $query_args );

		echo wp_kses_post( $before_widget );
		if ( ! empty( $title ) ) {
			echo '<h2 class="widget-title general-title">' . esc_html( $title ) . '</h2>';
		}
		echo '<div class="post-widget">';

		if ( $r->have_posts() ) :
			while ( $r->have_posts() ) :
				$r->the_post();
				$detect = new Mobile_Detect();
				if ( ! $detect->isTablet() ) {
					get_template_part( 'tp/content', 'list' );
				} else {
					get_template_part( 'tp/content', (string) get_post_format() );
				}
			endwhile;
		else :
			?>
			<p><?php esc_html_e( 'No post found', 'sekolahane' ); ?></p>
			<?php
		endif;

		echo '</div>';
		echo wp_kses_post( $after_widget );

		wp_reset_postdata();
	}

	/**
	 * Sanitasi nilai form widget saat disimpan.
	 *
	 * @param array<string, mixed> $new_instance Nilai baru yang dikirim dari form.
	 * @param array<string, mixed> $old_instance Nilai lama di DB.
	 * @return array<string, mixed>
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = is_array( $old_instance ) ? $old_instance : array();
		$instance['title']    = isset( $new_instance['title'] ) ? sanitize_text_field( (string) $new_instance['title'] ) : '';
		$instance['type']     = isset( $new_instance['type'] ) ? sanitize_text_field( (string) $new_instance['type'] ) : 'Recent Post';
		$instance['category'] = isset( $new_instance['category'] ) ? sanitize_text_field( (string) $new_instance['category'] ) : '';
		$instance['post_tag'] = isset( $new_instance['post_tag'] ) ? sanitize_text_field( (string) $new_instance['post_tag'] ) : '';
		$instance['number']   = isset( $new_instance['number'] ) ? (string) absint( $new_instance['number'] ) : '5';
		$instance['offset']   = isset( $new_instance['offset'] ) ? (string) absint( $new_instance['offset'] ) : '0';
		$instance['orderby']  = isset( $new_instance['orderby'] ) ? sanitize_key( (string) $new_instance['orderby'] ) : 'date';
		$instance['order']    = ( isset( $new_instance['order'] ) && 'ASC' === strtoupper( (string) $new_instance['order'] ) ) ? 'ASC' : 'DESC';

		return $instance;
	}

	/**
	 * Render form pengaturan widget di wp-admin.
	 *
	 * @param array<string, mixed> $instance Pengaturan yang tersimpan di DB.
	 * @return string
	 */
	public function form( $instance ) {
		$types    = array( 'Recent Post', 'Popular Post', 'Most Comments', 'Post Format: Gallery', 'Post Format: Video' );
		$orderbys = array( 'ID', 'title', 'date', 'rand' );
		$orders   = array( 'ASC', 'DESC' );

		$settings = wp_parse_args( (array) $instance, $this->get_default_instance() );
		$title    = (string) $settings['title'];
		$type     = (string) $settings['type'];
		$category = (string) $settings['category'];
		$post_tag = (string) $settings['post_tag'];
		$number   = (string) $settings['number'];
		$orderby  = (string) $settings['orderby'];
		$order    = (string) $settings['order'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'sekolahane' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Select a type', 'sekolahane' ); ?></label>
			<select onchange="typechange()" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">
				<?php foreach ( $types as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>"<?php selected( $type, $option ); ?>><?php echo esc_html( $option ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<hr />
		<p id="category<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select a category:', 'sekolahane' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
				<option value=""><?php esc_html_e( 'All Category', 'sekolahane' ); ?></option>
				<?php
				$category_get = get_terms(
					array(
						'taxonomy'   => 'category',
						'hide_empty' => false,
					)
				);

				if ( is_array( $category_get ) && ! empty( $category_get ) ) :
					foreach ( $category_get as $option ) :
						if ( $option instanceof WP_Term ) :
							?>
							<option value="<?php echo esc_attr( $option->slug ); ?>"<?php selected( $category, $option->slug ); ?>><?php echo esc_html( $option->name ); ?></option>
							<?php
						endif;
					endforeach;
				endif;
				?>
			</select>
		</p>
		<hr />
		<p id="tag<?php echo esc_attr( $this->get_field_id( 'post_tag' ) ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'post_tag' ) ); ?>"><?php esc_html_e( 'Type tag', 'sekolahane' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'post_tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_tag' ) ); ?>" type="text" value="<?php echo esc_attr( $post_tag ); ?>" />
			<?php esc_html_e( 'separate by comma', 'sekolahane' ); ?>
		</p>
		<hr />
		<h4><?php esc_html_e( 'Display options', 'sekolahane' ); ?></h4>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'sekolahane' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" style="width:40px; margin-left:.2em; text-align:right;" />
		</p>
		<?php
		$orderby_style = ( 'Most Comments' === $type || 'Popular Post' === $type ) ? 'display:none' : 'display:block';
		?>
		<p id="orderby<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" style="<?php echo esc_attr( $orderby_style ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order post by:', 'sekolahane' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<?php foreach ( $orderbys as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>" id="<?php echo esc_attr( $option ); ?>"<?php selected( $orderby, $option ); ?>><?php echo esc_html( $option ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p id="order<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order:', 'sekolahane' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
				<?php foreach ( $orders as $option ) : ?>
					<option value="<?php echo esc_attr( $option ); ?>"<?php selected( $order, $option ); ?>><?php echo esc_html( $option ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
		return '';
	}
}
