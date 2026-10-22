<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-page-kontak'); ?>>
	<header class="entry-header">
			<div class="ane-content">
				<div class="ane-title">
					<?php the_title( '<h1 class="post-title general-title">', '</h1>' ); ?>
				</div>
			</div>
            <div class="kontak-konten">
                <div class="row">

        			<div class="col-md-6 post-tengah">
						<?php if( have_rows('about_ane','option') ): ?>
							<div class="alamat">
								<?php while( have_rows('about_ane','option') ): the_row();
									$namaperusahaan = get_sub_field('company_name');
								?>
									<h3><?php echo esc_html( (string) $namaperusahaan ); ?></h3>

									<?php if( have_rows('contact_ane','option') ): ?>
											<?php
												while( have_rows('contact_ane','option') ): the_row();
												$alamat = get_sub_field('kontak_alamat');
													if( !empty( $alamat ) ):
														echo '<p>' . wp_kses_post( $alamat ) . '</p>';
													endif;
												endwhile; ?>

									<?php endif; ?>

								<?php endwhile; ?>
							</div>
						<?php endif; ?>

                    </div>

                        <div class="col-md-6 post-tengah">
							<?php if( have_rows('contact_ane','option') ): ?>
								<div class="kontak text-right">
										<?php
										while( have_rows('contact_ane','option') ): the_row();
										$Phone = get_sub_field('kontak_telepon');
										$mobile = get_sub_field('kontak_handphone');
										$Email = get_sub_field('kontak_email');
										$Web = get_sub_field('kontak_website');
											if( !empty( $Phone ) ):
										?>
										<p>Telepon: <?php echo esc_html( (string) $Phone ); ?></p>
										<?php
											endif;
											if( !empty( $mobile ) ):
										?>
										<p>Handphone: <?php echo esc_html( (string) $mobile ); ?></p>
										<?php endif;
											if( !empty( $Email ) ):
										?>
										<p>Email: <?php echo esc_html( (string) $Email ); ?></p>

										<?php endif; ?>
								<?php endwhile; ?>
								</div>

						<?php endif;
						?>
                        </div>

                </div>
            </div>

	</header>
    <div class="row">
        <div class="col-md-7">
            <div class="entry-content">
				<div class="kontak-cs-mobile">
					<?php
					$title = get_field('ane_cs_label', 'option');
					if(!empty($title)):
					?>
					<div class="ane-title">
						<h1><?php echo esc_html( (string) $title ); ?></h1>
					</div>
					<?php endif;?>


					<?php
					if( have_rows('ane_cs','option') ): ?>
				  <ul>

					  <?php // Loop through rows.
					  while( have_rows('ane_cs','option') ) : the_row();
					  $wa = preg_replace( '/[^0-9]/', '', (string) get_sub_field( 'ane_whatsapp' ) );
					  $wa_url = 'https://wa.me/' . $wa;
					  ?>
					  <a href="<?php echo esc_url( $wa_url ); ?>">
					  <li>
						  <?php
						  $image = get_sub_field('ane_image');
						  $nama = get_sub_field('ane_nama');
						  $area = get_sub_field('ane_area');

						  if( is_array( $image ) && isset( $image['sizes']['kotak'] ) ):
							  $thumb = $image['sizes']['kotak'];
						 	if( !empty( $thumb ) ):
						  ?>
						  <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( (string) $nama ); ?>">
					  	<?php endif; endif;?>
						  <a href="<?php echo esc_url( $wa_url ); ?>">
						  <span><?php echo esc_html( (string) $nama ); ?> </span><br/>
						  <?php echo esc_html( (string) $area ); ?>
							</a>
					  </li>
					  </a>
				  <?php endwhile; ?>
				  </ul>
			  <?php endif; ?>
				</div>
				<div class="ane-title">
					<h1>Kirim Pesan</h1>
				</div>
				<?php the_content();?>
			</div>
        </div>
        <?php
            $location = get_field('gmap', 'option');
            if( is_array( $location ) && ! empty( $location['lat'] ) && ! empty( $location['lng'] ) ):
                $lat     = (string) $location['lat'];
                $lng     = (string) $location['lng'];
                $address = isset( $location['address'] ) ? (string) $location['address'] : '';
        ?>
        <div class="col-md-5">
            <div class="kontak-map">
                    <div class="acf-map">
                        <div class="marker" data-lat="<?php echo esc_attr( $lat ); ?>" data-lng="<?php echo esc_attr( $lng ); ?>">
                        <a class="directions" href="<?php echo esc_url( 'https://www.google.com/maps?saddr=My+Location&daddr=' . rawurlencode( $lat . ',' . $lng ) ); ?>"><?php esc_html_e( 'Get Directions to', 'sekolahane' ); ?> <?php echo esc_html( $address ); ?></a>
                        </div>
                    </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

</article>
