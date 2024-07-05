<?php
/**
 * Plugin Name: Enboarder Custom Menu
 * Description: Enboarder custom menu with a possibility to add AD Image and AD links to each nested menu.
 * Version: 2.0
 * Author: Lava & NBD
*/



/** Add options page BO **/
add_action('acf/init', 'addACFPages');
function addACFPages() {
    // Check function exists.
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_page(array(
			'page_title'    => 'Header General Settings',
			'menu_title'    => 'Header Settings',
			'menu_slug'     => 'header-general-settings',
			'capability'    => 'edit_posts',
            'icon_url'      => 'dashicons-editor-ul',
			'redirect'      => false
		));
	
		acf_add_local_field_group(array(
			'key' => 'group_001',
			'title' => 'Theme Header Settings',
			'fields' => array(
                array(
                    'key' => 'field_001',
                    'label' => 'Demo Button Label',
                    'name' => 'book_demo_button_label',
                    'type' => 'text',
                    'default_value' => 'Book a Demo',
                ),
                array(
                    'key' => 'field_002',
                    'label' => 'Demo Button Link',
                    'name' => 'book_demo_button_link',
                    'type' => 'url',
                    'default_value' => 'http://example.com',
                )
            ),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'header-general-settings',
					),
				),
			),
		));
	}
	
}

add_filter('wp_nav_menu_objects', 'add_custom_demo_label', 10, 2);
function add_custom_demo_label($items, $args) {
    foreach ($items as $item) {
        if ($item->title == "Book a Demo") { // Exact match is crucial
            $label = get_field('book_demo_button_label', 'option');
            error_log('Checking label: ' . $label); // Check what label is being fetched
            if ($label) {
                $item->title = '<a id="bookDemo" href="' . $item->url . '">' . esc_html($label) . '</a>';
                error_log('Label applied: ' . $item->title); // Confirm label application
            }
        }
    }
    return $items;
}

function enqueue_demo_button_script() {
    if (function_exists('get_field')) {
        $demo_label = get_field('book_demo_button_label', 'option');
        $demo_link = get_field('book_demo_button_link', 'option');

        // Debug output
        error_log('Demo Label: ' . $demo_label);
        error_log('Demo Link: ' . $demo_link);

        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            var label = <?php echo json_encode($demo_label); ?>;
            var link = <?php echo json_encode($demo_link); ?>;
            if (!link) {
                console.error('Demo link is null:', link);
                link = '#'; // Default fallback link
            }
            var buttonHtml = '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a id="bookDemo" class="book" href="' + link + '">' + label + '</a></li>'
                            + '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a id="bookDemoMobile" class="hideDesk" href="' + link + '">' + label + '</a></li>';
            
            // Append the button to the site header inside the main menu UL
			console.log("buttonHtml: ", buttonHtml)
            $("#menu-main-menu").append(buttonHtml);
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'enqueue_demo_button_script'); 


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