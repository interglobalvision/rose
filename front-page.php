<?php
get_header();
?>

<main <?php post_class('grid-item item-s-12'); ?>>

<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();

    $images = get_post_meta($post->ID, '_igv_images', true);
    $stockists = get_post_meta($post->ID, '_igv_stockists', true);
    $contact = get_post_meta($post->ID, '_igv_contact', true);
    $filter_color = get_post_meta($post->ID, '_igv_image_color', true);
    $accent_color = get_post_meta($post->ID, '_igv_accent_color', true);
?>

  <style type="text/css">
    .image-filter {
      background-color: <?php echo !empty($filter_color) ? $filter_color : 'transparent'; ?>;
    }
  </style>

<?php
  if (!empty($images)) {
?>
  <section id="images">
    <div class="container grid-row">
    <?php
      foreach ($images as $image) {
    ?>
      <style type="text/css">
        <?php
          echo '#image-' . $image['image_id'] . ' {';
          echo !empty($image['scale']) ? '
            width: calc(96vw*' . $image['scale'] . ');
          ' : '
            width: 96vw;
          ';
          echo '}'
        ?>
        @media screen and (min-width: 720px) {
          <?php
            echo '#image-' . $image['image_id'] . ' {';
            echo !empty($image['scale']) ? '
              width: calc(40vw*' . $image['scale'] . ');
              height: calc(40vh*' . $image['scale'] . ');
            ' : '
              width: 40vw;
              height: 40vh;
            ';
            echo !empty($image['top']) ? '
              top: ' . $image['top'] . 'vh;
            ' : '
              top: 10vh;
            ';
            echo !empty($image['left']) ? '
              left: ' . $image['left'] . 'vw;
            ' : '
              left: 10vw;
            ';
            echo '}'
          ?>
        }
      </style>
      <div id="image-<?php echo $image['image_id']; ?>" class="image-container grid-item">
        <div class="image-holder">
          <?php echo wp_get_attachment_image($image['image_id'], 'full'); ?>
          <div class="image-filter"></div>
        </div>
      <?php
        if (!empty($image['caption'])) {
      ?>
        <div class="image-caption padding-top-micro">
          <?php echo apply_filters('the_content', $image['caption']); ?>
        </div>
      <?php
        }
      ?>
      </div>
    <?php
      }
    ?>
    </div>
  </section>
<?php
  }
?>

  <section id="about" class="content-overlay">
    <div class="container grid-row justify-center">
      <div class="grid-row grid-item item-s-11 no-gutter">
        <div class="section-content grid-item font-size-large item-s-12 item-m-11">
          <?php the_content(); ?>
        </div>
        <div class="grid-item item-s-1">
          <div class="section-close u-pointer">X</div>
        </div>
      </div>
    </div>
  </section>

<?php
  if (!empty($stockists)) {
?>
  <section id="stockists" class="content-overlay">
    <div class="container grid-row">
      <div class="grid-row grid-item item-s-11 no-gutter">
      <?php
        foreach ($stockists as $stockist) {
      ?>
        <div class="section-content grid-item item-s-12 item-m-4 item-l-3">
          <?php echo apply_filters('the_content', $stockist['stockist']); ?>
        </div>
      <?php
        }
      ?>
      </div>
      <div class="grid-row grid-item item-s-1 no-gutter">
        <div class="grid-item">
          <div class="section-close u-pointer">X</div>
        </div>
      </div>
    </div>
  </section>
<?php
  }
?>

<?php
  if (!empty($contact)) {
?>
  <section id="contact" class="content-overlay">
    <div class="container grid-row justify-between">
      <div class="grid-item item-s-4">
        <div class="section-close u-pointer">X</div>
      </div>
      <div class="section-content grid-item item-s-12 item-m-8 text-align-right">
        <?php echo apply_filters('the_content', $contact); ?>
      </div>
    </div>
  </section>
<?php
  }
?>

<?php
  }
}
?>

</main>

<?php
get_footer();
?>
