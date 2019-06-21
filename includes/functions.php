<?php


//hook 'admin_menu'
add_action('admin_menu', 'myplugin_add_admin_link');

function myplugin_add_admin_link(){
  add_menu_page(
    'Testimonial Slider',
    'Temoignages',
    'manage_options',
    'testimonials_slider_wp/includes/settings-page.php'
  );
}
