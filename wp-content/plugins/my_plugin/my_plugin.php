<?php 
//phần server
/*
 * Plugin Name:       My Plugin NDGB
 * Plugin URI:        https://baokhcodon.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            GiaBaoNguyenDuong
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-plugin
 * Domain Path:       /languages
 */

defined("ABSPATH") or die("You can not access directly"); // bảo mật Plugin_Upgrader_Skin // đường dẫn tuyệt đối tới mục cài đặc wp
define("PLUGIN_PATH", plugin_dir_path( __FILE__ ));
define("PLUGIN_URI", plugin_dir_url( __FILE__ ));
define("PLUGIN_ADMIN", admin_url());
//add menu cho plugin
if(!class_exists('MyPlugin')) {
    class MyPlugin {
    
    public function __construct() {
        add_action('admin_menu', array($this,'custom_admin_menu')) ; //thêm vào menu admin
        add_action('admin_enqueue_scripts', array($this, 'load_assets'));



    }

    function custom_admin_menu (){
    add_menu_page( 'All Employees', 'All Employees', 'manage_options', 'all-employees', array($this, 'render_employee'), '', 10 );     //thêm vào menu //10 là vị trí nằm

    // add_menu_page( $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $callback:callable, $icon_url:string, $position:integer|float|null )

    //menu con           tên menu cha   Tên hiện thị                                           đường dẫn            function code
    add_submenu_page( 'all-employees', 'Add Employees', 'Add Employees', 'manage_options', 'add-employee', array($this, 'render_add_employee'), 1 );

    add_submenu_page( 'all-employees', '', '', 'manage_options', 'edit-employee', array($this, 'render_edit_employee'), 1 );

    // add_submenu_page( $parent_slug:string, $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $callback:callable, $position:integer|float|null )


    add_menu_page( 'All Departments', 'All Departments', 'manage_options', 'all-departments', array($this, 'render_department'), '', 11 );     //thêm vào menu //10 là vị trí nằm

    add_submenu_page( 'all-departments', 'Add Departments', 'Add Departments', 'manage_options', 'add-departments', array($this, 'render_add_department'), 1 );
    add_submenu_page( 'all-departments', '', '', 'manage_options', 'edit-departments', array($this, 'render_edit_department'), 1 );

    }

    function render_employee (){
    include_once(PLUGIN_PATH."/pages/list_employees.php");
    }

    function render_add_employee() {
        include_once(PLUGIN_PATH."/pages/add_employee.php");
    }
    function render_edit_employee() {
    include_once(PLUGIN_PATH."/pages/edit_employee.php");
    }

    //phòng ban
    function render_department(){
        include_once(PLUGIN_PATH."/pages/list_departments.php");
    }

    function render_add_department() {
        include_once(PLUGIN_PATH."/pages/add_departments.php");
    }
    function render_edit_department() {
    include_once(PLUGIN_PATH."/pages/edit_departments.php");
    }
    
    function create_table_ems() {
    global $wpdb;
    $table_prefix = $wpdb->prefix; // lấy tiền tố của wp -> kq : wp_ 
    $sql = "CREATE TABLE {$table_prefix}ems_form_data (
        `id` int NOT NULL AUTO_INCREMENT,
        `email` varchar(180) NOT NULL,
        `name` varchar(225) NOT NULL,
        `age` int NOT NULL,
        `image` varchar(225) NULL,
        `department_id` int NOT NULL,
        `phone` varchar(20) NOT NULL,
        `address` varchar(255) NOT NULL,
        `gender` varchar(20) NOT NULL,
        PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci"; //-> tạo ra bảng wp_ems_form_data
        
        include_once ABSPATH . '/wp-admin/includes/upgrade.php'; // đi chung bDelta($sql) /wp-admin/includes/upgrade.php
        //File này chứa các hàm để nâng cấp cơ sở dữ liệu, bao gồm hàm dbDelta() dùng để tạo và cập nhật bảng trong cơ sở dữ liệu.
        dbDelta($sql); // câu lệnh tạo bảng của wp => không chỉ tạo bảng mà còn kiểm tra xem bảng đã tồn tại hay chưa và có thay đổi gì về cấu trúc không


         //Tạo thêm bảng phòng ban
        $sql1 = "CREATE TABLE {$table_prefix}ems_department (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(225) NOT NULL,
        PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";
        dbDelta($sql1);
    }
   // Xóa table khi hủy kích hoạt plugin 
    function drop_table_ems() {
        global $wpdb;
        $table_prefix = $wpdb->prefix; // wp_
        $sql = "DROP TABLE IF EXISTS {$table_prefix}ems_form_data";
        $wpdb->query($sql); //câu lệnh truy vấn cho sql

        $sql1 = "DROP TABLE IF EXISTS {$table_prefix}ems_department";
        $wpdb->query($sql1);
    }

    function load_assets() {
        //Nhúng thư viện css
        wp_enqueue_style( 'bootstrap_min_css', PLUGIN_URI."css/bootstrap.min.css", array(), '1.0.0', 'all' );
        wp_enqueue_style('dataTables_min_css', PLUGIN_URI."css/dataTables.min.css", array(), '1.0.0', 'all');
        wp_enqueue_style('mystyle_css', PLUGIN_URI."css/mystyle.css", array(), '1.0.0', 'all');
        //Nhúng thư viện js
        wp_enqueue_script( 'bootstrap_min_js', PLUGIN_URI."js/bootstrap.min.js", array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'dataTable_min_js', PLUGIN_URI."js/dataTables.min.js", array('jquery'), '1.0.0', true );
        wp_enqueue_script('jquery_validate', PLUGIN_URI."js/jquery.validate.min.js", array('jquery'), '1.0.0', true);
        wp_enqueue_script('myscript', PLUGIN_URI."js/myscript.js", array('jquery'), '1.0.0', true);
        
        
        //Nhúng đường dẫn admin_ajax vào trong myscript để sử dụng
        wp_localize_script("myscript","ajaxurl",array(
            "baseURL" => admin_url("admin-ajax.php")
            ));

    }
    

}
}


$plugins = new MyPlugin;
// Kích hoạt plugin + Tạo table wp_ems_form_data
register_activation_hook( __FILE__, array($plugins, 'create_table_ems'));

// Hủy kích hoạt plugin => Xóa table wp_ems_form_data
register_deactivation_hook( __FILE__, array($plugins, 'drop_table_ems'));


//call ajax phía backend
//Add Employee

add_action('wp_ajax_delete', 'employee_delete_handler');
add_action('wp_ajax_editemploy', 'employee_update_handler');
add_action("wp_ajax_addemploy","employee_ajax_handler");


//Thêm mới phòng ban
add_action("wp_ajax_adddepartment", "department_ajax_handler");
//Cập nhật phòng ban
add_action("wp_ajax_editdepartment", "department_ajax_handler_update");
//Delete phòng ban bằng ajax
add_action('wp_ajax_deletedepartment','department_delete_handler');


function employee_ajax_handler() {
    global $wpdb;

    if ($_REQUEST['param'] == "save") {
        $email = sanitize_text_field($_REQUEST["email"]);

        // Kiểm tra xem email có trùng trong cơ sở dữ liệu hay không
        $email_exists = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM wp_ems_form_data WHERE email = %s", $email
        ));
        if ($email_exists > 0) {
            // Email đã tồn tại, trả về lỗi
            print_r(json_encode(array("status" => "400", "message" => "Email đã tồn tại!")));
        } else {
            // Email không tồn tại, tiến hành thêm mới vào bảng
            $wpdb->insert("wp_ems_form_data", array(
                "email" => $email,
                "name"  => sanitize_text_field($_REQUEST["name"]),
                "age"   => sanitize_text_field($_REQUEST["age"]),
                "image" => sanitize_text_field($_REQUEST["image-uploaded"]), //chuyển đổi dạng ký tự
                "phone" => sanitize_text_field($_REQUEST["phone"]),
                "department_id" =>  sanitize_text_field($_REQUEST["department"]),
                "address" => sanitize_text_field($_REQUEST["address"]),
                "gender"  => sanitize_text_field($_REQUEST["gender"])
            ));

            // Trả về thông báo thành công
            print_r(json_encode(array("status" => "200", "message" => "You created new employee successfully!")));
        }
    }

    wp_die();
}


//Update Employee
function employee_update_handler() {
global $wpdb;
  if($_REQUEST['param']=="update") {
        $wpdb->update("wp_ems_form_data", array(
        "email" => sanitize_text_field( $_REQUEST["email"] ) , 
        "name"  => sanitize_text_field($_REQUEST["name"]),
        "age"   => sanitize_text_field($_REQUEST["age"]), 
        "phone" => sanitize_text_field($_REQUEST["phone"]),
        "department_id" =>  sanitize_text_field($_REQUEST["department"]),
        "address" => sanitize_text_field($_REQUEST["address"]), 
        "gender"  => sanitize_text_field($_REQUEST["gender"])
        ), array (
        "id" => isset($_REQUEST['employee_id']) ? intval($_REQUEST['employee_id']) : 0
        ));

   print_r(json_encode(array("status" => "201", "message"=>"You updated employee successfully!")));
  }
  else{
    print_r(json_encode(array("status" => "400", "message"=>"You updated employee NOT successfully!")));

  }

  wp_die();
}
//Delete Employee


function employee_delete_handler() {
global $wpdb;
  
    $wpdb->delete("wp_ems_form_data", array(
      "id" => $_REQUEST['id']
    ));

   print_r(json_encode(array("status" => "200", "message"=>"You deleted employee successfully!")));
  

  wp_die();
}

//Ajax phòng ban



function department_ajax_handler() {
    global $wpdb;
        if ($_REQUEST['param'] == "save") {
            $wpdb->insert("wp_ems_department", array(
                "name" => sanitize_text_field($_REQUEST["name"]),
            ));

            print_r(json_encode(array("status" => "200", "message" => "You created new department successfully!")));
    }else{
                    print_r(json_encode(array("status" => "401", "message" => "You created new department NOT successfully!")));

    }

    wp_die();
}

function department_ajax_handler_update() {
        global $wpdb;
        if ($_REQUEST['param'] == "update") {
            $wpdb->update("wp_ems_department", array(
                "name" => sanitize_text_field($_REQUEST["name"]),
            ), array(
                "id" => isset($_REQUEST['department_id']) ? intval($_REQUEST['department_id']) : 0,
            ));

            print_r(json_encode(array("status" => "201", "message" => "You updated department successfully!")));
    }else{
                print_r(json_encode(array("status" => "400", "message" => "You updated department NOT successfully!")));

    }

wp_die();

  }

function department_delete_handler() {
  global $wpdb;

  $wpdb->delete("wp_ems_department", array(
    "id" => $_REQUEST['id'],
  ));

print_r(json_encode(array("status" => "200", "message" => "You deleted department successfully!")));

wp_die();

}


?>