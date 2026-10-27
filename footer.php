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
				Copyright <?php echo wp_kses_post( (string) webane_load_dynamic_copyright_year() ) . ' ' . esc_html( $sekolahane_judul ) . ' ' . wp_kses_post( (string) webane_load_designed_by() ); ?>
			</div>
		</div>
	</div>
</footer>
<div class="cc-contactpop fixed">
	<header class="kelapa">
		<?php
		$sekolahane_cs_title = get_field( 'ane_cs_label', 'option' );
		if ( ! empty( $sekolahane_cs_title ) ) :
			?>
			<h3><span class="fa fa-whatsapp" aria-hidden="true"></span> <?php echo esc_html( (string) $sekolahane_cs_title ); ?></h3>
		<?php endif; ?>
	</header>

	<div class="renseignement">
		<i class="fa fa-times"></i>
		<?php
		$sekolahane_msg = get_field( 'ane_cs_welcome', 'option' );
		if ( ! empty( $sekolahane_msg ) ) :
			?>
			<p><?php echo esc_html( (string) $sekolahane_msg ); ?></p>
			<?php
		endif;
		if ( have_rows( 'ane_cs', 'option' ) ) :
			?>
			<ul>
				<?php
				while ( have_rows( 'ane_cs', 'option' ) ) :
					the_row();
					$sekolahane_wa     = (string) preg_replace( '/[^0-9]/', '', (string) get_sub_field( 'ane_whatsapp' ) );
					$sekolahane_image  = get_sub_field( 'ane_image' );
					$sekolahane_nama   = (string) get_sub_field( 'ane_nama' );
					$sekolahane_area   = (string) get_sub_field( 'ane_area' );
					$sekolahane_wa_url = 'https://wa.me/' . $sekolahane_wa;
					?>
					<li>
						<?php
						if ( is_array( $sekolahane_image ) && ! empty( $sekolahane_image['sizes']['kotak'] ) ) :
							?>
							<img src="<?php echo esc_url( (string) $sekolahane_image['sizes']['kotak'] ); ?>" alt="<?php echo esc_attr( $sekolahane_nama ); ?>">
						<?php endif; ?>
						<a href="<?php echo esc_url( $sekolahane_wa_url ); ?>">
							<span><?php echo esc_html( $sekolahane_nama ); ?> </span><br/>
							<?php echo esc_html( $sekolahane_area ); ?>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>

</div> <!-- webane-wrapper -->
<?php wp_footer(); ?>
</body>
</html>
