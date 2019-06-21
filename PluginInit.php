<?php
class PluginInit
{
    public function __construct()
    {
      add_shortcode('testimonial_plugin', 'testimonial_init');
      function testimonial_init(){
        return create_slider($atts, $content);
      }


    function create_slider($atts, $content){
      $atts = shortcode_atts(array('numberposts' => 5), $atts);
      $html = array();
      $html[] = $content;
      $html[] ='<div class="container">';
      $html[] .=' <div class="row">';
      $html[] .='   <div class="col-md-12">';
      $html[] .='     <div class="carousel slide" data-ride="carousel" id="quote-carousel">';
      $html[] .='       <div class="carousel-inner text-center">';
      //foreach post
      $html[] .='         <div class="item active">';
      $html[] .='           <blockquote>';
      $html[] .='             <p>Test</p>';
      $html[] .='           </blockquote>';
      $html[] .='         </div>';
      $html[] .='         <div class="item active">';
      $html[] .='           <blockquote>';
      $html[] .='             <p>Test</p>';
      $html[] .='           </blockquote>';
      $html[] .='         </div>';
      //end foreach
      $html[] .='       </div>';
      $html[] .='     </div>';
      $html[] .='   </div>';
      $html[] .=' </div>';
      $html[] .='</div>';


      echo implode('', $html);
    }

    function create_form(){

    }
  }

}
