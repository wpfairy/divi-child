<?php

// Theme Scripts & Styles
function divi_child_theme_scripts_styles() {
    $parent_style = 'parent-style';
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
	
}
add_action( 'wp_enqueue_scripts', 'divi_child_theme_scripts_styles' );


//add_action('init', 'divi_child_codex_custom_init');
function divi_child_codex_custom_init()
{

  $args = array(
    'exclude_from_search' => true, // Don't show Mooberry Books in search results
  );
  
    register_post_type('mbdb_book',$args); // Only on blog page
}

/**
 * Registers a new setting for 'Link Color' in the WordPress Theme Customizer
 * that will allow users to change the color of their anchors across the
 * entire site
 *
 * Note that functions prefixed with 'tmx' stand for 'Tom McFarlin Example.'
 *
 * @param      object    $wp_customize    The WordPress Theme Customizer
 * @package    tmx
 */
function tmx_register_theme_customizer( $wp_customize ) {

	/**
   	 * Adds the setting with the unique id of 'tmx_link_color'. 
   	 *
   	 * Also defines the transport method to 'postMessage' so that 
   	 * we can use JavaScript to dynamically change the color without 
   	 * using the default method of 'refresh.'
   	 */
	$wp_customize->add_setting(
		'tmx_link_color',
		array(
			'default'     => '#000000',
			'transport'   => 'postMessage'
		)
  	);

	/**
   	 * Introduces a new color control to the Theme Customizer in the
	 * 'Colors' section. This is the actual control that will allow
	 * a user to pick a color.
	 */
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
			    'label'      => __( 'Link Color', 'tmx' ),
			    'section'    => 'colors',
			    'settings'   => 'tmx_link_color'
			)
		)
	);

} // end tcx_register_theme_customizer
add_action( 'customize_register', 'tmx_register_theme_customizer' );

/**
 * Registers the Theme Customizer Preview JavaScript with WordPress.
 *
 * @package    tmx
 */
function tmx_customizer_live_preview() {

	wp_enqueue_script(
		'divi-child-theme-customizer',
		get_template_directory_uri() . '/js/theme-customizer.js',
		array( 'jquery', 'customize-preview' ),
		'',
		true
	);

} // end tcx_customizer_live_preview
add_action( 'customize_preview_init', 'tmx_customizer_live_preview' );