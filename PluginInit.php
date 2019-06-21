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
      $html[] .='             <div class="col-sm-8 col-sm-offset-2">';
      $html[] .='               <p>Test</p>';
      $html[] .='             </div>';
      $html[] .='           </blockquote>';
      $html[] .='         </div>';
      $html[] .='         <div class="item active">';
      $html[] .='           <blockquote>';
      $html[] .='             <div class="col-sm-8 col-sm-offset-2">';
      $html[] .='               <p>Test</p>';
      $html[] .='             </div>';
      $html[] .='           </blockquote>';
      $html[] .='         </div>';
      //end foreach
      $html[] .='       </div>';
      $html[] .='     </div>';
      $html[] .='   </div>';
      $html[] .=' </div>';
      $html[] .='</div>';
      $html[] .='<a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>';
      $html[] .='<a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>';



      echo implode('', $html);
    }

    function create_form(){

    }
  }

}
