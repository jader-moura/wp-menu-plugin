<?php
/**
 * Plugin Name: Enboarder Custom Menu
 * Description: Adds an image field to each menu item and displays the associated image on the frontend.
 * Version: 1.0
 * Author: Lava
*/


//ou edita o menu OU cria um novo menu e altera-se no header.php



/** Add options page BO **/
add_action('acf/init', 'addACFPages');
function addACFPages() {
    // Check function exists.
    if( function_exists('acf_add_options_page') ) {
        /** Activate 2023 Header Menu **/
        acf_add_options_page(array(
            'page_title'    => 'Header 2023',
            'menu_title'    => 'Header 2023',
            'menu_slug'     => 'activate-2023-header',
            'capability'    => 'edit_posts',
            'icon_url'      => 'dashicons-editor-ul',
            'redirect'      => false
        ));

    }
}


/** ACF FIELDS MENU **/
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	/** Fields in Menu items **/
	acf_add_local_field_group( array(
		'key' => 'group_6488751251bc7',
		'title' => 'Header Menu fields',
		'fields' => array(
			array(
                'key' => 'field_6498751adimg',
                'label' => 'AD Image',
                'name' => 'ad_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all'
            ),
            array(
                'key' => 'field_6498751adlink',
                'label' => 'AD Link',
                'name' => 'ad_link',
                'type' => 'url',
                'instructions' => 'Enter the URL for the advertisement.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'nav_menu_item',
					'operator' => '==',
					'value' => 'all',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	) );

	/** ACF field in options page **/
	acf_add_local_field_group( array(
		'key' => 'group_6491817683171',
		'title' => 'Options Page Header 2023',
		'fields' => array(
			array(
				'key' => 'field_64918177695f8',
				'label' => 'Activate 2023 Header Menu',
				'name' => 'activate_2023_header_menu',
				'aria-label' => '',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => 'Check the checkbox to activate 2023 Header Menu.',
				'default_value' => 0,
				'ui' => 0,
				'ui_on_text' => '',
				'ui_off_text' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'activate-2023-header',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	) );
} );

add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
function my_wp_nav_menu_objects($items, $args) {
    if (get_field('activate_2023_header_menu', 'options')) {
        foreach ($items as &$item) {
            $adImage = get_field('ad_image', $item);
            $adLink = get_field('ad_link', $item);
            if ($adImage && $adLink) {
                $item->title .= '<span class="menu-ad-image" data-ad-image-url="' . esc_url($adImage) . '" data-ad-link-url="' . esc_url($adLink) . '"></span>';
            }
        }
    }
    return $items;
}

/** Enqueue styles and Scripts **/
function lava_enqueue_styles() {
	$version = '0.21';
	if(get_field('activate_2023_header_menu','options')){
		wp_enqueue_style('lava-custom-menu-styles', plugin_dir_url(__FILE__) . 'assets/custom_menu_style.css', array(), $version);
		wp_enqueue_style('lava-custom-menu-styles-other', plugin_dir_url(__FILE__) . 'assets/custom_menu_style_other.css', array(), $version);
		wp_enqueue_script('custom-menu-js', plugin_dir_url(__FILE__) .'assets/custom_menu.js', array(), $version, false);
	}
}
add_action('wp_enqueue_scripts', 'lava_enqueue_styles',99);