<?php
/**
 * Template part untuk menampilkan Section Ekstrakurikuler di Landing Page / Profil.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_judul       = trim( (string) get_sub_field( 'ane_title' ) );
$sekolahane_deskripsi   = trim( wp_strip_all_tags( (string) get_sub_field( 'ane_deskripsi' ) ) );
$sekolahane_archive_url = get_post_type_archive_link( 'ekstrakurikuler' );
?>
<section class="home-ekstrakurikuler">
	<div class="container">
		<div class="ane-ekstra-header">
			<div class="home-title">
				<?php if ( '' !== $sekolahane_judul ) : ?>
					<h2><?php echo wp_kses_post( $sekolahane_judul ); ?></h2>
				<?php else : ?>
					<h2>Ekstra<span>kurikuler</span></h2>
				<?php endif; ?>

				<?php if ( '' !== $sekolahane_deskripsi ) : ?>
					<p><?php echo esc_html( $sekolahane_deskripsi ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( is_string( $sekolahane_archive_url ) && '' !== $sekolahane_archive_url ) : ?>
				<div class="ane-ekstra-action">
					<a href="<?php echo esc_url( $sekolahane_archive_url ); ?>" class="btn-ekstra-all">
						<span><?php esc_html_e( 'Semua Ekstrakurikuler', 'sekolahane' ); ?></span>
						<?php echo sekolahane_icon( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="owl-carousel dot-style2" id="home-sliding">
					<?php
					$sekolahane_ekstra_query = new WP_Query(
						array(
							'post_type'      => 'ekstrakurikuler',
							'posts_per_page' => 8,
							'post_status'    => 'publish',
						)
					);
					while ( $sekolahane_ekstra_query->have_posts() ) :
						$sekolahane_ekstra_query->the_post();
						get_template_part( 'tp/content', 'ekstrakurikuler' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
	</div>
</section>
