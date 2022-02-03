<?php

/**
 * @snippet       WooCommerce User Login Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
*/

// Formulario login personalizado
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


//Create shortcode for lost password form
add_shortcode( 'sts_lost_password_form', 'wc_custom_lost_password_form' );

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


add_action('wp_logout','njengah_homepage_logout_redirect');

function njengah_homepage_logout_redirect(){

    wp_redirect( home_url() . "/iniciar-sesion" );

    exit;

}



add_shortcode( 'sts_redirect_login_user', 'sts_redirect_login_user__func' );

function sts_redirect_login_user__func(){
    if(is_user_logged_in()){

        $user = wp_get_current_user(); // getting & setting the current user 
	    $roles = ( array ) $user->roles; // obtaining the role
        if(in_array('customer', $roles)){
            ?>
            <script>
                window.location.href = "<?php echo site_url("mi-cuenta"); ?>";
            </script>
            <?php
            // wp_redirect(get_permalink( get_page_by_path( 'dashboard-sts' ) ));
        }
    }
}