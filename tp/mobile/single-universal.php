<?php
/**
 * Template part: Universal Single Mobile App-Style (tp/mobile/single-universal.php).
 *
 * Berlaku untuk semua single di perangkat mobile:
 * - Post standar & format video (single.php)
 * - Default Page (page.php)
 * - CPT Ekstrakurikuler (single-ekstrakurikuler.php)
 * - CPT Guru (single-guru.php)
 *
 * Struktur urutan aplikasi modern:
 * 1. Featured Image / Media (padding kiri-kanan 15px & border-radius cantik)
 * 2. Badge Kategori / Label + Judul Utama
 * 3. Meta Date / Meta Deskripsi / Info Jabatan & Mengajar
 * 4. Konten Artikel Bersih (.ane-content)
 * 5. Tag & Modern Share Bar (+ Copy URL) di bagian bawah
 * 6. Konten Terkait Ringkas
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_post_id   = (int) get_the_ID();
$sekolahane_post_type = (string) get_post_type( $sekolahane_post_id );
$sekolahane_img_url   = '';
$sekolahane_img_cap   = '';

if ( has_post_thumbnail( $sekolahane_post_id ) ) {
	$sekolahane_img_size = ( 'guru' === $sekolahane_post_type ) ? 'kotak' : 'large';
	$sekolahane_thumb_id = (int) get_post_thumbnail_id( $sekolahane_post_id );
	$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, $sekolahane_img_size );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_img_url = (string) $sekolahane_thumb[0];
	}
	$sekolahane_thumb_post = get_post( $sekolahane_thumb_id );
	if ( $sekolahane_thumb_post instanceof WP_Post && '' !== trim( $sekolahane_thumb_post->post_excerpt ) ) {
		$sekolahane_img_cap = trim( $sekolahane_thumb_post->post_excerpt );
	}
} elseif ( 'post' === $sekolahane_post_type && 'video' === get_post_format( $sekolahane_post_id ) ) {
	$sekolahane_embed_url = ane_get_embedded_media( array( 'video', 'iframe' ) );
	if ( '' !== $sekolahane_embed_url ) {
		$sekolahane_img_url = ane_get_youtube_thumbnail( $sekolahane_embed_url, 'hq' );
	}
} elseif ( 'guru' === $sekolahane_post_type ) {
	$sekolahane_img_url = ane_dummy_kotak();
} elseif ( 'page' === $sekolahane_post_type ) {
	$sekolahane_img_url = sekolahane_dummy_tumbnail();
}

$sekolahane_jabatan    = ( 'guru' === $sekolahane_post_type ) ? trim( (string) get_field( 'ane_jabatan', $sekolahane_post_id ) ) : '';
$sekolahane_single_cls = ( 'guru' === $sekolahane_post_type ) ? 'ane-mobile-single msingle-type-guru' : 'ane-mobile-single';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $sekolahane_single_cls ); ?>>
	<?php if ( '' !== $sekolahane_img_url ) : ?>
		<div class="msingle-media">
			<div class="msingle-media-frame">
				<img src="<?php echo esc_url( $sekolahane_img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="eager">
			</div>
			<?php if ( '' !== $sekolahane_img_cap ) : ?>
				<span class="msingle-caption"><?php echo wp_kses_post( $sekolahane_img_cap ); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="msingle-container">
		<header class="msingle-head">
			<?php if ( 'post' === $sekolahane_post_type ) : ?>
				<?php
				$sekolahane_cats = get_the_category( $sekolahane_post_id );
				if ( ! empty( $sekolahane_cats ) ) :
					?>
					<div class="msingle-badges">
						<?php foreach ( $sekolahane_cats as $sekolahane_cat ) : ?>
							<a class="msingle-badge" href="<?php echo esc_url( get_category_link( $sekolahane_cat->term_id ) ); ?>">
								<?php echo esc_html( $sekolahane_cat->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php elseif ( 'ekstrakurikuler' === $sekolahane_post_type ) : ?>
				<div class="msingle-badges">
					<span class="msingle-badge"><?php esc_html_e( 'Ekstrakurikuler', 'sekolahane' ); ?></span>
				</div>
			<?php elseif ( 'guru' === $sekolahane_post_type && '' !== $sekolahane_jabatan ) : ?>
				<div class="msingle-badges">
					<span class="msingle-badge"><?php echo esc_html( $sekolahane_jabatan ); ?></span>
				</div>
			<?php endif; ?>

			<?php the_title( '<h1 class="msingle-title">', '</h1>' ); ?>

			<?php if ( 'post' === $sekolahane_post_type ) : ?>
				<div class="msingle-meta">
					<span class="msingle-meta-item">
						<?php echo sekolahane_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo esc_html( (string) get_the_date( 'j F Y' ) ); ?>
					</span>
					<span class="msingle-meta-dot" aria-hidden="true">&bull;</span>
					<span class="msingle-meta-item">
						<?php echo sekolahane_icon( 'eye' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo esc_html( (string) get_views( $sekolahane_post_id ) ); ?>
					</span>
				</div>
			<?php elseif ( 'guru' === $sekolahane_post_type ) : ?>
				<?php
				$sekolahane_pelajaran = get_the_terms( $sekolahane_post_id, 'pelajaran' );
				$sekolahane_kelas     = get_the_terms( $sekolahane_post_id, 'Kelas' );
				if ( is_array( $sekolahane_pelajaran ) || is_array( $sekolahane_kelas ) ) :
					?>
					<div class="msingle-guru-info">
						<?php if ( is_array( $sekolahane_pelajaran ) && ! empty( $sekolahane_pelajaran ) ) : ?>
							<div class="msingle-guru-row">
								<span class="msingle-guru-label"><?php esc_html_e( 'Pelajaran:', 'sekolahane' ); ?></span>
								<div class="msingle-guru-tags">
									<?php foreach ( $sekolahane_pelajaran as $sekolahane_mapel ) : ?>
										<a href="<?php echo esc_url( (string) get_term_link( $sekolahane_mapel ) ); ?>"><?php echo esc_html( $sekolahane_mapel->name ); ?></a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php if ( is_array( $sekolahane_kelas ) && ! empty( $sekolahane_kelas ) ) : ?>
							<div class="msingle-guru-row">
								<span class="msingle-guru-label"><?php esc_html_e( 'Kelas:', 'sekolahane' ); ?></span>
								<div class="msingle-guru-tags">
									<?php foreach ( $sekolahane_kelas as $sekolahane_kls ) : ?>
										<a href="<?php echo esc_url( (string) get_term_link( $sekolahane_kls ) ); ?>"><?php echo esc_html( $sekolahane_kls->name ); ?></a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<div class="msingle-meta">
					<span class="msingle-meta-item">
						<?php echo sekolahane_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php
						/* translators: %s: tanggal pembaruan halaman */
						echo esc_html( sprintf( __( 'Diperbarui %s', 'sekolahane' ), (string) get_the_modified_date( 'j F Y' ) ) );
						?>
					</span>
				</div>
			<?php endif; ?>
		</header>

		<div class="ane-content msingle-body">
			<?php the_content(); ?>

			<?php if ( 'post' === $sekolahane_post_type && get_the_tag_list() ) : ?>
				<div class="msingle-tags">
					<?php echo wp_kses_post( (string) get_the_tag_list( '<ul><li>', '</li><li>', '</li></ul>' ) ); ?>
				</div>
			<?php endif; ?>
		</div>

		<footer class="msingle-footer">
			<div class="share-this">
				<?php echo fungsi_share_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<?php if ( 'post' === $sekolahane_post_type ) : ?>
				<div class="msingle-related">
					<?php ane_related_post(); ?>
				</div>
			<?php elseif ( 'ekstrakurikuler' === $sekolahane_post_type ) : ?>
				<?php
				$sekolahane_ekstra_q = new WP_Query(
					array(
						'post_type'           => 'ekstrakurikuler',
						'posts_per_page'      => 4,
						'ignore_sticky_posts' => 1,
						'orderby'             => 'rand',
						'post__not_in'        => array( $sekolahane_post_id ),
					)
				);
				if ( $sekolahane_ekstra_q->have_posts() ) :
					?>
					<div class="konten-terkait-v2 msingle-related-cpt">
						<h2><?php esc_html_e( 'Ekstrakurikuler Lain', 'sekolahane' ); ?></h2>
						<div class="testimoni-slider owl-carousel">
							<?php
							while ( $sekolahane_ekstra_q->have_posts() ) :
								$sekolahane_ekstra_q->the_post();
								get_template_part( 'tp/content', 'ekstrakurikuler' );
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
				<?php endif; ?>
			<?php elseif ( 'guru' === $sekolahane_post_type ) : ?>
				<?php
				$sekolahane_terms    = get_the_terms( $sekolahane_post_id, 'Kelas' );
				$sekolahane_term_ids = is_array( $sekolahane_terms ) ? wp_list_pluck( $sekolahane_terms, 'term_id' ) : array();
				if ( ! empty( $sekolahane_term_ids ) ) :
					$sekolahane_guru_q = new WP_Query(
						array(
							'post_type'           => 'guru',
							// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
							'tax_query'           => array(
								array(
									'taxonomy' => 'Kelas',
									'field'    => 'id',
									'terms'    => $sekolahane_term_ids,
									'operator' => 'IN',
								),
							),
							'posts_per_page'      => 4,
							'ignore_sticky_posts' => 1,
							'orderby'             => 'rand',
							'post__not_in'        => array( $sekolahane_post_id ),
						)
					);
					if ( $sekolahane_guru_q->have_posts() ) :
						?>
						<div class="konten-terkait-v2 msingle-related-cpt">
							<h2><?php esc_html_e( 'Guru Kelas Yang Sama', 'sekolahane' ); ?></h2>
							<div class="testimoni-slider owl-carousel">
								<?php
								while ( $sekolahane_guru_q->have_posts() ) :
									$sekolahane_guru_q->the_post();
									get_template_part( 'tp/content', 'guru' );
								endwhile;
								wp_reset_postdata();
								?>
							</div>
						</div>
						<?php
					endif;
				endif;
				?>
			<?php endif; ?>
		</footer>
	</div>
</article>
