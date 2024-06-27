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
				'key' => 'field_648875145aea8',
				'label' => 'Icon',
				'name' => 'menu_submenu_icon',
				'aria-label' => '',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
				'preview_size' => 'medium',
			),
            array(
				'key' => 'field_6erf44f23ea8',
				'label' => 'Icon Hover',
				'name' => 'menu_submenu_icon_hover',
				'aria-label' => '',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
				'preview_size' => 'medium',
			),
			array(
				'key' => 'field_6455gb66aea9',
				'label' => 'Icon Alt Text',
				'name' => 'menu_icon_alt_Text',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'rows' => '',
				'placeholder' => '',
				'new_lines' => '',
			),
			array(
				'key' => 'field_6488753a5aea9',
				'label' => 'Text',
				'name' => 'parent_intro_text',
				'aria-label' => '',
				'type' => 'textarea',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'rows' => '',
				'placeholder' => '',
				'new_lines' => '',
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





/** Add Text and Icons to Menu items **/
add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
function my_wp_nav_menu_objects( $items, $args ) {


	if(get_field('activate_2023_header_menu','options')){
		foreach( $items as &$item ) {
			$icon = get_field('menu_submenu_icon', $item);
			$iconHover = get_field('menu_submenu_icon_hover', $item);
			$iconAltText = get_field('menu_icon_alt_Text', $item);

			$introText = get_field('parent_intro_text', $item);
			if( $introText ) {
				$item->title = '<span intro-text="'.$introText.'"></span>
					'. $item->title;
			}
			else if($icon){
				$item->title = '<img src="'.$icon.'" class="iconDefault" alt="'.$iconAltText.'"><img src="'.$iconHover.'" class="iconHover" alt="'.$iconAltText.'">' . ' ' .$item->title;
			}
			// else if($icon && array_key_exists('url',$icon)){
			//     var_dump($icon);
			//   $item->title = $item->title;
			// }
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