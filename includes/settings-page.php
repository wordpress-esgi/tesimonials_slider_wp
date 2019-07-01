<?php updateValues(); ?>
<?php $testimonials = fetchTestimonial(); ?>
<?php $enumsValues = get_enum_values_status(); ?>



<div class="col-md-12 mb-5">
  <div class="row">
    <h1  class="w-100 text-center">Slider Plugin</h1>
    <p class="w-100  text-center">Below you'll find all informations related to this pluging</p>

    <!-- <div class="alert alert-primary" role="alert">
      Here are the data related to the slider
    </div> -->
  </div>
</div>

<div class="offset-md-1 col-md-10">
  <div class="row">

    <div class="w-100 alert alert-primary text-center mb-4" role="alert">
      <h4 class="alert-heading">Below are data about Slider</h4>
    </div>

    <form class="col-md-12" action="<?php wp_redirect( "settings-page.php" ); ?>" method="post">
      <table class="table mb-5 text-center">

        <thead>
          <tr>
            <th scope="col">User</th>
            <th scope="col">Message</th>
            <th scope="col">Status</th>
            <th scope="col">Created</th>
          </tr>
        </thead>

        <tbody>
        <?php foreach($testimonials as $testimonial): ?>

          <tr>
            <td><?= $testimonial->user_name ?></td>
            <td><?= $testimonial->message ?></td>
            <td>
              <input type="hidden" name="id[]" value="<?= $testimonial->id; ?>" />
              <select name="status[]" id="status">

                <?php foreach($enumsValues as $enumsValue): ?>

                  <?php if ($testimonial->status == $enumsValue): ?>
                    <option id="selectedOption" value="<?= $enumsValue ?>" selected><?= $enumsValue ?></option>
                  <?php endif; ?>

                  <?php if ($testimonial->status != $enumsValue): ?>
                    <option value="<?= $enumsValue ?>"><?= $enumsValue ?></option>
                  <?php endif; ?>

                <?php endforeach; ?>
              </select>
            </td>
            <td><?= $testimonial->created_at ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <div class="col-md-12 text-center mb-4">
        <button type="submit" name="update" class="btn btn-primary ">Submit</button>
      </div>

    </form>

    <!-- <div class="w-100 alert alert-warning mb-4 mt-4" role="alert">
      <h4 class="alert-heading mb-4">You will find below how to configure slider's configurations</h4>
      <p>By editing shortcode, you can set your own configurations  :</p>
      <p class="mb-0"><strong>Example :</strong> [testimonial_plugin numberslide="3" speed="1000"]</p>
    </div> -->

    <div class="w-100 alert alert-primary text-center mb-5" role="alert">
      <h4 class="alert-heading">How to use shortcode to set slider's configuration ?</h4>
    </div>

    <div class="w-100 mb-5">
      <h5 class="mt-5 mb-5 text-center">Basic shortcode :</h5>
      <p class="font-italic">Title is how to call <strong>shortcode</strong> :</p>
      <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin]</p>
    </div>

<!-- [testimonial_plugin speed="2000" numberslide="3" prev="angle-left" next="angle-right" title="Title"]  -->
    <div class="w-100">
      <h5 class="mt-5 mb-5 text-center">You can customize the slider with parameters in shortcode :</h5>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Title is defined on <strong>"Slider's title"</strong> :</p>
        <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin title="Title"]</p>
      </div>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Scrolling speed defined on <strong>2000ms</strong> :</p>
        <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin speed="2000"]</p>
      </div>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Image number defined on <strong>3</strong> : </p>
        <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin numberslide="3"]</p>
      </div>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Scrolling left icon is define on <strong>"angle-left"</strong> font awesome's class :</p>
        <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin prev="angle-left"]</p>
      </div>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Scrolling right icon is define on <strong>"angle-right"</strong> font awesome's class :</p>
        <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin next="angle-right"]</p>
      </div>
    </div>

    <div class="w-100 mb-5">
      <h5 class="mt-5 mb-5 text-center">You can add multiple parameters in shortcode :</h5>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Example with <strong>speed & title :</strong></p>
        <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin speed="2000" title="Title"]</p>
      </div>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Example with <strong>slide's number & left/rigth scrolling icons :</strong></p>
        <p class="w-50 alert alert-warning text-center mb-4">[testimonial_plugin numberslide="3" prev="angle-left" next="angle-right"]</p>
      </div>

      <div class="aCustomization w-100 mb-5">
        <p class="font-italic">Example with <strong>all parameters</strong></p>
        <p class="w-75 alert alert-warning text-center mb-4">[testimonial_plugin speed="2000" numberslide="3" prev="angle-left" next="angle-right" title="Title"]</p>
      </div>


    </div>

  </div>





  </div>
</div>
