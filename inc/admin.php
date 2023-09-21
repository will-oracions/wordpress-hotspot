<?php

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
} //

class Wordpress_Hotspot_List extends WP_List_Table
{

  /** Class constructor */
  public function __construct()
  {

    parent::__construct([
      'singular' => __('Wordpress Hotspot', 'sp'), //singular name of the listed records
      'plural' => __('Wordpress Hotspots', 'sp'), //plural name of the listed records
      'ajax' => false //should this table support ajax?
    ]);

    global $wpdb;
    $table_name = $wpdb->base_prefix . WP_HOTSPOT_TABLE_NAME;
    $query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

    if (!$wpdb->get_var($query) == $table_name) {
      $this->create_table();
    }
    // $this->seed_data();
  }

  public function create_table()
  {
    global $wpdb;

    $table_name =  $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;
    $charset_collate = $wpdb->get_charset_collate();

    // locationId varchar(255) NOT NULL,
    //   shortcode varchar(255) NOT NULL,
    //   name varchar(255) NOT NULL,
    //   title varchar(255) NOT NULL,
    //   description TEXT NOT NULL,
    //   image TEXT NOT NULL,
    //   x varchar(255) NOT NULL,
    //   y varchar(255) NOT NULL,
    // shortcode varchar(255) NOT NULL,
    $sql = "CREATE TABLE $table_name (
      ID mediumint(9) NOT NULL AUTO_INCREMENT,

      name varchar(255) NOT NULL,
      data TEXT NOT NULL,
      annotated_image TEXT NOT NULL,
      
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
      updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY  (ID)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }

  function seed_data()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;

    for ($i = 0; $i < 10; ++$i) {
      $data = array(
        "name" => "image hotspot " . $i + 1,
        "data" => "data " . $i + 1,
        "path" => "/the/path/to/ " . $i + 1,

      );

      $wpdb->insert($table_name, $data);
    }
  }

  /**
   * Retrieve image_hotspot’s data from the database
   *
   * @param int $per_page
   * @param int $page_number
   *
   * @return mixed
   */
  public static function get_image_hotspots($per_page = 5, $page_number = 1)
  {
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}" . WP_HOTSPOT_TABLE_NAME;

    if (!empty($_REQUEST['orderby'])) {
      $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
      $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
    }

    $sql .= " LIMIT $per_page";

    $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

    $result = $wpdb->get_results($sql, 'ARRAY_A');

    return $result;
  }

  /**
   * Delete a image_hotspot record.
   *
   * @param int $id image_hotspot ID
   */
  public static function delete_image_hotspot($id)
  {
    global $wpdb;

    $wpdb->delete(
      "{$wpdb->prefix}" . WP_HOTSPOT_TABLE_NAME,
      ['ID' => $id],
      ['%d']
    );
  }

  /**
   * Returns the count of records in the database.
   *
   * @return null|string
   */
  public static function record_count()
  {
    global $wpdb;

    $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}" . WP_HOTSPOT_TABLE_NAME;

    return $wpdb->get_var($sql);
  }

  /** Text displayed when no image_hotspot data is available */
  public function no_items()
  {
    _e('No image hotspots avaliable.', 'sp');
  }

  /**
   * Method for name column
   *
   * @param array $item an array of DB data
   *
   * @return string
   */
  function column_name($item)
  {

    // create a nonce
    $delete_nonce = wp_create_nonce('sp_delete_image_hotspot');
    $edit_nonce = wp_create_nonce('sp_edit_image_hotspot');

    // $link = sprintf(
    //   '<strong><a href="?page=%s&action=%s&id=%s">'. $item['name'] .'</a></strong>',
    //   'wordpress_hotspot_add',
    //   'details',
    //   $item['ID']);

    $delete_link = sprintf(
      '<a href="?page=%s&action=%s&image_hotspot_id=%s&_wpnonce=%s">Delete</a>',
      esc_attr($_REQUEST['page']),
      'delete',
      absint($item['ID']),
      $delete_nonce
    );

    $edit_link = sprintf(
      '<a href="?page=%s&action=%s&id=%s">Edit</a>',
      'wordpress_hotspot_edit',
      'edit',
      $item['ID']
    );

    // $edit_link = admin_url( 'post.php?action=edit&amp;post=' .  $item['ID']);

    // $actions = [
    //   'edit' => sprintf( '<a href="?page=%s&action=%s&image_hotspot=%s&_wpnonce=%s">Edit</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['ID'] ), $edit_nonce ),
    //   'delete' => sprintf( '<a href="?page=%s&action=%s&image_hotspot=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce ),
    // ];

    // return $link . $this->row_actions( $actions );


    $output    = '';
    // Title.
    $output .= '<strong><a href="?page=wordpress_hotspot_edit&action=edit&id=' . $item['ID'] . '" class="row-title">' . esc_html($item['name']) . '</a></strong>';

    // Get actions.
    $actions = array(
      // 'edit'   =>  $edit_link, // sprintf( '<a href="?page=%s&action=%s&image_hotspot=%s&_wpnonce=%s">Edit</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['ID'] ), $edit_nonce ),
      'delete' => $delete_link, // sprintf( '<a href="?page=%s&action=%s&image_hotspot=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce ),
    );

    $row_actions = $actions; // array();

    // foreach ( $actions as $action => $link ) {
    //     $row_actions[] = '<span class="' . esc_attr( $action ) . '">' . $link . '</span>';
    // }

    $output .= '<div class="row-actions">' . implode(' | ', $row_actions) . '</div>';

    return $output;
  }

  /**
   * Render a column when no column specific method exists.
   *
   * @param array $item
   * @param string $column_name
   *
   * @return mixed
   */
  public function column_default($item, $column_name)
  {
    switch ($column_name) {
      case 'action':
        $details_link = sprintf(
          '<a href="?page=%s&action=%s&id=%s">details</a>',
          'wordpress_hotspot_details',
          'details',
          $item['ID']
        );
        return $details_link;
      case 'name':
        return $this->column_name($item);
      case 'shortcode':
        return "[" . WORDPRESS_HOTSPOT_SHORT_CODE . ' id="' . $item['ID'] . '"]';
      case 'created_at':
        return $item[$column_name];
        // default:
        //   return print_r( $item, true ); //Show the whole array for troubleshooting purposes
      default:
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }
  }

  /**
   * Render the bulk edit checkbox
   *
   * @param array $item
   *
   * @return string
   */
  function column_cb($item)
  {
    return sprintf(
      '<input type="checkbox" name="bulk-delete[]" value="%s" />',
      $item['ID']
    );
  }

  /**
   * Associative array of columns
   *
   * @return array
   */
  function get_columns()
  {
    $columns = [
      'cb' => '<input type="checkbox" />',
      'name' => __('Name', 'sp'),
      // 'email' => __( 'Email Address', 'sp' ),
      // 'phone_number' => __( 'Phone Number', 'sp' ),
      // 'desired_salary' => __( 'Desired Salary', 'sp' ),
      'shortcode' => __('Shortcode', 'sp'),
      'created_at' => __('Created At', 'sp'),
      // 'action' => __('Action', 'flipp-survey'),
    ];

    return $columns;
  }

  /**
   * Columns to make sortable.
   *
   * @return array
   */
  public function get_sortable_columns()
  {
    $sortable_columns = array(
      'name' => array('name', true),
      // 'email' => array( 'email', false ),
      // 'phone_number' => array( 'email', false ),
      // 'desired_salary' => array( 'desired_salary', false ),
      'created_at' => array('created_at', false),
      // 'number_of_employees' => array( 'created_at', false ),
    );

    return $sortable_columns;
  }

  /**
   * Returns an associative array containing the bulk action
   *
   * @return array
   */
  public function get_bulk_actions()
  {
    $actions = [
      'bulk-delete' => 'Delete',
    ];

    return $actions;
  }
  /**
   * Handles data query and filter, sorting, and pagination.
   */
  public function prepare_items()
  {

    $this->_column_headers = $this->get_column_info();

    /** Process bulk action */
    $this->process_bulk_action();

    $per_page = $this->get_items_per_page('image_hotspots_per_page', 5);
    $current_page = $this->get_pagenum();
    $total_items = self::record_count();

    $this->set_pagination_args([
      'total_items' => $total_items, //WE have to calculate the total number of items
      'per_page' => $per_page //WE have to determine how many items to show on a page
    ]);

    $this->items = self::get_image_hotspots($per_page, $current_page);
  }

  public function process_bulk_action()
  {
    //Detect when a bulk action is being triggered...
    if ('delete' === $this->current_action()) {

      // In our file that handles the request, verify the nonce.
      $nonce = esc_attr($_REQUEST['_wpnonce']);

      if (!wp_verify_nonce($nonce, 'sp_delete_image_hotspot')) {
        die('Go get a life script kiddies');
      } else {
        self::delete_image_hotspot(absint($_GET['image_hotspot_id']));
        return;
        // wp_redirect( esc_url( add_query_arg() ) );
        // exit;
      }
    }

    // If the delete bulk action is triggered
    if ((isset($_POST['action']) && $_POST['action'] == 'bulk-delete')
      || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-delete')
    ) {

      $delete_ids = esc_sql($_POST['bulk-delete']);

      // loop over the array of record IDs and delete them
      foreach ($delete_ids as $id) {
        self::delete_image_hotspot($id);
      }

      wp_redirect(esc_url(add_query_arg()));
      exit;
    }
  }
} //

class Wordpress_HOTSPOT_SP_Plugin
{
  // class instance
  static $instance;
  // image_hotspot WP_List_Table object
  public $wordpress_hotspot_obj;

  public $ROOT_URL;
  public $GET_HOTSPOT_IMAGE_ROUTE;
  // class constructor
  public function __construct($ROOT_URL, $GET_HOTSPOT_IMAGE_ROUTE)
  {

    $this->ROOT_URL = $ROOT_URL;
    $this->GET_HOTSPOT_IMAGE_ROUTE = $GET_HOTSPOT_IMAGE_ROUTE;
    add_filter('set-screen-option', [__CLASS__, 'set_screen'], 10, 3);
    add_action('admin_menu', [$this, 'plugin_menu']);
    // $this->load_assets();
  }

  public static function set_screen($status, $option, $value)
  {
    return $value;
  }

  public function plugin_menu()
  {
    // $hook = add_menu_page(
    //   'Flipp Surver',
    //   'Flipp Surver',
    //   'manage_options',
    //   'wp_list_table_class',
    //   [ $this, 'plugin_settings_page' ]
    // );

    $hook = add_menu_page(
      'Wordpress Hotspot',
      'Wordpress Hotspot',
      'manage_options',
      'wordpress-hotspot',
      [$this, 'plugin_settings_page'],
      'dashicons-feedback',
      6
    );

    add_submenu_page(
      'wordpress_hotspot_details',
      'Wordpress Hotspot',
      '',
      'manage_options',
      'wordpress_hotspot_details',
      [$this, 'admin_details_page']
    );

    add_submenu_page(
      'wordpress_hotspot_add',
      'Wordpress Hotspot Add',
      '',
      'manage_options',
      'wordpress_hotspot_add',
      [$this, 'admin_add_page']
    );

    add_submenu_page(
      'wordpress_hotspot_edit',
      'Wordpress Hotspot edit',
      '',
      'manage_options',
      'wordpress_hotspot_edit',
      [$this, 'admin_add_page']
    );

    add_action("load-$hook", [$this, 'screen_option']);
  }

  /**
   * Screen options
   */
  public function screen_option()
  {
    $option = 'per_page';
    $args = [
      'label' => 'image_hotspots',
      'default' => 5,
      'option' => 'image_hotspots_per_page'
    ];

    add_screen_option($option, $args);

    $this->wordpress_hotspot_obj = new Wordpress_Hotspot_List();
  }

  /**
   * Plugin settings page
   */
  public function plugin_settings_page()
  {
    $add_link = sprintf(
      '<a  class="page-title-action" href="?page=%s&action=%s">Add</a>',
      'wordpress_hotspot_add',
      'add'
    );

?>
    <div class="wrap">
      <div>
        <h2>Wordpress Hotspot</h2>
        <!-- <a href="<?php //echo $add_link 
                      ?>" class="page-title-action">Add New</a> -->
        <div><?php echo $add_link ?></div>
      </div>

      <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-3">
          <div id="post-body-content">
            <div class="meta-box-sortables ui-sortable">
              <form method="post">
                <?php
                $this->wordpress_hotspot_obj->prepare_items();
                $this->wordpress_hotspot_obj->display(); ?>
              </form>
            </div>
          </div>
        </div>
        <br class="clear">
      </div>
    </div>
    <?php
  }

  /** Singleton instance */
  public static function get_instance($ROOT_URL, $GET_HOTSPOT_IMAGE_ROUTE)
  {
    if (!isset(self::$instance)) {
      self::$instance = new self($ROOT_URL, $GET_HOTSPOT_IMAGE_ROUTE);
    }

    return self::$instance;
  }

  function admin_details_page()
  {
    global $wpdb;
    $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id > 0) {
      $details = $wpdb->get_row("SELECT * FROM $table_name WHERE ID = $id", ARRAY_A);
      if ($details) {
    ?>



        <div class="app-box">
          <h3 class="app-box-title">Wordpress Hotspot Details page</h3>
        </div>

<?php
      } else {
        echo "<h2>" . __("No details found for this ID.",) . "</h2>";
      }
    } else {
      echo "<h2>" . __("ID is invalid.", "flipp-survey") . "</h2>";
    }
  }

  function admin_add_page()
  {
    if ($_GET['action'] == 'edit') {
      $id = $_GET['id'];

      global $wpdb;

      $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;

      $data = $wpdb->get_results("SELECT * FROM $table_name WHERE id = " . $id);

      if ($data) {
        $annotatedImageHotspot = $data[0];
      } else {
        die('Invalid ID.');
      }
    }

    // if(isset($_POST['submit'])){
    //   // Save
    //   $data = array(
    //     'name' => 'form saved',
    //     'data' => '{}',
    //     'path' => 'saved...'
    //   );

    //   $this->insert_image_hotspot_to_db($data);

    //   if($_FILES['file']['name'] != '') {
    //     $this->upload_file($_FILES['file']);
    //   }
    // }
    function get_hotspot_by_id($id)
    {
      global $wpdb;
      $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;
      $data = $wpdb->get_results("SELECT * FROM $table_name WHERE id = " . $id);

      if (!$data) return null;
      return $data[0];
    }

    $get_hotspot_endpoint = get_rest_url() . "$this->ROOT_URL/$this->GET_HOTSPOT_IMAGE_ROUTE/$id";

    $data = get_hotspot_by_id($id);

    include WORDPRESS_HOTSPOT_PLUGIN_PATH . 'inc/template/create-page.php';
  }

  function upload_file($file)
  {

    $uploadedfile = $file;
    $upload_overrides = array('test_form' => false);

    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
    $imageurl = "";
    if ($movefile && !isset($movefile['error'])) {
      $imageurl = $movefile['url'];
      echo "url : " . $imageurl;
    } else {
      echo $movefile['error'];
    }
  }

  function insert_image_hotspot_to_db($data)
  {
    // if (current_user_can('administrator') && isset($_POST['hotspots'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . WP_HOTSPOT_TABLE_NAME;
    // $hotspots = json_decode(stripslashes($_POST['hotspots']), true);
    // $image_url = $_POST['image_url'];
    // array('image_url' => $image_url, 'hotspots' => serialize($hotspots))
    $wpdb->insert($table_name, $data);
    die('Les hotspots ont été enregistrés avec succès.');
    // }
  }
} //

add_action('plugins_loaded', function () {
  $ROOT_URL = $this->ROOT_URL;
  $GET_HOTSPOT_IMAGE_ROUTE = $this->GET_HOTSPOT_IMAGE_ROUTE;
  Wordpress_HOTSPOT_SP_Plugin::get_instance($ROOT_URL, $GET_HOTSPOT_IMAGE_ROUTE);
});
