<?php

/* Get post objects for select field options */
function get_post_objects( $query_args ) {
  $args = wp_parse_args( $query_args, array(
    'post_type' => 'post',
  ) );
  $posts = get_posts( $args );
  $post_options = array();
  if ( $posts ) {
    foreach ( $posts as $post ) {
      $post_options [ $post->ID ] = $post->post_title;
    }
  }
  return $post_options;
}


/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add metaboxes. Can only happen on the 'cmb2_init' hook.
 */
add_action( 'cmb2_init', 'igv_cmb_metaboxes' );
function igv_cmb_metaboxes() {

  // Start with an underscore to hide fields from custom fields list
  $prefix = '_igv_';

  /**
   * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
   */

  $home_page = get_page_by_path('home');

  if(!empty($home_page)) {

    $home_metabox = new_cmb2_box( array(
      'id'            => $prefix . 'home_metabox',
      'title'         => esc_html__( 'Options', 'cmb2' ),
      'object_types'  => array( 'page' ), // Post type
      'show_on'      => array(
        'key' => 'id',
        'value' => array($home_page->ID)
      ),
    ) );

    $home_metabox->add_field( array(
  		'name'    => esc_html__( 'Contact', 'cmb2' ),
  		'desc'    => esc_html__( 'Telephone links use tel:5555555555', 'cmb2' ),
  		'id'      => $prefix . 'contact',
  		'type'    => 'wysiwyg',
  		'options' => array(
        'media_buttons' => false, // show insert/upload button(s)
        'textarea_rows' => get_option('default_post_edit_rows', 5), // rows="..."
      ),
  	) );

    $home_metabox->add_field( array(
  		'name'    => esc_html__( 'Image color', 'cmb2' ),
  		'desc'    => esc_html__( '', 'cmb2' ),
  		'id'      => $prefix . 'image_color',
  		'type'    => 'colorpicker',
  		'default' => '#f6e028',
  	) );

    $home_metabox->add_field( array(
  		'name'    => esc_html__( 'Accent color', 'cmb2' ),
  		'desc'    => esc_html__( '', 'cmb2' ),
  		'id'      => $prefix . 'accent_color',
  		'type'    => 'colorpicker',
  		'default' => '#f61e43',
  	) );

    // IMAGES

    $images_metabox = new_cmb2_box( array(
      'id'            => $prefix . 'images_metabox',
      'title'         => esc_html__( 'Images', 'cmb2' ),
      'object_types'  => array( 'page' ), // Post type
      'show_on'      => array(
        'key' => 'id',
        'value' => array($home_page->ID)
      ),
    ) );

    $images_group = $images_metabox->add_field( array(
      'id'          => $prefix . 'images',
      'type'        => 'group',
      'description' => esc_html__( '', 'cmb2' ),
      'options'     => array(
        'group_title'   => esc_html__( 'Image {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'    => esc_html__( 'Add Another Image', 'cmb2' ),
        'remove_button' => esc_html__( 'Remove Image', 'cmb2' ),
        'sortable'      => true, // beta
        // 'closed'     => true, // true to have the groups closed by default
      ),
    ) );

    $images_metabox->add_group_field( $images_group, array(
      'name'       => esc_html__( 'Image', 'cmb2' ),
      'id'         => 'image',
      'type'       => 'file',
      'description' => esc_html__( '', 'cmb2' ),
      'query_args' => array(
        'type' => array(
    		 	'image/gif',
    		 	'image/jpeg',
    		 	'image/png',
    		 ),
       ),
       'preview_size' => array( 150, 150 ),
    ) );

    $images_metabox->add_group_field( $images_group, array(
      'name'       => esc_html__( 'Caption', 'cmb2' ),
      'id'         => 'caption',
      'type'       => 'wysiwyg',
      'description' => esc_html__( '', 'cmb2' ),
      'options' => array(
        'media_buttons' => false, // show insert/upload button(s)
        'textarea_rows' => get_option('default_post_edit_rows', 5), // rows="..."
      ),
    ) );

    // STOCKISTS

    $stockists_metabox = new_cmb2_box( array(
      'id'            => $prefix . 'stockists_metabox',
      'title'         => esc_html__( 'Stockists', 'cmb2' ),
      'object_types'  => array( 'page' ), // Post type
      'show_on'      => array(
        'key' => 'id',
        'value' => array($home_page->ID)
      ),
    ) );

    $stockists_group = $stockists_metabox->add_field( array(
      'id'          => $prefix . 'stockists',
      'type'        => 'group',
      'description' => esc_html__( '', 'cmb2' ),
      'options'     => array(
        'group_title'   => esc_html__( 'Stockist {#}', 'cmb2' ), // {#} gets replaced by row number
        'add_button'    => esc_html__( 'Add Another Stockist', 'cmb2' ),
        'remove_button' => esc_html__( 'Remove Stockist', 'cmb2' ),
        'sortable'      => true, // beta
        // 'closed'     => true, // true to have the groups closed by default
      ),
    ) );

    $stockists_metabox->add_group_field( $stockists_group, array(
      'name'       => esc_html__( 'Stockist', 'cmb2' ),
      'id'         => 'stockist',
      'type'       => 'wysiwyg',
      'description' => esc_html__( 'Telephone links use tel:5555555555', 'cmb2' ),
      'options' => array(
        'media_buttons' => false, // show insert/upload button(s)
        'textarea_rows' => get_option('default_post_edit_rows', 5), // rows="..."
      ),
    ) );

  }

}
?>
