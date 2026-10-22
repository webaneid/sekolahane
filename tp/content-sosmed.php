<?php
defined( 'ABSPATH' ) || exit;

if ( have_rows( 'sosmed_ane', 'option' ) ) :
	?>
<div class="ane-sosmed">
	<ul>
		<?php
		while ( have_rows( 'sosmed_ane', 'option' ) ) :
			the_row();
			$facebook  = (string) get_sub_field( 'sosmed_fb' );
			$whatsapp  = preg_replace( '/[^0-9]/', '', (string) get_sub_field( 'sosmed_wa' ) );
			$instagram = (string) get_sub_field( 'sosmed_ig' );
			$twitter   = (string) get_sub_field( 'sosmed_tw' );
			$youtube   = (string) get_sub_field( 'sosmed_youtube' );

			if ( '' !== $whatsapp ) :
				?>
				<li><a class="whatsapp" href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener"><i class="ane-whatsapp"></i></a></li>
				<?php
			endif;
			if ( '' !== $facebook ) :
				?>
				<li><a class="facebook" href="<?php echo esc_url( $facebook ); ?>"><i class="ane-facebook"></i></a></li>
				<?php
			endif;
			if ( '' !== $twitter ) :
				?>
				<li><a class="twitter" href="<?php echo esc_url( 'https://twitter.com/' . ltrim( $twitter, '@' ) ); ?>" target="_blank" rel="noopener"><i class="ane-twitter"></i></a></li>
				<?php
			endif;
			if ( '' !== $youtube ) :
				?>
				<li><a class="youtube" href="<?php echo esc_url( $youtube ); ?>"><i class="ane-youtube"></i></a></li>
				<?php
			endif;
			if ( '' !== $instagram ) :
				?>
				<li><a class="instagram" href="<?php echo esc_url( 'https://instagram.com/' . ltrim( $instagram, '@' ) ); ?>" target="_blank" rel="noopener"><i class="ane-instagram"></i></a></li>
			<?php endif; ?>
		<?php endwhile; ?>
	</ul>
</div>
<?php endif; ?>
