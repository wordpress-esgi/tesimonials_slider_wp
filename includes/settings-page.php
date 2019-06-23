<?php $testimonials = fetchTestimonial(); ?>
<?php $enumsValues = get_enum_values_status(); ?>
<?php updateValues(); ?>

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
      Below are data about Slider
    </div>

    <form class="col-md-12" action="<?php wp_redirect( "settings-page.php" ); ?>" method="post">
      <table class="table mb-5">

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
              <select name="status[]">
                <?php foreach($enumsValues as $enumsValue): ?>
                  <option value="<?= $enumsValue ?>"><?= $enumsValue ?></option>
                <?php endforeach; ?>
              </select>
            </td>
            <td><?= $testimonial->created_at ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="row mt-5">
      <div class="w-100 alert alert-primary text-center mb-4" role="alert">
        Fill the form to configure slider's settings
      </div>

        <div class="col-md-12 form-group">
          <label for="scrollingTimer">Scrolling Time </label>
          <select class="form-control" name="scrollingTimer" id="scrollingTimer">
            <option value="1" selected>1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>

        <div class="col-md-12 form-group">
          <label for="numberOfPicture">Picture's number</label>
          <select class="form-control" name="numberOfPicture" id="numberOfPicture">
            <option value="2" selected>2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>

        <div class="col-md-12 text-center">
          <button type="submit" name="update" class="btn btn-primary ">Submit</button>
        </div>

    </form>
  </div>
</div>
