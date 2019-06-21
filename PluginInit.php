<?php
class PluginInit
{
    public function __construct()
    {
      add_shortcode('testimonial_plugin', 'create_slider');
      function testimonial_init(){
        return create_slider($atts, $content);
      }


    function create_slider($atts, $content){
      $atts = shortcode_atts(array('numberposts' => 5), $atts);
      $html = array();
      $html[] = $content;
      $html[] ='<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">';
      $html[] .='<p>Test slider</p>';
      $html[] .='</div>';


      echo implode('', $html);
    }

    function create_form(){

    }
  }

}
