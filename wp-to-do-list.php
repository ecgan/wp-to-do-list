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
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'wporg' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
        ?>
      </form>
    </div>
    <?php
}

function add_admin_menu_main_page() {
    add_menu_page(
        __( 'WP To-do List', 'wp-to-do-list' ),
        __( 'WP To-do List 123', 'wp-to-do-list' ),
        'manage_options',
        'wp-to-do-list_main',
        'wporg_options_main_html',
        '',
        20
    );
}

add_action( 'admin_menu', 'add_admin_menu_main_page' );
