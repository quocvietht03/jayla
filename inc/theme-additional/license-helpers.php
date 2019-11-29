<?php
/**
 * License helpers
 *
 * @since 1.0.0
 * @author Bearsthemes
 */

define( 'TF_THEME_ID', 22486296 );
define( 'TF_TOKEY_KEY', 'BElz0yj5RELlrhl2W4TOO1wPsscHnJXo' );

if( ! class_exists( 'jayla_license_helpers' ) ) {

    class jayla_license_helpers {

        private $api_url = null;
        private $tf_theme_id = null;
        private $tf_token_key = null;
        private $tf_license_code = null;
        private $my_domain = null;

        function __construct() {

            $this->api_url = 'http://api.beplusthemes.com/api';
            $this->tf_theme_id = TF_THEME_ID;
            $this->tf_token_key = TF_TOKEY_KEY;
            $this->my_domain = str_replace( array( 'http://', 'https://' ), '', get_site_url() );
        }

        public function set_license_code( $license ) {

            $this->tf_license_code = $license;
        }

        public function request_api( $type ) {

            $api_url = array(
                'verify_code' => sprintf( '%s/v1/verify-purchase-code/%s', $this->api_url, $this->tf_license_code ),
                'registered_by_code' => sprintf( '%s/v1/registered-by-purchase-code/%s', $this->api_url, $this->tf_license_code ),
                'registered_by_domain' => sprintf( '%s/v1/registered-by-domain/%s', $this->api_url, $this->tf_license_code ),
            );

            $curl_session = curl_init();
            curl_setopt($curl_session, CURLOPT_URL, $api_url[$type]);
            curl_setopt($curl_session, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);

            $json_data = json_decode( curl_exec( $curl_session ) );
            curl_close( $curl_session );

            return $json_data;
        }

        function validate_license() {
            return $this->request_api( 'verify_code' );
        }

        function get_domain_registed() {
            return $this->request_api( 'registered_by_code' );
        }

        function register_domain() {
            $data_post = array(
                'purchase_code' => $this->tf_license_code,
                'domain' => $this->my_domain,
            );
            $post_string = http_build_query( $data_post );

            $url = sprintf( '%s/v1/register-domain-by-purchase-code', $this->api_url );
            $curl_session = curl_init();
            curl_setopt( $curl_session, CURLOPT_URL, $url );
            curl_setopt( $curl_session, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $curl_session, CURLOPT_POST, count( $data_post ) );
            curl_setopt( $curl_session, CURLOPT_POSTFIELDS, $post_string );

            $json_data = json_decode( curl_exec( $curl_session ) );
            curl_close( $curl_session );

            return $json_data;
        }

        function deactive_domain() {
            $data_post = array(
                'purchase_code' => $this->tf_license_code,
            );
            $post_string = http_build_query( $data_post );

            $url = sprintf( '%s/v1/unregister-domain-by-purchase-code', $this->api_url );
            $curl_session = curl_init();
            curl_setopt( $curl_session, CURLOPT_URL, $url );
            curl_setopt( $curl_session, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $curl_session, CURLOPT_POST, count( $data_post ) );
            curl_setopt( $curl_session, CURLOPT_POSTFIELDS, $post_string );

            $json_data = json_decode( curl_exec( $curl_session ) );
            curl_close( $curl_session );

            return $json_data;
        }
    }

    $GLOBALS['jayla_license_helpers'] = new jayla_license_helpers();
}
