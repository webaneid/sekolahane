<?php
/**
 * Template part untuk menampilkan Section Ekstrakurikuler di Landing Page / Profil.
 *
 * Mendukung 2 pilihan desain section (ane_ekstra_style):
 * 1. bento : Bento Grid Showcase (grid mosaik asimetris modern tanpa carousel)
 * 2. split : Asymmetric Split Showcase (panel intro & CTA di kiri, grid kegiatan di kanan)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_style_raw   = (string) get_sub_field( 'ane_ekstra_style' );
$sekolahane_style_map   = array(
	'bento' => 'ekstra-layout-bento',
	'split' => 'ekstra-layout-split',
);
$sekolahane_style_class = isset( $sekolahane_style_map[ $sekolahane_style_raw ] ) ? $sekolahane_style_map[ $sekolahane_style_raw ] : 'ekstra-layout-bento';

$sekolahane_judul       = trim( (string) get_sub_field( 'ane_title' ) );
$sekolahane_deskripsi   = trim( wp_strip_all_tags( (string) get_sub_field( 'ane_deskripsi' ) ) );
$sekolahane_archive_url = get_post_type_archive_link( 'ekstrakurikuler' );
$sekolahane_limit       = 6;

$sekolahane_ekstra_query = new WP_Query(
	array(
		'post_type'      => 'ekstrakurikuler',
		'posts_per_page' => $sekolahane_limit,
		'post_status'    => 'publish',
	)
);
?>
<section class="home-ekstrakurikuler <?php echo esc_attr( $sekolahane_style_class ); ?>">
	<div class="container">
		<?php if ( 'ekstra-layout-split' === $sekolahane_style_class ) : ?>
			<div class="ane-ekstra-split-box">
				<div class="ane-ekstra-split-intro">
					<span class="ane-ekstra-badge"><?php esc_html_e( 'Bakat & Minat Siswa', 'sekolahane' ); ?></span>
					<div class="home-title">
						<?php if ( '' !== $sekolahane_judul ) : ?>
							<h2><?php echo wp_kses_post( $sekolahane_judul ); ?></h2>
						<?php else : ?>
							<h2>Ekstra<span>kurikuler</span></h2>
						<?php endif; ?>

						<?php if ( '' !== $sekolahane_deskripsi ) : ?>
							<p><?php echo esc_html( $sekolahane_deskripsi ); ?></p>
						<?php else : ?>
							<p><?php esc_html_e( 'Wadah pengembangan potensi, karakter, kepemimpinan, dan kreativitas peserta didik melalui berbagai kegiatan positif.', 'sekolahane' ); ?></p>
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

				<div class="ane-ekstra-split-gallery">
					<div class="ane-ekstra-split-grid">
						<?php
						while ( $sekolahane_ekstra_query->have_posts() ) :
							$sekolahane_ekstra_query->the_post();
							echo '<div class="ane-ekstra-grid-item">';
							get_template_part( 'tp/content', 'ekstrakurikuler' );
							echo '</div>';
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
		<?php else : ?>
			<div class="ane-ekstra-header">
				<div class="home-title">
					<span class="ane-ekstra-badge"><?php esc_html_e( 'Bakat & Minat Siswa', 'sekolahane' ); ?></span>
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

			<div class="ane-ekstra-bento-grid">
				<?php
				while ( $sekolahane_ekstra_query->have_posts() ) :
					$sekolahane_ekstra_query->the_post();
					echo '<div class="ane-ekstra-bento-item">';
					get_template_part( 'tp/content', 'ekstrakurikuler' );
					echo '</div>';
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
