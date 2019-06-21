<?php
/*
Plugin Name: Slider testimonial ESGI
Plugin URI: http://slider-testimonial-esgi.com
Description: Un plugin pour intégrer un slider et un formulaire pour les témoignages
Author: Alix, Charles, Fabien
Author URI: http://nous.com
Version: 0.1
*/

require_once plugin_dir_path(__FILE__).'includes/functions.php';
register_activation_hook(__FILE__, 'install');
register_deactivation_hook( __FILE__, 'remove_database' );

class TestimonialPlugin
{
  public function __construct()
  {
    include_once plugin_dir_path( __FILE__ ).'/PluginInit.php';
    new PluginInit();
  }
}

new TestimonialPlugin;
