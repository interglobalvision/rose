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
    ::selection {
      background: <?php echo !empty($filter_color) ? $filter_color : 'default'; ?>;
    }
    .image-filter {
      background-color: <?php echo !empty($filter_color) ? $filter_color : 'transparent'; ?>;
    }
    .image-active a,
    .image-active a:visited,
    .image-active a:active,
    .image-container:hover a,
    .image-container:hover a:visited,
    .image-container:hover a:active,
    .nav-item.active {
      color: <?php echo !empty($accent_color) ? $accent_color : '#000000'; ?>
    }
    #cursor.down path {
      fill: <?php echo !empty($accent_color) ? $accent_color : '#000000'; ?>
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
              width: calc(30vw*' . $image['scale'] . ');
            ' : '
              width: 30vw;
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
          <?php echo wp_get_attachment_image($image['image_id'], 'gallery', false, 'data-no-lazysizes=true'); ?>
          <div class="image-filter"></div>
        </div>
      <?php
        if (!empty($image['caption'])) {
      ?>
        <div class="image-caption padding-top-micro font-size-small text-align-center">
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
    <div class="section-content-holder">
      <div class="section-content-wrapper font-size-large">
        <div class="container padding-bottom-basic grid-row">
          <div class="grid-item item-s-12 item-m-10 no-gutter grid-row justify-center">
            <div class="section-content grid-item item-s-12 item-m-11 font-sans">
              <?php the_content(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section-close-holder">
      <div class="container grid-row justify-end">
        <div class="grid-item item-s-1">
          <span class="section-close"><img class="close-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/img/rose-close.svg" </span>
        </div>
      </div>
    </div>
  </section>

<?php
  if (!empty($stockists)) {
?>
  <section id="stockists" class="content-overlay">
    <div class="section-content-holder">
      <div class="section-content-wrapper">
        <div class="container padding-bottom-basic grid-row">
          <div class="section-content grid-item item-s-12 item-m-10 no-gutter grid-row justify-center">
          <?php
            foreach ($stockists as $stockist) {
          ?>
            <div class="grid-item item-s-6 item-m-4 item-l-3 margin-bottom-small">
              <?php echo apply_filters('the_content', $stockist['stockist']); ?>
            </div>
          <?php
            }
          ?>
          </div>
        </div>
      </div>
    </div>
    <div class="section-close-holder">
      <div class="container grid-row justify-end">
        <div class="grid-item item-s-1">
          <span class="section-close"><img class="close-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/img/rose-close.svg" </span>
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
    <div class="section-content-holder">
      <div class="section-content-wrapper">
        <div class="container padding-bottom-basic grid-row">
          <div class="section-content grid-item item-s-12 offset-m-7 item-m-5 text-align-right padding-bottom-basic font-size-small font-sans">
            <?php echo apply_filters('the_content', $contact); ?>
          </div>
        </div>
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
