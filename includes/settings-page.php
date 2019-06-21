<?php fetchTestimonial(); ?>
<?php get_enum_values_status(); ?>

<div class="col-md-12">
  <div class="row">
    <h1 style="text-align:center" clas>Slider Plugin</h1>
    <p style="text-align:center">Below you'll find all informations related to this pluging</p>
  </div>
</div>

<div class="col-md-12">
  <div class="row">
    <table class="table">

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
          <td><?= $testimonial->messsage ?></td>
          <td>
            <?php foreach($enumsValues as $enumsValue): ?>
              <option value="<?= $enumsValue ?>"><?= $enumsValue ?></option>
            <?php endforeach; ?>
          </td>
          <td><?= $testimonial->created_at ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
