new DataTable('#list_employees');
// Xác thực đầu vào cho form ems_form_data và submit form
// jQuery("#ems_form_data").validate({
//     submitHandler: function() {
//         var postData = "action=addemployee&param=save&"+jQuery("#ems_form_data").serialize();
//         console.log(postData);
        
//         jQuery.post(ajaxurl.baseURL, postData, function(res){
//             console.log(res);
//         })
//     }
// });


//Upload hình ảnh lên media của Wordpress
jQuery("#upload-image").on("click", function() {
    var image = wp.media({
        title : "Upload image for my Employee",
        multiple: false
    }).open().on("select", function() {
        var uploaded_image = image.state().get("selection");
        var getImage = uploaded_image.toJSON()[0].url;
        jQuery('#preview-image').html("<img src='"+getImage+"'width='64' height='64' />"); //thêm đoạn phần ảnh đoạn htlm để hiển thị
        jQuery('#image-uploaded').val(getImage); //lấy giá trị 
    })
})

//Client
//Ẩn thông báo
jQuery("#alert_danger").hide();
//Thêm emplyee
//Đoạn mã này sử dụng jQuery để xử lý việc xác thực biểu mẫu và gửi dữ liệu biểu mẫu thông qua Ajax
// gửi dữ liệu lên sever thông qua ajax
jQuery("#ems_form_data").validate({ // sau khi cái form ems_form_data validate thành công thì thực hiện submit
    submitHandler : function() {

        var postData = "action=addemploy&param=save&"+jQuery("#ems_form_data").serialize(); //tạo ra một câu truy vấn được mã hóa serialize để gửi lên server
        // console.log('jq',jQuery("#ems_form_data").serialize());

        jQuery.post(ajaxurl.baseURL, postData, function(res) {
            var result = jQuery.parseJSON(res);
            if(result.status == "200") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-employees';

                }, 3000)
            }
            if(result.status == "400") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-employees';

                }, 3000)
            }
        });
    }
});



//Edit Empoyee
jQuery("#ems_form_edit_data").validate({
    submitHandler: function () {
        var editData = "action=editemploy&param=update&" + jQuery("#ems_form_edit_data").serialize();
        console.log(editData);

        jQuery.post(ajaxurl.baseURL, editData, function (res) {
            var result = jQuery.parseJSON(res);
            if (result.status == "201") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-employees';

                }, 3000)

            }
            if (result.status == "400") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-employees';

                }, 3000)
            }
        });
       
    }
});


//Send Request delete to server
jQuery(document).on("click", ".deletedata", function () {
    var isDelete = confirm("Are you want to sure delete this employee");
    if(isDelete) {
        var dataID = jQuery(this).attr('data-id');
        console.log(dataID);
        var data = "action=delete&id="+dataID;
            console.log(data);

    
        jQuery.post(ajaxurl.baseURL, data, function (res) {
            var result = jQuery.parseJSON(res);
            if (result.status == "201") {
                setTimeout(() => {
                    location.reload();
                    alert("Xóa thành công")
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-employees';

                }, 1000)
            }
            if (result.status == "400") {
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    location.reload();
                     alert("Xóa không thành công")
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-employees';
                }, 1000)
            }
        });
    }
})

//Phòng ban

jQuery("#ems_department").validate({ // sau khi cái form ems_form_data validate thành công thì thực hiện submit
    submitHandler : function() {

        var postData = "action=adddepartment&param=save&"+jQuery("#ems_department").serialize(); //tạo ra một câu truy vấn được mã hóa serialize để gửi lên server
        // console.log('jq',jQuery("#ems_form_data").serialize());

        jQuery.post(ajaxurl.baseURL, postData, function(res) {
            var result = jQuery.parseJSON(res);
            if(result.status == "200") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-departments';

                }, 3000)
            }
            if(result.status == "400") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-departments';

                }, 3000)
            }
        });
    }
});

//Edit Phòng ban

jQuery("#ems_edit_department").validate({
    submitHandler: function () {
        var editData = "action=editdepartment&param=update&" + jQuery("#ems_edit_department").serialize();
        console.log(editData);

        jQuery.post(ajaxurl.baseURL, editData, function (res) {
            var result = jQuery.parseJSON(res);
            if (result.status == "201") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-departments';

                }, 3000)

            }
            if (result.status == "400") {
                jQuery("#alert_danger").show();
                jQuery("#alert_danger").text(result.message);
                // Ẩn thông báo sau 3s
                setTimeout(() => {
                    jQuery("#alert_danger").hide();
                    window.location.href = 'http://localhost/ManagePlugin/wp-admin/admin.php?page=all-departments';

                }, 3000)
            }
        });
       
    }
});


//Send Request delete to server
//Xóa phòng ban
jQuery(document).on("click", ".remove-department", function () {
    var isDelete = confirm("Are you want to sure delete this department");
    if (isDelete) {
        var dataID = jQuery(this).attr('data-id');
        console.log(dataID);
        var data = "action=deletedepartment&id=" + dataID;


        jQuery.post(ajaxurl.baseURL, data, function (res) {
            var result = jQuery.parseJSON(res);
            if (result.status == "200") {
                setTimeout(() => {
                    location.reload();
                }, 3000)
            }
        });
    }
})