<?php
class PluginInit
{
    public function __construct()
    {
      add_shortcode('testimonial_plugin', 'create_slider');
      function testimonial_init(){
        return create_slider();
      }


    function create_slider(){
      // $atts = shortcode_atts(array('numberposts' => 5), $atts);
      // $html = array();
      // $html[] = $content;
      // $html[] =
      //
      // echo implode('', $html);
      return  '<p>Test</p>';

    }

    function create_form(){

    }
  }

}
