<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

//  Agregando librerías
if(!function_exists('add_custom_scripts')){
    add_action('wp_enqueue_scripts', 'add_custom_scripts');
    function add_custom_scripts(){

        wp_enqueue_style( 'slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css', array(), '1.8.1');
        wp_enqueue_style( 'aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), '2.3.1');
        wp_enqueue_style( 'lightbox-css', get_stylesheet_directory_uri() . '/lightbox2/css/lightbox.min.css', array());
        wp_enqueue_style( 'custom-css', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), '1.0' );
        
        wp_enqueue_script( 'parallax-js', 'https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js', array(), '3.1.0', true );
        wp_enqueue_script( 'aos-js', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), '2.3.1', true );
        wp_enqueue_script( 'slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '3.1.0', true );
        wp_enqueue_script( 'lightbox-js', get_stylesheet_directory_uri() . '/lightbox2/js/lightbox.min.js', array('jquery'), '1.0');

        wp_register_script( 'main-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '3.1.0', true );
        wp_enqueue_script( 'main-js');
        $passedValues = array( 'home_url' => get_home_url(), 'child_theme_url' => get_stylesheet_directory_uri() );

        wp_localize_script( 'main-js', 'passed_object', $passedValues );
    }

   
}



// Disable Gutenberg
add_filter('use_block_editor_for_post', '__return_false', 10);


// CUSTOM POST TYPES
require('inc/cpt-sts-services.php');
require('inc/cpt-sts-sliders.php');
require('inc/cpt-sts-coach.php');

// SHORTCODES
require('inc/sc-sts-flipcards.php');
require('inc/sc-sts-blog.php');
require('inc/sc-sts-slider-coach.php');
require('inc/sc-sts-slider-home.php');

// Hola mundo

/**
 * @snippet       WooCommerce User Login Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
add_shortcode( 'wc_login_form_bbloomer', 'bbloomer_separate_login_form' );
  
function bbloomer_separate_login_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return; 
   ob_start();
   
   woocommerce_login_form();
   return ob_get_clean();
}

add_shortcode('wc_lost_password_sts', 'wc_lost_password_sts_func');

function wc_lost_password_sts_func(){
    ob_start();
    ?>
    <form method="post" class="woocommerce-ResetPassword lost_reset_password">

        <p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
            <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
        </p>

        <div class="clear"></div>

        <?php do_action( 'woocommerce_lostpassword_form' ); ?>

        <p class="woocommerce-form-row form-row">
            <input type="hidden" name="wc_reset_password" value="true" />
            <button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
        </p>

        <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

    </form>

    <?php
    return ob_get_clean();
}