<?php
class PluginInit
{
    public function __construct()
    {
      add_shortcode('testimonial_plugin', 'testimonial_init');
      function testimonial_init($atts, $content= null) {
          $a = shortcode_atts(
              array(
                  'numberslide' => '2',
                  'title' => 'Les derniers témoignages',
                  'speed' => '4000',
                  'prev'=> 'chevron-left',
                  'next'=> 'chevron-right'
              ), $atts);
          //transforme les paramètres en variables
//          extract($atts);
        return create_slider($a);
      }


    function create_slider($atts){


      $testimonials = fetchTestimonialApproved();

      $numberSlide = $atts['numberslide'];
      $title = $atts['title'];
      $speed= $atts['speed'];
      $prev = $atts['prev'];
      $next = $atts['next'];

      $html = '';
      $html .='<div class="container">';
      $html .=' <div class="row">';
      $html .='   <div class="col-md-12">';
      $html .='     <div>';
      $html .='     <h2 class="title-testimonial">'.$title.'</h2>';
      $html .='     </div>';
      $html .='     <div id="carouselTestimonial" class="carousel slide" data-ride="carousel" data-interval="'.$speed.'">';
      $html .='        <div class="carousel-inner text-center carousel-testimonial-plugin">';
      $i = 0;
      foreach($testimonials as $testimonial){
        if($i < $numberSlide){
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
      $html .='       </div>';
      $html .='<a class="carousel-control-prev testimonial-control" href="#carouselTestimonial" role="button" data-slide="prev"><i class="fas fa-'.$prev.'"></i></a>';
      $html .='<a class="carousel-control-next testimonial-control" href="#carouselTestimonial" role="button" data-slide="next"><i class="fas fa-'.$next.'"></i></a>';
      $html .='     </div>';
      $html .='   </div>';
      $html .=' </div>';
      $html .='</div>';
      return $html;
    }

    function create_form(){

    }
  }

}
