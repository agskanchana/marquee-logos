<?php
/*
 * Plugin Name:       Marquee Logos
 * Plugin URI:        www.linkedin.com/in/sameera-kanchana-3b4660198
 * Description:       animated logos
 * Version:           1.0.0
 * Requires at least: 1.2
 * Requires PHP:      7.2
 * Author:            Sameera
 * Author URI:       www.linkedin.com/in/sameera-kanchana-3b4660198
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       marquee-logos
 * Domain Path:       /languages
 */

if( !function_exists('carbon_fields_boot_plugin')){
  include_once( plugin_dir_path( __FILE__ ) . 'carbon-fields/carbon-fields-plugin.php' );
}


use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'marquee_fields' );
function marquee_fields() {
	Container::make( 'post_meta', '.' )
    ->where( 'post_type', '=', 'marquee' )
    ->add_fields( array(
        Field::make( 'complex', 'marquee_images', __( 'Marquee Images' ) )
    ->add_fields( array(
      Field::make( 'image', 'marquee_image', __( 'Image' ) )



    ) )
    ));


    Container::make( 'post_meta', 'Settings' )
    ->where( 'post_type', '=', 'marquee' )
    ->set_context( 'side' )
    ->add_fields( array(
      Field::make( 'text', 'width', __( 'Width' ) )
    ->set_default_value( 200 ),
    Field::make( 'text', 'height', __( 'Height' ) )
    ->set_default_value( 200 ),
      Field::make( 'select', 'speed', __( 'Speed' ) )
      ->set_options( array(
        '60' => 60,
        '10' => 10,
        '20' => 20,
        '30' => 30,
        '40' => 40,
        '50' => 50,
        '60' => 60,
        '70' => 70,
        '80' => 80,
        '90' => 90,
        '100' => 100,
        '110' => 110,
        '120' => 120,
        '130' => 130,
        '140' => 140,
        '150' => 150,
      ) ),
      Field::make( 'select', 'gap', __( 'Gap' ) )
      ->set_options( array(
        '20' => 20,
        '5' => 5,
        '10' => 10,
        '15' => 15,
        '20' => 20,
        '25' => 25,
        '30' => 30,
        '35' => 35,
        '40' => 40,
        '45' => 45,
        '50' => 50,
        '55' => 55,
        '60' => 60,
        '65' => 65,
        '70' => 70,
        '75' => 75,
        '80' => 80,
        '85' => 85,
        '90' => 90,
        '95' => 95,
        '100' => 100,
      ) ),
      Field::make( 'select', 'marquee_direction', __( 'Direction' ) )
      ->set_options( array(
        '' => 'left',
        'marquee--reverse' => 'right',
      ) )
    ));



  }



function marquee_post_type(){
  $labels = array(
          'name' => 'Marquee',
          'singular_name' => 'marquee',
          'add_new' => 'Add New Item'
  );

  $args = array(
                      'labels' => $labels,
                      'supports'              => array( 'title',  ),
                      'hierarchical'          => false,
                      'public'                => false,
                      'show_ui'               => true,
                      'show_in_menu'          => true,
                      'menu_position'         => 5,
                      'menu_icon'             => 'dashicons-format-chat',
                      'show_in_admin_bar'     => true,
                      'show_in_nav_menus'     => false,
                      'can_export'            => true,
                      'has_archive'           => false,
                      'exclude_from_search'   => true,
                      'publicly_queryable'    => false,
                      'query_var'                        => false,
                      'capability_type'       => 'post'


  );
  register_post_type( 'marquee', $args );
}

add_action( 'init', 'marquee_post_type');



add_filter('manage_marquee_posts_columns', 'marquee_table_head');

function marquee_table_head( $defaults ) {
    $defaults['shortcode']  = 'Shortcode';
    return $defaults;
}


add_action( 'manage_marquee_posts_custom_column', 'marquee_table_content', 10, 2 );



function marquee_table_content( $column_name, $post_id ) {

    if ($column_name == 'shortcode') {

        echo  '[marquee id="'.$post_id.'"]';

    }

}





add_shortcode('marquee',function($atts){
    ob_start();
    $post_id = $atts['id'];


?>

<?php
if(carbon_get_post_meta($post_id, 'marquee_images')):
?>

<div id="marq_<?php echo $post_id;?>" class="wrapper">
        <div style="gap: <?php echo carbon_get_post_meta($post_id, 'gap');?>px;" class="marquee <?php echo carbon_get_post_meta($post_id, 'marquee_direction');?>">
            <div class="marquee-group"  style="gap: <?php echo carbon_get_post_meta($post_id, 'gap');?>px;" >
                <?php foreach(carbon_get_post_meta($post_id, 'marquee_images') as $marquee_image ):?>
                <div
                style="width: <?php echo carbon_get_post_meta($post_id, 'width');?>px; height: <?php echo carbon_get_post_meta($post_id, 'height');?>px;"
                class="marquee-item"
                <?php if(carbon_get_post_meta($post_id, 'background')):?> style="background: <?php echo carbon_get_post_meta($post_id, 'background');?>;" <?php endif;?>>
                <?php echo wp_get_attachment_image($marquee_image['marquee_image'], 'full');?>
                </div>
                <?php endforeach;?>
            </div>
            <div aria-hidden="true" class="marquee-group"  style="gap: <?php echo carbon_get_post_meta($post_id, 'gap');?>px;">
            <?php foreach(carbon_get_post_meta($post_id, 'marquee_images') as $marquee_image ):?>
                <div
                style="width: <?php echo carbon_get_post_meta($post_id, 'width');?>px; height: <?php echo carbon_get_post_meta($post_id, 'height');?>px;"
                class="marquee-item"
                <?php if(carbon_get_post_meta($post_id, 'background')):?> style="background: <?php echo carbon_get_post_meta($post_id, 'background');?>;" <?php endif;?>>
                <?php echo wp_get_attachment_image($marquee_image['marquee_image'], 'full');?>
                </div>
              <?php endforeach;?>
            </div>
        </div>
  </div>
  <style>
    #marq_<?php echo $post_id;?> .marquee-group{
      animation: scroll-x <?php echo carbon_get_post_meta($post_id, 'speed');?>s  linear infinite;
    }
    #marq_<?php echo $post_id;?> .marquee--reverse  .marquee-group{
      animation-direction: reverse;
    }
  </style>
<?php endif;?>

    <?php
     return ob_get_clean();

});


function marquee_scripts() {
  $plugin_url = plugin_dir_url( __FILE__ );

wp_enqueue_style( 'style',  $plugin_url . "css/style.css");
}

add_action( 'wp_enqueue_scripts', 'marquee_scripts' );