<?php
/**
 * Footer template theme Sekolah Ane.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

get_template_part( 'tp/mobile/menu-footer' );
$sekolahane_org_name = get_field( 'nama_organisasi', 'option' );
$sekolahane_judul    = ! empty( $sekolahane_org_name ) ? (string) $sekolahane_org_name : get_bloginfo( 'name' );
?>
<footer id="footer" class="ane-footer">
	<div class="atas">
		<div class="container">
			<div class="row justify-content-center">
				<?php if ( have_rows( 'about_ane', 'option' ) ) : ?>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-12">
						<div class="isi">
							<?php
							while ( have_rows( 'about_ane', 'option' ) ) :
								the_row();
								$sekolahane_comp_name = trim( (string) get_sub_field( 'company_name' ) );
								$sekolahane_slogan    = trim( (string) get_sub_field( 'company_sologan' ) );
								$sekolahane_about     = trim( (string) get_sub_field( 'company_about' ) );
								if ( '' !== $sekolahane_comp_name ) {
									$sekolahane_judul = $sekolahane_comp_name;
								}
								?>
								<div class="footer-content">
									<?php if ( '' !== $sekolahane_comp_name ) : ?>
										<h3><?php echo esc_html( $sekolahane_comp_name ); ?></h3>
									<?php endif; ?>
									<?php if ( '' !== $sekolahane_slogan ) : ?>
										<h4><?php echo esc_html( $sekolahane_slogan ); ?></h4>
									<?php endif; ?>
									<?php if ( '' !== $sekolahane_about ) : ?>
										<p><?php echo wp_kses_post( $sekolahane_about ); ?></p>
									<?php endif; ?>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-12">
					<div class="isi-v2">
						<h3><?php esc_html_e( 'Link Penting', 'sekolahane' ); ?></h3>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menufooter',
								'container'      => 'div',
								'fallback_cb'    => 'wp_page_menu',
								'depth'          => 4,
							)
						);
						?>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-12">
					<div class="isi-v2">
						<h3><?php esc_html_e( 'Hubungi Kami', 'sekolahane' ); ?></h3>
						<?php if ( have_rows( 'contact_ane', 'option' ) ) : ?>
							<div class="footer-kontak">
								<ul>
									<?php
									while ( have_rows( 'contact_ane', 'option' ) ) :
										the_row();
										$sekolahane_alamat = trim( (string) get_sub_field( 'kontak_alamat' ) );
										$sekolahane_phone  = trim( (string) get_sub_field( 'kontak_telepon' ) );
										$sekolahane_mobile = trim( (string) get_sub_field( 'kontak_handphone' ) );
										$sekolahane_email  = trim( (string) get_sub_field( 'kontak_email' ) );
										$sekolahane_web    = trim( (string) get_sub_field( 'kontak_website' ) );
										$sekolahane_url    = home_url( '/' );

										if ( '' !== $sekolahane_alamat ) :
											?>
											<li>
												<?php echo sekolahane_icon( 'lokasi' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												<span><?php echo esc_html( $sekolahane_alamat ); ?></span>
											</li>
											<?php
										endif;
										if ( '' !== $sekolahane_phone ) :
											?>
											<li>
												<?php echo sekolahane_icon( 'telepon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												<span><?php echo esc_html( $sekolahane_phone ); ?></span>
											</li>
											<?php
										endif;
										if ( '' !== $sekolahane_mobile ) :
											?>
											<li>
												<?php echo sekolahane_icon( 'handphone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												<span><?php echo esc_html( $sekolahane_mobile ); ?></span>
											</li>
											<?php
										endif;
										if ( '' !== $sekolahane_email ) :
											?>
											<li>
												<?php echo sekolahane_icon( 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												<span><?php echo esc_html( $sekolahane_email ); ?></span>
											</li>
											<?php
										endif;
										if ( '' !== $sekolahane_web ) :
											?>
											<li>
												<a href="<?php echo esc_url( $sekolahane_url ); ?>" title="<?php echo esc_attr( $sekolahane_web ); ?>">
													<?php echo sekolahane_icon( 'laptop' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
													<span><?php echo esc_html( $sekolahane_web ); ?></span>
												</a>
											</li>
											<?php
										endif;
									endwhile;
									?>
								</ul>
							</div>
							<?php
						endif;
						get_template_part( 'tp/content', 'sosmed' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bawah">
		<div class="container">
			<div class="isi">
				<div class="bawah-kiri">
					Copyright <?php echo wp_kses_post( (string) webane_load_dynamic_copyright_year() ) . ' ' . esc_html( $sekolahane_judul ); ?>
				</div>
				<div class="bawah-kanan">
					<?php echo wp_kses_post( ltrim( (string) webane_load_designed_by(), '| ' ) ); ?>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php
$sekolahane_cs_title   = trim( (string) get_field( 'ane_cs_label', 'option' ) );
$sekolahane_cs_label   = '' !== $sekolahane_cs_title ? $sekolahane_cs_title : __( 'Layanan Informasi', 'sekolahane' );
$sekolahane_cs_welcome = trim( (string) get_field( 'ane_cs_welcome', 'option' ) );
if ( have_rows( 'ane_cs', 'option' ) ) :
	?>
	<div class="cc-contactpop fixed">
		<header class="kelapa" role="button" tabindex="0" aria-label="<?php echo esc_attr( $sekolahane_cs_label ); ?>">
			<span class="cc-wa-fab">
				<?php echo sekolahane_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="cc-wa-dot" aria-hidden="true"></span>
			</span>
		</header>

		<div class="renseignement">
			<div class="cc-popup-head">
				<div class="cc-popup-head-info">
					<h3><?php echo esc_html( $sekolahane_cs_label ); ?></h3>
					<?php if ( '' !== $sekolahane_cs_welcome ) : ?>
						<p><?php echo esc_html( $sekolahane_cs_welcome ); ?></p>
					<?php endif; ?>
				</div>
				<button type="button" class="cc-close-btn" aria-label="<?php esc_attr_e( 'Tutup', 'sekolahane' ); ?>">&times;</button>
			</div>
			<ul>
				<?php
				while ( have_rows( 'ane_cs', 'option' ) ) :
					the_row();
					$sekolahane_wa = (string) preg_replace( '/[^0-9]/', '', (string) get_sub_field( 'ane_whatsapp' ) );
					if ( '' !== $sekolahane_wa && '0' === substr( $sekolahane_wa, 0, 1 ) ) {
						$sekolahane_wa = '62' . substr( $sekolahane_wa, 1 );
					}
					$sekolahane_image  = get_sub_field( 'ane_image' );
					$sekolahane_nama   = trim( (string) get_sub_field( 'ane_nama' ) );
					$sekolahane_area   = trim( (string) get_sub_field( 'ane_area' ) );
					$sekolahane_wa_url = 'https://wa.me/' . $sekolahane_wa;
					$sekolahane_avatar = '';
					if ( is_array( $sekolahane_image ) ) {
						if ( ! empty( $sekolahane_image['sizes']['kotak'] ) ) {
							$sekolahane_avatar = (string) $sekolahane_image['sizes']['kotak'];
						} elseif ( ! empty( $sekolahane_image['url'] ) ) {
							$sekolahane_avatar = (string) $sekolahane_image['url'];
						}
					}
					?>
					<li>
						<a href="<?php echo esc_url( $sekolahane_wa_url ); ?>" target="_blank" rel="noopener noreferrer" class="cc-agent-item">
							<div class="cc-agent-avatar">
								<?php if ( '' !== $sekolahane_avatar ) : ?>
									<img src="<?php echo esc_url( $sekolahane_avatar ); ?>" alt="<?php echo esc_attr( $sekolahane_nama ); ?>" loading="lazy">
								<?php else : ?>
									<span class="cc-agent-fallback" aria-hidden="true">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" focusable="false">
											<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
										</svg>
									</span>
								<?php endif; ?>
								<span class="cc-agent-status" aria-hidden="true"></span>
							</div>
							<div class="cc-agent-meta">
								<span class="cc-agent-name"><?php echo esc_html( $sekolahane_nama ); ?></span>
								<?php if ( '' !== $sekolahane_area ) : ?>
									<span class="cc-agent-role"><?php echo esc_html( $sekolahane_area ); ?></span>
								<?php endif; ?>
							</div>
							<span class="cc-agent-action" aria-hidden="true">
								<?php echo sekolahane_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>

<?php get_template_part( 'tp/mobile/menu-footer' ); ?>

</div> <!-- webane-wrapper -->
<?php wp_footer(); ?>
</body>
</html>
