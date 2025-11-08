<?php
/**
 * Dalsoop Theme Functions
 *
 * @package Dalsoop
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
function dalsoop_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'dalsoop', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 675, true );

    // Add custom image sizes
    add_image_size( 'dalsoop-featured', 1200, 675, true );
    add_image_size( 'dalsoop-thumbnail', 400, 300, true );

    // Register navigation menus
    register_nav_menus(
        array(
            'primary' => esc_html__( '주 메뉴', 'dalsoop' ),
            'footer'  => esc_html__( '푸터 메뉴', 'dalsoop' ),
        )
    );

    // Switch default core markup to output valid HTML5
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for custom logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    // Add support for custom background
    add_theme_support(
        'custom-background',
        array(
            'default-color' => 'ffffff',
        )
    );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for Block Styles
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'dalsoop_setup' );

/**
 * Set the content width in pixels
 */
function dalsoop_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'dalsoop_content_width', 1200 );
}
add_action( 'after_setup_theme', 'dalsoop_content_width', 0 );

/**
 * Register widget areas
 */
function dalsoop_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( '사이드바', 'dalsoop' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( '메인 사이드바 위젯 영역', 'dalsoop' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );

    // Footer widget areas
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar(
            array(
                'name'          => sprintf( esc_html__( '푸터 %d', 'dalsoop' ), $i ),
                'id'            => 'footer-' . $i,
                'description'   => sprintf( esc_html__( '푸터 위젯 영역 %d', 'dalsoop' ), $i ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            )
        );
    }
}
add_action( 'widgets_init', 'dalsoop_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function dalsoop_scripts() {
    // Theme stylesheet
    wp_enqueue_style( 'dalsoop-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Add inline style for custom colors
    $custom_css = "
        :root {
            --primary-color: " . get_theme_mod( 'primary_color', '#2c3e50' ) . ";
            --secondary-color: " . get_theme_mod( 'secondary_color', '#3498db' ) . ";
            --accent-color: " . get_theme_mod( 'accent_color', '#e74c3c' ) . ";
        }
    ";
    wp_add_inline_style( 'dalsoop-style', $custom_css );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'dalsoop_scripts' );

/**
 * Custom excerpt length
 */
function dalsoop_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'dalsoop_excerpt_length', 999 );

/**
 * Custom excerpt more
 */
function dalsoop_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'dalsoop_excerpt_more' );

/**
 * Add custom classes to body
 */
function dalsoop_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'dalsoop_body_classes' );

/**
 * Customizer additions
 */
function dalsoop_customize_register( $wp_customize ) {
    // Add color settings
    $wp_customize->add_section(
        'dalsoop_colors',
        array(
            'title'    => __( '테마 색상', 'dalsoop' ),
            'priority' => 30,
        )
    );

    // Primary color
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#2c3e50',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'   => __( '주 색상', 'dalsoop' ),
                'section' => 'dalsoop_colors',
            )
        )
    );

    // Secondary color
    $wp_customize->add_setting(
        'secondary_color',
        array(
            'default'           => '#3498db',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            array(
                'label'   => __( '보조 색상', 'dalsoop' ),
                'section' => 'dalsoop_colors',
            )
        )
    );

    // Accent color
    $wp_customize->add_setting(
        'accent_color',
        array(
            'default'           => '#e74c3c',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'accent_color',
            array(
                'label'   => __( '강조 색상', 'dalsoop' ),
                'section' => 'dalsoop_colors',
            )
        )
    );
}
add_action( 'customize_register', 'dalsoop_customize_register' );

/**
 * Sanitize hex color
 */
function dalsoop_sanitize_hex_color( $color ) {
    if ( '' === $color ) {
        return '';
    }

    // 3 or 6 hex digits, or the empty string
    if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
        return $color;
    }

    return '';
}
