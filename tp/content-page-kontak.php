<article id="post-<?php the_ID(); ?>" <?php post_class('ane-page-kontak'); ?>>
	<header class="entry-header">
			<div class="ane-content">
				<div class="ane-title">
					<?php the_title( sprintf( '<h1 class="post-title general-title">', esc_url( get_permalink() ) ), '</h1>' ); ?>
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
									<h3><?php echo $namaperusahaan ?></h3>

									<?php if( have_rows('contact_ane','option') ): ?>
											<?php
												while( have_rows('contact_ane','option') ): the_row();
												$alamat = get_sub_field('kontak_alamat');
													if( !empty( $alamat ) ):
														echo '<p>'. $alamat .'</p>';
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
										<p>Telepon: <?= $Phone; ?></p>
										<?php
											endif;
											if( !empty( $mobile ) ):
										?>
										<p>Handphone: <?= $mobile; ?></p>
										<?php endif;
											if( !empty( $Email ) ):
										?>
										<p>Email: <?= $Email; ?></p>

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
						<h1><?php echo $title; ?></h1>
					</div>
					<?php endif;?>


					<?php
					if( have_rows('ane_cs','option') ): ?>
				  <ul>

					  <?php // Loop through rows.
					  while( have_rows('ane_cs','option') ) : the_row();
					  $wa = get_sub_field('ane_whatsapp');
					  ?>
					  <a href="https://wa.me/<?php echo $wa; ?>">
					  <li>
						  <?php
						  $image = get_sub_field('ane_image');
						  $nama = get_sub_field('ane_nama');
						  $area = get_sub_field('ane_area');

						  if( $image ):
							  $size = 'kotak';
							  $thumb = $image['sizes'][ $size ];
						 	if( !empty( $thumb ) ):
						  ?>
						  <img src="<?php echo $thumb; ?>" alt="<?php echo $nama; ?>">
					  	<?php endif; endif;?>
						  <a href="https://wa.me/<?php echo $wa; ?>">
						  <span><?php echo $nama; ?> </span><br/>
						  <?php echo $area; ?>
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
            if( !empty($location) ):
        ?>
        <div class="col-md-5">
            <div class="kontak-map">
                    <div class="acf-map">
                        <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                        <a class="directions" href="https://www.google.com/maps?saddr=My+Location&daddr=<?php echo $location['lat'] . ',' . $location['lng']; ?>"><?php _e('Get Directions to','roots'); ?> <?php echo $location['address']; ?></a> <!-- Output the title -->
                        </div>
                    </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

</article>
