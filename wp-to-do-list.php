<?php
/*
 * Plugin Name:       WP To Do List
 * Plugin URI:        https://github.com/ecgan/wp-to-do-list
 * Description:       To do list for WordPress.
 * Version:           0.0.1
 * Requires at least: 6.5
 * Requires PHP:      8.2
 * Author:            Gan Eng Chin
 * Author URI:        https://ecgan.com/
 * Text Domain:       wp-to-do-list
 */

function register_types() {
	register_post_type('wptdl_task',
		array(
			'labels'      => array(
				'name'          => __('Tasks', 'wp-to-do-list'),
				'singular_name' => __('Task', 'wp-to-do-list'),
                'add_new'       => __('Add New Task', 'wp-to-do-list'),
                'add_new_item'  => __('Add New Task', 'wp-to-do-list'),
                'edit_item'     => __('Edit Task', 'wp-to-do-list'),
                'new_item'      => __('New Task', 'wp-to-do-list'),
                'view_item'     => __('View Task', 'wp-to-do-list'),
                'view_items'    => __('View Tasks', 'wp-to-do-list'),
                'search_items'  => __('Search Tasks', 'wp-to-do-list'),
                'not_found'     => __('No tasks found', 'wp-to-do-list'),
                'not_found_in_trash' => __('No tasks found in Trash', 'wp-to-do-list'),
                'all_items'     => __('All Tasks', 'wp-to-do-list'),
                'archives'      => __('Task Archives', 'wp-to-do-list'),
                'attributes'    => __('Task Attributes', 'wp-to-do-list'),
			),
            'public'      => true,
            'hierarchical'  => true,
            'has_archive'   => true,
            'show_in_rest'  => true,
            'supports'      => array('title', 'editor', 'author', 'comments', 'revisions'),
		)
	);
}

add_action('init', 'register_types');

function wporg_options_main_html() {
    ?>
    <div class="wrap">
      <div id="wptdl_app"></div>
    </div>
    <?php
}

/**
 * Display callback for the submenu page.
 */
function books_ref_page_callback() { 
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <p><?php _e( 'Helpful stuff here', 'textdomain' ); ?></p>
    </div>
    <?php
}

function add_admin_menu_main_page() {
    add_menu_page(
        __( 'WP To-do List', 'wp-to-do-list' ),
        __( 'WP To-do List', 'wp-to-do-list' ),
        'manage_options',
        'wp-to-do-list_main',
        'wporg_options_main_html',
        'dashicons-editor-ul',
        58
    );

    add_submenu_page( 
        'wp-to-do-list_main', 
        __( 'Main', 'wp-to-do-list' ), 
        __( 'Main', 'wp-to-do-list' ),
        'manage_options', 
        'wp-to-do-list_main'
    );
    add_submenu_page( 
        'wp-to-do-list_main', 
        __( 'Settings', 'wp-to-do-list' ),
        __( 'Settings', 'wp-to-do-list' ),
        'manage_options', 
        'wp-to-do-list_submenu',
        'books_ref_page_callback'
    );
}

add_action( 'admin_menu', 'add_admin_menu_main_page' );


/**
 * Load the admin script.
 *
 * @param string $hook The hook name of the page.
 */
function load_custom_wp_admin_scripts( $hook ) {
	// Load only on ?page=my-custom-gutenberg-app.
	if ( 'toplevel_page_wp-to-do-list_main' !== $hook ) {
		return;
	}

	// Load the required WordPress packages.

	// Automatically load imported dependencies and assets version.
	$asset_file = include plugin_dir_path( __FILE__ ) . '/build/index.asset.php';

	// Enqueue CSS dependencies.
	foreach ( $asset_file['dependencies'] as $style ) {
		wp_enqueue_style( $style );
	}

	// Load our app.js.
	wp_register_script(
		'my-custom-gutenberg-app',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);
	wp_enqueue_script( 'my-custom-gutenberg-app' );

	// Load our style.css.
	// wp_register_style(
	// 	'my-custom-gutenberg-app',
	// 	plugins_url( 'build/style-index.css', __FILE__ ),
	// 	array(),
	// 	$asset_file['version']
	// );
	// wp_enqueue_style( 'my-custom-gutenberg-app' );
}

add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_scripts' );
