<?php
global $wpdb;
$departments = $wpdb->get_results($wpdb->prepare("select * from wp_ems_department", ""), ARRAY_A);
//   print_r($employees);

?>
<table id="list_employees" class="display" style="width:100%">
    <thead>
        <tr>
            <th>STT</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
if (count($departments) > 0) {
    $stt = 1;
    foreach ($departments as $department) {
        ?>

        <tr>
            <td><?php echo $stt++ ?></td>
            <td><?php echo $department['name'] ?></td>
            <td>
                <a href="http://localhost/ManagePlugin/wp-admin/admin.php?page=edit-departments&id=<?php echo $department['id'] ?>"
                    class="btn btn-warning">Edit</a>
                <a href="javascript:void(0)" class="btn btn-danger remove-department"
                    data-id="<?php echo $department['id'] ?>">Delete</a>
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