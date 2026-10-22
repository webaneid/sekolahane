<?php
add_action('customize_register', 'webane_theme_customoze');
function webane_theme_customoze($wp_customize){
     //Footer
    $wp_customize->add_section('footer_settings_section', array(
      'title' => esc_html__( 'Webane Footer', 'kabarane' ),
      'description'     => esc_html__( 'Setting Footer Kabarane', 'kabarane' ),
      'capability' => 'edit_theme_options',
     ));
        $wp_customize->add_setting('footer_link_title', array(
         'default'        => 'Link Penting',
         'transport' => 'refresh',
         ));
        $wp_customize->add_control('footer_link_title', array(
         'label'               => 'Footer Links Title',
          'section'            => 'footer_settings_section',
         'type'                => 'text',
         'sanitize_callback'   => 'wp_filter_nohtml_kses'
        ));
        //title contacts
        $wp_customize->add_setting('footer_contact_title', array(
         'default'        => 'Hubungi Kami',
         'transport'      => 'refresh',
         ));
        $wp_customize->add_control('footer_contact_title', array(
         'label'   => 'Footer Contact Title',
          'section' => 'footer_settings_section',
         'type'    => 'text',
         'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        //warna footer 1
        $wp_customize->add_setting(
            'warna_footer_1',
            array(
                'default' => '#086649',
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'      => 'refresh',
            ));

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
            $wp_customize,
            'warna_footer_1',
            array(
                'label' => 'Gradient Background Warna 1',
                'description' => 'Ganti warna background gradient. Jika tidak ingin gradient, silahkan buat satu warna untuk warna 1 maupun warna 2',
                'section' => 'footer_settings_section',
                'settings' => 'warna_footer_1',
            )));

        //warna footer 2
        $wp_customize->add_setting('warna_footer_2', array(
         'default'        => '#70aa05',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport'      => 'refresh',
        ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_footer_2', array(
            'label'   => 'Gradient Background Warna 2',
            'section' => 'footer_settings_section',
            'settings'   => 'warna_footer_2',
            'sanitize_callback' => 'sanitize_hex_color',
        )));
        //warna footer
        $wp_customize->add_setting('warna_footer', array(
         'default'        => '#f7feea',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport'      => 'refresh',
        ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_footer', array(
            'label'   => 'Warna Footer',
            'section' => 'footer_settings_section',
            'settings'   => 'warna_footer',
            'sanitize_callback' => 'sanitize_hex_color',
        )));
        //warna link footer
        $wp_customize->add_setting('warna_footer_link', array(
         'default'        => '#ffffff',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport'      => 'refresh',
        ) );
            $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_footer_link', array(
            'label'   => 'Warna Footer',
            'section' => 'footer_settings_section',
            'settings'   => 'warna_footer_link',
            'sanitize_callback' => 'sanitize_hex_color',
        )));

// -== color setting ==- //
    $wp_customize->add_section('kabarane_colors_settings', array(
        'title'          => 'Webane Colors',
        'description' => esc_html__( 'Ganti Warna Sesuai dengan brand Anda' ),
        'capability' => 'edit_theme_options',
        ));
        //warna utama
        $wp_customize->add_setting('warna_utama', array(
         'default'        => '#70aa05',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport'      => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_utama', array(
        'label'   => 'Warna Utama',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_utama',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //Warna Terang
        $wp_customize->add_setting('warna_terang', array(
         'default'        => '#f7feea',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_terang', array(
        'label'   => 'Warna Terang',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_terang',
        )));
        //warna gelap
        $wp_customize->add_setting('warna_gelap', array(
         'default'        => '#0c1201',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_gelap', array(
        'label'   => 'Warna Gelap',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_gelap',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //warna background menu
        $wp_customize->add_setting('bg_menu_1', array(
         'default'            => '#086649',
         'sanitize_callback'  => 'sanitize_hex_color',
         'transport'          => 'refresh',
         'description'        => 'Ganti warna background Menu Utama. Jika tidak ingin gradient, silahkan buat satu warna untuk warna 1 maupun warna 2',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bg_menu_1', array(
        'label'   => 'Warna Menu 1 / Gradient 1',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'bg_menu_1',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //warna background menu 2
        $wp_customize->add_setting('bg_menu_2', array(
         'default'        => '#70aa05',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bg_menu_2', array(
        'label'   => 'Warna Menu 2 / Gradient 2',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'bg_menu_2',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //warna menu aktif
        $wp_customize->add_setting('warna_menu', array(
         'default'        => '#ffffff',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_menu', array(
        'label'   => 'Warna Text Menu',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_menu',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //Text Aktif
        $wp_customize->add_setting('warna_aktif', array(
         'default'        => '#086649',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_aktif', array(
        'label'   => 'Warna Text URL Aktif',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_aktif',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //Text Aktif hover
        $wp_customize->add_setting('warna_aktif_hover', array(
         'default'        => '#086649',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
         'description' => 'Adalah text yang memikili link, untuk membedakan dengan text atau kalimat yang tidak memiliki link atau tidak aktif',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_aktif_hover', array(
        'label'   => 'Warna Text URL Hover',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_aktif_hover',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //warna judul
        $wp_customize->add_setting('warna_judul', array(
         'default'        => '#182501',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_judul', array(
        'label'   => 'Warna Judul',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_judul',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
        //warna judul hover
        $wp_customize->add_setting('warna_judul_hover', array(
         'default'        => '#3f6003',
         'sanitize_callback' => 'sanitize_hex_color',
         'transport' => 'refresh',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'warna_judul_hover', array(
        'label'   => 'Warna Judul Hover',
        'section' => 'kabarane_colors_settings',
        'settings'   => 'warna_judul_hover',
        'sanitize_callback' => 'sanitize_hex_color',
        )));
}
