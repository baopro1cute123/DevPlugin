<?php
wp_enqueue_media();
global $wpdb;
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$department = $wpdb->get_row($wpdb->prepare("SELECT * from wp_ems_department where id = %d", $id), ARRAY_A); //lấy ra mảng danh sách từ bảng phòng ban

?>


<div class="alert alert-danger" role="alert" id="alert_danger">

</div>
<form class="form-inline pt-3" action="javascript:void(0)" id="ems_edit_department" method="POST">
    <div class="alert alert-warning text-center">Edit Department</div>
    <input type="hidden" name="department_id" value="<?php echo $department['id']; ?>">


    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $department['name'] ?>">
    </div>



    <div class="form-group pt-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-info pt-3">Update</button>
    </div>
</form>