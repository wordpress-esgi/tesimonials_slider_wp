<?php
class PluginInit
{
    public function __construct()
    {
      add_shortcode('testimonial_plugin', 'testimonial_init');
      function testimonial_init($atts, $content= null) {
          $a = shortcode_atts(
              array(
                  'numberposts' => '4',
                  'parametre2' => '4000',
                  'parametre3'=> null
              ), $atts);
          //transforme les paramètres en variables
//          extract($atts);
        return create_slider($a);
      }


    function create_slider($atts){


      $testimonials = fetchTestimonialApproved();

      $numberPosts = $atts['numberposts'];
      $param2= $atts['parametre2'];
      $param3= $atts['parametre3'];
      $html = '';
      $html .='<div class="container">';
      $html .=' <div class="row">';
      $html .='   <div class="col-md-12">';
      $html .='     <div id="carouselTestimonial" class="carousel slide" data-ride="carousel" data-interval="'.$param2.'">';
      $html .='        <div class="carousel-inner text-center carousel-testimonial-plugin">';
      $i = 0;
      foreach($testimonials as $testimonial){
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
        $i++;
      }
      $html .='       </div>';
      $html .='     </div>';

      $html .='<a class="carousel-control-prev testimonial-control" href="#carouselTestimonial" role="button" data-slide="prev"><i class="fa fa-chevron-left"></i></a>';
      $html .='<a class="carousel-control-next testimonial-control" href="#carouselTestimonial" role="button" data-slide="next"><i class="fa fa-chevron-right"></i></a>';
      $html .='   </div>';
      $html .=' </div>';
      $html .='</div>';
      return $html;
    }

    function create_form(){

    }
  }

}
