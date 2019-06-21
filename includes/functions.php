<?php

add_action( 'wp_enqueue_scripts', 'myStyle' );
function myStyle() {
    wp_enqueue_style( 'myStyle', get_stylesheet_uri());
    wp_enqueue_style('Bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}

function load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style1', $plugin_url . 'css/testimonial-plugin-style.css' );
}
add_action( 'wp_enqueue_scripts', 'load_plugin_css' );


//hook 'admin_menu'
add_action('admin_menu', 'testimonial_add_admin_link');

function testimonial_add_admin_link(){
  add_menu_page(
    'Testimonial Slider',
    'Temoignages',
    'manage_options',
    'testimonials_slider_wp/includes/settings-page.php'
  );
}

function fetchTestimonial()
{
    global $wpdb;
  $testimonial_table_name = $wpdb->prefix . 'testimonial';
  $testimonials = $wpdb->get_results( "SELECT * FROM $testimonial_table_name");
  return $testimonials;
}

function install(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $testimonial_table_name = $wpdb->prefix . 'testimonial';

    $testimonial_sql = "CREATE TABLE IF NOT EXISTS $testimonial_table_name (
                        id MEDIUMINT NOT NULL AUTO_INCREMENT,
                        user_name varchar(45) NOT NULL,
                        message TINYTEXT NOT NULL,
                        status ENUM('PENDING', 'APPROVED', 'REJECTED') NOT NULL DEFAULT 'PENDING',
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY  (id)
                    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($testimonial_sql);
}

// Delete table when deactivate
function remove_database() {
    global $wpdb;
    $testimonial_table_name = $wpdb->prefix . 'testimonial';
    $sql = "DROP TABLE IF EXISTS $testimonial_table_name;";
    $wpdb->query($sql);
}
