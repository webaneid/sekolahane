<?php
/**
 * GitHub Auto-Updater — Sekolah Ane.
 *
 * Mengecek rilis terbaru di repository GitHub privat, menampilkan notifikasi
 * update di wp-admin, serta menangani unduhan dan instalasi paket ZIP rilis.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'SEKOLAHANE_UPDATER_REPO' ) ) {
	define( 'SEKOLAHANE_UPDATER_REPO', 'webaneid/sekolahane' );
}

if ( ! defined( 'SEKOLAHANE_UPDATER_SLUG' ) ) {
	define( 'SEKOLAHANE_UPDATER_SLUG', 'sekolahane' );
}

/**
 * Ambil GitHub Personal Access Token untuk autentikasi rilis privat.
 *
 * Prioritas:
 * 1. Konstanta SEKOLAHANE_UPDATER_TOKEN di wp-config.php.
 * 2. Field ACF option `ane_updater_token`.
 *
 * @return string Token GitHub atau string kosong.
 */
function sekolahane_updater_get_token() {
	if ( defined( 'SEKOLAHANE_UPDATER_TOKEN' ) && is_string( SEKOLAHANE_UPDATER_TOKEN ) ) {
		$config_token = trim( SEKOLAHANE_UPDATER_TOKEN );
		if ( '' !== $config_token ) {
			return $config_token;
		}
	}

	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	return trim( (string) get_field( 'ane_updater_token', 'option' ) );
}

/**
 * Ambil versi theme yang sedang terpasang dari header style.css.
 *
 * @return string Versi theme.
 */
function sekolahane_updater_get_theme_version() {
	$theme   = wp_get_theme( SEKOLAHANE_UPDATER_SLUG );
	$version = $theme->get( 'Version' );

	return is_string( $version ) ? $version : '0.0.0';
}

/**
 * Ambil metadata rilis terbaru dari GitHub API (dengan cache transient 12 jam).
 *
 * @return array<string, string>|false Array data rilis atau false jika gagal/belum dikonfigurasi.
 */
function sekolahane_updater_get_release() {
	$cached = get_transient( 'sekolahane_github_release' );
	if ( false !== $cached ) {
		return is_array( $cached ) ? $cached : false;
	}

	$token = sekolahane_updater_get_token();
	if ( '' === $token ) {
		return false;
	}

	$url = 'https://api.github.com/repos/' . SEKOLAHANE_UPDATER_REPO . '/releases/latest';

	$response = wp_remote_get(
		$url,
		array(
			'headers' => array(
				'Authorization' => 'token ' . $token,
				'Accept'        => 'application/vnd.github.v3+json',
				'User-Agent'    => 'Sekolahane-Updater',
			),
			'timeout' => 15,
		)
	);

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		set_transient( 'sekolahane_github_release', 'error', HOUR_IN_SECONDS );
		return false;
	}

	$body = json_decode( wp_remote_retrieve_body( $response ) );
	if ( ! is_object( $body ) || empty( $body->tag_name ) ) {
		return false;
	}

	// Cari asset .zip dari rilis (gunakan API URL agar kompatibel dengan repo privat).
	$asset_url = '';
	if ( ! empty( $body->assets ) && is_array( $body->assets ) ) {
		foreach ( $body->assets as $asset ) {
			if ( is_object( $asset ) && ! empty( $asset->name ) && ! empty( $asset->url ) ) {
				if ( '.zip' === substr( (string) $asset->name, -4 ) ) {
					$asset_url = (string) $asset->url;
					break;
				}
			}
		}
	}

	// Jangan fallback ke zipball (nama folder tidak sesuai slug + isu autentikasi).
	if ( '' === $asset_url ) {
		return false;
	}

	$release = array(
		'version'   => ltrim( (string) $body->tag_name, 'vV' ),
		'tag'       => (string) $body->tag_name,
		'url'       => isset( $body->html_url ) ? (string) $body->html_url : '',
		'package'   => $asset_url,
		'body'      => isset( $body->body ) ? (string) $body->body : '',
		'published' => isset( $body->published_at ) ? (string) $body->published_at : '',
	);

	set_transient( 'sekolahane_github_release', $release, 12 * HOUR_IN_SECONDS );

	return $release;
}

/**
 * Suntikkan informasi update ke transient `update_themes` WordPress.
 *
 * @param object $transient Objek transient update_themes.
 * @return object Objek transient yang sudah diperbarui.
 */
function sekolahane_updater_check( $transient ) {
	if ( ! is_object( $transient ) || empty( $transient->checked ) ) {
		return $transient;
	}

	$release = sekolahane_updater_get_release();
	if ( ! is_array( $release ) ) {
		return $transient;
	}

	$current_version = sekolahane_updater_get_theme_version();

	if ( version_compare( $release['version'], $current_version, '>' ) ) {
		if ( ! isset( $transient->response ) || ! is_array( $transient->response ) ) {
			$transient->response = array();
		}

		$transient->response[ SEKOLAHANE_UPDATER_SLUG ] = array(
			'theme'       => SEKOLAHANE_UPDATER_SLUG,
			'new_version' => $release['version'],
			'url'         => $release['url'],
			'package'     => $release['package'],
		);
	}

	return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'sekolahane_updater_check' );

/**
 * Sediakan detail informasi theme & changelog pada popup wp-admin.
 *
 * @param false|object|array<string, mixed> $result Nilai hasil default.
 * @param string                            $action Nama aksi themes_api.
 * @param object                            $args   Argumen request.
 * @return false|object|array<string, mixed>
 */
function sekolahane_updater_info( $result, $action, $args ) {
	if ( 'theme_information' !== $action || ! is_object( $args ) || ! isset( $args->slug ) || SEKOLAHANE_UPDATER_SLUG !== $args->slug ) {
		return $result;
	}

	$release = sekolahane_updater_get_release();
	if ( ! is_array( $release ) ) {
		return $result;
	}

	$theme = wp_get_theme( SEKOLAHANE_UPDATER_SLUG );

	return (object) array(
		'name'          => $theme->get( 'Name' ),
		'slug'          => SEKOLAHANE_UPDATER_SLUG,
		'version'       => $release['version'],
		'author'        => $theme->get( 'Author' ),
		'homepage'      => $theme->get( 'ThemeURI' ),
		'requires'      => '6.0',
		'tested'        => '6.7',
		'requires_php'  => '7.4',
		'downloaded'    => 0,
		'last_updated'  => $release['published'],
		'sections'      => array(
			'description' => (string) $theme->get( 'Description' ),
			'changelog'   => nl2br( esc_html( $release['body'] ) ),
		),
		'download_link' => $release['package'],
	);
}
add_filter( 'themes_api', 'sekolahane_updater_info', 20, 3 );

/**
 * Sisipkan header Authorization khusus untuk unduhan asset rilis repo ini.
 *
 * @param array<string, mixed> $args Argumen HTTP request.
 * @param string               $url  URL tujuan request.
 * @return array<string, mixed>
 */
function sekolahane_updater_auth_header( $args, $url ) {
	$is_api    = false !== strpos( $url, 'api.github.com/repos/' . SEKOLAHANE_UPDATER_REPO . '/' );
	$is_github = false !== strpos( $url, 'github.com/' . SEKOLAHANE_UPDATER_REPO . '/' );

	if ( ! $is_api && ! $is_github ) {
		return $args;
	}

	$token = sekolahane_updater_get_token();
	if ( '' === $token ) {
		return $args;
	}

	if ( ! isset( $args['headers'] ) || ! is_array( $args['headers'] ) ) {
		$args['headers'] = array();
	}

	$args['headers']['Authorization'] = 'token ' . $token;

	// Unduhan asset via API GitHub wajib memakai Accept: application/octet-stream.
	if ( $is_api && false !== strpos( $url, '/releases/assets/' ) ) {
		$args['headers']['Accept'] = 'application/octet-stream';
	}

	return $args;
}
add_filter( 'http_request_args', 'sekolahane_updater_auth_header', 10, 2 );

/**
 * Pastikan nama folder hasil ekstraksi ZIP sesuai dengan slug theme.
 *
 * @param string               $source        Path folder sumber yang diekstrak.
 * @param string               $remote_source Path direktori sementara.
 * @param WP_Upgrader          $upgrader      Instance upgrader WordPress.
 * @param array<string, mixed> $hook_extra    Konteks ekstra proses upgrade.
 * @return string|WP_Error
 */
function sekolahane_updater_rename_source( $source, $remote_source, $upgrader, $hook_extra ) {
	global $wp_filesystem;

	if ( ! isset( $hook_extra['theme'] ) || SEKOLAHANE_UPDATER_SLUG !== $hook_extra['theme'] ) {
		return $source;
	}

	$correct_dir = trailingslashit( $remote_source ) . SEKOLAHANE_UPDATER_SLUG;

	if ( trailingslashit( $source ) === trailingslashit( $correct_dir ) ) {
		return $source;
	}

	if ( is_object( $wp_filesystem ) && method_exists( $wp_filesystem, 'move' ) ) {
		$moved = $wp_filesystem->move( $source, $correct_dir, true );
		if ( $moved ) {
			return trailingslashit( $correct_dir );
		}
	}

	return new WP_Error(
		'sekolahane_rename_failed',
		__( 'Gagal menyesuaikan nama folder theme saat update.', 'sekolahane' )
	);
}
add_filter( 'upgrader_source_selection', 'sekolahane_updater_rename_source', 10, 4 );

/**
 * Bersihkan transient rilis setelah proses update theme selesai.
 *
 * @param WP_Upgrader          $upgrader Instance upgrader.
 * @param array<string, mixed> $options  Opsi proses upgrade.
 * @return void
 */
function sekolahane_updater_clear_cache( $upgrader, $options ) {
	if ( isset( $options['action'], $options['type'] ) && 'update' === $options['action'] && 'theme' === $options['type'] ) {
		delete_transient( 'sekolahane_github_release' );
	}
}
add_action( 'upgrader_process_complete', 'sekolahane_updater_clear_cache', 10, 2 );

/**
 * Daftarkan tab dan field Auto Update pada halaman ACF Options theme.
 *
 * @return void
 */
function sekolahane_register_updater_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$version        = sekolahane_updater_get_theme_version();
	$release        = get_transient( 'sekolahane_github_release' );
	$changelog_html = '';

	if ( is_array( $release ) && ! empty( $release['version'] ) ) {
		$status = version_compare( $release['version'], $version, '>' )
			? '<span style="color:#e65100;font-weight:700;">' . sprintf(
				/* translators: %s: nomor versi terbaru */
				esc_html__( 'Update tersedia: v%s', 'sekolahane' ),
				esc_html( $release['version'] )
			) . '</span>'
			: '<span style="color:#264113;">' . esc_html__( 'Sudah versi terbaru.', 'sekolahane' ) . '</span>';

		$changelog_html = '<br><br><strong>' . esc_html__( 'Status:', 'sekolahane' ) . '</strong> ' . $status;

		if ( ! empty( $release['body'] ) ) {
			$changelog_html .= '<br><br><strong>' . sprintf(
				/* translators: %s: nomor versi rilis */
				esc_html__( 'Changelog (v%s):', 'sekolahane' ),
				esc_html( $release['version'] )
			) . '</strong><br>'
				. '<div style="background:#f7f7f7;border:1px solid #ddd;border-radius:8px;padding:12px 16px;margin-top:6px;font-size:13px;line-height:1.6;">'
				. nl2br( esc_html( $release['body'] ) )
				. '</div>';
		}
	}

	$force_url = wp_nonce_url(
		admin_url( 'themes.php?sekolahane_force_check=1' ),
		'sekolahane_updater_action'
	);

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sekolahane_updater',
			'title'                 => __( 'Auto Update', 'sekolahane' ),
			'fields'                => array(
				array(
					'key'       => 'field_sekolahane_updater_tab',
					'label'     => __( 'Update', 'sekolahane' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'     => 'field_sekolahane_updater_info',
					'label'   => __( 'Informasi', 'sekolahane' ),
					'type'    => 'message',
					'message' => sprintf(
						'<strong>%s</strong> %s<br><strong>%s</strong> %s (private)<br><br>%s',
						esc_html__( 'Versi saat ini:', 'sekolahane' ),
						esc_html( $version ),
						esc_html__( 'Repo:', 'sekolahane' ),
						esc_html( SEKOLAHANE_UPDATER_REPO ),
						esc_html__( 'Theme otomatis mengecek update dari GitHub setiap 12 jam. Jika ada versi baru, notifikasi akan muncul di Appearance → Themes.', 'sekolahane' )
					) . $changelog_html
					. '<br><br><a href="' . esc_url( $force_url ) . '" class="button button-secondary">' . esc_html__( 'Cek Update Sekarang', 'sekolahane' ) . '</a>',
				),
				array(
					'key'          => 'field_sekolahane_updater_token',
					'label'        => __( 'GitHub Personal Access Token', 'sekolahane' ),
					'name'         => 'ane_updater_token',
					'type'         => 'password',
					'instructions' => sprintf(
						/* translators: %s: nama repository GitHub */
						__( 'Buat Fine-grained Token di GitHub Settings dengan permission Contents: Read-only pada repo %s, atau definisikan konstanta SEKOLAHANE_UPDATER_TOKEN di wp-config.php.', 'sekolahane' ),
						'<code>' . esc_html( SEKOLAHANE_UPDATER_REPO ) . '</code>'
					),
					'placeholder'  => 'github_pat_xxxxx',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'webane-theme-general-settings',
					),
				),
			),
			'menu_order'            => 99,
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
		)
	);
}
add_action( 'acf/init', 'sekolahane_register_updater_fields' );

/**
 * Tangani permintaan "Cek Update Sekarang" (dengan verifikasi capability & nonce).
 *
 * @return void
 */
function sekolahane_updater_force_check_handler() {
	if ( ! isset( $_GET['sekolahane_force_check'] ) ) {
		return;
	}

	if ( ! current_user_can( 'update_themes' ) ) {
		return;
	}

	check_admin_referer( 'sekolahane_updater_action' );

	delete_transient( 'sekolahane_github_release' );
	delete_site_transient( 'update_themes' );

	add_action( 'admin_notices', 'sekolahane_updater_force_check_notice' );
}
add_action( 'admin_init', 'sekolahane_updater_force_check_handler' );

/**
 * Tampilkan admin notice setelah cache update dibersihkan.
 *
 * @return void
 */
function sekolahane_updater_force_check_notice() {
	?>
	<div class="notice notice-success is-dismissible">
		<p><?php esc_html_e( 'Pengecekan update selesai. Cache update telah diperbarui.', 'sekolahane' ); ?></p>
	</div>
	<?php
}
