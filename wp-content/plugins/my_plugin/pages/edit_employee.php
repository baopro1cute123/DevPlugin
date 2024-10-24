<?php
    wp_enqueue_media();
    global $wpdb; 
    $book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $employee = $wpdb->get_row($wpdb->prepare(
        "SELECT wp_ems_form_data.id as ems_id, wp_ems_form_data.name as name, wp_ems_department.name as deparment_name, email, age, image, phone, gender, address
    from wp_ems_form_data inner join wp_ems_department on wp_ems_form_data.department_id = wp_ems_department.id
    where wp_ems_form_data.id = %d", $book_id), ARRAY_A);
    $departments = $wpdb->get_results("SELECT id, name FROM wp_ems_department", ARRAY_A);

?>


<div class="alert alert-danger" role="alert" id="alert_danger">

</div>
<form class="form-inline pt-3" action="javascript:void(0)" id="ems_form_edit_data" method="POST">
    <div class="alert alert-warning text-center">Edit Employee</div>
    <input type="hidden" name="employee_id" value="<?php echo $employee['ems_id']; ?>">
    <div class="form-group">
        <label for="email">Email address:</label>
        <input type="email" class="form-control" id="email" required name="email"
            value="<?php echo $employee['email'] ?>">
    </div>

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $employee['name'] ?>">
    </div>

    <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" class="form-control" id="age" name="age" value="<?php echo $employee['age'] ?>">
    </div>

    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" class="form-control" id="phone" required name="phone"
            value="<?php echo $employee['phone'] ?>">
    </div>

    <div class="form-group">
        <label for="department">Department</label>
        <select class="form-control" name="department" id="department">
            <option>Select Department</option>
            <?php foreach ($departments as $department) { ?>
            <option value="<?php echo $department['id']; ?>"
                <?php if ($employee['deparment_name'] == $department['name']) echo 'selected'; ?>>
                <?php echo $department['name']; ?>
            </option>
            <?php } ?>
        </select>
    </div>



    <div class="form-group">
        <label for="age">Upload Image:</label> <br />
        <img id="old_image" src="<?php if(isset($employee['image'])) {
      echo $employee['image'];
    } ?>" style="width: 100px; height: auto;">
        <input type="button" id="upload-image" class="btn btn-info" value="upload image" />
        <!-- Xem trước hình ảnh đã upload lên -->
        <div id="preview-image"></div>
        <img id="image-uploaded-preview" src="path/to/image.jpg" alt="Uploaded Image"
            style="width: 10px; height: auto;" />
    </div>

    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" class="form-control" id="address" required name="address"
            value="<?php echo $employee['address'] ?>">
    </div>

    <div class="form-group pt-3">

        <select class="form-select" aria-label="Default select example" required name="gender">
            <option value="nam" <?php if($employee['gender'] == 'nam') echo 'selected="selected"';  ?>>Nam</option>
            <option value="nu" <?php if($employee['gender'] == 'nu') echo 'selected="selected"';  ?>>Nữ</option>
        </select>
    </div>

    <div class="form-group pt-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-info pt-3">Update</button>
    </div>
</form>