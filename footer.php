<?php
/**
 * Footer template theme Sekolah Ane.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

get_template_part( 'tp/mobile/menu-footer' );
$nama  = get_field( 'nama_organisasi', 'option' );
$judul = ! empty( $nama ) ? (string) $nama : get_bloginfo( 'name' );
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
							$judul   = (string) get_sub_field( 'company_name' );
							$sologan = (string) get_sub_field( 'company_sologan' );
							$about   = (string) get_sub_field( 'company_about' );
							?>
							<div class="footer-content">
								<h3><?php echo esc_html( $judul ); ?></h3>
								<h4><?php echo esc_html( $sologan ); ?></h4>
								<p><?php echo wp_kses_post( $about ); ?></p>
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
										$alamat = (string) get_sub_field( 'kontak_alamat' );
										$phone  = (string) get_sub_field( 'kontak_telepon' );
										$mobile = (string) get_sub_field( 'kontak_handphone' );
										$email  = (string) get_sub_field( 'kontak_email' );
										$web    = (string) get_sub_field( 'kontak_website' );
										$url    = home_url( '/' );

										if ( '' !== $alamat ) :
											?>
											<li><i class="ane-lokasi"></i> <?php echo esc_html( $alamat ); ?></li>
											<?php
										endif;
										if ( '' !== $phone ) :
											?>
											<li><i class="ane-telepon"></i> <?php echo esc_html( $phone ); ?></li>
											<?php
										endif;
										if ( '' !== $mobile ) :
											?>
											<li><i class="ane-handphone"></i> <?php echo esc_html( $mobile ); ?></li>
											<?php
										endif;
										if ( '' !== $email ) :
											?>
											<li><i class="ane-email"></i> <?php echo esc_html( $email ); ?></li>
											<?php
										endif;
										if ( '' !== $web ) :
											?>
											<li><a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $web ); ?>"> <i class="ane-laptop"></i> <?php echo esc_html( $web ); ?></a></li>
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
				Copyright <?php echo wp_kses_post( webane_load_dynamic_copyright_year() ) . ' ' . esc_html( $judul ) . ' ' . wp_kses_post( webane_load_designed_by() ); ?>
			</div>
		</div>
	</div>
</footer>
<div class="cc-contactpop fixed">
	<header class="kelapa">
		<?php
		$cs_title = get_field( 'ane_cs_label', 'option' );
		if ( ! empty( $cs_title ) ) :
			?>
			<h3><span class="fa fa-whatsapp" aria-hidden="true"></span> <?php echo esc_html( (string) $cs_title ); ?></h3>
		<?php endif; ?>
	</header>

	<div class="renseignement">
		<i class="fa fa-times"></i>
		<?php
		$msg = get_field( 'ane_cs_welcome', 'option' );
		if ( ! empty( $msg ) ) :
			?>
			<p><?php echo esc_html( (string) $msg ); ?></p>
			<?php
		endif;
		if ( have_rows( 'ane_cs', 'option' ) ) :
			?>
			<ul>
				<?php
				while ( have_rows( 'ane_cs', 'option' ) ) :
					the_row();
					$wa    = preg_replace( '/[^0-9]/', '', (string) get_sub_field( 'ane_whatsapp' ) );
					$image = get_sub_field( 'ane_image' );
					$nama  = (string) get_sub_field( 'ane_nama' );
					$area  = (string) get_sub_field( 'ane_area' );
					$wa_url = 'https://wa.me/' . $wa;
					?>
					<li>
						<?php
						if ( is_array( $image ) && ! empty( $image['sizes']['kotak'] ) ) :
							?>
							<img src="<?php echo esc_url( (string) $image['sizes']['kotak'] ); ?>" alt="<?php echo esc_attr( $nama ); ?>">
						<?php endif; ?>
						<a href="<?php echo esc_url( $wa_url ); ?>">
							<span><?php echo esc_html( $nama ); ?> </span><br/>
							<?php echo esc_html( $area ); ?>
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
