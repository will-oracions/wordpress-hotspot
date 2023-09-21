<?php
/*
  Plugin Name: Wordpress Hotspot
  Description: wordpress hotspot.
  Author: Zenidata
  Version: 2.0.0
  Author URI: https://zenidata.com/
  Text Domain: wordpress-hotspot
*/

defined('ABSPATH') or die('No script kiddies please!');


if (!class_exists('Wordpress_Hotspot')) {
  class Wordpress_Hotspot
  {
    private $ROOT_URL = 'wordpress-hotspot/v1';
    private $SAVE_HOTSPOT_IMAGE_ROUTE = 'save-hotspot-image';
    private $GET_HOTSPOT_IMAGE_ROUTE = 'get-hotspot-image';

    public function __construct()
    {
      define('WORDPRESS_HOTSPOT_PLUGIN_PATH', plugin_dir_path(__FILE__));
      define("WORDPRESS_HOTSPOT_DOMAINE", "wordpress-hotspot");
      define(
        'WORDPRESS_HOTSPOT_SAVE_IMAGE_ROUTE',
        $this->ROOT_URL . '/' . $this->SAVE_HOTSPOT_IMAGE_ROUTE
      );
      define('WP_HOTSPOT_TABLE_NAME', 'wordpress_hotspot');
      define('WORDPRESS_HOTSPOT_SHORT_CODE', 'wordpress-hotspot');

      $this->initialize();
    }

    public function initialize()
    {
      // die('init');
      // include_once WORDPRESS_HOTSPOT_PLUGIN_PATH . "includes/contact-form.php";
      include_once WORDPRESS_HOTSPOT_PLUGIN_PATH . "inc/admin.php";

      // Add assets (js, css)
      add_action('wp_enqueue_scripts', array($this, 'load_assets'));

      // Add admin assets
      add_action('admin_enqueue_scripts', array($this, 'load_admin_assets'));

      // Add shortcode
      add_shortcode(WORDPRESS_HOTSPOT_SHORT_CODE, array($this, 'show_shortcode_template'));
      // add_action( 'init', array($this, 'register_regex_shortcode') );

      // Register REST Api
      add_action('rest_api_init', array($this, 'register_rest_api'));

      add_action('admin_enqueue_scripts', array($this, 'load_media_files'));
    }

    public function load_assets()
    {
      //  wp_enqueue_style(
      //    'wordpress-hotspot-main',
      //    plugin_dir_url(__FILE__) . '/assets/main.css',
      //    array('progressive-contact-form-main'),
      //    1,
      //    'all',
      //  );
      // wp_enqueue_script('thickbox');
      // wp_enqueue_style('thickbox');

      wp_enqueue_style(
        'wordpress-hotspot-main',
        plugin_dir_url(__FILE__) . 'assets/css/main.css',
        array(
          'wordpress-hotspots-jquery-hotspot',
          'wordpress-hotspots-jquery-hotspot-modal-css',
          // 'wordpress-hotspot-bootstrap-css',
        ),
        1,
        'all',
      );

      // wp_enqueue_style(
      //   'wordpress-hotspot-bootstrap-css',
      //   'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css',
      //   array('wordpress-hotspots-jquery-hotspot', 'wordpress-hotspots-jquery-hotspot-modal-css'),
      //   1,
      //   'all',
      // );


      wp_enqueue_script(
        'wordpress-hotspot-main',
        plugin_dir_url(__FILE__) . 'assets/js/main.js',
        array('jquery', 'wordpress-hotspots-jquery-modal-js'),
        1,
        true,
      );

      wp_enqueue_style(
        'wordpress-hotspots-jquery-hotspot',
        plugin_dir_url(__FILE__) . 'assets/lib/jquery-hotspot.min.css',
        array(),
        1,
        'all',
      );

      wp_enqueue_style(
        'wordpress-hotspots-jquery-hotspot-modal-css',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css',
        array(),
        1,
        'all',
      );

      wp_enqueue_script(
        'wordpress-hotspots-jquery-hotspot-main',
        plugin_dir_url(__FILE__) . 'assets/lib/jquery-hotspot.min.js',
        array('jquery'),
        1,
        true,
      );

      wp_enqueue_script(
        'wordpress-hotspots-jquery-modal-js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js',
        array('jquery'),
        1,
        true,
      );

      // add_action('wp_footer', array($this, 'load_scripts'));
    }

    public function load_admin_assets()
    {
      wp_enqueue_style(
        'wordpress-hotspots-jquery-hotspot',
        plugin_dir_url(__FILE__) . 'assets/lib/jquery-hotspot.min.css',
        array(),
        1,
        'all',
      );

      wp_enqueue_script(
        'wordpress-hotspots-jquery-hotspot-main',
        plugin_dir_url(__FILE__) . 'assets/lib/jquery-hotspot.min.js',
        array('jquery'),
        1,
        true,
      );

      wp_enqueue_script(
        'wordpress-hotspots-admin-main',
        plugin_dir_url(__FILE__) . 'assets/admin/admin-main.js',
        array('jquery'),
        1,
        true,
      );

      wp_enqueue_style(
        'wordpress-hotspots-admin-main',
        plugin_dir_url(__FILE__) . 'assets/admin/admin-main.css',
        array(),
        1,
        'all',
      );

      wp_enqueue_style(
        'toastify',
        "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"
      );

      wp_enqueue_script(
        'toastify',
        "https://cdn.jsdelivr.net/npm/toastify-js",
        array('jquery'),
        '1.0',
        true
      );

      // add_action('wp_footer', array($this, 'load_scripts'));
    }

    public function load_media_files()
    {
      wp_enqueue_media();
    }

    public function register_rest_api()
    {
      $args = array(
        'methods' => 'POST',
        'callback' => array($this, 'handle_save_hotspot_image'),
        'permission_callback' => '__return_true',
      );

      $args2 = array(
        'methods' => 'GET',
        'callback' => function ($data) {
          return $this->get_hotspot_by_id($data['id']);
        },
        'permission_callback' => '__return_true',
      );

      register_rest_route($this->ROOT_URL, $this->SAVE_HOTSPOT_IMAGE_ROUTE, $args, true);
      register_rest_route($this->ROOT_URL, "$this->GET_HOTSPOT_IMAGE_ROUTE/(?P<id>\d+)", $args2, true);
    }

    public function handle_save_hotspot_image($data)
    {
      // return 'Annotable image saved successfully';

      $params = $data->get_params();
      // $nonce = $headers['x_wp_nonce'][0];

      // if (!wp_verify_nonce($nonce, 'wp_rest')) {
      //   return new WP_REST_Response('Message not sent', 422);
      // }

      global $wpdb;
      $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;
      $id = $params['ID'];
      if ($id) {
        $data = $wpdb->get_results("SELECT * FROM $table_name WHERE ID = " . $id);
        if ($data) {
          $where = array('ID' => $id);
          $result = $wpdb->update($table_name, $params, $where);

          if ($result == 1) {
            return new WP_REST_Response('Annotated image is updated successfully', 200);
          } else {
            return new WP_REST_Response('Unable to save the image, maybe there is no updated infos. if not, please try later', 400);
          }
        }
      }

      $result = $wpdb->insert($table_name, $params);

      // Save new Image
      // global $wpdb;
      // $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;

      if ($result == 1) {
        return new WP_REST_Response('Annotated image is saved successfully', 200);
      }

      return new WP_REST_Response('Something wrong, please try later', 400);
    }

    public function show_shortcode_template($attr, $content, $tag)
    {
      $id = $attr['id'];
      $get_hotspot_endpoint = get_rest_url() . "$this->ROOT_URL/$this->GET_HOTSPOT_IMAGE_ROUTE/$id";

      $data = $this->get_hotspot_by_id($attr['id']);

      ob_start();
      include WORDPRESS_HOTSPOT_PLUGIN_PATH . 'inc/template/short-code-template.php';
      $html = ob_get_clean();
      return $html;
    }

    public function get_hotspot_by_id($id)
    {
      global $wpdb;
      $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;
      $data = $wpdb->get_results("SELECT * FROM $table_name WHERE id = " . $id);

      if (!$data) return null;
      return $data[0];
    }
  }

  $Wordpress_Hotspot = new Wordpress_Hotspot;
}
