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
        wp_enqueue_script( 'dashboard-sts', get_stylesheet_directory_uri() . '/assets/js/dashboard-sts.js', array('jquery'), '1.0');
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
require('inc/cpt-sts-modules.php');

// SHORTCODES
require('inc/sc-sts-flipcards.php');
require('inc/sc-sts-blog.php');
require('inc/sc-sts-slider-coach.php');
require('inc/sc-sts-slider-home.php');

// TAXONOMIES
require('inc/tax-sts-cats-modules.php');

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
function get_link_by_slug($slug, $type = 'post'){
    $post = get_page_by_path($slug, OBJECT, $type);
    return get_permalink($post->ID);
}


/**
* Redirect users to custom URL based on their role after login
*
* @param string $redirect
* @param object $user
* @return string
*/
function wc_custom_user_redirect( $redirect, $user ) {
    // Get the first of all the roles assigned to the user
    $role = $user->roles[0];
    $dashboard = admin_url();
    $dashboard_customer = get_permalink(  get_page_by_path( 'dashboard-sts' ) );
    $myaccount = get_permalink( wc_get_page_id( 'shop' ) );
    if( $role == 'administrator' ) {
      //Redirect administrators to the dashboard
      $redirect = $dashboard;
    } elseif ( $role == 'shop-manager' ) {
      //Redirect shop managers to the dashboard
      $redirect = $dashboard;
    } elseif ( $role == 'editor' ) {
      //Redirect editors to the dashboard
      $redirect = $dashboard;
    } elseif ( $role == 'author' ) {
      //Redirect authors to the dashboard
      $redirect = $dashboard;
    } elseif ( $role == 'customer') {
      //Redirect customers and subscribers to the "My Account" page
      $redirect = $dashboard_customer;
    } else {
      //Redirect any other role to the previous visited page or, if not available, to the home
      $redirect = wp_get_referer() ? wp_get_referer() : home_url();
    }
    return $redirect;
  }
  add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 ); 


  add_shortcode( 'my_purchased_products', 'bbloomer_products_bought_by_curr_user' );
   
function bbloomer_products_bought_by_curr_user() {
   
    // GET CURR USER
    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) return;
   
    // GET USER ORDERS (COMPLETED + PROCESSING)
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $current_user->ID,
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_is_paid_statuses() ),
    ) );
   
    // LOOP THROUGH ORDERS AND GET PRODUCT IDS
    if ( ! $customer_orders ) return;
    $product_ids = array();
    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order->ID );
        $items = $order->get_items();
        foreach ( $items as $item ) {
            $product_id = $item->get_product_id();
            $product_ids[] = $product_id;
        }
    }
    $product_ids = array_unique( $product_ids );
    $product_ids_str = implode( ",", $product_ids );
   
    // PASS PRODUCT IDS TO PRODUCTS SHORTCODE
    return $product_ids_str;
   
}


add_shortcode( 'sts_show_content', 'sts_show_content_func' );

function sts_show_content_func($atts){
    $atts = shortcode_atts( array(
        'ids_tax' => []
    ), 
    $atts, 
    'sts_show_content'
    );

    $ids_products = explode(",", $atts['ids_tax']);
    $ids_tax = [];

    if(in_array('1254', $ids_products)){
        array_push($ids_tax, '24');
    }

    if(in_array('1255', $ids_products)){
        array_push($ids_tax, '24');
    }


    $args = array(
        'post_type' => 'sts_modules',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'sts_cat_modules',
                'field'    => 'term_id',
                'terms'    => ['24'],
            ),
        ),
    );

    $query = new WP_Query($args);

    if($query->have_posts()){
        ?>
        <div class="sts-slick-plan">
        <?php while($query->have_posts()): $query->the_post()?>
        <div class="sts-item-slick">
           <div>
            <section class="sts-section-video">
                <div class='embed-container'>
                    
                    <?php 
                    if(get_field('tipo-video') == "Youtube"){
                        the_field('video_youtube'); 
                    } elseif (get_field('tipo-video') == "Vimeo") {
                        the_field('video_vimeo'); 
                    } else {
                        the_field('video_importar');
                    }
                    ?>
                </div>
                <script src="https://player.vimeo.com/api/player.js"></script>
            </section>
            <section class="sts-section-info">
                <h3 class="sts-section-info__title">
                    <?php the_title(); ?>
                </h3>
                <div class="sts-section-info__desc">
                    <?php the_content(); ?>
                </div>
            </section>
           </div>
        </div>
        <?php endwhile; ?>
        </div>
        <?php   
        wp_reset_postdata();
    } else{
        echo "No hay posts";
    }
}

