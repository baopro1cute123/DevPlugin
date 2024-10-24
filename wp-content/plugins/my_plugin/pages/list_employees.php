<?php 
  global $wpdb;
  $employees = $wpdb->get_results($wpdb->prepare("select
   wp_ems_form_data.id as ems_id, wp_ems_form_data.name as name, wp_ems_department.name as deparment_name, email, age, image, phone, gender, address
   from wp_ems_form_data inner join wp_ems_department on wp_ems_form_data.department_id = wp_ems_department.id order by wp_ems_form_data.id desc ",""),ARRAY_A);
//   print_r($employees);
 

?>
<table id="list_employees" class="display" style="width:100%">
    <thead>
        <tr>
            <th>STT</th>
            <th>Email</th>
            <th>Name</th>
            <th>Age</th>
            <th>Image</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
               if(count($employees) > 0) {
                $stt = 1;
                foreach ($employees as $employee) {
                    ?>

        <tr>
            <td><?php echo $stt++ ?></td>
            <td><?php echo $employee['email'] ?></td>
            <td><?php echo $employee['name'] ?></td>
            <td><?php echo $employee['age'] ?></td>
            <td class="d-flex justify-content-center">
                <img src="<?php echo $employee['image'] ?>" width="75" height="75">
            </td>
            <td><?php echo $employee['phone'] ?></td>
            <td><?php echo $employee['deparment_name'] ?></td>
            <td><?php echo $employee['address'] ?></td>
            <td><?php echo $employee['gender'] == 'nu' ? 'nữ' : 'nam' ?></td>
            <td>
                <a href="http://localhost/ManagePlugin/wp-admin/admin.php?page=edit-employee&id=<?php echo $employee['ems_id'] ?>"
                    class="btn btn-warning">Edit</a>
                <a href="javascript:void(0)" class="btn btn-danger deletedata"
                    data-id="<?php echo $employee['ems_id'] ?>">Delete</a>
            </td>
        </tr>
        <?php
                }
               }
            
            ?>


    </tbody>
    <tfoot>

    </tfoot>
</table>