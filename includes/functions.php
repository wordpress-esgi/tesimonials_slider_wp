<?php
require_once plugin_dir_path(__FILE__).'../TestimonialForm.php';

add_action( 'wp_enqueue_scripts', 'Bootstrap_style' );
function Bootstrap_style() {
    wp_enqueue_style( 'myStyle', get_stylesheet_uri());
    wp_enqueue_style('Bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('BootJs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css' );
}

function load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style1', $plugin_url . 'css/testimonial-plugin-style.css' );
}
add_action( 'wp_enqueue_scripts', 'load_plugin_css' );



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


// Init Widget

class TestimonialsWidget extends WP_Widget
{

  function __construct()
  {
    parent::__construct(
      'slider-widget',
      esc_html__('Témoignages', 'mtp_domain'),
      array(
        'description' => esc_html__('Un widget pour les témoignages', 'mtp_domain'),
      )
    );
  }

	// Front display

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
    $testimonials = fetchTestimonialApproved();

    $html = '';
    $html .='<div class="container">';
    $html .=' <div class="row">';
    $html .='   <div class="col-md-12">';
    $html .='     <div>';
    $html .='     <h2 class="title-testimonial">'.$instance['title'].'</h2>';
    $html .='     </div>';
    $html .='     <div id="carouselTestimonialWidget" class="carousel slide" data-ride="carousel" data-interval="'.$instance['speed'].'">';
    $html .='        <div class="carousel-inner text-center carousel-testimonial-plugin">';
    $i = 0;
    if(!empty($testimonials)){
      foreach($testimonials as $testimonial){
        if($i < $instance['numberslide']){
          if ($i == 0) {
            $html .='         <div class="carousel-item active slide-testimonial-plugin">';
            $html .='               <p class="testimonial-message">'.$testimonial->message.'</p>';
            $html .='               <p class="testimonial-user"><small>'.$testimonial->user_name.'</small></p>';
            $html .='         </div>';
          } else {
            $html .='         <div class="carousel-item slide-testimonial-plugin">';
            $html .='               <p class="testimonial-message">'.$testimonial->message.'</p>';
            $html .='               <p class="testimonial-user"><small>'.$testimonial->user_name.'</small></p>';
            $html .='         </div>';
          }
        }
        $i++;
      }
    }else{
      $html .='         <div class="carousel-item active slide-testimonial-plugin">';
      $html .='               <p class="testimonial-message">Laissez le premier témoignage !</p>';
      $html .='         </div>';
    }
    $html .='       </div>';
    $html .='<a class="carousel-control-prev testimonial-control" href="#carouselTestimonialWidget" role="button" data-slide="prev"><i class="fas fa-'.$instance['prev'].'"></i></a>';
    $html .='<a class="carousel-control-next testimonial-control" href="#carouselTestimonialWidget" role="button" data-slide="next"><i class="fas fa-'.$instance['next'].'"></i></a>';
    $html .='     </div>';
    $html .='   </div>';
    $html .=' </div>';
    $html .='</div>';

    $form = new TestimonialForm();
    $html .= $form->create_form();

    echo $html;
		echo $args['after_widget'];
	}

  // Widget's form back

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Les Témoignages', 'mtp_domain' );
		$speed = ! empty( $instance['speed'] ) ? $instance['speed'] : esc_html__( '4000', 'mtp_domain' );
		$numberSlide = ! empty( $instance['numberslide'] ) ? $instance['numberslide'] : esc_html__( '4', 'mtp_domain' );
		$prev = ! empty( $instance['prev'] ) ? $instance['prev'] : esc_html__( 'angle-left', 'mtp_domain' );
		$next = ! empty( $instance['next'] ) ? $instance['next'] : esc_html__( 'angle-right', 'mtp_domain' );
		echo '<p>
			<label for="'.esc_attr($this->get_field_id('title')).'">'.esc_attr_e('Titre :','mtp_domain').'</label>
			<input class="widefat" id="'.esc_attr($this->get_field_name('title')).'" name="'.esc_attr($this->get_field_name('title')).'" type="text" value="'.esc_attr($title).'">
      </p>';
    echo  '<p>
    <label for="'.esc_attr($this->get_field_id('speed')).'">'.esc_attr_e('Vitesse (en millisecondes) :','mtp_domain').'</label>
    <input class="widefat" id="'.esc_attr($this->get_field_name('speed')).'" name="'.esc_attr($this->get_field_name('speed')).'" type="text" value="'.esc_attr($speed).'">
    </p>';
    echo  '<p>
    <label for="'.esc_attr($this->get_field_id('numberslide')).'">'.esc_attr_e('Nombre de slides :','mtp_domain').'</label>
    <input class="widefat" id="'.esc_attr($this->get_field_name('numberslide')).'" name="'.esc_attr($this->get_field_name('numberslide')).'" type="text" value="'.esc_attr($numberSlide).'">
    </p>';
    echo  '<p>
    <label for="'.esc_attr($this->get_field_id('prev')).'">'.esc_attr_e('Icône précédent :','mtp_domain').'</label>
    <input class="widefat" id="'.esc_attr($this->get_field_name('prev')).'" name="'.esc_attr($this->get_field_name('prev')).'" type="text" value="'.esc_attr($prev).'"></p>';
    echo  '<p>
    <label for="'.esc_attr($this->get_field_id('next')).'">'.esc_attr_e('Icône suivant :','mtp_domain').'</label>
    <input class="widefat" id="'.esc_attr($this->get_field_name('next')).'" name="'.esc_attr($this->get_field_name('next')).'" type="text" value="'.esc_attr($next).'">
    </p>';
	}

	// update data
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['speed'] = ( ! empty( $new_instance['speed'] ) ) ? sanitize_text_field( $new_instance['speed'] ) : '';
		$instance['numberslide'] = ( ! empty( $new_instance['numberslide'] ) ) ? sanitize_text_field( $new_instance['numberslide'] ) : '';
		$instance['prev'] = ( ! empty( $new_instance['prev'] ) ) ? sanitize_text_field( $new_instance['prev'] ) : '';
		$instance['next'] = ( ! empty( $new_instance['next'] ) ) ? sanitize_text_field( $new_instance['next'] ) : '';

		return $instance;
	}

}
add_action('widgets_init', 'mtp_register_widgets');

function mtp_register_widgets(){
    register_widget('TestimonialsWidget');
}
