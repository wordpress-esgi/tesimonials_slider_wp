<?php


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
                        status int NOT NULL DEFAULT 0,
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
