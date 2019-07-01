<?php

add_action( 'wp_enqueue_scripts', 'Bootstrap_style' );
function Bootstrap_style() {
    wp_enqueue_style( 'myStyle', get_stylesheet_uri());
    wp_enqueue_style('Bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('BootJs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
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

add_action('admin_head',  'add_bootstrap_admin_head');

function add_bootstrap_admin_head() {
  wp_enqueue_style('AdminBootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
  wp_enqueue_script('AdminJquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
  wp_enqueue_script('jsCustom', plugin_dir_url( __FILE__ ).'script.js', array(), null, true);
  wp_enqueue_style( 'AdminFA', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}

function fetchTestimonial()
{
  global $wpdb;
  $testimonial_table_name = $wpdb->prefix . 'testimonial';
  $testimonials = $wpdb->get_results( "SELECT * FROM $testimonial_table_name");
  return $testimonials;
}

function fetchTestimonialApproved()
{
  global $wpdb;
  $testimonial_table_name = $wpdb->prefix . 'testimonial';
  $testimonialsApproved = $wpdb->get_results( "SELECT * FROM $testimonial_table_name WHERE status='APPROVED'");
  return $testimonialsApproved;
}

function fetchAuthorAndDescription()
{
  global $wpdb;
  $testimonial_table_name = $wpdb->prefix . 'testimonial';
  $testimonials = $wpdb->get_results( "SELECT user_name,message FROM $testimonial_table_name");
  return $testimonials;
}


function get_enum_values_status()
{
  global $wpdb;
  $testimonial_table_name = $wpdb->prefix . 'testimonial';
  $results = $wpdb->get_results( "SHOW FIELDS FROM $testimonial_table_name LIKE 'status'" );
  foreach ($results as $result) {
    $array = get_object_vars($result);
    $enums = $array['Type'];
    preg_match('/enum\((.*)\)$/', $enums, $matches);
    $enumsValues = explode(',', $matches[1]);
    $enumsValues = str_replace('\'', "", $enumsValues);
  }
  return $enumsValues;
}

function postedValuesFormSlider()
{
  $postedValues = [];

  if(isset($_POST['update'])){
    for ($i=0; $i < count($_POST); $i++) {
      if(!empty($_POST['id'][$i]) && !empty($_POST['id'][$i])) {
      $postedValues['testimonial'.$i]['id'] = $_POST['id'][$i];
      $postedValues['testimonial'.$i]['status'] = $_POST['status'][$i];
      }
    }
  }
  return $postedValues;
}

function updateValues()
{
  global $wpdb;
  $testimonial_table_name = $wpdb->prefix . 'testimonial';
  $postedValues = postedValuesFormSlider();

  foreach ($postedValues as $aTestimonial => $aTestimonialValues) {
    $updateQuery = "UPDATE {$testimonial_table_name}
                    SET status = '{$aTestimonialValues['status']}'
                    WHERE id = {$aTestimonialValues['id']}";
    $wpdb->query($updateQuery);
  }

}

function addTestimonialFromForm(array $data){
    global $wpdb;
    $testimonial_table_name = $wpdb->prefix . 'testimonial';
    $sql = "INSERT INTO ".$testimonial_table_name." (user_name, message) VALUES ('".$data['user_name']."', '".$data['message']."')";
    $wpdb->query($sql);
}

function add_testimonial_treatment() {

    if (isset($_POST) && !empty($_POST)) {
        addTestimonialFromForm($_POST);
        $url = add_query_arg('return', 'success', wp_get_referer());
        wp_safe_redirect($url);
        exit();
    }
}
add_action('template_redirect', 'add_testimonial_treatment');

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
