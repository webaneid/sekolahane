<?php
/**
 * Mesin SEO Premium Hybrid (Yoast Booster & Standalone Engine), Schema.org JSON-LD
 * untuk Google Sitelinks & Rich Results, Konversi Tag ke Keywords, serta
 * Generative Engine Optimization (GEO /llms.txt).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

/**
 * Periksa apakah plugin Yoast SEO sedang aktif.
 *
 * @return bool
 */
function sekolahane_is_yoast_active() {
	return defined( 'WPSEO_VERSION' ) || class_exists( 'WPSEO_Options' );
}

/**
 * Normalisasi nomor telepon/WhatsApp ke format internasional (+62...).
 *
 * @param string $raw Nomor mentah.
 * @return string Nomor terformat atau string kosong.
 */
function sekolahane_seo_normalize_phone( $raw ) {
	$digits = (string) preg_replace( '/[^0-9]/', '', $raw );
	if ( '' === $digits ) {
		return '';
	}
	if ( '0' === substr( $digits, 0, 1 ) ) {
		$digits = '62' . substr( $digits, 1 );
	}
	return '+' . $digits;
}

/**
 * Kumpulkan profil lengkap lembaga/sekolah dari ACF Options & pengaturan WordPress
 * (di-cache di memori statis per request agar 0 query berulang).
 *
 * @return array<string, mixed>
 */
function sekolahane_get_school_profile() {
	static $profile = null;
	if ( is_array( $profile ) ) {
		return $profile;
	}

	$site_name = trim( wp_strip_all_tags( (string) get_bloginfo( 'name' ) ) );
	$tagline   = trim( wp_strip_all_tags( (string) get_bloginfo( 'description' ) ) );
	$home_url  = home_url( '/' );

	$org_name = '';
	$slogan   = $tagline;
	$about    = '';
	$address  = '';
	$phone    = '';
	$mobile   = '';
	$email    = '';
	$lat      = '';
	$lng      = '';
	$ppdb_url = '';
	$socials  = array();
	$cs_list  = array();

	if ( function_exists( 'get_field' ) ) {
		$com_name = trim( wp_strip_all_tags( (string) get_field( 'ane_com_name', 'option' ) ) );
		$org_opt  = trim( wp_strip_all_tags( (string) get_field( 'nama_organisasi', 'option' ) ) );
		if ( '' !== $com_name ) {
			$org_name = $com_name;
		} elseif ( '' !== $org_opt ) {
			$org_name = $org_opt;
		}

		$about_rows = get_field( 'about_ane', 'option' );
		if ( is_array( $about_rows ) && ! empty( $about_rows[0] ) && is_array( $about_rows[0] ) ) {
			$first_about = $about_rows[0];
			if ( '' === $org_name && ! empty( $first_about['company_name'] ) ) {
				$org_name = trim( wp_strip_all_tags( (string) $first_about['company_name'] ) );
			}
			if ( ! empty( $first_about['company_sologan'] ) ) {
				$slogan = trim( wp_strip_all_tags( (string) $first_about['company_sologan'] ) );
			}
			if ( ! empty( $first_about['company_about'] ) ) {
				$about = trim( wp_strip_all_tags( (string) $first_about['company_about'] ) );
			}
		}

		$address = trim( wp_strip_all_tags( (string) get_field( 'ane_Option_alamat', 'option' ) ) );
		$phone   = trim( wp_strip_all_tags( (string) get_field( 'ane_telepon', 'option' ) ) );
		$mobile  = trim( wp_strip_all_tags( (string) get_field( 'ane_handphone', 'option' ) ) );
		$email   = sanitize_email( (string) get_field( 'ane_email', 'option' ) );

		$contact_rows = get_field( 'contact_ane', 'option' );
		if ( is_array( $contact_rows ) && ! empty( $contact_rows[0] ) && is_array( $contact_rows[0] ) ) {
			$first_contact = $contact_rows[0];
			if ( '' === $address && ! empty( $first_contact['kontak_alamat'] ) ) {
				$address = trim( wp_strip_all_tags( (string) $first_contact['kontak_alamat'] ) );
			}
			if ( '' === $phone && ! empty( $first_contact['kontak_telepon'] ) ) {
				$phone = trim( wp_strip_all_tags( (string) $first_contact['kontak_telepon'] ) );
			}
			if ( '' === $mobile && ! empty( $first_contact['kontak_handphone'] ) ) {
				$mobile = trim( wp_strip_all_tags( (string) $first_contact['kontak_handphone'] ) );
			}
			if ( '' === $email && ! empty( $first_contact['kontak_email'] ) ) {
				$email = sanitize_email( (string) $first_contact['kontak_email'] );
			}
		}

		$gmap = get_field( 'ane_gmap', 'option' );
		if ( is_array( $gmap ) && ! empty( $gmap['lat'] ) && ! empty( $gmap['lng'] ) ) {
			$lat = (string) $gmap['lat'];
			$lng = (string) $gmap['lng'];
		}

		$header_link = get_field( 'ane_link_header', 'option' );
		if ( is_array( $header_link ) && ! empty( $header_link['url'] ) ) {
			$ppdb_url = esc_url_raw( (string) $header_link['url'] );
		}

		$sosmed_rows = get_field( 'sosmed_ane', 'option' );
		if ( is_array( $sosmed_rows ) ) {
			foreach ( $sosmed_rows as $s_row ) {
				if ( ! is_array( $s_row ) ) {
					continue;
				}
				if ( ! empty( $s_row['sosmed_fb'] ) ) {
					$socials[] = esc_url_raw( (string) $s_row['sosmed_fb'] );
				}
				if ( ! empty( $s_row['sosmed_youtube'] ) ) {
					$socials[] = esc_url_raw( (string) $s_row['sosmed_youtube'] );
				}
				if ( ! empty( $s_row['sosmed_ig'] ) ) {
					$ig        = ltrim( trim( (string) $s_row['sosmed_ig'] ), '@' );
					$socials[] = ( 0 === strpos( $ig, 'http' ) ) ? esc_url_raw( $ig ) : 'https://instagram.com/' . rawurlencode( $ig );
				}
				if ( ! empty( $s_row['sosmed_tw'] ) ) {
					$tw        = ltrim( trim( (string) $s_row['sosmed_tw'] ), '@' );
					$socials[] = ( 0 === strpos( $tw, 'http' ) ) ? esc_url_raw( $tw ) : 'https://twitter.com/' . rawurlencode( $tw );
				}
				if ( '' === $mobile && ! empty( $s_row['sosmed_wa'] ) ) {
					$mobile = trim( wp_strip_all_tags( (string) $s_row['sosmed_wa'] ) );
				}
			}
		}

		$cs_rows = get_field( 'ane_cs', 'option' );
		if ( is_array( $cs_rows ) ) {
			foreach ( $cs_rows as $cs_item ) {
				if ( ! is_array( $cs_item ) ) {
					continue;
				}
				$cs_name = isset( $cs_item['ane_cs_nama'] ) ? trim( wp_strip_all_tags( (string) $cs_item['ane_cs_nama'] ) ) : '';
				$cs_area = isset( $cs_item['ane_cs_area'] ) ? trim( wp_strip_all_tags( (string) $cs_item['ane_cs_area'] ) ) : '';
				$cs_wa   = isset( $cs_item['ane_cs_wa'] ) ? sekolahane_seo_normalize_phone( (string) $cs_item['ane_cs_wa'] ) : '';
				if ( '' !== $cs_wa ) {
					$cs_list[] = array(
						'name'  => $cs_name,
						'role'  => $cs_area,
						'phone' => $cs_wa,
					);
				}
			}
		}
	}

	if ( '' === $org_name ) {
		$org_name = $site_name;
	}

	$logo_url      = (string) get_theme_mod( 'logo', get_template_directory_uri() . '/img/logo-sekolahane.png' );
	$custom_logo   = (int) get_theme_mod( 'custom_logo' );
	$custom_logo_a = $custom_logo > 0 ? wp_get_attachment_image_src( $custom_logo, 'full' ) : false;
	if ( is_array( $custom_logo_a ) && ! empty( $custom_logo_a[0] ) ) {
		$logo_url = (string) $custom_logo_a[0];
	}

	$profile = array(
		'site_name' => $site_name,
		'org_name'  => $org_name,
		'slogan'    => $slogan,
		'about'     => $about,
		'address'   => $address,
		'phone'     => $phone,
		'mobile'    => $mobile,
		'email'     => $email,
		'lat'       => $lat,
		'lng'       => $lng,
		'ppdb_url'  => $ppdb_url,
		'logo_url'  => $logo_url,
		'home_url'  => $home_url,
		'socials'   => array_values( array_unique( array_filter( $socials ) ) ),
		'cs_list'   => $cs_list,
	);

	return $profile;
}

/**
 * Potong teks dengan rapi pada batas kata maksimal panjang tertentu.
 *
 * @param string $text       Teks sumber.
 * @param int    $max_length Panjang karakter maksimum.
 * @return string
 */
function sekolahane_seo_trim_description( $text, $max_length = 158 ) {
	$clean = trim( (string) preg_replace( '/\s+/', ' ', wp_strip_all_tags( strip_shortcodes( $text ) ) ) );
	if ( '' === $clean ) {
		return '';
	}
	if ( strlen( $clean ) <= $max_length ) {
		return $clean;
	}
	$cut   = substr( $clean, 0, $max_length );
	$space = strrpos( $cut, ' ' );
	if ( false !== $space && $space > 80 ) {
		$cut = substr( $cut, 0, $space );
	}
	return rtrim( $cut, '.,;:- ' ) . '...';
}

/**
 * Hasilkan Meta Description cerdas otomatis untuk halaman aktif jika meta Yoast kosong.
 *
 * @return string
 */
function sekolahane_generate_smart_description() {
	$profile  = sekolahane_get_school_profile();
	$org_name = (string) $profile['org_name'];
	$slogan   = (string) $profile['slogan'];
	$about    = (string) $profile['about'];
	$address  = (string) $profile['address'];

	if ( is_front_page() || is_home() ) {
		$parts = array();
		if ( '' !== $org_name ) {
			$parts[] = $org_name;
		}
		if ( '' !== $slogan ) {
			$parts[] = $slogan;
		}
		if ( '' !== $about ) {
			$parts[] = $about;
		} elseif ( '' !== $address ) {
			$parts[] = 'Alamat: ' . $address;
		}
		return sekolahane_seo_trim_description( implode( ' — ', $parts ), 158 );
	}

	if ( is_singular() ) {
		$post_id = (int) get_queried_object_id();
		$post    = get_post( $post_id );
		if ( ! $post instanceof WP_Post ) {
			return '';
		}

		$post_type = $post->post_type;
		$title     = trim( wp_strip_all_tags( get_the_title( $post ) ) );
		$raw_body  = '' !== trim( $post->post_excerpt ) ? $post->post_excerpt : $post->post_content;

		if ( 'guru' === $post_type ) {
			$jabatan   = function_exists( 'get_field' ) ? trim( wp_strip_all_tags( (string) get_field( 'ane_jabatan', $post_id ) ) ) : '';
			$pelajaran = get_the_terms( $post_id, 'pelajaran' );
			$mapel_arr = is_array( $pelajaran ) ? wp_list_pluck( $pelajaran, 'name' ) : array();
			$mapel_str = ! empty( $mapel_arr ) ? implode( ', ', $mapel_arr ) : '';

			$desc = 'Profil ' . $title;
			if ( '' !== $jabatan ) {
				$desc .= ' (' . $jabatan . ')';
			}
			if ( '' !== $mapel_str ) {
				$desc .= ', pengajar ' . $mapel_str;
			}
			if ( '' !== $org_name ) {
				$desc .= ' di ' . $org_name . '. ';
			} else {
				$desc .= '. ';
			}
			$desc .= wp_strip_all_tags( strip_shortcodes( $raw_body ) );
			return sekolahane_seo_trim_description( $desc, 158 );
		}

		if ( 'ekstrakurikuler' === $post_type ) {
			$desc = 'Kegiatan Ekstrakurikuler ' . $title . ' di ' . $org_name . '. ' . wp_strip_all_tags( strip_shortcodes( $raw_body ) );
			return sekolahane_seo_trim_description( $desc, 158 );
		}

		if ( is_page_template( 'page-kontak.php' ) ) {
			$desc = 'Hubungi ' . $org_name;
			if ( '' !== $address ) {
				$desc .= ' — Alamat: ' . $address . '.';
			}
			if ( '' !== (string) $profile['phone'] || '' !== (string) $profile['mobile'] ) {
				$desc .= ' Informasi layanan telepon, WhatsApp Customer Care, dan peta lokasi resmi.';
			}
			return sekolahane_seo_trim_description( $desc, 158 );
		}

		$trimmed = sekolahane_seo_trim_description( $raw_body, 158 );
		if ( '' !== $trimmed ) {
			return $trimmed;
		}

		return sekolahane_seo_trim_description( $title . ' — ' . $org_name . ( '' !== $slogan ? ' (' . $slogan . ')' : '' ), 158 );
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			if ( '' !== trim( $term->description ) ) {
				return sekolahane_seo_trim_description( $term->description, 158 );
			}
			return sekolahane_seo_trim_description( 'Kumpulan artikel dan informasi mengenai ' . $term->name . ' di ' . $org_name . '.', 158 );
		}
	}

	if ( is_post_type_archive() ) {
		$pt_obj = get_queried_object();
		if ( is_object( $pt_obj ) && isset( $pt_obj->labels->name ) ) {
			return sekolahane_seo_trim_description( 'Daftar ' . $pt_obj->labels->name . ' resmi di ' . $org_name . '.', 158 );
		}
	}

	return sekolahane_seo_trim_description( $org_name . ' — ' . $slogan, 158 );
}

/**
 * Ambil URL gambar terbaik untuk OpenGraph / Twitter Card / Schema pada halaman aktif.
 *
 * @return string
 */
function sekolahane_get_seo_image_url() {
	if ( is_singular() ) {
		$post_id = (int) get_queried_object_id();
		if ( $post_id > 0 && has_post_thumbnail( $post_id ) ) {
			$img = wp_get_attachment_image_src( (int) get_post_thumbnail_id( $post_id ), 'large' );
			if ( is_array( $img ) && ! empty( $img[0] ) ) {
				return (string) $img[0];
			}
		}
	}

	$profile = sekolahane_get_school_profile();
	return (string) $profile['logo_url'];
}

/**
 * Kumpulkan daftar kata kunci (keywords) dari Focus Keyphrase Yoast,
 * Post Tags (`post_tag`), Kategori (`category`), dan Taxonomy Guru (`pelajaran`, `Kelas`).
 *
 * @param int $post_id ID post (opsional, 0 untuk otomatis deteksi).
 * @return array<int, string>
 */
function sekolahane_get_current_keywords( $post_id = 0 ) {
	$profile  = sekolahane_get_school_profile();
	$keywords = array();

	if ( $post_id <= 0 && is_singular() ) {
		$post_id = (int) get_queried_object_id();
	}

	if ( $post_id > 0 ) {
		// 1. Focus keyphrase dari Yoast SEO (jika diisi admin).
		$yoast_kw = trim( wp_strip_all_tags( (string) get_post_meta( $post_id, '_yoast_wpseo_focuskw', true ) ) );
		if ( '' !== $yoast_kw ) {
			$keywords[] = $yoast_kw;
		}

		// 2. Post Tags (post_tag) dijadikan keyword utama.
		$tags = get_the_tags( $post_id );
		if ( is_array( $tags ) ) {
			foreach ( $tags as $tag ) {
				if ( $tag instanceof WP_Term && '' !== trim( $tag->name ) ) {
					$keywords[] = trim( $tag->name );
				}
			}
		}

		// 3. Kategori post.
		$cats = get_the_category( $post_id );
		if ( is_array( $cats ) ) {
			foreach ( $cats as $cat ) {
				if ( $cat instanceof WP_Term && 'Uncategorized' !== $cat->name && 'Tak Berkategori' !== $cat->name ) {
					$keywords[] = trim( $cat->name );
				}
			}
		}

		// 4. Taxonomy Guru (pelajaran & Kelas).
		$post_type = get_post_type( $post_id );
		if ( 'guru' === $post_type ) {
			$jabatan = function_exists( 'get_field' ) ? trim( wp_strip_all_tags( (string) get_field( 'ane_jabatan', $post_id ) ) ) : '';
			if ( '' !== $jabatan ) {
				$keywords[] = $jabatan;
			}
			$mapels = get_the_terms( $post_id, 'pelajaran' );
			if ( is_array( $mapels ) ) {
				foreach ( $mapels as $m ) {
					if ( $m instanceof WP_Term ) {
						$keywords[] = trim( $m->name );
					}
				}
			}
			$kelases = get_the_terms( $post_id, 'Kelas' );
			if ( is_array( $kelases ) ) {
				foreach ( $kelases as $k ) {
					if ( $k instanceof WP_Term ) {
						$keywords[] = trim( $k->name );
					}
				}
			}
		} elseif ( 'ekstrakurikuler' === $post_type ) {
			$keywords[] = 'Ekstrakurikuler ' . trim( wp_strip_all_tags( get_the_title( $post_id ) ) );
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$keywords[] = trim( $term->name );
		}
	}

	if ( '' !== (string) $profile['org_name'] ) {
		$keywords[] = (string) $profile['org_name'];
	}
	if ( '' !== (string) $profile['site_name'] && $profile['site_name'] !== $profile['org_name'] ) {
		$keywords[] = (string) $profile['site_name'];
	}

	$clean_list = array();
	$seen       = array();
	foreach ( $keywords as $kw ) {
		$kw_clean = trim( wp_strip_all_tags( (string) $kw ) );
		$kw_lower = strtolower( $kw_clean );
		if ( '' !== $kw_clean && ! isset( $seen[ $kw_lower ] ) ) {
			$seen[ $kw_lower ] = true;
			$clean_list[]      = $kw_clean;
		}
	}

	return $clean_list;
}

/**
 * Filter Yoast SEO: Isi otomatis Meta Description, OG Description, & Twitter Description
 * jika admin tidak mengisinya secara manual di editor Yoast.
 *
 * @param string $desc Deskripsi dari Yoast.
 * @return string
 */
function sekolahane_yoast_fallback_description( $desc ) {
	if ( is_string( $desc ) && '' !== trim( $desc ) ) {
		return $desc;
	}
	return sekolahane_generate_smart_description();
}
add_filter( 'wpseo_metadesc', 'sekolahane_yoast_fallback_description', 20 );
add_filter( 'wpseo_opengraph_desc', 'sekolahane_yoast_fallback_description', 20 );
add_filter( 'wpseo_twitter_description', 'sekolahane_yoast_fallback_description', 20 );

/**
 * Filter Yoast SEO: Fallback otomatis gambar OpenGraph ke featured image / logo sekolah.
 *
 * @param string $image URL gambar OG dari Yoast.
 * @return string
 */
function sekolahane_yoast_fallback_og_image( $image ) {
	if ( is_string( $image ) && '' !== trim( $image ) ) {
		return $image;
	}
	return sekolahane_get_seo_image_url();
}
add_filter( 'wpseo_opengraph_image', 'sekolahane_yoast_fallback_og_image', 20 );
add_filter( 'wpseo_twitter_image', 'sekolahane_yoast_fallback_og_image', 20 );

/**
 * Pastikan direktif robots mengizinkan cuplikan penuh & preview gambar besar
 * untuk mendukung Google Discover & AI Overviews (GEO).
 *
 * @param array<string, bool|string> $robots Direktif robots WordPress.
 * @return array<string, bool|string>
 */
function sekolahane_seo_robots_directives( $robots ) {
	if ( ! is_array( $robots ) ) {
		$robots = array();
	}
	if ( empty( $robots['noindex'] ) ) {
		$robots['max-snippet']       = '-1';
		$robots['max-image-preview'] = 'large';
		$robots['max-video-preview'] = '-1';
	}
	return $robots;
}
add_filter( 'wp_robots', 'sekolahane_seo_robots_directives', 20 );

/**
 * Ambil daftar item navigasi utama (`menuutama`) untuk Schema `SiteNavigationElement`
 * (sinyal eksplisit Google Sitelinks seperti tampilan indeks Webane Indonesia) dan `/llms.txt`.
 *
 * @return array<int, array{name: string, url: string}>
 */
function sekolahane_get_sitelinks_navigation() {
	$items     = array();
	$locations = get_nav_menu_locations();

	if ( is_array( $locations ) && ! empty( $locations['menuutama'] ) ) {
		$menu_items = wp_get_nav_menu_items( (int) $locations['menuutama'] );
		if ( is_array( $menu_items ) ) {
			foreach ( $menu_items as $item ) {
				if ( ! is_object( $item ) || empty( $item->url ) || empty( $item->title ) ) {
					continue;
				}
				// Ambil menu level utama (parent = 0) agar Sitelinks fokus pada halaman pilar.
				if ( isset( $item->menu_item_parent ) && 0 !== (int) $item->menu_item_parent ) {
					continue;
				}
				$url   = trim( (string) $item->url );
				$title = trim( wp_strip_all_tags( (string) $item->title ) );
				if ( '' === $title || '' === $url || '#' === $url ) {
					continue;
				}
				$items[] = array(
					'name' => $title,
					'url'  => $url,
				);
			}
		}
	}

	if ( empty( $items ) ) {
		$pages = get_pages(
			array(
				'parent'      => 0,
				'number'      => 8,
				'sort_column' => 'menu_order,post_title',
			)
		);
		if ( is_array( $pages ) ) {
			foreach ( $pages as $p ) {
				if ( $p instanceof WP_Post ) {
					$items[] = array(
						'name' => trim( wp_strip_all_tags( get_the_title( $p ) ) ),
						'url'  => (string) get_permalink( $p ),
					);
				}
			}
		}
	}

	return $items;
}

/**
 * Bangun struktur array `BreadcrumbList` Schema.org untuk halaman aktif.
 *
 * @return array<string, mixed>|null
 */
function sekolahane_get_breadcrumb_schema_node() {
	if ( is_front_page() || is_home() ) {
		return null;
	}

	$home_url  = home_url( '/' );
	$positions = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => __( 'Beranda', 'sekolahane' ),
			'item'     => $home_url,
		),
	);
	$pos_index = 2;

	if ( is_singular() ) {
		$post_id = (int) get_queried_object_id();
		$post    = get_post( $post_id );
		if ( $post instanceof WP_Post ) {
			if ( 'post' === $post->post_type ) {
				$cats = get_the_category( $post_id );
				if ( is_array( $cats ) && ! empty( $cats[0] ) && $cats[0] instanceof WP_Term ) {
					$cat_link = get_category_link( $cats[0]->term_id );
					if ( is_string( $cat_link ) && '' !== $cat_link ) {
						$positions[] = array(
							'@type'    => 'ListItem',
							'position' => $pos_index++,
							'name'     => $cats[0]->name,
							'item'     => $cat_link,
						);
					}
				}
			} elseif ( ! in_array( $post->post_type, array( 'page', 'attachment' ), true ) ) {
				$pt_obj       = get_post_type_object( $post->post_type );
				$archive_link = get_post_type_archive_link( $post->post_type );
				if ( is_object( $pt_obj ) && isset( $pt_obj->labels->name ) && is_string( $archive_link ) && '' !== $archive_link ) {
					$positions[] = array(
						'@type'    => 'ListItem',
						'position' => $pos_index++,
						'name'     => (string) $pt_obj->labels->name,
						'item'     => $archive_link,
					);
				}
			} elseif ( 'page' === $post->post_type && $post->post_parent > 0 ) {
				$ancestors = array_reverse( get_post_ancestors( $post ) );
				foreach ( $ancestors as $ancestor_id ) {
					$positions[] = array(
						'@type'    => 'ListItem',
						'position' => $pos_index++,
						'name'     => wp_strip_all_tags( get_the_title( $ancestor_id ) ),
						'item'     => (string) get_permalink( $ancestor_id ),
					);
				}
			}

			$positions[] = array(
				'@type'    => 'ListItem',
				'position' => $pos_index,
				'name'     => wp_strip_all_tags( get_the_title( $post ) ),
				'item'     => (string) get_permalink( $post ),
			);
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$term_link = get_term_link( $term );
			if ( is_string( $term_link ) ) {
				$positions[] = array(
					'@type'    => 'ListItem',
					'position' => $pos_index,
					'name'     => $term->name,
					'item'     => $term_link,
				);
			}
		}
	} elseif ( is_post_type_archive() ) {
		$pt_obj = get_queried_object();
		if ( is_object( $pt_obj ) && isset( $pt_obj->name, $pt_obj->labels->name ) ) {
			$archive_link = get_post_type_archive_link( (string) $pt_obj->name );
			if ( is_string( $archive_link ) ) {
				$positions[] = array(
					'@type'    => 'ListItem',
					'position' => $pos_index,
					'name'     => (string) $pt_obj->labels->name,
					'item'     => $archive_link,
				);
			}
		}
	}

	if ( count( $positions ) < 2 ) {
		return null;
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) ) . '#breadcrumb',
		'itemListElement' => $positions,
	);
}

/**
 * Bangun JSON-LD `@graph` lengkap untuk SEO Premium, Google Sitelinks, & Knowledge Graph GEO.
 *
 * @return array<string, mixed>
 */
function sekolahane_build_schema_graph() {
	$profile  = sekolahane_get_school_profile();
	$home_url = (string) $profile['home_url'];
	$org_id   = $home_url . '#organization';
	$web_id   = $home_url . '#website';

	// 1. Node EducationalOrganization / School (Setara Yoast Local SEO + Knowledge Graph).
	$org_node = array(
		'@type' => array( 'EducationalOrganization', 'School', 'Organization' ),
		'@id'   => $org_id,
		'name'  => (string) $profile['org_name'],
		'url'   => $home_url,
		'logo'  => array(
			'@type' => 'ImageObject',
			'@id'   => $home_url . '#logo',
			'url'   => (string) $profile['logo_url'],
		),
		'image' => (string) $profile['logo_url'],
	);

	if ( '' !== (string) $profile['site_name'] && $profile['site_name'] !== $profile['org_name'] ) {
		$org_node['alternateName'] = (string) $profile['site_name'];
	}
	if ( '' !== (string) $profile['about'] ) {
		$org_node['description'] = (string) $profile['about'];
	} elseif ( '' !== (string) $profile['slogan'] ) {
		$org_node['description'] = (string) $profile['slogan'];
	}
	if ( '' !== (string) $profile['address'] ) {
		$org_node['address'] = array(
			'@type'          => 'PostalAddress',
			'streetAddress'  => (string) $profile['address'],
			'addressCountry' => 'ID',
		);
	}
	if ( '' !== (string) $profile['lat'] && '' !== (string) $profile['lng'] ) {
		$org_node['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) $profile['lat'],
			'longitude' => (float) $profile['lng'],
		);
	}
	if ( '' !== (string) $profile['phone'] ) {
		$org_node['telephone'] = (string) $profile['phone'];
	} elseif ( '' !== (string) $profile['mobile'] ) {
		$org_node['telephone'] = sekolahane_seo_normalize_phone( (string) $profile['mobile'] );
	}
	if ( '' !== (string) $profile['email'] ) {
		$org_node['email'] = (string) $profile['email'];
	}
	if ( ! empty( $profile['socials'] ) ) {
		$org_node['sameAs'] = $profile['socials'];
	}

	$contact_points = array();
	if ( '' !== (string) $profile['phone'] ) {
		$contact_points[] = array(
			'@type'             => 'ContactPoint',
			'telephone'         => (string) $profile['phone'],
			'contactType'       => 'customer service',
			'availableLanguage' => array( 'Indonesian' ),
		);
	}
	if ( ! empty( $profile['cs_list'] ) && is_array( $profile['cs_list'] ) ) {
		foreach ( $profile['cs_list'] as $cs ) {
			$contact_points[] = array(
				'@type'             => 'ContactPoint',
				'telephone'         => (string) $cs['phone'],
				'contactType'       => '' !== (string) $cs['role'] ? (string) $cs['role'] : 'customer support',
				'name'              => (string) $cs['name'],
				'availableLanguage' => array( 'Indonesian' ),
			);
		}
	}
	if ( ! empty( $contact_points ) ) {
		$org_node['contactPoint'] = $contact_points;
	}

	$graph = array( $org_node );

	// 2. Node WebSite + Sitelinks Searchbox (Agar nama brand & Sitelinks tampil di atas URL Google).
	$website_node = array(
		'@type'           => 'WebSite',
		'@id'             => $web_id,
		'url'             => $home_url,
		'name'            => (string) $profile['org_name'],
		'alternateName'   => (string) $profile['site_name'],
		'description'     => (string) $profile['slogan'],
		'publisher'       => array( '@id' => $org_id ),
		'inLanguage'      => get_bloginfo( 'language' ),
		'potentialAction' => array(
			array(
				'@type'       => 'SearchAction',
				'target'      => array(
					'@type'       => 'EntryPoint',
					'urlTemplate' => $home_url . '?s={search_term_string}',
				),
				'query-input' => 'required name=search_term_string',
			),
		),
	);

	$graph[] = $website_node;

	// 3. Node SiteNavigationElement dari Menu Utama (Pemicu utama Indented Sitelinks seperti Webane Indonesia).
	$nav_items = sekolahane_get_sitelinks_navigation();
	if ( ! empty( $nav_items ) ) {
		$nav_elements = array();
		$pos          = 1;
		foreach ( $nav_items as $nav ) {
			$nav_elements[] = array(
				'@type'    => 'SiteNavigationElement',
				'position' => $pos++,
				'name'     => $nav['name'],
				'url'      => $nav['url'],
			);
		}
		$graph[] = array(
			'@type'           => 'ItemList',
			'@id'             => $home_url . '#site-navigation',
			'name'            => __( 'Navigasi Utama', 'sekolahane' ),
			'itemListElement' => $nav_elements,
		);
	}

	// 4. Node BreadcrumbList JSON-LD.
	$breadcrumb_node = sekolahane_get_breadcrumb_schema_node();
	if ( is_array( $breadcrumb_node ) ) {
		$graph[] = $breadcrumb_node;
	}

	// 5. Node Spesifik Halaman (NewsArticle dengan Keywords dari Tag, Person untuk Guru, Course untuk Ekskul).
	if ( is_singular() ) {
		$post_id = (int) get_queried_object_id();
		$post    = get_post( $post_id );
		if ( $post instanceof WP_Post ) {
			$permalink = (string) get_permalink( $post );
			$title     = wp_strip_all_tags( get_the_title( $post ) );
			$desc      = sekolahane_generate_smart_description();
			$img_url   = sekolahane_get_seo_image_url();
			$keywords  = sekolahane_get_current_keywords( $post_id );

			if ( 'post' === $post->post_type ) {
				$author_id   = (int) $post->post_author;
				$author_name = get_the_author_meta( 'display_name', $author_id );
				$cats        = get_the_category( $post_id );
				$sections    = is_array( $cats ) ? wp_list_pluck( $cats, 'name' ) : array();

				$article_node = array(
					'@type'            => array( 'NewsArticle', 'BlogPosting' ),
					'@id'              => $permalink . '#article',
					'mainEntityOfPage' => $permalink,
					'headline'         => $title,
					'description'      => $desc,
					'image'            => array( $img_url ),
					'datePublished'    => (string) get_the_date( DATE_W3C, $post ),
					'dateModified'     => (string) get_the_modified_date( DATE_W3C, $post ),
					'author'           => array(
						'@type' => 'Person',
						'name'  => '' !== (string) $author_name ? (string) $author_name : (string) $profile['org_name'],
						'url'   => get_author_posts_url( $author_id ),
					),
					'publisher'        => array( '@id' => $org_id ),
					'isPartOf'         => array( '@id' => $web_id ),
					'inLanguage'       => get_bloginfo( 'language' ),
				);

				if ( ! empty( $keywords ) ) {
					$article_node['keywords'] = implode( ', ', $keywords );
				}
				if ( ! empty( $sections ) ) {
					$article_node['articleSection'] = array_values( $sections );
				}

				$graph[] = $article_node;
			} elseif ( 'guru' === $post->post_type ) {
				$jabatan   = function_exists( 'get_field' ) ? trim( wp_strip_all_tags( (string) get_field( 'ane_jabatan', $post_id ) ) ) : '';
				$pelajaran = get_the_terms( $post_id, 'pelajaran' );
				$knows     = is_array( $pelajaran ) ? array_values( wp_list_pluck( $pelajaran, 'name' ) ) : array();

				$person_node = array(
					'@type'       => 'Person',
					'@id'         => $permalink . '#person',
					'name'        => $title,
					'url'         => $permalink,
					'image'       => $img_url,
					'description' => $desc,
					'worksFor'    => array( '@id' => $org_id ),
				);
				if ( '' !== $jabatan ) {
					$person_node['jobTitle'] = $jabatan;
				}
				if ( ! empty( $knows ) ) {
					$person_node['knowsAbout'] = $knows;
				}
				$graph[] = $person_node;
			} elseif ( 'ekstrakurikuler' === $post->post_type ) {
				$graph[] = array(
					'@type'       => 'Course',
					'@id'         => $permalink . '#course',
					'name'        => $title,
					'description' => $desc,
					'url'         => $permalink,
					'image'       => $img_url,
					'provider'    => array( '@id' => $org_id ),
				);
			}
		}
	}

	return array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);
}

/**
 * Cetak tag meta SEO, Keywords dari Tag, OpenGraph/Twitter fallback, link `/llms.txt` (GEO),
 * dan JSON-LD `@graph` di `<head>`.
 *
 * Jika Yoast SEO aktif, fungsi ini hanya mencetak elemen yang TIDAK dikeluarkan Yoast Free
 * (seperti `<meta name="keywords">` dari Tag, link `/llms.txt`, dan JSON-LD `@graph`
 * khusus Sekolah + Sitelinks) sehingga 0 duplikasi.
 *
 * @return void
 */
function sekolahane_render_seo_head() {
	if ( is_admin() || is_feed() || is_robots() ) {
		return;
	}

	$yoast_active = sekolahane_is_yoast_active();
	$profile      = sekolahane_get_school_profile();
	$description  = sekolahane_generate_smart_description();
	$keywords     = sekolahane_get_current_keywords();
	$img_url      = sekolahane_get_seo_image_url();
	$llms_url     = home_url( '/llms.txt' );

	echo "\n<!-- Sekolah Ane Premium SEO & GEO Engine -->\n";

	// 1. Jika Yoast TIDAK aktif, cetak meta description, canonical, OpenGraph & Twitter Card penuh.
	if ( ! $yoast_active ) {
		if ( '' !== $description ) {
			echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
		}

		$canonical = wp_get_canonical_url();
		if ( ! is_string( $canonical ) || '' === $canonical ) {
			$canonical = home_url( add_query_arg( array(), $GLOBALS['wp']->request ?? '' ) );
		}
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '" />' . "\n";

		$og_type  = is_singular( 'post' ) ? 'article' : 'website';
		$og_title = wp_get_document_title();

		echo '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '" />' . "\n";
		echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '" />' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $og_title ) . '" />' . "\n";
		if ( '' !== $description ) {
			echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />' . "\n";
		}
		echo '<meta property="og:url" content="' . esc_url( $canonical ) . '" />' . "\n";
		echo '<meta property="og:site_name" content="' . esc_attr( (string) $profile['org_name'] ) . '" />' . "\n";
		if ( '' !== $img_url ) {
			echo '<meta property="og:image" content="' . esc_url( $img_url ) . '" />' . "\n";
		}
		if ( is_singular( 'post' ) ) {
			echo '<meta property="article:published_time" content="' . esc_attr( (string) get_the_date( DATE_W3C ) ) . '" />' . "\n";
			echo '<meta property="article:modified_time" content="' . esc_attr( (string) get_the_modified_date( DATE_W3C ) ) . '" />' . "\n";
		}

		echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $og_title ) . '" />' . "\n";
		if ( '' !== $description ) {
			echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '" />' . "\n";
		}
		if ( '' !== $img_url ) {
			echo '<meta name="twitter:image" content="' . esc_url( $img_url ) . '" />' . "\n";
		}
	}

	// 2. Cetak <meta name="keywords"> otomatis dari Post Tags + Kategori + Focus KW Yoast (selalu aktif).
	if ( ! empty( $keywords ) ) {
		echo '<meta name="keywords" content="' . esc_attr( implode( ', ', $keywords ) ) . '" />' . "\n";
	}

	// 3. Jika Yoast tidak aktif dan ini single post, cetak juga <meta property="article:tag"> untuk tiap tag.
	if ( ! $yoast_active && is_singular( 'post' ) ) {
		$post_tags = get_the_tags();
		if ( is_array( $post_tags ) ) {
			foreach ( $post_tags as $ptag ) {
				if ( $ptag instanceof WP_Term ) {
					echo '<meta property="article:tag" content="' . esc_attr( $ptag->name ) . '" />' . "\n";
				}
			}
		}
	}

	// 4. Sinyal penemuan GEO (/llms.txt) untuk AI Search Crawlers (ChatGPT, Perplexity, Gemini, Claude).
	echo '<link rel="alternate" type="text/plain" title="LLMs.txt - Ringkasan Pengetahuan AI" href="' . esc_url( $llms_url ) . '" />' . "\n";

	// 5. Cetak JSON-LD Schema `@graph` (EducationalOrganization, WebSite, SiteNavigationElement Sitelinks, BreadcrumbList, Article/Person/Course).
	$schema_graph = sekolahane_build_schema_graph();
	$json_ld      = wp_json_encode( $schema_graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	if ( is_string( $json_ld ) && '' !== $json_ld ) {
		echo '<script type="application/ld+json" class="sekolahane-schema-graph">' . $json_ld . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'sekolahane_render_seo_head', 5 );

/**
 * Otomatis isi atribut `alt` pada gambar attachment yang kosong dengan judul post + nama sekolah.
 *
 * @param array<string, string> $attr       Atribut tag `<img>`.
 * @param WP_Post               $attachment Objek post attachment.
 * @return array<string, string>
 */
function sekolahane_auto_image_alt_attributes( $attr, $attachment ) {
	if ( ! is_array( $attr ) ) {
		return $attr;
	}

	$current_alt = isset( $attr['alt'] ) ? trim( (string) $attr['alt'] ) : '';
	if ( '' === $current_alt ) {
		$profile  = sekolahane_get_school_profile();
		$fallback = '';
		if ( is_singular() ) {
			$fallback = trim( wp_strip_all_tags( get_the_title() ) );
		}
		if ( '' === $fallback && $attachment instanceof WP_Post && '' !== trim( $attachment->post_title ) ) {
			$fallback = trim( wp_strip_all_tags( $attachment->post_title ) );
		}
		if ( '' !== $fallback && '' !== (string) $profile['org_name'] ) {
			$fallback .= ' - ' . (string) $profile['org_name'];
		} elseif ( '' === $fallback ) {
			$fallback = (string) $profile['org_name'];
		}
		$attr['alt'] = $fallback;
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'sekolahane_auto_image_alt_attributes', 10, 2 );

/**
 * Tambahkan Resource Hints (`preconnect`) untuk mempercepat pemuatan Google Fonts & CDN.
 *
 * @param array<int, string|array<string, string>> $urls          Daftar URL resource hints.
 * @param string                                   $relation_type Jenis relasi (`preconnect`, `dns-prefetch`, dll).
 * @return array<int, string|array<string, string>>
 */
function sekolahane_seo_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
		$urls[] = 'https://cdnjs.cloudflare.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'sekolahane_seo_resource_hints', 10, 2 );

/**
 * Bersihkan tag tidak penting di `<head>` agar ringan dan fokus pada SEO/GEO.
 *
 * @return void
 */
function sekolahane_clean_wp_head_noise() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
}
add_action( 'init', 'sekolahane_clean_wp_head_noise' );

/**
 * Bangun isi dokumen Markdown `/llms.txt` untuk Generative Engine Optimization (GEO).
 *
 * Digunakan oleh AI Search Engines (ChatGPT Search, Google AI Overviews, Perplexity,
 * Claude, Gemini) untuk mengutip informasi resmi sekolah secara akurat.
 *
 * @return string
 */
function sekolahane_generate_llms_txt_content() {
	$cached = get_transient( 'sekolahane_llms_txt_cache' );
	if ( false !== $cached && is_string( $cached ) && '' !== $cached ) {
		return $cached;
	}

	$profile = sekolahane_get_school_profile();
	$lines   = array();

	$lines[] = '# ' . ( '' !== (string) $profile['org_name'] ? (string) $profile['org_name'] : (string) $profile['site_name'] );
	$lines[] = '';

	if ( '' !== (string) $profile['slogan'] ) {
		$lines[] = '> ' . (string) $profile['slogan'];
		$lines[] = '';
	}
	if ( '' !== (string) $profile['about'] ) {
		$lines[] = (string) $profile['about'];
		$lines[] = '';
	}

	$lines[] = '## Identitas & Kontak Resmi';
	$lines[] = '- Website Resmi: ' . (string) $profile['home_url'];
	if ( '' !== (string) $profile['address'] ) {
		$lines[] = '- Alamat: ' . (string) $profile['address'];
	}
	if ( '' !== (string) $profile['lat'] && '' !== (string) $profile['lng'] ) {
		$lines[] = '- Koordinat Peta (GPS): ' . (string) $profile['lat'] . ', ' . (string) $profile['lng'] . ' (https://www.google.com/maps/search/?api=1&query=' . rawurlencode( (string) $profile['lat'] . ',' . (string) $profile['lng'] ) . ')';
	}
	if ( '' !== (string) $profile['phone'] ) {
		$lines[] = '- Telepon Kantor: ' . (string) $profile['phone'];
	}
	if ( '' !== (string) $profile['mobile'] ) {
		$lines[] = '- Handphone / WhatsApp: ' . (string) $profile['mobile'];
	}
	if ( '' !== (string) $profile['email'] ) {
		$lines[] = '- Email Resmi: ' . (string) $profile['email'];
	}
	if ( '' !== (string) $profile['ppdb_url'] ) {
		$lines[] = '- Link Pendaftaran (PPDB): ' . (string) $profile['ppdb_url'];
	}
	if ( ! empty( $profile['cs_list'] ) && is_array( $profile['cs_list'] ) ) {
		foreach ( $profile['cs_list'] as $cs ) {
			$role_str = '' !== (string) $cs['role'] ? ' (' . (string) $cs['role'] . ')' : '';
			$lines[]  = '- Layanan Informasi / Customer Care: ' . (string) $cs['name'] . $role_str . ' — WhatsApp ' . (string) $cs['phone'];
		}
	}
	$lines[] = '';

	// Navigasi Utama (Sitelinks).
	$nav_items = sekolahane_get_sitelinks_navigation();
	if ( ! empty( $nav_items ) ) {
		$lines[] = '## Halaman Utama (Sitelinks)';
		foreach ( $nav_items as $nav ) {
			$lines[] = '- [' . $nav['name'] . '](' . $nav['url'] . ')';
		}
		$lines[] = '';
	}

	// Ekstrakurikuler.
	$ekskul_posts = get_posts(
		array(
			'post_type'      => 'ekstrakurikuler',
			'posts_per_page' => 20,
			'post_status'    => 'publish',
		)
	);
	if ( is_array( $ekskul_posts ) && ! empty( $ekskul_posts ) ) {
		$lines[] = '## Kegiatan Ekstrakurikuler';
		foreach ( $ekskul_posts as $ek ) {
			if ( $ek instanceof WP_Post ) {
				$ek_title = trim( wp_strip_all_tags( get_the_title( $ek ) ) );
				$ek_desc  = sekolahane_seo_trim_description( '' !== $ek->post_excerpt ? $ek->post_excerpt : $ek->post_content, 110 );
				$lines[]  = '- [' . $ek_title . '](' . (string) get_permalink( $ek ) . ')' . ( '' !== $ek_desc ? ': ' . $ek_desc : '' );
			}
		}
		$lines[] = '';
	}

	// Daftar Guru & Tenaga Pendidik.
	$guru_posts = get_posts(
		array(
			'post_type'      => 'guru',
			'posts_per_page' => 25,
			'post_status'    => 'publish',
		)
	);
	if ( is_array( $guru_posts ) && ! empty( $guru_posts ) ) {
		$lines[] = '## Tenaga Pendidik & Guru';
		foreach ( $guru_posts as $gr ) {
			if ( $gr instanceof WP_Post ) {
				$gr_title   = trim( wp_strip_all_tags( get_the_title( $gr ) ) );
				$gr_jabatan = function_exists( 'get_field' ) ? trim( wp_strip_all_tags( (string) get_field( 'ane_jabatan', $gr->ID ) ) ) : '';
				$lines[]    = '- [' . $gr_title . '](' . (string) get_permalink( $gr ) . ')' . ( '' !== $gr_jabatan ? ' — ' . $gr_jabatan : '' );
			}
		}
		$lines[] = '';
	}

	// Berita & Informasi Terbaru.
	$recent_posts = get_posts(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 10,
			'post_status'    => 'publish',
		)
	);
	if ( is_array( $recent_posts ) && ! empty( $recent_posts ) ) {
		$lines[] = '## Berita & Informasi Terbaru';
		foreach ( $recent_posts as $rp ) {
			if ( $rp instanceof WP_Post ) {
				$rp_title = trim( wp_strip_all_tags( get_the_title( $rp ) ) );
				$rp_date  = (string) get_the_date( 'Y-m-d', $rp );
				$rp_desc  = sekolahane_seo_trim_description( '' !== $rp->post_excerpt ? $rp->post_excerpt : $rp->post_content, 110 );
				$lines[]  = '- [' . $rp_title . '](' . (string) get_permalink( $rp ) . ') (' . $rp_date . ')' . ( '' !== $rp_desc ? ': ' . $rp_desc : '' );
			}
		}
		$lines[] = '';
	}

	$output = implode( "\n", $lines );
	set_transient( 'sekolahane_llms_txt_cache', $output, 6 * HOUR_IN_SECONDS );

	return $output;
}

/**
 * Bersihkan cache `/llms.txt` saat ada post atau halaman yang disimpan/diperbarui.
 *
 * @return void
 */
function sekolahane_flush_llms_txt_cache() {
	delete_transient( 'sekolahane_llms_txt_cache' );
}
add_action( 'save_post', 'sekolahane_flush_llms_txt_cache' );
add_action( 'acf/save_post', 'sekolahane_flush_llms_txt_cache' );

/**
 * Tangani request ke `/llms.txt` atau `?llms_txt=1` secara dinamis tanpa perlu
 * mengubah `.htaccess` atau flush rewrite rules manual di situs pelanggan.
 *
 * @return void
 */
function sekolahane_serve_llms_txt_endpoint() {
	$req_uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	$req_path = (string) wp_parse_url( $req_uri, PHP_URL_PATH );
	$is_llms  = ( '/llms.txt' === substr( $req_path, -9 ) ) || ( isset( $_GET['llms_txt'] ) && '1' === sanitize_text_field( wp_unslash( $_GET['llms_txt'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( ! $is_llms ) {
		return;
	}

	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	header( 'X-Robots-Tag: index, follow' );

	echo sekolahane_generate_llms_txt_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit;
}
add_action( 'init', 'sekolahane_serve_llms_txt_endpoint', 1 );

/**
 * Ekstrak nilai kode verifikasi murni dari input teks yang mungkin berisi
 * tag HTML penuh `<meta name="..." content="KODE" />` atau hanya `KODE`.
 *
 * @param string $raw Input mentah dari admin.
 * @return string Kode verifikasi bersih.
 */
function sekolahane_extract_verification_token( $raw ) {
	$text = trim( (string) $raw );
	if ( '' === $text ) {
		return '';
	}

	if ( preg_match( '/content\s*=\s*["\']([^"\']+)["\']/i', $text, $matches ) && ! empty( $matches[1] ) ) {
		$text = trim( $matches[1] );
	}

	return (string) preg_replace( '/[^a-zA-Z0-9_\-\.]/', '', $text );
}

/**
 * Ambil dan validasi seluruh pengaturan Google & Tracking Pixel dari ACF Option.
 *
 * @return array{gsc: string, gtm_id: string, ga4_id: string, fb_pixel: string, fb_verify: string, tiktok_pixel: string}
 */
function sekolahane_get_tracking_settings() {
	static $settings = null;
	if ( is_array( $settings ) ) {
		return $settings;
	}

	$gsc          = '';
	$gtm_id       = '';
	$ga4_id       = '';
	$fb_pixel     = '';
	$fb_verify    = '';
	$tiktok_pixel = '';

	if ( function_exists( 'get_field' ) ) {
		$gsc       = sekolahane_extract_verification_token( (string) get_field( 'sekolahane_gsc_verification', 'option' ) );
		$fb_verify = sekolahane_extract_verification_token( (string) get_field( 'sekolahane_fb_domain_verify', 'option' ) );

		$raw_gtm = strtoupper( trim( (string) get_field( 'sekolahane_gtm_id', 'option' ) ) );
		if ( preg_match( '/(GTM-[A-Z0-9]+)/', $raw_gtm, $m_gtm ) ) {
			$gtm_id = $m_gtm[1];
		}

		$raw_ga4 = strtoupper( trim( (string) get_field( 'sekolahane_ga4_id', 'option' ) ) );
		if ( preg_match( '/((?:G|UA|AW|DC)-[A-Z0-9\-]+)/', $raw_ga4, $m_ga4 ) ) {
			$ga4_id = $m_ga4[1];
		}

		$raw_fb = trim( (string) get_field( 'sekolahane_fb_pixel_id', 'option' ) );
		if ( preg_match( '/([0-9]{8,25})/', $raw_fb, $m_fb ) ) {
			$fb_pixel = $m_fb[1];
		}

		$raw_tt = strtoupper( trim( (string) get_field( 'sekolahane_tiktok_pixel_id', 'option' ) ) );
		if ( preg_match( '/^([A-Z0-9]{10,30})$/', $raw_tt, $m_tt ) ) {
			$tiktok_pixel = $m_tt[1];
		}
	}

	$settings = array(
		'gsc'          => $gsc,
		'gtm_id'       => $gtm_id,
		'ga4_id'       => $ga4_id,
		'fb_pixel'     => $fb_pixel,
		'fb_verify'    => $fb_verify,
		'tiktok_pixel' => $tiktok_pixel,
	);

	return $settings;
}

/**
 * Cetak meta verifikasi (Google Search Console & Meta Domain) serta script resmi
 * Google Tag Manager, Google Analytics 4, Meta Pixel, dan TikTok Pixel di `<head>`.
 *
 * @return void
 */
function sekolahane_render_tracking_head() {
	if ( is_admin() || is_feed() || is_robots() ) {
		return;
	}

	$t = sekolahane_get_tracking_settings();

	if ( '' !== $t['gsc'] ) {
		echo '<meta name="google-site-verification" content="' . esc_attr( $t['gsc'] ) . '" />' . "\n";
	}

	if ( '' !== $t['fb_verify'] ) {
		echo '<meta name="facebook-domain-verification" content="' . esc_attr( $t['fb_verify'] ) . '" />' . "\n";
	}

	if ( '' !== $t['gtm_id'] ) {
		$gtm_js = esc_js( $t['gtm_id'] );
		echo "<!-- Google Tag Manager -->\n";
		echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . $gtm_js . "');</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	if ( '' !== $t['ga4_id'] ) {
		$ga_url = 'https://www.googletagmanager.com/gtag/js?id=' . rawurlencode( $t['ga4_id'] );
		$ga_js  = esc_js( $t['ga4_id'] );
		echo "<!-- Google Analytics (gtag.js) -->\n";
		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
		echo '<script async src="' . esc_url( $ga_url ) . '"></script>' . "\n";
		echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','" . $ga_js . "');</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	if ( '' !== $t['fb_pixel'] ) {
		$fb_js = esc_js( $t['fb_pixel'] );
		$fb_tr = 'https://www.facebook.com/tr?id=' . rawurlencode( $t['fb_pixel'] ) . '&ev=PageView&noscript=1';
		echo "<!-- Meta Pixel Code -->\n";
		echo "<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','" . $fb_js . "');fbq('track','PageView');</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<noscript><img height="1" width="1" style="display:none" src="' . esc_url( $fb_tr ) . '" alt="" /></noscript>' . "\n";
	}

	if ( '' !== $t['tiktok_pixel'] ) {
		$tt_js = esc_js( $t['tiktok_pixel'] );
		echo "<!-- TikTok Pixel Code -->\n";
		echo "<script>!function(w,d,t){w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=['page','track','identify','instances','debug','on','off','once','ready','alias','group','enableCookie','disableCookie'],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i='https://analytics.tiktok.com/i18n/pixel/events.js';ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement('script');o.type='text/javascript',o.async=!0,o.src=i+'?sdkid='+e+'&lib='+t;var a=document.getElementsByTagName('script')[0];a.parentNode.insertBefore(o,a)};ttq.load('" . $tt_js . "');ttq.page();}(window,document,'ttq');</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'sekolahane_render_tracking_head', 2 );

/**
 * Cetak `<noscript>` Google Tag Manager tepat setelah tag pembuka `<body>` (`wp_body_open`).
 *
 * @return void
 */
function sekolahane_render_tracking_body_open() {
	$t = sekolahane_get_tracking_settings();
	if ( '' === $t['gtm_id'] ) {
		return;
	}

	$gtm_ns_url = 'https://www.googletagmanager.com/ns.html?id=' . rawurlencode( $t['gtm_id'] );
	echo '<!-- Google Tag Manager (noscript) -->' . "\n";
	echo '<noscript><iframe src="' . esc_url( $gtm_ns_url ) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n";
}
add_action( 'wp_body_open', 'sekolahane_render_tracking_body_open', 2 );
