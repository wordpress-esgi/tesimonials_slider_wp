<div class="d-flex justify-content-center">
  <h3>Slider Plugin</h3>
  <br>
  <p>Below you'll find all informations related to this pluging</p>

</div>
<?php fetchTestimonial(); ?>

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
      <td><?= $testimonial->status ?></td>
      <td><?= $testimonial->created_at ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
