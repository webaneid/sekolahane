<?php
/**
 * Template part: Social media links.
 *
 * @package sekolahane
 */

defined( 'ABSPATH' ) || exit;

if ( have_rows( 'sosmed_ane', 'option' ) ) :
	?>
<div class="ane-sosmed">
	<ul>
		<?php
		while ( have_rows( 'sosmed_ane', 'option' ) ) :
			the_row();
			$sekolahane_facebook  = (string) get_sub_field( 'sosmed_fb' );
			$sekolahane_whatsapp  = (string) preg_replace( '/[^0-9]/', '', (string) get_sub_field( 'sosmed_wa' ) );
			$sekolahane_instagram = (string) get_sub_field( 'sosmed_ig' );
			$sekolahane_twitter   = (string) get_sub_field( 'sosmed_tw' );
			$sekolahane_youtube   = (string) get_sub_field( 'sosmed_youtube' );

			if ( '' !== $sekolahane_whatsapp ) :
				?>
				<li><a class="whatsapp" href="<?php echo esc_url( 'https://wa.me/' . $sekolahane_whatsapp ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?php echo sekolahane_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
				<?php
			endif;
			if ( '' !== $sekolahane_facebook ) :
				?>
				<li><a class="facebook" href="<?php echo esc_url( $sekolahane_facebook ); ?>" aria-label="Facebook"><?php echo sekolahane_icon( 'facebook' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
				<?php
			endif;
			if ( '' !== $sekolahane_twitter ) :
				?>
				<li><a class="twitter" href="<?php echo esc_url( 'https://twitter.com/' . ltrim( $sekolahane_twitter, '@' ) ); ?>" target="_blank" rel="noopener" aria-label="Twitter"><?php echo sekolahane_icon( 'twitter' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
				<?php
			endif;
			if ( '' !== $sekolahane_youtube ) :
				?>
				<li><a class="youtube" href="<?php echo esc_url( $sekolahane_youtube ); ?>" aria-label="YouTube"><?php echo sekolahane_icon( 'youtube' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
				<?php
			endif;
			if ( '' !== $sekolahane_instagram ) :
				?>
				<li><a class="instagram" href="<?php echo esc_url( 'https://instagram.com/' . ltrim( $sekolahane_instagram, '@' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><?php echo sekolahane_icon( 'instagram' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></li>
			<?php endif; ?>
		<?php endwhile; ?>
	</ul>
</div>
<?php endif; ?>
