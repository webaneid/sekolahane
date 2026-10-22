<?php
	get_template_part ('tp/mobile/menu-footer');
	$nama = get_field('nama_organisasi', 'option');
?>
<footer id="footer" class="ane-footer">
	<div class="atas">
		<div class="container">
			<div class="row justify-content-center">
				<?php if( have_rows('about_ane','option') ): ?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-12">
					<div class="isi">
						<?php while( have_rows('about_ane','option') ): the_row();
							$judul = get_sub_field('company_name');
							$sologan = get_sub_field('company_sologan');
							$about = get_sub_field('company_about');
						?>
						<div class="footer-content">
							<h3><?php echo $judul ?></h3>
							<h4><?php echo $sologan ?></h4>
							<p><?php echo $about ?></p>
						</div>
						<?php endwhile; ?>
					</div>
				</div> <!--- end col-md-4 -->
				<?php endif; ?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-12">
					<div class="isi-v2">
						<h3>Link Penting</h3>
						<?php
								wp_nav_menu(  array(
								'theme_location' => 'menufooter',
								'container'      => 'div',
								'fallback_cb'    => 'wp_page_menu',
								'depth'          => 4,
								)
								);
						?>
					</div>
				</div><!--- end col-md-4 -->
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 col-12">
					<div class="isi-v2">
						<h3>Hubungi Kami</h3>
						<?php if( have_rows('contact_ane','option') ): ?>
							<div class="footer-kontak">
								<ul>
									<?php
									while( have_rows('contact_ane','option') ): the_row();
									$alamat = get_sub_field('kontak_alamat');
									$Phone = get_sub_field('kontak_telepon');
									$mobile = get_sub_field('kontak_handphone');
									$Email = get_sub_field('kontak_email');
									$Web = get_sub_field('kontak_website');

										if( !empty( $alamat ) ):
									?>
									<li><i class="ane-lokasi"></i> <?php
									echo $alamat; ?></li>
									<?php
										endif;
										if( !empty( $Phone ) ):
									?>
									<li><i class="ane-telepon"></i> <?= $Phone; ?></li>
									<?php
										endif;
										if( !empty( $mobile ) ):
									?>
									<li><i class="ane-handphone"></i> <?= $mobile; ?></li>
									<?php endif;
										if( !empty( $Email ) ):
									?>
									<li><i class="ane-email"></i> <?= $Email; ?></li>
									<?php endif;
										$url = home_url( $path = '/' );
										if( !empty( $Web ) ):
									?>
									<li><a href="<?= $url ?>" alt="<?= $Web; ?>" title="<?= $Web; ?>"> <i class="ane-laptop"></i> <?= $Web; ?></a></li>

									<?php endif; ?>
								</ul>
							<?php endwhile; ?>
							</div>

					<?php endif;
					get_template_part('tp/content','sosmed');
					?>
					</div>

				</div>
			</div>
		</div>

	</div>
	<div class="bawah">
		<div class="container">
			<div class="isi">
				Copyright <?php echo webane_load_dynamic_copyright_year() . " " . $judul. " " . webane_load_designed_by(); ?>
			</div>
		</div>
	</div>

</footer>
<div class="cc-contactpop fixed">
	<header class="kelapa">
		<?php
		$title = get_field('ane_cs_label', 'option');
		if(!empty($title)):
		?>
			<h3><span class="fa fa-whatsapp" aria-hidden="true"></span> <?php echo $title; ?></h3>
		<?php endif;?>
	</header>

	<div class="renseignement">
	  <i class="fa fa-times"></i>
	  <?php
	  $msg = get_field('ane_cs_welcome', 'option');
	  if(!empty($msg)):
	  ?>
	  <p><?php echo $msg ?></p>
		<?php
		endif;
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

</div>

</div> <!--- webane-wrapper -->
<?php wp_footer(); ?>
</body>
</html>
