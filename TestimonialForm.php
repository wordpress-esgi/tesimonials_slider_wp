<?php

class TestimonialForm {

    public function __construct(){
    }

    public function create_form(){
        $actionUrl= wp_get_referer();
        $formStr =
    <<< EOF
        <form action="$actionUrl" method="post">
          <div class="form-group">
            <label for="user_name">Nom</label>
            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="">
          </div>

          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
          </div>

          <input id="submit" type="submit" name="testimonial_form_submit" class="btn btn-primary" value="Envoyer" />
        </form>
EOF;

        if (isset($_GET['return'])){
            switch ($_GET['return']) {
                case 'erreur' :
                    $errorMsg= "erreur";
                    $formStr .= "<div class=\"alert alert-danger\"> $errorMsg </div>";
                    break;

                case 'success' :
                    $errorMsg= "Avis envoyé!";
                    $formStr .= "<div class=\"alert alert-success\"> $errorMsg </div>";
				            break;

			          default :
                  $errorMsg= 'Une erreur est survenue.';
                  $formStr .= "<div class=\"alert alert-danger\"> $errorMsg </div>";

		              }
                }
        return $formStr;
    }
}
