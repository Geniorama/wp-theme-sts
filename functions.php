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
        wp_enqueue_style( 'remixicons', 'https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css');
        wp_enqueue_style( 'dashboard-css', get_stylesheet_directory_uri() . '/assets/css/dashboard.css', array(), '1.0' );
        
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

/**
 * Change lost password
 * @package generatepress_child
 */


// URL lost Password
function wdm_lostpassword_url() {
    return site_url( '/contrasena-perdida' );
}
add_filter( 'lostpassword_url', 'wdm_lostpassword_url', 10, 0 );

// Redirect new pass
function woocommerce_new_pass_redirect( $user ) {
    wc_add_notice( __( 'Your password has been changed successfully! Please login to continue.', 'woocommerce' ), 'success' );
    wp_redirect( home_url() . "/sign-in/?new-password-created=true" );
    exit;
}
add_action( 'woocommerce_customer_reset_password', 'woocommerce_new_pass_redirect' );


//Create shortcode for lost password form [lost_password_form]
function wc_custom_lost_password_form( $atts ) {
    if ( !empty( $_COOKIE[ "csx-reset-link-set" ] ) && isset( $_COOKIE[ "csx-reset-link-set" ] ) && $_COOKIE[ "csx-reset-link-set" ] === "true" ) { // WPCS: input var ok, CSRF ok.
        return wc_get_template( 'myaccount/lost-password-confirmation.php' );
    } elseif ( !empty( $_SESSION[ "csx-show-reset-form" ] ) && isset( $_SESSION[ "csx-show-reset-form" ] ) && $_SESSION[ "csx-show-reset-form" ] === "true" ) {
        $rp_id = $_SESSION[ "csx-id" ];
        $rp_key = $_SESSION[ "csx-key" ];
        if ( isset( $_COOKIE[ 'wp-resetpass-' . COOKIEHASH ] ) && 0 < strpos( $_COOKIE[ 'wp-resetpass-' . COOKIEHASH ], ':' ) ) { // @codingStandardsIgnoreLine
            list( $rp_id, $rp_key ) = array_map( 'wc_clean', explode( ':', wp_unslash( $_COOKIE[ 'wp-resetpass-' . COOKIEHASH ] ), 2 ) ); // @codingStandardsIgnoreLine
            $userdata = get_userdata( absint( $rp_id ) );
            $rp_login = $userdata ? $userdata->user_login : '';
            $user = WC_Shortcode_My_Account::check_password_reset_key( $rp_key, $rp_login );

            // Reset key / login is correct, display reset password form with hidden key / login values.
            if ( is_object( $user ) ) {
                return wc_get_template(
                    'myaccount/form-reset-password.php',
                    array(
                        'key' => $rp_key,
                        'login' => $rp_login,
                    )
                );
            }
        }
    }

    // Show lost password form by default.
    return wc_get_template(
        'myaccount/form-lost-password.php',
        array(
            'form' => 'lost_password',
        )
    );
}
add_shortcode( 'sts_lost_password_form', 'wc_custom_lost_password_form' );

//Handling query
function csx_process_query() {

    if ( isset( $_GET[ 'reset-link-sent' ] ) && $_GET[ 'reset-link-sent' ] === "true" ) {
        setcookie( 'csx-reset-link-set', "true", time() + ( 300 * 1 ), "/" ); //Allow to submit email for reset after 5 minutes only.
        unset( $_SESSION[ "csx-show-reset-form" ] );
    }

    if ( isset( $_GET[ 'show-reset-form' ] ) && $_GET[ 'show-reset-form' ] === "true" ||
        isset( $_GET[ 'key' ] ) && isset( $_GET[ 'id' ] ) ) {
        $_SESSION[ "csx-show-reset-form" ] = "true";
        setcookie( 'csx-reset-link-set', "", time() - 3600, "/" );
    }

    //Set session and cookie if key and id are existed
    if ( isset( $_GET[ 'key' ] ) && isset( $_GET[ 'id' ] ) ) {
        $_SESSION[ "csx-key" ] = $_GET[ 'key' ];
        $_SESSION[ "csx-id" ] = $_GET[ 'id' ];

        $value = sprintf( "%s:%s", wp_unslash( $_GET[ 'id' ] ), wp_unslash( $_GET[ 'key' ] ) );
        WC_Shortcode_My_Account::set_reset_password_cookie( $value );
    }

    //Unset session and cookie after successfully changed the password.
    if ( isset( $_GET[ 'new-password-created' ] ) && $_GET[ 'new-password-created' ] === "true" ) {
        setcookie( 'wp-resetpass-' . COOKIEHASH, "", time() - 3600 );
        unset( $_SESSION[ "csx-show-reset-form" ] );
        unset( $_SESSION[ "csx-reset-link-set" ] );
        unset( $_SESSION[ "csx-id" ] );
        unset( $_SESSION[ "csx-key" ] );
    }
}
add_action( 'init', 'csx_process_query' );

// Shortcode form reset password

add_shortcode( 'sts_form_reset_password', 'sts_form_reset_password_func' );

function sts_form_reset_password_func(){
    
    do_action( 'woocommerce_before_reset_password_form' );
    ob_start();
    ?>

    <form method="post" class="woocommerce-ResetPassword lost_reset_password">

        <p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="password_1"><?php esc_html_e( 'New password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" />
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="password_2"><?php esc_html_e( 'Re-enter new password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" />
        </p>

        <input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
        <input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

        <div class="clear"></div>

        <?php do_action( 'woocommerce_resetpassword_form' ); ?>

        <p class="woocommerce-form-row form-row">
            <input type="hidden" name="wc_reset_password" value="true" />
            <button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>"><?php esc_html_e( 'Save', 'woocommerce' ); ?></button>
        </p>

        <?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

    </form>
    <?php
    do_action( 'woocommerce_after_reset_password_form' );
    return ob_get_clean();
}

//Redirect to custom lost password on request
// function csx_redirections() {
//     if ( isset( $_GET[ 'reset-link-sent' ] ) || isset( $_GET[ 'show-reset-form' ] ) ||
//         isset( $_GET[ 'key' ] ) && isset( $_GET[ 'id' ] ) ) {
//         wp_redirect( home_url() . '/restablecer-contrasena' );
//         exit;
//     }
// }
// add_action( 'template_redirect', 'csx_redirections' );