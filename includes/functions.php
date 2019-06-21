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
  $testimonials = $wpdb->get_results( "SELECT * FROM Testimonial");
  return $testimonials;
}
